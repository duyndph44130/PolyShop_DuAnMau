<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm người dùng mới</title>
</head>
<body>
    <h1>Thêm người dùng mới</h1>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post">
        <label>Tên: <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"></label><br>
        <label>Password: <input type="password" name="password" id="password"></label><br>
        <label><input type="checkbox" onclick="togglePassword()"> Hiện mật khẩu</label><br>
        <label>Số điện thoại: <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"></label><br>
        <label>Địa chỉ: <input type="text" name="address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>"></label><br>
        <label>Quyền:
            <select name="role">
                <option value="client" <?= (($_POST['role'] ?? '') === 'client') ? 'selected' : '' ?>>Client</option>
                <option value="admin" <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
            </select>
        </label><br>
        <button type="submit">Thêm</button>
    </form>
    <a href="?act=/users">Quay lại</a>
</body>
</html>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        passwordInput.type = (passwordInput.type === "password") ? "text" : "password";
    }
</script>