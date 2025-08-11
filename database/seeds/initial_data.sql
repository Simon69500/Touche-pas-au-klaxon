-- Insertion Villes
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

-- Insertion utilisateurs
INSERT INTO users (nom, prenom, telephone, email, role)
VALUES
('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', 'employe'),
('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', 'employe'),
('Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', 'employe'),
('Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', 'employe'),
('Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', 'employe'),
('Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', 'employe'),
('Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', 'employe'),
('Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', 'employe'),
('Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', 'employe'),
('Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', 'employe'),
('Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', 'employe'),
('Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', 'employe'),
('Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', 'employe'),
('Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', 'employe'),
('Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', 'employe'),
('Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', 'employe'),
('Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', 'employe'),
('Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', 'employe'),
('Masson', 'Julie', '0733445566', 'julie.masson@email.fr', 'employe'),
('Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', 'employe'),
-- Ajout de l'admin
('Admin', 'Super', '0600000000', 'admin@entreprise.fr', 'admin');

