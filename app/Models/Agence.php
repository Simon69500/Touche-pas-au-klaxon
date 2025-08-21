<?php

namespace App\Models;

use App\Config\Database;
use PDO;

/**
 * Modèle représentant une agence.
 * 
 * Permet de gérer les agences : récupération, création, modification et suppression.
 */
class Agence 
{
    /** @var int|null Identifiant de l'agence */
    private ?int $id_agence = null;

    /** @var string Nom de la ville de l'agence */
    private string $ville = '';

    /** @var PDO Instance PDO pour la connexion à la base */
    private PDO $pdo;

    
    /**
     * Constructeur : initialise la connexion PDO.
     */
    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }


    /**
     * Récupère toutes les agences, triées par ordre alphabétique.
     *
     * @return array<int, array<string, mixed>> Tableau associatif des agences
     */
    public static function getAll(): array
    {   
        $instance = new self();
        $stmt = $instance->pdo->query("SELECT * FROM agences ORDER BY ville ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Trouve une agence par son identifiant.
     *
     * @param int $id_agence Identifiant de l'agence
     * @return array<string, mixed>|null Tableau associatif de l'agence ou null si non trouvé
     */
    public static function find(int $id_agence): ?array
    {
        $instance = new self();
        $stmt = $instance->pdo->prepare("SELECT * FROM agences WHERE id_agence = :id_agence");
        $stmt->execute([':id_agence' => $id_agence]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    /**
     * Crée une nouvelle agence.
     *
     * @param array<string, string> $data Données de l'agence (ex: ['ville' => 'Paris'])
     * @return bool True si la création a réussi, false sinon
     */
    public static function create(array $data): bool
    {   
        $sql = "INSERT INTO agences(ville) VALUES (:ville)";
        $instance = new self();
        $stmt = $instance->pdo->prepare($sql);

        return $stmt->execute([
            ':ville' => $data['ville'],
        ]);
    }


    /**
     * Modifie une agence existante.
     *
     * @param int $id_agence Identifiant de l'agence
     * @param array<string, string> $data Données à mettre à jour
     * @return bool True si la mise à jour a réussi, false sinon
     */
    public static function update(int $id_agence, array $data): bool
    {
        $instance = new self();
        $stmt = $instance->pdo->prepare("UPDATE agences SET ville = :ville WHERE id_agence = :id_agence");
        return $stmt->execute([
            ':ville' => $data['ville'],
            ':id_agence' => $id_agence
        ]);
    }


    /**
     * Supprime une agence par son identifiant.
     *
     * @param int $id_agence Identifiant de l'agence à supprimer
     * @return bool True si la suppression a réussi, false sinon
     */
    public static function delete(int $id_agence): bool
    {
        $instance = new self();
        $stmt = $instance->pdo->prepare("DELETE FROM agences WHERE id_agence = :id_agence");
        return $stmt->execute([':id_agence' => $id_agence]);
    }

    // ------------------------
    // Getters / Setters
    // ------------------------
    public function getIdAgence(): ?int
    {
        return $this->id_agence;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }
}
