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
        <link rel="stylesheet" href="/PolyShop_DuAnMau/admin/assets/css/admin.css">
        <!-- Thêm class 'auth-page' cho body nếu là trang đăng nhập/đăng ký -->
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
    