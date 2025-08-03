<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h1>Chi tiết sản phẩm</h1>

    <?php if (empty($product)): ?>
        <p>Sản phẩm không tồn tại.</p>
    <?php else: ?>
        <p><span class="label">ID:</span> <?= htmlspecialchars($product['product_id']) ?></p>
        <p><span class="label">Tên:</span> <?= htmlspecialchars($product['name']) ?></p>
        <p><span class="label">Mô tả:</span> <?= nl2br(htmlspecialchars($product['description'])) ?></p>
        <p><span class="label">Giá:</span> <?= number_format($product['price'], 0, ',', '.') ?> đ</p>
        <p><span class="label">Size:</span> <?= htmlspecialchars($product['size']) ?></p>
        <p><span class="label">Màu sắc:</span> <?= htmlspecialchars($product['color']) ?></p>
        <p><span class="label">Tồn kho:</span> <?= $product['stock_quantity'] ?></p>
        <p><span class="label">Danh mục:</span> <?= $product['category_id'] ?></p>
        <?php if (!empty($product['image_url'])): ?>
            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="Ảnh sản phẩm" width="200px">
        <?php endif; ?>
    <?php endif; ?>

    <br>
    <a class="btn" href="?act=/products">← Quay lại danh sách</a>
</div>

<?php include './views/layouts/footer.php'; ?>

