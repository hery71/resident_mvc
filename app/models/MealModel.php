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
        $stmt = $this->pdo->query("SELECT meal FROM meal_tbl WHERE enabled = 1 ORDER BY meal ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

}
