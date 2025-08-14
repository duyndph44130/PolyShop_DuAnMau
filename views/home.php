<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/menu.php'; ?>

<div class="container main-content"> <!-- Thêm main-content để phân biệt với container của menu -->
    <!-- Sản phẩm mới -->
    <h2 class="product-title">✨ Sản phẩm mới nhất</h2>
    <div class="product-grid">
        <?php foreach ($newProducts as $product): ?>
            <div class="product-card">
                <img src="admin/<?= htmlspecialchars($product['image_url'] ?? 'no-image.png') ?>" 
                        alt="<?= htmlspecialchars($product['name'] ?? 'Sản phẩm') ?>"
                        class="product-image">
                <h3 class="product-name"><?= htmlspecialchars($product['name'] ?? 'Sản phẩm không tên') ?></h3>
                <p class="product-price"><?= isset($product['price']) ? number_format($product['price']) . '₫' : 'Giá liên hệ' ?></p>
                <a href="?act=/product/detail&id=<?= $product['product_id'] ?? 0 ?>" class="btn-view btn-primary">Xem ngay</a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Sản phẩm nổi bật -->
    <h2 class="product-title">🔥 Sản phẩm nổi bật</h2>
    <div class="product-grid">
        <?php foreach ($featuredProducts as $product): ?>
            <div class="product-card">
                <img src="admin/<?= htmlspecialchars($product['image_url'] ?? 'no-image.png') ?>" 
                        alt="<?= htmlspecialchars($product['name'] ?? 'Sản phẩm') ?>"
                        class="product-image">
                <h3 class="product-name"><?= htmlspecialchars($product['name'] ?? 'Sản phẩm không tên') ?></h3>
                <p class="product-price"><?= isset($product['price']) ? number_format($product['price']) . '₫' : 'Giá liên hệ' ?></p>
                <a href="?act=/product/detail&id=<?= $product['product_id'] ?? 0 ?>" class="btn-view btn-primary">Xem ngay</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".product-card");

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = 1;
                entry.target.style.transform = "translateY(0)";
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    cards.forEach(card => {
        card.style.opacity = 0; /* Start hidden for animation */
        card.style.transform = "translateY(20px)"; /* Start slightly below */
        observer.observe(card);
    });
});
</script>
