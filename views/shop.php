<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/menu.php'; ?>

<div class="shop-container container">

    <!-- Sidebar filter -->
    <aside class="shop-sidebar">
        <form method="GET" action="" class="filter-form">
            <input type="hidden" name="act" value="shop">

            <h3 class="filter-title">Tìm kiếm</h3>
            <input type="text" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>" class="filter-input form-input">

            <h3 class="filter-title">Danh mục</h3>
            <select name="category" class="filter-select form-input">
                <option value="0">Tất cả</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" <?= (!empty($category_id) && $category_id == $cat['category_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <h3 class="filter-title">Khoảng giá</h3>
            <div class="filter-price">
                <input type="number" name="min_price" placeholder="Từ" value="<?= htmlspecialchars($min_price ?? '') ?>" class="filter-input-small form-input"> <br>
                <span class="price-sep">đến</span><br>
                <input type="number" name="max_price" placeholder="Đến" value="<?= htmlspecialchars($max_price ?? '') ?>" class="filter-input-small form-input">
            </div>

            <h3 class="filter-title">Sắp xếp</h3>
            <select name="sort" class="filter-select form-input">
                <option value="">Mặc định</option>
                <option value="price_asc" <?= (!empty($sort) && $sort == 'price_asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                <option value="price_desc" <?= (!empty($sort) && $sort == 'price_desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                <option value="newest" <?= (!empty($sort) && $sort == 'newest') ? 'selected' : '' ?>>Mới nhất</option>
                <option value="oldest" <?= (!empty($sort) && $sort == 'oldest') ? 'selected' : '' ?>>Cũ nhất</option>
            </select>

            <button type="submit" class="filter-btn btn-primary">Lọc</button>
        </form>
    </aside>

    <!-- Product list -->
    <main class="shop-main">
        <h2 class="shop-title">Sản phẩm</h2>
        <?php if (!empty($products)): ?>
            <div class="product-list product-grid"> <!-- Thêm product-grid để đồng bộ -->
                <?php foreach ($products as $product): ?>
                    <div class="product-item product-card"> <!-- Thêm product-card để đồng bộ -->
                        <a href="?act=/product/detail&id=<?= $product['product_id'] ?>">
                            <img src="admin/<?= htmlspecialchars($product['image_url']) ?>" 
                                    alt="<?= htmlspecialchars($product['name']) ?>" 
                                    class="product-image">
                            <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="product-price"><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                            <a href="?act=/product/detail&id=<?= $product['product_id'] ?>" class="btn-view btn-primary">Xem chi tiết</a>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if (!empty($total_pages) && $total_pages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?act=shop&page=<?= $i ?>&keyword=<?= urlencode($keyword ?? '') ?>&category=<?= $category_id ?? 0 ?>&min_price=<?= $min_price ?? '' ?>&max_price=<?= $max_price ?? '' ?>&sort=<?= $sort ?? '' ?>"
                            class="pagination-link <?= ($i == $page) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <?php if (!empty($keyword)): ?>
                <p class="no-product empty-message">Không tìm thấy sản phẩm nào cho từ khoá "<strong><?= htmlspecialchars($keyword) ?></strong>".</p>
            <?php else: ?>
                <p class="no-product empty-message">Không tìm thấy sản phẩm nào.</p>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</div>

<?php include './views/layouts/footer.php'; ?>
