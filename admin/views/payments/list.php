<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách thanh toán</title>
</head>
<body>
    <h2>Danh sách thanh toán</h2>

    <table border="1" cellpadding="8">
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

</body>
</html>