<?php
/**
 * Database Configuration & PDO Connection
 * (Example Template for GitHub)
 */

class Database {
    private static $instance = null;
    private $conn = null;

    private function __construct() {
        // Auto-detect if we are running on local XAMPP or the live server
        $is_localhost = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', '192.168.1.19']);

        if ($is_localhost) {
            // Local XAMPP Development Settings
            $db_name  = 'resumexportfolio';
            $username = 'root';
            $password = '';
            $host     = '127.0.0.1';
        } else {
            // Production Settings (DO NOT COMMIT REAL PASSWORDS TO GIT)
            $db_name  = 'YOUR_LIVE_DB_NAME';
            $username = 'YOUR_LIVE_DB_USER';
            $password = 'YOUR_LIVE_DB_PASSWORD';
            $host     = 'YOUR_LIVE_DB_HOST';
        }

        try {
            $dsn = "mysql:host={$host};port=3306;dbname={$db_name};charset=utf8mb4";
            $this->conn = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            // Keep connection null so graceful fallbacks kick in if DB is down
            $this->conn = null;
        }
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
