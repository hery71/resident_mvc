<?php

class DashBoardController extends Controller
{
    public function index()
    {
        global $pdo;

        date_default_timezone_set('America/Moncton');
        $xdate = $_POST['xdate'] ?? $_GET['date'] ?? date('Y-m-d');
        // ==============================
        // 1️⃣ DATE
        // ==============================
        

        $target = new DateTime($xdate);
        $day    = $target->format('l');
        $year   = (int)$target->format('Y');
        $cycleYear = $year;

        // ==============================
        // 2️⃣ MENU
        // ==============================
        $cycle = MenuCycle::getSeasonAndWeek($xdate);
        $menuModel = new MenuModel($pdo);

        $menu = null;
        $id_unique = 0;

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
        
        // ==============================
        // 3️⃣ INFO
        // ==============================
        $info = "📅 <strong>" . $target->format('l, d F Y') . "</strong> — 
                 Saison : <strong>$saison</strong> — 
                 Semaine : <strong>" . ($week ? "Week $week" : "Unique") . "</strong> — 
                 Jour : <strong>$day</strong> — 
                 Cycle : <strong>$cycleYear</strong>";

        // ==============================
        // 4️⃣ RESTRICTIONS
        // ==============================
        $restrictions = [];
        //var_dump($menu);
       // exit();
        if ($menu) {
            $dashboardModel = new DashboardModel($pdo);
            $restrictions = $dashboardModel->getMenuRestrictions($menu);
        }
        //-----------------------------
        //residents avec anniversaire aujourd'hui
        //----------------------------- 
        $residentModel = new ResidentModel($pdo);
        $birthdays = $residentModel->findByBornDate($xdate);
        //-----------------------------
        //residents avec fete anniversaire aujourd'hui
        //-----------------------------
        $feteModel = new FeteModel($pdo);
        $fetes = $feteModel->feteByDate($xdate);
        //-----------------------------
        //gâteaux d'anniversaire pour aujourd'hui
        $cakeModel = new CakeModel($pdo);
        $cakes = $cakeModel->cakeOrderByDate($xdate);
        // ==============================
        // 5️⃣ VIEW
        // ==============================
        require __DIR__ . '/../views/dashBoard/index.php';
    }
}