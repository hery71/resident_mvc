<?php

class MealController
{

public function mealManager()
    {
        $model = new MealModel();
        $meals = $model->get_Meals();

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

}