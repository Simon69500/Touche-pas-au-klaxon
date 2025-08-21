<?php

namespace Tests\Unit\Models;

use App\Config\Database;
use PHPUnit\Framework\TestCase;
use App\Models\Trip;

class TripTest extends TestCase 
{   
    
    protected function setUp(): void
    {
        // On active l'environnement de test 
        putenv('APP_ENV=testing');

        // Connexion a la BDD test 
        $pdo = Database::getInstance()->getConnection();

        // On vide la table avant chaque test 
        $pdo->exec("TRUNCATE TABLE trajets");
    }


    // 1. Test : Création d'un trajet
    public function testCreateTrip() 
    {
        $trip = new Trip;

        $data = [
            'agence_depart_id' => 1,
            'agence_arrive_id' => 2,
            'contact_id' => 1,
            'auteur_id' => 1,
            'places_dispo' => 10,
            'places_total' => 10,
            'date_heure_depart' => '2025-08-22 10:00:00',
            'date_heure_arrive' => '2028-08-22 12:00:00'
        ];

        $result = $trip->create($data);

        // Vérifie que la creation a retouné true 
        $this->assertTrue($result);

        // Vérifie qu'on a bien 1 trajet en BDD 
        $allTrips = Trip::getAll();
        $this->assertCount(1, $allTrips);

        // Vérifie que les données sont correctes 
        $this->assertEquals(10, $allTrips[0]['places_total']);
        $this->assertEquals('2025-08-22 10:00:00', $allTrips[0]['date_heure_depart']);
    }


    // 2. Test : modification d'un trajet
    public function testUpdateTrip()
    {
        $trip = new Trip();
        
        // on crée un trajet
        $data =  [
        'agence_depart_id' => 1,
        'agence_arrive_id' => 2,
        'contact_id' => 1,
        'auteur_id' => 1,
        'places_total' => 10,
        'places_dispo' => 10,
        'date_heure_depart' => '2025-08-22 10:00:00',
        'date_heure_arrive' => '2025-08-22 12:00:00'
    ];

    $trip->create($data);

    // Récupérer l'id du trajet créé
    $allTrips = Trip::getAll();
    $id = $allTrips[0]['id_trajet'];

    // Mettre à jour certaines valeurs
    $updateData = [
        'agence_depart_id' => 2,
        'agence_arrive_id' => 3,
        'places_total' => 12,
        'places_dispo' => 12,
        'date_heure_depart' => '2025-08-22 11:00:00',
        'date_heure_arrive' => '2025-08-22 13:00:00'        
    ];

    $result = $trip->tripUpdate($id, $updateData);

    // Assertions
    $this->assertTrue($result, 'tripUpdate should return true');

    $updatedTrip = Trip::tripFind($id);

    $this->assertEquals(2, $updatedTrip['agence_depart_id']);
    $this->assertEquals(3, $updatedTrip['agence_arrive_id']);
    $this->assertEquals(12, $updatedTrip['places_total']);
    $this->assertEquals('2025-08-22 11:00:00', $updatedTrip['date_heure_depart']);
    }


    // 3. Test : Récupérer un trajet via son ID 
    public function testFindTrip()
    {
        $trip = new Trip();

        // Créer un trajet pour le tester
        $data = [
            'agence_depart_id' => 1,
            'agence_arrive_id' => 2,
            'contact_id' => 1,
            'auteur_id' => 1,
            'places_total' => 10,
            'places_dispo' => 10,
            'date_heure_depart' => '2025-08-22 14:00:00',
            'date_heure_arrive' => '2025-08-22 16:00:00'
        ];
        $trip->create($data);

        // Récupérer l'ID
        $id = Trip::getAll()[0]['id_trajet'];

        // Tester tripFind()
        $foundTrip = Trip::tripFind($id);
        $this->assertNotNull($foundTrip, 'tripFind should return a trip array');
        $this->assertEquals(1, $foundTrip['agence_depart_id']);
        $this->assertEquals(2, $foundTrip['agence_arrive_id']);
    }


    // 4. Test : Supprimer un trajet 
    public function testDeleteTrip()
    {
        $trip = new Trip();

        // Créer un trajet pour le supprimer
        $data = [
            'agence_depart_id' => 1,
            'agence_arrive_id' => 2,
            'contact_id' => 1,
            'auteur_id' => 1,
            'places_total' => 10,
            'places_dispo' => 10,
            'date_heure_depart' => '2025-08-22 18:00:00',
            'date_heure_arrive' => '2025-08-22 20:00:00'
        ];
        $trip->create($data);

        // Récupérer l'ID
        $id = Trip::getAll()[0]['id_trajet'];

        // Supprimer le trajet
        $result = Trip::delete($id);
        $this->assertTrue($result, 'delete should return true');

        // Vérifier que le trajet n'existe plus
        $deletedTrip = Trip::tripFind($id);
        $this->assertNull($deletedTrip, 'Deleted trip should be null');
    }


    // 5. Test : On test la methode tripAvailable() 
    public function testTripAvailable()
    {
        $trip = new Trip();

        // 1️ Trajet disponible
        $trip->create([
            'agence_depart_id' => 1,
            'agence_arrive_id' => 2,
            'contact_id' => 1,
            'auteur_id' => 1,
            'places_total' => 10,
            'places_dispo' => 5, // places dispo > 0
            'date_heure_depart' => date('Y-m-d H:i:s', strtotime('+1 day')), // futur
            'date_heure_arrive' => date('Y-m-d H:i:s', strtotime('+1 day +2 hours'))
        ]);

        // 2️ Trajet complet (places_dispo = 0)
        $trip->create([
            'agence_depart_id' => 2,
            'agence_arrive_id' => 3,
            'contact_id' => 1,
            'auteur_id' => 1,
            'places_total' => 10,
            'places_dispo' => 0, // pas de place
            'date_heure_depart' => date('Y-m-d H:i:s', strtotime('+1 day')),
            'date_heure_arrive' => date('Y-m-d H:i:s', strtotime('+1 day +2 hours'))
        ]);

        // 3️ Trajet passé
        $trip->create([
            'agence_depart_id' => 3,
            'agence_arrive_id' => 4,
            'contact_id' => 1,
            'auteur_id' => 1,
            'places_total' => 10,
            'places_dispo' => 5,
            'date_heure_depart' => date('Y-m-d H:i:s', strtotime('-1 day')), // passé
            'date_heure_arrive' => date('Y-m-d H:i:s', strtotime('-1 day +2 hours'))
        ]);

        // Vérifier les trajets disponibles
        $availableTrips = $trip->tripAvailable();

        $this->assertCount(1, $availableTrips, 'Il doit y avoir exactement 1 trajet disponible');
        $this->assertEquals('Paris', $availableTrips[0]['ville_depart']);
        $this->assertEquals('Lyon', $availableTrips[0]['ville_arrivee']);

    }
}