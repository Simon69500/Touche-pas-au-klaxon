/**
 * Table users
 * Stocke les informations des utilisateurs du système.
 * 
 * Colonnes :
 * - id_user : Identifiant unique auto-incrémenté de l'utilisateur.
 * - nom : Nom de famille de l'utilisateur.
 * - prenom : Prénom de l'utilisateur.
 * - telephone : Numéro de téléphone de l'utilisateur (optionnel).
 * - email : Adresse email unique de l'utilisateur.
 * - role : Rôle de l'utilisateur (ex : employe, admin).
 */
CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    telephone VARCHAR(15),
    email VARCHAR(130) NOT NULL UNIQUE,
    role VARCHAR(50) NOT NULL
);


/**
 * Table agences
 * Contient la liste des agences avec leur ville.
 * 
 * Colonnes :
 * - id_agence : Identifiant unique auto-incrémenté de l'agence.
 * - ville : Nom de la ville (unique).
 */
CREATE TABLE IF NOT EXISTS agences (
    id_agence INT AUTO_INCREMENT PRIMARY KEY,
    ville VARCHAR(50) NOT NULL UNIQUE
);


/**
 * Table trajets
 * Représente un trajet entre deux agences, avec un contact et un auteur.
 * 
 * Colonnes :
 * - id_trajet : Identifiant unique auto-incrémenté du trajet.
 * - agence_depart_id : Référence vers l'agence de départ.
 * - agence_arrive_id : Référence vers l'agence d'arrivée.
 * - contact_id : Référence vers l'utilisateur contact.
 * - auteur_id : Référence vers l'utilisateur auteur.
 * - places_total : Nombre total de places disponibles.
 * - places_dispo : Nombre de places encore disponibles.
 * - date_heure_depart : Date et heure de départ.
 * - date_heure_arrive : Date et heure d'arrivée.
 * 
 * Contraintes :
 * - clés étrangères reliant les agences et utilisateurs.
 */
CREATE TABLE IF NOT EXISTS trajets (
    id_trajet INT AUTO_INCREMENT PRIMARY KEY,
    agence_depart_id INT NOT NULL,
    agence_arrive_id INT NOT NULL,
    contact_id INT NOT NULL,
    auteur_id INT NOT NULL,
    places_total INT NOT NULL,
    places_dispo INT NOT NULL,
    date_heure_depart DATETIME NOT NULL,
    date_heure_arrive DATETIME NOT NULL,
    FOREIGN KEY (agence_depart_id) REFERENCES agences(id_agence),
    FOREIGN KEY (agence_arrive_id) REFERENCES agences(id_agence),
    FOREIGN KEY (contact_id) REFERENCES users(id_user),
    FOREIGN KEY (auteur_id) REFERENCES users(id_user)
);
