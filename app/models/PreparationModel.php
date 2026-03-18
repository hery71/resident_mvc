<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';
class PreparationModel
{
    private $pdo;
    private string $fileIngredients;
    private string $fileActions;
    private string $fileUnites; 

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
        $this->fileIngredients = dirname(__DIR__, 2) . '/storage/data/ingredients.json';
        $this->fileActions = dirname(__DIR__, 2) . '/storage/data/action.json';
        $this->fileUnites = dirname(__DIR__, 2) . '/storage/data/unite.json';
    }
    public function get_ingredients()
    {
        if (!file_exists($this->fileIngredients)) {
            return [];
        }
        $json = file_get_contents($this->fileIngredients);
        $data = json_decode($json, true);
        return $data ?: [];
    }
    public function get_actions()
    {
        if (!file_exists($this->fileActions)) {
            return [];
        }
        $json = file_get_contents($this->fileActions);
        $data = json_decode($json, true);
        return $data ?: [];
    }   
    public function get_unites()
    {
        if (!file_exists($this->fileUnites)) {
            return [];
        }
        $json = file_get_contents($this->fileUnites);
        $data = json_decode($json, true);
        return $data ?: [];
    }
    public function get_special_menu_for_date($date)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM menu_unique WHERE date = ? AND enabled = 1 LIMIT 1");
        $stmt->execute([$date]);
        $special = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$special) return null;// ici le code sort si aucun menu unique n'est trouvé pour la date donnée
        $id_special = (int)$special['id'];
        $fetchMeals = function($table) use ($id_special) 
        {
            $sql = "SELECT GROUP_CONCAT(meal ORDER BY id SEPARATOR ', ') AS plats 
                    FROM `$table` WHERE ids = ? AND enabled = 1";
            $st = $this->pdo->prepare($sql);
            $st->execute([$id_special]);
            $r = $st->fetch(PDO::FETCH_ASSOC);
            return $r && $r['plats'] ? $r['plats'] : '';
        };
        return [
            'type' => 'special',
            'id' => $id_special,
            'nom' => $special['nom'],
            'observation' => $special['observation'],
            'breakfast' => $fetchMeals('breakfast'),
            'lunch' => $fetchMeals('lunch'),
            'lunch_dessert' => $fetchMeals('lunch_dessert'),
            'dinner' => $fetchMeals('dinner'),
            'dinner_dessert' => $fetchMeals('dinner_dessert')
        ];
    }
    function get_menu(int $annee, string $saison, ?int $week, string $day) 
    {
        if (in_array($saison, ['Christmass', 'New year'])) {
            $stmt = $this->pdo->prepare("SELECT * FROM menu_tbl WHERE annee LIKE ? AND saison=? AND day=? AND enabled=1 LIMIT 1");
            $stmt->execute(["%$annee%", $saison, $day]);
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM menu_tbl WHERE annee LIKE ? AND saison=? AND week=? AND day=? AND enabled=1 LIMIT 1");
            $stmt->execute(["%$annee%", $saison, $week, $day]);
        }
        $menu = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$menu) return null;

        $id_menu = $menu['id'];
        $fetchMeals = function($table) use ($id_menu) {
            $q = $this->pdo->prepare("SELECT GROUP_CONCAT(meal ORDER BY id SEPARATOR ', ') AS plats 
                                FROM {$table} WHERE id_menu=? AND enabled=1");
            $q->execute([$id_menu]);
            $r = $q->fetch(PDO::FETCH_ASSOC);
            return $r && $r['plats'] ? $r['plats'] : '';
        };
        return [
            'breakfast'      => $fetchMeals('menu_breakfast')      ?: $menu['breakfast'],
            'lunch'          => $fetchMeals('menu_lunch')          ?: $menu['lunch'],
            'lunch_dessert'  => $fetchMeals('menu_lunch_dessert')  ?: $menu['lunch_dessert'],
            'dinner'         => $fetchMeals('menu_dinner')         ?: $menu['dinner'],
            'dinner_dessert' => $fetchMeals('menu_dinner_dessert') ?: $menu['dinner_dessert']
        ];
    }
    public function get_preparation_for_date($xdate)    
    {
          // Récupère toutes les préparations EXISTANTES pour cette date
        $stmtPrep = $this->pdo->prepare("SELECT * FROM preparation WHERE date = ? AND enabled = 1");
        $stmtPrep->execute([$xdate]);
        return $stmtPrep->fetchAll(PDO::FETCH_ASSOC);

    }
    public function save_preparation($data)
    {
        $sql = "INSERT INTO preparation (date, plat, ingredient, nb, unite,  action, jour, enabled)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data['date'], 
            $data['plat'], 
            $data['ingredient'], 
            $data['nb'], 
            $data['unite'], 
            $data['action'], 
            $data['jour'], 
            1
        ]);
    }
    public function getByDateAndPlat(string $date, string $plat): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * 
             FROM preparation 
             WHERE date = ? 
               AND plat = ? 
               AND enabled = 1"
        );
        $stmt->execute([$date, $plat]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByPlat(string $plat): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, ingredient, action, nb, unite, jour
             FROM preparation
             WHERE plat = ?
               AND enabled = 1
             ORDER BY id DESC"
        );
        $stmt->execute([$plat]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByPlat(string $plat): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*)
             FROM preparation
             WHERE plat = ?
               AND enabled = 1"
        );
        $stmt->execute([$plat]);

        return (int)$stmt->fetchColumn();
    }

    public function applyPreparationsByIds(string $date, string $plat, array $ids): int
    {
        if (empty($ids)) {
            return 0;
        }

        $inserted = 0;
        $this->pdo->beginTransaction();

        try {
            $select = $this->pdo->prepare(
                "SELECT ingredient, action, nb, unite, jour
                 FROM preparation
                 WHERE id = ?
                   AND enabled = 1
                 LIMIT 1"
            );

            $exists = $this->pdo->prepare(
                "SELECT id
                 FROM preparation
                 WHERE date = ?
                   AND plat = ?
                   AND ingredient = ?
                   AND action = ?
                   AND nb = ?
                   AND unite = ?
                   AND jour = ?
                   AND enabled = 1
                 LIMIT 1"
            );

            $insert = $this->pdo->prepare(
                "INSERT INTO preparation (date, plat, ingredient, nb, unite, action, jour, enabled)
                 VALUES (?, ?, ?, ?, ?, ?, ?, 1)"
            );

            foreach ($ids as $id) {
                $id = (int)$id;
                if ($id <= 0) {
                    continue;
                }

                $select->execute([$id]);
                $row = $select->fetch(PDO::FETCH_ASSOC);

                if (!$row) {
                    continue;
                }

                $exists->execute([
                    $date,
                    $plat,
                    $row['ingredient'],
                    $row['action'],
                    $row['nb'],
                    $row['unite'],
                    $row['jour']
                ]);

                if ($exists->fetch(PDO::FETCH_ASSOC)) {
                    continue;
                }

                $insert->execute([
                    $date,
                    $plat,
                    $row['ingredient'],
                    $row['nb'],
                    $row['unite'],
                    $row['action'],
                    $row['jour']
                ]);

                $inserted++;
            }

            $this->pdo->commit();
            return $inserted;
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    function delete_preparation($id) {
        $stmt = $this->pdo->prepare("UPDATE preparation SET enabled = 0 WHERE id = ?");
        $stmt->execute([$id]);  
    }
    function getWeeklyPreparation($start,$end){
        $stmt = $this->pdo->prepare("SELECT * FROM preparation WHERE preparation_date >= ? AND preparation_date <= ? AND enabled = 1 ORDER BY preparation_date ASC");
        $stmt->execute([$start->format('Y-m-d'), $end->format('Y-m-d')]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getPreparationByDate($date){
        $stmt = $this->pdo->prepare("SELECT * FROM preparation WHERE preparation_date = ? AND enabled = 1");
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getMealIngredientsByPlat(string $plat): array
    {
        $table ='meal_tbl';
        $stmt = $this->pdo->prepare("
            SELECT ingredients
            FROM `$table`
            WHERE TRIM(LOWER(meal)) = TRIM(LOWER(?))
            LIMIT 1
        ");
        $stmt->execute([$plat]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['ingredients'])) {
            $items = array_map('trim', explode(',', $row['ingredients']));
            $items = array_filter($items, fn($v) => $v !== '');
            return array_values($items);
        }

        return [];
    }
    public function addIngredientToMeal(string $plat, string $ingredient): bool
    {
        $ingredient = $this->cleanIngredient($ingredient);

        if ($ingredient === '') {
            return false;
        }

        $table= 'meal_tbl';
        $stmt = $this->pdo->prepare("
            SELECT id, ingredients
            FROM `$table`
            WHERE TRIM(LOWER(meal)) = TRIM(LOWER(?))
            LIMIT 1
        ");

        $stmt->execute([$plat]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {

            $existing = trim((string)$row['ingredients']);

            // transformer en tableau
            $items = $existing !== ''
                ? array_map('trim', explode(',', $existing))
                : [];

            // supprimer éléments vides
            $items = array_filter($items, fn($v) => $v !== '');

            // vérifier si déjà présent
            foreach ($items as $item) {
                if (mb_strtolower($item) === mb_strtolower($ingredient)) {
                    return true;
                }
            }

            // ajouter l'ingrédient
            $items[] = $ingredient;

            // tri alphabétique
            natcasesort($items);

            // reconstruire la chaîne
            $newValue = implode(', ', $items);

            $up = $this->pdo->prepare("
                UPDATE `$table`
                SET ingredients = ?
                WHERE id = ?
            ");

            return $up->execute([$newValue, $row['id']]);
        }

        return false;
    }
    public function removeIngredientFromMeal(string $plat, string $ingredient): bool
    {
        $table = 'meal_tbl';
        $stmt = $this->pdo->prepare("
            SELECT id, ingredients
            FROM $table
            WHERE LOWER(TRIM(meal)) = LOWER(TRIM(?))
            LIMIT 1
        ");
        $stmt->execute([$plat]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) continue;
        $items = array_map('trim', explode(',', $row['ingredients']));
        $items = array_filter($items, fn($i) => strtolower($i) !== strtolower($ingredient));
        $new = implode(', ', $items);
        $up = $this->pdo->prepare("
            UPDATE $table
            SET ingredients = ?
            WHERE id = ?
        ");
        return $up->execute([$new, $row['id']]):
}
   public function addIngredientDictionary(string $ingredient): array
    {
        $ingredient = $this->cleanIngredient($ingredient);

        if ($ingredient === '') {
            return [
                'success' => false,
                'message' => 'ingredient vide'
            ];
        }

        $list = $this->get_ingredients();

        foreach ($list as $existing) {

            $existingClean = $this->cleanIngredient($existing);

            if ($existingClean === $ingredient) {
                return [
                    'success' => false,
                    'exists'  => true,
                    'ingredient' => $existing
                ];
            }
            /*

            if (levenshtein($ingredient, $existingClean) <= 2) {
                return [
                    'success' => false,
                    'similar' => $existing
                ];
            }
                */
        }

        $list[] = $ingredient;

        natcasesort($list);

        file_put_contents(
            $this->fileIngredients,
            json_encode(array_values($list), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return [
            'success' => true,
            'ingredient' => $ingredient
        ];
    }
   private function normalize(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');

        // remplacer caractères spéciaux français
        $text = strtr($text, [
            'œ' => 'oe',
            'æ' => 'ae',
            'ç' => 'c',
            'é' => 'e',
            'è' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'à' => 'a',
            'â' => 'a',
            'ä' => 'a',
            'ù' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'î' => 'i',
            'ï' => 'i',
            'ô' => 'o',
            'ö' => 'o'
        ]);

        // supprimer ponctuation
        $text = preg_replace('/[\'’\-_ ]/', '', $text);

        return $text;
    }
    private function cleanIngredient(string $text): string
    {
        $text = trim($text);

        // minuscules
        $text = mb_strtolower($text, 'UTF-8');

        // enlever accents
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

        // remplacer apostrophes et tirets par espace
        $text = str_replace(["'", "’", "-", "_"], " ", $text);

        // supprimer espaces multiples
        $text = preg_replace('/\s+/', ' ', $text);

        $text = trim($text);

        // enlever pluriel simple
        if (substr($text, -1) === "s") {
            $text = substr($text, 0, -1);
        }

        if (substr($text, -1) === "x") {
            $text = substr($text, 0, -1);
        }

        return $text;
    }
}