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
}
