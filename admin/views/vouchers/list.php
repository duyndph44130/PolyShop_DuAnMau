<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách voucher</title>
</head>
<body>
    <h2>Danh sách mã giảm giá</h2>

    <form method="GET">
        <input type="hidden" name="act" value="/vouchers">
        <input type="text" name="keyword" placeholder="Tìm theo mã voucher..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button type="submit">Tìm</button>
    </form>
    <br>

    <?php if (!empty($keyword)): ?>
        <p>Đã tìm thấy <?= count($listVouchers) ?> kết quả cho từ khóa: <strong><?= htmlspecialchars($keyword) ?></strong></p>
    <?php endif; ?>
    <br>

    <a href="?act=/voucher/add">+ Thêm mới voucher</a>

    <table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Mã code</th>
        <th>Giảm (%)</th>
        <th>Giảm tối đa</th>
        <th>Giá trị tối thiểu</th>
        <th>Hạn sử dụng</th>
        <th>Người tạo</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($listVouchers as $voucher): ?>
    <tr>
        <td><?= $voucher['voucher_id'] ?></td>
        <td><?= htmlspecialchars($voucher['code']) ?></td>
        <td><?= $voucher['discount_percent'] ?>%</td>
        <td><?= number_format($voucher['max_discount']) ?>₫</td>
        <td><?= number_format($voucher['min_order_value']) ?>₫</td>
        <td style="color: <?= (strtotime($voucher['expiry_date']) < time()) ? 'red' : 'green' ?>">
            <?= $voucher['expiry_date'] ?>
        </td>
        <td><?= htmlspecialchars($voucher['admin_name']) ?></td>
        <td>
            <a href="?act=/voucher/edit&id=<?= $voucher['voucher_id'] ?>">Sửa</a> |
            <a href="?act=/voucher/delete&id=<?= $voucher['voucher_id'] ?>" onclick="return confirm('Bạn chắc chắn muốn xoá?')">Xoá</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>

</body>
</html>