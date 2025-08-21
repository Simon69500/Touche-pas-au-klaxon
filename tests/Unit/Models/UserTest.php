<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * Préparation avant chaque test
     * 
     * - Supprime l'utilisateur de test s'il existe déjà.
     * - Crée un utilisateur admin avec mot de passe hashé pour les tests.
     */
    protected function setUp(): void
    {
        $pdo = \App\Config\Database::getInstance()->getConnection();

        // Supprime l'utilisateur si présent
        $pdo->exec("DELETE FROM users WHERE email='admin@entreprise.fr'");

        // Création du mot de passe hashé
        $passwordHash = password_hash('password123', PASSWORD_DEFAULT);

        // Insertion de l'utilisateur admin
        $stmt = $pdo->prepare(
            "INSERT INTO users (nom, prenom, email, password_hash, role) 
             VALUES (:nom, :prenom, :email, :password_hash, :role)"
        );
        $stmt->execute([
            ':nom' => 'Admin',
            ':prenom' => 'Super',
            ':email' => 'admin@entreprise.fr',
            ':password_hash' => $passwordHash,
            ':role' => 'admin'
        ]);
    }

    /**
     * Test : Authentification réussie
     * Vérifie qu'un utilisateur existant peut se connecter avec le bon mot de passe.
     */
    public function testAuthenticateSuccess()
    {
        $email = 'admin@entreprise.fr';
        $password = 'password123';

        $user = User::authenticate($email, $password);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals('admin', $user->getRole());
    }

    /**
     * Test : Authentification avec mauvais mot de passe
     * Vérifie que l'utilisateur ne peut pas se connecter avec un mot de passe incorrect.
     */
    public function testAuthenticateWrongPassword()
    {
        $email = 'admin@entreprise.fr';
        $password = 'wrongpassword';

        $user = User::authenticate($email, $password);

        $this->assertNull($user);
    }

    /**
     * Test : Authentification d'un utilisateur inexistant
     * Vérifie que la méthode retourne null si l'utilisateur n'existe pas dans la BDD.
     */
    public function testAuthenticateNonExistentUser()
    {
        $email = 'nonexistent@test.com';
        $password = 'anyPassword';

        $user = User::authenticate($email, $password);

        $this->assertNull($user);
    }
}
