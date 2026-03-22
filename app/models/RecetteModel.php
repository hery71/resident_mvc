<?php
// models/Recette.php
require_once dirname(__DIR__, 2) . '/app/config/db.php';
class RecetteModel
{
    private string $dataDir;

    public function __construct() {
        $this->dataDir = __DIR__ . '/../../storage/data/recepies/canada/';
    }

    public function liste(): array {
        $fichiers = glob($this->dataDir . '*.json');
        $recettes = [];
        foreach ($fichiers as $fichier) {
            $data = json_decode(file_get_contents($fichier), true);
            $recettes[] = [
                'titre'   => $data['titre'] ?? basename($fichier, '.json'),
                'fichier' => basename($fichier, '.json')
            ];
        }
        return $recettes;
    }

    public function detail(string $id): ?array {
        $fichier = $this->dataDir . basename($id) . '.json';
        if (!file_exists($fichier)) return null;
        return json_decode(file_get_contents($fichier), true);
    }
}