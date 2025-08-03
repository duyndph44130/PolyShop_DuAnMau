<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Danh sách vận chuyển</h2>

    <table border="1" >
    <tr>
        <th>ID</th>
        <th>Khách hàng</th>
        <th>Người nhận</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
        <th>Phương thức</th>
        <th>Trạng thái</th>
        <th>Ngày đặt</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($shipments as $shippinginfo): ?>
    <tr>
        <td><?= $shippinginfo['shipping_id'] ?></td>
        <td><?= htmlspecialchars($shippinginfo['user_name']) ?></td>
        <td><?= htmlspecialchars($shippinginfo['recipient_name']) ?></td>
        <td><?= htmlspecialchars($shippinginfo['address']) ?></td>
        <td><?= $shippinginfo['phone'] ?></td>
        <td><?= $shippinginfo['shipping_method'] ?></td>
        <td><?= $shippinginfo['shipping_status'] ?></td>
        <td><?= $shippinginfo['created_at'] ?></td>
        <td><a href="?act=/shippinginfo/detail&id=<?= $shippinginfo['shipping_id'] ?>">Xem chi tiết</a></td>
        <td><a href="?act=/shippinginfo/edit&id=<?= $shippinginfo['shipping_id'] ?>">Sửa</a></td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>

<?php include './views/layouts/footer.php'; ?>
