<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Trip
{
    private $id_trajet;
    private $agence_depart_id;
    private $agence_arrive_id;
    private $contact_id;
    private $auteur_id;
    private $places_total;
    private $places_dispo;
    private $date_heure_depart;
    private $date_heure_arrive;

    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

     /**
     * Créer un trajet
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO trajets ( agence_depart_id, agence_arrive_id,contact_id, auteur_id, places_total, places_dispo, date_heure_depart, date_heure_arrive )
        VALUES ( :agence_depart_id, :agence_arrive_id, :contact_id, :auteur_id, :places_total, :places_dispo, :date_heure_depart, :date_heure_arrive )";
    
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':agence_depart_id' => $data['agence_depart_id'],
            ':agence_arrive_id' => $data['agence_arrive_id'],
            ':contact_id' => $data['contact_id'],
            ':auteur_id' => $data['auteur_id'],
            ':places_total' => $data['places_total'],
            ':places_dispo' => $data['places_dispo'],
            ':date_heure_depart' => $data['date_heure_depart'],
            ':date_heure_arrive' => $data['date_heure_arrive'],
        ]);
    }
    
    
        /**
         * Récuprer tous les trajets (all)
         * triés par date de départ croissante.
         */
        public function tripAll(): array
        {
            $stmt = $this->pdo->query("SELECT * FROM trajets ORDER BY date_heure_depart ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Récupérer uniquement les trajets disponibles :
         * - encore des places
         * - date de départ >= maintenant
         * - triés par date de départ croissante
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
         * Trouver un trajet par ID (find)
         */
        public function tripFind(int $id_trajet): ?array
        {
            $stmt = $this->pdo->prepare("SELECT * FROM trajets WHERE id_trajet = :id_trajet");
            $stmt->execute([':id_trajet' => $id_trajet]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ?: null ;
        }

        /**
         * Mettre à jour un trajet (update)
         */
        public function tripUpdate(int $id_trajet, array $data): bool 
        {
            $stmt = $this->pdo->prepare("UPDATE trajets SET
                agence_depart_id = :agence_depart_id,
                agence_arrive_id = :agence_arrive_id,
                date_heure_depart = :date_heure_depart,
                date_heure_arrive = :date_heure_arrive,
                places_total = :places_total,
                places_dispo = :places_dispo
                WHERE id_trajet = :id_trajet"); // <-- plus de virgule ici

            return $stmt->execute([
                ':agence_depart_id' => $data['agence_depart_id'],
                ':agence_arrive_id' => $data['agence_arrive_id'],
                ':date_heure_depart' => $data['date_heure_depart'],
                ':date_heure_arrive' => $data['date_heure_arrive'],
                ':places_total' => $data['places_total'],
                ':places_dispo' => $data['places_dispo'],
                ':id_trajet' => $id_trajet,
            ]);
        }


        /**
         * Supprimer un trajet (delete)
         */
        public function tripDelete(int $id_trajet): bool
        {
            $stmt = $this->pdo->prepare("DELETE FROM trajets WHERE id_trajet = :id_trajet");
            return $stmt->execute([':id_trajet' => $id_trajet]);
        }
}  