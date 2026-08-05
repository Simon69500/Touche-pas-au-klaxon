# 🚗 Touche pas au klaxon

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)
![PHPUnit](https://img.shields.io/badge/Tests-PHPUnit-3F546C?style=flat&logo=php&logoColor=white)
![PHPStan](https://img.shields.io/badge/Analyse%20statique-PHPStan-1E90FF?style=flat)

Application web interne d'entreprise pour le covoiturage entre agences. L'objectif est de réduire les trajets peu occupés et de favoriser le partage des véhicules entre collaborateurs. L'application est développée en **PHP natif** (sans framework), avec une architecture **MVC** maison, et utilise **MySQL** pour la persistance des données.

**Démo en ligne :** [touche-pas-au-klaxon-production.up.railway.app](https://touche-pas-au-klaxon-production.up.railway.app/)

---

## Sommaire

- [Objectif](#objectif)
- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Architecture du projet](#architecture-du-projet)
- [Modèle de données](#modèle-de-données)
- [Pages et actions disponibles](#pages-et-actions-disponibles)
- [Installation](#installation)
- [Variables d'environnement](#variables-denvironnement)
- [Adapter la connexion MySQL pour un environnement local (XAMPP)](#adapter-la-connexion-mysql-pour-un-environnement-local-xampp)
- [Comptes de test](#comptes-de-test)
- [Qualité de code et tests](#qualité-de-code-et-tests)
- [Auteur](#auteur)

---

## Objectif

Développer une application web interne à l'entreprise pour le covoiturage entre agences. L'objectif est de réduire les trajets peu occupés et de favoriser le partage des véhicules.

## Fonctionnalités

### 1. Pour tous les visiteurs
- Consulter la liste des trajets disponibles, triée par date de départ croissante
- Voir uniquement les trajets avec des places disponibles

### 2. Pour un utilisateur connecté
- Consulter les détails d'un trajet (personne à contacter, nombre total de places)
- Créer un nouveau trajet
- Modifier ou supprimer ses propres trajets (contrôle d'auteur : seul le créateur du trajet peut le modifier ou le supprimer)

### 3. Pour l'administrateur
- Accéder à un tableau de bord dédié
- Gérer les agences (création, modification, suppression)
- Gérer les trajets (consultation, suppression)
- Consulter la liste des utilisateurs

## Stack technique

| Domaine | Choix technique |
|---|---|
| Langage | PHP 8.2+ |
| Base de données | MySQL, accédée via PDO |
| Architecture | MVC maison (sans framework), autoload PSR-4 via Composer |
| Frontend | HTML, Bootstrap, Sass |
| Configuration | `vlucas/phpdotenv` (gestion du `.env`) |
| Tests | PHPUnit |
| Analyse statique | PHPStan |
| Style de code | PHP_CodeSniffer |
| Hébergement | Railway |

Le choix de ne pas utiliser un framework comme Symfony ou Laravel est volontaire pour ce projet de formation : il oblige à implémenter soi-même le routing, l'autoload des classes, l'accès aux données et le pattern MVC, plutôt que de s'appuyer sur des abstractions déjà prêtes.

## Architecture du projet

```
Touche-pas-au-klaxon/
├── public/
│   ├── index.php           # Front controller : point d'entrée unique, dispatch vers les contrôleurs
│   └── assets/              # CSS compilé et sources Sass
├── app/
│   ├── Config/
│   │   ├── Config.php       # Lecture des variables d'environnement, config globale
│   │   └── Database.php     # Connexion PDO (pattern Singleton)
│   ├── Controllers/         # AuthController, HomeController, TripController, AdminController
│   ├── Models/               # User, Trip, Agence — accès aux données via PDO
│   └── Views/                # Templates PHP, organisés par domaine (auth, home, trips, admin)
├── database/
│   ├── migrations/create_tables.sql
│   └── seeds/initial_data.sql
├── tests/
│   ├── Unit/                 # Tests unitaires (Controllers, Models)
│   └── Feature/              # Tests d'intégration (ex. DatabaseTest)
└── composer.json
```

Le projet suit une séparation classique **Contrôleur → Modèle → Vue** : chaque contrôleur reçoit la requête via le front controller, délègue l'accès aux données à un modèle (qui encapsule les requêtes PDO), puis inclut une vue PHP pour le rendu HTML.

## Modèle de données

Trois entités principales, reliées entre elles :

| Table | Rôle | Relations |
|---|---|---|
| `users` | Comptes utilisateurs (nom, prénom, email, téléphone, mot de passe, rôle) | Auteur et contact d'un trajet |
| `agences` | Agences de l'entreprise (ville) | Référencées comme point de départ et d'arrivée d'un trajet |
| `trajets` | Trajets proposés (agence de départ/arrivée, dates, places totales/disponibles, auteur, contact) | Liée à deux agences et à un utilisateur |

Un trajet ne peut pas avoir la même agence de départ et d'arrivée, et la date d'arrivée doit être postérieure à la date de départ : ces règles sont vérifiées côté contrôleur (`TripController::create` et `TripController::edit`) avant toute écriture en base.

## Pages et actions disponibles

Il n'y a pas de routeur au sens classique (pas d'URLs façon `/trips/create`) : `public/index.php` fait office de **front controller** et dispatch les requêtes selon les paramètres GET `page` (routes publiques/utilisateur) ou `controller`/`action` (routes admin).

### Routes publiques et utilisateur (`?page=...`)

| Paramètre | Méthode HTTP | Accès | Description |
|---|---|---|---|
| `?page=home` (défaut) | GET | Public | Page d'accueil, liste des trajets disponibles |
| `?page=login` | GET | Public | Formulaire de connexion |
| `?page=login` | POST | Public | Traite la connexion, redirige selon le rôle |
| `?page=register` | GET | Public | Formulaire d'inscription |
| `?page=register` | POST | Public | Traite l'inscription d'un nouvel utilisateur |
| `?page=logout` | GET | Connecté | Déconnecte l'utilisateur (destruction de session) |
| `?page=create` | GET | Connecté | Formulaire de création de trajet |
| `?page=create` | POST | Connecté | Traite la création d'un trajet |
| `?page=edit&id=...` | GET | Auteur du trajet | Formulaire d'édition d'un trajet |
| `?page=edit&id=...` | POST | Auteur du trajet | Traite la modification d'un trajet |
| `?page=delete&id=...` | GET | Auteur du trajet | Supprime un trajet |

### Routes administrateur (`?controller=admin&action=...`)

Toutes protégées : `AdminController` vérifie en constructeur que `$_SESSION['user']['role'] === 'admin'`, sinon redirige vers l'accueil.

| Paramètre | Méthode HTTP | Description |
|---|---|---|
| `action=dashboard` | GET | Tableau de bord (utilisateurs, trajets, agences) |
| `action=listUsers` | GET | Liste des utilisateurs |
| `action=listTrips` | GET | Liste des trajets |
| `action=deleteTrip&id=...` | GET | Supprime un trajet |
| `action=listAgences` | GET | Liste des agences |
| `action=createAgence` | GET/POST | Formulaire et création d'une agence |
| `action=editAgence&id=...` | GET/POST | Formulaire et modification d'une agence |
| `action=deleteAgence&id=...` | GET | Supprime une agence (refusé si elle est utilisée par des trajets) |

## Installation

### Prérequis système
- PHP **8.2** ou supérieur (requis par `composer.json`)
- MySQL
- Serveur web Apache — XAMPP recommandé
- Composer
- Navigateur moderne (Chrome, Firefox, Edge)

### Étapes

```bash
# 1. Copier le projet dans XAMPP
# Placer le dossier dans C:\xampp\htdocs\touche-pas-au-klaxon
# (ou le dossier équivalent sur ton OS)

# 2. Installer les dépendances
composer install

# 3. Créer la base de données
mysql -u root -p -e "CREATE DATABASE touche_pas_au_klaxon;"

# 4. Importer la structure et les données de test
mysql -u root -p touche_pas_au_klaxon < database/migrations/create_tables.sql
mysql -u root -p touche_pas_au_klaxon < database/seeds/initial_data.sql

# 5. Configurer l'environnement
# Copier .env.example en .env, puis renseigner les identifiants de connexion
```

Accéder ensuite à l'application via `http://localhost/touche-pas-au-klaxon`.

## Variables d'environnement

Le fichier `.env.example` définit les variables attendues par `app/Config/Database.php` :

| Variable | Description |
|---|---|
| `DB_HOST` | Hôte de la base de données |
| `DB_PORT` | Port MySQL |
| `DB_NAME` | Nom de la base de données |
| `DB_USER` | Utilisateur MySQL |
| `DB_PASS` | Mot de passe MySQL |

⚠️ Attention au nom exact de la variable de mot de passe : c'est **`DB_PASS`**, pas `DB_PASSWORD` — le code ne lira pas une variable nommée différemment.

## Adapter la connexion MySQL pour un environnement local (XAMPP)

En production, la connexion PDO (`app/Config/Database.php`) force l'utilisation d'un certificat SSL (`PDO::MYSQL_ATTR_SSL_CA` pointant vers `app/Config/certs/aiven-ca.pem`), car la base de production est hébergée chez **Aiven**, un fournisseur cloud qui exige une connexion chiffrée.

En local avec un MySQL/MariaDB classique fourni par XAMPP, ce certificat n'a généralement pas d'utilité et peut provoquer une erreur de connexion si le serveur local ne supporte pas cette configuration SSL précise. Deux options pour un développement local sans y toucher à chaque fois :

- **Option simple** : commenter ou retirer temporairement la ligne `PDO::MYSQL_ATTR_SSL_CA => $sslCa` dans le tableau d'options PDO de `Database.php` pendant le développement local, à condition de ne pas committer ce changement (ou de le gérer via une branche/variante locale).
- **Option propre** : conditionner cette option SSL à une variable d'environnement (par exemple `DB_SSL=true`), et ne l'ajouter au tableau d'options PDO que si elle est activée. Cela permettrait de garder le même code entre local et production, en pilotant le comportement uniquement via le `.env`.

Je n'ai pas modifié le code pour l'instant : dis-moi si tu veux qu'on implémente l'option propre ensemble.

## Comptes de test

| Rôle | Email | Mot de passe |
|---|---|---|
| Administrateur | `admin@entreprise.fr` | `password123` |
| Utilisateur | `alexandre.martin@email.fr` | `martin123` |

## Qualité de code et tests

Le projet inclut une chaîne d'outils qualité, pilotée via Composer :

| Commande | Description |
|---|---|
| `composer test` | Exécute la suite de tests PHPUnit (unitaires et fonctionnels) |
| `composer analyse` | Lance l'analyse statique PHPStan (détection d'erreurs sans exécuter le code) |
| `composer cs-check` | Vérifie le respect des standards de code (PHP_CodeSniffer) |
| `composer cs-fix` | Corrige automatiquement les problèmes de style détectables |

Les tests couvrent à la fois des cas unitaires (`tests/Unit`, sur les contrôleurs et modèles) et un test d'intégration à la base de données (`tests/Feature/DatabaseTest.php`).

## Auteur

Projet réalisé par **Simon** dans le cadre d'une formation en développement web fullstack.
