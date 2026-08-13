<?php
class UniversityController {
    
    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/University.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo "Database connection failed.";
            return;
        }

        $university = new University($db);

        $user_id = $_SESSION['user_id'];
        
        $data = $university->getProfile($user_id);
        
        if (!$data) {
            echo "User not found";
            return;
        }
        
        require_once 'views/university/profile.php';
    }

    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/University.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            header("Location: index.php?url=university_profile");
            exit;
        }

        $university = new University($db);

        $user_id = $_SESSION['user_id'];
        $university_name = $_POST['university_name'] ?? '';
        $location = $_POST['location'] ?? '';
        $description = $_POST['description'] ?? '';

        if ($university->updateProfile($user_id, $university_name, $location, $description)) {
            $success = "Profile updated successfully";
        } else {
            $error = "Update failed";
        }
        
        $data = $university->getProfile($user_id);
        require_once 'views/university/profile.php';
    }

    public function getUniversitiesJSON() {
        header('Content-Type: application/json');
        require_once 'config/database.php';
        require_once 'models/University.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo json_encode([]);
            return;
        }

        $university = new University($db);

        $universities = $university->getAll();
        echo json_encode($universities);
    }

    public function getUniversityDetailsJSON() {
        header('Content-Type: application/json');
        require_once 'config/database.php';
        require_once 'models/University.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo json_encode(null);
            return;
        }

        $university = new University($db);

        require_once 'models/Course.php';

        $id = $_GET['id'] ?? 0;
        $details = $university->getById($id);
        
        if ($details) {
            $courseModel = new Course($db);
            $courses = $courseModel->getCourses($id);
            $details['courses'] = $courses;
        }
        
        echo json_encode($details);
    }

    public function applications() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/University.php';
        require_once 'models/Application.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo "Database connection failed.";
            return;
        }

        $university = new University($db);
        $app = new Application($db);

        $user_id = $_SESSION['user_id'];
        $profile = $university->getProfile($user_id);

        if ($profile) {
            $university_id = $profile['id'];
            $applications = $app->getApplicationsByUniversity($university_id);
            require_once 'views/university/applications.php';
        } else {
            echo "University profile not found";
        }
    }

    public function updateApplicationStatus() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not logged in']);
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/Application.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
            exit;
        }

        $app = new Application($db);

        $id = $_POST['id'] ?? 0;
        $status = $_POST['status'] ?? '';

        if ($app->updateStatus($id, $status)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Update failed']);
        }
    }

    public function updateApplicationFeedback() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not logged in']);
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/Application.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
            exit;
        }

        $app = new Application($db);

        $id = $_POST['id'] ?? 0;
        $feedback = $_POST['feedback'] ?? '';

        if ($app->sendFeedback($id, $feedback)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Update failed']);
        }
    }
}
