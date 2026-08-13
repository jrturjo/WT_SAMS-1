<?php
class User {
    public $conn;

    function __construct($db) {
        $this->conn = $db;
    }

    function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    function register($username, $email, $password, $role) {
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $password, $role]);
    }

    function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$email, $password]);
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch();
        }
        return false;
    }

    function updatePassword($email, $new_password) {
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        return $stmt->execute([$new_password, $email]);
    }
}
