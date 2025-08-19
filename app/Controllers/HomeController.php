<?php

namespace App\Controllers;

use App\Models\Trip;
use App\Config\Database;

class HomeController 
{
    public function index() 
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