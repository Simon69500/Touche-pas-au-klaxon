# PROJET : TOUCHE PAS AU KLAXON

## Objectif:

Développer une application web interne à l’entreprise pour le covoiturage entre agences. L’objectif est de réduire les trajets peu occupés et de favoriser le partage des véhicules. L’application est développée en PHP, utilise MySQL et respecte une architecture MVC.

--- 

## Fonctionnalités
1. Pour tous les utilisateurs

- Consulter la liste des trajets disponibles, triée par date de départ croissante

- Voir uniquement les trajets avec des places disponibles

2. Pour un utilisateur connecté

- Consulter les détails d’un trajet (personne à contacter, nombre total de places)

- Créer un nouveau trajet

- Modifier ou supprimer ses propres trajets

3. Pour l’administrateur

- Accéder à toutes les fonctionnalités de consultation, création, modification et suppression

- Gérer les agences (création, modification, suppression)

- Gérer les trajets (création, modification, suppression)

## Lister les utilisateurs

### Prérequis système

PHP 7.4 ou supérieur

MySQL 

Serveur web (Apache)

Composer

Navigateur moderne (Chrome, Firefox, Edge)

### Installation

#### Cloner le projet :

`
git clone [lien du dépôt]
cd touche-pas-au-klaxon
`

#### Installer les dépendances :

`
composer install
`

#### Créer la base de données :

CREATE DATABASE touche_pas_au_klaxon;


Importer la structure et les données de test :

mysql -u root -p touche_pas_au_klaxon < database/migrations/create_tables.sql
mysql -u root -p touche_pas_au_klaxon < database/sedds/initial_data.sql


#### Configurer l’environnement :

- Renommer .env.example en .env

- Modifier les informations de connexion à la base :
```sql
DB_HOST=localhost
DB_NAME=touche_pas_au_klaxon
DB_USER=root
DB_PASSWORD=
```

#### Lancer le serveur local :
`
php -S localhost:8000 -t public
`

#### Accéder à l’application :

Ouvrir le navigateur sur http://localhost:8000

### Guide d’utilisation
Page d’accueil

Liste des trajets avec places disponibles, triés par date de départ croissante

Affiche l’agence de départ, la date de départ, l’agence d’arrivée, la date d’arrivée, et le nombre de places disponibles

Utilisateur connecté

Bouton pour afficher les informations complémentaires dans une fenêtre modale : nom, prénom, email, téléphone, nombre total de places

Les auteurs d’un trajet peuvent modifier ou supprimer leur trajet

Possibilité de créer un nouveau trajet

Administrateur

Tableau de bord avec accès à toutes les fonctionnalités

Gestion complète des agences et trajets

Consultation des utilisateurs

Architecture / MVC
App/
├─ Controllers/
├─ Models/
├─ Views/
├─ Config/
public/
├─ index.php
database/
├─ migrations
├─ seeds
.env.example

### Compte de test

Administrateur : admin@example.com
 / motdepasse : 

Utilisateur : user@example.com
 / motdepasse : 