<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/menu.php'; ?>

<div class="container mx-auto p-4 grid grid-cols-4 gap-4">

    <!-- Sidebar filter -->
    <aside class="col-span-1 bg-white p-4 rounded shadow">
        <form method="GET" action="">
            <input type="hidden" name="act" value="shop">

            <h3 class="font-bold mb-2">Tìm kiếm</h3>
            <input type="text" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>" class="w-full border p-2 rounded mb-4">

            <h3 class="font-bold mb-2">Danh mục</h3>
            <select name="category" class="w-full border p-2 rounded mb-4">
                <option value="0">Tất cả</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" <?= (!empty($category_id) && $category_id == $cat['category_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <h3 class="font-bold mb-2 flex">Khoảng giá</h3>
            <div class="flex items-center gap-2 mb-4">
                <input type="number" name="min_price" placeholder="Từ" value="<?= htmlspecialchars($min_price ?? '') ?>" 
                    class="w-1/2 border p-2 rounded">
                <span>đến</span>
                <input type="number" name="max_price" placeholder="Đến" value="<?= htmlspecialchars($max_price ?? '') ?>" 
                    class="w-1/2 border p-2 rounded">
            </div>

            <h3 class="font-bold mb-2">Sắp xếp</h3>
            <select name="sort" class="w-full border p-2 rounded mb-4">
                <option value="">Mặc định</option>
                <option value="price_asc" <?= (!empty($sort) && $sort == 'price_asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                <option value="price_desc" <?= (!empty($sort) && $sort == 'price_desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                <option value="newest" <?= (!empty($sort) && $sort == 'newest') ? 'selected' : '' ?>>Mới nhất</option>
                <option value="oldest" <?= (!empty($sort) && $sort == 'oldest') ? 'selected' : '' ?>>Cũ nhất</option>
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Lọc</button>
        </form>
    </aside>

    <!-- Product list -->
    <main class="col-span-3">
        <h2 class="text-2xl font-bold mb-4">Sản phẩm</h2>
        <?php if (!empty($products)): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($products as $product): ?>
                    <div class="bg-white shadow rounded p-3 hover:shadow-md transition">
                        <a href="?act=/product/detail&id=<?= $product['product_id'] ?>">
                            <img src="uploads/<?= htmlspecialchars($product['image_url']) ?>" 
                                    alt="<?= htmlspecialchars($product['name']) ?>" 
                                    class="w-full h-48 object-cover rounded">
                            <h3 class="mt-2 text-sm font-semibold"><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="text-blue-600 font-bold mt-1"><?= number_format($product['price'], 0, ',', '.') ?>₫</p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if (!empty($total_pages) && $total_pages > 1): ?>
                <div class="mt-6 flex justify-center gap-2">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?act=shop&page=<?= $i ?>&keyword=<?= urlencode($keyword ?? '') ?>&category=<?= $category_id ?? 0 ?>&min_price=<?= $min_price ?? '' ?>&max_price=<?= $max_price ?? '' ?>&sort=<?= $sort ?? '' ?>"
                            class="px-3 py-1 border rounded <?= ($i == $page) ? 'bg-blue-500 text-white' : 'bg-white' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <?php if (!empty($keyword)): ?>
                <p>Không tìm thấy sản phẩm nào cho từ khoá "<strong><?= htmlspecialchars($keyword) ?></strong>".</p>
            <?php else: ?>
                <p>Không tìm thấy sản phẩm nào.</p>
            <?php endif; ?>
        <?php endif; ?>

    </main>
</div>

<?php include './views/layouts/footer.php'; ?>
