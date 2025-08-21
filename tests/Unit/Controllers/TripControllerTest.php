<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use App\Models\Trip;
use App\Models\User;
use App\Models\Agence;

class TripControllerTest extends TestCase
{
    private int $userId;
    private int $contactId;
    private int $agenceDepartId;
    private int $agenceArriveId;

    /**
     * Méthode helper pour récupérer le dernier ID inséré
     * dans la base via ReflectionProperty (car $pdo est private).
     */
    private function getLastInsertId($model): string
    {
        $refPdo = new \ReflectionProperty(get_class($model), 'pdo');
        $refPdo->setAccessible(true);
        $pdo = $refPdo->getValue($model);
        return $pdo->lastInsertId();
    }

    /**
     * Création de données de test avant chaque test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // --- Création utilisateur auteur ---
        $user = new User();
        $userData = [
            'nom' => 'TestAuteur',
            'prenom' => 'User',
            'email' => 'auteur_' . uniqid() . '@example.com',
            'password' => 'secret',
            'role' => 'employe',
            'telephone' => '0102030405'
        ];
        $user->create($userData);
        $this->userId = $this->getLastInsertId($user);

        // --- Création utilisateur contact ---
        $contact = new User();
        $contactData = [
            'nom' => 'TestContact',
            'prenom' => 'User',
            'email' => 'contact_' . uniqid() . '@example.com',
            'password' => 'secret',
            'role' => 'employe',
            'telephone' => '0102030405'
        ];
        $contact->create($contactData);
        $this->contactId = $this->getLastInsertId($contact);

        // --- Création agence départ ---
        $agenceDepart = new Agence();
        $agenceDepartData = ['ville' => 'Paris_' . uniqid()];
        $agenceDepart->create($agenceDepartData);
        $this->agenceDepartId = $this->getLastInsertId($agenceDepart);

        // --- Création agence arrivée ---
        $agenceArrive = new Agence();
        $agenceArriveData = ['ville' => 'Lyon_' . uniqid()];
        $agenceArrive->create($agenceArriveData);
        $this->agenceArriveId = $this->getLastInsertId($agenceArrive);
    }

    /**
     * Test pour vérifier que l'on peut récupérer les agences
     */
    public function testAgencesRetrievedFromModel(): void
    {
        $agence = new Agence();
        $allAgences = $agence->getAll();
        $this->assertIsArray($allAgences, 'Les agences doivent être retournées sous forme de tableau');
        $this->assertNotEmpty($allAgences, 'Il doit y avoir au moins une agence dans la base');
    }

    /**
     * Test pour créer un trajet
     */
    public function testCreateTripSetsDataCorrectly(): void
    {
        $trip = new Trip();
        $tripData = [
            'agence_depart_id' => $this->agenceDepartId,
            'agence_arrive_id' => $this->agenceArriveId,
            'contact_id' => $this->contactId,
            'auteur_id' => $this->userId,
            'places_total' => 5,
            'places_dispo' => 5,
            'date_heure_depart' => date('Y-m-d H:i:s', strtotime('+1 day')),
            'date_heure_arrive' => date('Y-m-d H:i:s', strtotime('+1 day +2 hours')),
        ];

        $result = $trip->create($tripData);
        $this->assertTrue($result, 'La création du trajet doit renvoyer true');

        // Vérifier que le trajet existe bien
        $trips = $trip->getAll();
        $this->assertNotEmpty($trips, 'La liste des trajets ne doit pas être vide après création');
        $lastTrip = end($trips);
        $this->assertEquals($tripData['agence_depart_id'], $lastTrip['agence_depart_id']);
        $this->assertEquals($tripData['agence_arrive_id'], $lastTrip['agence_arrive_id']);
        $this->assertEquals($tripData['contact_id'], $lastTrip['contact_id']);
        $this->assertEquals($tripData['auteur_id'], $lastTrip['auteur_id']);
    }
}
