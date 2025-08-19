<?php

// Autoload Composer pour charger toutes les classes
require_once __DIR__ . '/vendor/autoload.php';

// Démarrage de la session
session_start();

// Chargement des classes nécessaires
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Config\Config;

// Route simple 
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'login':
        $controller = new AuthController();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->loginForm();
        }
        break;

    case 'register':
        $controller = new AuthController();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            $controller->registerForm();
        }
        break;

    case 'logout': 
        $controller = new AuthController();
        $controller->logout();
        break;

    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}
