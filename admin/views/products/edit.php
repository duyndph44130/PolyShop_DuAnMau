<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h1>Sửa sản phẩm</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form act="" method="post" enctype="multipart/form-data">
        <label>Tên sản phẩm:
            <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $product['name']) ?>">
        </label><br><br>

        <label>Mô tả:
            <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? $product['description']) ?></textarea>
        </label><br><br>

        <label>Giá:
            <input type="number" name="price" value="<?= htmlspecialchars($_POST['price'] ?? $product['price']) ?>">
        </label><br><br>

        <label>Size:
            <input type="text" name="size" value="<?= htmlspecialchars($_POST['size'] ?? $product['size']) ?>">
        </label><br><br>

        <label>Màu sắc:
            <input type="text" name="color" value="<?= htmlspecialchars($_POST['color'] ?? $product['color']) ?>">
        </label><br><br>

        <label>Số lượng tồn kho:
            <input type="number" name="stock_quantity" value="<?= htmlspecialchars($_POST['stock_quantity'] ?? $product['stock_quantity']) ?>">
        </label><br><br>

        <label>Danh mục:
            <select name="category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"
                        <?= (($_POST['category_id'] ?? $product['category_id']) == $category['category_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>

        <label for="is_featured">Nổi bật:</label><br>
        <select name="is_featured" id="is_featured">
            <option value="0" <?= isset($product['is_featured']) && $product['is_featured'] == 0 ? 'selected' : '' ?>>Không</option>
            <option value="1" <?= isset($product['is_featured']) && $product['is_featured'] == 1 ? 'selected' : '' ?>>Có</option>
        </select>

        <label>Hình ảnh:
            <?php if (!empty($product['image_url'])): ?>
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="Ảnh sản phẩm hiện tại">
            <?php endif; ?>
            <input type="file" name="image">
        </label><br><br>

        <br><br>
        <button type="submit">Cập nhật</button>
        <a class="btn" href="?act=/products">Quay lại danh sách</a>
    </form>

</div>

<?php include './views/layouts/footer.php'; ?>
