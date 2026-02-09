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
        require __DIR__ . '/../views/alimentaire/preparation/edit.php';
    }   
    public function save()
    {
       if (!isset($_POST['date'], $_POST['plat'], $_POST['ingredient'], $_POST['nb'], $_POST['action'], $_POST['unite'], $_POST['jour'])) 
        {
            die("Erreur : données manquantes.");
        }
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
        $model->save_preparation([
            'date' => $date,
            'plat' => $plat,
            'ingredient' => $ingredient,
            'nb' => $nb,
            'unite' => $unite,
            'action' => $action,
            'jour' => $jour,
            'enabled' => $enabled
        ]);
        // Redirection après succès
        header("Location: /preparation/edit?date=" . urlencode($date) . "&success=1");
    }   
    public function load()
    {
        global $pdo;

        if (!isset($_GET['date'], $_GET['plat'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing parameters']);
            return;
        }

        $date = $_GET['date'];
        $plat = $_GET['plat'];

        $model = new PreparationModel($pdo);
        $data = $model->getByDateAndPlat($date, $plat);

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function delete( )
    {
       $id = $_GET['id'] ?? '0';
       $model = new PreparationModel();
       $model->delete_preparation($id);
    }
}
