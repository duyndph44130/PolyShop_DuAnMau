<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/menu.php'; ?>

<div class="container mx-auto px-4 py-6">

    <!-- KẾT QUẢ TÌM KIẾM -->
    <main class="md:col-span-3">
        <h2 class="text-xl font-bold mb-6">
            🔍 Kết quả tìm kiếm cho: 
            <span class="text-blue-600">"<?= htmlspecialchars($keyword) ?>"</span>
        </h2>

        <?php if (!empty($results)): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($results as $product): ?>
                    <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">
                        <a href="?act=/product/detail&id=<?= $product['product_id'] ?>">
                            <img src="uploads/<?= htmlspecialchars($product['image_url']) ?>" 
                                    alt="<?= htmlspecialchars($product['name']) ?>" 
                                    class="w-full h-56 object-cover">
                            <div class="p-3">
                                <h3 class="text-sm font-semibold truncate">
                                    <?= htmlspecialchars($product['name']) ?>
                                </h3>
                                <p class="text-blue-600 font-bold mt-1">
                                    <?= number_format($product['price'], 0, ',', '.') ?>₫
                                </p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">
                Không tìm thấy sản phẩm nào phù hợp với từ khóa 
                "<strong><?= htmlspecialchars($keyword) ?></strong>".
            </p>
        <?php endif; ?>
    </main>

</div>

<?php include './views/layouts/footer.php'; ?>
