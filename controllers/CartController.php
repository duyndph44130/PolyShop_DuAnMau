<?php

class CartController {
    private $cartModel;
    private $productModel;
    private $voucherModel;

    public function __construct() {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->voucherModel = new VoucherModel();
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add() {
        $userId = $_SESSION['user']['user_id'] ?? null;
        if (!$userId) {
            if ($this->isAjax()) {
                echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập.']);
                exit;
            }
            header("Location: ?act=/login");
            exit;
        }

        $productId = intval($_POST['product_id'] ?? 0);
        $quantity  = max(1, intval($_POST['quantity'] ?? 1));

        $product = $this->productModel->getProductById($productId);
        if (!$product) {
            if ($this->isAjax()) {
                echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại.']);
                exit;
            }
            $_SESSION['error'] = "Sản phẩm không tồn tại.";
            header("Location: ?act=/shop");
            exit;
        }

        $this->cartModel->addOrUpdateItem($userId, $productId, $quantity, $product['price']);

        if ($this->isAjax()) {
            echo json_encode(['status' => 'success']);
            exit;
        }

        $_SESSION['success'] = "Đã thêm sản phẩm vào giỏ hàng.";
        header("Location: ?act=/cart");
        exit;
    }

    private function isAjax(): bool {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ (AJAX)
     */
    public function updateQty() {
        $orderDetailId = intval($_POST['orderdetail_id'] ?? 0);
        $quantity      = intval($_POST['quantity'] ?? 1);

        $this->cartModel->updateQuantity($orderDetailId, $quantity);

        $userId = $_SESSION['user']['user_id'] ?? null;
        $cart   = $this->cartModel->getCart($userId); // chỉ lấy, không tạo
        $total  = 0;
        $itemTotal = 0;

        if ($cart) {
            $items = $this->cartModel->getCartItems($cart['order_id']);
            foreach ($items as $item) {
                $total += $item['quantity'] * $item['price'];
                if ($item['orderdetail_id'] == $orderDetailId) {
                    $itemTotal = $item['quantity'] * $item['price'];
                }
            }
            $this->cartModel->calculateTotal($cart['order_id']);
        }

        echo json_encode([
            'status'     => 'success',
            'total'      => $total,
            'item_total' => $itemTotal
        ]);
        exit;
    }

    /**
     * Xóa sản phẩm khỏi giỏ (AJAX)
     */
    public function remove() {
        $orderDetailId = intval($_POST['orderdetail_id'] ?? 0);
        $this->cartModel->removeItem($orderDetailId);

        $userId = $_SESSION['user']['user_id'] ?? null;
        $total  = 0;

        $cart = $this->cartModel->getCart($userId); // chỉ lấy, không tạo
        if ($cart) {
            $total = $this->cartModel->calculateTotal($cart['order_id']);
        }
        $_SESSION['success'] = "Đã xoá sản phẩm khỏi giỏ hàng.";

        echo json_encode([
            'status' => 'success',
            'total'  => $total
        ]);
        exit;
    }

    /**
     * Hiển thị giỏ hàng
     */
    public function viewCart()
    {
        $userId = $_SESSION['user']['user_id'] ?? null;
        if (!$userId) {
            header("Location: ?act=/login");
            exit;
        }

        // Lấy giỏ hàng hiện tại
        $cart = $this->cartModel->getCart($userId); // chỉ lấy, không tạo mới
        $items = [];
        $total = 0;
        $discount = 0;

        if ($cart) {
            $items = $this->cartModel->getCartItems($cart['order_id']);
            $total = $this->cartModel->calculateTotal($cart['order_id']);

            // Nếu đã áp dụng voucher
            if (!empty($_SESSION['voucher'])) {
                $discount = $_SESSION['voucher']['discount'] ?? 0;
                $total -= $discount;
                if ($total < 0) $total = 0; // Không cho âm tổng tiền
            }
        }

        // Truyền dữ liệu sang view
        include './views/cart.php';
    }


    public function applyVoucher()
    {
        $code = trim($_POST['voucher_code'] ?? '');

        if (empty($code)) {
            $_SESSION['error'] = "Vui lòng nhập mã voucher.";
            header("Location: ?act=/cart");
            exit;
        }

        // Lấy thông tin voucher từ model
        $voucher = $this->voucherModel->getVoucherByCode($code);
        if (!$voucher) {
            $_SESSION['error'] = "Mã voucher không hợp lệ hoặc đã hết hạn.";
            header("Location: ?act=/cart");
            exit;
        }

        // Lấy tổng giá trị giỏ hàng hiện tại
        $userId = $_SESSION['user']['user_id'] ?? null;
        if (!$userId) {
            $_SESSION['error'] = "Bạn cần đăng nhập để áp dụng voucher.";
            header("Location: ?act=/login");
            exit;
        }

        $cart = $this->cartModel->getCart($userId);
        if (!$cart) {
            $_SESSION['error'] = "Giỏ hàng trống.";
            header("Location: ?act=/cart");
            exit;
        }

        $total = $this->cartModel->calculateTotal($cart['order_id']);

        // Kiểm tra giá trị tối thiểu của đơn hàng
        if (!empty($voucher['min_order_value']) && $total < $voucher['min_order_value']) {
            $_SESSION['error'] = "Đơn hàng chưa đạt giá trị tối thiểu để áp dụng voucher.";
            header("Location: ?act=/cart");
            exit;
        }

        // Tính số tiền giảm
        if ($voucher['discount_value'] <= 100) {
            // Giảm theo %
            $discount = ($total * $voucher['discount_value']) / 100;

            // Áp dụng giới hạn giảm tối đa nếu có
            if (!empty($voucher['max_discount']) && $discount > $voucher['max_discount']) {
                $discount = $voucher['max_discount'];
            }
        } else {
            // Giảm số tiền cố định
            $discount = $voucher['discount_value'];
        }

        // Không để giảm vượt quá tổng tiền
        if ($discount > $total) {
            $discount = $total;
        }

        // Lưu thông tin voucher vào session
        $_SESSION['voucher'] = [
            'code' => $voucher['name'],
            'discount' => $discount
        ];

        $_SESSION['success'] = "Áp dụng voucher thành công.";
        header("Location: ?act=/cart");
        exit;
    }


}
