<?php
require_once __DIR__ . '/../models/MenuCycle.php';
class RecetteController
{
    public function indexca()
    {
        $recettesDir = __DIR__ . '/../../storage/data/recepies/canada/';
        $fichiers = glob($recettesDir . '*.json');
        $recettes = [];
        foreach ($fichiers as $fichier) {
            $data = json_decode(file_get_contents($fichier), true);
            $recettes[] = [
                'titre' => $data['titre'] ?? basename($fichier, '.json'),
                'fichier' => basename($fichier, '.json')
            ];
        }
        // 🔹 tri alphabétique sur le titre
    usort($recettes, function ($a, $b) {
        return strcasecmp($a['titre'], $b['titre']);
    });
        
        require __DIR__ . '/../views/alimentaire/recette/indexca.php';
    }

    public function detailca()
    {
        $id = $_GET['id'] ?? '';
        $fichier = __DIR__ . '/../../storage/data/recepies/canada/' . basename($id) . '.json';
        if (!file_exists($fichier)) { header('Location: /recette/'); exit; }
        $r = json_decode(file_get_contents($fichier), true);
        $title = $r['titre'];
        $custom_js = $custom_style = '';
        require __DIR__ . '/../views/alimentaire/recette/detailca.php';
    }
     public function printRecipeCa()
    {
        $id = $_GET['id'] ?? '';
        $fichier = __DIR__ . '/../../storage/data/recepies/canada/' . basename($id) . '.json';
        if (!file_exists($fichier)) { header('Location: /recette/'); exit; }
        $r = json_decode(file_get_contents($fichier), true);
        $title = $r['titre'];
        $custom_js = $custom_style = '';
        require __DIR__ . '/../views/alimentaire/recette/printRecipeCa.php';
    }
    public function printRecipeFr()
    {
        $id = $_GET['id'] ?? '';
        $fichier = __DIR__ . '/../../storage/data/recepies/france/' . basename($id) . '.json';
        if (!file_exists($fichier)) { header('Location: /recette/'); exit; }
        $r = json_decode(file_get_contents($fichier), true);
        $title = $r['titre'];
        $custom_js = $custom_style = '';
        require __DIR__ . '/../views/alimentaire/recette/printRecipeFr.php';
    }
    public function printRecipeBeurre()
    {
        $id = $_GET['id'] ?? '';
        $fichier = __DIR__ . '/../../storage/data/recepies/france/' . basename($id) . '.json';
        if (!file_exists($fichier)) { header('Location: /recette/'); exit; }
        $r = json_decode(file_get_contents($fichier), true);
        $title = $r['titre'];
        $custom_js = $custom_style = '';
        require __DIR__ . '/../views/alimentaire/recette/printRecipeBeurre.php';
    }
    public function printRecipeMarinade()
    {
        $id = $_GET['id'] ?? '';
        $fichier = __DIR__ . '/../../storage/data/recepies/france/' . basename($id) . '.json';
        if (!file_exists($fichier)) { header('Location: /recette/'); exit; }
        $r = json_decode(file_get_contents($fichier), true);
        $title = $r['titre'];
        $custom_js = $custom_style = '';
        require __DIR__ . '/../views/alimentaire/recette/printRecipeMarinade.php';
    }
    public function indexfr()
    {
        $recettesDir = __DIR__ . '/../../storage/data/recepies/france/';
        $fichiers = glob($recettesDir . '*.json');
        $recettes = [];
        foreach ($fichiers as $fichier) {
            $data = json_decode(file_get_contents($fichier), true);
            $recettes[] = [
                'titre' => $data['titre'] ?? basename($fichier, '.json'),
                'fichier' => basename($fichier, '.json')
            ];
        }
        // 🔹 tri alphabétique sur le titre
    usort($recettes, function ($a, $b) {
        return strcasecmp($a['titre'], $b['titre']);
    });
        
        require __DIR__ . '/../views/alimentaire/recette/indexfr.php';
    }

