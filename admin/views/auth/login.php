<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="/PolyShop_DuAnMau/admin/assets/css/admin.css">
</head>
<div class="main-content" style="width: 800px; align-self: center;">
    <h1 class="text-center">Đăng nhập</h1>
    <form method="post" action="?act=/login">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br>
            <label><input type="checkbox" onclick="togglePassword()"> Hiện mật khẩu</label><br>
        </div>
        <button class="btn" type="submit">Đăng nhập</button>
    </form>
    <?php if (!empty($errors)): ?>
        <div>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</body>
</html>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        passwordInput.type = (passwordInput.type === "password") ? "text" : "password";
    }
</script>

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
