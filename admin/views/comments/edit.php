<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>
<div class="main-content">
    <h1>🛠 Sửa trạng thái bình luận</h1>

    <div class="comment-info">
        <p><strong>ID bình luận:</strong> <?= htmlspecialchars($comment['comment_id']) ?></p>
        <p><strong>ID người dùng:</strong> <?= htmlspecialchars($comment['user_id']) ?></p>
        <p><strong>ID sản phẩm:</strong> <?= htmlspecialchars($comment['product_id']) ?></p>
        <p><strong>Nội dung:</strong> <?= nl2br(htmlspecialchars($comment['content'])) ?></p>
        <p><strong>Thời gian:</strong> <?= htmlspecialchars($comment['created_at']) ?></p>
    </div>

    <form method="post">
        <label for="status">Trạng thái:</label><br>
        <select name="status" id="status">
            <option value="0" <?= $comment['status'] == 0 ? 'selected' : '' ?>>Ẩn</option>
            <option value="1" <?= $comment['status'] == 1 ? 'selected' : '' ?>>Đã duyệt</option>
        </select>
        <br><br>
        <button type="submit">Lưu thay đổi</button>
    </form>

    <br>
    <a class="btn" href="?act=/comments">⬅ Quay lại danh sách bình luận</a>
</div>


<?php include './views/layouts/footer.php'; ?>
