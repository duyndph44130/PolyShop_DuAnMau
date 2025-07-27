<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>
    <style>
        label { display: block; margin-top: 10px; }
        .error { color: red; }
    </style>
</head>
<body>
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

    <form action="" method="post" enctype="multipart/form-data">
        <label>Tên sản phẩm:
            <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </label>

        <label>Mô tả:
            <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </label>

        <label>Giá:
            <input type="number" name="price" value="<?= htmlspecialchars($_POST['price'] ?? 0) ?>">
        </label>

        <label>Size:
            <input type="text" name="size" value="<?= htmlspecialchars($_POST['size'] ?? '') ?>">
        </label>

        <label>Màu sắc:
            <input type="text" name="color" value="<?= htmlspecialchars($_POST['color'] ?? '') ?>">
        </label>

        <label>Số lượng tồn kho:
            <input type="number" name="stock_quantity" value="<?= htmlspecialchars($_POST['stock_quantity'] ?? 0) ?>">
        </label>

        <label>Danh mục:</label>
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
        </label>

        <br>
        <button type="submit">Thêm</button>
        <a href="index.php?act=/products">Hủy</a>
    </form>
</body>
</html>
