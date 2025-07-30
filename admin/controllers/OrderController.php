<?php
class OrderController {
    public $modelOrder;

    public function __construct() {
        $this->modelOrder = new OrderModel();
    }
        public function list() {
        $orders = $this->modelOrder->getAllOrders();
        require_once './views/orders/list.php';
    }

    public function detail($order_id) {
        $order = $this->modelOrder->getOrderById($order_id);
        $orderDetails = $this->modelOrder->getOrderDetails($order_id);
        require_once './views/orders/show.php';
    }

    // Xử lý cập nhật trạng thái
    public function edit($order_id) {
        $order = $this->modelOrder->getOrderById($order_id);
        $orderDetails = $this->modelOrder->getOrderDetails($order_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $status = $_POST['status'] ?? '';
            $updated = $this->modelOrder->updateOrderStatus((int)$order_id, $status);

            if ($updated || $status === $order['status']) {
                header("Location: ?act=/orders");
                exit;
            } else {
                echo "Không có gì thay đổi hoặc lỗi khi cập nhật trạng thái.";
            }
        }

        require_once './views/orders/edit.php';
    }

}