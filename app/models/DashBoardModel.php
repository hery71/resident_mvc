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
        $fields = [
            'breakfast',
            'lunch',
            'lunch_dessert',
            'dinner',
            'dinner_dessert'
        ];

        $results = [];

        // 🔹 Récupérer tous les résidents actifs
        $resStmt = $this->pdo->query("
            SELECT Id, Prenom, Nom, Chambre, Allergie, Intolerance
            FROM resident_tbl
            WHERE enabled = 1
        ");

        $residents = $resStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($fields as $field) {

            if (empty($menu[$field])) {
                continue;
            }

            // 🔹 Découper les items du menu
            $items = array_map('trim', explode(',', $menu[$field]));

            foreach ($items as $item) {

                if ($item === '' || str_ends_with($item, ':')) {
                    continue;
                }

                // 🔥 NOUVELLE REQUÊTE (meal_tbl)
                $stmt = $this->pdo->prepare("
                    SELECT meal, allergene, intolerance
                    FROM meal_tbl
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

                    // 🔴 Allergènes
                    foreach ($residentAllergies as $ra) {
                        if ($ra !== '' && in_array($ra, $itemAllergenes)) {
                            $concernedResidents[] =
                                $resident['Prenom'] . ' ' . $resident['Nom'];
                            break;
                        }
                    }

                    // 🟠 Intolérances
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
                    'meal'        => $row['meal'], // ⚠️ changé
                    'allergene'   => $row['allergene'],
                    'intolerance' => $row['intolerance'],
                    'residents'   => $concernedResidents
                ];
            }
        }

        return $results;
    }
}