    public function detailfr()
    {
        $id = $_GET['id'] ?? '';
        $fichier = __DIR__ . '/../../storage/data/recepies/france/' . basename($id) . '.json';
        if (!file_exists($fichier)) { header('Location: /recette/'); exit; }
        $r = json_decode(file_get_contents($fichier), true);
        $title = $r['titre'];
        $custom_js = $custom_style = '';

        $type = strtolower($r['type'] ?? '');

        switch ($type) {
            case 'beurre compose':
                require __DIR__ . '/../views/alimentaire/recette/detailbeurre.php';
                break;
            case 'marinade':
                require __DIR__ . '/../views/alimentaire/recette/detailmarinade.php';
                break;
            default:
                require __DIR__ . '/../views/alimentaire/recette/detailfr.php';
                break;
        }
    }
    public function add_recipe_Fr()
    {
        $error = $_GET['error'] ?? '';
        $options = require __DIR__ . '/../config/options.php';
        $Sections = $options['Sections'] ?? [];
        sort($Sections);        
        require __DIR__ . '/../views/alimentaire/recette/add_recipe_fr.php';   
    }
    public function add_recipe_Ca()
    {
        $error = $_GET['error'] ?? '';      
        require __DIR__ . '/../views/alimentaire/recette/add_recipe_ca.php';   
    }
    public function scan(){
        require __DIR__ . '/../views/alimentaire/recette/scan.php';   
    }
    public function save_recipe_fr()
    {
        
        $type  = $_POST['type'] ?? 'general';
        $titre = trim($_POST['titre'] ?? '');

        if ($titre === '') {
            header('Location: /recette/add_recipe?error=Le titre est requis');
            exit;
        }

        $data = [
            'titre' => $titre,
            'type'  => $_POST['type_recette'] ?? ''
        ];

        // 🔹 GENERAL
        if ($type === 'general') {

            $data['pax'] = $_POST['pax'] ?? '';

            $sectionsSelect = $_POST['section_select'] ?? [];
            $sectionsInput  = $_POST['section_input'] ?? [];
            $noms = $_POST['nom'] ?? [];
            $unites = $_POST['unite'] ?? [];
            $quantites = $_POST['quantite'] ?? [];

            foreach ($sectionsSelect as $index => $sectionName) {

                if (!empty($sectionName) && $sectionName !== 'custom') {
                    $finalSection = $sectionName;
                } else {
                    $finalSection = trim($sectionsInput[$index] ?? '');
                }

                if ($finalSection === '') continue;

                $data[$finalSection] = [];

                foreach ($noms[$index] ?? [] as $i => $nom) {

                    if (trim($nom) === '') continue;

                    $item = ['nom' => trim($nom)];

                    if (!empty($unites[$index][$i])) {
                        $item['unite'] = trim($unites[$index][$i]);
                    }

                    if (!empty($quantites[$index][$i])) {
                        $item['quantite'] = trim($quantites[$index][$i]);
                    }

                    $data[$finalSection][] = $item;
                }
            }

            $data['technique_de_realisation'] = array_filter($_POST['technique'] ?? []);
        }

        // 🔹 BEURRE
        if ($type === 'beurre') {
            $data['genre'] = 'beurre compose';
            $data['ingredients'] = array_filter($_POST['ingredients'] ?? []);
            $data['technique_de_realisation'] = array_filter($_POST['technique'] ?? []);
            $data['utilisation'] = array_filter($_POST['utilisation'] ?? []);
        }

        // 🔹 MARINADE
        if ($type === 'marinade') {
            $data['genre'] = 'marinade';
            $data['base'] = $_POST['base'] ?? '';
            $data['type_de_viande'] = $_POST['type_viande'] ?? '';
            $data['ingredients'] = array_filter($_POST['ingredients'] ?? []);
            $data['technique_de_realisation'] = array_filter($_POST['technique'] ?? []);
        }

        // 🔹 SAVE JSON
        $filename = strtolower(str_replace(' ', '_', $titre)) . '.json';
        $path = __DIR__ . '/../../storage/data/recepies/france/' . $filename;

        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        header('Location: /recette/indexfr');
        exit;
    }
    public function save_recipe_ca()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /recette/add_recipe_ca');
            exit;
        }
        $titre = trim($_POST['titre'] ?? '');
        $pax   = (int)($_POST['pax'] ?? 0);

        $ingredientNoms = $_POST['ingredient_nom'] ?? [];
        $ingredientUnites = $_POST['ingredient_unite'] ?? [];
        $ingredientQuantites = $_POST['ingredient_quantite'] ?? [];

        $techniques = $_POST['technique_de_realisation'] ?? [];

        $ingredients = [];
        foreach ($ingredientNoms as $i => $nom) {
            $nom = trim($nom);
            $unite = trim($ingredientUnites[$i] ?? '');
            $quantite = $ingredientQuantites[$i] ?? '';

            if ($nom === '' || $unite === '' || $quantite === '') {
                continue;
            }

            $ingredients[] = [
                'nom' => $nom,
                'unite' => $unite,
                'quantite' => (float)$quantite
            ];
        }

        $technique_de_realisation = [];
        foreach ($techniques as $etape) {
            $etape = trim($etape);
            if ($etape !== '') {
                $technique_de_realisation[] = $etape;
            }
        }

        $data = [
            'titre' => $titre,
            'pax' => $pax,
            'ingredients' => $ingredients,
            'technique_de_realisation' => $technique_de_realisation
        ];

        $filename = preg_replace('/[^A-Za-z0-9_-]/', '_', strtolower($titre)) . '.json';
        $folder = __DIR__ . '/../../storage/data/recepies/canada/';
        $file =$folder . '/' . $filename;
        $path = __DIR__ . '/../../storage/data/recepies/canada/' . $filename;

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        file_put_contents(
            $path,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        header('Location: /recette/indexca');
        exit;
    }
    
}