<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/menu.php'; ?>

<div class="container main-content search-page-container"> <!-- Thêm main-content và search-page-container -->

    <!-- KẾT QUẢ TÌM KIẾM -->
    <main class="search-results-main"> <!-- Đổi tên class -->
        <h2 class="search-results-title">
            🔍 Kết quả tìm kiếm cho: 
            <span class="search-keyword">"<?= htmlspecialchars($keyword) ?>"</span>
        </h2>

        <?php if (!empty($results)): ?>
            <div class="product-grid search-product-grid"> <!-- Thêm search-product-grid -->
                <?php foreach ($results as $product): ?>
                    <div class="product-card search-product-card"> <!-- Thêm search-product-card -->
                        <a href="?act=/product/detail&id=<?= $product['product_id'] ?>">
                            <img src="admin//<?= htmlspecialchars($product['image_url']) ?>" 
                                    alt="<?= htmlspecialchars($product['name']) ?>" 
                                    class="product-image">
                            <div class="product-card-content"> <!-- Thêm div bọc nội dung -->
                                <h3 class="product-name">
                                    <?= htmlspecialchars($product['name']) ?>
                                </h3>
                                <p class="product-price">
                                    <?= number_format($product['price'], 0, ',', '.') ?>₫
                                </p>
                                <a href="?act=/product/detail&id=<?= $product['product_id'] ?>" class="btn-view btn-primary">Xem chi tiết</a>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-product empty-message">
                Không tìm thấy sản phẩm nào phù hợp với từ khóa 
                "<strong><?= htmlspecialchars($keyword) ?></strong>".
            </p>
        <?php endif; ?>
    </main>

</div>

<?php include './views/layouts/footer.php'; ?>
