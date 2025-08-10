<?php
class CommentController {
    private $commentModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->commentModel = new CommentModel();
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ";
            header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/');
            exit;
        }

        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Bạn cần đăng nhập để bình luận";
            header('Location: ?act=/login');
            exit;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');

        if ($productId <= 0 || $content === '') {
            $_SESSION['error'] = "Nội dung bình luận không được để trống";
            header("Location: ?act=/product/detail&id=$productId");
            exit;
        }

        $userId = $_SESSION['user']['user_id'];

        $result = $this->commentModel->addComment($productId, $userId, $content);

        if ($result) {
            $_SESSION['success'] = "Bình luận của bạn đã được gửi";
        } else {
            $_SESSION['error'] = "Gửi bình luận thất bại, vui lòng thử lại";
        }

        header("Location: ?act=/product/detail&id=$productId");
        exit;
    }
}
