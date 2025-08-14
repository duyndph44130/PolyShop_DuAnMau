<?php
class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function profile() {
        if (empty($_SESSION['user_id'])) {
            header("Location: ?act=/login");
            exit;
        }
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        require './views/profile.php';
    }

    public function editProfile() {
        if (empty($_SESSION['user_id'])) {
            header("Location: ?act=/login");
            exit;
        }
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        require './views/profileupdate.php';
    }

    public function updateProfile() {
        if (empty($_SESSION['user_id'])) {
            header("Location: ?act=/login");
            exit;
        }

        $name     = $_POST['name'] ?? '';
        $email    = $_POST['email'] ?? '';
        $phone    = $_POST['phone'] ?? '';
        $address  = $_POST['address'] ?? '';
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

        if ($this->userModel->updateUser($_SESSION['user_id'], $name, $email, $phone, $address, $password)) {
            $_SESSION['success'] = "Cập nhật thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật thất bại!";
        }
        header("Location: ?act=/account/editProfile");
    }
}
