<?php

namespace App\Controllers;

use App\Models\Trip;
use App\Config\Database;

/**
 * Contrôleur principal de l'application.
 * 
 * Gère l'affichage de la page d'accueil et la récupération des trajets disponibles.
 */
class HomeController 
{
    /**
     * Affiche la page d'accueil avec les trajets disponibles.
     *
     * @return void
     */
    public function index(): void
    {
        // Connexion à la base
        $db = Database::getInstance()->getConnection();

        // Récupération des trajets disponibles
        $tripModel = new Trip();
        $trips = $tripModel->tripAvailable();

        // Inclusion de la vue
        require __DIR__ . '/../Views/home/home.php';
    }
}
