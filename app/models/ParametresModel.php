<?php

require_once dirname(__DIR__, 2) . '/app/config/db.php';

class ParametresModel
{
    private PDO $pdo;

    /**
     * Table de détail => colonne correspondante dans menu_tbl.
     */
    private const MEAL_MAP = [
        'menu_breakfast'      => 'breakfast',
        'menu_lunch'          => 'lunch',
        'menu_lunch_dessert'  => 'lunch_dessert',
        'menu_dinner'         => 'dinner',
        'menu_dinner_dessert' => 'dinner_dessert',
    ];

    private const DAY_NAMES = [
        1 => 'Sunday',
        2 => 'Monday',
        3 => 'Tuesday',
        4 => 'Wednesday',
        5 => 'Thursday',
        6 => 'Friday',
        7 => 'Saturday',
    ];

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }

    public function getCompanyInfo(): array|false
    {
        $stmt = $this->pdo->query('SELECT * FROM organisation WHERE id = 1');
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function exportMenus(array $postData, string $saison, string $annee): void
    {
        $data = $this->parseMenuData($postData, [1, 2, 3]);
        $this->persistMenuData($data, $saison, $annee);
    }

    public function exportSpecialMenus(array $postData, string $saison, string $annee): void
    {
        $data = $this->parseMenuData($postData, [1]);
        $this->persistMenuData($data, $saison, $annee);
    }

    /**
     * Accepte les nouveaux champs week1_menu_breakfast ainsi que les anciens
     * champs week1_breakfast pour rester compatible avec les deux vues.
     */
    private function parseMenuData(array $postData, array $weeks): array
    {
        $data = [];

        foreach ($weeks as $week) {
            foreach (self::MEAL_MAP as $mealTable => $menuColumn) {
                $newField = "week{$week}_{$mealTable}";
                $oldField = "week{$week}_{$menuColumn}";
                $text = trim((string)($postData[$newField] ?? $postData[$oldField] ?? ''));

                if ($text === '') {
                    continue;
                }

                $lines = preg_split('/\R/', $text) ?: [];

                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '') {
                        continue;
                    }

                    $columns = explode(';', $line);

                    for ($day = 0; $day < 7; $day++) {
                        $item = trim((string)($columns[$day] ?? ''));
                        if ($item !== '') {
                            $data[(int)$week][$day + 1][$mealTable][] = $item;
                        }
                    }
                }
            }
        }

        return $data;
    }

    private function persistMenuData(array $data, string $saison, string $annee): void
    {
        $importTime = date('Y-m-d H:i:s');
        $this->pdo->beginTransaction();

        try {
            $stmtMenu = $this->pdo->prepare('
                INSERT INTO menu_tbl
                (week, annee, saison, day, breakfast, lunch, lunch_dessert,
                 dinner, dinner_dessert, enabled, date1)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)
            ');

            $mealStatements = [];
            foreach (self::MEAL_MAP as $mealTable => $menuColumn) {
                $mealStatements[$mealTable] = $this->pdo->prepare("
                    INSERT INTO `{$mealTable}`
                    (meal, allergene, enabled, id_menu, intolerance, ids)
                    VALUES (?, '', 1, ?, '', 0)
                ");
            }

            foreach ($data as $week => $days) {
                foreach ($days as $day => $mealsData) {
                    if (!isset(self::DAY_NAMES[$day])) {
                        continue;
                    }

                    $stmtMenu->execute([
                        $week,
                        $annee,
                        $saison,
                        self::DAY_NAMES[$day],
                        implode(', ', $mealsData['menu_breakfast'] ?? []),
                        implode(', ', $mealsData['menu_lunch'] ?? []),
                        implode(', ', $mealsData['menu_lunch_dessert'] ?? []),
                        implode(', ', $mealsData['menu_dinner'] ?? []),
                        implode(', ', $mealsData['menu_dinner_dessert'] ?? []),
                        $importTime,
                    ]);

                    $menuId = (int)$this->pdo->lastInsertId();

                    foreach (self::MEAL_MAP as $mealTable => $menuColumn) {
                        foreach ($mealsData[$mealTable] ?? [] as $item) {
                            $mealStatements[$mealTable]->execute([$item, $menuId]);
                        }
                    }
                }
            }

            $this->pdo->commit();
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
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
                     FIELD(day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday',
                                'Thursday', 'Friday', 'Saturday')
        ");

        $stmt->execute(["%{$annee}%", $saison]);
        $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];

        foreach ($menus as $menu) {
            $week = (int)$menu['week'];
            $day = (string)$menu['day'];
            $menuId = (int)$menu['id'];

            foreach (self::MEAL_MAP as $mealTable => $menuColumn) {
                $result[$week][$day][$menuColumn] = $this->getItems($mealTable, $menuId);
            }
        }

        return $result;
    }

    private function getItems(string $table, int $menuId): array
    {
        if (!array_key_exists($table, self::MEAL_MAP)) {
            throw new InvalidArgumentException('Table de repas invalide.');
        }

        $stmt = $this->pdo->prepare("
            SELECT meal
            FROM `{$table}`
            WHERE id_menu = ?
              AND enabled = 1
            ORDER BY id
        ");

        $stmt->execute([$menuId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getExistedSeasonYear(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT CONCAT(annee, ' ', saison)
            FROM menu_tbl
            WHERE enabled = 1
            GROUP BY CONCAT(annee, ' ', saison)
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function disableYearSeason(string $annee, string $saison): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE menu_tbl SET enabled = 0 WHERE annee = ? AND saison = ?'
        );
        $stmt->execute([$annee, $saison]);
    }

    public function getStartSeasonWeeks(): array
    {
        $stmt = $this->pdo->query("
            SELECT *
            FROM season_start_week
            WHERE enabled = 1
            ORDER BY annee DESC,
                     FIELD(saison, 'Winter', 'Spring', 'Summer', 'Fall')
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteStartSeasonWeek(int $id): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE season_start_week SET enabled = 0 WHERE id = ?'
        );
        $stmt->execute([$id]);
    }

    public function checkStartSeasonWeekExists(
        string $annee,
        string $saison
    ): bool {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM season_start_week
            WHERE annee = ?
              AND saison = ?
              AND enabled = 1
        ");
        $stmt->execute([$annee, $saison]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function addStartSeasonWeek(
        string $annee,
        string $saison,
        int $week
    ): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO season_start_week (annee, saison, week, enabled)
            VALUES (?, ?, ?, 1)
        ");
        $stmt->execute([$annee, $saison, $week]);
    }
}