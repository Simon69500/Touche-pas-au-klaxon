<?php

namespace App\Controllers;

use App\Models\User;

/**
 * Contrôleur gérant l'authentification des utilisateurs.
 * 
 * Inclut la connexion, l'inscription et la déconnexion.
 */
class AuthController
{
        // --- Connexion existante ---

    /**
     * Affiche le formulaire de connexion.
     *
     * @return void
     */
    public function loginForm()
    {
        require __DIR__ . '/../Views/auth/login.php';
    }


    /**
     * Traite la soumission du formulaire de connexion.
     *
     * @return void
     */
    public function login()
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

    // Si user = null connexion réussité sinon on stock un tableau dans session avec toutes les infos utiles pour reconnaitre l'utilisateur
    $user = User::authenticate($email, $password);

    if($user) {
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail(),
            'role' => $user->getRole(),
        ];

        // Redirection selon le rôle 
        if ($user->getRole() === 'admin') {
            header('Location: index.php?controller=admin&action=dashboard');
        } else {
            header('Location: index.php?page=home');
        }
        exit;
    } else {
        $error = 'Email ou mot de passe incorrect.';
        require __DIR__ . '/../Views/auth/login.php';
    }
    }


    /**
     * Vérifie qu'un utilisateur est connecté.
     *
     * @throws \Exception si aucun utilisateur connecté
     * @return void
     */
    public static function requireLogin()
    {
        if(empty($_SESSION['user'])) {
            // Au lieu de redirection directe, on lance une exception pour testabilité
            throw new \Exception('Login requis');
        }
    }


    /**
     * Vérifie qu'un utilisateur connecté est administrateur.
     *
     * @throws \Exception si l'utilisateur n'est pas admin
     * @return void
     */
    public static function requireAdmin()
    {
        self::requireLogin();

        if($_SESSION['user']['role'] !== 'admin') {
            // Au lieu de echo/exit, on lance une exception
            throw new \Exception('Accès interdit');
        }
    }


        // --- Partie Inscription ---

    /**
     * Affiche le formulaire d'inscription.
     *
     * @return void
     */
    public function registerForm()
    {
        require __DIR__. '/../Views/auth/register.php';
    }


    /**
     * Traite le formulaire d'inscription d'un nouvel utilisateur.
     *
     * @return void
     */
    public function register()
    {
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';

        // Vérification simple 
        if(empty($nom) || empty($prenom) || empty($email) || empty($password)) {
            $error = "Tous les champs obligatoires doivent être remplis.";
             require __DIR__. '/../Views/auth/register.php';
             return;
        }

        // Vérifier si l'email existe déjà 
        if(User::exists($email)) {
            $error = "Un compte avec cet email existe déjà.";
             require __DIR__. '/../Views/auth/register.php';
             return;
        }

      // Création de l'utilisateur
        $user = new User();
        $user->create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'role' => $role,
            'password' => $password
        ]);
        // Redirection vers la page de connexion après inscription
        header('Location:' . \App\Config\Config::baseUrl());
        exit;
    }

    
    // -- Partie déconnexion -- 

    /**
     * Déconnecte l'utilisateur et détruit la session.
     *
     * @return void
     */
    public function logout()
    {   
        session_unset();
        session_destroy();
        header('Location: ' . \App\Config\Config::baseUrl());
        exit;
    }

}