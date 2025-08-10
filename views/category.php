<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/menu.php'; ?>

<div class="container mx-auto px-4 py-6">
    <!-- Tiêu đề danh mục -->
    <h2 class="text-2xl font-bold mb-6 text-blue-600">
        🛍️ Danh mục: <?= htmlspecialchars($category['name']) ?>
    </h2>

    <!-- Nếu có sản phẩm -->
    <?php if (!empty($products)): ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($products as $product): ?>
                <div class="bg-white shadow rounded-lg p-4 hover:shadow-md transition">
                    <a href="?act=/product/detail&id=<?= $product['product_id'] ?>">
                        <img src="assets/images/<?= htmlspecialchars($product['image_url']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-full h-48 object-cover rounded mb-3">
                    </a>
                    <h3 class="text-lg font-semibold mb-1 line-clamp-1"><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="text-blue-600 font-bold mb-2"><?= number_format($product['price']) ?>₫</p>
                    <a href="?act=/product/detail&id=<?= $product['product_id'] ?>"
                        class="block text-center bg-blue-600 text-white rounded-full py-2 hover:bg-blue-700 transition">
                        Xem chi tiết
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-gray-500 italic">Không có sản phẩm nào trong danh mục này.</div>
    <?php endif; ?>
</div>

<?php include './views/layouts/footer.php'; ?>
