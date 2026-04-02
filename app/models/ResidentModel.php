<?php

require_once __DIR__ . '/../../app/config/db.php';

class ResidentModel
{
    private $pdo;
    private string $fileIngredients;
    private string $fileAllergies;
    private string $fileIntolerances;

    public function __construct()
    {
        global $pdo;
        $this->fileIngredients = dirname(__DIR__, 2) . '/storage/data/ingredients.json';
        $this->fileAllergies = dirname(__DIR__, 2) . '/storage/data/allergies.json';
        $this->fileIntolerances = dirname(__DIR__, 2) . '/storage/data/intolerances.json';

        if (!$pdo) {
            die("❌ PDO non initialisé (db.php non chargé)");
        }

        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM resident_tbl WHERE 1=1 AND enabled=1 ORDER BY Nom");
        return $stmt->fetchAll();
    }
    public function getPaginated($limit, $offset, $nom, $prenom)
    {
        $sql = "SELECT * FROM resident_tbl WHERE 1=1 AND enabled=1";
        $params = [];

        if ($nom !== '') {
            $sql .= " AND Nom LIKE :nom";
            $params['nom'] = "%$nom%";
        }

        if ($prenom !== '') {
            $sql .= " AND Prenom LIKE :prenom";
            $params['prenom'] = "%$prenom%";
        }

        $sql .= " ORDER BY Prenom ASC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function countFiltered($nom, $prenom)
    {
        $sql = "SELECT COUNT(*) FROM resident_tbl WHERE 1=1 AND enabled=1";
        $params = [];

        if ($nom !== '') {
            $sql .= " AND Nom LIKE :nom";
            $params['nom'] = "%$nom%";
        }

        if ($prenom !== '') {
            $sql .= " AND Prenom LIKE :prenom";
            $params['prenom'] = "%$prenom%";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn();
    }
    public function update($id, $data)
    {
        $sql = "UPDATE resident_tbl SET
                    Gender = :gender,
                    Prenom = :prenom,
                    Nom = :nom,
                    Anniversaire = :anniversaire,
                    Famille = :famille,
                    Tel1 = :tel1,
                    Tel2 = :tel2,
                    Tel3 = :tel3,
                    Chambre = :chambre,
                    Relation = :relation
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'gender' => $data['Gender'],
            'prenom' => $data['Prenom'],
            'nom' => $data['Nom'],
            'anniversaire' => $data['Anniversaire'],
            'famille' => $data['Famille'],
            'tel1' => $data['Tel1'],
            'tel2' => $data['Tel2'],
            'tel3' => $data['Tel3'],
            'chambre' => $data['Chambre'],
            'relation' => $data['Relation'],
            'id' => $id
        ]);
    }
    public function findById($id)
    {
        $sql = "SELECT * FROM resident_tbl WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }
     public function findByBornDate($date)
     {
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
         $sql = "SELECT * FROM resident_tbl WHERE MONTH(Anniversaire) = :month AND DAY(Anniversaire) = :day AND enabled = 1";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(['month' => $month, 'day' => $day]);

         return $stmt->fetchAll();
     }
    public function departResident($id, $cause, $date)
    {
        $sql = "UPDATE resident_tbl
                SET enabled = 0,
                    CauseDepart = :cause,
                    leavedate = :date
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'cause' => $cause,
            'date'  => $date,
            'id'    => $id
        ]);
    }
    public function insert($data)
    {
        $sql = "INSERT INTO resident_tbl
            (Nom, Prenom, Anniversaire, Admission, Gender,
            Tel1, Tel2, Tel3, Famille, Relation, Enabled)
            VALUES
            (:Nom, :Prenom, :Anniversaire, :Admission, :Gender,
            :Tel1, :Tel2, :Tel3, :Famille, :Relation, 1)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }
    public function updatePreferenceAlimentaire($id, $data)
    {
        $sql = "UPDATE resident_tbl SET
                    Bread = :Bread,
                    Tartinade = :Tartinade,
                    Cereale = :Cereale,
                    Proteine = :Proteine,
                    Fruit = :Fruit,
                    BREUVAGE_DEJ = :Breuvage_dej,
                    BREUVAGE_DIN = :Breuvage_din,
                    BREUVAGE_SOU = :Breuvage_sou,
                    moremeal = :moremeal,
                    lessmeal = :lessmeal,
                    Regime = :Regime,
                    ModeEating = :ModeEating,
                    Allergie = :Allergie
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'Bread' => $data['Bread'],
            'Tartinade' => $data['Tartinade'],
            'Cereale' => $data['Cereale'],
            'Proteine' => $data['Proteine'],
            'Fruit' => $data['Fruit'],
            'Breuvage_dej' => $data['Breuvage_dej'],
            'Breuvage_din' => $data['Breuvage_din'],
            'Breuvage_sou' => $data['Breuvage_sou'],
            'moremeal' => $data['moremeal'],
            'lessmeal' => $data['lessmeal'],
            'Regime' => $data['Regime'],
            'ModeEating' => $data['ModeEating'],
            'Allergie' => $data['Allergie'],
            'id' => $id
        ]);
        return $stmt->rowCount() > 0;

    }
    public function findDietById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM resident_tbl WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateDietetique(int $id, array $data): bool
    {
        if ($id <= 0 || empty($data)) {
            return false;
        }

        // ✅ Convertir automatiquement les champs multi-select (array -> varchar)
        foreach (['Intolerance', 'Allergie'] as $multiField) {
            if (array_key_exists($multiField, $data)) {
                if (is_array($data[$multiField])) {
                    // Nettoyage + suppression des vides + unicité
                    $vals = array_values(array_unique(array_filter(array_map('trim', $data[$multiField]))));
                    $data[$multiField] = $vals ? implode(', ', $vals) : null;
                } else {
                    // si string: trim et null si vide
                    $v = trim((string)$data[$multiField]);
                    $data[$multiField] = ($v === '') ? null : $v;
                }
            }
        }

        // (Optionnel) trim sur tous les champs string
        foreach ($data as $k => $v) {
            if (is_string($v)) {
                $data[$k] = trim($v);
            }
            if ($data[$k] === '') {
                $data[$k] = null;
            }
        }

        // Construire dynamiquement SET
        $set = [];
        foreach ($data as $key => $value) {
            // ⚠️ sécurité: on évite les clés bizarres
            if (!preg_match('/^[A-Za-z0-9_]+$/', $key)) {
                continue;
            }
            $set[] = "`$key` = :$key";
        }

        if (empty($set)) {
            return false;
        }

        $sql = "UPDATE `resident_tbl` SET " . implode(', ', $set) . " WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);

        $data['id'] = $id;
        return $stmt->execute($data);
    }
    public function getLastResidentId()
    {
        $stmt = $this->pdo->query("SELECT * FROM resident_tbl WHERE enabled=1 ORDER BY id DESC LIMIT 5 ");
        return $stmt->fetchAll();
    }
    public function makeTelDefault($id_resident, $tel)
    {
        $sql = "UPDATE resident_tbl SET Tel_default = :tel WHERE id = :id_resident";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'tel' => $tel,
            'id_resident' => $id_resident
        ]);
    }
    public function getAllEnabled()
    {
        $stmt = $this->pdo->query("
            SELECT Id, Prenom, Nom
            FROM resident_tbl
            WHERE enabled = 1
            ORDER BY Prenom
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getrestriction($field, $id){
    $stmt = $this->pdo->prepare("SELECT `$field` FROM resident_tbl WHERE Id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
    }
    public function updateRestriction($field, $value, $id){
        $sql = "UPDATE resident_tbl SET `$field` = :value WHERE Id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'value' => $value,
            'id' => $id
        ]);
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
    public function get_item($type)
    {
        if (!file_exists($this->fileIngredients)) {
            return [];
        }
        $file='';
        switch ($type) {
            case 'ingredient':
                $file = $this->fileIngredients;
                break;
            case 'allergie':
                $file = $this->fileAllergies;
                break;
            case 'intolerance':
                $file = $this->fileIntolerances;
                break;
            default:
                return [];
        }
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        return $data ?: [];
    }
    public function addDictionary($type,string $value): array
    {
        $value = $this->cleanIngredient($value);


        if ($value === '') {
            return [
                'success' => false,
                'message' => 'Item vide'
            ];
        }

        $list = $this->get_item($type);

        // Determine the file path based on type
        $file = '';
        switch ($type) {
            case 'ingredient':
                $file = $this->fileIngredients;
                break;
            case 'allergie':
                $file = $this->fileAllergies;
                break;
            case 'intolerance':
                $file = $this->fileIntolerances;
                $json = file_get_contents($file);
                $data = json_decode($json, true);
                if (!$data) {
                    return ['success'=>false];
                }
                $mainKey = 'Intolerances_Alimentaires_Canada';
                $defaultCategory = 'Autres_Aliments';

                if (!isset($data[$mainKey][$defaultCategory])) {
                    $data[$mainKey][$defaultCategory] = [];
                }
                // 🔍 vérifier si existe déjà dans toutes les catégories
                foreach ($data[$mainKey] as $cat => $items) {
                    foreach ($items as $existing) {
                        if ($this->cleanIngredient($existing) === $value) {
                            return [
                                'success' => false,
                                'exists' => true,
                                'value' => $existing
                            ];
                        }
                    }
                }
                // ✅ ajout dans catégorie par défaut
                $data[$mainKey][$defaultCategory][] = $value;

                // tri
                sort($data[$mainKey][$defaultCategory], SORT_NATURAL | SORT_FLAG_CASE);

                file_put_contents(
                    $file,
                    json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                );

                return [
                    'success' => true,
                    'value' => $value
                ];
            default:
                return [
                    'success' => false,
                    'message' => 'Type invalide'
                ];
        }

        foreach ($list as $existing) {

            $existingClean = $this->cleanIngredient($existing);

            if ($existingClean === $value) {
                return [
                    'success' => false,
                    'exists'  => true,
                    'value' => $existing
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

        $list[] = $value;

        natcasesort($list);

        file_put_contents(
            $file,
            json_encode(array_values($list), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return [
            'success' => true,
            'value' => $value
        ];
    }
}
