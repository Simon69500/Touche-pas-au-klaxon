<?php
/**
 * Bootstrap pour les tests PHPUnit
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Configuration spécifique aux tests
$_ENV['APP_ENV'] = 'testing';
$_ENV['DB_NAME'] = 'touche_pas_au_klaxon_test';