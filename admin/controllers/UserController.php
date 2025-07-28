<?php 
class UserController {
    public $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Lấy danh sách người dùng
    public function list() {
        $listUsers = $this->userModel->getAllUsers();
        require_once './views/users/list.php';
    }

    // Chi tiết người dùng
    public function detail($id) {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            http_response_code(404);
            echo "Người dùng không tồn tại.";
            return;
        }
        require_once './views/users/show.php';
    }

    // Thêm người dùng
    public function add() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $role = $_POST['role'] ?? 'client';

            // Validate
            if (empty($name)) $errors[] = "Tên không được để trống.";
            if (empty($email)) $errors[] = "Email không được để trống.";
            if (empty($password)) $errors[] = "Mật khẩu không được để trống.";
            if (empty($phone)) $errors[] = "Số điện thoại không được để trống.";
            if (empty($address)) $errors[] = "Địa chỉ không được để trống.";
            if (empty($role)) $errors[] = "Vai trò không hợp lệ.";

            if ($this->userModel->findByEmail($email)) {
                $errors[] = "Email đã được sử dụng.";
            }

            if (strlen($password) < 6) {
                $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
            }

            if (!preg_match('/[A-Z]/', $password) || 
                !preg_match('/[a-z]/', $password) || 
                !preg_match('/[0-9]/', $password)) {
                $errors[] = "Mật khẩu phải có ít nhất một chữ hoa, một chữ thường và một số.";
            }

            if (empty($errors)) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                if ($this->userModel->create($name, $email, $hashed, $phone, $address, $role)) {
                    header('Location: ?act=/users');
                    exit;
                } else {
                    $errors[] = "Lỗi khi thêm người dùng.";
                }
            }
        }

        require_once './views/users/add.php';
    }

    // Chỉnh sửa người dùng
    public function edit($id) {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            http_response_code(404);
            echo "Người dùng không tồn tại.";
            return;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $role = $_POST['role'] ?? 'client';

            if (empty($name)) $errors[] = "Tên không được để trống.";
            if (empty($email)) $errors[] = "Email không được để trống.";
            if (empty($phone)) $errors[] = "Số điện thoại không được để trống.";
            if (empty($address)) $errors[] = "Địa chỉ không được để trống.";
            if (empty($role)) $errors[] = "Vai trò không hợp lệ.";

            // Mặc định giữ lại mật khẩu cũ nếu không đổi
            $hashed = $user['password'];
            if (!empty($password)) {
                if (strlen($password) < 6 || 
                    !preg_match('/[A-Z]/', $password) || 
                    !preg_match('/[a-z]/', $password) || 
                    !preg_match('/[0-9]/', $password)) {
                    $errors[] = "Mật khẩu mới phải có ít nhất 6 ký tự, bao gồm chữ hoa, chữ thường và số.";
                } else {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                }
            }

            if (empty($errors)) {
                if ($this->userModel->update($id, $name, $email, $hashed, $phone, $address, $role)) {
                    header('Location: ?act=/users');
                    exit;
                } else {
                    $errors[] = "Lỗi khi cập nhật người dùng.";
                }
            }
        }

        require_once './views/users/edit.php';
    }

    // Xóa người dùng
    public function delete($id) {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            http_response_code(404);
            echo "Người dùng không tồn tại.";
            return;
        }

        if ($this->userModel->delete($id)) {
            header('Location: ?act=/users');
            exit;
        } else {
            echo "Lỗi khi xoá người dùng.";
        }
    }
}
