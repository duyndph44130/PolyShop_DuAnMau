<?php 
class OrderController {
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function orderHistory() {
        if (empty($_SESSION['user']['user_id'])) {
            header("Location: ?act=/login");
            exit;
        }

        $orders = $this->orderModel->getOrdersByUserId($_SESSION['user']['user_id']);
        require './views/orderhistory.php';
    }

public function orderDetail() {
    if (empty($_GET['id'])) {
        header("Location: ?act=/account/orders");
        exit;
    }

    $orderId = (int) $_GET['id'];
    $order = $this->orderModel->getOrderById($orderId);
    $items = $this->orderModel->getOrderItems($orderId);

    // ====== TÍNH TỔNG & GIẢM GIÁ ======
    $tam_tinh = 0;
    foreach ($items as $item) {
        $tam_tinh += $item['price'] * $item['quantity'];
    }

    $discount_amount = 0;
    if (!empty($_SESSION['voucher'])) {
        $voucher = $_SESSION['voucher'];

        if (!empty($voucher['discount_percent'])) {
            $discount_amount = $tam_tinh * ($voucher['discount_percent'] / 100);
        }

        if (!empty($voucher['discount_value'])) {
            $discount_amount = $voucher['discount_value'];
        }

        if (!empty($voucher['max_discount']) && $discount_amount > $voucher['max_discount']) {
            $discount_amount = $voucher['max_discount'];
        }
    }

    $tong_cong = $tam_tinh - $discount_amount;

    // Truyền dữ liệu sang view
    require './views/orderdetail.php';
}


}
