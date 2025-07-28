<?php
class CommentModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM comment ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM comment WHERE comment_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($user_id, $product_id, $content) {
        $stmt = $this->conn->prepare("
            INSERT INTO comment (user_id, product_id, content, created_at)
            VALUES (:user_id, :product_id, :content, NOW())
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM comment WHERE comment_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getCommentsByProduct($product_id) {
        $stmt = $this->conn->prepare("SELECT * FROM comment WHERE product_id = :product_id ORDER BY created_at DESC");
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStatus($comment_id, $status) {
    try {
        $stmt = $this->conn->prepare("UPDATE comment SET status = :status WHERE comment_id = :id");
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $comment_id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Lỗi cập nhật trạng thái: " . $e->getMessage();
        return false;
    }
}

}
