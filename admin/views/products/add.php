<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h1>Thêm sản phẩm</h1>

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
            <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </label><br><br>

        <label>Mô tả:
            <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </label><br><br>

        <label>Giá:
            <input type="number" name="price" value="<?= htmlspecialchars($_POST['price'] ?? 0) ?>">
        </label><br><br>

        <label>Size:
            <input type="text" name="size" value="<?= htmlspecialchars($_POST['size'] ?? '') ?>">
        </label><br><br>

        <label>Màu sắc:
            <input type="text" name="color" value="<?= htmlspecialchars($_POST['color'] ?? '') ?>">
        </label><br><br>

        <label>Số lượng tồn kho:
            <input type="number" name="stock_quantity" value="<?= htmlspecialchars($_POST['stock_quantity'] ?? 0) ?>">
        </label><br><br>

        <label>Danh mục:</label><br>
        <select name="category_id">
            <option value="">-- Chọn danh mục --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>"
                    <?= (isset($_POST['category_id']) && $_POST['category_id'] == $cat['category_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Hình ảnh:
            <input type="file" name="image">
        </label><br><br>

        <br>
        <button type="submit">Thêm</button>
        <a class="btn" href="?act=/products">Hủy</a>
    </form>

</div>
<?php include './views/layouts/footer.php'; ?>
