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
        $table= $_GET['table'] ?? 'list_lunch';
        $listTables = [
            'list_breakfast' => 'Breakfast',
            'list_lunch' => 'Lunch',
            'list_lunch_dessert' => 'Lunch Dessert',
            'list_dinner' => 'Dinner',
            'list_dinner_dessert' => 'Dinner Dessert'
        ];
        
        //$page_css = 'alimentaire.css';
        $model = new RestrictionModel($pdo);
        $meals = $model->getAllMeals($table);
        require __DIR__ . '/../views/alimentaire/restriction/edit.php';
    }

}