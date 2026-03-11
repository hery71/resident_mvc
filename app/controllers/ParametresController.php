<?php

class ParametresController
{
    public function index()
    {

        $model = new ParametresModel();
        $company = $model->getCompanyInfo();

        // Logique pour récupérer les paramètres si nécessaire

        require __DIR__ . '/../views/parametres/index.php';
    }
    public function import()
    {
        $model = new ParametresModel();
        $yearSeason = $model->getExistedSeasonYear();
         $meals = [
            'breakfast' => 'Breakfast',
            'lunch' => 'Lunch',
            'lunch_dessert' => 'Lunch Dessert',
            'dinner' => 'Dinner',
            'dinner_dessert' => 'Dinner Dessert'
        ];
        $rows = [];

        $meals = [
            'breakfast',
            'lunch',
            'lunch_dessert',
            'dinner',
            'dinner_dessert'
        ];

        // ============================
        // 1️⃣ RANGER (RAW → TEXTAREAS)
        // ============================
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['range'])) {

            $raw = trim($_POST['raw_data'] ?? '');

            if ($raw !== '') {

                $lines = explode("\n", $raw);

                $currentBlock = -1;
                $data = [];

                foreach ($lines as $line) {

                    $line = trim($line);

                    if ($line === '') continue;

                    if ($line === 'xxxxxxx;;;;;;;') {
                        $currentBlock++;
                        continue;
                    }

                    if ($currentBlock >= 0) {

                        $week = floor($currentBlock / 5) + 1;
                        $mealIndex = $currentBlock % 5;
                        $meal = $meals[$mealIndex];

                        $cols = explode(';', $line);

                        for ($d = 0; $d < 7; $d++) {
                            if (!empty($cols[$d])) {
                                $data[$week][$d + 1][$meal][] = trim($cols[$d]);
                            }
                        }
                    }
                }

                // Reconstruction vers textareas
                for ($w = 1; $w <= 3; $w++) {
                    foreach ($meals as $meal) {

                        $outputLines = [];

                        if (!empty($data[$w])) {

                            $maxLines = 0;

                            foreach ($data[$w] as $dayData) {
                                $count = count($dayData[$meal] ?? []);
                                if ($count > $maxLines) $maxLines = $count;
                            }

                            for ($i = 0; $i < $maxLines; $i++) {

                                $row = [];

                                for ($d = 1; $d <= 7; $d++) {
                                    $row[] = $data[$w][$d][$meal][$i] ?? '';
                                }

                                $outputLines[] = implode(';', $row);
                            }
                        }

                        $_POST["week{$w}_{$meal}"] = implode("\n", $outputLines);
                    }
                }
            }
        }

        // ============================
        // 2️⃣ PREVIEW (TEXTAREAS → TABLE)
        // ============================
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['preview'])) {

            $data = [];

            for ($w = 1; $w <= 3; $w++) {

                foreach ($meals as $meal) {

                    $field = "week{$w}_{$meal}";
                    $text = trim($_POST[$field] ?? '');

                    if ($text === '') continue;

                    $lines = explode("\n", $text);

                    foreach ($lines as $line) {

                        $cols = explode(';', trim($line));

                        for ($d = 0; $d < 7; $d++) {
                            if (!empty($cols[$d])) {
                                $data[$w][$d + 1][$meal][] = trim($cols[$d]);
                            }
                        }
                    }
                }
            }

            // Construction tableau preview
            $rows[] = [
                'Week','Day',
                'Breakfast','Lunch',
                'Lunch Dessert',
                'Dinner',
                'Dinner Dessert'
            ];

            foreach ($data as $week => $days) {
                foreach ($days as $day => $mealsData) {

                    $rows[] = [
                        $week,
                        $day,
                        implode(', ', $mealsData['breakfast'] ?? []),
                        implode(', ', $mealsData['lunch'] ?? []),
                        implode(', ', $mealsData['lunch_dessert'] ?? []),
                        implode(', ', $mealsData['dinner'] ?? []),
                        implode(', ', $mealsData['dinner_dessert'] ?? [])
                    ];
                }
            }
        }

        require __DIR__ . '/../views/parametres/import.php';
    }
