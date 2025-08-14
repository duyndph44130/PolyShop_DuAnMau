<?php $isLoggedIn = isset($_SESSION['user']); ?>

<!-- views/layouts/header.php -->
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>PolyShop Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap & Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Custom Admin CSS -->
        <link rel="stylesheet" href="<?= BASE_URL ?>admin/assets/css/admin.css">
        <!-- Thêm class 'auth-page' cho body nếu là trang đăng nhập/đăng ký -->
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
        <?php
            $current_act = $_GET['act'] ?? '';
            if ($current_act === '/login' || $current_act === '/register') {
                echo '<style>body { background: none; }</style>'; // Remove default body background if auth-page
                echo '<body class="auth-page">';
            } else {
                echo '<body>';
            }
        ?>
    </head>
    <body>
    