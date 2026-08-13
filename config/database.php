<?php
class Database {
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $host = getenv('DB_HOST') ?: 'localhost';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: '';
            $name = getenv('DB_NAME') ?: 'sams_db';

            $this->conn = new PDO(
                "mysql:host=$host;dbname=$name;charset=utf8mb4",
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
