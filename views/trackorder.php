<?php include './views/layouts/header.php'; ?>

<div class="track-order-container container">
    <h1 class="track-order-title">🚚 Theo dõi đơn hàng của bạn</h1>

    <form id="trackOrderForm" class="track-order-form">
        <div class="form-group">
            <label for="orderCode" class="form-label">Nhập mã đơn hàng:</label>
            <input type="text" id="orderCode" name="order_code" placeholder="Ví dụ: #12345" required class="form-input">
        </div>
        <button type="submit" class="btn-primary track-submit-btn">Theo dõi</button>
    </form>

    <div id="orderResults" class="track-order-results">
        <!-- Kết quả theo dõi đơn hàng sẽ hiển thị ở đây -->
        <p class="empty-message">Nhập mã đơn hàng để xem chi tiết.</p>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>
