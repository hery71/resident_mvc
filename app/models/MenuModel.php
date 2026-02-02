<?php

class MenuModel
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    /* ============================================================
       🔥 MENU UNIQUE (par date)
       ============================================================ */
     public function getUniqueMenuForDate(string $date): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM menu_unique WHERE date = ? AND enabled = 1 LIMIT 1"
        );
        $stmt->execute([$date]);
        $unique = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$unique) return null;

        $id_unique = (int)$unique['id'];

        $fetchMeals = function ($table) use ($id_unique) {
            $sql = "SELECT GROUP_CONCAT(meal ORDER BY id SEPARATOR ', ') AS plats
                    FROM `$table`
                    WHERE ids = ? AND enabled = 1";
            $st = $this->pdo->prepare($sql);
            $st->execute([$id_unique]);
            $r = $st->fetch(PDO::FETCH_ASSOC);
            return $r['plats'] ?? '';
        };

        return [
            'type'           => 'unique',
            'id'             => $id_unique,
            'nom'            => $unique['nom'],
            'observation'    => $unique['observation'],
            'breakfast'      => $fetchMeals('breakfast'),
            'lunch'          => $fetchMeals('lunch'),
            'lunch_dessert'  => $fetchMeals('lunch_dessert'),
            'dinner'         => $fetchMeals('dinner'),
            'dinner_dessert' => $fetchMeals('dinner_dessert')
        ];
    }

    /* ============================================================
       🔥 MENU DE BASE (cycle normal)
       ============================================================ */
    public function getBaseMenu(
        string $saison,
        int $week,
        string $day,
        int $cycleYear
    ): ?array {
        $stmt = $this->pdo->prepare("
            SELECT * FROM menu_tbl
            WHERE saison=?
              AND week=?
              AND day=?
              AND annee LIKE ?
              AND enabled=1
            LIMIT 1
        ");
        $stmt->execute([$saison, $week, $day, "%$cycleYear%"]);
        $menuRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$menuRow) return null;

        $id_menu = (int)$menuRow['id'];

        $fetchMeals = function ($table) use ($id_menu, $menuRow) {
            $q = $this->pdo->prepare("
                SELECT GROUP_CONCAT(meal ORDER BY id SEPARATOR ', ') AS plats
                FROM $table
                WHERE id_menu = ? AND enabled = 1
            ");
            $q->execute([$id_menu]);
            $r = $q->fetch(PDO::FETCH_ASSOC);
            return $r['plats'] ?: $menuRow[$table];
        };

        return [
            'breakfast'       => $fetchMeals('breakfast'),
            'lunch'           => $fetchMeals('lunch'),
            'lunch_dessert'   => $fetchMeals('lunch_dessert'),
            'dinner'          => $fetchMeals('dinner'),
            'dinner_dessert'  => $fetchMeals('dinner_dessert')
        ];
    }
    function getSpecialMenuForDate(string $date) {
        $stmt = $this->pdo->prepare("SELECT * FROM menu_unique WHERE date = ? AND enabled = 1 LIMIT 1");
        $stmt->execute([$date]);
        $special = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$special) return null;

        $id_special = (int)$special['id'];
        $fetchMeals = function($table) use ($id_special) {
            $sql = "SELECT GROUP_CONCAT(meal ORDER BY id SEPARATOR ', ') AS plats 
                    FROM `$table` WHERE ids = ? AND enabled = 1";
            $st = $this->pdo->prepare($sql);
            $st->execute([$id_special]);
            $r = $st->fetch(PDO::FETCH_ASSOC);
            return $r && !empty($r['plats']) ? $r['plats'] : '';
        };

        return [
            'id'             => $id_special,
            'nom'            => $special['nom'],
            'observation'    => $special['observation'],
            'breakfast'      => $fetchMeals('breakfast'),
            'lunch'          => $fetchMeals('lunch'),
            'lunch_dessert'  => $fetchMeals('lunch_dessert'),
            'dinner'         => $fetchMeals('dinner'),
            'dinner_dessert' => $fetchMeals('dinner_dessert')
        ];
    }

    function getFullMenu(string $saison, int $week, string $day, int $annee) {

        $stmt = $this->pdo->prepare("
            SELECT * FROM menu_tbl
            WHERE saison = ? 
            AND week   = ? 
            AND day    = ? 
            AND annee  LIKE ? 
            AND enabled = 1 
            LIMIT 1
        ");
        $stmt->execute([$saison, $week, $day, "%$annee%"]);

        $menuRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$menuRow) return null;

        $id_menu = (int)$menuRow['id'];

        $fetchMeals = function($table) use ($id_menu, $menuRow) {
            $sql = "SELECT GROUP_CONCAT(meal ORDER BY id SEPARATOR ', ') AS plats 
                    FROM `$table` 
                    WHERE id_menu = ? AND enabled = 1";
            $q = $this->pdo->prepare($sql);
            $q->execute([$id_menu]);
            $r = $q->fetch(PDO::FETCH_ASSOC);
            // Si aucun détail trouvé → on retombe sur la colonne de base de menu_tbl (si elle existe)
            return $r && !empty($r['plats']) ? $r['plats'] : ($menuRow[$table] ?? '');
        };

        return [
            'breakfast'       => $fetchMeals('breakfast'),
            'lunch'           => $fetchMeals('lunch'),
            'lunch_dessert'   => $fetchMeals('lunch_dessert'),
            'dinner'          => $fetchMeals('dinner'),
            'dinner_dessert'  => $fetchMeals('dinner_dessert')
        ];
    }

    public function getMonthlyMenus(int $year, int $month): array
    {
        $monthStart = new DateTime("$year-$month-01");
        $monthEnd   = (clone $monthStart)->modify('last day of this month');

        $rows = [];
        $current = clone $monthStart;

        $cycle = MenuCycle::getSeasonAndWeek($current->format('Y-m-d'));
        $season = $cycle['season'];
        $week   = $cycle['week'];
        $cycleYear = $cycle['cycleYear'] ?? (int)$current->format('Y');

        while ($current <= $monthEnd) {
            $date = $current->format('Y-m-d');
            $day  = $current->format('l');

            if ($current->format('w') == 0) {
                $cycle = MenuCycle::getSeasonAndWeek($date);
                $season = $cycle['season'];
                $week   = $cycle['week'];
                $cycleYear = $cycle['cycleYear'] ?? (int)$current->format('Y');
            }

            $special = $this->getSpecialMenuForDate($date);

            if ($special) {
                $rows[] = [
                    'date' => $date,
                    'day' => $day,
                    'saison' => 'Special',
                    'week' => '-',
                    'menu' => $special
                ];
            } else {
                $menu = ($week !== null)
                    ? $this->getFullMenu($season, $week, $day, $cycleYear)
                    : null;

                $rows[] = [
                    'date' => $date,
                    'day' => $day,
                    'saison' => $season,
                    'week' => $week ?? '-',
                    'menu' => $menu
                ];
            }

            $current->modify('+1 day');
        }

        return [
            'rows' => $rows,
            'year' => $year,
            'month' => $month,
            'monthName' => DateHelper::MONTHS_FR[$month - 1]
        ];
    }
    // ===============================
// 🎄🎆 Menus spéciaux (week 4 / 5)
// ===============================
public function getSpecialMenus(int $annee, int $week): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM menu_tbl
            WHERE enabled = 1
            AND annee LIKE :annee
            AND week = :week
            ORDER BY FIELD(day,
            'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')
        ");
        $stmt->execute([
            'annee' => "%$annee%",
            'week'  => $week
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===============================
    // 🍽️ Récupération des plats
    // ===============================
    public function getMealsByMenu(int $id_menu): array
    {
        $tables = ['breakfast','lunch','lunch_dessert','dinner','dinner_dessert'];
        $plats  = [];

        foreach ($tables as $table) {
            $sql = "
                SELECT GROUP_CONCAT(meal ORDER BY id SEPARATOR ', ') AS plats
                FROM `$table`
                WHERE id_menu = :id_menu AND enabled = 1
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id_menu' => $id_menu]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            $plats[$table] = $res && $res['plats'] ? trim($res['plats']) : '';
        }

        // 🚫 Sécurité dessert = dinner
        if ($plats['dinner'] === $plats['dinner_dessert']) {
            $plats['dinner_dessert'] = '';
        }

        return $plats;
    }

}
