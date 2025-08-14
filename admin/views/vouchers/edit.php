<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<?php $errors = $errors ?? []; ?>

<div class="main-content">
    <h2>Sửa mã giảm giá: <?= htmlspecialchars($voucher['name']) ?></h2>

    <form method="POST">
        <label>Mã code:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($voucher['name'] ?? '') ?>"><br>
        <?php if (!empty($errors['name'])): ?><small style="color:red"><?= $errors['name'] ?></small><br><?php endif; ?>
        <br>

        <label>Giảm (%):</label><br>
        <input type="number" name="discount_value" min="1" max="100" value="<?= htmlspecialchars($voucher['discount_value'] ?? '') ?>"><br>
        <?php if (!empty($errors['discount_value'])): ?><small style="color:red"><?= $errors['discount_value'] ?></small><br><?php endif; ?>
        <br>

        <label>Giảm tối đa (VNĐ):</label><br>
        <input type="number" name="max_discount" value="<?= htmlspecialchars($voucher['max_discount'] ?? '') ?>"><br><br>

        <label>Giá trị tối thiểu đơn hàng (VNĐ):</label><br>
        <input type="number" name="min_order_value" value="<?= htmlspecialchars($voucher['min_order_value'] ?? '') ?>"><br><br>

        <label>Ngày bắt đầu:</label><br>
        <input type="date" name="start_date" value="<?= htmlspecialchars($voucher['start_date'] ?? '') ?>"><br><br>

        <label>Ngày kết thúc:</label><br>
        <input type="date" name="end_date" value="<?= htmlspecialchars($voucher['end_date'] ?? '') ?>"><br>
        <?php if (!empty($errors['date'])): ?><small style="color:red"><?= $errors['date'] ?></small><br><?php endif; ?>
        <br>

        <label>Áp dụng cho sản phẩm:</label><br>
        <select name="product_id">
            <option value="">-- Toàn bộ sản phẩm --</option>
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['product_id'] ?>" <?= ($voucher['product_id'] ?? '') == $product['product_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($product['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button class="btn" type="submit">💾 Cập nhật voucher</button>
    </form>

    <br><a class="btn" href="?act=/vouchers">← Quay lại danh sách</a>
</div>

<?php include './views/layouts/footer.php'; ?>
