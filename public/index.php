<?php

/**
 * Point d'entrée principal de l'application Touche-pas-au-Klaxon 
 * @author Simon 
 * @version 1.0
 */

// Affichage des erreurs de développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoloader Composer
require_once __DIR__. '/../vendor/autoload.php';

// Chargement des variables d'environements
if (file_exists(__DIR__. '/../.env')) {
    $lines = file(__DIR__. '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

// Démarrage de la session 
session_start();

// Routeur simple pour commencer 
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

// Routes de base 
switch ($path) {
    case '/' :
        echo "Bienvenue sur Touche pas au klaxon - Page d'acceuil en construction";
        break;
    case '/login' :
        echo "Page de connexion - En construction";
        break;
    default:
    http_response_code(404);
    echo "Page non trouvée";
    break;
}

?>