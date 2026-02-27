<?php
namespace App\Core; 

use PDO;
use PDOException;

// TEAM: This is our Database connection. 
// It uses the "Singleton" pattern. 3leh? Because if 100 people visit our site, 
// we don't want to open 100 power cables to the database and crash the server.
// We only open ONE connection and share it.
class Database {
    
    private static $instance = null;
    private $connection;

    // Gatekeeper, Client, Creative: Do NOT put your passwords here. 
    // This is for local WAMP testing only.
    private $host = 'localhost';
    private $db_name = 'ad_attack_db';
    private $username = 'root';
    private $password = ''; 

    private function __construct() {
        try {
            // Plug in the power cable to MySQL
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            
            // Make sure the database yells at us if we write bad SQL
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Bring data back as objects ($user->name) instead of messy arrays
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            
        } catch (PDOException $e) {
            die("Team, the Database is down. Check WAMP! Error: " . $e->getMessage());
        }
    }

    // TEAM: Whenever you need to talk to the database in your Models, just call this yuss:
    // $db = Database::getConnection();
    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}