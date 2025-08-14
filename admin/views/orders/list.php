<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Danh sách đơn hàng</h2>

    <!-- Form tìm kiếm -->
    <form method="GET" style="margin-bottom: 15px;">
        <input type="hidden" name="act" value="/orders">
        <input type="text" name="keyword" placeholder="Nhập từ khoá tìm kiếm..." 
            value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button class="btn" type="submit">Tìm kiếm</button>
    </form>

    <?php if (!empty($keyword)): ?>
        <p>Đã tìm thấy <?= count($orders) ?> kết quả cho từ khóa: <strong><?= htmlspecialchars($keyword) ?></strong></p>
        <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <tr style="background-color: #007bff; color: white;">
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Người nhận</th>
            <th>Điện thoại</th>
            <th>Địa chỉ</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['order_id'] ?></td>
                <td><?= htmlspecialchars($order['user_name']) ?></td>
                <td><?= htmlspecialchars($order['recipient_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($order['phone'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($order['address'] ?? 'N/A') ?></td>
                <td><?= number_format($order['total_amount'] ?? 0, 0, ',', '.') ?> ₫</td>
                <td><?= $order['status_label'] ?></td>
                <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                <td>
                    <a href="?act=/order/edit&id=<?= $order['order_id'] ?>">Sửa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include './views/layouts/footer.php'; ?>
