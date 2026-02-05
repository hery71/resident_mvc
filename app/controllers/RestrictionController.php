<?php

class RestrictionController
{


public function index()
    {
        global $pdo;
        /***************************************************
         * TABLES DISPONIBLES
         ***************************************************/
        $listTables = [
            'list_breakfast' => 'Breakfast',
            'list_lunch' => 'Lunch',
            'list_lunch_dessert' => 'Lunch Dessert',
            'list_dinner' => 'Dinner',
            'list_dinner_dessert' => 'Dinner Dessert'
        ];
        foreach ($listTables as $xtable => $label) {
            $model = new RestrictionModel($pdo);
            $restrictions= $model->getRestrictions($xtable);
            $data[$xtable] = [
                'label' => $label,
                'restrictions' => $restrictions
            ];
        }
        

    $page_css = 'edit_restriction.css';
        require __DIR__ . '/../views/alimentaire/restriction/index.php';
    }
public function edit()
    {
        global $pdo;
        $page_css = 'edit_restriction.css';
        $mealId = $_GET['id'] ?? 0;
        $selectedMeal = null;
        $checkedAllergens = [];
        $checkedIntolerances = [];
        //POST-----------------------------------------
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {    



        }
        //GET-----------------------------------------
        $table= $_GET['table'] ?? 'list_lunch';
        $listTables = [
            'list_breakfast' => 'Breakfast',
            'list_lunch' => 'Lunch',
            'list_lunch_dessert' => 'Lunch Dessert',
            'list_dinner' => 'Dinner',
            'list_dinner_dessert' => 'Dinner Dessert'
        ];
        $model = new AllergieModel($pdo);
        $allergenList = $model->all();
        $model2 = new IntoleranceModel($pdo);
        $intoleranceList = $model2->all();
        $model = new RestrictionModel($pdo);
        if ($mealId) {
            $selectedMeal = $model->getRestrictionByMealId($table, (int)$mealId);
            if ($selectedMeal) {
                $checkedAllergens = array_filter(array_map('trim', explode(',', $selectedMeal['allergene']??'')));
                $checkedIntolerances = array_filter(array_map('trim', explode(',', $selectedMeal['intolerance']??'')));
            }
        }
        
        $meals = $model->getAllMeals($table);


        require __DIR__ . '/../views/alimentaire/restriction/edit.php';
    }

}