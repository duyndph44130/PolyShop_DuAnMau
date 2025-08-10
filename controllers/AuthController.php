<?php
class AuthController {
    private $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->userModel = new UserModel();
    }

    // Đăng nhập
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
                        header('Location: /PolyShop_DuAnMau/?act=/home'); // hoặc chỉ /PolyShop_DuAnMau nếu index.php mặc định
                        exit;
                    } elseif ($user['role'] === 'admin') {
                        header('Location: /PolyShop_DuAnMau/admin/?act=/dashboard'); // Chuyển đến trang admin mặc định (index.php)
                        exit;
                    } else {
                        // Role không hợp lệ → đăng xuất
                        session_destroy();
                        $errors['general'] = "Tài khoản không có quyền truy cập.";
                        require_once './views/login.php';
                        return;
                    }
                } else {
                    $errors['general'] = "Email hoặc mật khẩu không đúng.";
                }
            }
        }

        require_once './views/login.php';
    }

    // Đăng ký
    public function register() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $phone    = trim($_POST['phone'] ?? '');
            $address  = trim($_POST['address'] ?? '');
            $role     = 'client';

            // Validate tên
            if (empty($name)) {
                $errors['name'] = "Vui lòng nhập tên.";
            }

            // Validate email
            if (empty($email)) {
                $errors['email'] = "Vui lòng nhập email.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email không hợp lệ.";
            } elseif ($this->userModel->findByEmail($email)) {
                $errors['email'] = "Email đã tồn tại.";
            }

            // Validate mật khẩu
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập mật khẩu.";
            } elseif (strlen($password) < 6) {
                $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự.";
            }

            // Validate số điện thoại
            if (empty($phone)) {
                $errors['phone'] = "Vui lòng nhập số điện thoại.";
            } elseif (!preg_match('/^[0-9]{10,11}$/', $phone)) {
                $errors['phone'] = "Số điện thoại không hợp lệ.";
            } elseif ($this->userModel->findByPhone($phone)) {
                $errors['phone'] = "Số điện thoại đã tồn tại.";
            }

            // Validate địa chỉ
            if (empty($address)) {
                $errors['address'] = "Vui lòng nhập địa chỉ.";
            }

            // Nếu không có lỗi → lưu user mới
            if (empty($errors)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                if ($this->userModel->create($name, $email, $hashedPassword, $phone, $address, $role)) {
                    header("Location: ?act=/login");
                    exit;
                } else {
                    $errors['general'] = "Đăng ký thất bại. Vui lòng thử lại.";
                }
            }
        }

        require_once './views/register.php';
    }

    // Đăng xuất
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header('Location: ?act=/login');
        exit;
    }
}
