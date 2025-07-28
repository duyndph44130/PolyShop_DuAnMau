<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách bình luận</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        a.delete-btn {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>📋 Danh sách bình luận</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID người dùng</th>
                <th>ID sản phẩm</th>
                <th>Nội dung</th>
                <th>Trạng thái</th>
                <th>Ngày bình luận</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td><?= htmlspecialchars($comment['comment_id']) ?></td>
                        <td><?= htmlspecialchars($comment['user_id']) ?></td>
                        <td><?= htmlspecialchars($comment['product_id']) ?></td>
                        <td><?= nl2br(htmlspecialchars($comment['content'])) ?></td>
                        <td><?= $comment['status'] == 0 ? 'Ẩn' : 'Đã duyệt' ?></td>
                        <td><?= htmlspecialchars($comment['created_at']) ?></td>
                        <td>
                            <a href="?act=/comment/edit&id=<?= $comment['comment_id'] ?>">Sửa trạng thái</a> |
                            <a href="?act=/comment/delete&id=<?= $comment['comment_id'] ?>" class="delete-btn" onclick="return confirm('Xoá bình luận này?')">Xoá</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Không có bình luận nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
