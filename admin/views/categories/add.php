<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm danh mục</title>
    <style>
        .error { color: red; }
        label { display: block; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Thêm danh mục</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form act="" method="post">
        <label for="name">Tên danh mục:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>

        <br><br>
        <button type="submit">Thêm</button>
        <a href="?act=/categories">Quay lại danh sách</a>
    </form>
</body>
</html>
