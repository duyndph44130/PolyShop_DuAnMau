<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Chi tiết vận chuyển</h2>

    <p><strong>Khách hàng:</strong> <?= htmlspecialchars($shipment['user_name']) ?></p>
    <p><strong>Người nhận:</strong> <?= $shipment['recipient_name'] ?></p>
    <p><strong>Địa chỉ:</strong> <?= $shipment['address'] ?></p>
    <p><strong>Phương thức:</strong> <?= $shipment['shipping_method'] ?></p>
    <p><strong>Trạng thái hiện tại:</strong> <?= $shipment['shipping_status'] ?></p>
    <p><strong>Ngày đặt hàng:</strong> <?= $shipment['created_at'] ?></p>

    <br>
    <a class="btn" href="?act=/shippinginfo/edit&id=<?= $shipment['shipping_id'] ?>">Sửa trạng thái vận chuyển</a>
    <a class="btn" href="?act=/shippinginfos">← Quay lại danh sách vận chuyển</a>
</div>

<?php include './views/layouts/footer.php'; ?>