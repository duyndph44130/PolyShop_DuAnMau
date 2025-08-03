<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Sửa voucher: <?= htmlspecialchars($voucher['code']) ?></h2>

    <form method="POST">
        Mã code: <input type="text" name="code" value="<?= $voucher['code'] ?>" required><br><br>
        Giảm (%): <input type="number" name="discount_percent" value="<?= $voucher['discount_percent'] ?>" required><br><br>
        Giảm tối đa (VNĐ): <input type="number" name="max_discount" value="<?= $voucher['max_discount'] ?>" required><br><br>
        Giá trị tối thiểu (VNĐ): <input type="number" name="min_order_value" value="<?= $voucher['min_order_value'] ?>" required><br><br>
        Hạn dùng: <input type="date" name="expiry_date" value="<?= $voucher['expiry_date'] ?>" required><br><br>
        <button type="submit">Cập nhật</button>
    </form>

    <a class="btn" href="?act=/vouchers">← Quay lại danh sách</a>
</div>

<?php include './views/layouts/footer.php'; ?>
