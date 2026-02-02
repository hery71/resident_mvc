<?php

require_once __DIR__ . '/../models/MenuUniqueModel.php';

class MenuUniqueController
{
    public function index()
    {
        global $pdo;
        $page_css = 'index_menuUnique.css';
        $model = new MenuUniqueModel($pdo);
        $annee = $_GET['annee'] ?? date("Y");
        //recuperation des années existantes
        $years = $model->getAvailableYears();
        // Récupération menus uniques
        $menus = $model->getByYear($annee);
        //vue
        require __DIR__ . '/../views/alimentaire/menuUnique/index.php';
    }
    public function edit()
    {
        global $pdo;

        date_default_timezone_set('America/Moncton');

        $model = new MenuUniqueModel($pdo);

        // Date courante / forcée
        $currentDate = date('Y-m-d');
        $forcedDate = null;

        if (isset($_GET['date'])) {
            $d = DateTime::createFromFormat('Y-m-d', $_GET['date']);
            if ($d) $forcedDate = $_GET['date'];
        }

        //Chargement menu unique
        $id_unique = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $menu_unique = $id_unique ? $model->getById($id_unique) : null;
        $id_unique = $menu_unique ? $menu_unique['id'] : null;

        //Création menu unique
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
            {
                if(isset($_POST['save_menu'])) {
                    $id = $model->create(
                        trim($_POST['nom']),
                        $_POST['date'],
                        trim($_POST['observation'])
                    );
                    header("Location: /menuUnique/edit?id=".$id);
                    exit;
                }
                if(isset($_POST['update_menu'])) {
                        $model->update(
                        $id_unique,
                        trim($_POST['nom']),
                        $_POST['date'],
                        trim($_POST['observation'])
                    );
                    header("Location: /menuUnique/edit?id=".$id_unique);
                    exit;
                }
            }

        //Update + insert plats
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_meals'])) {
            $tables = ['breakfast','lunch','lunch_dessert','dinner','dinner_dessert'];

            foreach ($tables as $table) {
                if (!empty($_POST["{$table}_id"])) {
                    foreach ($_POST["{$table}_id"] as $i => $idMeal) {
                        $meal = trim($_POST["{$table}_meal"][$i]);
                        if ($meal !== '') {
                            $model->updateMeal($table, (int)$idMeal, $meal);
                        }
                    }
                }

                if (!empty($_POST[$table])) {
                    foreach ($_POST[$table] as $meal) {
                        $meal = trim($meal);
                        if ($meal !== '') {
                            $model->insertMeal($table, $id_unique, $meal);
                        }
                    }
                }
            }
            $message = "Plats du menu unique enregistrés avec succès.";
        }

        // 6️⃣ Récupération plats
        $existingMeals = $id_unique ? $model->getMeals($id_unique) : [];

        require __DIR__ . '/../views/alimentaire/menuUnique/edit.php';
    }
// app/controllers/MenuUniqueController.php

public function ajaxImportMenuRegular()
    {
        global $pdo;

        $id_unique = (int)($_GET['id_unique'] ?? 0);
        if (!$id_unique){
            echo 'ID de menu unique invalide.';
            return;
        }
        
        // 1️⃣ Date menu unique
        $model = new MenuUniqueModel($pdo);
        $uniqueDate = $model->getDateById($id_unique);

        // 2️⃣ Calcul cycle (INCHANGÉ)
        $target = new DateTime($uniqueDate);
        $day    = $target->format('l');
        $year   = (int)$target->format('Y');

        // 3️⃣ Menu régulier (INCHANGÉ)
        $id_menu =  $model->getIdfromMenu($day, $year, $uniqueDate);
        if (!$id_menu){
            echo 'Aucun menu régulier trouvé pour cette date.';
            return;
        }

        // 4️⃣ Récupération meals
        $labels = [
            'breakfast'=>'🥐 Petit-déjeuner',
            'lunch'=>'🍽️ Dîner',
            'lunch_dessert'=>'🍰 Dessert dîner',
            'dinner'=>'🌙 Souper',
            'dinner_dessert'=>'🍮 Dessert souper'
        ];

        $mealsByTable = [];

        foreach ($labels as $table => $label) {
            
            $meals = $model->getMealByMenuId($id_menu, $table);

            if ($meals) {
                $mealsByTable[$table] = [
                    'label' => $label,
                    'meals' => $meals
                ];
            }
        }

        // 5️⃣ Rendu AJAX (HTML partiel)
        require APP_PATH . '/views/alimentaire/menuUnique/_import_regular_meals.php';
    }
public function importMenuUnique()
    {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['import_confirm'])) {
            http_response_code(400);
            exit;
        }

        $id_unique = (int)($_POST['id_unique'] ?? 0);
        if (!$id_unique) {
            http_response_code(400);
            exit;
        }

        $tables = ['breakfast','lunch','lunch_dessert','dinner','dinner_dessert'];

        foreach ($tables as $table) {
            if (empty($_POST[$table])) continue;

            foreach ($_POST[$table] as $meal) {
                $meal = trim($meal);
                if ($meal === '') continue;

                $stmt = $pdo->prepare("
                    INSERT INTO `$table` (meal, ids, enabled)
                    VALUES (?, ?, 1)
                ");
                $stmt->execute([$meal, $id_unique]);
            }
        }

        echo 'OK';
    }
public function importMeals()
    {
        global $pdo;
        

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['import_confirm'])) {
            http_response_code(400);
            exit;
        }

        $id_unique = (int)($_POST['id_unique'] ?? 0);
        if (!$id_unique) {
            http_response_code(400);
            exit;
        }

        $tables = ['breakfast','lunch','lunch_dessert','dinner','dinner_dessert'];

        foreach ($tables as $table) {
            if (empty($_POST[$table])) continue;

            foreach ($_POST[$table] as $meal) {
                $meal = trim($meal);
                if ($meal === '') continue;
                $model = new MenuUniqueModel($pdo);
                $model->insertMeals($id_unique, $table, $meal);
            }
        }

        echo 'OK';
    }
public function deleteMeal()
    {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['delete'], $_GET['table'], $_GET['idUnique'])) {
            http_response_code(400);
            exit;
        }

        $table = preg_replace('/[^a-z_]/', '', $_GET['table']);
        $idMeal = (int)$_GET['delete'];
        $model = new MenuUniqueModel($pdo);
        $model->deleteMeal($table, $idMeal);

        header("Location: /menuUnique/edit?id=".(int)$_GET['idUnique']);
        exit;
    }   


}
