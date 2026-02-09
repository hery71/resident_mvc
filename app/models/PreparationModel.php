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
            'breakfast'       => $fetchMeals('breakfast')       ?: $menu['breakfast'],
            'lunch'           => $fetchMeals('lunch')           ?: $menu['lunch'],
            'lunch_dessert'   => $fetchMeals('lunch_dessert')   ?: $menu['lunch_dessert'],
            'dinner'          => $fetchMeals('dinner')          ?: $menu['dinner'],
            'dinner_dessert'  => $fetchMeals('dinner_dessert')  ?: $menu['dinner_dessert']
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
    function delete_preparation($id) {
        $stmt = $this->pdo->prepare("UPDATE preparation SET enabled = 0 WHERE id = ?");
        $stmt->execute([$id]);  
    }
}