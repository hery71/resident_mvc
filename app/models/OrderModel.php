<?php

class OrderModel
{
    private PDO $pdo;
    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }
    public function getPreviousSunday(string $date): string
    {
        $d = new DateTime($date);

        if ($d->format('w') != 0) {
            $d->modify('last sunday');
        }

        return $d->format('Y-m-d');
    }
    public function getIngredientsByMealNames(array $mealNames): array
    {
        if (empty($mealNames)) return [];
        $mealNames = array_values(array_unique(array_filter(array_map('trim', $mealNames))));
        if (empty($mealNames)) return [];
        $placeholders = implode(',', array_fill(0, count($mealNames), '?'));
        $stmt = $this->pdo->prepare("
            SELECT meal, ingredients
            FROM meal_tbl
            WHERE meal IN ($placeholders)
            AND enabled = 1
        ");
        $stmt->execute($mealNames);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getMealWithoutIngredients(array $mealNames): array
    {
        if (empty($mealNames)) return [];

        $mealNames = array_values(array_unique(array_filter(array_map('trim', $mealNames))));

        if (empty($mealNames)) return [];

        $placeholders = implode(',', array_fill(0, count($mealNames), '?'));

        $stmt = $this->pdo->prepare("
            SELECT meal
            FROM meal_tbl
            WHERE meal IN ($placeholders)
            AND enabled = 1
            AND (
                    ingredients IS NULL
                    OR TRIM(ingredients) = ''
                )
            ORDER BY meal ASC
        ");

        $stmt->execute($mealNames);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function buildWeeklyOrderList(array $menus): array
    {
        $groups = [
            'breakfast' => [],
            'lunch' => [],
            'dinner' => []
        ];

        $allMeals = [];

        $serviceMap = [
            'breakfast' => ['breakfast'],
            'lunch' => ['lunch', 'lunch_dessert'],
            'dinner' => ['dinner', 'dinner_dessert']
        ];

        foreach ($menus as $menu) {
            if (empty($menu)) {
                continue;
            }

            foreach ($serviceMap as $groupName => $services) {
                foreach ($services as $service) {
                    if (empty($menu[$service])) {
                        continue;
                    }

                    $meals = array_map('trim', explode(',', $menu[$service]));

                    foreach ($meals as $meal) {
                        if ($meal !== '') {
                            $groups[$groupName][] = $meal;
                            $allMeals[] = $meal;
                        }
                    }
                }
            }
        }

        $allMeals = array_values(array_unique($allMeals));

        $mealModel = new MealModel();

        foreach ($allMeals as $meal) {
            $mealModel->ensureMealExists($meal);
        }

        $mealsWithoutIngredients = $this->getMealWithoutIngredients($allMeals);

        $result = [];

        foreach ($groups as $groupName => $mealNames) {
            $rows = $this->getIngredientsByMealNames($mealNames);
            $ingredientsCount = [];

            foreach ($rows as $row) {
                if (empty(trim($row['ingredients'] ?? ''))) {
                    continue;
                }

                $ingredients = array_map('trim', explode(',', $row['ingredients']));

                foreach ($ingredients as $ingredient) {
                    if ($ingredient === '') {
                        continue;
                    }

                    if (!isset($ingredientsCount[$ingredient])) {
                        $ingredientsCount[$ingredient] = 0;
                    }

                    $ingredientsCount[$ingredient]++;
                }
            }

            ksort($ingredientsCount);

            $result[$groupName] = $ingredientsCount;
        }

        $result['mealsWithoutIngredients'] = $mealsWithoutIngredients;

        return $result;
    }
    
}