<?php
class Database {
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $host = getenv('DB_HOST') ?: 'localhost';
            $port = getenv('DB_PORT') ?: '3306';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: '';
            $name = getenv('DB_NAME') ?: 'sams_db';

            $this->conn = new PDO(
                "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch(PDOException $e) {
            error_log("DB Connection Error: " . $e->getMessage());
            $this->conn = null;
        }
        return $this->conn;
    }
}
