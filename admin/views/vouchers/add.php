<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm voucher mới</title>
</head>
    <h2>Thêm mới voucher</h2>

    <form method="POST">
        Mã code: <input type="text" name="code" required><br><br>
        Giảm (%): <input type="number" name="discount_percent" min="1" max="100" required><br><br>
        Giảm tối đa (VNĐ): <input type="number" name="max_discount" required><br><br>
        Giá trị tối thiểu (VNĐ): <input type="number" name="min_order_value" required><br><br>
        Hạn dùng: <input type="date" name="expiry_date" required><br><br>
        <button type="submit">Thêm</button>
    </form>

    <a href="?act=/vouchers">← Quay lại danh sách</a>

</body>
</html>