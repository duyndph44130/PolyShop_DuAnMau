<?php include './views/layouts/header.php'; ?>

<style>
    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    h2 {
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
        border-bottom: 2px solid #ddd;
        padding-bottom: 10px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        transition: 0.3s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .product-card img {
        max-width: 100%;
        height: 200px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .product-card h3 {
        font-size: 18px;
        color: #333;
        margin: 10px 0;
        height: 48px;
        overflow: hidden;
    }

    .product-card p {
        color: #e91e63;
        font-weight: bold;
        margin: 5px 0 10px;
    }

    .product-card a {
        display: inline-block;
        margin-top: 5px;
        padding: 8px 16px;
        background: #007bff;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .product-card a:hover {
        background: #0056b3;
    }
</style>

<?php include './views/layouts/menu.php'; ?>

<div class="container">
    <h2>Sản phẩm mới nhất</h2>
    <div class="product-grid">
        <?php foreach ($newProducts as $product): ?>
            <div class="product-card">
                <img src="assets/images/<?= htmlspecialchars($product['image'] ?? 'no-image.png') ?>" 
                        alt="<?= htmlspecialchars($product['name'] ?? 'Sản phẩm') ?>">
                <h3><?= htmlspecialchars($product['name'] ?? 'Sản phẩm không tên') ?></h3>
                <p><?= isset($product['price']) ? number_format($product['price']) . '₫' : 'Giá liên hệ' ?></p>
                <a href="?act=/product/detail&id=<?= $product['product_id'] ?? 0 ?>">Xem chi tiết</a>
            </div>
        <?php endforeach; ?>
    </div>

    <h2>Sản phẩm nổi bật</h2>
    <div class="product-grid">
        <?php foreach ($featuredProducts as $product): ?>
            <div class="product-card">
                <img src="assets/images/<?= htmlspecialchars($product['image'] ?? 'no-image.png') ?>" 
                        alt="<?= htmlspecialchars($product['name'] ?? 'Sản phẩm') ?>">
                <h3><?= htmlspecialchars($product['name'] ?? 'Sản phẩm không tên') ?></h3>
                <p><?= isset($product['price']) ? number_format($product['price']) . '₫' : 'Giá liên hệ' ?></p>
                <a href="?act=/product/detail&id=<?= $product['product_id'] ?? 0 ?>">Xem chi tiết</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>
