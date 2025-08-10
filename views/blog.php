<?php require_once './views/layouts/header.php'; ?>
<?php require_once './views/layouts/menu.php'; ?>

<div class="bg-gray-50 py-10">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Tin tức & Blog</h1>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Bài viết 1 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="uploads/blog1.jpg" alt="Tin tức 1" class="w-full h-56 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Xu hướng thời trang 2025</h2>
                    <p class="text-gray-600 mb-4">Cập nhật những xu hướng mới nhất về màu sắc, kiểu dáng và chất liệu sẽ dẫn đầu trong năm 2025...</p>
                    <a href="#" class="text-pink-500 hover:underline">Đọc tiếp →</a>
                </div>
            </div>

            <!-- Bài viết 2 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="uploads/blog2.jpg" alt="Tin tức 2" class="w-full h-56 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Cách phối đồ cho mùa hè</h2>
                    <p class="text-gray-600 mb-4">Gợi ý những cách phối đồ đơn giản, mát mẻ và thời trang dành cho mùa hè nóng bức...</p>
                    <a href="#" class="text-pink-500 hover:underline">Đọc tiếp →</a>
                </div>
            </div>

            <!-- Bài viết 3 -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="uploads/blog3.jpg" alt="Tin tức 3" class="w-full h-56 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Bí quyết giữ quần áo bền đẹp</h2>
                    <p class="text-gray-600 mb-4">Chia sẻ mẹo bảo quản và giặt giũ để quần áo của bạn luôn mới và bền màu...</p>
                    <a href="#" class="text-pink-500 hover:underline">Đọc tiếp →</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './views/layouts/footer.php'; ?>
