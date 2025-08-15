<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
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
        header('Location: /');
        exit;
    } else {
        $error = 'Email ou mot de passe incorrect.';
        require __DIR__ . '/../Views/auth/login.php';
    }
    }

    // Partie pour la deconnexion de l'utilisateur
    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    // Si la session est vide sans utilisateur on revoi vers la page login
    public static function requireLogin()
    {
        if(empty($_SESSION['user'])) {
            header('Location: /login');
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
}