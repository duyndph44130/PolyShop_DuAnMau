<!-- BANNER + DANH MỤC -->
<!-- Style block removed as it's now in main.css -->

<section class="container menu-section"> <!-- Thêm menu-section để phân biệt -->
    <!-- DANH MỤC -->
    <div class="category-box">
        <h3>📂 Danh mục</h3>
        <ul class="category-list">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <li>
                        <a href="?act=/category&id=<?= $cat['category_id'] ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="no-category-message">Không có danh mục</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- BANNER + DỊCH VỤ -->
    <div class="banner-wrapper">
        <!-- BANNER -->
        <div class="banner-slider">
            <img src="admin/uploads/banner1.webp" class="banner-slide active" alt="Banner 1">
            <img src="admin/uploads/banner2.webp" class="banner-slide" alt="Banner 2">
            <img src="admin/uploads/banner3.webp" class="banner-slide" alt="Banner 3">

            <button id="prevSlide" class="banner-btn prev">‹</button>
            <button id="nextSlide" class="banner-btn next">›</button>
        </div>

        <!-- DỊCH VỤ -->
        <div class="services-grid"> <!-- Đổi tên class để tránh xung đột -->
            <div class="service-item">🚚<p>Miễn phí vận chuyển</p></div>
            <div class="service-item">🔁<p>Đổi trả trong 7 ngày</p></div>
            <div class="service-item">📞<p>Hỗ trợ 24/7</p></div>
            <div class="service-item">💳<p>Thanh toán linh hoạt</p></div>
        </div>
    </div>
</section>

<script>
    const slides = document.querySelectorAll('.banner-slide');
    let index = 0;

    function showSlide(i) {
        slides.forEach((slide, idx) => {
            slide.classList.toggle('active', idx === i);
        });
    }

    // Initial display
    showSlide(index);

    document.getElementById('prevSlide').onclick = () => {
        index = (index - 1 + slides.length) % slides.length;
        showSlide(index);
    };

    document.getElementById('nextSlide').onclick = () => {
        index = (index + 1) % slides.length;
        showSlide(index);
    };

    setInterval(() => {
        index = (index + 1) % slides.length;
        showSlide(index);
    }, 5000);
</script>
