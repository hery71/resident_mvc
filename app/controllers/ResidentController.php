<?php
class ResidentController
{
    public function index()
    {
        $model = new ResidentModel();
        // Pagination
        $perPage = 10;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * $perPage;

        // Filtres
        $nom = trim($_GET['nom'] ?? '');
        $prenom = trim($_GET['prenom'] ?? '');

        // Données
        $residents = $model->getPaginated($perPage, $offset, $nom, $prenom);
        $total = $model->countFiltered($nom, $prenom);

        $totalPages = ceil($total / $perPage);

        require __DIR__ . '/../views/residents/index.php';
    }
     public function printIndex()
    {
        $model = new ResidentModel();

        // Pagination
        $perPage = 10;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * $perPage;

        // Filtres
        $nom = trim($_GET['nom'] ?? '');
        $prenom = trim($_GET['prenom'] ?? '');

        // Données
        $residents = $model->getPaginated($perPage, $offset, $nom, $prenom);
        $total = $model->countFiltered($nom, $prenom);

        $totalPages = ceil($total / $perPage);

        require __DIR__ . '/../views/residents/printIndex.php';
    }
    public function edit($id)
    {
        $model = new ResidentModel();
        $resident = $model->findById($id);

        if (!$resident) {
            http_response_code(404);
            die("Résident introuvable");
        }

        require __DIR__ . '/../views/residents/edit.php';
    }
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $model = new ResidentModel();
        $model->update($id, $_POST);

        header("Location: /resident");
        exit;
    }
    public function depart()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $cause = trim($_POST['CauseDepart'] ?? '');
        $date = $_POST['leavedate'] ?? '';

        if (!$id || $cause === '' || $date === '') {
            die("Données manquantes");
        }

        $model = new ResidentModel();
        $model->departResident($id, $cause, $date);

        header("Location: /resident");
        exit;
    }
    public function create()
    {
        $token = Auth::generateToken();
        require __DIR__ . '/../views/residents/create.php';
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
            'Nom'          => trim($_POST['Nom'] ?? ''),
            'Prenom'       => trim($_POST['Prenom'] ?? ''),
            'Anniversaire' => $_POST['Anniversaire'] ?? null,
            'Admission'    => $_POST['Admission'] ?? null,
            'Gender'       => $_POST['Gender'] ?? '',
            'Tel1'         => $_POST['Tel1'] ?? '',
            'Tel2'         => $_POST['Tel2'] ?? '',
            'Tel3'         => $_POST['Tel3'] ?? '',
            'Famille'      => $_POST['Famille'] ?? '',
            'Relation'     => $_POST['Relation'] ?? ''
        ];

        // Validation minimale
        if ($data['Nom'] === '' || $data['Prenom'] === '') {
            die("Nom et prénom requis");
        }

        $model = new ResidentModel();
        $model->insert($data);

        header("Location: /resident");
        exit;
    }
    public function preferenceAlimentaire()
    {
        $options = require __DIR__ . '/../config/options.php';
        $idResident = (int)($_GET['id'] ?? 0);

        $model = new AllergieModel();
        $allergenes = $model->all();

        $model = new ResidentModel();
        $resident = $model->findById($idResident);

        if (!$resident) {
            http_response_code(404);
            die("Résident introuvable");
        }

        require __DIR__ . '/../views/residents/preferenceAlimentaire.php';
    }  
    public function savePreferenceAlimentaire()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
        $idResident = (int)($_POST['idResident'] ?? 0);
        // Champs à mettre à jour
        $fields = ['Bread', 'Tartinade', 'Cereale',
        'Proteine','Fruit', 'Breuvage_dej', 'Breuvage_din', 
        'Breuvage_sou','moremeal','lessmeal','Regime','ModeEating','Allergie'];

         $model = new ResidentModel();
        $data = [];
        foreach ($fields as $field) {

            if (isset($_POST[$field]) && is_array($_POST[$field])) {
                // Champ multiple
                $values = array_filter(array_map('trim', $_POST[$field]));
                $data[$field] = implode(',', $values);
            } else {
                // Champ simple
                $data[$field] = trim($_POST[$field] ?? '');
            }
        }
        $model->updatePreferenceAlimentaire($idResident, $data);
        header("Location: /resident");
        exit;
    }
}
