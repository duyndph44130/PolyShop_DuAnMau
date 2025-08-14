<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">

    <h1>Danh sách danh mục</h1>
    
    <form method="GET">
        <input type="hidden" name="act" value="/categories">
        <input type="text" name="keyword" placeholder="Tìm danh mục theo tên..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button class="btn" type="submit">Tìm kiếm</button>
    </form>
    <br>
    
    <?php if (!empty($keyword)): ?>
        <p>Đã tìm thấy <?= count($listCategories) ?> kết quả cho từ khóa: <strong><?= htmlspecialchars($keyword) ?></strong></p>
        <?php endif; ?>
        
        <a class="btn mb-2" href="?act=/category/add">Thêm danh mục</a>
        <table border="1">
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
                            <a href="?act=/category/detail&id=<?= $category['category_id'] ?>">Xem</a> |
                            <a href="?act=/category/edit&id=<?= $category['category_id'] ?>">Sửa</a> |
                            <a href="?act=/category/delete&id=<?= $category['category_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</a>
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
</div>

<?php include './views/layouts/footer.php'; ?>
