<?php
class ShippingInfoController {
    public $modelShippinginfo;

    public function __construct() {
        $this->modelShippinginfo = new ShippingInfoModel();
    }

    public function list() {
        $shipments = $this->modelShippinginfo->getAllShipping();
        require './views/shippinginfos/list.php';
    }

    public function detail($id) {
        $shipment = $this->modelShippinginfo->getShippingById($id);
        require './views/shippinginfos/show.php';
    }

    public function update($id) {
        $shipment = $this->modelShippinginfo->getShippingById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatus = $_POST['shipping_status'] ?? '';
            if ($this->modelShippinginfo->updateShippingStatus($id, $newStatus)) {
                header("Location: ?act=/shippinginfos");
                exit;
            } else {
                echo "❌ Không thể cập nhật trạng thái.";
            }
        }

        require './views/shippinginfos/edit.php';
    }
}
