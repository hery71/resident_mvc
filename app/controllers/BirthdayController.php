<?php

class BirthdayController
{
    public function index()
    {
        $mois  = isset($_GET['mois']) ? (int)$_GET['mois'] : (int)date('m');
        $annee = isset($_GET['annee']) ? (int)$_GET['annee'] : (int)date('Y');

        $model = new BirthdayModel();
        $anniversaires = $model->getByMonthAndYear($mois, $annee);
   

        $moisLabel = [
            1=>'Janvier', 2=>'Février', 3=>'Mars', 4=>'Avril',
            5=>'Mai', 6=>'Juin', 7=>'Juillet', 8=>'Août',
            9=>'Septembre', 10=>'Octobre', 11=>'Novembre', 12=>'Décembre'
        ];

        require __DIR__ . '/../views/birthday/index.php';
    }
    //************************************************************************************************** */
    public function create()
    {
        $token = Auth::generateToken();
        // Données reçues depuis birthday/index.php
        $id_resident = (int)($_GET['id_resident'] ?? 0);
        $annee       = (int)($_GET['annee'] ?? date('Y'));
        $mois        = (int)($_GET['mois'] ?? 0);
        $jour        = (int)($_GET['jour'] ?? 0);

        if (!$id_resident || !$mois || !$jour) {
            die("Paramètres invalides");
        }
        $model = new ResidentModel();
        $resident = $model->findById($id_resident);

        require __DIR__ . '/../views/birthday/create.php';
    }
    //************************************************************************************************** */
    public function save()
    {
       if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        if (!Auth::checkToken($_POST['token'] ?? '')) {
            die("Token CSRF non vxalide");
        }
         $data = [
            'id_resident'   => $_POST['id_resident'],
            'motif'         => $_POST['motif'],
            'pax'           => $_POST['pax'],
            'date'          => $_POST['date'],
            'heure'         => $_POST['heure'],
            'commentaires'  => $_POST['commentaires'] ?? '',
            'informations'  => $_POST['informations'] ?? '',
            'observation'   => $_POST['observation'] ?? '',
            'lieux'         => $_POST['lieux'],
            'annee'         => $_POST['annee'],
            'tea'           => $_POST['tea'] ?? 0,
            'coffee'        => $_POST['coffee'] ?? 0,
            'pop'           => $_POST['pop'] ?? 0,
            'juice'         => $_POST['juice'] ?? 0,
            'milk'          => $_POST['milk'] ?? 0,
            'cake'          => $_POST['cake'] ?? 0,
            'sugar'         => $_POST['sugar'] ?? 0,
            'saltpepper'    => $_POST['saltpepper'] ?? 0,
            'water'         => $_POST['water'] ?? 0,
            'tablecloth'    => $_POST['tablecloth'] ?? 0,
            'greycenter'    => $_POST['greycenter'] ?? 0,
            'juiceglass'    => $_POST['juiceglass'] ?? 0,
            'foamglass'     => $_POST['foamglass'] ?? 0,
            'plasticdish6'  => $_POST['plasticdish6'] ?? 0,
            'plasticdish9'  => $_POST['plasticdish9'] ?? 0,
            'cups'          => $_POST['cups'] ?? 0,
            'knife'         => $_POST['knife'] ?? 0,
            'fork'          => $_POST['fork'] ?? 0,
            'teaspoon'      => $_POST['teaspoon'] ?? 0,
            'cakeknife'     => $_POST['cakeknife'] ?? 0,
            'napkin'        => $_POST['napkin'] ?? 0,
            'trashbag'      => $_POST['trashbag'] ?? 0,
            'kitchencloth'  => $_POST['kitchencloth'] ?? 0,
            'disposable'    => $_POST['disposable'] ?? 0,
            'enabled'       => 1,
            'rang'          => 0
        ];
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];
        $model = new BirthdayModel();
        $model->insertBirthday($data);
        // Redirection vers birthday/index.php
        header("Location: /birthday?mois=$mois&annee=$annee");
        exit;
    }
    //************************************************************************************************** */
    public function edit()
    {
         $token = Auth::generateToken();
        $idBirthday = (int)($_GET['idBirthday'] ?? 0);
        $mois = (int)($_GET['mois'] ?? date('m'));
        $annee = (int)($_GET['annee'] ?? date('Y'));

        if (!$idBirthday) {
            http_response_code(400);
            exit('ID invalide');
        }

        $model = new BirthdayModel();
        $birthday = $model->getById($idBirthday);

        if (!$birthday) {
            http_response_code(404);
            exit('Anniversaire introuvable');
        }

        require __DIR__ . '/../views/birthday/edit.php';
    }
    //************************************************************************************************** */
     public function update()
    {
       if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        if (!Auth::checkToken($_POST['token'] ?? '')) {
            die("Token CSRF non vxalide");
        }
         $data = [
            'id_resident'   => $_POST['id_resident'],
            'idBirthday'       => $_POST['idBirthday'],
            'motif'         => $_POST['motif'],
            'pax'           => $_POST['pax'],
            'date'          => $_POST['date'],
            'heure'         => $_POST['heure'],
            'lieux'         => $_POST['lieux'],
            'annee'         => $_POST['annee'],
            'tea'           => $_POST['tea'] ?? 0,
            'coffee'        => $_POST['coffee'] ?? 0,
            'pop'           => $_POST['pop'] ?? 0,
            'juice'         => $_POST['juice'] ?? 0,
            'milk'          => $_POST['milk'] ?? 0,
            'cake'          => $_POST['cake'] ?? 0,
            'sugar'         => $_POST['sugar'] ?? 0,
            'saltpepper'    => $_POST['saltpepper'] ?? 0,
            'water'         => $_POST['water'] ?? 0,
            'tablecloth'    => $_POST['tablecloth'] ?? 0,
            'greycenter'    => $_POST['greycenter'] ?? 0,
            'juiceglass'    => $_POST['juiceglass'] ?? 0,
            'foamglass'     => $_POST['foamglass'] ?? 0,
            'plasticdish6'  => $_POST['plasticdish6'] ?? 0,
            'plasticdish9'  => $_POST['plasticdish9'] ?? 0,
            'cups'          => $_POST['cups'] ?? 0,
            'knife'         => $_POST['knife'] ?? 0,
            'fork'          => $_POST['fork'] ?? 0,
            'teaspoon'      => $_POST['teaspoon'] ?? 0,
            'cakeknife'     => $_POST['cakeknife'] ?? 0,
            'napkin'        => $_POST['napkin'] ?? 0,
            'trashbag'      => $_POST['trashbag'] ?? 0,
            'kitchencloth'  => $_POST['kitchencloth'] ?? 0,
            'disposable'    => $_POST['disposable'] ?? 0,
            'commentaires'  => $_POST['commentaires'] ?? '',
            'informations'  => $_POST['informations'] ?? '',
            'observation'   => $_POST['observation'] ?? '',
            'enabled'       => 1,
            'rang'          => 0
        ];
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];

        $model = new BirthdayModel();
        $model->updateBirthday($data);

        header("Location: /birthday/index?mois=" . $mois . "&annee=" . $annee);
        exit;
    }
    /**************************************************************************************************** */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Méthode non autorisée');
        }

        $id = (int)($_POST['id'] ?? 0);

        if (!$id) {
            http_response_code(400);
            exit('ID invalide');
        }

        $model = new BirthdayModel();
        $model->softDelete($id);

        // Redirection vers la liste mensuelle
        header("Location: /birthday");
        exit;
    }
    public function printRequisition(int $id): void
    {
        $model = new BirthdayModel();
        $row = $model->findFullById($id); // méthode avec JOIN resident
        $organisationModel = new OrganisationModel();
        $organisation = $organisationModel->getOrganisation();

        if (!$row) {
            header("Location: /birthday");
            exit;
        }

        require_once __DIR__ . '/../../app/services/birthdayRequisitionPdf.php';

        $pdf = new BirthdayRequisitionPDF($organisation,'P', 'mm', 'Letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();

        // ==============================
        // INFORMATIONS RESIDENT
        // ==============================

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, f8('Informations du résident'), 0, 1, 'L');
        $pdf->Ln(3);

        $pdf->TableRow('Date De la fete:', $row['date'] ?? '', 50, 140);
        $pdf->TableRow(
            'Nom:',
            ($row['Prenom'] ?? '') . ' ' .
            ($row['Nom'] ?? '') . ' (' .
            ($row['Anniversaire'] ?? '') . ')',
            50,
            140
        );
        $pdf->TableRow('Heure:', $row['heure'] ?? '', 50, 140);
        $pdf->TableRow('Lieu:', $row['lieux'] ?? '', 50, 140);
        $pdf->TableRow('Pax:', $row['pax'] ?? '', 50, 140);
        $pdf->TableRow('Observation:', $row['observation'] ?? '', 50, 140);
        $pdf->TableRow('Commentaires:', $row['commentaires'] ?? '', 50, 140);
        $pdf->Ln(6);

        // ==============================
        // BOISSONS
        // ==============================

        $boissonOptions = [
            'Tea' => $row['tea'],
            'Coffee' => $row['coffee'],
            'Pop' => $row['pop'],
            'Juice' => $row['juice'],
            'Milk' => $row['milk'],
            'Cake' => $row['cake'],
            'Sugar' => $row['sugar'],
            'Salt & Pepper' => $row['saltpepper'],
            'Water' => $row['water']
        ];

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, f8('Boissons'), 0, 1, 'L');
        $pdf->Ln(3);

        $tableX = ($pdf->GetPageWidth() - 70) / 2;

        foreach ($boissonOptions as $key => $value) {
            $pdf->SetX($tableX);
            $pdf->TableRow($key, $value ? 'X' : '', 50, 20);
        }

        // ==============================
        // MATERIELS
        // ==============================

        $materielsOptions = [
            'Grey Center' => $row['greycenter'],
            'Juice Glass' => $row['juiceglass'],
            'Foam Glass' => $row['foamglass'],
            'Paper Dish 6"' => $row['plasticdish6'],
            'Paper Dish 9"' => $row['plasticdish9'],
            'Cups' => $row['cups'],
            'Knife' => $row['knife'],
            'Fork' => $row['fork'],
            'Teaspoon' => $row['teaspoon'],
            'Cake Knife' => $row['cakeknife'],
            'Napkin' => $row['napkin'],
            'Trash Bag' => $row['trashbag'],
            'Kitchen Cloth' => $row['kitchencloth']
        ];

        $titre = "Materiels et Ustensils";
        if ($row['disposable'] == 1) {
            $titre .= " (**************ALL DISPOSABLES***************)";
        }

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, f8($titre), 0, 1, 'L');
        $pdf->Ln(3);

        foreach ($materielsOptions as $key => $value) {
            $pdf->SetX($tableX);
            $pdf->TableRow($key, $value ? 'X' : '', 50, 20);
        }

        $pdf->Output('I', 'Requisition_Birthday_' . $row['id'] . '.pdf');
    }

}
