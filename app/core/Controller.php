<?php

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        // Transforme les clés du tableau $data en variables PHP
        // ex: ['rows' => $rows] → $rows disponible dans la vue
        extract($data, EXTR_SKIP);

        // Chemin absolu vers la vue
        $viewPath = APP_PATH . '/views/' . $view . '.php';

        // Sécurité : vérifier que la vue existe
        if (!file_exists($viewPath)) {
            throw new Exception("Vue introuvable : " . $viewPath);
        }

        // Inclusion de la vue
        require $viewPath;
    }
}
