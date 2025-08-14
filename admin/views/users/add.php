<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<style>
    .error-text {
        color: red;
        font-size: 14px;
        margin: 4px 0 0 0;
    }
</style>

<div class="main-content">
    <h1>Thêm người dùng mới</h1>

    <form method="post">
        <label>
            Tên:
            <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            <?php if (!empty($errors['name'])): ?>
                <div class="error-text"><?= htmlspecialchars($errors['name']) ?></div>
            <?php endif; ?>
        </label><br>

        <label>
            Email:
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <?php if (!empty($errors['email'])): ?>
                <div class="error-text"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>
        </label><br>

        <label>
            Password:
            <input type="password" name="password" id="password">
            <?php if (!empty($errors['password'])): ?>
                <div class="error-text"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>
        </label><br>

        <label><input type="checkbox" onclick="togglePassword()"> Hiện mật khẩu</label><br>

        <label>
            Số điện thoại:
            <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
            <?php if (!empty($errors['phone'])): ?>
                <div class="error-text"><?= htmlspecialchars($errors['phone']) ?></div>
            <?php endif; ?>
        </label><br>

        <label>
            Địa chỉ:
            <input type="text" name="address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
            <?php if (!empty($errors['address'])): ?>
                <div class="error-text"><?= htmlspecialchars($errors['address']) ?></div>
            <?php endif; ?>
        </label><br>

        <label>
            Quyền:
            <select name="role">
                <option value="client" <?= (($_POST['role'] ?? '') === 'client') ? 'selected' : '' ?>>Client</option>
                <option value="admin" <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
            </select>
        </label><br>

        <button class="btn" type="submit">Thêm</button>
    </form>

    <a class="btn" href="?act=/users">Quay lại</a>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        passwordInput.type = (passwordInput.type === "password") ? "text" : "password";
    }
</script>

<?php include './views/layouts/footer.php'; ?>
