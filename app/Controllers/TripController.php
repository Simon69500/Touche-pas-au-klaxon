<?php

namespace App\Controllers;

use App\Models\Trip;
use App\Models\Agence;

/**
 * Contrôleur gérant les trajets.
 * 
 * Permet de créer, éditer, supprimer et afficher les trajets.
 */
class TripController
{

    /**
     * Affiche le formulaire de création de trajet.
     *
     * @return void
     */
    public function createForm()
    {
        $agenceModel = new Agence();
        $agences = $agenceModel->getAll();
        require __DIR__ . '/../Views/trips/create.php';
    }


    /**
     * Traite le formulaire de création de trajet.
     *
     * @return void
     */
    public function create()
    {
        $errors = [];

        // Validation agences différentes
        if($_POST['agence_depart_id'] === $_POST['agence_arrive_id']) {
            $errors[] = "L'agence de départ et d'arrivée doivent être différentes.";
        }

        // Validation dates cohérentes
        $depart = strtotime($_POST['date_heure_depart']);
        $arrive = strtotime($_POST['date_heure_arrive']);
        if ($arrive <= $depart) {
            $errors[] = "La date et heure d'arrivée doivent être après la date de départ.";
        }

        // Validation places > 0
        if((int)$_POST['places_total'] <= 0) {
            $errors[] = "Le nombre de places doit être supérieur à 0.";
        }

        if(empty($errors)) {
            $tripModel = new Trip();

            $_POST['contact_id'] = $_SESSION['user']['id'];
            $_POST['auteur_id']  = $_SESSION['user']['id'];
            $_POST['places_dispo'] = $_POST['places_total'];            

        $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => "Le trajet a été créer avec succès !"
        ];

            $tripModel->create($_POST);
            header('Location: ' . \App\Config\Config::baseUrl());
            exit;
        } else {
            // si erreurs , recharger le formulaire avec erreurs
            $agenceModel = new Agence();
            $agences = $agenceModel->getAll();
            require __DIR__ . '/../Views/trips/create.php';
        }
    }


    /**
     * Affiche le formulaire d'édition pour un trajet existant.
     *
     * @return void
     */
    public function editForm()
    {

        $id_trajet = $_GET['id'] ?? null;
        if(!$id_trajet) {
            header('Location:' . \App\Config\Config::baseUrl());
            exit;
        }

        $tripModel = new Trip();
        $trip = $tripModel->tripFind($id_trajet);

        // Sécurité : seul l'auteur peut éditer 
        if(!$trip || $trip['auteur_id'] != $_SESSION['user']['id']) {
            header('Location :' . \App\Config\Config::baseUrl() );
            exit;
        }

        $agenceModel = new Agence;
        $agences = $agenceModel->getAll();

        $errors = [];
        require __DIR__ .  '/../Views/trips/edit.php';
    }
    

    /**
     * Traite le formulaire d'édition d'un trajet.
     *
     * @return void
     */
    public function edit() {
    $id_trajet = $_GET['id'] ?? null;
    if (!$id_trajet) {
        header('Location: ' . \App\Config\Config::baseUrl());
        exit;
    }

    $tripModel = new Trip();
    $trip = $tripModel->tripFind($id_trajet);

    if (!$trip || $trip['auteur_id'] != $_SESSION['user']['id']) {
        header('Location: ' . \App\Config\Config::baseUrl());
        exit;
    }

    $errors = [];

    // Validation agences différentes
    if ($_POST['agence_depart_id'] === $_POST['agence_arrive_id']) {
        $errors[] = "L'agence de départ et d'arrivée doivent être différentes.";
    }

    // Validation dates cohérentes
    $depart = strtotime($_POST['date_heure_depart']);
    $arrive = strtotime($_POST['date_heure_arrive']);
    if (!$depart || !$arrive || $arrive <= $depart) {
        $errors[] = "La date et heure d'arrivée doivent être après la date de départ.";
    }

    // Validation places > 0
    $places_total = (int)$_POST['places_total'];
    if ($places_total <= 0) {
        $errors[] = "Le nombre de places doit être supérieur à 0.";
    }

    if (empty($errors)) {

        $places_dispo = $trip['places_dispo'] + ($places_total - $trip['places_total']);
        if ($places_dispo < 0) $places_dispo = 0;

        $_POST['places_dispo'] = $places_dispo;

        $tripModel->tripUpdate($id_trajet, $_POST);

        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Le trajet a bien été modifié avec succès !'
        ];

        header('Location: ' . \App\Config\Config::baseUrl());
        exit;
    } else {
        $agenceModel = new Agence();
        $agences = $agenceModel->getAll();
        require __DIR__ . '/../Views/trips/edit.php';
    }
}


    /**
     * Supprime un trajet.
     *
     * Vérifie que l'utilisateur connecté est l'auteur du trajet.
     *
     * @return void
     */

    public function delete() 
    {

        $tripModel = new Trip();
        $trip = null;

        if(!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $id_trajet = $_GET['id'] ?? null;
        if($id_trajet) {
            $tripModel = new Trip();
            $trip = $tripModel->tripFind($id_trajet);
        }

        // Sécurité : vérifier que l'utilisateur est bien l'auteur
        if($trip && $trip['auteur_id'] == $_SESSION['user']['id']) {
            $tripModel->delete($id_trajet);
        }
        
        // Après suppression
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Le trajet a bien été supprimé !'
        ];

        // Rediriger vers la liste après suppression
        header('Location: ' . \App\Config\Config::baseUrl());
        exit;
    }

    
    /**
     * Affiche la page d'accueil avec les trajets disponibles.
     *
     * @return void
     */
    public function home() {
    $tripModel = new \App\Models\Trip();
    $trips = $tripModel->tripAvailable(); // méthode à créer dans le modèle
    require __DIR__ . '/../Views/home/home.php';
}
}