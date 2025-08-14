<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/menu.php'; ?>

<div class="category-container container">
    <!-- Tiêu đề danh mục -->
    <?php foreach ($categories as $cat) : ?>
        <?php if ($cat['category_id'] == $category['category_id']) : ?>
            <h2 class="category-title">
                🛍️ Danh mục: <?= htmlspecialchars($cat['name'] ?? 'Không xác định') ?>
            </h2>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- Nếu có sản phẩm -->
    <?php if (!empty($products)): ?>
        <div class="category-grid product-grid"> <!-- Thêm product-grid để dùng chung style -->
            <?php foreach ($products as $product): ?>
                <div class="category-card product-card"> <!-- Thêm product-card để dùng chung style -->
                    <a href="?act=/product/detail&id=<?= $product['product_id'] ?>">
                        <img src="admin/<?= htmlspecialchars($product['image_url']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="category-image product-image"> <!-- Thêm product-image -->
                    </a>
                    <h3 class="category-product-name product-name"><?= htmlspecialchars($product['name']) ?></h3> <!-- Thêm product-name -->
                    <p class="category-product-price product-price"><?= number_format($product['price']) ?>₫</p> <!-- Thêm product-price -->
                    <a href="?act=/product/detail&id=<?= $product['product_id'] ?>" class="category-btn btn-view"> <!-- Thêm btn-view -->
                        Xem chi tiết
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="category-empty empty-message">Không có sản phẩm nào trong danh mục này.</div> <!-- Thêm empty-message -->
    <?php endif; ?>
</div>

<?php include './views/layouts/footer.php'; ?>
