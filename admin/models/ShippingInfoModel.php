<?php
class ShippingInfoModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy tất cả bản ghi vận chuyển
    public function getAllShipping() {
        $sql = "SELECT s.*, o.created_at, o.status AS order_status, u.name AS user_name
                FROM shippinginfo s
                JOIN orders o ON s.order_id = o.order_id
                JOIN user u ON o.user_id = u.user_id
                ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết theo shipping_id
    public function getShippingById($shipping_id) {
        $sql = "SELECT s.*, o.created_at, o.status AS order_status, u.name AS user_name
                FROM shippinginfo s
                JOIN orders o ON s.order_id = o.order_id
                JOIN user u ON o.user_id = u.user_id
                WHERE s.shipping_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$shipping_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái giao hàng
    public function updateShippingStatus($shipping_id, $status) {
        $sql = "UPDATE shippinginfo 
                SET shipping_status = :status 
                WHERE shipping_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $shipping_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Tìm kiếm Shipping Info
    public function search($keyword = '') {
        $sql = "SELECT s.*, o.created_at, u.name AS user_name
                FROM shippinginfo s
                JOIN orders o ON s.order_id = o.order_id
                JOIN user u ON o.user_id = u.user_id";

        if (!empty($keyword)) {
            $sql .= " WHERE s.recipient_name LIKE :kw 
                    OR s.phone LIKE :kw 
                    OR u.name LIKE :kw";
        }

        $sql .= " ORDER BY o.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        if (!empty($keyword)) {
            $kw = "%" . $keyword . "%";
            $stmt->bindParam(':kw', $kw, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
