<?php 
class OrderModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    /**
     * Lấy tất cả đơn hàng
     */
    public function getAllOrders() {
        $sql = "
            SELECT o.*,
                u.name AS user_name,
                s.recipient_name,
                s.phone,
                s.address
            FROM orders o
            LEFT JOIN user u ON o.user_id = u.user_id
            LEFT JOIN shippinginfo s ON o.order_id = s.order_id
            ORDER BY o.created_at DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy thông tin đơn hàng theo ID
     */
    public function getOrderById($order_id) {
        $sql = "SELECT o.*, 
                    u.name AS user_name,
                    s.recipient_name,
                    s.phone,
                    s.address,
                    s.shipping_method
                FROM `orders` o
                JOIN user u ON o.user_id = u.user_id
                LEFT JOIN shippinginfo s ON o.order_id = s.order_id
                WHERE o.order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách sản phẩm trong đơn hàng
     */
    public function getOrderDetails($order_id) {
        $sql = "SELECT od.*, p.name AS product_name, p.image_url 
                FROM orderdetail od 
                JOIN product p ON od.product_id = p.product_id 
                WHERE od.order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateOrderStatus($order_id, $status) {
        $sql = "UPDATE `orders` SET status = :status WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0; 
    }

    /**
     * Tạo đơn hàng mới
     */
    public function createOrder($user_id, $total_amount, $status = 'pending') {
        $sql = "INSERT INTO `orders` (user_id, total_amount, status) 
                VALUES (:user_id, :total_amount, :status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    /**
     * Thêm sản phẩm vào chi tiết đơn hàng
     */
    public function addOrderDetail($order_id, $product_id, $quantity, $price) {
        $sql = "INSERT INTO orderdetail (order_id, product_id, quantity, price)
                VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function searchOrders($keyword = '') {
        $sql = "SELECT o.*, u.name AS user_name, 
                    s.recipient_name, s.phone, s.address
                FROM orders o
                JOIN user u ON o.user_id = u.user_id
                LEFT JOIN shippinginfo s ON o.order_id = s.order_id";

        if (!empty($keyword)) {
            $sql .= " WHERE o.order_id LIKE :kw 
                    OR u.name LIKE :kw 
                    OR s.phone LIKE :kw";
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