<?php
class CommentController {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new CommentModel();
    }

    public function list() {
        $comments = $this->commentModel->getAll();
        require_once './views/comments/list.php';
    }

    public function delete($id) {
        if ($this->commentModel->delete($id)) {
            header('Location: ?act=/comments');
            exit;
        } else {
            echo "Lỗi khi xoá bình luận.";
        }
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['user_id'] ?? null;
            $product_id = $_POST['product_id'] ?? null;
            $content = trim($_POST['content'] ?? '');

            if ($user_id && $product_id && $content) {
                $this->commentModel->create($user_id, $product_id, $content);
                header("Location: ?act=/product/detail&id=$product_id");
                exit;
            } else {
                echo "Vui lòng nhập đầy đủ thông tin.";
            }
        }
    }

    public function detail($id) {
        $comment = $this->commentModel->getById($id);
        if (!$comment) {
            http_response_code(404);
            echo "Bình luận không tồn tại.";
            return;
        }

        require_once './views/comments/show.php';
    }

    public function updateStatus($id) {
        $comment = $this->commentModel->getById($id);
        if (!$comment) {
            echo "Bình luận không tồn tại.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatus = $_POST['status'] ?? $comment['status'];

            if ($this->commentModel->updateStatus($id, $newStatus)) {
                header("Location: ?act=/comments");
                exit;
            } else {
                echo "Lỗi cập nhật trạng thái.";
            }
        }

        require_once './views/comments/edit.php';
    }

}
