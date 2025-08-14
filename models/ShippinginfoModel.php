<?php
class ShippinginfoModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    /**
     * Thêm thông tin người nhận hàng gắn với order_id
     */
    public function create(array $data) {
        $sql = "INSERT INTO shippinginfo (order_id, recipient_name, phone, address, shipping_method, shipping_status)
                VALUES (:order_id, :recipient_name, :phone, :address, :shipping_method, 'pending')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $data['order_id']);
        $stmt->bindParam(':recipient_name', $data['recipient_name']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':shipping_method', $data['shipping_method']);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }
}