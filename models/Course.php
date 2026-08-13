<?php
class Course {
    public $conn;

    function __construct($db) {
        $this->conn = $db;
    }

    function addCourse($university_id, $department, $course_name) {
        $stmt = $this->conn->prepare("INSERT INTO courses (university_id, department, course_name) VALUES (?, ?, ?)");
        return $stmt->execute([$university_id, $department, $course_name]);
    }

    function removeCourse($id) {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id = ?");
        return $stmt->execute([$id]);
    }

    function getCourses($university_id) {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE university_id = ?");
        $stmt->execute([$university_id]);
        return $stmt->fetchAll();
    }
}
