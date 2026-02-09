<?php

class RestrictionModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function getRestrictions(string $table): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `$table` where  
        (allergene <> '' or 
        intolerance <> '')
        ORDER BY meal ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllMeals(string $table): array
    {
        $stmt = $this->pdo->prepare("SELECT id, meal FROM `$table` WHERE enabled=1 ORDER BY meal ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getRestrictionByMealId(string $table, int $mealId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT id, meal, allergene, intolerance FROM `$table` WHERE id = :mealId");
        $stmt->bindParam(':mealId', $mealId, PDO::PARAM_INT);
        $stmt->execute();
        $meal = $stmt->fetch(PDO::FETCH_ASSOC);
        return $meal ?: null;
        var_dump($meal);
        exit();
    }
    public function saveRestrictions(string $table, int $mealId, string $allergeneStr, string $intoleranceStr): bool
    {
        $stmt = $this->pdo->prepare("UPDATE `$table` SET allergene = :allergene, intolerance = :intolerance WHERE id = :mealId");
        $stmt->bindParam(':allergene', $allergeneStr, PDO::PARAM_STR);
        $stmt->bindParam(':intolerance', $intoleranceStr, PDO::PARAM_STR);
        $stmt->bindParam(':mealId', $mealId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}