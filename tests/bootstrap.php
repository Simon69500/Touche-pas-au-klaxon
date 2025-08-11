<?php
/**
 * Bootstrap pour les tests PHPUnit
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Configuration spécifique aux tests
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Vérification
echo "DB_USER depuis bootstrap: ";
var_dump(getenv('DB_USER'));