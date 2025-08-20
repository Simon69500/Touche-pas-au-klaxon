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
    public static function getAll(): array
    {   
        $instance = new self();
        $stmt = $instance->pdo->query("SELECT * FROM agences ORDER BY ville ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouver une agence par ID (find)
     */
    public static function find(int $id_agence): ?array
    {
        $instance = new self();
        $stmt = $instance->pdo->prepare("SELECT * FROM agences WHERE id_agence = :id_agence");
        $stmt->execute([':id_agence' => $id_agence]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    /**
     * Creer une agence
     */
    public static function create(array $data): bool
    {   
        $sql = "INSERT INTO agences(ville)
        VALUES (:ville)";

        $instance = new self();
        $stmt = $instance->pdo->prepare($sql);

        return $stmt->execute([
            ':ville' => $data['ville'],
        ]);
    }

        /**
         * Supprimer une Agence (delete)
         */
        public static function delete(int $id_agence): bool
        {
            $instance = new self();
            $stmt = $instance->pdo->prepare("DELETE FROM agences WHERE id_agence = :id_agence");
            return $stmt->execute([':id_agence' => $id_agence]);
        }

}