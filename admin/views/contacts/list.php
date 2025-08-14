<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">

    <h1>Quản lý liên hệ</h1>
    
    <form method="GET" class="mb-4">
        <input type="hidden" name="act" value="/contacts">
        <input type="text" name="keyword" placeholder="Tìm liên hệ theo họ tên hoặc email..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button class="btn" type="submit">Tìm kiếm</button>
    </form>

    <?php if (!empty($keyword)): ?>
        <p>Đã tìm thấy <?= count($contacts) ?> kết quả cho từ khóa: <strong><?= htmlspecialchars($keyword) ?></strong></p>
    <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Tiêu đề</th>
                <th>Ngày gửi</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($contacts)): ?>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?= htmlspecialchars($contact['contact_id']) ?></td>
                        <td><?= htmlspecialchars($contact['name']) ?></td>
                        <td><?= htmlspecialchars($contact['email']) ?></td>
                        <td><?= htmlspecialchars($contact['subject']) ?></td>
                        <td><?= htmlspecialchars($contact['created_at']) ?></td>
                        <td><?= htmlspecialchars($contact['status'] ?: 'Chưa xử lý') ?></td>
                        <td>
                            <a href="?act=/contact/detail&id=<?= $contact['contact_id'] ?>">Xem</a> |
                            <a href="?act=/contact/delete&id=<?= $contact['contact_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Không có liên hệ nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<?php include './views/layouts/footer.php'; ?>
