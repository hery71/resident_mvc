<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';

class MealModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }
    public function get_Meals()
    {
        $stmt = $this->pdo->query("
            SELECT id, meal 
            FROM meal_tbl 
            WHERE enabled = 1 
            ORDER BY meal ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getMealAllergens($meal)
    {
        $stmt = $this->pdo->prepare("SELECT allergene FROM meal_tbl WHERE meal = :meal");
        $stmt->execute(['meal' => $meal]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function getMealIntolerances($meal)
    {
        $stmt = $this->pdo->prepare("SELECT intolerance FROM meal_tbl WHERE meal = :meal");
        $stmt->execute(['meal' => $meal]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function deleteMeal($id)
    {
        $stmt = $this->pdo->prepare("UPDATE meal_tbl SET enabled = 0 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
    public function syncMealsFromMenus()
    {
        $tables = [
            'menu_breakfast',
            'menu_lunch',
            'menu_lunch_dessert',
            'menu_dinner',
            'menu_dinner_dessert'
        ];

        $added = 0;

        foreach ($tables as $table) {

            $stmt = $this->pdo->query("SELECT meal FROM $table");
            $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($rows as $meal) {

                $clean = $this->normalizeMeal($meal);

                if (!$clean) continue;

                // vérifier existence
                $check = $this->pdo->prepare("
                    SELECT COUNT(*) 
                    FROM meal_tbl 
                    WHERE LOWER(TRIM(meal)) = ?
                ");
                $check->execute([$clean]);

                if ($check->fetchColumn() == 0) {

                    $insert = $this->pdo->prepare("
                        INSERT INTO meal_tbl (meal, enabled) 
                        VALUES (?,1)
                    ");
                    $insert->execute([$meal]);

                    $added++;
                }
            }
        }

        return $added;
    }
    private function normalizeMeal($meal)
    {
        if (!$meal) return null;

        $meal = trim($meal);

        // enlever doubles espaces
        $meal = preg_replace('/\s+/', ' ', $meal);

        // minuscule pour comparaison
        return strtolower($meal);
    }

}
