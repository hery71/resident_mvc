<?php

/**
 * Échappement HTML sécurisé (PHP 8+ safe)
 */
function e($value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}
function f8($value): string
{
    return mb_convert_encoding((string)($value ?? ''), 'ISO-8859-1', 'UTF-8');
}

function logo_disk_path(): ?string
{
    $cfg = Config::get('logo');
    $filename = $cfg['filename'] ?? null;
    if (!$filename) return null;

    $path = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/' . $filename;
    return file_exists($path) ? $path : null;
}
function ensureMealExists($pdo, $tableList, $meal) {
    $stmt = $pdo->prepare("SELECT id FROM $tableList WHERE meal = ? LIMIT 1");
    $stmt->execute([$meal]);
    if (!$stmt->fetchColumn()) {
        $stmt = $pdo->prepare("INSERT INTO $tableList (meal, enabled, allergene, intolerance)
                               VALUES (?, 1, '', '')");
        $stmt->execute([$meal]);
    }
}

// =========================
// 🔁 Fonction rotation automatique
// =========================
function getMenuRotation($annee, $saison, $week) {
    if ($week == 4) return "Special Christmas 🎄";
    if ($week == 5) return "Special New Year 🎆";
    $baseStart = strtotime("2025-01-05");
    $baseMenu  = 2;
    $totalMenus = 3;
    $approxDate = strtotime("$annee-01-01 +$week week");
    $weeksPassed = floor(($approxDate - $baseStart) / (7 * 86400));
    if ($weeksPassed < 0) return "Menu $baseMenu";
    return "Menu " . ((($baseMenu - 1 + $weeksPassed) % $totalMenus) + 1);
}
// =========================
// 🧩 Génération UI
// =========================
function createMealSection($label, $name, $items, $dessertLabel = null, $dessertName = null, $desserts = []) {
    echo "<div class='card card-modern mb-4'>";
    echo "<div class='card-header card-header-modern bg-light  text-center'>$label</div>";
    echo "<div class='card-body'>";
    echo "<div id='{$name}-list'>";

    foreach ($items as $item) {
        echo "<div class='input-group mb-2 position-relative'>";
        echo "<input type='hidden' name='{$name}[id][]' value='{$item['id']}'>";
        echo "<input type='text' name='{$name}[meal][]' class='form-control' value='".htmlspecialchars($item['meal'])."'>";
        echo "<button type='button' class='btn bg-light text-danger remove-btn ms-2' data-table='{$name}' data-id='{$item['id']}' data-meal='".htmlspecialchars($item['meal'])."'><i class='bi bi-trash'></i>X</button>";
        echo "</div>";
    }

    echo "</div>";

    echo "<button type='button' class='btn bg-light btn-sm btn-modern add-btn mt-2' data-table='{$name}'>
            <i class='bi bi-plus-circle'></i> Ajouter
          </button>";

    if ($dessertLabel) {
        echo "<hr><h6>$dessertLabel</h6>";
        echo "<div id='{$dessertName}-list'>";

        foreach ($desserts as $item) {
            echo "<div class='input-group mb-2 position-relative'>";
            echo "<input type='hidden' name='{$dessertName}[id][]' value='{$item['id']}'>";
            echo "<input type='text' name='{$dessertName}[meal][]' class='form-control' value='".htmlspecialchars($item['meal'])."'>";
            echo "<button type='button' class='btn bg-light remove-btn ms-2' data-table='{$dessertName}' data-id='{$item['id']}' data-meal='".htmlspecialchars($item['meal'])."'><i class='bi bi-trash'></i></button>";
            echo "</div>";
        }

        echo "</div>";
        echo "<button type='button' class='btn bg-light btn-sm btn-modern add-btn mt-2' data-table='{$dessertName}'>
                <i class='bi bi-plus-circle'></i> Ajouter dessert
              </button>";
    }

    echo "</div></div>";
}
/**
 * Transforme une chaîne de meals séparés par des virgules
 * en tableau compatible avec createMealSection()
 */
function explodeMeals($value): array
{
    if (!$value) return [];

    // Si déjà un tableau → on retourne tel quel
    if (is_array($value)) return $value;

    // Séparation par virgule
    $parts = preg_split('/\s*,\s*/', $value);

    $items = [];
    foreach ($parts as $meal) {
        $meal = trim($meal);
        if ($meal !== '') {
            $items[] = [
                'id'   => 0,
                'meal' => $meal
            ];
        }
    }

    return $items;
}

