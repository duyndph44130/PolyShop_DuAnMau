<?php
class PaymentController {
    public $model;

    public function __construct() {
        $this->model = new PaymentModel();
    }

    public function list() {
        $payments = $this->model->getAllPayments();
        require_once './views/payments/list.php';
    }

    public function detail($id) {
        $payment = $this->model->getPaymentById($id);
        require_once './views/payments/show.php';
    }
}
