<?php
class AjaxRestrictionController
{
    public function addAllergen()
    {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $value = trim($data['value'] ?? '');

        if ($value === '') {
            echo json_encode(['success' => false, 'error' => 'Valeur vide']);
            return;
        }

        $file = dirname(__DIR__, 2) . '/storage/data/allergies.json';

        if (!file_exists($file)) {
            echo json_encode(['success' => false, 'error' => 'Fichier introuvable']);
            return;
        }

        $list = json_decode(file_get_contents($file), true) ?? [];

        if (in_array($value, $list, true)) {
            echo json_encode(['success' => false, 'error' => 'Existe déjà']);
            return;
        }

        $list[] = $value;
        sort($list, SORT_NATURAL | SORT_FLAG_CASE);

        file_put_contents(
            $file,
            json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        echo json_encode(['success' => true]);
    }
    public function addIntolerance()
{
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);

    $category = trim($data['category'] ?? '');
    $value    = trim($data['value'] ?? '');

    if ($category === '' || $value === '') {
        echo json_encode(['success' => false, 'error' => 'Données manquantes']);
        return;
    }

    $file = dirname(__DIR__, 2) . '/storage/data/intolerances.json';

    if (!file_exists($file)) {
        echo json_encode(['success' => false, 'error' => 'Fichier introuvable']);
        return;
    }

    $json = json_decode(file_get_contents($file), true);

    if (!isset($json['Intolerances_Alimentaires_Canada'][$category])) {
        echo json_encode(['success' => false, 'error' => 'Catégorie invalide']);
        return;
    }

    $list = &$json['Intolerances_Alimentaires_Canada'][$category];

    if (in_array($value, $list, true)) {
        echo json_encode(['success' => false, 'error' => 'Existe déjà']);
        return;
    }

    $list[] = $value;
    sort($list, SORT_NATURAL | SORT_FLAG_CASE);

    file_put_contents(
        $file,
        json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );

    echo json_encode(['success' => true]);
}

}
