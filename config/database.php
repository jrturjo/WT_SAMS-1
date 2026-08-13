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
                echo "Connection error: " . $this->conn->connect_error;
                $this->conn = null;
            }
        } catch(Exception $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
