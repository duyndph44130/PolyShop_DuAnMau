<?php
class ContactAdminController {
    private $contactModel;

    public function __construct() {
        $this->contactModel = new ContactModel();
        // Có thể thêm kiểm tra admin login ở đây
    }

    // Danh sách liên hệ
    public function list() {
        $contacts = $this->contactModel->getAllContacts();

        // Load view list, truyền data
        require './views/contacts/list.php';
    }

    // Chi tiết liên hệ
    public function detail($id) {
        $id = (int)$id;
        if ($id <= 0) {
            $_SESSION['error'] = "Liên hệ không hợp lệ.";
            header('Location: ?act=/contacts');
            exit;
        }

        $contact = $this->contactModel->getContactById($id);
        if (!$contact) {
            $_SESSION['error'] = "Liên hệ không tồn tại.";
            header('Location: ?act=/contacts');
            exit;
        }

        require './views/contacts/show.php';
    }

    // Cập nhật trạng thái (POST)
 // Hàm xử lý POST cập nhật trạng thái liên hệ
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ";
            header("Location: ?act=/contacts");
            exit;
        }

        $contact_id = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;
        $status = $_POST['status'] ?? '';

        // Validate dữ liệu
        $allowedStatuses = ['Chưa xử lý', 'Đang xử lý', 'Đã xử lý'];
        if ($contact_id <= 0 || !in_array($status, $allowedStatuses)) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ";
            header("Location: ?act=/contacts");
            exit;
        }

        // Cập nhật trạng thái
        $updated = $this->contactModel->updateStatus($contact_id, $status);

        if ($updated) {
            $_SESSION['success'] = "Cập nhật trạng thái liên hệ thành công";
        } else {
            $_SESSION['error'] = "Cập nhật trạng thái thất bại";
        }

        // Chuyển về trang chi tiết liên hệ để xem kết quả
        header("Location: ?act=/contacts");
        exit;
    }
    // Xóa liên hệ (POST)
    public function delete() {
        // Chấp nhận cả GET và POST
        $id = 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['contact_id'] ?? 0);
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = (int)($_GET['id'] ?? 0);
        } else {
            $_SESSION['error'] = "Phương thức không hợp lệ";
            header('Location: ?act=/contacts');
            exit;
        }

        if ($id <= 0) {
            $_SESSION['error'] = "Liên hệ không hợp lệ.";
            header('Location: ?act=/contacts');
            exit;
        }

        if ($this->contactModel->deleteContact($id)) {
            $_SESSION['success'] = "Xóa liên hệ thành công.";
        } else {
            $_SESSION['error'] = "Xóa liên hệ thất bại.";
        }

        header('Location: ?act=/contacts');
        exit;
    }


}
