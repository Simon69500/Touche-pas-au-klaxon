<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class User
{
    private $id_user;
    private $nom;
    private $prenom;
    private $telephone;
    private $email;
    private $role;
    private $password_hash;

    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Trouver un utilisateur par email
    public function findByEmail(string $email) : ?self 
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($data === false) {
            return null;
        }

        $user = new self();
        $user->id_user = $data['id_user'];
        $user->nom = $data['nom'];
        $user->prenom = $data['prenom'];
        $user->telephone = $data['telephone'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->password_hash = $data['password_hash'];

        return $user;
    }

    // Vérifier le mot de passe
    public function verifyPassword(string $password) : bool 
    {
        return password_verify($password, $this->password_hash);    
    }

    // Authentification compléte (static)
    public static function authenticate(string $email, string $password) : ?self 
    {
        $instance = new self();
        $user = $instance->findByEmail($email);
        
        if($user && $user->verifyPassword($password)) {
            return $user;
        }

        return null;
    }

    // Creation user
    public function create(array $data): bool
    {
        $sql = "INSERT INTO users(nom, prenom, telephone, email, role, password_hash)
        VALUES (:nom, :prenom, :telephone, :email, :role, :password_hash)";

        $stmt = $this->pdo->prepare($sql);

        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

        return $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':telephone' => $data['telephone'] ?? null,
            ':email' => $data['email'],
            ':role' => $data['role'],
            'password_hash' => $password_hash
        ]);
    }

    // Getters

    public function getId()
    {
        return $this->id_user;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRole()
    {
        return $this->role;
    }
}