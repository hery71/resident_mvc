<?php
/*************************************************
 * FRONT CONTROLLER – MVC AVEC ROUTER
 *************************************************/

// ------------------------------------------------
// CONSTANTES
// ------------------------------------------------
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

// ------------------------------------------------
// SESSION
// ------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => false,   // HTTP local
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// ------------------------------------------------
// BASE DE DONNÉES
// ------------------------------------------------
require_once APP_PATH . '/config/db.php';

// ------------------------------------------------
// ERREURS (DEV)
// ------------------------------------------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ------------------------------------------------
// AUTOLOAD (controllers / models / core)
// ------------------------------------------------
spl_autoload_register(function ($class) {
    foreach (['controllers', 'models', 'core'] as $dir) {
        $file = APP_PATH . "/$dir/$class.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// ------------------------------------------------
// HELPERS & CONFIG
// ------------------------------------------------
require_once APP_PATH . '/core/helpers.php';
require_once APP_PATH . '/config/config.php';

// ------------------------------------------------
// ROUTER
// ------------------------------------------------
$router = new Router();

/*************************************************
 * ROUTES – MENU PRINCIPAL
 *************************************************/

// ======================
// ACCUEIL
// ======================
$router->add('GET', '/', 'ResidentController@index');

// ======================
// RÉSIDENTS
// ======================
$router->add('GET', '/resident', 'ResidentController@index');
$router->add('GET', '/resident/create', 'ResidentController@create');
$router->add('POST', '/resident/store',  'ResidentController@store');
$router->add('GET', '/resident/edit',  'ResidentController@edit');

// ======================
// ANNIVERSAIRES
// ======================
$router->add('GET', '/birthday', 'BirthdayController@index');
$router->add('GET', '/cake/cake_list_order', 'CakeController@cake_list_order');

// ======================
// FÊTES
// ======================
$router->add('GET', '/fete', 'FeteController@index');
$router->add('GET', '/fete/create', 'FeteController@create');

// ======================
// MÉNAGE
// ======================
$router->add('GET', '/menage', 'MenageController@index');

// ======================
// SERVICE ALIMENTAIRE
// ======================
$router->add('GET', '/alimentaire/index', 'AlimentaireController@index');
$router->add('GET', '/alimentaire/saison', 'AlimentaireController@saison');

// ======================
// MENUS
// ======================
$router->add('GET', '/menu/edit', 'MenuController@edit');
$router->add('GET', '/menu/dailyMenu', 'MenuController@dailyMenu');
$router->add('GET', '/menu/weeklyMenu', 'MenuController@weeklyMenu');
$router->add('GET', '/menu/monthlyMenu', 'MenuController@monthlyMenu');
$router->add('GET', '/menu/special', 'MenuController@special');

// ======================
// INGRÉDIENTS
// ======================
$router->add('GET',  '/ingredient/edit', 'IngredientController@edit');
$router->add('POST', '/ingredient/edit', 'IngredientController@edit');

// ======================
// PARAMÈTRES
// ======================
$router->add('GET', '/parametres', 'ParametresController@index');

// ======================
// AUTH
// ======================
$router->add('GET',  '/auth/login', 'AuthController@login');
$router->add('POST', '/auth/authenticate', 'AuthController@authenticate');
$router->add('GET',  '/auth/logout', 'AuthController@logout');

// ------------------------------------------------
// DISPATCH FINAL (UNIQUE)
// ------------------------------------------------
$router->dispatch();
