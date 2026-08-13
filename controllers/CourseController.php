<?php
class CourseController {
    
    public function manageCourses() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/Course.php';
        require_once 'models/University.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo "Database connection failed.";
            return;
        }
        
        $user_id = $_SESSION['user_id'];
        $stmt = $db->prepare("SELECT id FROM universities WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $uni_row = $stmt->fetch();

        if (!$uni_row) {
            echo "Please create a university profile first.";
            return;
        }
        
        $university_id = $uni_row['id'];
        
        $courseModel = new Course($db);
        $courses = $courseModel->getCourses($university_id);
        
        require_once 'views/university/manage_courses.php';
    }

    public function addCourse() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/Course.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            header("Location: index.php?url=manage_courses");
            exit;
        }
            
        $user_id = $_SESSION['user_id'];
        $stmt = $db->prepare("SELECT id FROM universities WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $uni_row = $stmt->fetch();
        $university_id = $uni_row['id'];

        $department = $_POST['department'] ?? '';
        $course_name = $_POST['course_name'] ?? '';

        $courseModel = new Course($db);
        $courseModel->addCourse($university_id, $department, $course_name);
        
        header("Location: index.php?url=manage_courses");
        exit;
    }

    public function removeCourse() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        require_once 'config/database.php';
        require_once 'models/Course.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            header("Location: index.php?url=manage_courses");
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        
        $courseModel = new Course($db);
        $courseModel->removeCourse($id);
        
        header("Location: index.php?url=manage_courses");
        exit;
    }
}
