<?php
class CommentModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();

    }

    public function getCommentsByProductId(int $product_id): array {
        try {
            $sql = "SELECT c.*, u.name AS user_name 
                    FROM comment c 
                    JOIN user u ON c.user_id = u.user_id 
                    WHERE c.product_id = :product_id AND c.status = 'active' 
                    ORDER BY c.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log("CommentModel::getCommentsByProductId error: " . $e->getMessage());
            return [];
        }
    }
        
    public function addComment(int $product_id, int $user_id, string $content): bool {
        try {
            $sql = "INSERT INTO comment (product_id, user_id, content, status, created_at)
                    VALUES (:product_id, :user_id, :content, 'active', NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "PDO Exception: " . $e->getMessage();
            return false;
        }
    }



}
