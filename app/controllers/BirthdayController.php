<?php

class BirthdayController
{
    public function index()
    {
        $token = $_SESSION['token'] ?? Auth::generateToken();
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
    public function saveCall(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        $respond = static function (int $status, string $message): void {
            http_response_code($status);
            echo json_encode(['message' => $message], JSON_UNESCAPED_UNICODE);
        };
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Allow: POST');
            $respond(405, 'Méthode non autorisée.');
            return;
        }
        $userId = (int)($_SESSION['user']['id'] ?? 0);
        if (!$userId) {
            $respond(401, 'Veuillez vous reconnecter.');
            return;
        }
        $token = $_POST['token'] ?? '';
        if (!is_string($token) || !Auth::checkToken($token)) {
            $respond(403, 'Session expirée. Rechargez la page après avoir conservé votre saisie.');
            return;
        }
        $birthdayId = filter_var($_POST['id_anniversaire'] ?? null, FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]);
        $numero = $_POST['numero'] ?? '';
        $etat = $_POST['etat'] ?? '';
        if (!$birthdayId || !is_string($numero) || !is_string($etat)
            || !in_array($etat, Config::options()['EtatAppel'], true)) {
            $respond(422, 'Sélectionnez un anniversaire, un numéro et un état valides.');
            return;
        }
        $numero = trim($numero);
        $resident = (new BirthdayModel())->getById($birthdayId);
        if (!$resident || (int)($resident['enabled'] ?? 0) !== 1) {
            $respond(404, 'Anniversaire introuvable.');
            return;
        }
        if (!in_array($numero, CallLogModel::phoneNumbers($resident), true)
            || strlen($numero) > 255) {
            $respond(422, 'Le numéro doit appartenir aux numéros enregistrés du résident.');
            return;
        }
        $timezone = new DateTimeZone('America/Halifax');
        $dateRappel = null;
        if ($etat === 'À rappeler') {
            $raw = $_POST['date_rappel'] ?? '';
            $date = is_string($raw)
                ? DateTimeImmutable::createFromFormat('!Y-m-d\TH:i', $raw, $timezone) : false;
            if (!$date || $date->format('Y-m-d\TH:i') !== $raw) {
                $respond(422, 'Indiquez une date et une heure de rappel valides.');
                return;
            }
            $dateRappel = $date->format('Y-m-d H:i:s');
        }
        try {
            $data = [
                'anniversaire' => $birthdayId,
                'user' => $userId,
                'date_appel' => (new DateTimeImmutable('now', $timezone))->format('Y-m-d H:i:s'),
                'etat' => $etat,
                'numero' => $numero,
                'date_rappel' => $dateRappel,
                // La modale est toujours ouverte depuis l’événement enregistré.
                'controller' => self::class,
                'method' => 'edit',
                'view' => 'birthday/edit.php',
            ];
            $logId = (new CallLogModel())->insert($data);
            http_response_code(201);
            echo json_encode(['message' => 'Appel enregistré.', 'log' => [
                'Id' => $logId, 'date_appel' => $data['date_appel'], 'Etat' => $etat,
                'numero' => $numero, 'date_rappel' => $dateRappel,
                'id_user' => $userId, 'user_name' => $_SESSION['user']['login'] ?? (string)$userId,
            ]], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            error_log('Enregistrement appel anniversaire : ' . $e->getMessage());
            $respond(500, 'Impossible d’enregistrer l’appel. Veuillez réessayer.');
        }
    }

