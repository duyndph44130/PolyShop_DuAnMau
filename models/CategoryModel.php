<?php
class CategoryModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả danh mục
    public function getAllCategories()
    {
        try {
            $sql = "SELECT * FROM category ORDER BY name ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi khi lấy danh mục: " . $e->getMessage();
            return [];
        }
    }

    // Lấy thông tin danh mục theo ID
    public function getCategoryById($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM category WHERE category_id = :id LIMIT 1");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi khi lấy danh mục theo ID: " . $e->getMessage();
            return false;
        }
    }

    // Lấy sản phẩm theo ID danh mục
    public function getProductsByCategory($categoryId)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT p.* 
                FROM product p
                WHERE p.category_id = :category_id
                ORDER BY p.created_at DESC
            ");
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi khi lấy sản phẩm theo danh mục: " . $e->getMessage();
            return [];
        }
    }
}
