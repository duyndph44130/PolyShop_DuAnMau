<?php
class CategoryModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả danh mục
    public function getCategoryById(int $id): ?array
    {
        $sql = "SELECT category_id, name 
                FROM category
                WHERE category_id = :id 
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAllCategories(): array
    {
        $sql = "SELECT category_id, name FROM category ORDER BY name";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo ID danh mục
    public function getProductsByCategory($categoryId)
    {
        try {
            $sql = "SELECT p.product_id, p.name, p.price, p.image_url
            FROM products p
            WHERE p.category_id = :id
            ORDER BY p.product_id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $categoryId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi khi lấy sản phẩm theo danh mục: " . $e->getMessage();
            return [];
        }
    }
}
