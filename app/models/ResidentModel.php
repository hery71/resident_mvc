<?php
/*
var_dump(file_exists(dirname(__DIR__, 2) . '/db.php'));
exit;
*/
require_once __DIR__ . '/../../app/config/db.php';

class ResidentModel
{
    private $pdo;

    public function __construct()
    {
        global $pdo;

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
                    Prenom = :prenom,
                    Nom = :nom,
                    Anniversaire = :anniversaire,
                    Famille = :famille,
                    Tel1 = :tel1,
                    Tel2 = :tel2,
                    Tel3 = :tel3,
                    Chambre = :chambre
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'prenom' => $data['Prenom'],
            'nom' => $data['Nom'],
            'anniversaire' => $data['Anniversaire'],
            'famille' => $data['Famille'],
            'tel1' => $data['Tel1'],
            'tel2' => $data['Tel2'],
            'tel3' => $data['Tel3'],
            'chambre' => $data['Chambre'],
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

}
}
