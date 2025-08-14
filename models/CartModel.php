<?php
class CartModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // CHỈ LẤY giỏ 'cart' (không tự tạo)
    public function getCart($userId) {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id AND status = 'cart' LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Tạo giỏ 'cart' khi THẬT SỰ cần
    public function createCart($userId) {
        $stmt = $this->conn->prepare(
            "INSERT INTO orders (user_id, total_amount, status, created_at) 
            VALUES (:user_id, 0, 'cart', NOW())"
        );
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $cartId = $this->conn->lastInsertId();
        return ['order_id' => $cartId, 'user_id' => $userId, 'total_amount' => 0, 'status' => 'cart'];
    }

    // Lấy sản phẩm trong giỏ hàng
    public function getCartItems($orderId) {
        $sql = "SELECT od.orderdetail_id, od.product_id, od.quantity, od.price, 
                    p.name AS product_name, p.image_url, p.stock_quantity
                FROM orderdetail od
                JOIN product p ON od.product_id = p.product_id
                WHERE od.order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm hoặc cập nhật sản phẩm
    public function addOrUpdateItem($userId, $productId, $quantity, $price) {
        // 1) Lấy giỏ hiện có
        $cart = $this->getCart($userId);
        // 2) Nếu chưa có -> tạo MỚI ở đây (điểm hợp lý)
        if (!$cart) {
            $cart = $this->createCart($userId);
        }
        $orderId = $cart['order_id'];

        // 3) Thêm/cập nhật item
        $sql = "SELECT * FROM orderdetail WHERE order_id = :order_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $newQty = $item['quantity'] + $quantity;
            $stmt = $this->conn->prepare("UPDATE orderdetail SET quantity = :qty WHERE orderdetail_id = :id");
            $stmt->execute(['qty' => $newQty, 'id' => $item['orderdetail_id']]);
        } else {
            $stmt = $this->conn->prepare(
                "INSERT INTO orderdetail (order_id, product_id, quantity, price) 
                VALUES (:order_id, :product_id, :qty, :price)"
            );
            $stmt->execute([
                'order_id' => $orderId,
                'product_id' => $productId,
                'qty' => $quantity,
                'price' => $price
            ]);
        }

        // 4) Cập nhật tổng tiền
        $this->calculateTotal($orderId);
        return true;
    }

    // Cập nhật số lượng
    public function updateQuantity($orderDetailId, $quantity) {
        $stmt = $this->conn->prepare("UPDATE orderdetail SET quantity = :qty WHERE orderdetail_id = :id");
        return $stmt->execute(['qty' => $quantity, 'id' => $orderDetailId]);
    }

    // Xóa sản phẩm
    public function removeItem($orderDetailId) {
        $stmt = $this->conn->prepare("DELETE FROM orderdetail WHERE orderdetail_id = :id");
        return $stmt->execute(['id' => $orderDetailId]);
    }

    // Tính tổng tiền (ép về 0 nếu null)
    public function calculateTotal($orderId) {
        $stmt = $this->conn->prepare("SELECT SUM(quantity * price) FROM orderdetail WHERE order_id = :id");
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $total = (float) ($stmt->fetchColumn() ?: 0);

        $stmt2 = $this->conn->prepare("UPDATE orders SET total_amount = :total WHERE order_id = :id");
        $stmt2->execute(['total' => $total, 'id' => $orderId]);

        return $total;
    }

    public function updateStatus($orderId, $status) {
        $sql = "UPDATE orders SET status = :status WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'status'   => $status,
            'order_id' => $orderId
        ]);
    }
}
