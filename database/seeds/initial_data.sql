/**
 * Insertion des villes dans la table agences
 * Chaque ville correspond à une agence présente dans le système.
 */
INSERT INTO agences (ville) 
VALUES 
('Paris'),
('Lyon'),
('Marseille'),
('Toulouse'),
('Nice'),
('Nantes'),
('Strasbourg'),
('Montpellier'),
('Bordeaux'),
('Lille'),
('Rennes'),
('Reims');


/**
 * Insertion des utilisateurs dans la table users
 * Chaque utilisateur a un nom, prénom, téléphone, email et un rôle.
 * Le rôle peut être 'employe' ou 'admin' pour gérer les droits d'accès.
 */
INSERT INTO users (nom, prenom, telephone, email, password_hash, role)
VALUES
('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '$2y$10$mL2/CuZO4WlnulpN0.vgBuwseAvCP1VDLO6ZckbpldRDeJslZbIcG', 'employe'),
('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '', 'employe'),
('Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '', 'employe'),
('Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '', 'employe'),
('Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', '', 'employe'),
('Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', '', 'employe'),
('Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', '', 'employe'),
('Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', '', 'employe'),
('Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', '', 'employe'),
('Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', '', 'employe'),
('Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', '', 'employe'),
('Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', '', 'employe'),
('Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', '', 'employe'),
('Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', '', 'employe'),
('Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', '', 'employe'),
('Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', '', 'employe'),
('Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', '', 'employe'),
('Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', '', 'employe'),
('Masson', 'Julie', '0733445566', 'julie.masson@email.fr', '', 'employe'),
('Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', '', 'employe'),
-- Ajout de l'admin
('Admin', 'Super', '0600000000', 'admin@entreprise.fr', '$2y$10$9Imke9EF2HhOx/GuMfJCUetqWYKICjocnquq7nYwjB7tJtp/a8q7y', 'admin');


/**
 * Insérer des trajets de test pour la table "trajets"
 *  Comprend des trajets passés et futurs, avec différents auteurs et contacts
 * Permet de tester l'affichage des trajets disponibles et la gestion des places
 */
INSERT INTO trajets (agence_depart_id, agence_arrive_id, contact_id, auteur_id, places_total, places_dispo, date_heure_depart, date_heure_arrive)
VALUES
-- Trajets aujourd'hui/futurs
(1, 2, 3, 3, 4, 2, '2025-08-22 08:00:00', '2025-08-22 10:00:00'),
(2, 1, 4, 4, 3, 1, '2025-08-23 09:30:00', '2025-08-23 11:30:00'),
(3, 1, 5, 5, 5, 5, '2025-08-24 07:00:00', '2025-08-24 09:30:00'),
(1, 3, 6, 6, 4, 3, '2025-08-25 12:00:00', '2025-08-25 14:00:00'),
(2, 3, 7, 7, 2, 1, '2025-08-26 14:00:00', '2025-08-26 16:30:00'),
-- Trajets passés
(1, 2, 3, 3, 4, 0, '2025-08-10 08:00:00', '2025-08-10 10:00:00'),
(2, 1, 4, 4, 3, 0, '2025-08-11 09:30:00', '2025-08-11 11:30:00'),
(3, 1, 5, 5, 5, 0, '2025-08-12 07:00:00', '2025-08-12 09:30:00'),
-- Trajets à venir
(1, 2, 3, 3, 4, 4, '2025-08-27 08:00:00', '2025-08-27 10:00:00'),
(2, 3, 4, 4, 3, 2, '2025-08-28 09:30:00', '2025-08-28 11:30:00');
