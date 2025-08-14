<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Sửa trạng thái vận chuyển #<?= $shipment['shipping_id'] ?? '' ?></h2>

    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <!-- Hiển thị thông tin vận chuyển đầy đủ -->
    <table border="1" style="margin-bottom:20px;">
        <tr><th>ID</th><td><?= $shipment['shipping_id'] ?? '' ?></td></tr>
        <tr><th>Khách hàng</th><td><?= htmlspecialchars($shipment['user_name'] ?? '') ?></td></tr>
        <tr><th>Người nhận</th><td><?= htmlspecialchars($shipment['recipient_name'] ?? '') ?></td></tr>
        <tr><th>Địa chỉ</th><td><?= htmlspecialchars($shipment['address'] ?? '') ?></td></tr>
        <tr><th>Điện thoại</th><td><?= htmlspecialchars($shipment['phone'] ?? '') ?></td></tr>
        <tr><th>Phương thức</th><td><?= htmlspecialchars($shipment['shipping_method'] ?? '') ?></td></tr>
        <tr><th>Ngày đặt</th><td><?= $shipment['created_at'] ?? '' ?></td></tr>
        <tr><th>Trạng thái đơn hàng</th><td><?= htmlspecialchars($shipment['order_status'] ?? '') ?></td></tr>
    </table>

    <!-- Form cập nhật trạng thái -->
    <form method="POST">
        <label for="shipping_status">Trạng thái vận chuyển:</label>
        <select name="shipping_status" id="shipping_status">
            <?php 
            $statusLabels = [
                'pending'    => 'Chờ xác nhận',
                'processing' => 'Đang giao',
                'completed'  => 'Hoàn tất',
                'canceled'   => 'Đã huỷ'
            ];
            foreach ($statusLabels as $status => $label): 
                $selected = ($shipment['shipping_status'] === $status) ? 'selected' : '';
            ?>
                <option value="<?= $status ?>" <?= $selected ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <button class="btn" type="submit">Cập nhật</button>
    </form>

    <br>
    <a class="btn" href="?act=/shippinginfos">⬅ Quay lại danh sách</a>
</div>

<?php include './views/layouts/footer.php'; ?>
