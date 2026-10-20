<?php

require_once __DIR__ . '/../config/db.php';

class SecondChoiceModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }

    public function get(): array
    {
        return $this->pdo->query('SELECT `Breakfast`, `lunch`, `diner`, `enabled` FROM `2ndchoice` WHERE `id` = 1')->fetch(PDO::FETCH_ASSOC)
            ?: ['Breakfast' => '', 'lunch' => '', 'diner' => '', 'enabled' => 1];
    }

    public function save(array $values): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO `2ndchoice` (`id`, `Breakfast`, `lunch`, `diner`, `enabled`)
             VALUES (1, :breakfast, :lunch, :diner, 1)
             ON DUPLICATE KEY UPDATE `Breakfast` = :new_breakfast, `lunch` = :new_lunch, `diner` = :new_diner'
        );
        $stmt->execute([
            'breakfast' => $values['Breakfast'], 'lunch' => $values['lunch'], 'diner' => $values['diner'],
            'new_breakfast' => $values['Breakfast'], 'new_lunch' => $values['lunch'], 'new_diner' => $values['diner'],
        ]);
    }
}
