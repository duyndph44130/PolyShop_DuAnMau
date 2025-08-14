<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h1>Danh sách người dùng</h1>
    <form method="GET" action="">
        <input type="hidden" name="act" value="/users">
        <input type="text" name="keyword" placeholder="Tìm theo tên hoặc email..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button class="btn" type="submit">Tìm kiếm</button>
    </form>
    <br>

    <?php if (!empty($keyword)): ?>
        <p>Đã tìm thấy <?= count($listUsers) ?> kết quả cho từ khóa: <strong><?= htmlspecialchars($keyword) ?></strong></p>
    <?php endif; ?>

    <a class="btn" href="?act=/user/add">Thêm người dùng</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Quyền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listUsers)): ?>
                <?php foreach ($listUsers as $user): ?>
                    <tr>
                        <td><?= $user['user_id'] ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['address']) ?></td>
                        <td><?= htmlspecialchars($user['phone']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <a href="?act=/user/detail&id=<?= $user['user_id'] ?>">Xem</a>
                            <a href="?act=/user/edit&id=<?= $user['user_id'] ?>">Sửa</a>
                            <a href="?act=/user/delete&id=<?= $user['user_id'] ?> " onclick="return confirm('Bạn có chắc chắn muốn xoá người dùng này chứ?')">Xoá</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Không có người dùng nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</div>

<?php include './views/layouts/footer.php'; ?>
