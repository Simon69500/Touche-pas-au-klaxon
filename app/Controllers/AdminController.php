<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Trip;
use App\Models\Agence;

/**
 * Contrôleur administratif.
 * 
 * Permet la gestion des utilisateurs, trajets et agences.
 * Accessible uniquement aux administrateurs.
 */
class AdminController {

    /**
     * Vérifie l'accès admin lors de la construction.
     */
    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php'); 
            exit;
        }
    }

    /**
     * Charge les données des modèles pour le dashboard.
     *
     * @return array{
     *   users: array<int, array<string, mixed>>,
     *   trips: array<array<string, mixed>>,
     *   agences: array<int, array{id_agence: int, ville: string}>
     * }
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
     * Affiche le dashboard admin.
     *
     * @return void
     */
    public function dashboard(): void
    {
        $data = $this->loadData();
        require __DIR__ . '/../Views/admin/dashboard.php';
    }

    /**
     * Liste tous les utilisateurs.
     *
     * @return void
     */
    public function listUsers(): void
    {
        /** @var User[] $users */
        $users = User::getAll();
        require __DIR__ . '/../Views/admin/users/listUsers.php';
    }

    /**
     * Liste tous les trajets disponibles.
     *
     * @return void
     */
    public function listTrips(): void
    {
        /** @var Trip[] $trips */
        $trips = (new Trip())->tripAvailable();
        require __DIR__ . '/../Views/admin/trips/listTrips.php';
    }

    /**
     * Supprime un trajet.
     *
     * @param int $id_trajet Identifiant du trajet
     * @return void
     */
    public function deleteTrip(int $id_trajet): void
    {
        Trip::delete($id_trajet);
        header('Location: index.php?controller=admin&action=listTrips');
        exit;
    }

    /**
     * Liste toutes les agences.
     *
     * @return void
     */
    public function listAgences(): void
    {
        /** @var Agence[] $agences */
        $agences = Agence::getAll();
        require __DIR__ . '/../Views/admin/agencies/listAgences.php';
    }

    /**
     * Crée une nouvelle agence.
     *
     * @return void
     */
    public function createAgence(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ville = trim($_POST['ville']);
            Agence::create(['ville' => $ville]);
            header('Location: index.php?controller=admin&action=listAgences');
            exit;
        }

        /** @var Agence[] $agences */
        $agences = Agence::getAll(); 
        require __DIR__ . '/../Views/admin/agencies/createAgence.php';
    }

    /**
     * Modifie une agence existante.
     *
     * @param int $id_agence ID de l’agence
     * @return void
     */

    public function editAgence(int $id_agence): void
    {
        /** @var Agence|null $agence */
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
     * Modifie une agence existante.
     *
     * @param int $id_agence ID de l'agence
     * @return void
     */

    public function deleteAgence(int $id_agence): void
    {
        Agence::delete($id_agence);
        header('Location: index.php?controller=admin&action=listAgences');
        exit;
    }
}
