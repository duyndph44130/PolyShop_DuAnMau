<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h1>Sửa thông tin người dùng</h1>
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
        <label>Tên: <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $user['name']) ?>"></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? $user['email']) ?>"></label><br>
        <label>Password: <input type="password" name="password" id="password"></label><br>
        <label> <input type="checkbox" onclick="togglePassword()"> Hiện mật khẩu</label><br>
        <label>Số điện thoại: <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"></label><br>
        <label>Địa chỉ: <input type="text" name="address" value="<?= htmlspecialchars($_POST['address'] ?? $user['address']) ?>"></label><br>
        <label>Quyền:
            <select name="role">
                <option value="client" <?= (($_POST['role'] ?? $user['role']) === 'client') ? 'selected' : '' ?>>Client</option>
                <option value="admin" <?= (($_POST['role'] ?? $user['role']) === 'admin') ? 'selected' : '' ?>>Admin</option>
            </select>
        </label><br>
        <button class="btn" type="submit">Cập nhật</button>
    </form>
    <a href="?act=/users">Quay lại</a>

    <?php
    // views/users/delete.php
    ?>
    <h1>Xác nhận xoá người dùng</h1>
    <p>Bạn có chắc chắn muốn xoá người dùng <strong><?= htmlspecialchars($user['name']) ?></strong>?</p>
    <form method="post">
        <button class="btn" type="submit">Xác nhận xoá</button>
        <a class="btn" href="?act=/users">Huỷ</a>
    </form>
</div>
    
<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        passwordInput.type = (passwordInput.type === "password") ? "text" : "password";
    }
</script>        

<?php include './views/layouts/footer.php'; ?>
