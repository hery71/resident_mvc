<?php

class MealController
{
    public function allergenList()
    {
        $allergenList = [];
        $meal = $_GET['meal'] ?? null;
        if (!$meal) {
            $model = new MealModel();
            $allergenList = $model->getMealAllergens($meal);
        }
        echo json_encode($allergenList);
    }

public function mealManager()
    {
        $file = dirname(__DIR__, 2) . '/storage/data/intolerances.json';
        $json = json_decode(file_get_contents($file), true);

        $intoleranceCategories = array_keys(
            $json['Intolerances_Alimentaires_Canada'] ?? []
        );
        $model = new MealModel();
        $meals = $model->get_Meals();
        $model1 = new AllergieModel();
        $allergenList = $model1->all();
        $model2 = new IntoleranceModel();
        $intoleranceList = $model2->all();
        require __DIR__ . '/../views/alimentaire/meal/mealManager.php';
    }
public function deleteMeal()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $model = new MealModel();
                $model->deleteMeal($id);
                echo json_encode(['success' => true]);
                return;
            }
        }
        echo json_encode(['success' => false]);
    }
public function syncMeals()
    {
        $model = new MealModel();
        $count = $model->syncMealsFromMenus();

        echo json_encode([
            'success' => true,
            'message' => $count . ' meal(s) ajoutés'
        ]);
    }
public function checkAllergen()
    {
        $meal = $_GET['meal'] ?? null;
        $model = new MealModel();
        $allergens = $model->getMealAllergens($meal);
        echo json_encode($allergens);       
    }
public function checkIntolerance()
    {
        $meal = $_GET['meal'] ?? null;
        $model = new MealModel();
        $intolerances = $model->getMealIntolerances($meal);
        echo json_encode($intolerances);       
    }
public function saveAllergens()
    {
        $meal = $_POST['meal'] ?? '';
        $allergene = $_POST['allergene'] ?? '';

        $model = new MealModel();
        $model->updateAllergens($meal, $allergene);

        echo json_encode(['success' => true]);
    }
public function saveIntolerances()
    {
        $meal = $_POST['meal'] ?? '';
        $intolerance = $_POST['intolerance'] ?? '';

        $model = new MealModel();
        $model->updateIntolerances($meal, $intolerance);

        echo json_encode(['success' => true]);
    }

}