<?php
class AuthController {
    public $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: ?act=/categories');
                exit;
            } else {
                $errors[] = "Email hoặc mật khẩu không đúng.";
            }
        }

        require_once './views/auth/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ?act=/login');
        exit;
    }
}
