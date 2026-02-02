<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';
class CakeModel
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function findByResidentAndYear($idResident, $annee)
    {
        $sql = "SELECT * FROM cake
                WHERE idResident = :id
                  AND annee = :annee
                  AND enabled = 1
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $idResident,
            'annee' => $annee
        ]);

        return $stmt->fetch();
    }
    public function cakeOrderList($mois, $annee)
    {
        $sql = "SELECT c.*,r.Prenom, r.Nom FROM cake as c 
                INNER JOIN resident_tbl as r ON c.idResident = r.id
                WHERE year(dateLivraison) = :annee
                  AND month(dateLivraison) = :mois
                  AND c.enabled = 1
                ORDER BY dateLivraison ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'annee' => $annee,
             'mois' => $mois
        ]);

        return $stmt->fetchall();
    }

    public function insert($data)
    {
        $cakeData = [
        'idResident'       => $data['idResident'],
        'dateAnniversaire' => $data['dateAnniversaire'],
        'dateLivraison'    => $data['dateLivraison'],
        'message'          => $data['message'],
        'couleur'          => $data['couleur'],
        'observation'      => $data['observation'],
        'annee'            => $data['annee'],
    ];
        $sql = "INSERT INTO cake
            (idResident, dateAnniversaire, dateLivraison,
             message, couleur, observation, enabled, annee)
            VALUES
            (:idResident, :dateAnniversaire, :dateLivraison,
             :message, :couleur, :observation, 1, :annee)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($cakeData);
        // 2️⃣ Récupérer l'id du gâteau créé
    $idCake = $this->pdo->lastInsertId();

    // 3️⃣ Mettre à jour anniversaire_tbl
    $sql = "UPDATE anniversaire_tbl
            SET idCakeOrder = :idCake
            WHERE id = :idAnniversaire";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        'idCake'          => $idCake,
        'idAnniversaire'  => $data['idAnniversaire']
    ]);

    return $idCake;
    }
    public function findForPdf(int $idCake)
    {
        $sql = "
            SELECT r.Prenom, r.Nom, r.Anniversaire,
                c.dateAnniversaire, c.dateLivraison, c.message, c.observation, c.couleur
            FROM cake c
            INNER JOIN resident_tbl r ON r.id = c.idResident
            WHERE c.id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $idCake]);
        return $stmt->fetch();
    }


    public function existsForResidentAndYear(int $idResident, int $annee): bool
    {
        $sql = "
            SELECT id
            FROM cake
            WHERE enabled = 1
            AND annee = :annee
            AND idResident = :idResident
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'annee'      => $annee,
            'idResident' => $idResident
        ]);

        return (bool) $stmt->fetchColumn();
    }
    


}
