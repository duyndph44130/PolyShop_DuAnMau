<?php
class VoucherController {
    public $modelVoucher;

    public function __construct() {
        $this->modelVoucher = new VoucherModel();
    }

    public function list() {
        $listVouchers = $this->modelVoucher->getAll();

        $keyword = $_GET['keyword'] ?? '';

        if (!empty($keyword)) {
            $listVouchers = $this->modelVoucher->searchVouchers($keyword);
        } else {
            $listVouchers = $this->modelVoucher->getAll();
        }

        require './views/vouchers/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'];
            $percent = $_POST['discount_percent'];
            $max = $_POST['max_discount'];
            $expiry = $_POST['expiry_date'];
            $admin_id = $_SESSION['user']['admin_id'] ?? 1;
            $min_order_value = $_POST['min_order_value'];

            $this->modelVoucher->insert($code, $percent, $max, $min_order_value, $expiry, $admin_id);
            header("Location: ?act=/vouchers");
            exit;
        }

        require './views/vouchers/add.php';
    }

    public function edit($id) {
        $voucher = $this->modelVoucher->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'];
            $percent = $_POST['discount_percent'];
            $max = $_POST['max_discount'];
            $expiry = $_POST['expiry_date'];
            $min_order_value = $_POST['min_order_value'];

            $this->modelVoucher->update($id, $code, $percent, $max, $min_order_value, $expiry);
            header("Location: ?act=/vouchers");
            exit;
        }

        require './views/vouchers/edit.php';
    }

    public function delete($id) {
        $this->modelVoucher->delete($id);
        header("Location: ?act=/vouchers");
        exit;
    }
}
