<?php

namespace Tests\Unit\Models;

use App\Config\Database;
use PHPUnit\Framework\TestCase;
use App\Models\Agence;

class AgenceTest extends TestCase
{
    protected $pdo;

    protected function setUp(): void
    {
        // On active l'environnement de test
        putenv('APP_ENV=testing');

        // Connexion à la BDD test
        $this->pdo = Database::getInstance()->getConnection();

        // Désactiver temporairement les contraintes FK pour vider les tables
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS=0");

        // Vider les tables
        $this->pdo->exec("TRUNCATE TABLE trajets");
        $this->pdo->exec("TRUNCATE TABLE agences");

        // Réactiver les contraintes FK
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS=1");
    }

    public function testCreateAgence()
    {
        $data = ['ville' => 'Paris'];
        $result = Agence::create($data);

        $this->assertTrue($result);

        $allAgences = Agence::getAll();
        $this->assertCount(1, $allAgences);
        $this->assertEquals('Paris', $allAgences[0]['ville']);
    }

    public function testGetAllAgences()
    {
        Agence::create(['ville' => 'Lyon']);
        Agence::create(['ville' => 'Marseille']);

        $allAgences = Agence::getAll();

        $this->assertCount(2, $allAgences);
        $this->assertEquals('Lyon', $allAgences[0]['ville']);
        $this->assertEquals('Marseille', $allAgences[1]['ville']);
    }

    public function testFindAgence()
    {
        Agence::create(['ville' => 'Nice']);
        $id = Agence::getAll()[0]['id_agence'];

        $found = Agence::find($id);
        $this->assertNotNull($found);
        $this->assertEquals('Nice', $found['ville']);
    }

    public function testUpdateAgence()
    {
        Agence::create(['ville' => 'Toulouse']);
        $id = Agence::getAll()[0]['id_agence'];

        $result = Agence::update($id, ['ville' => 'Bordeaux']);
        $this->assertTrue($result);

        $updated = Agence::find($id);
        $this->assertEquals('Bordeaux', $updated['ville']);
    }

    public function testDeleteAgence()
    {
        Agence::create(['ville' => 'Strasbourg']);
        $id = Agence::getAll()[0]['id_agence'];

        $result = Agence::delete($id);
        $this->assertTrue($result);

        $deleted = Agence::find($id);
        $this->assertNull($deleted);
    }
}
