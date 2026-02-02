<?php

require_once dirname(__DIR__, 1) . '/config/db.php';

class UserModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }

    public function findByLoginOrEmail($value)
    {
        $sql = "SELECT * FROM users 
                WHERE Login = :login OR Email = :email 
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'login' => $value,
            'email' => $value
        ]);

        return $stmt->fetch();
    }

}