    public function callHistory(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            header('Allow: GET');
            http_response_code(405);
            echo json_encode(['message' => 'Méthode non autorisée.']);
            return;
        }
        if (!Auth::check()) {
            http_response_code(401);
            echo json_encode(['message' => 'Veuillez vous reconnecter.']);
            return;
        }
        $id = filter_var($_GET['id_anniversaire'] ?? null, FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]);
        $birthday = $id ? (new BirthdayModel())->getById($id) : false;
        if (!$birthday || (int)($birthday['enabled'] ?? 0) !== 1) {
            http_response_code(404);
            echo json_encode(['message' => 'Anniversaire introuvable.']);
            return;
        }
        echo json_encode(['logs' => (new CallLogModel())->getByBirthday($id)], JSON_UNESCAPED_UNICODE);
    }

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
        $idBirthday = $model->insertBirthday($data);
        $_SESSION['birthday_call_after_save'] = $idBirthday;
        header('Location: /birthday/edit?' . http_build_query([
            'idBirthday' => $idBirthday, 'mois' => (int)$mois, 'annee' => (int)$annee,
        ]));
        exit;
    }
    //************************************************************************************************** */
    public function edit()
    {
         $token = Auth::generateToken();
        $idBirthday = (int)($_GET['idBirthday'] ?? 0);
        $mois = (int)($_GET['mois'] ?? date('m'));
        $annee = (int)($_GET['annee'] ?? date('Y'));
        $jour = (int)($_GET['jour'] ?? date('d'));

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
        $model = new CakeModel();
        $cake = !empty($birthday['idCakeOrder'])
            ? $model->findByIdCake((int)$birthday['idCakeOrder']) : false;
        if (!$cake) {
            $cake = $model->findByResidentAndYear($birthday['id_resident'], $annee);
        }

         if ($cake) {
            $birthday['cake'] = $cake['enabled'] ? 1 : 0;
        } else {
            $birthday['cake'] = 0;
        }
        $openCallModal = (int)($_SESSION['birthday_call_after_save'] ?? 0) === $idBirthday;
        if ($openCallModal) unset($_SESSION['birthday_call_after_save']);
        $callLogs = (new CallLogModel())->getByBirthday($idBirthday);

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

        $token = $_POST['token'] ?? '';
        if (!is_string($token) || !Auth::checkToken($token)) {
            http_response_code(403);
            exit('Token CSRF invalide');
        }
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]);

        if (!$id) {
            http_response_code(400);
            exit('ID invalide');
        }

        $model = new BirthdayModel();
        $model->softDelete($id);

        // Redirection vers la liste mensuelle
        $mois = filter_var($_POST['mois'] ?? date('m'), FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1, 'max_range' => 12]]) ?: (int)date('m');
        $annee = filter_var($_POST['annee'] ?? date('Y'), FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1, 'max_range' => 9999]]) ?: (int)date('Y');
        header('Location: /birthday?' . http_build_query(['mois' => $mois, 'annee' => $annee]));
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
        $pdf->TableRow('Motif de l evenement:', $row['motif'] ?? '', 50, 140);

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
    public function telByDefault()
    {
       //recuperer les GET
        $id_resident = (int)($_GET['id'] ?? 0);
        $tel = (int)($_GET['tel'] ?? 0);
        $year = (int)($_GET['year'] ?? date('Y'));
        $month = (int)($_GET['month'] ?? date('m'));
        $day = (int)($_GET['day'] ?? date('d'));

        if (!$id_resident || !$tel) {
            die("Paramètres invalides");
        }
        $model = new residentModel();
        $model->makeTelDefault($id_resident, $tel);

        header("Location: /birthday/create?id_resident=$id_resident&annee=$year&mois=$month&jour=$day");
        exit;

    }
    public function telByDefaultCreate()
    {
       //recuperer les GET
        $id_resident = (int)($_GET['id'] ?? 0);
        $tel = (int)($_GET['tel'] ?? 0);
        $year = (int)($_GET['year'] ?? date('Y'));
        $month = (int)($_GET['month'] ?? date('m'));
        $day = (int)($_GET['day'] ?? date('d'));
        $idBirthday = (int)($_GET['idBirthday'] ?? 0);

        if (!$id_resident || !$tel || !$idBirthday) {
            die("Paramètres invalides");
        }
        $model = new ResidentModel();
        $model->makeTelDefault($id_resident, $tel);

        header("Location: /birthday/edit?idBirthday=$idBirthday&annee=$year&mois=$month");
        exit;

    }
    public function birthdayList()
    {
        $model = new BirthdayModel();

        // Récupérer tous les résidents avec leur anniversaire
        $residents = $model->getBirthdayList();

        require __DIR__ . '/../views/birthday/birthday_list.php';
    }
    //************************************************************************************************** */
public function birthdayListPrint()
    {
        $model = new BirthdayModel();

        // Récupérer la liste complète des résidents avec leurs anniversaires
        $residents = $model->getBirthdayList();

        // Vue imprimable
        require __DIR__ . '/../views/birthday/birthday_list_print.php';
    }
}
