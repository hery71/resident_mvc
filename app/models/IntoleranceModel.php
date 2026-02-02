<?php

class IntoleranceModel extends JsonRepository
{
    private string $file;

    public function __construct()
    {
        // chemin réel du fichier JSON
        $this->file = dirname(__DIR__, 2) . '/storage/data/intolerances.json';
    }

    /**
     * Retourne toutes les catégories et leurs items
     */
    public function allCategories(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $data = json_decode(file_get_contents($this->file), true);

        return $data['Intolerances_Alimentaires_Canada'] ?? [];
    }

    /**
     * Sauvegarde toutes les catégories (logique de ton ancien script)
     */
    public function saveCategories(array $postData): void
    {
        $cleaned = [];

        foreach ($postData as $category => $items) {
            if (!is_array($items)) {
                continue;
            }

            $values = array_values(
                array_filter(
                    array_map('trim', $items)
                )
            );

            $cleaned[$category] = $values;
        }

        $data = [
            'Intolerances_Alimentaires_Canada' => $cleaned
        ];

        // 🔐 backup automatique (comme avant)
        copy(
            $this->file,
            APP_PATH . '/storage/backup_intolerance_' . date('Ymd_His') . '.json'
        );

        file_put_contents(
            $this->file,
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }
}
