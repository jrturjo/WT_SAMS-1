<?php
session_start();

$url = $_GET['url'] ?? '';

if ($url == '') {
    include 'views/landing.php';
} elseif ($url == 'login') {
    include 'controllers/AuthController.php';
    $auth = new AuthController();
    $auth->login();
} elseif ($url == 'register') {
    include 'controllers/AuthController.php';
    $auth = new AuthController();
    $auth->register();
} elseif ($url == 'dashboard') {
    include 'controllers/DashboardController.php';
    $dash = new DashboardController();
    $dash->index();
} elseif ($url == 'login_submit') {
    include 'controllers/AuthController.php';
    $auth = new AuthController();
    $auth->loginSubmit();
} elseif ($url == 'register_submit') {
    include 'controllers/AuthController.php';
    $auth = new AuthController();
    $auth->registerSubmit();
} elseif ($url == 'profile') {
    include 'controllers/StudentController.php';
    $studentCallback = new StudentController();
    $studentCallback->profile();
} elseif ($url == 'update_profile') {
    include 'controllers/StudentController.php';
    $studentCallback = new StudentController();
    $studentCallback->updateProfile();
} elseif ($url == 'update_profile') {
    include 'controllers/StudentController.php';
    $studentCallback = new StudentController();
    $studentCallback->updateProfile();
} elseif ($url == 'university_profile') {
    include 'controllers/UniversityController.php';
    $uni = new UniversityController();
    $uni->profile();
} elseif ($url == 'update_university_profile') {
    include 'controllers/UniversityController.php';
    $uni = new UniversityController();
    $uni->updateProfile();
} elseif ($url == 'universities') {
    include 'controllers/StudentController.php';
    $student = new StudentController();
    $student->universities();
} elseif ($url == 'history') {
    include 'controllers/StudentController.php';
    $student = new StudentController();
    $student->history();
} elseif ($url == 'api_universities') {
    include 'controllers/UniversityController.php';
    $uni = new UniversityController();
    $uni->getUniversitiesJSON();
} elseif ($url == 'api_university_details') {
    include 'controllers/UniversityController.php';
    $uni = new UniversityController();
    $uni->getUniversityDetailsJSON();
} elseif ($url == 'view_applications') {
    include 'controllers/UniversityController.php';
    $uni = new UniversityController();
    $uni->applications();
} elseif ($url == 'update_application_status') {
    include 'controllers/UniversityController.php';
    $uni = new UniversityController();
    $uni->updateApplicationStatus();
} elseif ($url == 'update_application_feedback') {
    include 'controllers/UniversityController.php';
    $uni = new UniversityController();
    $uni->updateApplicationFeedback();
} elseif ($url == 'manage_courses') {
    include 'controllers/CourseController.php';
    $course = new CourseController();
    $course->manageCourses();
} elseif ($url == 'add_course') {
    include 'controllers/CourseController.php';
    $course = new CourseController();
    $course->addCourse();
} elseif ($url == 'remove_course') {
    include 'controllers/CourseController.php';
    $course = new CourseController();
    $course->removeCourse();
} elseif ($url == 'apply_course') {
    include 'controllers/ApplicationController.php';
    $app = new ApplicationController();
    $app->apply();
} elseif ($url == 'logout') {
    include 'controllers/AuthController.php';
    $auth = new AuthController();
    $auth->logout();
} elseif ($url == 'reset_password') {
    include 'controllers/AuthController.php';
    $auth = new AuthController();
    $auth->resetPassword();
} elseif ($url == 'reset_password_submit') {
    include 'controllers/AuthController.php';
    $auth = new AuthController();
    $auth->resetPasswordSubmit();
} else {
    echo "404 Page Not Found";
}
