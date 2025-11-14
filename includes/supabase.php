<?php

class Database {
    private static $instance = null;
    private $connection;
    
    // Simplification : le constructeur peut être allégé en appelant simplement loadEnv
    private function __construct() {
        // Le chemin doit pointer vers le fichier .env (un niveau au-dessus)
        $this->loadEnv(__DIR__ . '/../.env');
        
        try {
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT') ?: '5432';
            $dbname = getenv('DB_NAME') ?: 'postgres';
            $username = getenv('DB_USER') ?: 'postgres';
            $password = getenv('DB_PASSWORD');
            
            if (!$host || !$password) {
                // Utiliser error_log et un message générique pour la production
                throw new Exception("Variables de connexion manquantes (DB_HOST ou DB_PASSWORD)");
            }
            
            // sslmode=require est essentiel pour Supabase
            $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false
            ];
            
            $this->connection = new PDO($dsn, $username, $password, $options);
            
        } catch (PDOException $e) {
            // Affichage de l'erreur pour le débogage local (à retirer en production)
            die("❌ Erreur de connexion à la DB : " . $e->getMessage()); 
        } catch (Exception $e) {
            die("❌ Erreur de configuration : " . $e->getMessage());
        }
    }
    
    // Votre méthode de chargement .env est fonctionnelle pour l'essentiel
    private function loadEnv($path) {
        if (!file_exists($path)) {
            throw new Exception("Le fichier .env est introuvable à : {$path}");
        }
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value, '"\'');
                
                // Utiliser putenv est la méthode la plus simple pour setenv
                putenv("{$name}={$value}");
            }
        }
    }
    
    // Le reste du Singleton est correct
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    private function __clone() {}
    
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

// Fonction utilitaire pour obtenir une instance de la connexion
function getDB() {
    return Database::getInstance()->getConnection();
}