<?php
class CartModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    /** 
     * Lấy giỏ hàng theo user_id (nếu chưa có thì tạo mới)
     */
    public function getCartByUserId($userId) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id = :user_id LIMIT 1");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cart) {
                $stmt = $this->conn->prepare("
                    INSERT INTO cart (user_id, created_at, updated_at) 
                    VALUES (:user_id, NOW(), NOW())
                ");
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();
                $cartId = $this->conn->lastInsertId();
                return [
                    'cart_id' => $cartId,
                    'user_id' => $userId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }

            return $cart;
        } catch (PDOException $e) {
            error_log("CartModel::getCartByUserId error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Lấy tất cả sản phẩm trong giỏ hàng
     */
    // Lấy tất cả sản phẩm trong giỏ hàng
    public function getCartItems($cartId) {
        $sql = "SELECT ci.cart_item_id, ci.cart_id, ci.product_id, ci.quantity, 
                    p.name AS product_name, p.price, p.image_url, p.stock_quantity
                FROM cartitem ci
                JOIN product p ON ci.product_id = p.product_id
                WHERE ci.cart_id = :cart_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Thêm sản phẩm vào giỏ hàng hoặc cập nhật số lượng
    public function addOrUpdateCartItem($cartId, $productId, $quantity, $price) {
        try {
            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $stmt = $this->conn->prepare("SELECT quantity FROM cartitem WHERE cart_id = :cart_id AND product_id = :product_id LIMIT 1");
            $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                // Cập nhật số lượng + updated_at
                $newQuantity = $existingItem['quantity'] + $quantity;
                $stmt = $this->conn->prepare("
                    UPDATE cartitem 
                    SET quantity = :quantity, updated_at = NOW() 
                    WHERE cart_id = :cart_id AND product_id = :product_id
                ");
                $stmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
                $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                return $stmt->execute();
            } else {
                // Thêm mới sản phẩm
                $stmt = $this->conn->prepare("
                    INSERT INTO cartitem (cart_id, product_id, quantity, price, created_at, updated_at) 
                    VALUES (:cart_id, :product_id, :quantity, :price, NOW(), NOW())
                ");
                $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->bindParam(':price', $price);
                return $stmt->execute();
            }
        } catch (PDOException $e) {
            error_log("CartModel::addOrUpdateCartItem error: " . $e->getMessage());
            return false;
        }
    }
    /**
     * Cập nhật số lượng sản phẩm
     */
    public function updateCartItemQuantity($cartItemId, $quantity) {
        try {
            $stmt = $this->conn->prepare("
                UPDATE cartitem 
                SET quantity = :quantity, updated_at = NOW() 
                WHERE cartitem_id = :cartitem_id
            ");
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':cartitem_id', $cartItemId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("CartModel::updateCartItemQuantity error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeCartItem($cartItemId) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM cartitem WHERE cartitem_id = :cartitem_id");
            $stmt->bindParam(':cartitem_id', $cartItemId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("CartModel::removeCartItem error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clearCart($cartId) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM cartitem WHERE cart_id = :cart_id");
            $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("CartModel::clearCart error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy tổng số lượng sản phẩm trong giỏ hàng
     */
    public function getTotalCartItems($userId) {
        try {
            $cart = $this->getCartByUserId($userId);
            if (!$cart) return 0;

            $stmt = $this->conn->prepare("SELECT SUM(quantity) FROM cartitem WHERE cart_id = :cart_id");
            $stmt->bindParam(':cart_id', $cart['cart_id'], PDO::PARAM_INT);
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("CartModel::getTotalCartItems error: " . $e->getMessage());
            return 0;
        }
    }
}
