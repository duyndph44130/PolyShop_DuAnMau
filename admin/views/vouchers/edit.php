<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa voucher</title>
</head>
<body>
    <h2>Sửa voucher: <?= htmlspecialchars($voucher['code']) ?></h2>

    <form method="POST">
        Mã code: <input type="text" name="code" value="<?= $voucher['code'] ?>" required><br><br>
        Giảm (%): <input type="number" name="discount_percent" value="<?= $voucher['discount_percent'] ?>" required><br><br>
        Giảm tối đa (VNĐ): <input type="number" name="max_discount" value="<?= $voucher['max_discount'] ?>" required><br><br>
        Giá trị tối thiểu (VNĐ): <input type="number" name="min_order_value" value="<?= $voucher['min_order_value'] ?>" required><br><br>
        Hạn dùng: <input type="date" name="expiry_date" value="<?= $voucher['expiry_date'] ?>" required><br><br>
        <button type="submit">Cập nhật</button>
    </form>

    <a href="?act=/vouchers">← Quay lại danh sách</a>

</body>
</html>