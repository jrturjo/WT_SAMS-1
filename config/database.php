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

            $this->conn = new mysqli($host, $user, $pass, $name);

            if ($this->conn->connect_error) {
                error_log("DB Connection Error: " . $this->conn->connect_error);
                $this->conn = null;
                return null;
            }

            $this->conn->set_charset("utf8mb4");
        } catch(Exception $e) {
            error_log("DB Exception: " . $e->getMessage());
            $this->conn = null;
        }
        return $this->conn;
    }
}
