<?php

require_once __DIR__ . '/../models/ParametresModel.php';

class SeasonService
{
    public static function getNextSeasonByDate(string $date): array
    {
        $year = (int)date('Y', strtotime($date));
        $seasons = array_merge(
            self::getSeasonsForYear($year - 1),
            self::getSeasonsForYear($year)
        );

        // Noël et Nouvel An gardent toujours la priorité si une saison
        // régulière configurée chevauche accidentellement leur période.
        usort($seasons, static function (array $a, array $b): int {
            $specials = ['Semaine Noël', 'Nouvel An'];
            $aSpecial = in_array($a['Saison'], $specials, true);
            $bSpecial = in_array($b['Saison'], $specials, true);

            if ($aSpecial !== $bSpecial) {
                return $aSpecial ? -1 : 1;
            }

            return strcmp($a['Début'], $b['Début']);
        });

        foreach ($seasons as $s) {
            if ($date >= $s['Début'] && $date <= $s['Fin']) {
                return $s;
            }
        }

        // Si aucune saison suivante dans l'année, retourner la première saison de l'année suivante
        return self::getSeasonsForYear($year + 1)[0];
    }

    public static function getSeasonsForYear(int $year): array
    {
        $weeks = self::getWeeksForYear($year);

        // 🎆 Semaine Nouvel An
        $newyear = strtotime("$year-01-01");
        $ny_day = date('w', $newyear);
        $specialNY_start = strtotime("-$ny_day days", $newyear);
        $specialNY_end   = strtotime("+6 days", $specialNY_start);

        // 🧊 Winter
        $winterStart = strtotime("+1 day", $specialNY_end);
        $winterEnd = self::calculateSeasonEnd($winterStart, $weeks['winter']);

        // 🌷 Spring
        $springStart = strtotime("+1 day", $winterEnd);
        $springEnd = self::calculateSeasonEnd($springStart, $weeks['spring']);

        // ☀️ Summer
        $summerStart = strtotime("+1 day", $springEnd);
        $summerEnd = self::calculateSeasonEnd($summerStart, $weeks['summer']);

        // 🍂 Fall
        $fallStart = strtotime("+1 day", $summerEnd);
        $fallEnd = self::calculateSeasonEnd($fallStart, $weeks['fall']);

        // 🎄 Noël
        $xmas = strtotime("$year-12-25");
        $xmasDay = date('w', $xmas);
        $specialXmas_start = strtotime("-$xmasDay days", $xmas);
        $specialXmas_end   = strtotime("+6 days", $specialXmas_start);

        // 🎆 Nouvel An fin d’année
        $specialNY2_start = strtotime("+7 days", $specialXmas_start);
        $specialNY2_end   = strtotime("+6 days", $specialNY2_start);

        $seasons = [
            ['Saison' => 'Winter', 'Début' => $winterStart, 'Fin' => $winterEnd],
            ['Saison' => 'Spring', 'Début' => $springStart, 'Fin' => $springEnd],
            ['Saison' => 'Summer', 'Début' => $summerStart, 'Fin' => $summerEnd],
            ['Saison' => 'Fall',   'Début' => $fallStart,   'Fin' => $fallEnd],
            ['Saison' => 'Semaine Noël', 'Début' => $specialXmas_start, 'Fin' => $specialXmas_end],
            ['Saison' => 'Nouvel An',   'Début' => $specialNY2_start,  'Fin' => $specialNY2_end],
        ];

        foreach ($seasons as &$s) {
            $s['Début'] = date('Y-m-d', $s['Début']);
            $s['Fin']   = date('Y-m-d', $s['Fin']);
            $s['Durée'] = (int)((strtotime($s['Fin']) - strtotime($s['Début'])) / 86400) + 1;
        }
        unset($s);

        return $seasons;
    }

    private static function getWeeksForYear(int $year): array
    {
        // Valeurs correspondant exactement à l'algorithme historique.
        $weeks = [
            'winter' => 11,
            'spring' => 13,
            'summer' => 13,
            'fall'   => 13,
        ];

        $model = new ParametresModel();
        $configured = $model->getActiveSeasonDurationForYear($year);

        if (!$configured) {
            return $weeks;
        }

        foreach (array_keys($weeks) as $season) {
            $value = (int)($configured[$season] ?? 0);
            if ($value >= 1 && $value <= 53) {
                $weeks[$season] = $value;
            }
        }

        return $weeks;
    }

    private static function calculateSeasonEnd(int $start, int $weeks): int
    {
        $days = ($weeks * 7) - 1;
        return strtotime("+{$days} days", $start);
    }
}
