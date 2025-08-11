-- Création table utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    telephone VARCHAR(15),
    email VARCHAR(130) NOT NULL UNIQUE,
    role VARCHAR(50) NOT NULL
);

-- Création table agences
CREATE TABLE IF NOT EXISTS agences (
    id_agence INT AUTO_INCREMENT PRIMARY KEY,
    ville VARCHAR(50) NOT NULL UNIQUE
);

-- Création table trajets
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
