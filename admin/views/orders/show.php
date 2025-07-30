<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
</head>
<body>
    <h2>Chi tiết đơn hàng #<?= $order['order_id'] ?></h2>
    <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['user_name']) ?></p>
    <p><strong>Ngày đặt:</strong> <?= $order['created_at'] ?></p>
    <p><strong>Trạng thái:</strong> <?= $order['status'] ?></p>
    <p><strong>Tổng tiền:</strong> <?= number_format($order['total_amount']) ?>₫</p>

    <h3>Sản phẩm trong đơn hàng:</h3>
    <table border="1" cellpadding="10">
    <tr>
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
        <td><?= number_format($item['price']) ?>₫</td>
        <td><?= number_format($item['price'] * $item['quantity']) ?>₫</td>
        </tr>
    <?php endforeach; ?>
    </table>
    
    <br>
    <a href="?act=/orders">← Quay lại danh sách đơn hàng</a>

</body>
</html>