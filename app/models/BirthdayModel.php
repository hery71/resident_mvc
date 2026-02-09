<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';

class BirthdayModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }

   public function insertBirthday($data)
    {
       $birthdayData = [
        'id_resident'   => $data['id_resident'],
        'motif'         => $data['motif'],
        'pax'           => $data['pax'],
        'date'          => $data['date'],
        'heure'         => $data['heure'],
        'observation'   => $data['observation'] ?? 'NC',
        'commentaires'  => $data['commentaires'] ?? 'NC',
        'lieux'         => $data['lieux'],
        'annee'         => $data['annee'],

        'tea'           => (int)$data['tea'],
        'coffee'        => (int)$data['coffee'],
        'pop'           => (int)$data['pop'],
        'juice'         => (int)$data['juice'],
        'milk'          => (int)$data['milk'],
        'cake'          => (int)$data['cake'],
        'sugar'         => (int)$data['sugar'],
        'saltpepper'    => (int)$data['saltpepper'],
        'water'         => (int)$data['water'],
        'tablecloth'    => (int)$data['tablecloth'],
        'greycenter'    => (int)$data['greycenter'],
        'juiceglass'    => (int)$data['juiceglass'],
        'foamglass'     => (int)$data['foamglass'],
        'plasticdish6'  => (int)$data['plasticdish6'],
        'plasticdish9'  => (int)$data['plasticdish9'],
        'cups'          => (int)$data['cups'],
        'knife'         => (int)$data['knife'],
        'fork'          => (int)$data['fork'],
        'teaspoon'      => (int)$data['teaspoon'],
        'cakeknife'     => (int)$data['cakeknife'],
        'napkin'        => (int)$data['napkin'],
        'trashbag'      => (int)$data['trashbag'],
        'kitchencloth'  => (int)$data['kitchencloth'],
        'informations'  => $data['informations'],
        'disposable'    => (int)$data['disposable'],
        'enabled'       => 1,
        'rang'          => 0
    ];

    $sql = "INSERT INTO anniversaire_tbl (
        id_resident, motif, pax, date, heure, observation, commentaires, lieux, annee,
        tea, coffee, pop, juice, milk, cake, sugar, saltpepper, water,
        tablecloth, greycenter, juiceglass, foamglass,
        plasticdish6, plasticdish9, cups,
        knife, fork, teaspoon, cakeknife, napkin,
        trashbag, kitchencloth,
        informations, disposable, enabled, rang
    ) VALUES (
        :id_resident, :motif, :pax, :date, :heure, :observation, :commentaires, :lieux, :annee,
        :tea, :coffee, :pop, :juice, :milk, :cake, :sugar, :saltpepper, :water,
        :tablecloth, :greycenter, :juiceglass, :foamglass,
        :plasticdish6, :plasticdish9, :cups,
        :knife, :fork, :teaspoon, :cakeknife, :napkin,
        :trashbag, :kitchencloth,
        :informations, :disposable, :enabled, :rang
    )";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($birthdayData);
    }
    public function getById(int $id)
    {
        $sql = "
            SELECT
                a.*,
                r.id AS id_resident,
                r.Nom,
                r.Prenom,
                r.Gender,
                r.Anniversaire,
                month(r.Anniversaire) AS mois 
            FROM anniversaire_tbl a
            LEFT JOIN resident_tbl r ON r.id = a.id_resident
            WHERE a.id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }
    //****************************************************************************************** */
    public function updateBirthday(array $data)
    {
        $birthdayData = [ 
            'idBirthday' => $data['idBirthday'], 

            'id_resident' => $data['id_resident'], 
            'motif' => $data['motif'], 
            'pax' => $data['pax'], 

            'date' => $data['date'], 
            'heure' => $data['heure'], 
            'lieux' => $data['lieux'], 
            'annee' => $data['annee'], 

            'tea' => (int)$data['tea'], 
            'coffee' => (int)$data['coffee'], 
            'pop' => (int)$data['pop'], 
            'juice' => (int)$data['juice'], 
            'milk' => (int)$data['milk'], 

            'cake' => (int)$data['cake'], 
            'sugar' => (int)$data['sugar'], 
            'saltpepper' => (int)$data['saltpepper'], 
            'water' => (int)$data['water'],

            'tablecloth' => (int)$data['tablecloth'], 
            'greycenter' => (int)$data['greycenter'], 
            'juiceglass' => (int)$data['juiceglass'], 
            'foamglass' => (int)$data['foamglass'], 

            'plasticdish6' => (int)$data['plasticdish6'], 
            'plasticdish9' => (int)$data['plasticdish9'], 
            'cups' => (int)$data['cups'], 
            'knife' => (int)$data['knife'], 

            'fork' => (int)$data['fork'], 
            'teaspoon' => (int)$data['teaspoon'], 
            'cakeknife' => (int)$data['cakeknife'], 
            'napkin' => (int)$data['napkin'], 

            'trashbag' => (int)$data['trashbag'], 
            'kitchencloth' => (int)$data['kitchencloth'], 

            'commentaires' => $data['commentaires'] ?? '',
            'observation' => $data['observation'] ?? '',
            'informations' => $data['informations'] ?? '',

            'disposable' => (int)$data['disposable']
            ];
            $sql = "UPDATE anniversaire_tbl SET
            id_resident   = :id_resident,
            motif         = :motif,
            pax           = :pax,

            date          = :date,
            heure         = :heure,
            lieux         = :lieux,
            annee         = :annee,

            tea           = :tea,
            coffee        = :coffee,
            pop           = :pop,
            juice         = :juice,
            milk          = :milk,

            cake          = :cake,
            sugar         = :sugar,
            saltpepper    = :saltpepper,
            water         = :water,

            tablecloth    = :tablecloth,
            greycenter    = :greycenter,
            juiceglass    = :juiceglass,
            foamglass     = :foamglass,

            plasticdish6  = :plasticdish6,
            plasticdish9  = :plasticdish9,
            cups          = :cups,
            knife         = :knife,

            fork          = :fork,
            teaspoon      = :teaspoon,
            cakeknife     = :cakeknife,
            napkin        = :napkin,

            trashbag      = :trashbag,
            kitchencloth  = :kitchencloth,
            
            commentaires  = :commentaires,
            observation  = :observation,
            informations  = :informations,

            disposable    = :disposable
        WHERE id = :idBirthday";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($birthdayData);
    }
    //****************************************************************************************** */
    public function softDelete(int $id)
    {
        $sql = "
            UPDATE anniversaire_tbl
            SET enabled = 0
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
     public function getByMonthAndYear(int $month, int $year)
    {
        $sql = "
            SELECT
            r.id,
            r.Nom,
            r.Prenom,
            r.Anniversaire AS date_naissance,
            DAY(r.Anniversaire) AS jour,
            MONTH(r.Anniversaire) AS mois,
            a.id AS fete_id,
            a.annee,
            a.motif,
            a.enabled,
            c.id AS cake_id
        FROM resident_tbl r
        LEFT JOIN anniversaire_tbl a
            ON a.id_resident = r.id
        AND a.annee = :annee
        AND a.enabled = 1
        AND a.motif = 'Birthday'
        LEFT JOIN cake c
            ON c.idResident = r.id
        AND c.enabled = 1
        AND c.annee = :xannee
        WHERE MONTH(r.Anniversaire) = :mois
        ORDER BY jour ASC, r.Nom ASC

        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'mois'  => $month,
            'annee' => $year,
            'xannee' => $year
        ]);

        return $stmt->fetchAll();
    }
}
