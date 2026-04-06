<?php
require_once __DIR__ . '/../models/MenuCycle.php';
class PreparationController
{
    public function edit()
    {
        $xdate = $_GET['date'] ?? date("Y-m-d");
        //-------------------Cycles
        $cycle = MenuCycle::getSeasonAndWeek($xdate);
        $saison = $cycle['season'];
        $week = $cycle['week'];
        $anne = (int)date("Y", strtotime($xdate));
        $model = new PreparationModel();
        $specialMenu = $model->get_special_menu_for_date($xdate);
        if ($specialMenu) {
            $menu = $specialMenu;   
        } else {
            $menu = $model->get_menu($anne, $saison, $week, date("l", strtotime($xdate)));
        }
        $prepRows = $model->get_preparation_for_date($xdate);
        $ingredients = $model->get_ingredients();
        $actions = $model->get_actions();
        $unites = $model->get_unites();
        $meals = $model->getAllMealsWithIngredients();
        require __DIR__ . '/../views/alimentaire/preparation/edit.php';
    }   
    public function save()
    {
       if (!isset($_POST['date'], $_POST['plat'], $_POST['ingredient'], $_POST['nb'], $_POST['action'], $_POST['unite'], $_POST['jour'])) 
        {
            die("Erreur : données manquantes.");
        }
        //************************************************************* */
        
        //************************************************************* */
        // Nettoyage / récupération
        $date       = trim($_POST['date']);        // date du menu
        $plat       = trim($_POST['plat']);        // plat sélectionné
        $ingredient = trim($_POST['ingredient']);  // ingrédient choisi
        $nb         = trim($_POST['nb']);          // quantité
        $unite      = trim($_POST['unite']);       // unite
        $action     = trim($_POST['action']);      // action (Defrost, Cook…)
        $jour       = trim($_POST['jour']);        // nb de jours avant
        $enabled    = 1;
        $model = new PreparationModel();
        $model->addIngredientToMeal($plat, $ingredient);
        $model->save_preparation([
            'date' => $date,
            'plat' => $plat,
            'ingredient' => $ingredient,
            'nb' => $nb,
            'unite' => $unite,
            'action' => $action,
            'jour' => $jour,
            'enabled' => $enabled,
            'preparation_date' => (new DateTime($date))->modify('-' . intval($jour) . ' days')->format('Y-m-d')
        ]);
        //Pas de header location car on veut rester sur la même page pour ajouter plusieurs préparations
        echo json_encode(['success' => true]);
        exit;
    }   
    public function load()
    {
        if (!isset($_GET['date'], $_GET['plat'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $date = $_GET['date'];
        $plat = $_GET['plat'];

        $model = new PreparationModel();
        $data = $model->getByDateAndPlat($date, $plat);

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function checkByPlat()
    {
        $plat = trim($_GET['plat'] ?? '');
        if ($plat === '') {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Missing plat']);
            return;
        }

        $model = new PreparationModel();
        $count = $model->countByPlat($plat);

        header('Content-Type: application/json');
        echo json_encode(['count' => $count]);
    }

    public function loadByPlat()
    {
        $plat = trim($_GET['plat'] ?? '');
        if ($plat === '') {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Missing plat']);
            return;
        }

        $model = new PreparationModel();
        $data = $model->getByPlat($plat);

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function applyExisting()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $date = trim($_POST['date'] ?? '');
        $plat = trim($_POST['plat'] ?? '');
        $ids = $_POST['ids'] ?? [];

        if ($date === '' || $plat === '' || !is_array($ids)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid payload']);
            return;
        }

        $model = new PreparationModel();
        $inserted = $model->applyPreparationsByIds($date, $plat, $ids);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'inserted' => $inserted]);
    }
    public function delete( )
    {
       $id = $_GET['id'] ?? '0';
       $model = new PreparationModel();
       $model->delete_preparation($id);
    }
    public function hebdomadaire()
    {
        $xdate = $_GET['date'] ?? date("Y-m-d");
        $dayIndex = (new DateTime($xdate))->format('N');
        if ($dayIndex != 7) {
        $startOfWeek = (new DateTime($xdate))->modify('+' . (0 - $dayIndex) . ' days');
        $endOfWeek = (new DateTime($xdate))->modify('+' . (6 - $dayIndex) . ' days');
        } else {
        $startOfWeek = (new DateTime($xdate));
        $endOfWeek = (new DateTime($xdate))->modify('+6 days');
        }
        $model = new PreparationModel();
        $weekData = [];
        $weekData = $model->getWeeklyPreparation($startOfWeek, $endOfWeek);
        require __DIR__ . '/../views/alimentaire/preparation/hebdomadaire.php';
    }
    public function printHebdomadaire()
    {
        $xdate = $_GET['date'] ?? date("Y-m-d");
        $dayIndex = (new DateTime($xdate))->format('N');
        if ($dayIndex != 7) {
        $startOfWeek = (new DateTime($xdate))->modify('+' . (0 - $dayIndex) . ' days');
        $endOfWeek = (new DateTime($xdate))->modify('+' . (6 - $dayIndex) . ' days');
        } else {
        $startOfWeek = (new DateTime($xdate));
        $endOfWeek = (new DateTime($xdate))->modify('+6 days');
        }
        $model = new PreparationModel();
        $weekData = [];
        $weekData = $model->getWeeklyPreparation($startOfWeek, $endOfWeek);
        require __DIR__ . '/../views/alimentaire/preparation/printHebdomadaire.php';
    }
    public function loadMealIngredients()
    {
        $plat = trim($_GET['plat'] ?? '');
        if ($plat === '') {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Missing plat']);
            return;
        }

        $model = new PreparationModel();
        $ingredients = $model->getMealIngredientsByPlat($plat);

        header('Content-Type: application/json');
        echo json_encode($ingredients);
    }
    public function addMealIngredient2()
    {
        var_dump($_POST);
        exit();
        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'test' => $_POST
        ]);
        exit;
    }
    public function addMealIngredient()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $plat = trim($_POST['plat'] ?? '');
        $ingredient = trim($_POST['ingredient'] ?? '');

