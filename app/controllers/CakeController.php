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
        var_dump($data);
        $model = new CakeModel();
        $model->insert($data);
        header("Location: /birthday");
        exit;
    }
    public function cakeOrderPdf($idCake)
{
    if (!Auth::check()) {
        header("Location: /auth/login");
        exit;
    }

    $model = new CakeModel();
    $row = $model->findForPdf((int)$idCake);

    if (!$row) {
        http_response_code(404);
        exit("Commande non trouvée");
    }

    $logoPath = logo_disk_path(); // ← depuis helpers + logo.json

    require __DIR__ . '/../views/cake/cakeOrderPdf.php';
    exit;
}


}
