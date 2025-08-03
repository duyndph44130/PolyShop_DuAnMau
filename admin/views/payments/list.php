<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Danh sách thanh toán</h2>

    <table border="1" >
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Phương thức</th>
            <th>Trạng thái</th>
            <th>Ngày thanh toán</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?= $payment['payment_id'] ?></td>
                <td><?= htmlspecialchars($payment['user_name']) ?></td>
                <td><?= $payment['payment_method'] ?></td>
                <td><?= $payment['payment_status'] ?></td>
                <td><?= $payment['payment_date'] ?></td>
                <td>
                    <a href="?act=/payment/detail&id=<?= $payment['payment_id'] ?>">Xem</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>

<?php include './views/layouts/footer.php'; ?>
