<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="/PolyShop_DuAnMau/admin/assets/css/admin.css">
</head>
<div class="main-content">
    <h1>Đăng ký tài khoản</h1>
    <form method="post" action="?act=/register">
        <label>Họ tên:</label><br>
        <input type="text" name="name" required><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br>

        <label>Mật khẩu:</label><br>
        <input type="password" name="password" id="password" required><br>
        <label>
            <input type="checkbox" onclick="togglePassword()"> Hiện mật khẩu
        </label><br>

        <label>Số điện thoại:</label><br>
        <input type="text" name="phone" required><br>

        <label>Địa chỉ:</label><br>
        <input type="text" name="address" required><br>

        <button class="btn" type="submit">Đăng ký</button>
    </form>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <script>
        function togglePassword() {
            const passInput = document.getElementById('password');
            passInput.type = (passInput.type === 'password') ? 'text' : 'password';
        }
    </script>
</body>
</html>

    <!-- Footer HTML -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (!empty($_SESSION['success'])): ?>
    <script>
    Swal.fire({
    title: "Thành công",
    text: "<?= addslashes($_SESSION['success']) ?>",
    icon: "success",
    showConfirmButton: false,
    timer: 2000
    });
    </script>
    <?php unset($_SESSION['success']); endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
    <script>
    Swal.fire({
    title: "Thất bại",
    text: "<?= addslashes($_SESSION['error']) ?>",
    icon: "error",
    showConfirmButton: true
    });
    </script>
    <?php unset($_SESSION['error']); endif; ?>
