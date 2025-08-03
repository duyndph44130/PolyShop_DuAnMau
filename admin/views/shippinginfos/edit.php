<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Chỉnh sửa trạng thái vận chuyển</h2>

    <p><strong>Khách hàng:</strong> <?= htmlspecialchars($shipment['user_name']) ?></p>
    <p><strong>Người nhận:</strong> <?= $shipment['recipient_name'] ?></p>
    <p><strong>Địa chỉ:</strong> <?= $shipment['address'] ?></p>
    <p><strong>Phương thức:</strong> <?= $shipment['shipping_method'] ?></p>
    <p><strong>Trạng thái hiện tại:</strong> <?= $shipment['shipping_status'] ?></p>
    <p><strong>Ngày đặt hàng:</strong> <?= $shipment['created_at'] ?></p>


    <form method="POST" action="?act=/shippinginfo/edit&id=<?= $shipment['shipping_id'] ?>">        
        <label for="shipping_status">Trạng thái mới:</label>
        <select name="shipping_status" id="shipping_status">
            <?php
            $statuses = ['Chưa gửi', 'Đang giao', 'Giao thành công', 'Giao thất bại'];
            foreach ($statuses as $s) {
                $selected = ($shipment['shipping_status'] === $s) ? 'selected' : '';
                echo "<option value=\"$s\" $selected>$s</option>";
            }
            ?>
        </select>
        <br><br>
        <button type="submit">Cập nhật</button>
    </form>
</div>

<?php include './views/layouts/footer.php'; ?>
