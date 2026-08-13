<?php
class Application {
    public $conn;

    function __construct($db) {
        $this->conn = $db;
    }

    function apply($student_id, $university_id, $course_name) {
        $stmt = $this->conn->prepare("INSERT INTO applications (student_id, university_id, course_name, status) VALUES (?, ?, ?, 'pending')");
        return $stmt->execute([$student_id, $university_id, $course_name]);
    }

    function getHistory($student_id) {
        $stmt = $this->conn->prepare(
            "SELECT a.id, u.name as university_name, a.course_name, a.status, a.feedback 
             FROM applications a
             JOIN universities u ON a.university_id = u.id
             WHERE a.student_id = ?"
        );
        $stmt->execute([$student_id]);
        return $stmt->fetchAll();
    }

    function getApplicationsByUniversity($university_id) {
        $stmt = $this->conn->prepare(
            "SELECT a.id, s.name as student_name, u.username, a.course_name, a.status, a.feedback 
             FROM applications a
             LEFT JOIN students s ON a.student_id = s.id
             LEFT JOIN users u ON s.user_id = u.id
             WHERE a.university_id = ?"
        );
        $stmt->execute([$university_id]);
        $apps = $stmt->fetchAll();
        foreach ($apps as &$row) {
            if (empty($row['student_name'])) {
                $row['student_name'] = $row['username'] ?? 'Unknown';
            }
        }
        return $apps;
    }

    function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE applications SET status=? WHERE id=?");
        return $stmt->execute([$status, $id]);
    }

    function sendFeedback($id, $feedback) {
        $stmt = $this->conn->prepare("UPDATE applications SET feedback=? WHERE id=?");
        return $stmt->execute([$feedback, $id]);
    }
}
