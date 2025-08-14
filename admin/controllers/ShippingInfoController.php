<?php
class ShippingInfoController {
    public $modelShippinginfo;

    public function __construct() {
        $this->modelShippinginfo = new ShippingInfoModel();
    }

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

    // List tất cả vận chuyển
    public function list() {
        $keyword = $_GET['keyword'] ?? '';
        $shippingInfos = $this->modelShippinginfo->search($keyword);

        // Map trạng thái sang tiếng Việt
        $statusMap = [
            'pending'    => 'Chờ xử lý',
            'shipping'   => 'Đang giao',
            'delivered'  => 'Đã giao',
            'canceled'   => 'Đã hủy'
        ];

        foreach ($shippingInfos as &$info) {
            $info['shipping_status_label'] = $statusMap[$info['shipping_status']] ?? $info['shipping_status'];
        }

        require_once './views/shippinginfos/list.php';
    }


    // Xem chi tiết vận chuyển
    public function detail($id) {
        $shippinginfos = $this->modelShippinginfo->getShippingById($id);
        $shippinginfos['shipping_status_label'] = $this->translateStatus($shippinginfos['shipping_status']);
        $shippinginfoDetai = $this->modelShippinginfo->getShippingById($id);
        require_once './views/shippinginfos/show.php';
    }

    // Cập nhật trạng thái vận chuyển
    public function edit($id) {
        $shipment = $this->modelShippinginfo->getShippingById($id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newStatus = trim($_POST['shipping_status'] ?? ''); // loại bỏ khoảng trắng dư thừa
        $validStatuses = ['pending','processing','completed','canceled'];

        // Kiểm tra giá trị có hợp lệ không
        if (!in_array($newStatus, $validStatuses, true)) {
            $error = "Trạng thái không hợp lệ.";
        } else {
            if ($this->modelShippinginfo->updateShippingStatus($id, $newStatus)) {
                header("Location: ?act=/shippinginfos");
                exit;
            } else {
                $error = "❌ Không thể cập nhật trạng thái.";
            }
        }
    }

        require './views/shippinginfos/edit.php';
    }
}
?>
