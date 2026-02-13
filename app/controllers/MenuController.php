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
        $breakfastItems     = $model->fetchMealList('breakfast', $id_menu);
        $lunchItems         = $model->fetchMealList('lunch', $id_menu);
        $lunchDessertItems  = $model->fetchMealList('lunch_dessert', $id_menu);
        $dinnerItems        = $model->fetchMealList('dinner', $id_menu);
        $dinnerDessertItems = $model->fetchMealList('dinner_dessert', $id_menu);

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
        $cycleYear = $year;

        $cycle = MenuCycle::getSeasonAndWeek($xdate);

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
        $cycleYear = $year;

        $cycle = MenuCycle::getSeasonAndWeek($xdate);

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

}
