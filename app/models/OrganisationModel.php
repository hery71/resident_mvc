<?php

class OrganisationModel
{
   private $pdo;
    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getOrganisation(): ?array
    {
        $stmt = $this->pdo->query("SELECT * FROM organisation LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }
}
