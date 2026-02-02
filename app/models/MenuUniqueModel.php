<?php

class MenuUniqueModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM menu_unique WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(string $nom, string $date, string $observation): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO menu_unique (nom, date, observation, enabled)
            VALUES (?, ?, ?, 1)
        ");
        $stmt->execute([$nom, $date, $observation]);
        return (int)$this->pdo->lastInsertId();
    }
    public function update(int $id, string $nom, string $date, string $observation): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE menu_unique
            SET nom = ?, date = ?, observation = ?
            WHERE id = ?
        ");
        $stmt->execute([$nom, $date, $observation, $id]);
    }   

    public function getMeals(int $id_unique): array
    {
        $tables = ['breakfast','lunch','lunch_dessert','dinner','dinner_dessert'];
        $out = [];

        foreach ($tables as $table) {
            $stmt = $this->pdo->prepare("
                SELECT id, meal FROM `$table`
                WHERE ids=? AND enabled=1
                ORDER BY id
            ");
            $stmt->execute([$id_unique]);
            $out[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $out;
    }

    public function updateMeal(string $table, int $id, string $meal): void
    {
        $this->pdo->prepare("
            UPDATE `$table` SET meal=? WHERE id=?
        ")->execute([$meal, $id]);
    }

    public function insertMeal(string $table, int $id_unique, string $meal): void
    {
        $this->pdo->prepare("
            INSERT INTO `$table` (meal, ids, enabled)
            VALUES (?, ?, 1)
        ")->execute([$meal, $id_unique]);
    }

    public function deleteMeal(string $table, int $id): void
    {
        $this->pdo->prepare("DELETE FROM `$table` WHERE id=?")
            ->execute([$id]);
    }
    public function getByYear(int $year): array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM menu_unique
            WHERE 
            YEAR(date) = ?
            AND enabled = 1
            ORDER BY date DESC
        ");
        $stmt->execute([$year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAvailableYears(): array
    {
        $stmt = $this->pdo->query("
            SELECT DISTINCT YEAR(date) AS year
            FROM menu_unique
            ORDER BY year DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function getDateById(int $id): ?string
    {
        $stmt = $this->pdo->prepare("SELECT date FROM menu_unique WHERE id=?");
        $stmt->execute([$id]);
        $date = $stmt->fetchColumn();
        return $date ?: null;
    }
    public function getIdfromMenu($day, $year,$uniqueDate): ?int
    {
        $cycle = MenuCycle::getSeasonAndWeek($uniqueDate);
        $stmt = $this->pdo->prepare("
            SELECT id FROM menu_tbl
            WHERE saison=? AND week=? AND day=? AND annee LIKE ? AND enabled=1
            LIMIT 1
        ");
        $stmt->execute([
            $cycle['season'],
            $cycle['week'],
            $day,
            "%$year%"
        ]);
        $id_menu = $stmt->fetchColumn();
        return $id_menu ?: null;
    }
    public function getMealByMenuId(int $id_menu, string $table): array
    {
        $stmt = $this->pdo->prepare("
            SELECT meal FROM `$table`
            WHERE id_menu=? AND enabled=1
            ORDER BY id
        ");
        $stmt->execute([$id_menu]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function insertMeals(int $id_unique, string $table, string $meal): void
    {
            $this->pdo->prepare("
                INSERT INTO `$table` (meal, ids, enabled)
                VALUES (?, ?, 1)
            ")->execute([
                $meal,
                $id_unique
            ]);
    }
}
