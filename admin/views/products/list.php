<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h1>Danh sách sản phẩm</h1>

    <form method="GET">
        <input type="hidden" name="act" value="/products">
        <input type="text" name="keyword" placeholder="Tìm theo tên hoặc mô tả..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button class="btn" type="submit">Tìm kiếm</button>
    </form>
    <br>

    <?php if (!empty($keyword)): ?>
        <p>🔍 Tìm thấy <?= count($listProducts) ?> kết quả cho từ khóa "<strong><?= htmlspecialchars($keyword) ?></strong>"</p>
    <?php endif; ?>

    <a class="btn mb-2" href="?act=/product/add">Thêm sản phẩm</a>

    <table border="1" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Nổi bật</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listProducts)): ?>
                <?php foreach ($listProducts as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['product_id']) ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= number_format($product['price'], 0, ',', '.') ?> đ</td>
                        <td><?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại') ?></td>
                        <td><?= $product['is_featured'] ? '✅' : '❌' ?></td>
                        <td>
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="Ảnh" width="100px">
                            <?php else: ?>
                                Không có ảnh
                            <?php endif; ?>
                        </td>
                        <td class="acts">
                            <a href="?act=/product/detail&id=<?= $product['product_id'] ?>">Chi tiết</a>|
                            <a href="?act=/product/edit&id=<?= $product['product_id'] ?>">Sửa</a>|
                            <a href="?act=/product/delete&id=<?= $product['product_id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Không có sản phẩm nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include './views/layouts/footer.php'; ?>
