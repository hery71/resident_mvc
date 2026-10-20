<?php
class CakeController
{
    public function create($idResident, $annee,$idAniversaire)
    {
        $model = new CakeModel();
        // Vérifier si une commande existe déjà
        $cake = $model->findByResidentAndYear($idResident, $annee);
        // Infos résident
        $residentModel = new ResidentModel();
        $resident = $residentModel->findById($idResident);
        $model = new BirthdayModel();
        $fete = $model->getById($idAniversaire);
        $token = Auth::generateToken();
        require __DIR__ . '/../views/cake/create.php';
    }
     public function cake_list_order()
    {
        $mois  = isset($_GET['mois']) ? (int)$_GET['mois'] : (int)date('m');
        $annee = isset($_GET['annee']) ? (int)$_GET['annee'] : (int)date('Y');
        
        $model = new CakeModel();

        $cake = $model->cakeOrderList($mois, $annee);

        $token = Auth::generateToken();
         $moisLabel = [
            1=>'Janvier', 2=>'Février', 3=>'Mars', 4=>'Avril',
            5=>'Mai', 6=>'Juin', 7=>'Juillet', 8=>'Août',
            9=>'Septembre', 10=>'Octobre', 11=>'Novembre', 12=>'Décembre'
        ];

        require __DIR__ . '/../views/cake/cake_list_order.php';
    }
    public function print_cake_list_order()
    {
        $mois  = isset($_GET['mois']) ? (int)$_GET['mois'] : (int)date('m');
        $annee = isset($_GET['annee']) ? (int)$_GET['annee'] : (int)date('Y');
        
        $model = new CakeModel();

        $cake = $model->cakeOrderList($mois, $annee);

        $token = Auth::generateToken();
         $moisLabel = [
            1=>'Janvier', 2=>'Février', 3=>'Mars', 4=>'Avril',
            5=>'Mai', 6=>'Juin', 7=>'Juillet', 8=>'Août',
            9=>'Septembre', 10=>'Octobre', 11=>'Novembre', 12=>'Décembre'
        ];
        require __DIR__ . '/../views/cake/print_cake_list_order.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        if (!Auth::checkToken($_POST['token'] ?? '')) {
            die("Token CSRF invalide");
        }

        $data = [
            'idAnniversaire'   => $_POST['idAnniversaire'],
            'idResident'       => $_POST['idResident'],
            'dateAnniversaire' => $_POST['dateAnniversaire'],
            'dateLivraison'    => $_POST['dateLivraison'],
            'message'          => $_POST['message'],
            'couleur'          => $_POST['couleur'],
            'observation'      => $_POST['observation'],
            'annee'            => $_POST['annee'],
        ];
        $model = new CakeModel();
        $fete = (new BirthdayModel())->getById((int)$data['idAnniversaire']);
        if (!$fete || (int)$fete['id_resident'] !== (int)$data['idResident']) {
            http_response_code(400);
            exit('Anniversaire invalide');
        }
        $model->insert($data);
        header('Location: /birthday/index?' . http_build_query([
            'mois' => (int)$fete['mois'],
            'annee' => (int)$fete['annee'],
        ]));
        exit;
    }
    public function cakeOrderPdf($idCake)
{
    if (!Auth::check()) {
        header("Location: /auth/login");
        exit;
    }
    $OrganisationModel = new OrganisationModel();
    $company = $OrganisationModel->getOrganisation();

    $cakeModel = new CakeModel();
    $row = $cakeModel->findByIdCake((int)$idCake);

    if (!$row) {
        http_response_code(404);
        exit("Commande non trouvée");
    }

    $logoPath = logo_disk_path(); // ← depuis helpers + logo.json

    require __DIR__ . '/../views/cake/cakeOrderPdf.php';
    exit;
}
    public function edit($id = null)
    {
        $id = filter_var($id ?? ($_GET['id'] ?? null), FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]);
        if (!$id) {
            http_response_code(400);
            exit('ID de commande invalide');
        }
        $cakeModel = new CakeModel();
        $cake = $cakeModel->findByIdCake($id);
        if (!$cake) {
            http_response_code(404);
            exit('Commande introuvable');
        }
        $token = Auth::generateToken();
         require __DIR__ . '/../views/cake/edit.php';
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            exit;
        }
        $token = $_POST['token'] ?? '';
        if (!is_string($token) || !Auth::checkToken($token)) {
            http_response_code(403);
            exit('Token CSRF invalide');
        }
        $id = filter_var($_POST['idCake'] ?? null, FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]);
        $model = new CakeModel();
        $cake = $id ? $model->findByIdCake($id) : false;
        if (!$cake) {
            http_response_code(404);
            exit('Commande introuvable');
        }
        $date = $_POST['dateLivraison'] ?? '';
        $parsed = is_string($date) ? DateTimeImmutable::createFromFormat('!Y-m-d', $date) : false;
        if (!$parsed || $parsed->format('Y-m-d') !== $date) {
            http_response_code(422);
            exit('Date de livraison invalide');
        }
        $data = ['id' => $id, 'dateLivraison' => $date];
        foreach (['message', 'couleur', 'observation'] as $field) {
            $value = $_POST[$field] ?? '';
            if (!is_string($value) || mb_strlen($value, 'UTF-8') > 45) {
                http_response_code(422);
                exit('Les champs de la commande sont limités à 45 caractères.');
            }
            $data[$field] = $value;
        }
        $model->update($data);
        header('Location: /birthday/edit?' . http_build_query([
            'idBirthday' => (int)$cake['idAnniversaire'],
            'annee' => (int)$cake['annee'],
            'mois' => (int)date('m', strtotime($cake['Anniversaire'])),
        ]));
        exit;
    }
}
