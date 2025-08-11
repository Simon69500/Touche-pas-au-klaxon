<?php

namespace App\Config;

        use Dotenv\Dotenv;
        use PDO;
        use PDOException;

/**
 * Classe Database utilisant le pattern Singleton
 * pour gérer la connexion PDO à la base de données.
 */
class Database
{
     /**
     * Instance unique de la classe
     * @var Database|null
     */
    private static ?Database $instance = null;

    /**
     * Objet PDO pour la connexion à la BDD
     * @var PDO|null
     */
    private ?PDO $pdo = null ;

     /**
     * Constructeur privé pour empêcher l'instanciation directe.
     * Initialise la connexion PDO.
     */
    private function __construct()
    {
        // Chargement du fichier .event_note
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
   
        var_dump(getenv('DB_USER'));
        var_dump(getenv('DB_PASS'));

        $host = getenv('DB_HOST');
        $db = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');

        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$db;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Récupère l'instance unique de la classe Database.
     * @return Database
     */
    public static function getInstance(): Database
    {
        if(self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }
    
    /**
     * Récupère l'objet PDO pour faire des requêtes.
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this-> pdo;
    }

    /**
     * Exécute une requête SQL simple (sans paramètre).
     * @param string $sql
     * @return bool|\PDOStatement
     */
    public function query(string $sql)
    {
        return $this->pdo->query($sql);
    }

    /**
     * Prépare une requête SQL avec paramètres.
     * @param string $sql
     * @return \PDOStatement
     */
    public function prepare(string $sql): \PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    /**
     * Execute une requête prepare avec des données
     * @param string $sql
     * @return \PDOStatement
     */
    public function execute(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}   

