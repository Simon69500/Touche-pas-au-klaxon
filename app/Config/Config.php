<?php
/**
 * Configuration globale de l'application
 * 
 * @package App\Config
 * @author Simon
 */

namespace App\Config;

class Config
{
    /**
     * Récupère une valeur de configuration depuis les variables d'environnement
     * 
     * @param string $key Clé de configuration
     * @param mixed $default Valeur par défaut
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
    
    /**
     * Vérifie si on est en environnement de développement
     * 
     * @return bool
     */
    public static function isDevelopment(): bool
    {
        return self::get('APP_ENV', 'production') === 'development';
    }
    
    /**
     * Récupère la configuration de la base de données
     * 
     * @return array
     */
    public static function database(): array
    {
        return [
            'host' => self::get('DB_HOST', 'localhost'),
            'port' => self::get('DB_PORT', 3306),
            'dbname' => self::get('DB_NAME', 'touche_pas_au_klaxon'),
            'username' => self::get('DB_USER', 'root'),
            'password' => self::get('DB_PASS', ''),
            'charset' => 'utf8mb4'
        ];
    }
}