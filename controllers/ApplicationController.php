<?php
class ApplicationController {
    
    public function apply() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not logged in']);
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/Application.php';
        require_once 'models/Student.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
            exit;
        }
        
        $user_id = $_SESSION['user_id'];
        $studentModel = new Student($db);
        $studentProfile = $studentModel->getProfile($user_id);
        
        if (!$studentProfile) {
            echo json_encode(['success' => false, 'message' => 'Student profile not found']);
            exit;
        }
        
        $student_id = $studentProfile['id'];

        if (empty($student_id)) {
            $studentModel->updateProfile($user_id, '', '', '');
            $studentProfile = $studentModel->getProfile($user_id);
            $student_id = $studentProfile['id'];
        }

        $university_id = $_POST['university_id'] ?? 0;
        $course_name = $_POST['course_name'] ?? '';

        $appModel = new Application($db);
        if ($appModel->apply($student_id, $university_id, $course_name)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }
}
