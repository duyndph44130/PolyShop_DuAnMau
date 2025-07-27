<?php

class CategoryModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAllCategories() {
        try {
            $sql = "SELECT * FROM category";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function getCategoryById($id) {
        try {
            $sql = "SELECT * FROM category WHERE category_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function countProductsInCategory($categoryId) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM product WHERE category_id = ?");
            $stmt->execute([$categoryId]);
            return $stmt->fetchColumn(); // trả về số nguyên
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return 0;
        }
    }

    public function addCategory($name, $description) {
        try {
            $sql = "INSERT INTO category (name, description) VALUES (:name, :description)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function updateCategory($id, $name, $description) {
        try {
            $sql = "UPDATE category SET name = :name, description = :description WHERE category_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function destroyCategory($id) {
        try {
            $sql = "DELETE FROM category WHERE category_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}
