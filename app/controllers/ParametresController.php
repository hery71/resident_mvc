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

                    if ($line === 'xxxxxxx') {
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

}