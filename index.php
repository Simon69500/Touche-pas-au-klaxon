<?php
// index.php à la racine du projet

// Autoload Composer pour charger toutes les classes
require_once __DIR__ . '/vendor/autoload.php';

// Démarrage de la session
session_start();

// Chargement des classes nécessaires
use App\Config\Database;
use App\Models\Trip;

// --- Connexion à la base de données ---
$db = Database::getInstance()->getConnection();

// --- Récupération des trajets (seulement ceux avec des places dispo et date future) ---
$tripModel = new Trip();
$trips = $tripModel->tripAvailable(); 

// --- Inclusion de la vue home.php ---
include __DIR__ . '/app/Views/home/home.php';
