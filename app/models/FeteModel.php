<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';
class FeteModel
{
    private $pdo;
    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }
    public function FeteList($mois, $annee)
    {
        $sql = "SELECT a.*,r.id as idResident, r.Prenom, r.Nom FROM anniversaire_tbl as a 
                LEFT JOIN resident_tbl as r ON a.id_resident = r.id
                WHERE year(`date`) = :annee
                  AND month(`date`) = :mois
                  AND a.enabled = 1
                ORDER BY `date` ASC;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'annee' => $annee,
             'mois' => $mois
        ]);

        return $stmt->fetchall();
    }

    public function residentList()
    {
        $sql = "SELECT *  from Resident_tbl
                WHERE enabled = 1
                ORDER BY Prenom ASC;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchall();
    }
    public function insertFete($data)
    {
       $feteData = [
        'id_resident'   => $data['id_resident'],
        'motif'         => $data['motif'],
        'pax'           => $data['pax'],
        'date'          => $data['date'],
        'heure'         => $data['heure'],
        'observation'   => $data['observation'],
        'commentaires'  => $data['commentaires'],
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
    $stmt->execute($feteData);
    }
    public function detailsFete($id)
    {
        $sql = "SELECT * FROM anniversaire_tbl
                WHERE id = :id
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' =>$id]);
        return $stmt->fetch();
    }
     public function deleteFete($id)
    {
        $sql = "update anniversaire_tbl 
                set enabled = 0 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' =>$id]);
        return $stmt->fetch();
    }
     public function updateFete($data)
    {
       $feteData = [
        'id_fete'       => $data['id_fete'],
        'id_resident'   => $data['id_resident'],
        'motif'         => $data['motif'],
        'pax'           => $data['pax'],
        'date'          => $data['date'],
        'heure'         => $data['heure'],
        'observation'   => $data['observation'],
        'commentaires'  => $data['commentaires'],
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

   $sql = "UPDATE anniversaire_tbl SET
    id_resident   = :id_resident,
    motif         = :motif,
    pax           = :pax,
    date          = :date,
    heure         = :heure,
    observation   = :observation,
    commentaires  = :commentaires,
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

    informations  = :informations,
    disposable    = :disposable,
    enabled       = :enabled,
    rang          = :rang
WHERE id = :id_fete";


    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($feteData);
    }
public function feteByDate($date)
    {
        $sql = "SELECT a.*,r.id as idResident, r.Prenom, r.Nom FROM anniversaire_tbl as a 
                LEFT JOIN resident_tbl as r ON a.id_resident = r.id
                WHERE a.date = :date
                AND a.enabled = 1
                ORDER BY `date` ASC;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'date' => $date
        ]);

        return $stmt->fetchall();
    }
}
