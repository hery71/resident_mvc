<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';

class ParametresModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }
    public function getCompanyInfo()
    {
        $stmt = $this->pdo->query("SELECT * FROM organisation where id=1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function exportMenus(array $postData, string $saison, string $annee): void
    {
        $pdo = $this->pdo;

        $meals = [
            'breakfast',
            'lunch',
            'lunch_dessert',
            'dinner',
            'dinner_dessert'
        ];

        $importTime = date('Y-m-d H:i:s');

        $pdo->beginTransaction();

        try {

            // ============================
            // 1️⃣ Reconstruire data depuis textareas
            // ============================

            $data = [];

            for ($w = 1; $w <= 3; $w++) {

                foreach ($meals as $meal) {

                    $field = "week{$w}_{$meal}";
                    $text = trim($postData[$field] ?? '');

                    if ($text === '') continue;

                    $lines = explode("\n", $text);

                    foreach ($lines as $line) {

                        $cols = explode(';', trim($line));

                        for ($d = 0; $d < 7; $d++) {
                            if (!empty($cols[$d])) {
                                $data[$w][$d + 1][$meal][] = trim($cols[$d]);
                            }
                        }
                    }
                }
            }

            // ============================
            // 2️⃣ Insert menu_tbl
            // ============================

            $stmtMenu = $pdo->prepare("
                INSERT INTO menu_tbl
                (week, annee, saison, day, breakfast, lunch, lunch_dessert, dinner, dinner_dessert, enabled, date1)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)
            ");

            $dayNames = [
                1=>'Sunday',2=>'Monday',3=>'Tuesday',
                4=>'Wednesday',5=>'Thursday',
                6=>'Friday',7=>'Saturday'
            ];

                foreach ($data as $week => $days) {
                    foreach ($days as $day => $mealsData) {

                        $stmtMenu->execute([
                            $week,
                            $annee,
                            $saison,
                            $dayNames[$day],
                            implode(', ', $mealsData['breakfast'] ?? []),
                            implode(', ', $mealsData['lunch'] ?? []),
                            implode(', ', $mealsData['lunch_dessert'] ?? []),
                            implode(', ', $mealsData['dinner'] ?? []),
                            implode(', ', $mealsData['dinner_dessert'] ?? []),
                            $importTime
                        ]);
                    }
                }

            // ============================
            // 3️⃣ Relire rows insérées
            // ============================

            $stmtSelect = $pdo->prepare("
                SELECT * FROM menu_tbl
                WHERE date1 = ?
            ");
            $stmtSelect->execute([$importTime]);

            $menus = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

            // ============================
            // 4️⃣ Explosion vers tables meals
            // ============================

            foreach ($menus as $menu) {

                $menuId = $menu['id'];

                foreach ($meals as $mealTable) {

                    $items = explode(',', $menu[$mealTable]);

                    foreach ($items as $item) {

                        $item = trim($item);

                        if ($item === '' || $item === null) continue;

                        $stmtMeal = $pdo->prepare("
                            INSERT INTO {$mealTable}
                            (meal, allergene, enabled, id_menu, intolerance, ids)
                            VALUES (?, '', 1, ?, '', 0)
                        ");

                        $stmtMeal->execute([
                            $item,
                            $menuId
                        ]);
                    }
                }
            }
            
            $pdo->commit();

        } catch (Exception $e) {

            $pdo->rollBack();
            throw $e;
        }
    }
    public function getSeasonMenus(string $annee, string $saison): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * 
            FROM menu_tbl
            WHERE annee LIKE ?
            AND saison = ?
            AND enabled = 1
            ORDER BY week,
            FIELD(day,'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')
        ");

        $stmt->execute(["%$annee%", $saison]);
        $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];

        foreach ($menus as $menu) {

            $week = $menu['week'];
            $day  = $menu['day'];
            $menuId = $menu['id'];

            $result[$week][$day] = [
                'breakfast'       => $this->getItems('breakfast', $menuId),
                'lunch'           => $this->getItems('lunch', $menuId),
                'lunch_dessert'   => $this->getItems('lunch_dessert', $menuId),
                'dinner'          => $this->getItems('dinner', $menuId),
                'dinner_dessert'  => $this->getItems('dinner_dessert', $menuId),
            ];
        }

        return $result;
    }
    private function getItems(string $table, int $menuId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT meal
            FROM {$table}
            WHERE id_menu = ?
            AND enabled = 1
            ORDER BY id
        ");

        $stmt->execute([$menuId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
public function exportSpecialMenus(array $postData, string $saison, string $annee): void
    {
        $pdo = $this->pdo;

        $meals = ['breakfast','lunch','lunch_dessert','dinner','dinner_dessert'];
        $importTime = date('Y-m-d H:i:s');

        $pdo->beginTransaction();

        try {

            // 1) reconstruire data (week 1 only)
            $data = [];

            foreach ($meals as $meal) {
                $field = "week1_{$meal}";
                $text = trim($postData[$field] ?? '');
                if ($text === '') continue;

                $lines = explode("\n", $text);
                foreach ($lines as $line) {
                    $cols = explode(';', trim($line));
                    for ($d = 0; $d < 7; $d++) {
                        if (!empty($cols[$d])) {
                            $data[1][$d + 1][$meal][] = trim($cols[$d]);
                        }
                    }
                }
            }

            // 2) insert menu_tbl (week=1)
            $stmtMenu = $pdo->prepare("
                INSERT INTO menu_tbl
                (week, annee, saison, day, breakfast, lunch, lunch_dessert, dinner, dinner_dessert, enabled, date1)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)
            ");

            $dayNames = [
                1=>'Sunday',2=>'Monday',3=>'Tuesday',
                4=>'Wednesday',5=>'Thursday',6=>'Friday',7=>'Saturday'
            ];

            foreach (($data[1] ?? []) as $day => $mealsData) {
                $stmtMenu->execute([
                    1,
                    $annee,
                    $saison,
                    $dayNames[$day],
                    implode(', ', $mealsData['breakfast'] ?? []),
                    implode(', ', $mealsData['lunch'] ?? []),
                    implode(', ', $mealsData['lunch_dessert'] ?? []),
                    implode(', ', $mealsData['dinner'] ?? []),
                    implode(', ', $mealsData['dinner_dessert'] ?? []),
                    $importTime
                ]);
            }

            // 3) relire menus insérés
            $stmtSelect = $pdo->prepare("SELECT * FROM menu_tbl WHERE date1 = ?");
            $stmtSelect->execute([$importTime]);
            $menus = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

            // 4) explosion vers tables meals
            foreach ($menus as $menu) {
                $menuId = (int)$menu['id'];

                foreach ($meals as $mealTable) {
                    $items = explode(',', (string)$menu[$mealTable]);

                    foreach ($items as $item) {
                        $item = trim($item);
                        if ($item === '') continue;

                        $stmtMeal = $pdo->prepare("
                            INSERT INTO {$mealTable}
                            (meal, allergene, enabled, id_menu, intolerance, ids)
                            VALUES (?, '', 1, ?, '', 0)
                        ");
                        $stmtMeal->execute([$item, $menuId]);
                    }
                }
            }

            $pdo->commit();

        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
