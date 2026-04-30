<?php
require_once __DIR__ . '/../models/AlimentaireModel.php';
require_once __DIR__ . '/../models/MenuCycle.php';
require_once __DIR__ . '/../models/MenuModel.php';

class MenuController extends Controller
{
    private MenuModel $model;

    public function edit(): void
    {
        $model = new AlimentaireModel();

        // =========================
        // 🔧 Filtres GET
        // =========================
        $saison = $_GET['saison'] ?? 'Winter';
        $annee  = (int)($_GET['annee'] ?? date('Y'));
        $week   = (int)($_GET['week'] ?? 1);
        $day    = $_GET['day'] ?? 'Sunday';

        // =========================
        // 🔎 Retrouver menu
        // =========================
        $menu = $model->getMenuByFilters($saison, $annee, $week, $day);

        if (!$menu) {
            die('Menu introuvable');
        }

        $id_menu = (int)$menu['id'];

        // =========================
        // 🍽 Charger meals
        // =========================
        $breakfastItems     = $model->fetchMealList('menu_breakfast', $id_menu);
        $lunchItems         = $model->fetchMealList('menu_lunch', $id_menu);
        $lunchDessertItems  = $model->fetchMealList('menu_lunch_dessert', $id_menu);
        $dinnerItems        = $model->fetchMealList('menu_dinner', $id_menu);
        $dinnerDessertItems = $model->fetchMealList('menu_dinner_dessert', $id_menu);

        // =========================
        // 📄 Vue
        // =========================
        require __DIR__ . '/../views/alimentaire/menu/edit.php';
    }

    public function save(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /menu/edit');
            exit;
        }

        $model = new AlimentaireModel();

        // =========================
        // 🔐 Sécurité minimale
        // =========================
        $id_menu = (int)($_POST['id_menu'] ?? 0);

        if ($id_menu <= 0) {
            die('ID menu invalide');
        }

        // =========================
        // 💾 Sauvegarde meals
        // =========================
        $model->saveMeals($id_menu, $_POST);

        // =========================
        // 🔁 Redirection avec filtres
        // =========================
        $params = http_build_query([
            'annee'  => $_POST['annee']  ?? date('Y'),
            'saison' => $_POST['saison'] ?? 'Winter',
            'week'   => $_POST['week']   ?? 1,
            'day'    => $_POST['day']    ?? 'Sunday'
        ]);

