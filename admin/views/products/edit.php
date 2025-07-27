<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <style>
        label { display: block; margin-top: 10px; }
        .error { color: red; }
        img { max-width: 150px; margin-top: 5px; display: block; }
    </style>
</head>
<body>
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

    <form action="" method="post" enctype="multipart/form-data">
        <label>Tên sản phẩm:
            <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $product['name']) ?>">
        </label>

        <label>Mô tả:
            <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? $product['description']) ?></textarea>
        </label>

        <label>Giá:
            <input type="number" name="price" value="<?= htmlspecialchars($_POST['price'] ?? $product['price']) ?>">
        </label>

        <label>Size:
            <input type="text" name="size" value="<?= htmlspecialchars($_POST['size'] ?? $product['size']) ?>">
        </label>

        <label>Màu sắc:
            <input type="text" name="color" value="<?= htmlspecialchars($_POST['color'] ?? $product['color']) ?>">
        </label>

        <label>Số lượng tồn kho:
            <input type="number" name="stock_quantity" value="<?= htmlspecialchars($_POST['stock_quantity'] ?? $product['stock_quantity']) ?>">
        </label>

        <label>Danh mục:
            <select name="category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"
                        <?= (($_POST['category_id'] ?? $product['category_id']) == $category['category_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Hình ảnh:
            <?php if (!empty($product['image_url'])): ?>
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="Ảnh sản phẩm hiện tại">
            <?php endif; ?>
            <input type="file" name="image">
        </label>

        <br><br>
        <button type="submit">Cập nhật</button>
        <a href="index.php?act=/products">Quay lại danh sách</a>
    </form>
</body>
</html>
