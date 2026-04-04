<?php
class ResidentController extends Controller
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
    public function dietetique(int $id): void
    {
        //veridsi il y a un nouveaui resident selectionné
        if(isset($_POST['idResident']))
            {
                $id=(int)$_POST['idResident'];
            }
            // Récupération des données du résident
        $model = new ResidentModel();
        $resident = $model->findDietById($id);
        $residentList = $model->getAll();

        if (!$resident) {
            header("Location: /residents");
            exit;
        }
        $options = require APP_PATH . '/config/options.php';
        $jsonPath = dirname(__DIR__, 2) . '/storage/data/intolerances.json';
        $intolerances = json_decode(file_get_contents($jsonPath), true);
        $allergiesPath = dirname(__DIR__, 2) . '/storage/data/allergies.json';
        $allergies = json_decode(file_get_contents($allergiesPath), true);

        $this->render('residents/dietetique', [
            'resident' => $resident,
            'options' => $options,
            'intolerances' => $intolerances,
            'allergies' => $allergies,
            'residentList' => $residentList
        ]);
    }
    public function updateDietetique(): void
    {
        
        // Intolerances
        if (!empty($_POST['Intolerance'])) {
            $data['Intolerance'] = implode(', ', $_POST['Intolerance']);
        } else {
            $data['Intolerance'] = null;
        }

        // Allergies
        if (!empty($_POST['Allergie'])) {
            $data['Allergie'] = implode(', ', $_POST['Allergie']);
        } else {
            $data['Allergie'] = null;
        }

        $model = new ResidentModel();
        $id = (int)$_POST['id'];

        $fields = [
            'Diabet',
            'LieuRepas',
            'Juice',
            'Prune',
            'Thickened',
            'Consistance',
            'Milk',
            'Lactose',
            'Intolerance',
            'Allergie',
            'Tartinade'
        ];

        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $_POST[$field] ?? null;
        }

        $model->updateDietetique($id, $data);

        header("Location: /resident/dietetique/$id");
        exit;
    }
    //*******************************************************************************
    // ****************************************************************************** */
    public function printFicheDietetique(int $id): void
    {
        $model = new ResidentModel();
        $resident = $model->findDietById($id);

        if (!$resident) {
            header("Location: /residents");
            exit;
        }
        //require_once __DIR__ . '/../../fpdf/fpdf.php';
        require_once __DIR__ . '/../../app/services/residentPdf.php';
        $logoConfig = Config::get('logo');
        $logoFilename = $logoConfig['filename'] ?? null;

        $logoPath = $logoFilename
            ? ROOT_PATH . '/public/assets/images/' . $logoFilename
            : null;

        $pdf = new ResidentPDF($logoPath);
        $pdf->AddPage();
        $pdf->Ln(7);

        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(0, 8, 'Nom : ' . f8($resident['Prenom'] . ' ' . $resident['Nom']), 0, 1);
        $pdf->Cell(0, 8, 'Chambre : ' . f8($resident['Chambre']), 0, 1);
        $pdf->Ln(5);

        // ===============================
        // 🔝 PARTIE HAUT : PREFERENCES
        // ===============================

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, 'Preferences Alimentaires', 0, 1);
        $pdf->Ln(3);

        $pdf->SetFont('Arial', '', 12);
        //tableaux
        $pdf->TableRow4('Juice:', f8($resident['Juice']), 'Prune:', f8($resident['Prune']));
        $pdf->TableRow4('Milk:', f8($resident['Milk']), 'Pain:', f8($resident['Bread']));
        $pdf->TableRow4('Tartinade:', f8($resident['Tartinade']), 'Cereale:', f8($resident['Cereale']));
        $pdf->TableRow4('Proteine:', f8($resident['Proteine']), 'Fruit:', f8($resident['Fruit']));
        $pdf->TableRow4('Breuvage Breakfast:', f8($resident['Breuvage_dej']), 'Breuvage Dinner:', f8($resident['Breuvage_din']));
        $pdf->TableRow4('Breuvage Souper:    ', f8($resident['Breuvage_sou']), '', '');

        $pdf->Ln(10);

        // ===============================
        // 🔽 PARTIE BAS : DIETETIQUE
        // ===============================

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, 'Informations Dietetiques', 0, 1);
        $pdf->Ln(3);

        $pdf->SetFont('Arial', '', 12);

        $pdf->TableRow4('Diabetique:', f8($resident['Diabet']), 'Lieu repas:', f8($resident['LieuRepas']));
        $pdf->TableRow4('Consistance:', f8($resident['Consistance']), 'Thickened:', f8($resident['Thickened']));
        $pdf->TableRow4('Lactose:', f8($resident['Lactose']), '', '');

        $pdf->Ln(5);

        // Allergies et Intolerances en MultiCell (plus long)
        $pdf->MultiCell(0, 8, 'Allergies : ' . f8($resident['Allergie']));
        $pdf->Ln(2);
        $pdf->MultiCell(0, 8, 'Intolerances : ' . f8($resident['Intolerance']));

        $pdf->Output('I', 'Fiche_' . f8($resident['Prenom']) . '.pdf');
    }
    public function informations(int $id): void
    {
        if ($id === null) {
        header("Location: /residents");
        exit;
    }
        $model = new ResidentModel();
        $resident = $model->findById($id);

        if (!$resident) {
            header("Location: /residents");
            exit;
        }

        require __DIR__ . '/../views/residents/informations.php';
    }
    public function telByDefault()
    {
        $id = (int)($_GET['id'] ?? 0);
        $tel = (int)($_GET['tel'] ?? 0);
    
        if (!$id || !$tel) {
            die("Données manquantes ou invalides");
        }

        $model = new ResidentModel();
        $model->makeTelDefault($id, $tel);

        header("Location: /resident/informations/$id");
        exit;
    }
    public function telByDefaultEdit()
    {
        $id = (int)($_GET['id'] ?? 0);
        $tel = (int)($_GET['tel'] ?? 0);
    
        if (!$id || !$tel) {
            die("Données manquantes ou invalides");
        }

        $model = new ResidentModel();
        $model->makeTelDefault($id, $tel);

        header("Location: /resident/edit/$id");
        exit;
    }
    public function restriction()
    {

        $model = new ResidentModel();

        // 🔹 liste des résidents actifs
        $residents = $model->getAllEnabled();

        // 🔹 id depuis GET ou défaut = premier
        $id = (int)($_GET['id'] ?? 0);

        if ($id === 0 && !empty($residents)) {
            $id = $residents[0]['Id']; // 🔥 premier résident
        }

        $resident = $model->findById($id);

        require __DIR__ . '/../views/residents/restriction.php';
    }
   public function getDictionary()
    {
        $type = $_GET['type'] ?? '';

        $map = [
            'ingredient'  => __DIR__ . '/../../storage/data/ingredients.json',
            'intolerance' => __DIR__ . '/../../storage/data/intolerances.json',
            'allergie'    => __DIR__ . '/../../storage/data/allergies.json',
            'drink'       => __DIR__ . '/../../storage/data/drinks.json',
        ];

        if (!isset($map[$type]) || !file_exists($map[$type])) {
            echo json_encode([]);
            return;
        }

        $json = json_decode(file_get_contents($map[$type]), true);

        $result = [];

        // 🔥 FLATTEN JSON
        array_walk_recursive($json, function($item) use (&$result){
            if (is_string($item)) {
                $result[] = $item;
            }
        });

        // 🔥 enlever doublons + trier
        $result = array_unique($result);
        sort($result);

        echo json_encode(array_values($result));
    }
    public function suggest()
    {
        $type = $_GET['type'] ?? '';
        $term = trim($_GET['term'] ?? '');

        $map = [
            'ingredient'  => __DIR__ . '/../../storage/data/ingredients.json',
            'intolerance' => __DIR__ . '/../../storage/data/intolerances.json',
            'allergie'    => __DIR__ . '/../../storage/data/allergies.json',
            'drink'       => __DIR__ . '/../../storage/data/drinks.json',
        ];

        if (!isset($map[$type]) || !file_exists($map[$type])) {
            echo json_encode([]);
            return;
        }

        $json = json_decode(file_get_contents($map[$type]), true);

        $allItems = [];

        array_walk_recursive($json, function ($item) use (&$allItems) {
            if (is_string($item)) {
                $allItems[] = trim($item);
            }
        });

        $allItems = array_values(array_unique(array_filter($allItems)));

        if ($term !== '') {
            $allItems = array_values(array_filter($allItems, function ($item) use ($term) {
                return stripos($item, $term) !== false;
            }));
        }

        natcasesort($allItems);

        echo json_encode(array_slice(array_values($allItems), 0, 15));
    }
    public function updateRestriction()
    {
        $id     = (int)($_POST['id'] ?? 0);
        $field  = $_POST['field'] ?? '';
        $value  = trim($_POST['value'] ?? '');
        $action = $_POST['action'] ?? '';

        $allowed = ['Allergie', 'Intolerance', 'ingredient'];

        if (!$id || !in_array($field, $allowed, true) || $value === '') {
            echo json_encode(['success' => false, 'message' => 'Données invalides']);
            return;
        }

        $model = new ResidentModel();
        $current = (string)$model->getResidentInfoByField($field, $id);
        $items = array_filter(array_map('trim', explode(',', $current)));

        if ($action === 'add') {
            $exists = false;
            foreach ($items as $item) {
                if (mb_strtolower($item) === mb_strtolower($value)) {
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                $items[] = $value;
            }
        }
        if ($action === 'remove') {
            $items = array_filter($items, function($item) use ($value) {
                return mb_strtolower($item) !== mb_strtolower($value);
            });
        }

        $newValue = implode(',', $items);
        $model = new ResidentModel();
        $ok = $model->updateRestriction($field, $newValue, $id  );
        echo json_encode([
            'success' => $ok,
            'saved' => $newValue
        ]);
    }
    public function updateDrink()
    {
        $id     = (int)($_POST['id'] ?? 0);
        $field  = $_POST['field'] ?? '';
        $value  = trim($_POST['value'] ?? '');
        $action = $_POST['action'] ?? '';

        $allowed = ['Drink_breakfast', 'Drink_lunch', 'Drink_dinner'];

        if (!$id || !in_array($field, $allowed, true) || $value === '') {
            echo json_encode(['success' => false, 'message' => 'Données invalides']);
            return;
        }

        $model = new ResidentModel();
        $current = (string)$model->getResidentInfoByField($field, $id);
        $items = array_filter(array_map('trim', explode(',', $current)));

        if ($action === 'add') {
            $exists = false;
            foreach ($items as $item) {
                if (mb_strtolower($item) === mb_strtolower($value)) {
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                $items[] = $value;
            }
        }
        if ($action === 'remove') {
            $items = array_filter($items, function($item) use ($value) {
                return mb_strtolower($item) !== mb_strtolower($value);
            });
        }
        $newValue = implode(',', $items);
        $model = new ResidentModel();
        $ok = $model->updateDrink($field, $newValue, $id  );
        echo json_encode([
            'success' => $ok,
            'saved' => $newValue
        ]);
    }
        public function addDictionary()
    {
        $value = trim($_POST['value'] ?? '');
        $type = $_POST['type'] ?? '';   
        if ($value == "") {
            echo json_encode(['success'=>false]);
            return;
        }
        $model = new ResidentModel();
        $res = $model->addDictionary($type, $value);
        echo json_encode($res);
    }
    public function drinks()
    {
        $model = new ResidentModel();

        $residents = $model->getAllEnabled();
        $id = (int)($_GET['id'] ?? ($residents[0]['Id'] ?? 0));
        $resident = $model->findById($id);

        require __DIR__ . '/../views/residents/drinks.php';
    }
    public function getDrinks()
    {
        $file = __DIR__ . '/../../storage/data/drinks.json';

        if (!file_exists($file)) {
            echo json_encode([]);
            return;
        }

        $data = json_decode(file_get_contents($file), true);

        $flat = [];

        $iterator = function($arr) use (&$flat, &$iterator) {
            foreach ($arr as $v) {
                if (is_array($v)) {
                    $iterator($v);
                } else {
                    $flat[] = $v;
                }
            }
        };

        $iterator($data);

        echo json_encode($flat);
    }
    public function edit_drinks()
    {
        $model = new ResidentModel();
        $drinks = $model->allDrinks();

        require __DIR__ . '/../views/residents/edit_drinks.php';
    }
    public function unlike_meal()
    {
        $model = new ResidentModel();
        $residents = $model->getAllEnabled();
        $id = (int)($_GET['id'] ?? ($residents[0]['Id'] ?? 0));
        $resident = $model->findById($id);

        require __DIR__ . '/../views/residents/unlike_meal.php';
        
    }
    public function getMeals()
    {
        $model = new MealModel();
        $meals = $model->get_Meals();
        echo json_encode($meals);
    }
    public function updateUnlikeMeal()
    {
        $id = (int)($_POST['id'] ?? 0);
        $meal = trim($_POST['value'] ?? '');
        $action = $_POST['action'] ?? '';

        if (!$id || $meal === '') {
            echo json_encode(['success' => false, 'message' => 'Données invalides']);
            return;
        }

        $model = new ResidentModel();
        $current = (string)$model->getResidentInfoByField('Unlike_meal', $id);
        $items = array_filter(array_map('trim', explode(',', $current)));

        if ($action === 'add') {
            $exists = false;
            foreach ($items as $item) {
                if (mb_strtolower($item) === mb_strtolower($meal)) {
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                $items[] = $meal;
            }
        }
        if ($action === 'remove') {
            $items = array_filter($items, function($item) use ($meal) {
                return mb_strtolower($item) !== mb_strtolower($meal);
            });
        }

        $newValue = implode(',', $items);
        $ok = $model->updateUnlikeMeal($newValue, $id);
        echo json_encode([
            'success' => $ok,
            'saved' => $newValue
        ]);
    }
    public function suggestMeal()
    {
        header('Content-Type: application/json');

        $term = $_GET['term'] ?? '';

        $model = new MealModel();
        $all = $model->get_Meals();

        $filtered = array_filter($all, function($m) use ($term) {
            return stripos($m, $term) !== false;
        });

        echo json_encode(array_values($filtered));
        exit;
    }
    public function resident_menu()
    {
        global $pdo;

        date_default_timezone_set('America/Moncton');

        $xdate  = $_GET['date'] ?? date('Y-m-d');
        $target = new DateTime($xdate);
        $day    = $target->format('l');

        $cycle = MenuCycle::getSeasonAndWeek($xdate);
        $cycleYear = $cycle['year'];

        $menuModel = new MenuModel($pdo);
        $residentModel = new ResidentModel($pdo);

        $menu = null;

        // PRIORITÉ MENU UNIQUE
        $uniqueMenu = $menuModel->getUniqueMenuForDate($xdate);

        if ($uniqueMenu) {
            $menu   = $uniqueMenu;
            $saison = $cycle['season'];
            $week   = null;
        } else {
            $saison = $cycle['season'];
            $week   = $cycle['week'];

            if ($week !== null) {
                $menu = $menuModel->getBaseMenu(
                    $saison,
                    $week,
                    $day,
                    $cycleYear
                );
            }
        }

        // RESIDENTS
        $residents = $residentModel->getEnabledResidents();
        foreach ($residents as &$r) {

            $unlikes = array_map('trim', explode(',', (string)($r['Unlike_meal'] ?? '')));
            $ingredients = array_map('trim', explode(',', (string)($r['ingredient'] ?? '')));

            $r['Breakfast_final'] = $this->adaptMeal($menu['breakfast'] ?? '', $unlikes, $ingredients);
            $r['Lunch_final']     = $this->adaptMeal($menu['lunch'] ?? '', $unlikes, $ingredients);
            $r['Dinner_final']    = $this->adaptMeal($menu['dinner'] ?? '', $unlikes, $ingredients);
        }
        unset($r);
        require __DIR__ . '/../views/residents/resident_menu.php';
    }
    private function normalizeText($text)
{
    $text = mb_strtolower((string)$text, 'UTF-8');
    $text = preg_replace('/\([^)]*\)/u', ' ', $text);
    $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
    $text = preg_replace('/\s+/u', ' ', $text);
    return trim($text);
}

private function textToWords($text)
{
    $text = $this->normalizeText($text);
    if ($text === '') {
        return [];
    }
    return preg_split('/\s+/u', $text);
}

private function matchUnlike($part, $unlikes)
{
    $partWords = $this->textToWords($part);

    foreach ($unlikes as $u) {

        $uWords = $this->textToWords($u);

        if (empty($uWords)) {
            continue;
        }

        foreach ($uWords as $w) {

            if ($w === '') continue;

            if (in_array($w, $partWords, true)) {
                return true; // ✔ un seul mot suffit
            }
        }
    }

    return false;
}

private function matchIngredient($part, $ingredients)
{
    $partClean = $this->normalizeText($part);

    foreach ($ingredients as $ing) {

        $ingClean = $this->normalizeText($ing);
        //var_dump($partClean, $ingClean); die; // 👈 ici

        if ($ingClean === '') continue;

        if (mb_strpos($partClean, $ingClean) !== false) {
            return true;
        }
    }

    return false;
}

private function adaptMeal($meal, $unlikes, $ingredients)
{
    //var_dump($ingredients); die; // 👈 ici
    $parts = array_map('trim', explode(',', (string)$meal));
    $result = [];

    foreach ($parts as $part) {
        if ($part === '') {
            continue;
        }

        $replace =
            $this->matchUnlike($part, $unlikes) ||
            $this->matchIngredient($part, $ingredients);

        $result[] = $replace ? '#(' . $part . ')#' : $part;
    }

    return implode(', ', $result);
}
}
