<?php include './views/layouts/header.php'; ?>

<div class="register-container container"> <!-- Đổi tên class và thêm container -->
    <div class="register-card card shadow-sm"> <!-- Đổi tên class và thêm card, shadow-sm -->
        <div class="register-header card-header bg-primary text-white"> <!-- Đổi tên class và thêm card-header, bg-primary, text-white -->
            <h4 class="mb-0">Đăng ký tài khoản mới</h4> <!-- Đổi tiêu đề -->
        </div>
        <div class="register-body card-body"> <!-- Đổi tên class và thêm card-body -->
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Form đăng ký -->
            <form action="?act=/register/process" method="POST"> <!-- Cập nhật action -->
                <div class="form-group mb-3">
                    <label class="form-label" for="reg_name">Họ và tên</label>
                    <input type="text" name="name" id="reg_name" class="form-control form-input" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                    <?php if (isset($errors['name'])): ?>
                        <p class="error-text"><?= htmlspecialchars($errors['name']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="reg_email">Email</label>
                    <input type="email" name="email" id="reg_email" class="form-control form-input" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <p class="error-text"><?= htmlspecialchars($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="reg_phone">Số điện thoại</label>
                    <input type="text" name="phone" id="reg_phone" class="form-control form-input" value="<?= htmlspecialchars($old['phone'] ?? '') ?>" required>
                    <?php if (isset($errors['phone'])): ?>
                        <p class="error-text"><?= htmlspecialchars($errors['phone']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="reg_address">Địa chỉ</label>
                    <input type="text" name="address" id="reg_address" class="form-control form-input" value="<?= htmlspecialchars($old['address'] ?? '') ?>" required>
                    <?php if (isset($errors['address'])): ?>
                        <p class="error-text"><?= htmlspecialchars($errors['address']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="reg_password">Mật khẩu</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="reg_password" class="form-control form-input" required>
                        <button type="button" onclick="togglePassword('reg_password')" class="password-toggle-btn">👁</button>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <p class="error-text"><?= htmlspecialchars($errors['password']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="reg_confirm_password">Xác nhận mật khẩu</label>
                    <div class="password-wrapper">
                        <input type="password" name="confirm_password" id="reg_confirm_password" class="form-control form-input" required>
                        <button type="button" onclick="togglePassword('reg_confirm_password')" class="password-toggle-btn">👁</button>
                    </div>
                    <?php if (isset($errors['confirm_password'])): ?>
                        <p class="error-text"><?= htmlspecialchars($errors['confirm_password']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-actions text-center"> <!-- Căn giữa nút -->
                    <button type="submit" class="btn-submit btn-primary">Đăng ký</button>
                </div>

                <p class="login-link-text text-center mt-3">
                    Bạn đã có tài khoản? <a href="?act=/login" class="login-now-link">Đăng nhập ngay</a>
                </p>
            </form>
        </div>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>

<script>
// Lấy dữ liệu lỗi và old từ session (nếu có)
<?php
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    input.type = (input.type === 'password') ? 'text' : 'password';
}
</script>
