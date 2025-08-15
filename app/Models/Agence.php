<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Agence 
{
    private $id_agence;
    private $ville;

    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Recuperer toutes les agences (all)
     * triés par ordre alphabétique
     */
    public function agenceAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM agences ORDER BY ville ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouver une agence par ID (find)
     */
    public function agenceID(int $id_agence): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agences WHERE id_agence = :id_agence");
        $stmt->execute([':id_agence'  => $id_agence]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }

}