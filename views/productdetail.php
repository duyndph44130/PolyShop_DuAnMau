<?php include './views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-6">

    <!-- Quay lại -->
    <button onclick="history.back()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        ⬅ Quay lại
    </button>
    <br><br>

    <!-- Chi tiết sản phẩm -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Hình ảnh -->
        <div class="bg-white p-4 rounded-lg shadow">
            <img src="assets/images/<?= htmlspecialchars($product['image'] ?? 'no-image.png') ?>"
                alt="<?= htmlspecialchars($product['name'] ?? 'Sản phẩm') ?>"
                class="w-full object-cover rounded">
        </div>

        <!-- Thông tin -->
        <div class="bg-white p-6 rounded-lg shadow space-y-4">
            <h1 class="text-2xl font-bold text-blue-700"><?= htmlspecialchars($product['name'] ?? '') ?></h1>
            <p class="text-xl text-red-600 font-semibold">
                <?= isset($product['price']) ? number_format($product['price']) . '₫' : 'Liên hệ' ?>
            </p>
            <p class="text-sm text-gray-600">
                Danh mục: <strong><?= htmlspecialchars($category['name'] ?? 'Không rõ') ?></strong>
            </p>

            <!-- Form thêm giỏ hàng -->
            <form action="?act=/cart/add" method="POST" class="space-y-4">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                <!-- Số lượng -->
                <label for="quantity" class="block text-sm font-medium mb-1">Số lượng:</label>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="decreaseQty()"
                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">−</button>
                    <input id="quantityInput" type="number" name="quantity" min="1" value="1"
                        class="w-20 text-center border px-2 py-1 rounded">
                    <button type="button" onclick="increaseQty()"
                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">+</button>
                </div>

                <button type="submit"
                    class="block w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
                    Thêm vào giỏ hàng
                </button>
            </form>
        </div>
    </div>

    <!-- Mô tả sản phẩm -->
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Mô tả sản phẩm</h2>
        <div class="text-gray-700 leading-relaxed">
            <?= isset($product['description']) ? nl2br(htmlspecialchars($product['description'])) : 'Không có mô tả.' ?>
        </div>
    </div>

    <!-- Khuyến mãi -->
    <?php if (!empty($voucher)): ?>
        <div class="mt-6 bg-pink-50 border-l-4 border-pink-400 p-4 rounded">
            <h3 class="font-semibold text-pink-600">🎁 Khuyến mãi</h3>
            <p class="text-sm text-pink-800 mt-1">
                Giảm <?= htmlspecialchars($voucher['discount_value']) ?>%
                <?php if (!empty($voucher['max_discount'])): ?>
                    , tối đa <?= number_format($voucher['max_discount']) ?>₫
                <?php endif; ?>
                (áp dụng từ <?= htmlspecialchars($voucher['start_date']) ?> đến <?= htmlspecialchars($voucher['end_date']) ?>)
            </p>
        </div>
    <?php endif; ?>

    <!-- Bình luận -->
    <div class="mt-10 bg-white p-6 rounded shadow">
        <h3 class="text-xl font-semibold text-pink-700 mb-4">Bình luận sản phẩm</h3>

        <?php if (!empty($comments)): ?>
            <div class="space-y-4 mb-6">
                <?php foreach ($comments as $cmt): ?>
                    <div class="border-b pb-3">
                        <p class="text-sm font-medium text-gray-700">
                            Người dùng: <span class="font-bold"><?= htmlspecialchars($cmt['user_name']) ?></span> – 
                            <span><?= htmlspecialchars($cmt['created_at']) ?></span>
                        </p>
                        <p class="text-gray-800 mt-1"><?= htmlspecialchars($cmt['content']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 mb-6">Chưa có bình luận nào cho sản phẩm này.</p>
        <?php endif; ?>

        <!-- Form gửi bình luận -->
        <?php if (isset($_SESSION['user'])): ?>
            <form action="?act=/comment/add" method="POST" class="space-y-4">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                <label for="content" class="block text-sm font-medium text-gray-700">Nội dung bình luận:</label>
                <textarea name="content" id="content" rows="4" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"></textarea>

                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Gửi bình luận</button>
            </form>
        <?php else: ?>
            <p class="text-sm text-gray-600 italic">
                Vui lòng <a href="?act=/login" class="text-blue-600 hover:underline">đăng nhập</a> để bình luận.
            </p>
        <?php endif; ?>
    </div>

</div>

<?php include './views/layouts/footer.php'; ?>

<!-- Script tăng giảm số lượng -->
<script>
    function decreaseQty() {
        const input = document.getElementById('quantityInput');
        let value = parseInt(input.value);
        if (value > 1) input.value = value - 1;
    }

    function increaseQty() {
        const input = document.getElementById('quantityInput');
        input.value = parseInt(input.value) + 1;
    }
</script>
