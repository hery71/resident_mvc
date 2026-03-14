<?php

class DashboardModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Retourne les allergènes / intolérances
     * des items du menu du jour
     */
   public function getMenuRestrictions(array $menu): array
    {
        $map = [
            'breakfast'       => 'meal_breakfast',
            'lunch'           => 'meal_lunch',
            'lunch_dessert'   => 'meal_lunch_dessert',
            'dinner'          => 'meal_dinner',
            'dinner_dessert'  => 'meal_dinner_dessert'
        ];

        $results = [];

        // 🔹 Récupérer tous les résidents actifs
        $resStmt = $this->pdo->query("
            SELECT Id, Prenom, Nom, Chambre, Allergie, Intolerance
            FROM resident_tbl
            WHERE enabled = 1
        ");

        $residents = $resStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($map as $field => $table) {

            if (empty($menu[$field])) {
                continue;
            }

            // 🔹 Découper les items du menu
            $items = array_map('trim', explode(',', $menu[$field]));

            foreach ($items as $item) {

                if ($item === '' || str_ends_with($item, ':')) {
                    continue;
                }

                $stmt = $this->pdo->prepare("
                    SELECT meal, allergene, intolerance
                    FROM $table
                    WHERE LOWER(TRIM(meal)) = LOWER(TRIM(:meal))
                    AND enabled = 1
                    LIMIT 1
                ");

                $stmt->execute(['meal' => $item]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$row) {
                    continue;
                }

                if (empty($row['allergene']) && empty($row['intolerance'])) {
                    continue;
                }

                // 🔹 Découper les allergènes du plat
                $itemAllergenes = array_map(
                    fn($v) => strtolower(trim($v)),
                    explode(',', (string)($row['allergene'] ?? ''))
                );

                $itemIntolerances = array_map(
                    fn($v) => strtolower(trim($v)),
                    explode(',', (string)($row['intolerance'] ?? ''))
                );

                $concernedResidents = [];

                foreach ($residents as $resident) {

                    $residentAllergies = array_map(
                        fn($v) => strtolower(trim($v)),
                        explode(',', (string)($resident['Allergie'] ?? ''))
                    );

                    $residentIntolerances = array_map(
                        fn($v) => strtolower(trim($v)),
                        explode(',', (string)($resident['Intolerance'] ?? ''))
                    );

                    // 🔴 Comparaison allergènes
                    foreach ($residentAllergies as $ra) {
                        if ($ra !== '' && in_array($ra, $itemAllergenes)) {
                            $concernedResidents[] =
                                $resident['Prenom'] . ' ' . $resident['Nom'];
                            break;
                        }
                    }

                    // 🟠 Comparaison intolérances
                    foreach ($residentIntolerances as $ri) {
                        if ($ri !== '' && in_array($ri, $itemIntolerances)) {
                            $concernedResidents[] =
                                $resident['Prenom'] . ' ' . $resident['Nom'];
                            break;
                        }
                    }
                }

                $results[] = [
                    'section'     => ucfirst(str_replace('_', ' ', $field)),
                    'meal'        => $row['meal'],
                    'allergene'   => $row['allergene'],
                    'intolerance' => $row['intolerance'],
                    'residents'   => $concernedResidents
                ];
            }
        }

        return $results;
    }
}