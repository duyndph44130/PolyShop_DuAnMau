<?php
class DashboardModel {
    public $conn;
    public function __construct() {
        $this->conn = connectDB();
    }

    public function getStats() {
        $stmt = $this->conn->query("
            SELECT 
                (SELECT COUNT(*) FROM user) as users,
                (SELECT COUNT(*) FROM product) as products,
                (SELECT COUNT(*) FROM category) as categories,
                (SELECT COUNT(*) FROM `order`) as orders,
                (SELECT SUM(total_amount) FROM `order` WHERE status = 'completed') as revenue
        ");
        return $stmt->fetch();
    }

    public function getMonthlySales() {
        $sql = "SELECT MONTH(created_at) as month, COUNT(*) as total_orders, SUM(total_amount) as total_amount
                FROM `order`
                WHERE YEAR(created_at) = YEAR(CURDATE())
                GROUP BY MONTH(created_at)
                ORDER BY month";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function getTopCategories() {
        $sql = "SELECT name, description FROM category LIMIT 3";
        return $this->conn->query($sql)->fetchAll();
    }

    public function getRecentUsers() {
        return $this->conn->query("SELECT name, email FROM user ORDER BY user_id DESC LIMIT 3")->fetchAll();
    }

    public function getLatestProducts() {
        $sql = "SELECT p.name, p.price, p.stock_quantity, c.name as category_name
                FROM product p
                JOIN category c ON p.category_id = c.category_id
                ORDER BY p.product_id DESC LIMIT 5";
        return $this->conn->query($sql)->fetchAll();
    }
    
    public function getRecentOrders() {
        $sql = "SELECT o.order_id, u.name, o.created_at, o.status, o.total_amount
                FROM `order` o
                JOIN user u ON o.user_id = u.user_id
                ORDER BY o.order_id DESC LIMIT 5";
        return $this->conn->query($sql)->fetchAll();
    }


    public function getRecentComments() {
        $sql = "SELECT c.content, u.name as user_name, p.name as product_name
                FROM comment c
                JOIN user u ON c.user_id = u.user_id
                JOIN product p ON c.product_id = p.product_id
                ORDER BY c.comment_id DESC LIMIT 5";
        return $this->conn->query($sql)->fetchAll();
    }
}
