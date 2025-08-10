<?php
class VoucherController {
    protected $voucherModel;

    public function __construct() {
        $this->voucherModel = new VoucherModel();
    }

    public function list() {
        $keyword = $_GET['keyword'] ?? '';
        $product_id = isset($_GET['product_id']) && is_numeric($_GET['product_id']) ? (int)$_GET['product_id'] : null;

        if (!empty($keyword)) {
            $listVouchers = $this->voucherModel->search($keyword, $product_id);
        } else {
            $listVouchers = $this->voucherModel->getAll($product_id);
        }

        require './views/vouchers/list.php';
    }

    public function add() {
        $errors = [];
        $data = $_POST ?? [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $discount_value = $_POST['discount_value'];
            $max_discount = $_POST['max_discount'] ?? null;
            $min_order_value = $_POST['min_order_value'] ?? null;
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $product_id = $_POST['product_id'] !== '' ? $_POST['product_id'] : null;
            $admin_id = $_SESSION['user']['admin_id'] ?? 1;

            if (empty($name)) $errors['name'] = "Mã giảm giá không được để trống.";
            if ($discount_value <= 0 || $discount_value > 100) $errors['discount_value'] = "Phần trăm giảm phải từ 1-100.";
            if (strtotime($start_date) > strtotime($end_date)) $errors['date'] = "Ngày bắt đầu phải trước hoặc bằng ngày kết thúc.";

            if (empty($errors)) {
                $this->voucherModel->insert($name, $discount_value, $max_discount, $min_order_value, $start_date, $end_date, $product_id, $admin_id);
                header("Location: ?act=/vouchers");
                exit;
            }
        }

        $products = (new ProductModel())->getAllProducts();
        require './views/vouchers/add.php';
    }

    public function edit($id) {
        $errors = [];
        $voucher = $this->voucherModel->getById($id);

        if (!$voucher) {
            die("Voucher không tồn tại.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $discount_value = $_POST['discount_value'];
            $max_discount = $_POST['max_discount'] ?? null;
            $min_order_value = $_POST['min_order_value'] ?? null;
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $product_id = $_POST['product_id'] !== '' ? $_POST['product_id'] : null;

            if (empty($name)) $errors['name'] = "Mã giảm giá không được để trống.";
            if ($discount_value <= 0 || $discount_value > 100) $errors['discount_value'] = "Phần trăm giảm phải từ 1-100.";
            if (strtotime($start_date) > strtotime($end_date)) $errors['date'] = "Ngày bắt đầu phải trước hoặc bằng ngày kết thúc.";

            if (empty($errors)) {
                $this->voucherModel->update($id, $name, $discount_value, $max_discount, $min_order_value, $start_date, $end_date, $product_id);
                header("Location: ?act=/vouchers");
                exit;
            }

            $voucher = $_POST;
            $voucher['voucher_id'] = $id; // giữ ID
        }

        $products = (new ProductModel())->getAllProducts();
        require './views/vouchers/edit.php';
    }

    public function delete($id) {
        $this->voucherModel->delete($id);
        header("Location: ?act=/vouchers");
        exit;
    }
}
