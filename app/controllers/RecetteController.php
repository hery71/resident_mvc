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
}
