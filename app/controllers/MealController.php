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
public function dayMealManagement()
    {
        global $pdo;

        date_default_timezone_set('America/Moncton');

        $xdate = $_GET['date'] ?? date('Y-m-d');

        $target = new DateTime($xdate);
        $day    = $target->format('l');

        $cycle = MenuCycle::getSeasonAndWeek($xdate);
        $cycleYear = $cycle['year'];

        $menuModel = new MenuModel($pdo);
        $mealModel = new MealModel();

        $menu = null;
        $id_unique = null;
        $saison = $cycle['season'];
        $week = $cycle['week'];

        $uniqueMenu = $menuModel->getUniqueMenuForDate($xdate);

        if ($uniqueMenu) {
            $menu = $uniqueMenu;
            $id_unique = $uniqueMenu['id'];
            $week = null;
        } else {
            if ($week !== null) {
                $menu = $menuModel->getBaseMenu(
                    $saison,
                    $week,
                    $day,
                    $cycleYear
                );
            }
        }

        $mealNames = [];

        if (!empty($menu)) {
            foreach (['breakfast', 'lunch', 'lunch_dessert', 'dinner', 'dinner_dessert'] as $service) {
                if (!empty($menu[$service])) {
                    foreach (explode(',', $menu[$service]) as $item) {
                        $mealName = trim($item);

                        if ($mealName !== '') {
                            $mealNames[] = $mealName;
                        }
                    }
                }
            }
        }

        $mealNames = array_values(array_unique($mealNames));

        foreach ($mealNames as $mealName) {
            $mealModel->ensureMealExists($mealName);
        }

        $meals = $mealModel->getMealsByNames($mealNames);

        $file = dirname(__DIR__, 2) . '/storage/data/intolerances.json';
        $json = json_decode(file_get_contents($file), true);

        $intoleranceCategories = array_keys(
            $json['Intolerances_Alimentaires_Canada'] ?? []
        );

        $model1 = new AllergieModel();
        $allergenList = $model1->all();

        $model2 = new IntoleranceModel();
        $intoleranceList = $model2->all();

        require __DIR__ . '/../views/alimentaire/meal/dayMealManagement.php';
    }
}