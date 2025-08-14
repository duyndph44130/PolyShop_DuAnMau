<?php include './views/layouts/header.php'; ?>

<div class="product-detail-container container">

    <!-- Nút quay lại -->
    <button onclick="history.back()" class="back-button">
        ⬅ Quay lại
    </button>

    <!-- Chi tiết sản phẩm -->
    <div class="product-detail-grid">
        
        <!-- Hình ảnh -->
        <div class="product-image-box">
            <img src="admin/<?= htmlspecialchars($product['image_url'] ?? 'no-image.png') ?>"
                alt="<?= htmlspecialchars($product['name'] ?? 'Sản phẩm') ?>"
                class="product-image-main"> <!-- Đổi tên class để tránh xung đột -->
        </div>

        <!-- Thông tin -->
        <div class="product-info-box">
            <h1 class="product-name"><?= htmlspecialchars($product['name'] ?? '') ?></h1>
            <p class="product-price">
                <?= isset($product['price']) ? number_format($product['price']) . '₫' : 'Liên hệ' ?>
            </p>
            <p class="product-category">
                Danh mục: <strong><?= htmlspecialchars($category['name'] ?? 'Không rõ') ?></strong>
            </p>

            <!-- Form thêm giỏ hàng -->
            <form action="?act=/cart/add" method="POST" id="addToCartForm" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                <label for="quantityInput" class="quantity-label">Số lượng:</label>
                <div class="quantity-control">
                    <button type="button" onclick="decreaseQty()" class="quantity-btn quantity-minus-btn">−</button>
                    <input id="quantityInput" type="number" name="quantity" min="1" value="1" class="quantity-input">
                    <button type="button" onclick="increaseQty()" class="quantity-btn quantity-plus-btn">+</button>
                </div>

                <button id="addToCartBtn" class="add-to-cart-btn btn-primary">
                    Thêm vào giỏ hàng
                </button>
            </form>
        </div>
    </div>

    <!-- Mô tả sản phẩm -->
    <div class="product-description-section">
        <h2 class="section-title">Mô tả sản phẩm</h2>
        <div class="product-description-content">
            <?= isset($product['description']) ? nl2br(htmlspecialchars($product['description'])) : 'Không có mô tả.' ?>
        </div>
    </div>

    <!-- Khuyến mãi -->
    <?php if (!empty($voucher)): ?>
        <div class="product-voucher-section">
            <h3 class="section-title">🎁 Khuyến mãi</h3>
            <p class="voucher-details">
                Giảm <?= htmlspecialchars($voucher['discount_value']) ?>%
                <?php if (!empty($voucher['max_discount'])): ?>
                    , tối đa <?= number_format($voucher['max_discount']) ?>₫
                <?php endif; ?>
                (áp dụng từ <?= htmlspecialchars($voucher['start_date']) ?> đến <?= htmlspecialchars($voucher['end_date']) ?>)
            </p>
        </div>
    <?php endif; ?>

    <!-- Bình luận -->
    <div class="product-comments-section">
        <h3 class="section-title">Bình luận sản phẩm</h3>

        <?php if (!empty($comments)): ?>
            <div class="comment-list">
                <?php foreach ($comments as $cmt): ?>
                    <div class="comment-item">
                        <p class="comment-meta">
                            Người dùng: <strong class="comment-user"><?= htmlspecialchars($cmt['user_name']) ?></strong> – 
                            <span class="comment-date"><?= htmlspecialchars($cmt['created_at']) ?></span>
                        </p>
                        <p class="comment-content"><?= htmlspecialchars($cmt['content']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-comments empty-message">Chưa có bình luận nào cho sản phẩm này.</p>
        <?php endif; ?>

        <!-- Form gửi bình luận -->
        <?php if (isset($_SESSION['user'])): ?>
            <form action="?act=/comment/add" method="POST" class="comment-form">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                <label for="content" class="form-label">Nội dung bình luận:</label>
                <textarea name="content" id="content" rows="4" required class="form-input"></textarea>

                <button type="submit" class="comment-submit-btn btn-primary">Gửi bình luận</button>
            </form>
        <?php else: ?>
            <p class="login-to-comment d-flex">
                Vui lòng <a href="?act=/login" class="login-link"> đăng nhập </a> để bình luận.
            </p>
        <?php endif; ?>
    </div>

</div>

<?php include './views/layouts/footer.php'; ?>

<!-- Script tăng giảm số lượng -->
<script>
    function decreaseQty() {
        const input = document.getElementById('quantityInput');
        let value = parseInt(input.value);
        if (value > 1) input.value = value - 1;
    }

    function increaseQty() {
        const input = document.getElementById('quantityInput');
        input.value = parseInt(input.value) + 1;
    }

    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('?act=/cart/add', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }, // thêm dòng này
            body: new URLSearchParams(formData)
        })
        
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    title: "Thành công!",
                    text: "Sản phẩm đã được thêm vào giỏ hàng.",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                });
                // Cập nhật số lượng giỏ hàng trên header nếu cần
                // Ví dụ: location.reload(); hoặc cập nhật badge bằng JS
            } else {
                Swal.fire({
                    title: "Lỗi!",
                    text: data.message || "Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.",
                    icon: "error",
                    showConfirmButton: true
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                title: "Lỗi!",
                text: "Không thể kết nối đến máy chủ.",
                icon: "error",
                showConfirmButton: true
            });
        });
    });
</script>
