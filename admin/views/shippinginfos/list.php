<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách vận chuyển</title>
</head>
<body>
    <h2>Danh sách vận chuyển</h2>

    <table border="1" cellpadding="8">
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
    <?php foreach ($shipments as $s): ?>
    <tr>
        <td><?= $s['shipping_id'] ?></td>
        <td><?= htmlspecialchars($s['user_name']) ?></td>
        <td><?= htmlspecialchars($s['recipient_name']) ?></td>
        <td><?= htmlspecialchars($s['address']) ?></td>
        <td><?= $s['phone'] ?></td>
        <td><?= $s['shipping_method'] ?></td>
        <td><?= $s['shipping_status'] ?></td>
        <td><?= $s['created_at'] ?></td>
        <td><a href="?act=/shipping/edit&id=<?= $s['shipping_id'] ?>">Sửa</a></td>
    </tr>
    <?php endforeach; ?>
    </table>

</body>
</html>