<?php

class SeasonService
{
    public static function getSeasonsForYear(int $year): array
    {
        $seasons = [];

        // 🎆 Semaine Nouvel An
        $newyear = strtotime("$year-01-01");
        $ny_day = date('w', $newyear);
        $specialNY_start = strtotime("-$ny_day days", $newyear);
        $specialNY_end   = strtotime("+6 days", $specialNY_start);

        // 🧊 Winter
        $winterStart = strtotime("+1 day", $specialNY_end);
        $winterEnd   = strtotime("saturday this week", strtotime("+75 days", $winterStart));

        // 🌷 Spring
        $springStart = strtotime("+1 day", $winterEnd);
        $springEnd   = strtotime("saturday this week", strtotime("+90 days", $springStart));

        // ☀️ Summer
        $summerStart = strtotime("+1 day", $springEnd);
        $summerEnd   = strtotime("saturday this week", strtotime("+90 days", $summerStart));

        // 🍂 Fall
        $fallStart = strtotime("+1 day", $summerEnd);
        $fallEnd   = strtotime("saturday this week", strtotime("+90 days", $fallStart));

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
            $s['Durée'] = (strtotime($s['Fin']) - strtotime($s['Début'])) / 86400 + 1;
        }

        return $seasons;
    }
}
