<?php

class FeteController
{
    public function index()
    {
        $mois  = isset($_GET['mois']) ? (int)$_GET['mois'] : (int)date('m');
        $annee = isset($_GET['annee']) ? (int)$_GET['annee'] : (int)date('Y');

        $model = new FeteModel();
        $fete = $model->feteList($mois, $annee);
   

        $moisLabel = [
            1=>'Janvier', 2=>'Février', 3=>'Mars', 4=>'Avril',
            5=>'Mai', 6=>'Juin', 7=>'Juillet', 8=>'Août',
            9=>'Septembre', 10=>'Octobre', 11=>'Novembre', 12=>'Décembre'
        ];

        require __DIR__ . '/../views/fete/index.php';
    }

     public function create()
    {
        $token = Auth::generateToken();
        $model = new FeteModel();
        $resident = $model->residentList();

        require __DIR__ . '/../views/fete/create.php';
    }
     public function edit()
    {
        $xparam= date('Ym');
        $id_fete  = isset($_GET['id_fete']) ? (int)$_GET['id_fete'] : (int)date('m');
        $parm = isset($_GET['param']) ? $_GET['param'] : $xparam;
        $annee = (int)substr($parm, 0,4);
        $mois  = (int)substr($parm, 4,strlen($xparam)-4);
        
        $token = Auth::generateToken();
        //2 models**************************
        $model = new FeteModel();
        $fete = $model->detailsFete($id_fete);
        $resident = $model->residentList();

        require __DIR__ . '/../views/fete/edit.php';
    }
     public function delete()
    {
        $id_fete  = isset($_GET['id_fete']) ? (int)$_GET['id_fete'] : (int)date('m');
        $mois  = isset($_GET['mois']) ? (int)$_GET['mois'] : (int)date('m');
        $annee = isset($_GET['annee']) ? (int)$_GET['annee'] : (int)date('Y');
        $token = Auth::generateToken();
        //2 models**************************
        $model = new FeteModel();
        $fete = $model->deleteFete($id_fete);

        header("Location: /fete/index?mois=$mois&annee=$annee");
    }
     public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        if (!Auth::checkToken($_POST['token'] ?? '')) {
            die("Token CSRF non valide");
        }

       $data = [
            'id_resident'   => $_POST['id_resident'],
            'motif'         => $_POST['motif'],
            'pax'           => $_POST['pax'],
            'date'          => $_POST['date'],
            'heure'         => $_POST['heure'],
            'commentaires'  => 'NC',
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

            'informations'  => $_POST['informations'] ?? null,
            'disposable'    => $_POST['disposable'] ?? 0,

            'enabled'       => 1,
            'rang'          => 0
        ];
       //var_dump($data);
        $model = new feteModel();
        $model->insertFete($data);
        header("Location: /fete/index");
        exit;
    }
    public function update()
    {
         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        if (!Auth::checkToken($_POST['token'] ?? '')) {
            die("Token CSRF non valide");
        }
         $data = [
            'id_fete'       => $_POST['id_fete'],
            'id_resident'   => $_POST['id_resident'],
            'motif'         => $_POST['motif'],
            'pax'           => $_POST['pax'],
            'date'          => $_POST['date'],
            'heure'         => $_POST['heure'],
            'commentaires'  => 'NC',
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

            'informations'  => $_POST['informations'] ?? '',
            'disposable'    => $_POST['disposable'] ?? 0,

            'enabled'       => 1,
            'rang'          => 0
        ];
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];
    
        $token = Auth::generateToken();
        //2 models**************************
        $model = new FeteModel();
        $fete = $
       $model->updateFete($data);
        header("Location: /fete/index?mois=$mois&annee=$annee");
    }
}
