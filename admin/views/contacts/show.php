<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="container mx-auto px-6 py-6 max-w-3xl bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-6">Chi tiết liên hệ</h1>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="space-y-4">
        <p><strong>ID:</strong> <?= htmlspecialchars($contact['contact_id']) ?></p>
        <p><strong>Họ tên:</strong> <?= htmlspecialchars($contact['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($contact['email']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($contact['phone']) ?></p>
        <p><strong>Tiêu đề:</strong> <?= htmlspecialchars($contact['subject']) ?></p>
        <p><strong>Nội dung:</strong></p>
        <div class="border p-3 rounded bg-gray-50"><?= nl2br(htmlspecialchars($contact['message'])) ?></div>
        <p><strong>Ngày gửi:</strong> <?= htmlspecialchars($contact['created_at']) ?></p>
        <p><strong>Trạng thái:</strong> <?= htmlspecialchars($contact['status'] ?: 'Chưa xử lý') ?></p>
    </div>

    <form action="?act=/contact/updateStatus" method="POST" class="mt-6 max-w-sm">
        <input type="hidden" name="contact_id" value="<?= $contact['contact_id'] ?>">
        <label for="status" class="block font-medium mb-1">Cập nhật trạng thái:</label>
        <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="Chưa xử lý" <?= ($contact['status'] ?? '') === 'Chưa xử lý' ? 'selected' : '' ?>>Chưa xử lý</option>
            <option value="Đang xử lý" <?= ($contact['status'] ?? '') === 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
            <option value="Đã xử lý" <?= ($contact['status'] ?? '') === 'Đã xử lý' ? 'selected' : '' ?>>Đã xử lý</option>
        </select>
        <button type="submit" class="btn">Cập nhật</button>
    </form>

    <a href="?act=/contacts" class="btn">← Quay lại danh sách</a>
</div>

<?php include './views/layouts/footer.php'; ?>
