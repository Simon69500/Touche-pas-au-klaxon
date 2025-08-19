<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
        // --- Connexion existante ---

    // Afficher la page du formulaire de connexion
    public function loginForm()
    {
        require __DIR__ . '/../Views/auth/login.php';
    }

    // On récupére les données envoyées par le formulaire
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
        header('Location: ' . \App\Config\Config::baseUrl());
        exit;
    } else {
        $error = 'Email ou mot de passe incorrect.';
        require __DIR__ . '/../Views/auth/login.php';
    }
    }

    // Si la session est vide sans utilisateur on revoi vers la page login
    public static function requireLogin()
    {
        if(empty($_SESSION['user'])) {
            header('Location: ?page=login');
            exit;
        }
    }

    // On vérifie si l'utilisateur connecté est bien l'admin sinon message d'erreur
    public static function requireAdmin()
    {
        self::requireLogin();
        if($_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            echo "Accés interdit";
            exit;
        }
    }


        // --- Partie Inscription ---

    // Affiche le formulaire d'inscription
    public function registerForm()
    {
        require __DIR__. '/../Views/auth/register.php';
    }

    // Traite le formulaire d'inscription 
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

        // Partie pour la deconnexion de l'utilisateur
    public function logout()
    {   
        session_unset();
        session_destroy();
        header('Location: ' . \App\Config\Config::baseUrl());
        exit;
    }

}