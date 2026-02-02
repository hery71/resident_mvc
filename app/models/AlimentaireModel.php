<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';

class AlimentaireModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }

    // =========================
    // 🔎 Retrouver le menu via filtres
    // =========================
    public function getMenuByFilters(string $saison, int $annee, int $week, string $day): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM menu_tbl
            WHERE saison = ?
              AND annee LIKE ?
              AND week = ?
              AND day = ?
            LIMIT 1
        ");
        $stmt->execute([$saison, "%$annee%", $week, $day]);
        $menu = $stmt->fetch(PDO::FETCH_ASSOC);
        return $menu ?: null;
    }

    // =========================
    // 🍽 Charger les meals réels
    // =========================
    public function fetchMealList(string $table, int $id_menu): array
    {
        $allowed = ['breakfast','lunch','lunch_dessert','dinner','dinner_dessert'];
        if (!in_array($table, $allowed, true)) {
            return [];
        }

        $stmt = $this->pdo->prepare("
            SELECT id, meal
            FROM {$table}
            WHERE id_menu = ?
              AND enabled = 1
            ORDER BY id ASC
        ");
        $stmt->execute([$id_menu]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saveMeals(int $id_menu, array $post): void
    {
        $tables = [
            'breakfast',
            'lunch',
            'lunch_dessert',
            'dinner',
            'dinner_dessert'
        ];

        $this->pdo->beginTransaction();

        try {
            foreach ($tables as $table) {

                if (empty($post[$table]['meal'])) {
                    continue;
                }

                foreach ($post[$table]['meal'] as $i => $meal) {

                    $meal = trim($meal);
                    if ($meal === '') {
                        continue;
                    }

                    $id = (int)($post[$table]['id'][$i] ?? 0);

                    if ($id > 0) {
                        // 🔵 UPDATE
                        $stmt = $this->pdo->prepare("
                            UPDATE {$table}
                            SET meal = ?
                            WHERE id = ?
                            AND id_menu = ?
                        ");
                        $stmt->execute([$meal, $id, $id_menu]);

                    } else {
                        // 🟢 INSERT
                        $stmt = $this->pdo->prepare("
                            INSERT INTO {$table}
                            (meal, allergene, intolerance, enabled, id_menu)
                            VALUES (?, '', '', 1, ?)
                        ");
                        $stmt->execute([$meal, $id_menu]);
                    }
                }
            }

            $this->pdo->commit();

        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

}
