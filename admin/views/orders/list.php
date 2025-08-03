<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Danh sách đơn hàng</h2>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>Khách hàng</th>
        <th>Trạng thái</th>
        <th>Ngày đặt</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($orders as $order): ?>
        <tr>
        <td><?= $order['order_id'] ?></td>
        <td><?= htmlspecialchars($order['user_name']) ?></td>
        <td><?= $order['status'] ?></td>
        <td><?= $order['created_at'] ?></td>
        <td>
            <a href="?act=/order/detail&id=<?= $order['order_id'] ?>">Xem chi tiết</a>
            <a href="?act=/order/edit&id=<?= $order['order_id'] ?>">Sửa trạng thái</a>
        </td>
        </tr>
    <?php endforeach; ?>
    </table>
</div>

<?php include './views/layouts/footer.php'; ?>
