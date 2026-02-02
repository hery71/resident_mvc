<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';

class BaseModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }
}