<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';
class StaffModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }
    public function getAllStaffs()
    {
        $sql = "SELECT * FROM staff_tbl where enabled=1 ORDER BY nom, prenom ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }   
    public function getStaffById($id)
    {
        $sql = "SELECT * FROM staff_tbl WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function disableStaff($id)
    {
        $sql = "UPDATE staff_tbl SET enabled = 0 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
    public function updateStaff($data)
    {
        $sql = "UPDATE staff_tbl SET 
                nom = :nom,
                prenom = :prenom,
                middle_name = :middle_name,
                gender = :gender,
                dob = :dob,
                statut = :statut,
                departement = :departement,
                sous_departement = :sous_departement,
                poste = :poste,
                tel1 = :tel1,
                tel2 = :tel2,
                adresse_l1 = :adresse_l1,
                adresse_l2 = :adresse_l2,
                code_postal = :code_postal,
                ville = :ville
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'middle_name' => $data['middle_name'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'statut' => $data['statut'],
            'departement' => $data['departement'],
            'sous_departement' => $data['sous_departement'],
            'poste' => $data['poste'],
            'tel1' => $data['tel1'],
            'tel2' => $data['tel2'],
            'adresse_l1' => $data['adresse_l1'],
            'adresse_l2' => $data['adresse_l2'],
            'code_postal' => $data['code_postal'],
            'ville' => $data['ville'],
            'id' => $data['id']
        ]);
        return $stmt->rowCount() > 0;
    }
}