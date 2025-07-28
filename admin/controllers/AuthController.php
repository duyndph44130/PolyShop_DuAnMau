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

            if ($user && $password === $user['password']) {
                $_SESSION['user'] = $user;
                // var_dump($_SESSION); exit;

                header('Location: ?act=/categories');
                exit;
            } else {
                $errors[] = "Email hoặc mật khẩu không đúng.";
            }
        }

        require_once './views/auth/login.php';
    }
    public function register() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $role = 'client'; // mặc định là client

            // Validate
            if (empty($name)) $errors[] = "Tên không được để trống.";
            if (empty($email)) $errors[] = "Email không được để trống.";
            if (empty($password)) $errors[] = "Mật khẩu không được để trống.";
            if (empty($phone)) $errors[] = "Số điện thoại không được để trống.";
            if (empty($address)) $errors[] = "Địa chỉ không được để trống.";

            if ($this->userModel->findByEmail($email)) {
                $errors[] = "Email đã được sử dụng.";
            }

            if (empty($errors)) {
                // Không hash mật khẩu
                $success = $this->userModel->create($name, $email, $password, $phone, $address, $role);
                if ($success) {
                    header("Location: ?act=/login");
                    exit;
                } else {
                    $errors[] = "Đăng ký thất bại.";
                }
            }
        }

        require_once './views/auth/register.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ?act=/login');
        exit;
    }
}
