<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Trip;
use App\Models\Agence;

class AdminController {

    public function __construct()
    {
        // Contrôle d'accès admin uniquement
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php'); 
            exit;
        }
    }

    /**
     * Méthode privée pour charger les modèles et leurs données
     */
    private function loadData(): array
    {
        return [
            'users' => User::getAll(),
            'trips' => (new Trip())->tripAvailable(),
            'agences' => Agence::getAll()
        ];
    }

    /**
     * Dashboard admin
     */
    public function dashboard()
    {
        $data = $this->loadData();
        require __DIR__ . '/../Views/admin/dashboard.php';
    }

    /**
     * Liste des utilisateurs
     */
    public function listUsers()
    {
        $users = User::getAll();
        require __DIR__ . '/../Views/admin/users/listUsers.php';
    }

    /**
     * Liste des trajets
     */
    public function listTrips()
    {
        $trips = (new Trip())->tripAvailable();
        require __DIR__ . '/../Views/admin/trips/listTrips.php';
    }

    /**
     * Supprimer un trajet
     */
    public function deleteTrip(int $id_trajet)
    {
        Trip::delete($id_trajet);
        header('Location: index.php?controller=admin&action=listTrips');
        exit;
    }

    /**
     * Liste des agences
     */
    public function listAgences()
    {
        $agences = Agence::getAll();

        require __DIR__ . '/../Views/admin/agencies/listAgences.php';
    }

    /**
     * Créer une agence
     */
    public function createAgence()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ville = trim($_POST['ville']);
            Agence::create(['ville' => $ville]);
            header('Location: index.php?controller=admin&action=listAgences');
            exit;
        }

        $agences = Agence::getAll(); 
        require __DIR__ . '/../Views/admin/agencies/createAgence.php';
    }

    /**
     * modifier une agence
     */
    public function editAgence(int $id_agence)
    {
        $agence = Agence::find($id_agence);

        if(!$agence) {
            header('Location: index.php?controller=admin&action=listAgences');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ville = trim($_POST['ville']);
            Agence::update($id_agence, ['ville' => $ville]);
            header('Location: index.php?controller=admin&action=listAgences');
            exit;
        }

        require __DIR__ . '/../Views/admin/agencies/editAgence.php';
    }


    /**
     * Supprimer une agence
     */
    public function deleteAgence(int $id_agence)
    {
        Agence::delete($id_agence);
        header('Location: index.php?controller=admin&action=listAgences');
        exit;
    }
}
