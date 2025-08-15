<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    // Test : Connexion d'un admin existant dans la BDD
    public function testAuthenticateSuccess()
    {
        $email = 'admin@entreprise.fr';
        $password = 'password123';
        $user = User::authenticate($email, $password);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals('admin', $user->getRole());
    }

    // Test : Connexion avec un mauvais mot de passe 
    public function testAuthenticateWrongPassword()
    {
        $email = 'admin@entreprise.fr';
        $password = 'wrongpassword';
        $user = User::authenticate($email, $password);

        $this->assertNull($user);
    }

    // Test : Connexion avec un utilisateur qui n'existe pas 
    public function testAuthenticateNonExistentUser()
    {
        $email = 'nonexistent@test.com';
        $password = 'anyPassword';
        $user = User::authenticate($email, $password);

        $this->assertNull($user);
    }
}