        header('Location: /menu/edit?' . $params . '&saved=1');
        exit;
    }

    public function dailyMenu()
    {
        global $pdo;

        date_default_timezone_set('America/Moncton');

        // === IDENTIQUE À TON CODE ===
        $xdate  = $_GET['date'] ?? date('Y-m-d');
        $date = new DateTime($xdate);
        $target = new DateTime($xdate);
        $day    = $target->format('l');
        $year   = (int)$target->format('Y');

        $cycle = MenuCycle::getSeasonAndWeek($xdate);

        $cycleYear = $cycle['year'];   // 🔥 année du cycle corrigée

        $menuModel = new MenuModel($pdo);

        $id_unique = 0;
        $menu = null;

        // === PRIORITÉ MENU UNIQUE ===
        $uniqueMenu = $menuModel->getUniqueMenuForDate($xdate);

        if ($uniqueMenu) {
            $menu     = $uniqueMenu;
            $saison   = $cycle['season'];
            $week     = null;
            $id_unique = $uniqueMenu['id'];
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

        // === MESSAGE INFO (inchangé) ===
        $info = "📅 <strong>" . $target->format('l, d F Y') . "</strong> — 
                 Saison : <strong>$saison</strong> — 
                 Semaine : <strong>" . ($week ? "Week $week" : "Unique") . "</strong> — 
                 Jour : <strong>$day</strong> — 
                 Cycle : <strong>$cycleYear</strong> —  
                 Id_base : <strong>" . ($menu['id_menu'] ?? 'N/A') . "</strong> — 
                 Id_Unique : <strong>" . ($uniqueMenu['id'] ?? 'N/A') . "</strong>";

        // === VARIABLES POUR LA VIEW ===
        require __DIR__ . '/../views/alimentaire/menu/daylyMenu.php';
    }
   
    public function weeklyMenu()
    {

        // 🔐 sécurité
        Auth::check();

        // 📅 date sélectionnée
        $startDate = $_GET['date'] ?? date('Y-m-d');
        $start     = new DateTime($startDate);

        // 🔁 dimanche de référence
        $weekStart = clone $start;
        if ($weekStart->format('w') != 0) {
            $weekStart->modify('last sunday');
        }
        

        $weekStartStr = $weekStart->format('Y-m-d');
        $weekEndStr   = (clone $weekStart)->modify('+6 days')->format('Y-m-d');

        // 📊 génération semaine
        $menus = [];

        for ($i = 0; $i < 7; $i++) {

            $current = (clone $weekStart)->modify("+$i day");
            $date    = $current->format('Y-m-d');
            $month   = (int)$current->format('n');
            $dayName = $current->format('l');
            $annee   = (int)$current->format('Y');

            // 🔹 menu unique ?
            $model = new MenuModel();
            $menuSpecial = $model->getSpecialMenuForDate($date);
            //$menuSpecial = MenuModel::getSpecialMenuForDate($pdo, $date);

            if ($menuSpecial) {
                $menus[] = [
                    'date'   => $date,
                    'day'    => $dayName,
                    'saison' => 'Special',
                    'week'   => '-',
                    'menu'   => $menuSpecial
                ];
                continue;
            }else{

                // 🔹 menu normal
                $cycle  = MenuCycle::getSeasonAndWeek($date);
                $saison = $cycle['season'];
                $week   = $cycle['week'];

                if ($week === null) {
                    $menus[] = [
                        'date'   => $date,
                        'day'    => $dayName,
                        'saison' => $saison,
                        'week'   => '-',
                        'menu'   => null
                    ];
                    continue;
                }else{

                    $model = new MenuModel();
                    $menu = $model->getFullMenu($saison, $week, $dayName, $annee);

                    $menus[] = [
                        'date'   => $date,
                        'day'    => $dayName,
                        'saison' => $saison,
                        'week'   => $week,
                        'menu'   => $menu
                    ];
                }
            }
        }
        require __DIR__ . '/../views/alimentaire/menu/weeklyMenu.php';
    }
    public function monthlyMenu()
    {
        $year  = $_GET['annee'] ?? date('Y');
        $month = $_GET['mois']  ?? date('n');
        $monthName = DateHelper::MONTHS_FR[(int)$month];
        $model = new MenuModel();
        $data = $model->getMonthlyMenus((int)$year, (int)$month);
        $data['monthsFr'] = DateHelper::MONTHS_FR;

        $this->render('alimentaire/menu/monthlyMenu', $data);
    }
    public function special(): void
    {
        // 🔹 Filtres
        $annee   = $_GET['annee']   ?? date('Y');
        $special = $_GET['special'] ?? 4; // 4 = Noël, 5 = NY

        $specialLabel = ($special == 4) ? 'Christmas' : 'New Year';

        // 🔹 Menus spéciaux
        $model = new MenuModel();
        $menus_raw = $model->getSpecialMenus((int)$annee, (int)$special);

        // 🔹 Fusion menus + plats
        $menus = [];
        foreach ($menus_raw as $m) {
            $plats = $model->getMealsByMenu((int)$m['id']);
            $menus[] = array_merge($m, $plats);
        }

        // 🔹 Vue
        require dirname(__DIR__) . '/views/alimentaire/menu/special.php';
    }
    public function printDailyMenu()
    {
        global $pdo;

        date_default_timezone_set('America/Moncton');
        $xdate  = $_GET['date'] ?? date('Y-m-d');
        $date = new DateTime($xdate);
        $target = new DateTime($xdate);
        $day    = $target->format('l');
        $year   = (int)$target->format('Y');

        $cycle = MenuCycle::getSeasonAndWeek($xdate);

        $cycleYear = $cycle['year'];   // correction
        $menuModel = new MenuModel($pdo);

        $id_unique = 0;
        $menu = null;

        // === PRIORITÉ MENU UNIQUE ===
        $uniqueMenu = $menuModel->getUniqueMenuForDate($xdate);

        if ($uniqueMenu) {
            $menu     = $uniqueMenu;
            $saison   = $cycle['season'];
            $week     = null;
            $id_unique = $uniqueMenu['id'];
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

        // === MESSAGE INFO (inchangé) ===
        $info = "📅 <strong>" . $target->format('l, d F Y') . "</strong> — 
                 Saison : <strong>$saison</strong> — 
                 Semaine : <strong>" . ($week ? "Week $week" : "Unique") . "</strong> — 
                 Jour : <strong>$day</strong> — 
                 Cycle : <strong>$cycleYear</strong>";

        // === VARIABLES POUR LA VIEW ===
        require __DIR__ . '/../views/alimentaire/menu/printDailyMenu.php';
       
    }

    public function printWeeklyMenu()
    {
        
        // 🔐 sécurité
        Auth::check();

        // 📅 date sélectionnée
        $startDate = $_GET['date'] ?? date('Y-m-d');
        $start     = new DateTime($startDate);

        // 🔁 dimanche de référence
        $weekStart = clone $start;
        if ($weekStart->format('w') != 0) {
            $weekStart->modify('last sunday');
        }

        $weekStartStr = $weekStart->format('Y-m-d');
        $weekEndStr   = (clone $weekStart)->modify('+6 days')->format('Y-m-d');

        // 📊 génération semaine
        $menus = [];

        for ($i = 0; $i < 7; $i++) {

            $current = (clone $weekStart)->modify("+$i day");
            $date    = $current->format('Y-m-d');
            $month   = (int)$current->format('n');
            $dayName = $current->format('l');
            $annee   = (int)$current->format('Y');

            // 🔹 menu unique ?
            $model = new MenuModel();
            $menuSpecial = $model->getSpecialMenuForDate($date);
            //$menuSpecial = MenuModel::getSpecialMenuForDate($pdo, $date);

            if ($menuSpecial) {
                $menus[] = [
                    'date'   => $date,
                    'day'    => $dayName,
                    'saison' => 'Special',
                    'week'   => '-',
                    'menu'   => $menuSpecial
                ];
                continue;
            }else{

                // 🔹 menu normal
                $cycle  = MenuCycle::getSeasonAndWeek($date);
                $saison = $cycle['season'];
                $week   = $cycle['week'];

                if ($week === null) {
                    $menus[] = [
                        'date'   => $date,
                        'day'    => $dayName,
                        'saison' => $saison,
                        'week'   => '-',
                        'menu'   => null
                    ];
                    continue;
                }else{

                    $model = new MenuModel();
                    $menu = $model->getFullMenu($saison, $week, $dayName, $annee);

                    $menus[] = [
                        'date'   => $date,
                        'day'    => $dayName,
                        'saison' => $saison,
                        'week'   => $week,
                        'menu'   => $menu
                    ];
                }
            }
        }
        require __DIR__ . '/../views/alimentaire/menu/printWeeklyMenu.php';
    }
public function printMonthlyMenu()
    {
        $year  = $_GET['annee'] ?? date('Y');
        $month = $_GET['mois']  ?? date('n');
        $monthName = DateHelper::MONTHS_FR[(int)$month];

        $model = new MenuModel();
        $data = $model->getMonthlyMenus((int)$year, (int)$month);
        $data['monthsFr'] = DateHelper::MONTHS_FR;

       $this->render('alimentaire/menu/printMonthlyMenu', $data);
    }
public function printDisplayMonthlyMenu()
    {
        $year  = $_GET['annee'] ?? date('Y');
        $month = $_GET['mois']  ?? date('n');
        $monthName = DateHelper::MONTHS_FR[(int)$month];

        $model = new MenuModel();
        $data = $model->getMonthlyMenus((int)$year, (int)$month);
        $data['monthsFr'] = DateHelper::MONTHS_FR;

       $this->render('alimentaire/menu/printDisplayMonthlyMenu', $data);
    }
public function deleteMeal(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

        $table = $_POST['table'] ?? '';
        $id = (int)($_POST['id'] ?? 0);
         $allowed = [
        'menu_breakfast',
        'menu_lunch',
        'menu_lunch_dessert',
        'menu_dinner',
        'menu_dinner_dessert'
    ];

        if (!in_array($table, $allowed) || $id <= 0) { echo "Invalid data"; exit; }
        $model = new MenuModel();
        $model->deleteMeal($table, $id);
        
       
    }
public function searchMeal()
    {
        require_once __DIR__ . '/../services/SeasonService.php';

        $currentYear = (int)date('Y');

        $selectedYear = isset($_GET['annee']) ? (int)$_GET['annee'] : $currentYear;
        $selectedSeasonName = trim($_GET['saison'] ?? '');
        $years = [];
        for ($y = $currentYear - 5; $y <= $currentYear + 1; $y++) {
            $years[] = $y;
        }

        $seasons = SeasonService::getSeasonsForYear($selectedYear);
        $service = $_GET['service'] ?? 'all';
        $keywordsRaw = trim($_GET['keywords'] ?? '');

        $allowedServices = [
            'all'                  => 'Tous les services',
            'menu_breakfast'       => 'Breakfast',
            'menu_lunch'           => 'Lunch',
            'menu_lunch_dessert'   => 'Lunch Dessert',
            'menu_dinner'          => 'Dinner',
            'menu_dinner_dessert'  => 'Dinner Dessert',
        ];

        if (!array_key_exists($service, $allowedServices)) {
            $service = 'all';
        }

        $results = [];

        if ($keywordsRaw !== '') {
            $menuModel = new MenuModel();

            $keywords = array_filter(array_map('trim', explode('+', $keywordsRaw)));

            if (!empty($keywords)) {
                if ($service === 'all') {
                    $tables = [
                        'menu_breakfast'       => 'Breakfast',
                        'menu_lunch'           => 'Lunch',
                        'menu_lunch_dessert'   => 'Lunch Dessert',
                        'menu_dinner'          => 'Dinner',
                        'menu_dinner_dessert'  => 'Dinner Dessert',
                    ];

                    foreach ($tables as $table => $label) {
                        $rows = $menuModel->searchMealsByKeywords($table, $keywords, $selectedYear, $selectedSeasonName);

                        foreach ($rows as &$row) {
                            $row['service_name'] = $label;
                            $row['service_table'] = $table;
                        }

                        $results = array_merge($results, $rows);
                    }

                    usort($results, function ($a, $b) {
                        return
                            strcmp((string)($b['annee'] ?? ''), (string)($a['annee'] ?? '')) ?:
                            ((int)($b['week'] ?? 0) <=> (int)($a['week'] ?? 0)) ?:
                            strcmp((string)($a['day'] ?? ''), (string)($b['day'] ?? '')) ?:
                            strcmp((string)($a['service_name'] ?? ''), (string)($b['service_name'] ?? '')) ?:
                            strcmp((string)($a['meal'] ?? ''), (string)($b['meal'] ?? ''));
                    });

                } else {
                    $results = $menuModel->searchMealsByKeywords($service, $keywords, $selectedYear, $selectedSeasonName);

                    $label = $allowedServices[$service] ?? $service;

                    foreach ($results as &$row) {
                        $row['service_name'] = $label;
                        $row['service_table'] = $service;
                    }
                }
            }
        }

        $title = 'Recherche de menu';
        require '../app/views/alimentaire/menu/searchMeal.php';
    }

   public function mealCalendar()
    {
        require_once __DIR__ . '/../models/MenuModel.php';
        require_once __DIR__ . '/../services/SeasonService.php';

        $service = $_GET['service'] ?? '';
        $meal = trim($_GET['meal'] ?? '');
        $year = (int)($_GET['year'] ?? date('Y'));
        $season = trim($_GET['season'] ?? '');
        $week = (int)($_GET['week'] ?? 1);
        $day = trim($_GET['day'] ?? '');

        $allowedServices = [
            'menu_breakfast' => 'Breakfast',
            'menu_lunch' => 'Lunch',
            'menu_lunch_dessert' => 'Lunch Dessert',
            'menu_dinner' => 'Dinner',
            'menu_dinner_dessert' => 'Dinner Dessert',
        ];

        if (!array_key_exists($service, $allowedServices) || $meal === '') {
            die('Paramètres invalides.');
        }

        if ($week < 1 || $week > 3) {
            $week = 1;
        }

        $dayNum = $this->mapDayToWeekdayNumber($day);
        if ($dayNum === null) {
            die('Jour invalide.');
        }

        $menuModel = new MenuModel();

        $seasons = SeasonService::getSeasonsForYear($year);
        $selectedSeason = null;

        foreach ($seasons as $s) {
            if (($s['Saison'] ?? '') === $season) {
                $selectedSeason = $s;
                break;
            }
        }

        if ($selectedSeason === null) {
            die('Saison invalide.');
        }

        $seasonStartWeek = (int)$menuModel->getSeasonStartWeek($year, $season);

        if ($seasonStartWeek < 1 || $seasonStartWeek > 3) {
            $seasonStartWeek = 1;
        }

        $dates = $this->getDatesForCycleBetween(
            $selectedSeason['Début'],
            $selectedSeason['Fin'],
            $seasonStartWeek,
            $week,
            $dayNum
        );

        $rows = [];
        foreach ($dates as $d) {
            $rows[] = [
                'date' => $d,
                'service' => $allowedServices[$service] ?? $service,
                'meal' => $meal,
                'season' => $season,
                'year' => $year,
                'week' => $week,
                'day' => $day,
            ];
        }

        $title = 'Meal Calendar';
        require __DIR__ . '/../views/alimentaire/menu/mealCalendar.php';
    }
private function getDatesForCycleBetween(
    string $start,
    string $end,
    int $seasonStartWeek,
    int $targetWeek,
    int $targetDay
): array {
    $dates = [];

    $startTs = strtotime($start);
    $endTs = strtotime($end);

    if ($startTs === false || $endTs === false || $startTs > $endTs) {
        return [];
    }

    $currentWeekStart = $startTs;

    while ($currentWeekStart <= $endTs) {
        $weeksFromStart = (int)floor(($currentWeekStart - $startTs) / 86400 / 7);
        $cycleWeek = (($seasonStartWeek - 1 + $weeksFromStart) % 3) + 1;

        if ($cycleWeek === $targetWeek) {
            $candidate = strtotime("+{$targetDay} days", $currentWeekStart);

            if ($candidate !== false && $candidate >= $startTs && $candidate <= $endTs) {
                $dates[] = date('Y-m-d', $candidate);
            }
        }

        $currentWeekStart = strtotime('+7 days', $currentWeekStart);
    }

    return $dates;
}
    public function mealCalendar2()
    {
        require_once __DIR__ . '/../models/MenuModel.php';
        require_once __DIR__ . '/../services/SeasonService.php';

        $service = $_GET['service'] ?? '';
        $meal = trim($_GET['meal'] ?? '');
        $year = (int)($_GET['year'] ?? date('Y'));
        $season = trim($_GET['season'] ?? '');

        $allowedServices = [
            'menu_breakfast' => 'Breakfast',
            'menu_lunch' => 'Lunch',
            'menu_lunch_dessert' => 'Lunch Dessert',
            'menu_dinner' => 'Dinner',
            'menu_dinner_dessert' => 'Dinner Dessert',
        ];

        if (!array_key_exists($service, $allowedServices) || $meal === '') {
            die('Paramètres invalides.');
        }

        $menuModel = new MenuModel();
        $rows = $menuModel->findExactMealOccurrences($service, $meal);

        $today = date('Y-m-d');
        $year = (int)date('Y');
        $seasons = SeasonService::getSeasonsForYear($year);
        $currentSeason = $this->findCurrentSeason($seasons, $today);

        $dates = [];

        foreach ($rows as $row) {

            if (!empty($row['unique_date'])) {
                $dates[] = [
                    'date' => $row['unique_date'],
                    'source' => 'Unique',
                    'service' => $allowedServices[$service] ?? $service,
                    'meal' => $row['meal'],
                    'day' => '',
                    'unique_nom' => $row['unique_nom'] ?? '',
                    'unique_observation' => $row['unique_observation'] ?? '',
                ];
            }

            if (!empty($row['day']) && !empty($currentSeason['Début']) && !empty($currentSeason['Fin'])) {
                $regularDates = $this->getDatesForWeekdayBetween(
                    $currentSeason['Début'],
                    $currentSeason['Fin'],
                    (int)$row['week'],
                    $row['day']
                );

                foreach ($regularDates as $d) {
                    $dates[] = [
                        'date' => $d,
                        'source' => 'Regular',
                        'service' => $allowedServices[$service] ?? $service,
                        'meal' => $row['meal'],
                        'day' => $row['day'],
                        'unique_nom' => '',
                        'unique_observation' => '',
                    ];
                }
            }
        }

        $dates = $this->deduplicateMealDates($dates);

        usort($dates, function ($a, $b) {
            return strcmp($a['date'], $b['date']);
        });

        $title = 'Meal Calendar';
        require __DIR__ . '/../views/alimentaire/menu/mealCalendar.php';
    }

private function findCurrentSeason(array $seasons, string $today): ?array
    {
        foreach ($seasons as $season) {
            if ($today >= $season['Début'] && $today <= $season['Fin']) {
                return $season;
            }
        }
        return null;
    }

private function mapDayToWeekdayNumber(string $day): ?int
    {
        $map = [
            'sunday' => 0,
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6,
        ];

        $key = strtolower(trim($day));
        return $map[$key] ?? null;
    }
private function getDatesForCycle3Weeks(string $start, string $end, int $week, string $day): array
    {
        $weekday = $this->mapDayToWeekdayNumber($day);
        if ($weekday === null) {
            return [];
        }

        $startTs = strtotime($start);
        $endTs = strtotime($end);

        // trouver le premier jour correspondant dans la semaine 1
        $firstWeekStart = $startTs;

        // ajuster au bon jour de la semaine
        while ((int)date('w', $firstWeekStart) !== $weekday) {
            $firstWeekStart = strtotime('+1 day', $firstWeekStart);
        }

        // décaler selon week (1,2,3)
        $offset = ($week - 1) * 7;
        $firstOccurrence = strtotime("+{$offset} days", $firstWeekStart);

        $dates = [];
        $current = $firstOccurrence;

        while ($current <= $endTs) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+21 days', $current);
        }

        return $dates;
    }

private function getDatesForWeekdayBetween(string $start, string $end, int $week, string $day): array
    {
        $weekday = $this->mapDayToWeekdayNumber($day);
        if ($weekday === null) {
            return [];
        }
        $seasonStart = strtotime($start);
        $endTs = strtotime($end);
        $current = $seasonStart;
        while ($current <= $endTs) {
            if ((int)date('w', $current) === $weekday) {
                break;
            }
            $current = strtotime('+1 day', $current);
        }
        if ($current > $endTs) {
            return [];
        }
        $offsetDays = ($week - 1) * 7;
        $current = strtotime("+{$offsetDays} days", $current);

        $dates = [];

        while ($current <= $endTs) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+21 days', $current);
        }

        return $dates;
    }

private function deduplicateMealDates(array $dates): array
    {
        $seen = [];
        $result = [];

        foreach ($dates as $row) {
            $key = $row['date'] . '|' . $row['source'] . '|' . $row['service'] . '|' . $row['meal'];

            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $result[] = $row;
            }
        }

        return $result;
    }
    public function menu2weeks()
{
    $date = $_GET['date'] ?? date('Y-m-d');

    $model = new MenuModel();
    $data = $model->get2WeeksMenus($date);

    $this->render('alimentaire/menu/menu2weeks', $data);
}
}
