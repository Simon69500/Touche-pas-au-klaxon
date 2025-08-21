<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\AuthController;

class AuthControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // On simule la session avec un tableau vide
        $_SESSION = [];
    }

    public function testRequireLoginThrowsExceptionWhenNotLoggedIn()
    {
        $_SESSION = []; // aucun utilisateur connecté

        // On s'attend à ce qu'une exception soit levée
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Login requis');

        // Appel de la fonction
        AuthController::requireLogin();
    }

    public function testRequireAdminThrowsExceptionForNonAdminUser()
    {
        // On simule un utilisateur connecté mais non admin
        $_SESSION['user'] = [
            'id' => 1,
            'nom' => 'Martin',
            'prenom' => 'Alexandre',
            'email' => 'alexandre.martin@email.fr',
            'role' => 'employe',
        ];

        // On s'attend à ce qu'une exception soit levée
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Accès interdit');

        AuthController::requireAdmin();
    }

    public function testRequireAdminPassesForAdminUser()
    {
        // On simule un utilisateur admin
        $_SESSION['user'] = [
            'id' => 2,
            'nom' => 'Durand',
            'prenom' => 'Claire',
            'email' => 'claire.durand@email.fr',
            'role' => 'admin',
        ];

        // On vérifie que l'appel ne lève pas d'exception
        $this->assertNull(AuthController::requireAdmin());
    }
}
