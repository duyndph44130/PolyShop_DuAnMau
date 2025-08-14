<?php
$isLoggedIn = isset($_SESSION['user']);
$cartItemCount = 0;

if ($isLoggedIn) {
    require_once './models/CartModel.php';
    $cartModel = new CartModel();
    $cart = $cartModel->getCart($_SESSION['user']['user_id']);

    if ($cart) {
        $items = $cartModel->getCartItems($cart['order_id']);
        foreach ($items as $item) {
            $cartItemCount += $item['quantity'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PolyShop - Website bán quần áo</title>

    <!-- Giữ nguyên thư viện -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css"> <!-- Đảm bảo dòng này có mặt và sau style.css -->
    <script defer src="../assets/js/main.js"></script>

</head>

<body>
<header class="main-header">
    <div class="header-container">
        <a href="?act=/" class="logo">
            <i class="fa-solid fa-store"></i> PolyShop
        </a>

        <form action="?act=/search" method="GET" class="search-form">
            <input type="hidden" name="act" value="/search">
            <input type="text" name="keyword" placeholder="Tìm sản phẩm..." class="search-input">
            <button type="submit" class="search-button">Tìm</button>
        </form>

        <div class="header-actions">
            <a href="?act=/cart" class="cart-link">
                <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
                <?php if ($cartItemCount > 0): ?>
                    <span class="cart-badge"><?= $cartItemCount ?></span>
                <?php endif; ?>
            </a>

            <div class="user-menu" id="userMenu">
                <?php if ($isLoggedIn): ?>
                    <button class="user-btn" onclick="toggleUserMenu()">
                        <i class="fa-solid fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user']['name']) ?>
                    </button>
                    <div class="user-dropdown">
                        <a href="?act=/account/profile">👤 Thông tin tài khoản</a>
                        <a href="?act=/account/orders">📦 Đơn mua</a>
                        <a href="?act=/logout" class="logout-link">🚪 Đăng xuất</a>
                    </div>
                <?php else: ?>
                    <a href="?act=/login" class="login-link">
                        <i class="fa-solid fa-user"></i> Đăng nhập
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <nav class="main-nav">
        <ul class="nav-list">
            <li><a href="?act=/" class="nav-item"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
            <li><a href="?act=/blog" class="nav-item"><i class="fa-regular fa-newspaper"></i> Tin tức</a></li>
            <li><a href="?act=/introduction" class="nav-item"><i class="fa-solid fa-bullhorn"></i> Giới thiệu</a></li>
            <li><a href="?act=/shop" class="nav-item"><i class="fa-solid fa-store"></i> Cửa hàng</a></li>
            <li><a href="?act=/contact" class="nav-item"><i class="fa-solid fa-phone"></i> Liên hệ</a></li>
        </ul>
    </nav>
</header>

<script>
function toggleUserMenu() {
    document.getElementById("userMenu").classList.toggle("open");
}
document.addEventListener("click", function(e) {
    const menu = document.getElementById("userMenu");
    if (!menu.contains(e.target)) {
        menu.classList.remove("open");
    }
});
</script>
