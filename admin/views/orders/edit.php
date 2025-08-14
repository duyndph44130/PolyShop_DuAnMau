<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Chi tiết đơn hàng #<?= $order['order_id'] ?></h2>

    <?php
        $statusMap = [
            'cart' => ['Giỏ hàng', 'gray'],
            'pending' => ['Chờ xác nhận', 'orange'],
            'processing' => ['Đang giao', 'blue'],
            'completed' => ['Hoàn tất', 'green'],
            'canceled' => ['Đã huỷ', 'red']
        ];
        $statusLabel = $statusMap[$order['status']][0] ?? $order['status'];
        $statusColor = $statusMap[$order['status']][1] ?? 'black';
    ?>

    <h3 class="text-red-500">Thông tin khách hàng</h3>
    <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['user_name']) ?></p>
    <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
    <p><strong>Tổng tiền:</strong> <?= number_format($order['total_amount'], 0, ',', '.') ?>₫</p>
    <p><strong>Trạng thái:</strong> <span style="color: <?= $statusColor ?>; font-weight: bold;"><?= $statusLabel ?></span></p>

    <h3 class="text-red-500">Thông tin giao hàng</h3>
    <p><strong>Người nhận:</strong> <?= htmlspecialchars($order['recipient_name'] ?? 'N/A') ?></p>
    <p><strong>Điện thoại:</strong> <?= htmlspecialchars($order['phone'] ?? 'N/A') ?></p>
    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address'] ?? 'N/A') ?></p>
    <p><strong>Phương thức:</strong> <?= htmlspecialchars($order['shipping_method'] ?? 'N/A') ?></p>

    <h3>Sản phẩm trong đơn hàng</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <tr style="background: #f4f4f4;">
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
        <?php foreach ($orderDetails as $item): ?>
            <tr>
                <td><img src="<?= $item['image_url'] ?>" width="60"></td>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>₫</td>
            </tr>
        <?php endforeach; ?>
    </table>

    <hr>

    <h3>Cập nhật trạng thái đơn hàng</h3>
    <form method="POST" action="?act=/order/edit&id=<?= $order['order_id'] ?>">
        <label for="status">Trạng thái mới:</label>
        <select name="status" id="status">
            <?php foreach ($statusMap as $key => $info): ?>
                <option value="<?= $key ?>" <?= ($order['status'] === $key) ? 'selected' : '' ?>>
                    <?= $info[0] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <button class="btn" type="submit">Cập nhật</button>
    </form>

    <br>
    <a class="btn" href="?act=/orders">← Quay lại danh sách đơn hàng</a>
</div>

<?php include './views/layouts/footer.php'; ?>
