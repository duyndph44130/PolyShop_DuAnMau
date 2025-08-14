<?php
class OrderModel {

    protected $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getOrdersByUserId($user_id) {
        try {
            $sql = "SELECT o.order_id, o.total_amount, o.status, o.created_at
                    FROM orders o
                    WHERE o.user_id = :user_id
                    ORDER BY o.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("OrderModel::getOrdersByUserId error: " . $e->getMessage());
            return [];
        }
    }

    public function getOrderById($orderId) {
        $sql = "SELECT o.*, u.name, u.email, s.recipient_name, s.phone, s.address
                FROM orders o
                JOIN user u ON o.user_id = u.user_id
                LEFT JOIN shippinginfo s ON o.order_id = s.order_id
                WHERE o.order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT od.*, p.name AS product_name, p.image_url
                FROM orderdetail od
                JOIN product p ON od.product_id = p.product_id
                WHERE od.order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}