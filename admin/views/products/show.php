<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm</title>
    <style>
        .label { font-weight: bold; }
        img { max-width: 200px; height: auto; display: block; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Chi tiết sản phẩm</h1>

    <?php if (empty($product)): ?>
        <p>Sản phẩm không tồn tại.</p>
    <?php else: ?>
        <p><span class="label">ID:</span> <?= htmlspecialchars($product['product_id']) ?></p>
        <p><span class="label">Tên:</span> <?= htmlspecialchars($product['name']) ?></p>
        <p><span class="label">Mô tả:</span> <?= nl2br(htmlspecialchars($product['description'])) ?></p>
        <p><span class="label">Giá:</span> <?= number_format($product['price'], 0, ',', '.') ?> đ</p>
        <p><span class="label">Size:</span> <?= htmlspecialchars($product['size']) ?></p>
        <p><span class="label">Màu sắc:</span> <?= htmlspecialchars($product['color']) ?></p>
        <p><span class="label">Tồn kho:</span> <?= $product['stock_quantity'] ?></p>
        <p><span class="label">Danh mục:</span> <?= $product['category_id'] ?></p>
        <?php if (!empty($product['image_url'])): ?>
            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="Ảnh sản phẩm">
        <?php endif; ?>
    <?php endif; ?>

    <br>
    <a href="index.php?act=/products">← Quay lại danh sách</a>
</body>
</html>
