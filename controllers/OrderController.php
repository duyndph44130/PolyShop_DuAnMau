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

        require './views/orderdetail.php';
    }

}
