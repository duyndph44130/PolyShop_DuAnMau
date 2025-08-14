<?php include './views/layouts/header.php'; ?>

<div class="login-container container">
    <h2 class="login-title">Đăng nhập tài khoản</h2>

    <?php if (!empty($error)): ?>
        <div class="error-message alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="login-form">
        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                class="form-input <?= !empty($errors['email']) ? 'input-error' : '' ?>"
            >
            <?php if (!empty($errors['email'])): ?>
                <p class="error-text"><?= htmlspecialchars($errors['email']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Mật khẩu -->
        <div class="form-group">
            <label for="password" class="form-label">Mật khẩu</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-input <?= !empty($errors['password']) ? 'input-error' : '' ?>"
            >
            <?php if (!empty($errors['password'])): ?>
                <p class="error-text"><?= htmlspecialchars($errors['password']) ?></p>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-submit btn-primary">Đăng nhập</button>

        <!-- Link đăng ký -->
        <p class="register-link">
            Bạn chưa có tài khoản?
            <a href="?act=/register" class="register-now-link">Đăng ký ngay</a>
        </p>
    </form>
</div>

<?php include './views/layouts/footer.php'; ?>
