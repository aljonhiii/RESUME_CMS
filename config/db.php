<?php
/**
 * Database Configuration & PDO Connection
 * Aljon Reyes - 3D Developer Portfolio
 */

class Database {
    private static $instance = null;
    private $conn = null;

    private function __construct() {
        $db_name = 'resumexportfolio';
        $username = 'root';
        $password = '';
        
        // Hosts and ports to try
        $connection_attempts = [
            ['host' => '127.0.0.1', 'port' => '3307'],
            ['host' => 'localhost', 'port' => '3307'],
            ['host' => '127.0.0.1', 'port' => '3306'],
            ['host' => 'localhost', 'port' => '3306']
        ];

        foreach ($connection_attempts as $attempt) {
            try {
                $dsn = "mysql:host={$attempt['host']};port={$attempt['port']};dbname={$db_name};charset=utf8mb4";
                $this->conn = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
                // Connected successfully
                return;
            } catch (PDOException $e) {
                // Try next
                continue;
            }
        }
        
        // If connection failed completely, keep $this->conn null for fallback
        $this->conn = null;
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}

function getDB() {
    return Database::getInstance()->getConnection();
}
?>
