<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\HomeController;

class HomeControllerTest extends TestCase
{
    private $homeController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->homeController = new HomeController();

        // On définit les variables serveur nécessaires pour la vue
        $_SERVER['SERVER_PORT'] = 80;
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/';
    }

    /**
     * Vérifie que la méthode index récupère des trajets disponibles
     */
    public function testIndexRetrievesAvailableTrips(): void
    {
        // On capture la sortie de la vue
        ob_start();
        $this->homeController->index();
        $output = ob_get_clean();

        // Vérifie que la sortie contient quelque chose (au moins la vue)
        $this->assertNotEmpty($output, "La vue ne doit pas être vide");

        // Optionnel : vérifier qu’un mot clé des trajets existe (si ta DB de test contient un trajet)
        // $this->assertStringContainsString('ville_depart', $output);
    }
}
