<?php
class Student {
    public $conn;

    function __construct($db) {
        $this->conn = $db;
    }

    function getProfile($user_id) {
        $stmt = $this->conn->prepare(
            "SELECT s.id, u.username, u.email, s.name, s.phone, s.current_university, s.address 
             FROM users u 
             LEFT JOIN students s ON u.id = s.user_id 
             WHERE u.id = ?"
        );
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }

    function updateProfile($user_id, $name, $phone, $address) {
        $check = $this->conn->prepare("SELECT * FROM students WHERE user_id = ?");
        $check->execute([$user_id]);

        if ($check->rowCount() > 0) {
            $stmt = $this->conn->prepare("UPDATE students SET name=?, phone=?, address=? WHERE user_id=?");
            return $stmt->execute([$name, $phone, $address, $user_id]);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO students (user_id, name, phone, address) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$user_id, $name, $phone, $address]);
        }
    }
}
