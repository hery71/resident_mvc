<?php
class Router
{
    private $routes = [];
    private $basePath = ''; // Chemin de base (ex: "/mon-projet") si ton site n'est pas à la racine

    /**
     * Ajoute une route au router.
     * @param string $method (GET, POST, etc.)
     * @param string $path (ex: "/cake/order/{year}/{month}")
     * @param string $controller (ex: "CakeController@orderList")
     */
    public function add($method, $path, $controller)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $this->normalizePath($path),
            'controller' => $controller,
            'regex' => $this->pathToRegex($path)
        ];
    }

    /**
     * Convertit un chemin comme "/cake/{year}" en regex.
     */
    private function pathToRegex($path)
    {
        // Remplace {param} par des groupes nommés dans la regex
        $regex = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[^/]+)', str_replace(')', '\\)', $path));
        return '@^' . $this->normalizePath($regex) . '$@D';
    }

    /**
     * Normalise le chemin (supprime les / en double, etc.).
     */
    private function normalizePath($path)
    {
        $path = trim($path, '/');
        return $this->basePath . '/' . $path;
    }

    /**
     * Traite la requête entrante et exécute le contrôleur correspondant.
     */
    public function dispatch()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = $this->normalizePath($requestUri);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            if (preg_match($route['regex'], $requestUri, $matches)) {
                // Extrait les paramètres nommés (ex: year, month)
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                unset($params[0]); // Supprime le match complet

                // Sépare le contrôleur et la méthode (ex: "CakeController@orderList")
                list($controllerName, $methodName) = explode('@', $route['controller']);

                // Instancie le contrôleur et appelle la méthode
                $controller = new $controllerName();
                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }

        // Aucune route trouvée : 404
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page non trouvée";
    }
}
