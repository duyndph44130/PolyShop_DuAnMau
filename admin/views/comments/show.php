<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h1>Chi tiết bình luận</h1>
    <p><strong>ID:</strong> <?= htmlspecialchars($comment['comment_id']) ?></p>
    <p><strong>Người dùng:</strong> <?= htmlspecialchars($comment['user_id']) ?></p>
    <p><strong>Sản phẩm:</strong> <?= htmlspecialchars($comment['product_id']) ?></p>
    <p><strong>Nội dung:</strong> <?= nl2br(htmlspecialchars($comment['content'])) ?></p>
    <p><strong>Trạng thái:</strong> <?= $comment['status'] == 0 ? 'Ẩn' : 'Đã duyệt' ?></p>
    <p><strong>Thời gian:</strong> <?= htmlspecialchars($comment['created_at']) ?></p>

    <a class="btn" href="?act=/comments">⬅ Quay lại danh sách</a>
</body>
</html>

<?php include './views/layouts/footer.php'; ?>
