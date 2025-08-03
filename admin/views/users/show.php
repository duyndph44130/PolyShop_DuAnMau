<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h1>Chi tiết người dùng</h1>
    <ul>
        <li>ID: <?= $user['user_id'] ?></li>
        <li>Tên: <?= htmlspecialchars($user['name']) ?></li>
        <li>Email: <?= htmlspecialchars($user['email']) ?></li>
        <li>Địa chỉ: <?= htmlspecialchars($user['address']) ?></li>
        <li>Mật khẩu: <?= htmlspecialchars($user['password']) ?></li>
        <li>Quyền: <?= htmlspecialchars($user['role']) ?></li>
    </ul>
<a class="btn" href="?act=/users">Quay lại</a></body>
</div>

<?php include './views/layouts/footer.php'; ?>
