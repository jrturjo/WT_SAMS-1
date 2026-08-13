<?php
class AuthController {
    public function login() {
        require_once 'views/auth/login.php';
    }

    public function loginSubmit() {
        require_once 'config/database.php';
        require_once 'models/User.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            $error = "Database connection failed. Please try again later.";
            require_once 'views/auth/login.php';
            return;
        }

        $user = new User($db);

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $result = $user->login($email, $password);

        if ($result) {
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['role'] = $result['role'];
            header("Location: index.php?url=dashboard");
            exit;
        } else {
            $error = "Invalid email or password.";
            require_once 'views/auth/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?url=login");
        exit;
    }

    public function resetPassword() {
        require_once 'views/auth/reset_password.php';
    }

    public function resetPasswordSubmit() {
        require_once 'config/database.php';
        require_once 'models/User.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            $error = "Database connection failed. Please try again later.";
            require_once 'views/auth/reset_password.php';
            return;
        }

        $user = new User($db);

        $email = $_POST['email'] ?? '';
        $new_password = $_POST['new_password'] ?? '';

        if ($user->emailExists($email)) {
            if ($user->updatePassword($email, $new_password)) {
                $success = "Password updated successfully.";
            } else {
                $error = "Failed to update password.";
            }
        } else {
            $error = "Email not found.";
        }
        require_once 'views/auth/reset_password.php';
    }

    public function register() {
        require_once 'views/auth/register.php';
    }

    public function registerSubmit() {
        require_once 'config/database.php';
        require_once 'models/User.php';

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            $error = "Database connection failed. Please try again later.";
            require_once 'views/auth/register.php';
            return;
        }

        $user = new User($db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? '';

            if (empty($username) || empty($email) || empty($password) || empty($role)) {
                $error = "All fields are required.";
            } elseif (strpos($email, '@') === false) {
                $error = "Invalid email address.";
            } elseif (strlen($password) < 6) {
                $error = "Password must be at least 6 characters.";
            } elseif ($user->emailExists($email)) {
                $error = "Email already registered.";
            } else {
                if ($user->register($username, $email, $password, $role)) {
                    $success = "Registration successful";
                } else {
                    $error = "Registration failed.";
                }
            }
            require_once 'views/auth/register.php';
        }
    }
}
