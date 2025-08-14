<?php include './views/layouts/header.php'; ?>

<div class="update-profile-container container">
    <div class="update-profile-card card shadow-sm"> <!-- Thêm card và shadow-sm để đồng bộ -->
        <div class="update-profile-header card-header bg-primary text-white"> <!-- Thêm card-header, bg-primary, text-white -->
            <h4 class="mb-0">Cập nhật thông tin tài khoản</h4>
        </div>
        <div class="update-profile-body card-body"> <!-- Thêm card-body -->
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="?act=/account/updateProfile" method="POST">
                <div class="form-group mb-3"> <!-- Thêm mb-3 -->
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="name" class="form-control form-input" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control form-input" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control form-input" value="<?= htmlspecialchars($user['phone']) ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" name="address" class="form-control form-input" value="<?= htmlspecialchars($user['address']) ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
                    <div class="password-wrapper">
                        <input type="password" id="newPassword" name="password" class="form-control form-input">
                        <button type="button" onclick="togglePassword()" class="password-toggle-btn">👁</button>
                    </div>
                </div>
                <div class="form-actions d-flex justify-content-between"> <!-- Thêm d-flex, justify-content-between -->
                    <a href="?act=/account/profile" class="btn-back btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn-save btn btn-primary">
                        <i class="bi bi-save"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>

<script>
function togglePassword() {
    const input = document.getElementById('newPassword');
    input.type = (input.type === 'password') ? 'text' : 'password';
}
</script>
