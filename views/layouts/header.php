<?php
$isLoggedIn = isset($_SESSION['user']);
$cartItemCount = 0;
if ($isLoggedIn) {
    // Tạm thời require model ở đây, nhưng tốt hơn nên truyền từ controller chính
    require_once './models/CartModel.php';
    $cartModel = new CartModel();
    $cartItemCount = $cartModel->getTotalCartItems($_SESSION['user']['user_id']);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PolyShop - Website bán quần áo</title>

    <!-- ✅ Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ✅ Font Awesome 6 (icon đẹp) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- ✅ Alpine.js (dropdown, toggle, mobile menu...) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- ✅ SwiperJS (slider banner) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- ✅ Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- HEADER -->
        <header class="bg-white shadow sticky top-0 z-50">
        <div class="!mt-0 container mx-auto flex items-center justify-between px-3 py-3">
        <!-- Logo -->
        <a href="?act=/" class="text-3xl font-extrabold text-blue-600 flex items-center leading-relaxed pt-3">
            <i class="fa-solid fa-store text-blue-500 mr-2"></i> PolyShop
        </a>

        <!-- Search -->
        <form action="?act=/search" method="GET" class="flex items-center w-full max-w-sm">
            <input type="hidden" name="act" value="/search">
            <input
                type="text"
                name="keyword"
                placeholder="Tìm sản phẩm..."
                class="flex-grow border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400"
            >
            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-lg transition-colors duration-200"
            >
                Tìm kiếm
            </button>
        </form>

        <!-- Cart + User -->
        <div class="flex items-center gap-5 pt-3">
            <!-- Giỏ hàng -->
            <a href="?act=/cart" class="text-blue-600 hover:text-blue-800 text-base font-semibold flex items-center gap-2 transition relative">
                <i class="fa-solid fa-cart-shopping text-lg"></i>
                <span class="hidden sm:inline">Giỏ hàng</span>
                <?php if ($cartItemCount > 0): ?>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                        <?= $cartItemCount ?>
                    </span>
                <?php endif; ?>
            </a>

            <!-- Tài khoản -->
            <div class="relative" x-data="{ open: false }">
                <?php if ($isLoggedIn): ?>
                    <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                        <i class="fa-solid fa-user-circle text-2xl text-blue-600"></i>
                        <span class="hidden sm:inline font-semibold"><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
                    </button>
                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white shadow-md rounded z-50 text-sm">
                        <a href="?act=/tai-khoan" class="block px-4 py-2 hover:bg-gray-100">👤 Thông tin tài khoản</a>
                        <a href="?act=/don-mua" class="block px-4 py-2 hover:bg-gray-100">📦 Đơn mua</a>
                        <a href="?act=/lich-su" class="block px-4 py-2 hover:bg-gray-100">🕓 Lịch sử mua</a>
                        <a href="?act=/logout" class="block px-4 py-2 text-red-600 hover:bg-red-100">🚪 Đăng xuất</a>
                    </div>
                <?php else: ?>
                    <a href="?act=/login" class="text-blue-600 hover:text-blue-800 text-base font-semibold flex items-center gap-2">
                        <i class="fa-solid fa-user text-lg"></i>
                        <span class="hidden sm:inline">Đăng nhập</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

        <!-- MENU -->
        <nav class="bg-blue-600">
            <ul class="flex justify-center space-x-8 px-4 py-3 text-white text-base font-bold">
                <li><a href="?act=/" class="hover:text-yellow-300"><i class="fa-solid fa-house mr-2"></i>Trang chủ</a></li>
                <li><a href="?act=/blog" class="hover:text-yellow-300"><i class="fa-regular fa-newspaper mr-2"></i>Tin tức</a></li>
                <li><a href="?act=/introduction" class="hover:text-yellow-300"><i class="fa-solid fa-bullhorn mr-2"></i>Giới thiệu</a></li>
                <li><a href="?act=/shop" class="hover:text-yellow-300"><i class="fa-solid fa-store mr-2"></i>Cửa hàng</a></li>
                <li><a href="?act=/contact" class="hover:text-yellow-300"><i class="fa-solid fa-phone mr-2"></i>Liên hệ</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
