<?php
class AdminAuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Đăng nhập admin
    public function login() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validate email
            if (empty($email)) {
                $errors['email'] = "Vui lòng nhập email.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email không hợp lệ.";
            }

            // Validate mật khẩu
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập mật khẩu.";
            }

            // Nếu không có lỗi → kiểm tra đăng nhập
            if (empty($errors)) {
                $user = $this->userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    // Lưu thông tin user vào session
                    $_SESSION['user'] = $user;

                    // Điều hướng theo role
                    if ($user['role'] === 'client') {
                        $_SESSION['success'] = "Đăng nhập thành công!";
                        header('Location: /PolyShop_DuAnMau/?act=/home');
                        exit;
                    } elseif ($user['role'] === 'admin') {
                        $_SESSION['success'] = "Đăng nhập thành công!";
                        header('Location: /PolyShop_DuAnMau/admin/?act=/dashboard');
                        exit;
                    } else {
                        // Role không hợp lệ → đăng xuất
                        session_destroy();
                        $errors['general'] = "Tài khoản không có quyền truy cập.";
                        require_once './views/login.php';
                        return;
                    }
                } else {
                    $_SESSION['error'] = "Sai email hoặc mật khẩu!";
                }
            }
        }
        
        require_once './views/auth/login.php';
    }

    // Đăng xuất admin
    public function logout() {
        unset($_SESSION['admin']);
        $_SESSION['success'] = "Đăng xuất thành công!";
        header('Location: ?act=/login');
        exit;
    }
}
