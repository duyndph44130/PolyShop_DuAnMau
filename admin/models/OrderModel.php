<?php 
class OrderModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }


    // Lấy tất cả đơn hàng
    public function getAllOrders() {
        $sql = " SELECT o.*, u.name as user_name
            FROM `order` o
            JOIN user u ON o.user_id = u.user_id
            ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết đơn hàng theo ID
    public function getOrderById($order_id) {
        $sql = "SELECT o.*, u.name as user_name
                FROM `order` o
                JOIN user u ON o.user_id = u.user_id
                WHERE o.order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách sản phẩm trong đơn hàng
    public function getOrderDetails($order_id) {
        $sql = "SELECT od.*, p.name as product_name, p.image_url 
                FROM orderdetail od 
                JOIN product p ON od.product_id = p.product_id 
                WHERE od.order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($order_id, $status) {
        $sql = "UPDATE `order` SET status = :status WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount() > 0; // Trả về true nếu có dòng bị cập nhật
    }
}