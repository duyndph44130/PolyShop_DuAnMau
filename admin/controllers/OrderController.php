<?php
class OrderController {
    public $modelOrder;

    public function __construct() {
        $this->modelOrder = new OrderModel();
    }

    // Dịch trạng thái sang tiếng Việt
    private function translateStatus($status) {
        $map = [
            'cart'       => 'Giỏ hàng',
            'pending'    => 'Chờ xác nhận',
            'processing' => 'Đang giao',
            'completed'  => 'Hoàn tất',
            'canceled'   => 'Đã huỷ'
        ];
        return $map[$status] ?? $status;
    }

    // Danh sách đơn hàng
    public function list() {
        $keyword = $_GET['keyword'] ?? '';
        $orders = $this->modelOrder->searchOrders($keyword);

        foreach ($orders as &$order) {
            $order['status_label'] = $this->translateStatus($order['status']);
        }

        require_once './views/orders/list.php';
    }

    // Xem chi tiết đơn hàng
    public function detail($order_id) {
        $order = $this->modelOrder->getOrderById($order_id);
        $order['status_label'] = $this->translateStatus($order['status']);

        $orderDetails = $this->modelOrder->getOrderDetails($order_id);

        require_once './views/orders/show.php';
    }

    // Sửa trạng thái đơn hàng
    public function edit($order_id) {
        $order = $this->modelOrder->getOrderById($order_id);
        $order['status_label'] = $this->translateStatus($order['status']);

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
