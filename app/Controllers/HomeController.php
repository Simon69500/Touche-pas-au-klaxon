<?php

namespace App\Controllers;

use App\Models\Trip;

class HomeController 
{
    public function index() 
    {
        $tripModel = new Trip();
        $trips = $tripModel->tripAvailable();
        require __DIR__ . '/../Views/home/home.php';
    }
}