<?php

class CartController {
    private $cartModel;
    private $productModel;

    public function __construct() {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel(); // Để lấy thông tin sản phẩm
    }

    // Hiển thị trang giỏ hàng
    public function cart() {
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để xem giỏ hàng.";
            header('Location: ?act=/login');
            exit;
        }

        $userId = $_SESSION['user']['user_id'];
        $cart = $this->cartModel->getCartByUserId($userId);
        $cartItems = [];
        $totalAmount = 0;

        if ($cart) {
            $cartItems = $this->cartModel->getCartItems($cart['cart_id']);
            foreach ($cartItems as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }
        }

        require './views/cart.php';
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ.";
            header('Location: ?act=/shop');
            exit;
        }

        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thêm sản phẩm.";
            header('Location: ?act=/login');
            exit;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity  = (int)($_POST['quantity'] ?? 1);

        if ($productId <= 0 || $quantity <= 0) {
            $_SESSION['error'] = "Thông tin sản phẩm hoặc số lượng không hợp lệ.";
            header('Location: ?act=/shop');
            exit;
        }

        $product = $this->productModel->getProductById($productId);
        if (!$product) {
            $_SESSION['error'] = "Sản phẩm không tồn tại.";
            header('Location: ?act=/shop');
            exit;
        }

        if ($quantity > $product['stock_quantity']) {
            $_SESSION['error'] = "Số lượng sản phẩm trong kho không đủ.";
            header('Location: ?act=/shop');
            exit;
        }

        $userId = $_SESSION['user']['user_id'];
        $cart   = $this->cartModel->getCartByUserId($userId);

        if (!$cart) {
            $_SESSION['error'] = "Không thể tạo giỏ hàng.";
            header('Location: ?act=/shop');
            exit;
        }

        $result = $this->cartModel->addOrUpdateCartItem($cart['cart_id'], $productId, $quantity, $product['price']);
        $_SESSION[$result ? 'success' : 'error'] = $result
            ? "Sản phẩm đã được thêm vào giỏ hàng."
            : "Có lỗi xảy ra khi thêm sản phẩm.";

        header('Location: ?act=/cart');
        exit;
    }

    // Cập nhật số lượng
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Phương thức không hợp lệ.";
            header('Location: ?act=/cart');
            exit;
        }

        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để cập nhật giỏ hàng.";
            header('Location: ?act=/login');
            exit;
        }

        $cartItemId = (int)($_POST['cartitem_id'] ?? 0);
        $quantity   = (int)($_POST['quantity'] ?? 0);

        if ($cartItemId <= 0 || $quantity <= 0) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ.";
            header('Location: ?act=/cart');
            exit;
        }

        // Lấy product_id từ cartitem
        $cartItems = $this->cartModel->getCartItems($this->cartModel->getCartByUserId($_SESSION['user']['user_id'])['cart_id']);
        $itemInfo = null;
        foreach ($cartItems as $item) {
            if ($item['cartitem_id'] == $cartItemId) {
                $itemInfo = $item;
                break;
            }
        }

        if (!$itemInfo) {
            $_SESSION['error'] = "Sản phẩm trong giỏ hàng không tồn tại.";
            header('Location: ?act=/cart');
            exit;
        }

        $product = $this->productModel->getProductById($itemInfo['product_id']);
        if ($quantity > $product['stock_quantity']) {
            $_SESSION['error'] = "Số lượng sản phẩm trong kho không đủ.";
            header('Location: ?act=/cart');
            exit;
        }

        $result = $this->cartModel->updateCartItemQuantity($cartItemId, $quantity);
        $_SESSION[$result ? 'success' : 'error'] = $result
            ? "Số lượng đã được cập nhật."
            : "Có lỗi xảy ra khi cập nhật.";

        header('Location: ?act=/cart');
        exit;
    }

    // Xóa sản phẩm
    public function remove() {
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để xóa sản phẩm.";
            header('Location: ?act=/login');
            exit;
        }

        $cartItemId = (int)($_GET['id'] ?? 0);
        if ($cartItemId <= 0) {
            $_SESSION['error'] = "ID sản phẩm không hợp lệ.";
            header('Location: ?act=/cart');
            exit;
        }

        $result = $this->cartModel->removeCartItem($cartItemId);
        $_SESSION[$result ? 'success' : 'error'] = $result
            ? "Sản phẩm đã được xóa."
            : "Có lỗi xảy ra khi xóa sản phẩm.";

        header('Location: ?act=/cart');
        exit;
    }

    // Xóa toàn bộ giỏ hàng
    public function clear() {
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để xóa giỏ hàng.";
            header('Location: ?act=/login');
            exit;
        }

        $userId = $_SESSION['user']['user_id'];
        $cart   = $this->cartModel->getCartByUserId($userId);

        if (!$cart) {
            $_SESSION['error'] = "Không tìm thấy giỏ hàng.";
            header('Location: ?act=/cart');
            exit;
        }

        $result = $this->cartModel->clearCart($cart['cart_id']);
        $_SESSION[$result ? 'success' : 'error'] = $result
            ? "Giỏ hàng đã được làm trống."
            : "Có lỗi xảy ra khi làm trống giỏ hàng.";

        header('Location: ?act=/cart');
        exit;
    }
}
