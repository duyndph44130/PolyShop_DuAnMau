<?php
class ShippingInfoModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy tất cả bản ghi vận chuyển
    public function getAllShipping() {
        $sql = "SELECT s.*, o.created_at, u.name as user_name
                FROM shippinginfo s
                JOIN `order` o ON s.order_id = o.order_id
                JOIN user u ON o.user_id = u.user_id
                ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết theo shipping_id
    public function getShippingById($shipping_id) {
        $sql = "SELECT s.*, o.created_at, u.name as user_name
                FROM shippinginfo s
                JOIN `order` o ON s.order_id = o.order_id
                JOIN user u ON o.user_id = u.user_id
                WHERE s.shipping_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$shipping_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái giao hàng
    public function updateShippingStatus($shipping_id, $status) {
        $sql = "UPDATE shippinginfo SET shipping_status = :status WHERE shipping_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $shipping_id);
        return $stmt->execute();
    }
}
