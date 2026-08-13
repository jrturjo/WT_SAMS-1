<?php
class StudentController {
    
    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/Student.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo "Database connection failed.";
            return;
        }

        $student = new Student($db);

        $user_id = $_SESSION['user_id'];
        
        $data = $student->getProfile($user_id);
        
        if (!$data) {
            echo "User not found";
            return;
        }
        
        require_once 'views/student/profile.php';
    }

    public function universities() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }
        require_once 'views/student/universities.php';
    }

    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/Student.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            header("Location: index.php?url=profile");
            exit;
        }

        $student = new Student($db);

        $user_id = $_SESSION['user_id'];
        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';

        if ($student->updateProfile($user_id, $name, $phone, $address)) {
            $success = "Profile updated successfully";
        } else {
            $error = "Update failed";
        }
        
        $data = $student->getProfile($user_id);
        require_once 'views/student/profile.php';
    }

    public function history() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/Student.php';
        require_once 'models/Application.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo "Database connection failed.";
            return;
        }

        $student = new Student($db);
        $app = new Application($db);

        $user_id = $_SESSION['user_id'];
        $profile = $student->getProfile($user_id);

        if ($profile) {
            $student_id = $profile['id'];
            $applications = $app->getHistory($student_id);
            require_once 'views/student/history.php';
        } else {
            echo "Student profile not found";
        }
    }
}
