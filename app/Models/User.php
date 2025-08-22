<?php

namespace App\Models;

use App\Config\Database;
use PDO;

/**
 * Modèle représentant un utilisateur.
 * 
 * Permet la gestion des utilisateurs : création, récupération, authentification.
 */
class User
{
    /** @var int|null Identifiant de l'utilisateur */
    private ?int $id_user = null;

    /** @var string Nom de l'utilisateur */
    private string $nom = '';

    /** @var string Prénom de l'utilisateur */
    private string $prenom  = '';

    /** @var string|null Numéro de téléphone */
    private ?string $telephone = null;

    /** @var string Email de l'utilisateur */
    private string $email  = '';

    /** @var string Rôle de l'utilisateur ('admin' ou 'user') */
    private string $role  = '';

    /** @var string Hash du mot de passe */
    private string $password_hash  = '';

    /** @var PDO Instance PDO pour la connexion à la base */
    private PDO $pdo;

    
    /**
     * Constructeur : initialise la connexion PDO.
     */
    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }


    /**
     * Trouve un utilisateur par email.
     *
     * @param string $email Email à rechercher
     * @return self|null L'utilisateur si trouvé, sinon null
     */
    public function findByEmail(string $email): ?self
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $user = new self();
        $user->id_user = (int)($data['id_user'] ?? null);
        $user->nom = $data['nom'] ?? '';
        $user->prenom = $data['prenom'] ?? '';
        $user->telephone = $data['telephone'] ?? null;
        $user->email = $data['email'] ?? '';
        $user->role = $data['role'] ?? '';
        $user->password_hash = $data['password_hash'] ?? '';

        return $user;
    }


    /**
     * Récupère tous les utilisateurs triés par nom.
     *
     * @return array<int, array<string, mixed>> Liste des utilisateurs
     */
    public static function getAll(): array
    {
        $instance = new self();
        $stmt = $instance->pdo->query("SELECT * FROM users ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Vérifie si le mot de passe correspond au hash stocké.
     *
     * @param string $password Mot de passe à vérifier
     * @return bool True si correct, false sinon
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }


    /**
     * Authentifie un utilisateur.
     *
     * @param string $email Email
     * @param string $password Mot de passe
     * @return self|null Utilisateur authentifié ou null
     */
    public static function authenticate(string $email, string $password): ?self
    {
        $instance = new self();
        $user = $instance->findByEmail($email);

        if ($user && $user->verifyPassword($password)) {
            return $user;
        }

        return null;
    }

    
    /**
     * Crée un nouvel utilisateur.
     *
     * @param array<string, mixed> $data Données de l'utilisateur
     * @return bool True si création réussie, false sinon
     */
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
            ':password_hash' => $password_hash
        ]);
    }


    /**
     * Vérifie si un email existe déjà.
     *
     * @param string $email Email à vérifier
     * @return bool True si existe, false sinon
     */
    public static function exists(string $email): bool
    {
        $instance = new self();
        return $instance->findByEmail($email) !== null;
    }


    // ---------- Getters ----------

    public function getId(): ?int
    {
        return $this->id_user;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
