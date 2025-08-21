<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\AdminController;

class AdminControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $_SESSION['user'] = [
            'role' => 'admin',
            'prenom' => 'Admin',
            'nom' => 'Test',
            'email' => 'admin@test.com'
        ];

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_PORT'] = 80;
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/';
    }


    public function testDashboardLoadsDataAndView()
    {
        $controller = new AdminController();

        // On capture la sortie de la vue
        ob_start();
        $controller->dashboard();
        $output = ob_get_clean();

        $this->assertStringContainsString('<!DOCTYPE html>', $output); // ou un élément de la vue
    }

    public function testListUsersLoadsView()
    {
        $controller = new AdminController();

        ob_start();
        $controller->listUsers();
        $output = ob_get_clean();

        $this->assertStringContainsString('<!DOCTYPE html>', $output);
    }

    public function testListTripsLoadsView()
    {
        $controller = new AdminController();

        ob_start();
        $controller->listTrips();
        $output = ob_get_clean();

        $this->assertStringContainsString('<!DOCTYPE html>', $output);
    }

    public function testListAgencesLoadsView()
    {
        $controller = new AdminController();

        ob_start();
        $controller->listAgences();
        $output = ob_get_clean();

        $this->assertStringContainsString('<!DOCTYPE html>', $output);
    }
}