//**************************************************************** */
    public function export()
    {
        //verifier l etat de overwrite
         $overwrite = $_POST['overwrite'] ?? '0';
            if ($overwrite === '1') {
                $model = new ParametresModel();
                $model->disableYearSeason($_POST['annee'], $_POST['saison']);
            }
        $saison = $_POST['saison'] ?? '';
        $annee = $_POST['annee'] ?? '2000';

        if ($saison === '') {
            die("Saison obligatoire.");
        }

        $model = new ParametresModel();
        $model->exportMenus($_POST, $saison, $annee);

        header("Location: /parametres/seasonMenu?saison=" . urlencode($saison));
        exit;
    }
    public function seasonMenu()
    {
        $annee  = $_POST['annee']  ?? date('Y');
        $saison = $_POST['saison'] ?? 'Summer';

         $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
         $meals = [
            'breakfast' => 'Breakfast',
            'lunch' => 'Lunch',
            'lunch_dessert' => 'Lunch Dessert',
            'dinner' => 'Dinner',
            'dinner_dessert' => 'Dinner Dessert'
        ];

        $menus = [];
        if ($saison !== '') {
            $model = new ParametresModel();
            $menus = $model->getSeasonMenus($annee, $saison);
        }
        require __DIR__ . '/../views/parametres/seasonMenu.php';
    }
   public function importSpecial()
{
    $rows = [];

    $meals = ['breakfast','lunch','lunch_dessert','dinner','dinner_dessert'];

    // 1) RANGER : RAW -> 5 textareas (Week 1) + detect type
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['range'])) {

        $raw = trim($_POST['raw_data'] ?? '');

        if ($raw !== '') {

            $hasXmas = (strpos($raw, 'CCCCCCC') !== false);
            $hasNY   = (strpos($raw, 'NNNNNNN') !== false);

            if ($hasXmas && $hasNY) {
                // on garde raw dans textarea + message simple
                $_POST['special_type'] = '';
                // Tu peux remplacer par flash/alert bootstrap plus tard
                die("Erreur: le brut contient CCCCCCC ET NNNNNNN. Importer un seul type à la fois.");
            }
            if (!$hasXmas && !$hasNY) {
                $_POST['special_type'] = '';
                die("Erreur: aucun séparateur détecté (CCCCCCC ou NNNNNNN).");
            }

            $sep = $hasXmas ? 'CCCCCCC' : 'NNNNNNN';
            $_POST['special_type'] = $hasXmas ? 'Christmass' : 'New year';

            $lines = explode("\n", $raw);

            $currentBlock = -1;
            $blocks = []; // [blockIndex][] lines

            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') continue;

                if ($line === $sep) {
                    $currentBlock++;
                    continue;
                }

                if ($currentBlock >= 0) {
                    $blocks[$currentBlock][] = $line;
                }
            }

            // On veut 5 blocs : breakfast..dinner_dessert
            for ($i = 0; $i < 5; $i++) {
                $meal = $meals[$i];
                $_POST["week1_{$meal}"] = isset($blocks[$i]) ? implode("\n", $blocks[$i]) : '';
            }
        }
    }

    // 2) PREVIEW : textareas -> table (Week 1)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['preview'])) {

        $type = $_POST['special_type'] ?? '';
        $data = [];

        foreach ($meals as $meal) {
            $field = "week1_{$meal}";
            $text = trim($_POST[$field] ?? '');
            if ($text === '') continue;

            $lines = explode("\n", $text);

            foreach ($lines as $line) {
                $cols = explode(';', trim($line));
                for ($d = 0; $d < 7; $d++) {
                    if (!empty($cols[$d])) {
                        $data[1][$d + 1][$meal][] = trim($cols[$d]);
                    }
                }
            }
        }

        $rows[] = ['Type','Week','Day','Breakfast','Lunch','Lunch Dessert','Dinner','Dinner Dessert'];

        foreach (($data[1] ?? []) as $day => $mealsData) {
            $rows[] = [
                $type,
                1,
                $day,
                implode(', ', $mealsData['breakfast'] ?? []),
                implode(', ', $mealsData['lunch'] ?? []),
                implode(', ', $mealsData['lunch_dessert'] ?? []),
                implode(', ', $mealsData['dinner'] ?? []),
                implode(', ', $mealsData['dinner_dessert'] ?? []),
                ];
            }
        }

        require __DIR__ . '/../views/parametres/importSpecial.php';
    }

    public function exportSpecial()
    {
        $annee = $_POST['annee'] ?? '';
        $type  = $_POST['special_type'] ?? '';

        if ($annee === '') die("Année obligatoire.");
        if ($type !== 'Christmass' && $type !== 'New year') die("Type obligatoire (Christmass ou New year).");

        $model = new ParametresModel();
        $model->exportSpecialMenus($_POST, $type, $annee);

        header("Location: /parametres/seasonMenu?saison=" . urlencode($type) . "&annee=" . urlencode($annee));
        exit;
    }
    public function jsonProcess()
    {
            require __DIR__ . '/../views/parametres/jsonProcess.php';
        
    }
    public function jsonCheck()
    {
        $checkResultMessage = null;
        $checkResultClass = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_json'])) {

            $input = trim($_POST['json_input']);

            if ($input === '') {
                $checkResultMessage = "Le champ est vide.";
                $checkResultClass = "danger";
            } else {
                json_decode($input);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $checkResultMessage = "JSON valide ✔";
                    $checkResultClass = "success";
                } else {
                    $checkResultMessage = "JSON invalide ❌ : " . json_last_error_msg();
                    $checkResultClass = "danger";
                }
            }
        }
        require __DIR__ . '/../views/parametres/jsonProcess.php';
    }
