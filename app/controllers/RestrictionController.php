<?php

class RestrictionController
{


public function index()
    {
        /***************************************************
         * TABLES DISPONIBLES
         ***************************************************/
        $xtable="meal_tbl";
            $model = new RestrictionModel();
            $restrictions= $model->getRestrictions($xtable);
            $data[$xtable] = [
                'label' => "Meal",
                'restrictions' => $restrictions
            ];
        

    $page_css = 'edit_restriction.css';
        require __DIR__ . '/../views/alimentaire/restriction/index.php';
    }
public function edit()
    {
        $page_css = 'edit_restriction.css';
        $mealId = $_GET['id'] ?? 0;
        $selectedMeal = null;
        $checkedAllergens = [];
        $checkedIntolerances = [];
        //POST-----------------------------------------
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
        //Traitement du POST
            $table= 'meal_tbl';
            $mealId = (int)($_POST['meal_id'] ?? 0);
            $allergenes = $_POST['allergen'] ?? '';
            $intolerances = $_POST['intolerance'] ?? '';
            //$allergeneStr = implode(',', $allergenes ??[]);
            //$intoleranceStr = implode(',', $intolerances ??[]);
            $model = new RestrictionModel();
            $success = $model->saveRestrictions($table, $mealId, $allergenes, $intolerances);
            if ($success) {
                header("Location: /restriction/edit?table=$table&id=$mealId&success=1");
                //$message =  $table . '#' . $mealId . '#' . $allergeneStr . '#' . $intoleranceStr;
                //header("Location: /test/index?message=" . urlencode($message));
                exit();
            } else {
                $error = "Une erreur est survenue lors de l'enregistrement des restrictions.";
            }
        }
        //GET-----------------------------------------
        $table='meal_tbl';
        $file = dirname(__DIR__, 2) . '/storage/data/intolerances.json';
        $json = json_decode(file_get_contents($file), true);

        $intoleranceCategories = array_keys(
            $json['Intolerances_Alimentaires_Canada'] ?? []
        );
        $model = new AllergieModel();
        $allergenList = $model->all();
        $model2 = new IntoleranceModel();
        $intoleranceList = $model2->all();
        $model = new RestrictionModel();
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