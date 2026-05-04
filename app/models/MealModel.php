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
            SELECT * 
            FROM meal_tbl 
            WHERE enabled = 1 
            ORDER BY meal ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getMealAllergens2($meal)
    {
        $stmt = $this->pdo->prepare("SELECT allergene FROM meal_tbl WHERE meal = :meal");
        $stmt->execute(['meal' => $meal]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function getMealAllergens($meal)
    {
        $stmt = $this->pdo->prepare("
            SELECT allergene 
            FROM meal_tbl 
            WHERE meal = :meal
        ");
        $stmt->execute(['meal' => $meal]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || empty($row['allergene'])) {
            return [];
        }

        return array_map('trim', explode(',', $row['allergene']));
    }
    public function getMealIntolerances2($meal)
    {
        $stmt = $this->pdo->prepare("SELECT intolerance FROM meal_tbl WHERE meal = :meal");
        $stmt->execute(['meal' => $meal]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function getMealIntolerances($meal)
    {
        $stmt = $this->pdo->prepare("
            SELECT intolerance 
            FROM meal_tbl 
            WHERE meal = :meal
        ");
        $stmt->execute(['meal' => $meal]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || empty($row['intolerance'])) {
            return [];
        }

        return array_map('trim', explode(',', $row['intolerance']));
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
    public function updateAllergens($meal, $allergene)
    {
        $stmt = $this->pdo->prepare("
            UPDATE meal_tbl 
            SET allergene = :allergene
            WHERE meal = :meal
        ");

        $stmt->execute([
            'meal' => $meal,
            'allergene' => $allergene
        ]);
    }
    public function updateIntolerances($meal, $intolerance)
    {
        $stmt = $this->pdo->prepare("
            UPDATE meal_tbl 
            SET intolerance = :intolerance  
            WHERE meal = :meal
        ");

        $stmt->execute([
            'meal' => $meal,
            'intolerance' => $intolerance
        ]);
    }
public function ensureMealExists($meal)
    {
        $meal = trim($meal);

        if ($meal === '') return;

        $stmt = $this->pdo->prepare("
            SELECT id FROM meal_tbl 
            WHERE LOWER(meal) = LOWER(?)
        ");
        $stmt->execute([$meal]);

        if (!$stmt->fetch()) {
            $insert = $this->pdo->prepare("
                INSERT INTO meal_tbl (meal, enabled)
                VALUES (?, 1)
            ");
            $insert->execute([$meal]);
        }
    }
public function normalizeMealName(string $meal): string
    {
        $meal = trim($meal);

        // enlever contenu entre () ou {}
        $meal = preg_replace('/[\(\{].*?[\)\}]/', '', $meal);

        // gérer "or"
        if (stripos($meal, ' or ') !== false) {
            $parts = explode(' or ', $meal);
            $meal = trim($parts[0]);
        }

        // nettoyer double espaces
        $meal = preg_replace('/\s+/', ' ', $meal);

        return trim($meal);
    }
public function getMealsByNames(array $names): array
    {
        if (empty($names)) return [];

        $normalized = array_map(function ($n) {
            return mb_strtolower(trim($n));
        }, $names);

        $placeholders = implode(',', array_fill(0, count($normalized), '?'));

        $sql = "
            SELECT id, meal, ingredients, allergene, intolerance
            FROM meal_tbl
            WHERE LOWER(meal) IN ($placeholders)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($normalized);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = [];
        foreach ($rows as $r) {
            $key = mb_strtolower(trim($r['meal']));
            $map[$key] = $r;
        }

        $ordered = [];
        foreach ($normalized as $n) {
            if (isset($map[$n])) {
                $ordered[] = $map[$n];
            }
        }

        return $ordered;
    }

}
