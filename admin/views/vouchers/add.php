<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<?php $errors = $errors ?? []; ?>

<div class="main-content">
    <h2>Thêm mới mã giảm giá</h2>

    <form method="POST">
        <label>Mã code:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"><br>
        <?php if (!empty($errors['name'])): ?><small style="color:red"><?= $errors['name'] ?></small><br><?php endif; ?>
        <br>

        <label>Giảm (%):</label><br>
        <input type="number" name="discount_value" min="1" max="100" value="<?= htmlspecialchars($_POST['discount_value'] ?? '') ?>"><br>
        <?php if (!empty($errors['discount_value'])): ?><small style="color:red"><?= $errors['discount_value'] ?></small><br><?php endif; ?>
        <br>

        <label>Giảm tối đa (VNĐ):</label><br>
        <input type="number" name="max_discount" value="<?= htmlspecialchars($_POST['max_discount'] ?? '') ?>"><br><br>

        <label>Giá trị tối thiểu đơn hàng (VNĐ):</label><br>
        <input type="number" name="min_order_value" value="<?= htmlspecialchars($_POST['min_order_value'] ?? '') ?>"><br><br>

        <label>Ngày bắt đầu:</label><br>
        <input type="date" name="start_date" value="<?= htmlspecialchars($_POST['start_date'] ?? '') ?>"><br><br>

        <label>Ngày kết thúc:</label><br>
        <input type="date" name="end_date" value="<?= htmlspecialchars($_POST['end_date'] ?? '') ?>"><br>
        <?php if (!empty($errors['date'])): ?><small style="color:red"><?= $errors['date'] ?></small><br><?php endif; ?>
        <br>

        <label>Áp dụng cho sản phẩm:</label><br>
        <select name="product_id">
            <option value="">-- Toàn bộ sản phẩm --</option>
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['product_id'] ?>" <?= ($_POST['product_id'] ?? '') == $product['product_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($product['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">➕ Thêm voucher</button>
    </form>

    <br><a href="?act=/vouchers">← Quay lại danh sách</a>
</div>

<?php include './views/layouts/footer.php'; ?>
