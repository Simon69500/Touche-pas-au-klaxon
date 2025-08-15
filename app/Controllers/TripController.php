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
        $agences = $agenceModel->agenceAll();
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
        if((int)$_POST['places_dispo'] <= 0) {
            $errors[] = "Le nombre de places doit être supérieur à 0.";
        }

        if(empty($errors)) {
            $tripModel = new Trip();
            $_POST['places_dispo'] = $_POST['places_total'];
            $tripModel->create($_POST);
            header('Location: /trips');
            exit;
        } else {
            // si erreurs , recharger le formulaire avec erreurs
            $agenceModel = new Agence();
            $agences = $agenceModel->agenceAll();
            require __DIR__ . '/../Views/trips/create.php';
        }
    }
}