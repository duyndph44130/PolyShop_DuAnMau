<?php include './views/layouts/header.php'; ?>

<div class="profile-container container">
    <div class="profile-row">
        <!-- Sidebar -->
        <div class="profile-sidebar">
            <div class="profile-card">
                <div class="profile-card-body">
                    <img src="admin//uploads/avataruser.webp ?? 'https://via.placeholder.com/150' ?>" 
                        class="profile-avatar" 
                        alt="Avatar người dùng">
                    <h5 class="profile-username"><?= htmlspecialchars($user['name']) ?></h5>
                </div>
                <div class="profile-card-footer">
                    <a href="?act=/account/editProfile" class="btn-edit btn-primary">
                        ✏ Sửa thông tin cá nhân
                    </a>
                    <a href="?act=/logout" class="btn-logout btn-secondary">
                        ⏏ Đăng xuất
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile info -->
        <div class="profile-main">
            <div class="profile-info-card">
                <div class="profile-info-header">
                    <h2 class="section-title">Thông tin tài khoản cá nhân</h2>
                </div>
                <div class="profile-info-body">
                    <div class="info-item">
                        <label>Họ và tên:</label>
                        <div class="info-value"><?= htmlspecialchars($user['name']) ?></div>
                    </div>
                    <div class="info-item">
                        <label>Email:</label>
                        <div class="info-value"><?= htmlspecialchars($user['email']) ?></div>
                    </div>
                    <div class="info-item">
                        <label>Số điện thoại:</label>
                        <div class="info-value"><?= htmlspecialchars($user['phone']) ?></div>
                    </div>
                    <div class="info-item">
                        <label>Địa chỉ:</label>
                        <div class="info-value"><?= htmlspecialchars($user['address']) ?></div>
                    </div>
                    <div class="info-item">
                        <label>Vai trò:</label>
                        <div class="info-value"><?= $user['role'] === 'admin' ? 'Quản trị viên' : 'Khách hàng' ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>