public function editStartSeasonWeek()
    {
        $message = $_GET['message'] ?? '';
        $message_success='';
        $message_error='';
        switch($message){
            case '0x1':
                $message_error = "Un enregistrement pour l'année et la saison existe déjà.";
                break;
            case '0x2':
                $message_success = "Enregistrement ajouté avec succès.";
                break;
            default:
        }
        $message = $_SESSION['message_error'] ?? '';
        $model = new ParametresModel();
        $startWeeks = $model->getStartSeasonWeeks();
        require __DIR__ . '/../views/parametres/editStartSeasonWeek.php';   
    }
public function deleteStartSeasonWeek()
    {
        if (isset($_GET['id'])) {
            $model = new ParametresModel();
            $model->deleteStartSeasonWeek($_GET['id']);
        }
        header('Location: ' . BASE_URL . '/parametres/editStartSeasonWeek');
        exit;
    }
public function saveStartSeasonWeek()
    {
        $message_error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $annee = $_POST['annee'] ?? '';
            $saison = $_POST['saison'] ?? '';
            $week = $_POST['week'] ?? '';
            //verifier si un enregistrement existe ou non?
             $model = new ParametresModel();
             $exists = $model->checkStartSeasonWeekExists($annee, $saison);
             if ($exists) {
                // Debug: Affiche les données existantes
                 // Si un enregistrement existe déjà pour l'année et la saison, on peut choisir de le mettre à jour ou d'afficher un message d'erreur
                 // Ici, on choisit d'afficher un message d'erreur
                // Si existe, on peut choisir de mettre à jour ou d'afficher un message d'erreur
                $_SESSION['message_error'] ="Un enregistrement pour l'année $annee et la saison $saison existe déjà.";
                header ('Location: ' . BASE_URL . '/parametres/editStartSeasonWeek?message=0x1');
                exit;
            }
             if ($annee !== '' && $saison !== '' && $week !== '') {
                $model = new ParametresModel();
                $model->addStartSeasonWeek($annee, $saison, $week);
                header('Location: ' . BASE_URL . '/parametres/editStartSeasonWeek?message=0x2');
                exit;
            }
        }
        header('Location: ' . BASE_URL . '/parametres/editStartSeasonWeek?message=0x0');
        exit;
    }
}