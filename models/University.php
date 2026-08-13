<?php
class University {
    public $conn;

    function __construct($db) {
        $this->conn = $db;
    }

    function getProfile($user_id) {
        $stmt = $this->conn->prepare(
            "SELECT u.username, u.email, un.id, un.name as university_name, un.location, un.description 
             FROM users u 
             LEFT JOIN universities un ON u.id = un.user_id 
             WHERE u.id = ?"
        );
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }

    function updateProfile($user_id, $university_name, $location, $description) {
        $check = $this->conn->prepare("SELECT * FROM universities WHERE user_id = ?");
        $check->execute([$user_id]);

        if ($check->rowCount() > 0) {
            $stmt = $this->conn->prepare("UPDATE universities SET name=?, location=?, description=? WHERE user_id=?");
            return $stmt->execute([$university_name, $location, $description, $user_id]);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO universities (user_id, name, location, description) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$user_id, $university_name, $location, $description]);
        }
    }

    function getAll() {
        $stmt = $this->conn->query("SELECT id, name, location FROM universities");
        return $stmt->fetchAll();
    }

    function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM universities WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
