<?php
class CheckoutController {
    private $cartModel;
    private $shippingModel;

    public function __construct() {
        $this->cartModel = new CartModel();
        $this->shippingModel = new ShippinginfoModel();
    }

    // Hiển thị form checkout
    public function checkout() {
        $userId = $_SESSION['user']['user_id'] ?? null;
        if (!$userId) { header("Location: ?act=/login"); exit; }

        $cart = $this->cartModel->getCart($userId);
        $items = $this->cartModel->getCartItems($cart['order_id']);
        $total = $this->cartModel->calculateTotal($cart['order_id']);

        include './views/checkout.php';
    }

    // Xử lý đặt hàng
    public function placeOrder() {
        $userId = $_SESSION['user']['user_id'] ?? null;
        if (!$userId) { header("Location: ?act=/login"); exit; }

        $errors = [];
        $receiver_name = trim($_POST['receiver_name']);
        $receiver_phone = trim($_POST['receiver_phone']);
        $receiver_address = trim($_POST['receiver_address']);
        $payment = $_POST['payment'] ?? 'COD';

        // Validate server-side
        if (strlen($receiver_name) < 3) {
            $errors['receiver_name'] = "Họ tên người nhận phải có ít nhất 3 ký tự.";
        }

        if (!preg_match('/^[0-9]{9,11}$/', $receiver_phone)) {
            $errors['receiver_phone'] = "Số điện thoại không hợp lệ (9-11 chữ số).";
        }

        if (strlen($receiver_address) < 5) {
            $errors['receiver_address'] = "Địa chỉ giao hàng phải có ít nhất 5 ký tự.";
        }

        // Nếu có lỗi → quay lại form
        if (!empty($errors)) {
            $cart = $this->cartModel->getCart($userId);
            $items = $this->cartModel->getCartItems($cart['order_id']);
            $total = $this->cartModel->calculateTotal($cart['order_id']);
            include './views/checkout.php';
            return;
        }

        // Lấy đơn hàng hiện tại (giỏ hàng)
        $cart = $this->cartModel->getCart($userId);

        // Tạo shipping info gắn trực tiếp vào order
        $this->shippingModel->create([
            'order_id' => $cart['order_id'],
            'recipient_name' => $receiver_name,
            'phone' => $receiver_phone,
            'address' => $receiver_address,
            'shipping_method' => $payment
        ]);

        // Cập nhật trạng thái đơn hàng sang 'pending'
        $this->cartModel->updateStatus($cart['order_id'], 'pending');

        unset($_SESSION['cart']);
        $_SESSION['success'] = "Thanh toán thành công!";
        header("Location: ?act=/thankyou");
        exit;
    }

    public function thankYou() {
        include './views/thankyou.php';
    }
}