        if ($plat === '' || $ingredient === '') {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Données manquantes']);
            return;
        }

        $model = new PreparationModel();
        $ok = $model->addIngredientToMeal($plat, $ingredient);

        header('Content-Type: application/json');
        echo json_encode(['success' => $ok]);
    }
    public function removeMealIngredient()
    {
        $plat = trim($_POST['plat'] ?? '');
        $ingredient = trim($_POST['ingredient'] ?? '');

        if ($plat === '' || $ingredient === '') {
            echo json_encode(['success'=>false]);
            return;
        }

        $model = new PreparationModel();
        $ok = $model->removeIngredientFromMeal($plat, $ingredient);

        echo json_encode(['success'=>$ok]);
    }
    public function suggestIngredient()
    {
        $term = trim($_GET['term'] ?? '');

        $model = new PreparationModel();
        $ingredients = $model->get_ingredients();

        $results = [];

        foreach ($ingredients as $ingredient) {

            if ($term === '') {
                $results[] = $ingredient;
                continue;
            }

            $cleanIngredient = $this->normalize($ingredient);
            $cleanTerm = $this->normalize($term);

            if (strpos($cleanIngredient, $cleanTerm) !== false) {
                $results[] = $ingredient;
            }
        }

        // 🔹 tri alphabetique
        usort($results, function ($a, $b) {
            return strcasecmp(
                iconv('UTF-8','ASCII//TRANSLIT',$a),
                iconv('UTF-8','ASCII//TRANSLIT',$b)
            );
        });

        header('Content-Type: application/json');
        echo json_encode(array_slice($results,0,20));
    }
    private function normalize(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');

        // enlever les accents
        $text = Normalizer::normalize($text, Normalizer::FORM_D);
        $text = preg_replace('/\p{Mn}/u', '', $text);

        // enlever apostrophes et espaces
        $text = str_replace(["'", "’", "-", " "], "", $text);

        return $text;
    }
    public function addIngredientDictionary()
    {
        $ingredient = trim($_POST['ingredient'] ?? '');

        if ($ingredient == "") {
            echo json_encode(['success'=>false]);
            return;
        }

        $model = new PreparationModel();

        $res = $model->addIngredientDictionary($ingredient);

        echo json_encode($res);
    }
    public function getIngredients()
    {
        $model = new PreparationModel();

        header('Content-Type: application/json');
        echo json_encode($model->get_ingredients());
    }
    public function mealAddIngredient()
    {
        $model = new PreparationModel();

        $meals = $model->getMealsWithoutIngredients();
        $ingredients = $model->get_Ingredients();

        require __DIR__ . '/../views/alimentaire/preparation/mealAddIngredient.php';
    }
    public function editMeal()
    {
        $id = (int)($_GET['id'] ?? 0);

        if (!$id) {
            echo "ID invalide";
            return;
        }

        $model = new PreparationModel();

        $meal = $model->getMealById($id);

        require __DIR__ . '/../views/alimentaire/preparation/editMeal.php';
    }
}
