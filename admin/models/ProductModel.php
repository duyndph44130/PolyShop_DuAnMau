<?php

class ProductModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy tất cả sản phẩm (JOIN theo category.id)
    public function getAllProducts() {
        try {
            $sql = "SELECT p.*, c.name AS category_name
                    FROM product p
                    LEFT JOIN category c ON p.category_id = c.category_id
                    ORDER BY p.category_id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    // Lấy sản phẩm theo ID
    public function getProductById($id) {
        try {
            $sql = "SELECT * FROM product WHERE product_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Thêm sản phẩm
    public function addProduct($name, $description, $price, $size, $color, $stock_quantity, $image_url, $category_id, $created_by) {
        try {
            $sql = "INSERT INTO product 
                    (name, description, price, size, color, stock_quantity, image_url, category_id, created_by)
                    VALUES 
                    (:name, :description, :price, :size, :color, :stock_quantity, :image_url, :category_id, :created_by)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':size', $size);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':stock_quantity', $stock_quantity, PDO::PARAM_INT);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindParam(':created_by', $created_by, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $name, $description, $price, $size, $color, $stock_quantity, $image_url, $category_id) {
        try {
            $sql = "UPDATE product SET 
                        name = :name,
                        description = :description,
                        price = :price,
                        size = :size,
                        color = :color,
                        stock_quantity = :stock_quantity,
                        image_url = :image_url,
                        category_id = :category_id
                    WHERE product_id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':size', $size);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':stock_quantity', $stock_quantity, PDO::PARAM_INT);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Xoá sản phẩm
    public function deleteProduct($id) {
        try {
            $sql = "DELETE FROM product WHERE product_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function searchProducts($keyword) {
        try {
            $sql = "SELECT p.*, c.name AS category_name
                    FROM product p
                    LEFT JOIN category c ON p.category_id = c.category_id
                    WHERE p.name LIKE :kw OR p.description LIKE :kw
                    ORDER BY p.product_id DESC";
            $stmt = $this->conn->prepare($sql);
            $kw = '%' . $keyword . '%';
            $stmt->bindParam(':kw', $kw);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi tìm kiếm sản phẩm: " . $e->getMessage();
            return [];
        }
    }

}
