<?php 

class ProductModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAllProducts() {
        try {
            $sql = "SELECT * FROM products";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}