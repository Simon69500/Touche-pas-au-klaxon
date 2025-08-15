<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\AuthController;

class AuthControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // On simule la session avec un tableau vide
        if (!isset($_SESSION)) {
            $_SESSION = [];
        } else {
            $_SESSION = [];
        }
    }

    public function testRequireLoginRedirectsWhenNotLoggedIn()
    {
        $_SESSION = []; // aucun utilisateur connecté

        // On va capturer la redirection
        $this->expectException(\PHPUnit\Framework\Error\Error::class);

        // On appelle la fonction
        AuthController::requireLogin();
    }

    public function testRequireAdminAccessForbiddenForNonAdmin()
    {
        // On simule un utilisateur connecté mais non admin
        $_SESSION['user'] = [
            'id' => 1,
            'nom' => 'Martin',
            'prenom' => 'Alexandre',
            'email' => 'alexandre.martin@email.fr',
            'role' => 'employe',
        ];

        // On va capturer le exit() et le message
        $this->expectOutputString('Accés interdit');

        try {
            AuthController::requireAdmin();
        } catch (\Exception $e) {
            $this->assertTrue(true); // juste pour capturer exit()
        }
    }
}
