<?php
class ContactController {
    private $contactModel;

    public function __construct() {
        $this->contactModel = new ContactModel();
    }

    // Form liên hệ
    public function form() {
        require_once './views/contact.php';
    }

    // Client gửi form liên hệ
    public function send() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ.";
            header('Location: ?act=/contact');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? null;
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';

        $errors = [];

        if ($name === '') {
            $errors['name'] = "Họ và tên không được để trống.";
        }

        if ($email === '') {
            $errors['email'] = "Email không được để trống.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ.";
        }

        if ($subject === '') {
            $errors['subject'] = "Tiêu đề không được để trống.";
        }

        if ($message === '') {
            $errors['message'] = "Nội dung không được để trống.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['name' => $name, 'email' => $email, 'phone' => $phone, 'subject' => $subject, 'message' => $message];
            header('Location: ?act=/contact');
            exit;
        }

        $result = $this->contactModel->addMessage($name, $email, $phone, $subject, $message);

        if ($result) {
            $_SESSION['success'] = "Gửi liên hệ thành công. Chúng tôi sẽ phản hồi bạn sớm nhất.";
            // Xoá dữ liệu old khi thành công
            unset($_SESSION['old']);
        } else {
            $_SESSION['error'] = "Gửi liên hệ thất bại. Vui lòng thử lại.";
            // Giữ lại dữ liệu để người dùng không mất
            $_SESSION['old'] = ['name' => $name, 'email' => $email, 'phone' => $phone, 'subject' => $subject, 'message' => $message];
        }

        header('Location: ?act=/contact');
        exit;
    }

}
