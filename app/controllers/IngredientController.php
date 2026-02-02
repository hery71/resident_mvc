<?php

class IngredientController
{
    public function edit()
    {
        
        $page_css = 'edit_ingredient.css';
        $model = new IngredientModel();
        $ingredients = $model->all();

        // Logique pour récupérer les paramètres si nécessaire

        require __DIR__ . '/../views/alimentaire/preparation/ingredient/edit.php';
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ingredients = $_POST['ingredients'] ?? [];

            $model = new IngredientModel();
            $model->saveAll($ingredients);

            header('Location: /ingredient/edit');
            exit();
        }
    }
}