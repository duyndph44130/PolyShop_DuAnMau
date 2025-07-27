<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách danh mục</title>
</head>
<body>
    <h1>Danh sách danh mục</h1>
    <a href="index.php?act=/category/add">Thêm danh mục</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listCategories)): ?>
                <?php foreach ($listCategories as $category): ?>
                    <tr>
                        <td><?= $category['category_id'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <td><?= $category['description'] ?></td>
                        <td>
                            <a href="index.php?act=/category/show&id=<?= $category['category_id'] ?>">Xem</a> |
                            <a href="index.php?act=/category/edit&id=<?= $category['category_id'] ?>">Sửa</a> |
                            <a href="index.php?act=/category/delete&id=<?= $category['category_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Không có danh mục nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>

    </table>
</body>
</html>