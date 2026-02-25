<?php

class AlimentaireController
{

public function saison()
    {
        require_once __DIR__ . '/../services/SeasonService.php';
        $page_css = 'saison.css';
        $annee = $_GET['annee'] ?? date("Y");
        $seasonService = new SeasonService();
        $seasons = $seasonService->getSeasonsForYear($annee);
        require __DIR__ . '/../views/alimentaire/saison.php';
    }
public function index()
    {
        $page_css = 'alimentaire.css';
        require __DIR__ . '/../views/alimentaire/index.php';
    }

}