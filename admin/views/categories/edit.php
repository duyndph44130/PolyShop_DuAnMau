<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa danh mục</title>
    <style>
        .error { color: red; }
        label { display: block; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Sửa danh mục</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <label for="name">Tên danh mục:</label>
        <input type="text" id="name" name="name" value="<?= $category['name'] ?? ''?>">

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description"><?= $category['description'] ?? '' ?></textarea>

        <br><br>
        <button type="submit">Cập nhật</button>
        <a href="index.php?act=/categories">Quay lại danh sách</a>
    </form>
</body>
</html>
