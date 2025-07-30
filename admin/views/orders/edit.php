<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa trạng thái đơn hàng</title>
</head>
<body>
    <h2>Chi tiết đơn hàng <?= $order['order_id'] ?></h2>

    <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['user_name']) ?></p>
    <p><strong>Ngày đặt:</strong> <?= $order['created_at'] ?></p>
    <p><strong>Trạng thái hiện tại:</strong> <?= $order['status'] ?></p>

    <h3>Sản phẩm trong đơn hàng</h3>
    <table border="1" cellpadding="8">
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

    <hr>

    <h3>Cập nhật trạng thái đơn hàng</h3>
    <form method="POST" action="?act=/order/edit&id=<?= $order['order_id'] ?>">
    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">

    <label for="status">Trạng thái mới:</label>
    <select name="status" id="status">
        <?php
        $statuses = ['Chờ xác nhận', 'Đang giao', 'Hoàn tất', 'Đã huỷ'];
        foreach ($statuses as $s) {
            $selected = ($order['status'] === $s) ? 'selected' : '';
            echo "<option value=\"$s\" $selected>$s</option>";
        }
        ?>
    </select>

    <br><br>
    <button type="submit">Cập nhật</button>
    </form>

    <br>
    <a href="?act=/orders">← Quay lại danh sách đơn hàng</a>

</body>
</html>