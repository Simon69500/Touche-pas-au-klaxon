<?php

namespace App\Models;

use App\Config\Database;
use PDO;

/**
 * Modèle représentant un trajet.
 * 
 * Permet de créer, récupérer, mettre à jour et supprimer des trajets.
 */
class Trip
{

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
     * Crée un nouveau trajet.
     *
     * @param array<string, mixed> $data Données du trajet
     * @return bool True si le trajet a été créé, false sinon
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO trajets (
            agence_depart_id, agence_arrive_id, contact_id, auteur_id, 
            places_total, places_dispo, date_heure_depart, date_heure_arrive
        ) VALUES (
            :agence_depart_id, :agence_arrive_id, :contact_id, :auteur_id, 
            :places_total, :places_dispo, :date_heure_depart, :date_heure_arrive
        )";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':agence_depart_id' => $data['agence_depart_id'] ?? 0,
            ':agence_arrive_id' => $data['agence_arrive_id'] ?? 0,
            ':contact_id' => $data['contact_id'] ?? 0,
            ':auteur_id' => $data['auteur_id'] ?? 0,
            ':places_total' => $data['places_total'] ?? 0,
            ':places_dispo' => $data['places_dispo'] ?? 0,
            ':date_heure_depart' => $data['date_heure_depart'] ?? '',
            ':date_heure_arrive' => $data['date_heure_arrive'] ?? '',
        ]);
    }

    /**
     * Récupère tous les trajets triés par date de départ croissante.
     *
     * @return array<int, array<string, mixed>> Liste des trajets
     */
    public static function getAll(): array
    {
        $instance = new self();
        $stmt = $instance->pdo->query("SELECT * FROM trajets ORDER BY date_heure_depart ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère uniquement les trajets disponibles.
     *
     * @return array<int, array<string, mixed>> Liste des trajets disponibles
     */
    public function tripAvailable(): array
    {
        $stmt = $this->pdo->query("
            SELECT t.id_trajet,
                   ad.ville AS ville_depart,
                   aa.ville AS ville_arrivee,
                   t.date_heure_depart,
                   t.date_heure_arrive,
                   t.places_dispo, 
                   t.auteur_id,
                   u.nom,
                   u.prenom,
                   u.email,
                   u.telephone
            FROM trajets t 
            JOIN agences ad ON t.agence_depart_id = ad.id_agence 
            JOIN agences aa ON t.agence_arrive_id = aa.id_agence 
            JOIN users u ON t.auteur_id = u.id_user 
            WHERE t.places_dispo > 0 AND t.date_heure_depart > NOW()
            ORDER BY t.date_heure_depart ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouve un trajet par son identifiant.
     *
     * @param int $id_trajet Identifiant du trajet
     * @return array<string, mixed>|null Trajet trouvé ou null
     */
    public static function tripFind(int $id_trajet): ?array
    {
        $instance = new self();
        $stmt = $instance->pdo->prepare("SELECT * FROM trajets WHERE id_trajet = :id_trajet");
        $stmt->execute([':id_trajet' => $id_trajet]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Met à jour un trajet existant.
     *
     * @param int $id_trajet Identifiant du trajet
     * @param array<string, mixed> $data Données mises à jour
     * @return bool True si la mise à jour a réussi, false sinon
     */
    public function tripUpdate(int $id_trajet, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE trajets SET
                agence_depart_id = :agence_depart_id,
                agence_arrive_id = :agence_arrive_id,
                date_heure_depart = :date_heure_depart,
                date_heure_arrive = :date_heure_arrive,
                places_total = :places_total,
                places_dispo = :places_dispo
            WHERE id_trajet = :id_trajet
        ");

        return $stmt->execute([
            ':agence_depart_id' => $data['agence_depart_id'] ?? 0,
            ':agence_arrive_id' => $data['agence_arrive_id'] ?? 0,
            ':date_heure_depart' => $data['date_heure_depart'] ?? '',
            ':date_heure_arrive' => $data['date_heure_arrive'] ?? '',
            ':places_total' => $data['places_total'] ?? 0,
            ':places_dispo' => $data['places_dispo'] ?? 0,
            ':id_trajet' => $id_trajet,
        ]);
    }

    /**
     * Supprime un trajet par son identifiant.
     *
     * @param int $id_trajet Identifiant du trajet
     * @return bool True si la suppression a réussi, false sinon
     */
    public static function delete(int $id_trajet): bool
    {
        $instance = new self();
        $stmt = $instance->pdo->prepare("DELETE FROM trajets WHERE id_trajet = :id_trajet");
        return $stmt->execute([':id_trajet' => $id_trajet]);
    }
}
