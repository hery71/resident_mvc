<?php

class ParametresController
{
    public function index()
    {

        $model = new ParametresModel();
        $company = $model->getCompanyInfo();

        // Logique pour récupérer les paramètres si nécessaire

        require __DIR__ . '/../views/parametres/index.php';
    }
}