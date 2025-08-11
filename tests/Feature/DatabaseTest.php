<?php

use PHPUnit\Framework\TestCase;
use App\Config\Database;

class DatabaseTest extends TestCase
{   

    // on test getConnection retourne bien un objet PDO
    public function testConnexionBDD() {
        $db = Database::getInstance()->getConnection();
        $this->assertInstanceOf(PDO::class, $db, "la connexion doit retourner un objet PDO");
    }

    // text de connexion et gestion d'erreurs
    public function testConnexionBDD_Erreur() {
        $this->expectException(\PDOException::class);(PDOException::class);

        // Création d'un faux objet Database 
        $reflection = new ReflectionClass(Database::class);
        $constructor = $reflection->getConstructor();
        $constructor->setAccessible(true);

        // Variable .env invalide
        putenv('DB_HOST=localhost');
        putenv('DB_NAME=bad_database');
        putenv('DB_USER=fake_user');
        putenv('DB_PASS=fake_pass');

        $constructor->invoke(Database::getInstance());
    }

}