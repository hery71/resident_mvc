<?php

require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/MenuModel.php';
require_once __DIR__ . '/../models/MenuCycle.php';

class OrderController
{
    public function index()
    {
        date_default_timezone_set('America/Moncton');
        $xdate = $_GET['date'] ?? date('Y-m-d');
        $orderModel = new OrderModel();
        // Début de semaine (dimanche précédent ou égal)
        $weekStart = $orderModel->getPreviousSunday($xdate);
        $range = $_GET['range'] ?? 7; // Par défaut 7jours sinon 14 jours
        // Générer les 7 jours de la semaine
        $days = [];
        $d = new DateTime($weekStart);
        //suivant range
        for ($i = 0; $i < $range; $i++) {
            $days[] = $d->format('Y-m-d');
            $d->modify('+1 day');
        }
        $menuModel = new MenuModel();
        $menus = [];
        foreach ($days as $dayDate) {

            $target = new DateTime($dayDate);
            $dayName = $target->format('l');

            $cycle = MenuCycle::getSeasonAndWeek($dayDate);
            $cycleYear = $cycle['year'];

            $uniqueMenu = $menuModel->getUniqueMenuForDate($dayDate);

            if ($uniqueMenu) {
                $menus[$dayDate] = $uniqueMenu;
            } else {

                $saison = $cycle['season'];
                $week   = $cycle['week'];

                if ($week !== null) {
                    $menus[$dayDate] = $menuModel->getBaseMenu(
                        $saison,
                        $week,
                        $dayName,
                        $cycleYear
                    );
                } else {
                    $menus[$dayDate] = null;
                }
            }
        }
        $orderList = $orderModel->buildWeeklyOrderList($menus);
        require __DIR__ . '/../views/order/index.php';
    }
}