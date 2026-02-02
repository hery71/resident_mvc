<?php

class IntoleranceController
{
    public function edit()
    {
        $model = new IntoleranceModel();
        $categories = $model->allCategories();

        require APP_PATH . '/views/alimentaire/intolerance/edit.php';
    }
    public function update()
    {
        $model = new IntoleranceModel();
         // 🔹 POST → sauvegarde
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model->saveCategories($_POST);

            header('Location: /intolerance/edit');
        }
    }
}
