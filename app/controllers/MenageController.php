<?php
class MenageController
{   
    public function index()
    {
        $annee = $_GET['annee'] ?? date("Y");
        // Charger le modèle StaffModel
        $model = new MenageModel();
        $inspections = $model->inspectionList($annee);

        // Charger la configuration des inspections
        $inspection =  Config::inspection(); 

        require __DIR__ . '/../views/menage/index.php';
    }
    public function create()
        {
            $annee = $_GET['annee'] ?? date("Y");
            // Charger le modèle StaffModel
            $model = new StaffModel();
            $staffs = $model->getAllStaffs();

            require __DIR__ . '/../views/menage/create.php';
        }
    public function save()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                exit;
            }
            $annee = $_POST['annee'] ?? date("Y");
            // Récupérer les données du formulaire
            $data =[
            'type_inspection' => $_POST['type_inspection'],
            'nom' => $_POST['nom'],
            'date' => $_POST['date'],
            'id_staff' => $_POST['id_staff'],
            'observation' => $_POST['observation']
            ];
            $model = new MenageModel();
            $model->createInspection($data);
            headers_sent($file, $line) && die("Headers already sent in $file on line $line");
            header("Location: /menage/index?annee=" . $annee);
            exit();
        }  
    public function delete(){
            $param = isset($_GET['param']) ? $_GET['param']: '0' . date("Y");
            $annee = (int)substr($param, strlen($param)-4,4);
            $id_inspection = (int)substr($param, 0,strlen($param)-4 );
            $model = new MenageModel();
            $model->deleteInspection($id_inspection);
            headers_sent($file, $line) && die("Headers already sent in $file on line $line");
            header("Location: /menage/index?annee=" . $annee);
            exit();
    } 
    public function edit()
        {
            $param = isset($_GET['param']) ? $_GET['param']: '0' . date("Y");
            $annee = (int)substr($param, strlen($param)-4,4);
            $id_inspection = (int)substr($param, 0,strlen($param)-4 );
            // Charger le modèle StaffModel
            $model = new StaffModel();
            $staffs = $model->getAllStaffs();

            require __DIR__ . '/../views/menage/edit.php';
        }  
    public function detail()
        {
            $param = isset($_GET['param']) ? $_GET['param']: '0' . date("Y");
            $annee = (int)substr($param, strlen($param)-4,4);
            $id_inspection = (int)substr($param, 0,strlen($param)-4 );

            $model = new MenageModel();
            $inspection = $model->getInspectionDetailsById($id_inspection);
            $taskS = $model->getTasksByInspectionId($id_inspection);

            require __DIR__ . '/../views/menage/detail.php';
        }
    
}