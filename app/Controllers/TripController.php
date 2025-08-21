<?php

namespace App\Controllers;

use App\Models\Trip;
use App\Models\Agence;

class TripController
{

    // Afficher le formulaire de création de trajet
    public function createForm()
    {
        $agenceModel = new Agence();
        $agences = $agenceModel->getAll();
        require __DIR__ . '/../Views/trips/create.php';
    }

    // Traiter le formulaire de création
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

    // -- Afficher le formulaire d'édition --
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
    
    // -- Traiter le formulaire d'édition --
    public function edit()
    {

        $id_trajet = $_GET['id'] ?? null;
        if(!$id_trajet){
            header('Location: ' . \App\Config\Config::baseUrl());
            exit;
        }

        $tripModel = new Trip();
        $trip = $tripModel->tripFind($id_trajet);

        // Sécurité : seul l'auteur peut éditer 
        if(!$trip || $trip['auteur_id'] != $_SESSION['user']['id']) {
            header('Location: ' . \App\Config\Config::baseUrl() );
            exit;
        }

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

        if (empty($errors)) {
                //  recalcul places_dispo si places_total changé
                if ((int)$_POST['places_total'] != $trip['places_total']) {
                    $_POST['places_dispo'] = $_POST['places_total'] - ($trip['places_total'] - $trip['places_dispo']);
                }            

            $tripModel->tripUpdate($id_trajet, $_POST);
            header('Location: ' . \App\Config\Config::baseUrl());
            exit;
        } else {
            // si erreurs , recharger le formulaire avec erreurs
            $agenceModel = new Agence();
            $agences = $agenceModel->getAll();
            require __DIR__ . '/../Views/trips/edit.php';
        }        
    }



    /**
     * Supprimer un trajet 
     * @method delete
     */
    public function delete() 
    {

        session_start();

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

        // Rediriger vers la liste après suppression
        header('Location: ' . \App\Config\Config::baseUrl());
        exit;
    }

    public function home() {
    $tripModel = new \App\Models\Trip();
    $trips = $tripModel->tripAvailable(); // méthode à créer dans le modèle
    require __DIR__ . '/../Views/home/home.php';
}
}