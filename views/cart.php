<?php include './views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🛒 Giỏ hàng của bạn</h1>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <div class="text-center py-10 bg-white rounded-lg shadow-md">
            <p class="text-gray-600 text-lg mb-4">Giỏ hàng của bạn đang trống.</p>
            <a href="?act=/shop" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition">
                Tiếp tục mua sắm
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Danh sách sản phẩm -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                <?php foreach ($cartItems as $item): ?>
                    <div class="flex items-center border-b border-gray-200 py-4 last:border-b-0">
                        <!-- Ảnh sản phẩm -->
                        <div class="w-24 h-24 flex-shrink-0 mr-4">
                            <img src="assets/images/<?= htmlspecialchars($item['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                 class="w-full h-full object-cover rounded-lg">
                        </div>

                        <!-- Thông tin sản phẩm -->
                        <div class="flex-grow">
                            <h2 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($item['product_name']) ?></h2>
                            <p class="text-blue-600 font-bold mt-1"><?= number_format($item['price']) ?>₫</p>
                            <p class="text-gray-500 text-sm">Còn lại: <?= htmlspecialchars($item['stock_quantity']) ?> sản phẩm</p>
                            
                            <!-- Form cập nhật -->
                            <form action="?act=/cart/update" method="POST" class="flex items-center mt-2">
                                <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                <label for="quantity-<?= $item['cart_item_id'] ?>" class="sr-only">Số lượng</label>
                                <input type="number" name="quantity" 
                                       id="quantity-<?= $item['cart_item_id'] ?>" 
                                       value="<?= htmlspecialchars($item['quantity']) ?>" 
                                       min="1" 
                                       max="<?= htmlspecialchars($item['stock_quantity']) ?>" 
                                       class="w-20 border border-gray-300 rounded-md px-2 py-1 text-center">
                                <button type="submit" 
                                        class="ml-2 bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600 transition">
                                    Cập nhật
                                </button>
                            </form>
                        </div>

                        <!-- Thành tiền + nút xóa -->
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-800">
                                <?= number_format($item['quantity'] * $item['price']) ?>₫
                            </p>
                            <a href="?act=/cart/remove&id=<?= $item['cart_item_id'] ?>" 
                               class="text-red-500 hover:text-red-700 text-sm mt-2 block" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                Xóa
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Nút xóa toàn bộ -->
                <div class="mt-6 text-right">
                    <a href="?act=/cart/clear" 
                       class="text-red-500 hover:text-red-700 text-sm" 
                       onclick="return confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?')">
                        Xóa toàn bộ giỏ hàng
                    </a>
                </div>
            </div>

            <!-- Tóm tắt đơn hàng -->
            <div class="lg:col-span-1 bg-white rounded-lg shadow-md p-6 h-fit sticky top-32">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3">Tóm tắt đơn hàng</h2>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Tổng tiền sản phẩm:</span>
                    <span class="font-semibold text-gray-800"><?= number_format($totalAmount) ?>₫</span>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-600">Phí vận chuyển:</span>
                    <span class="font-semibold text-gray-800">Miễn phí</span>
                </div>
                <div class="flex justify-between items-center font-bold text-xl pt-3 border-t border-gray-200">
                    <span>Tổng cộng:</span>
                    <span class="text-blue-600"><?= number_format($totalAmount) ?>₫</span>
                </div>
                <a href="?act=/checkout" 
                   class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg mt-6 hover:bg-blue-700 transition">
                    Tiến hành thanh toán
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include './views/layouts/footer.php'; ?>
