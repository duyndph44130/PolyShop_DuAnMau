<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết danh mục</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .info { margin-bottom: 20px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Chi tiết danh mục</h1>

    <?php if (empty($category)): ?>
        <p>Danh mục không tồn tại.</p>
    <?php else: ?>
        <div class="info">
            <p><span class="label">ID:</span> <?= $category['category_id'] ?></p>
            <p><span class="label">Tên danh mục:</span> <?= $category['name'] ?></p>
            <p><span class="label">Mô tả:</span> <?= nl2br($category['description']) ?></p>
            <p><span class="label">Số lượng sản phẩm trong danh mục:</span> <?= $productCount ?></p>
        </div>

        <a href="?act=/categories">← Quay lại danh sách</a>
    <?php endif; ?>
</body>
</html>
