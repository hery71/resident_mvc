<?php
require_once __DIR__ . '/../models/AllergieModel.php';
class AllergieController
{
    public function edit()
    {
        
        $page_css = 'edit_allergie.css';
        $model = new AllergieModel();
        $allergenes = $model->all();

        // Logique pour récupérer les paramètres si nécessaire

        require __DIR__ . '/../views/alimentaire/allergie/edit.php';
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $allergenes = $_POST['allergenes'] ?? [];

            $model = new AllergieModel();
            $model->saveAll($allergenes);

            header('Location: /allergie/edit');
            exit();
        }
    }
}