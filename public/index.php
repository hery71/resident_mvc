<?php
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', dirname(__DIR__) . '/app');

// Démarrer la session une seule fois, ici
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => false,   // local HTTP
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}
require_once __DIR__ . '/../app/config/db.php';
// Affichage des erreurs (DEV uniquement)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ==================================================
// FRONT CONTROLLER MVC
// ==================================================



// --------------------------------------------------
// Autoload simple (controllers / models / core)
// --------------------------------------------------
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/',
        __DIR__ . '/../app/core/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/config/config.php';

require_once dirname(__DIR__) . '/app/core/Router.php';
require_once dirname(__DIR__) . '/app/controllers/IngredientController.php';
//-----------------------------------ROUTES---------------------------------------
// --------------------------------------------------
// Définition des routes avec le Router
/*
$router = new Router();

$router->add('GET',  '/alimentaire/preparation/ingredient/edit', 'IngredientController@edit');
$router->add('POST', '/alimentaire/preparation/ingredient/edit', 'IngredientController@edit');

$router->dispatch();
*/
// --------------------------------------------------
// Récupération de l’URL
// Exemple : /residents/index
// --------------------------------------------------
$url = $_GET['url'] ?? '';
$url = trim($url, '/');
$urlParts = explode('/', $url);
// --------------------------------------------------
// PROTECTION PAR SESSION (AUTH)
// --------------------------------------------------
$publicRoutes = [
    'auth/login',
    'auth/authenticate',
    'auth/logout'
];

// URL demandée (ex: auth/login, birthday/index, resident, etc.)
//$currentRoute = $urlParts[0] ?? '';

// Autoriser les routes publiques
$isPublic = false;
foreach ($publicRoutes as $route) {
   if (str_starts_with($url, $route)) {
       $isPublic = true;
    }
}

// Si non connecté et route non publique → redirection login
if (!isset($_SESSION['user']) && !$isPublic) {
    header('Location: /auth/login');
    exit;
}

// --------------------------------------------------
// Définition Controller / Méthode
// --------------------------------------------------
$controllerName = !empty($urlParts[0])
    ? ucfirst($urlParts[0]) . 'Controller'
    : 'DashBoardController';

if (!class_exists($controllerName)) {
    http_response_code(404);
    echo "404 – Page introuvable (controller)";
    exit;
} 

$controller = new $controllerName();

$methodName = $urlParts[1] ?? 'index';

if (!method_exists($controller, $methodName)) {
    http_response_code(404);
    echo "404 – Méthode introuvable";
    exit;
}
$params = array_slice($urlParts, 2);
call_user_func_array([$controller, $methodName], $params);

