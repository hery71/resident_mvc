<?php

require_once __DIR__ . '/../services/seasonService.php';

class MenuCycle
{
    // 🔹 DIMANCHE de référence du cycle menus (Menu 2)
    private static $cycleStart      = "2025-01-05"; // DIMANCHE 5 janvier 2025
    private static $cycleStartMenu  = 2;
    private static $cycleTotalMenus = 3;
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    // Récupère le week_start pour une année donnée
    public function getWeekStartForYear(int $year): void {
        $stmt = $this->pdo->prepare("
            SELECT week,date_start
            FROM startweek
            WHERE annee = :year
            LIMIT 1
        ");
        $stmt->execute([':year' => $year]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        self::$cycleStart = $result['date_start'] ?? self::$cycleStart;
        self::$cycleStartMenu = $result['week'] ?? self::$cycleStartMenu;
        }

    // Exemple : Récupérer un menu depuis la DB
    public function getMenuId(string $season, int $week, string $day, string $year) {
        $stmt = $this->pdo->prepare("
            SELECT id FROM menu_tbl
            WHERE saison = :season AND 
            week = :week AND 
            day = :day AND 
            enabled = 1 AND 
            year LIKE CONCAT('%', :year, '%')
        ");
        $stmt->execute([':season' => $season, ':week' => $week, ':day' => $day, ':year' => $year]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //verifier si menu special day or not
    /**
 * Vérifie si une date correspond à un menu spécial.
 * @param string $date Date au format 'YYYY-MM-DD'
 * @return array ['id' => int, 'nom' => string] ou ['id' => 0, 'nom' => '']
 */
    public function isSpecialDay(string $date): array {
        $stmt = $this->pdo->prepare("
            SELECT id, nom
            FROM menu_unique
            WHERE date = :date
            AND enabled = 1
            LIMIT 1
        ");
        $stmt->execute([':date' => $date]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retourne un tableau structuré (même si vide)
        return [
            'id'  => $result ? (int)$result['id'] : 0,
            'nom' => $result ? $result['nom'] : ''
        ];
    }
    /**
 * Récupère les menus (normal ou spécial) pour un ID donné
 * @param int $idx ID du menu (menu_tbl.id ou menu_unique.id)
 * @param bool $isSpecialDay True si c'est un menu unique
 * @return array JSON avec les menus regroupés par type
 */
    /*=========================================================
    🔥 Récupérer les menus (normal ou spécial) pour un ID donné
    ***====================================================*/
    public function getMenubyId(int $idx, bool $isSpecialDay): array {
        // Détermine le champ à utiliser selon le type de menu
        $idField = $isSpecialDay ? 'ids' : 'id_menu';

        // Liste des tables à interroger
        $tables = ['breakfast', 'lunch', 'lunch_dessert', 'dinner', 'dinner_dessert'];

        $result = [];

        foreach ($tables as $table) {
            $stmt = $this->pdo->prepare("
                SELECT libelle
                FROM $table
                WHERE $idField = :idx
                ORDER BY libelle
            ");
            $stmt->execute([':idx' => $idx]);
            $items = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Regroupe les valeurs séparées par des virgules
            $result[$table] = !empty($items) ? implode(', ', $items) : '';
        }

        return $result;
    }

    /* ============================================================
       🔥 Fonction principale : Saison + Week pour une date
       ============================================================ */
    public static function getSeasonAndWeek(string $date): array
    {
        $target = new DateTime($date);
        $year = (int)$target->format('Y');
        $cycleYear = $year;

        // début Christmas de l'année précédente
        $xmas = strtotime(($year - 1) . "-12-25");
        $xmasDay = date('w', $xmas);
        $cycleStart = strtotime("-$xmasDay days", $xmas);

        // fin du cycle spécial (Christmas + New Year = 14 jours)
        $cycleEnd = strtotime("+13 days", $cycleStart);

        $dateTs = strtotime($date);

        if ($dateTs >= $cycleStart && $dateTs <= $cycleEnd) {
            $cycleYear = $year - 1;
        }

        $year = $cycleYear;

        $seasonYear = $year;
        $winterStartCurrentYear = null;

        foreach (self::getSeasonsForYear($year) as $range) {
            if ($range['Saison'] === 'Winter') {
                $winterStartCurrentYear = $range['Début'];
                break;
            }
        }

        if ($winterStartCurrentYear !== null && $date < $winterStartCurrentYear) {
            $seasonYear = $year - 1;
        }

        $seasons = self::getSeasonsForYear($seasonYear);
        foreach ($seasons as $s) {

            $start = strtotime($s['Début']);
            $end   = strtotime($s['Fin']);
            $ts    = strtotime($date);

            if ($ts >= $start && $ts <= $end) {

                /* ============================================================
                   🎄 SPECIAL CHRISTMAS (DB = Christmas, week = 4)
                   ============================================================ */
                if ($s['Saison'] === "Christmass") {
                    return [
                        'season'  => "Christmass",
                        'week'    => 4,
                        'unique' => true,
                        'year' => $seasonYear
                    ];
                }

                /* ============================================================
                   🎆 SPECIAL NEW YEAR (DB = New year, week = 5)
                   ============================================================ */

                if ($s['Saison'] === "New year") {
                    return [
                        'season'  => "New year",
                        'week'    => 5,
                        'unique' => true,
                        'year' => $seasonYear
                    ];
                }

                /* ============================================================
                   🌿 Saison normale (Winter/Spring/Summer/Fall)
                   ============================================================ */
                //$menuCycleInstance = new self($GLOBALS['pdo']);  // Nécessite que $pdo soit accessible globalement
                //$menuCycleInstance->getWeekStartForYear((int)$target->format('Y'));
                //$week = self::calculateMenuWeek($target);
                //$weeksPassed = floor(($ts - $start) / 604800);
                //$week = ($weeksPassed % self::$cycleTotalMenus) + 1;
                $startSunday = strtotime($s['Début']);
                $targetSunday = strtotime(self::getSundayOfWeek(new DateTime($date))->format('Y-m-d'));

                $weeksPassed = floor(($targetSunday - $startSunday) / 604800);
                // récupérer la week de départ depuis la table
                $menuCycleInstance = new self($GLOBALS['pdo']);
                $startWeek = $menuCycleInstance->getSeasonStartWeek($seasonYear, $s['Saison']);
                // calcul du cycle
                $week = (($startWeek + $weeksPassed - 1) % self::$cycleTotalMenus) + 1;

                return [
                    'season'  => $s['Saison'],
                    'week'    => $week,
                    'unique' => false,
                    'year' => $seasonYear
                ];
            }
        }

        // 🔸 Ne devrait plus jamais arriver
        return [
            'season'  => 'Unknown',
            'week'    => null,
            'unique' => false,
            'year' => $year
        ];
    }



    /* ============================================================
       🔥 Génération des plages de saisons pour un cycle
       ============================================================ */
    public static function getSeasonsForYear(int $year): array
    {
        $regular = [];
        $special = [];

        foreach (SeasonService::getSeasonsForYear($year) as $season) {
            if ($season['Saison'] === 'Semaine Noël') {
                $season['Saison'] = 'Christmass';
                $special[] = $season;
                continue;
            }

            if ($season['Saison'] === 'Nouvel An') {
                $season['Saison'] = 'New year';
                $special[] = $season;
                continue;
            }

            $regular[] = $season;
        }

        // Les semaines spéciales sont évaluées avant les saisons régulières.
        return array_merge($special, $regular);
    }



    /* ============================================================
       🔥 DIMANCHE réel de la semaine
       ============================================================ */
    private static function getSundayOfWeek(DateTime $date): DateTime
    {
        if ($date->format('w') == 0) {
            return clone $date;
        }
        return (clone $date)->modify('last sunday');
    }



    /* ============================================================
       🔥 Calcul du numéro du menu (1–3) basé sur le vrai dimanche
       ============================================================ */
    private static function calculateMenuWeek(DateTime $date): int
{
    $sunday = self::getSundayOfWeek($date);        // ligne 260

    $diffDays = floor(                             // ligne 262
        (strtotime($sunday->format('Y-m-d')) 
        - strtotime(self::$cycleStart)) / 86400
    );

    if ($diffDays < 0) $diffDays = 0;              // ligne 267

    $weeksPassed = floor($diffDays / 7);           // ligne 269

    return ((self::$cycleStartMenu - 1 
        + $weeksPassed) 
        % self::$cycleTotalMenus) + 1;              // ligne 271
}

    /*============================================================
      Calcul le jour a partir d une date
       ============================================================ */
    public static function getDayFromDate(string $date): string 
{
    return strtolower(date('l', strtotime($date)));  // "monday", "tuesday", etc.
}
    public static function getCycleYear(string $date, string $season): int
{
    $year = (int)date('Y', strtotime($date));
    $month = (int)date('n', strtotime($date));

    // cas spécial : semaine New Year début janvier
    if ($season === "New year" && $month == 1) {
        return $year - 1;
    }

    return $year;
}


    public function getSeasonStartWeek(int $annee, string $saison): int
{
    $stmt = $this->pdo->prepare("
        SELECT week
        FROM season_start_week
        WHERE annee = :annee
        AND saison = :saison
        AND enabled = 1
        LIMIT 1
    ");

    $stmt->execute([
        ':annee' => $annee,
        ':saison' => $saison
    ]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
    return 1;
    }

    return (int)$result['week'];
}
public function ensureSeasonStartWeeks(int $year): void
{
    $seasons = ['Winter','Spring','Summer','Fall'];

    foreach ($seasons as $season) {

        $stmt = $this->pdo->prepare("
            SELECT id
            FROM season_start_week
            WHERE annee = :annee
            AND saison = :saison
            LIMIT 1
        ");

        $stmt->execute([
            ':annee' => $year,
            ':saison' => $season
        ]);

        if (!$stmt->fetch()) {

            $insert = $this->pdo->prepare("
                INSERT INTO season_start_week (annee, saison, week, enabled)
                VALUES (:annee, :saison, 1, 1)
            ");

            $insert->execute([
                ':annee' => $year,
                ':saison' => $season
            ]);
        }
    }
}

}

?>
