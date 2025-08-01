<?php
class PaymentModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy tất cả thanh toán
    public function getAllPayments() {
        $sql = "SELECT p.*, o.user_id, u.name as user_name
                FROM payment p
                JOIN `order` o ON p.order_id = o.order_id
                JOIN user u ON o.user_id = u.user_id
                ORDER BY p.payment_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 thanh toán theo ID
    public function getPaymentById($payment_id) {
        $sql = "SELECT p.*, o.user_id, u.name as user_name
                FROM payment p
                JOIN `order` o ON p.order_id = o.order_id
                JOIN user u ON o.user_id = u.user_id
                WHERE p.payment_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$payment_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
