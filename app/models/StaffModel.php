<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';
class StaffModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }
    public function getAllStaffs()
    {
        $sql = "SELECT * FROM staff_tbl where enabled=1 ORDER BY nom, prenom ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }   

}