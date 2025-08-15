<?php include './views/layouts/header.php'; ?>

<div class="cart-container container">
    <h1 class="cart-page-title">🛒 Giỏ hàng của bạn</h1>

    <!-- Hiển thị thông báo -->
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="cart-empty">
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="?act=/shop" class="btn-continue btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="cart-grid">
            <!-- Danh sách sản phẩm -->
            <div class="cart-items-list">
                <?php foreach ($items as $item): ?>
                <div class="cart-item">
                    <div class="cart-item-image">
                        <img src="./admin/uploads<?= htmlspecialchars($item['image_url']) ?>"
                             alt="<?= htmlspecialchars($item['product_name']) ?>">
                    </div>

                    <div class="cart-item-info">
                        <h2 class="cart-item-name"><?= htmlspecialchars($item['product_name']) ?></h2>
                        <p class="cart-item-price"><?= number_format($item['price']) ?>₫</p>
                        <p class="cart-item-stock">Còn lại: <?= htmlspecialchars($item['stock_quantity']) ?> sản phẩm</p>

                        <div class="cart-item-qty-control">
                            <button type="button" class="qty-btn" data-id="<?= $item['orderdetail_id'] ?>" data-type="minus">−</button>
                            <input type="number" min="1" value="<?= $item['quantity'] ?>" class="qty-input" data-id="<?= $item['orderdetail_id'] ?>">
                            <button type="button" class="qty-btn" data-id="<?= $item['orderdetail_id'] ?>" data-type="plus">+</button>
                        </div>
                    </div>

                    <div class="cart-item-actions">
                        <p class="item-total"><?= number_format($item['quantity'] * $item['price']) ?>₫</p>
                        <button type="button" class="remove-btn">🗑 Xóa</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Tóm tắt đơn hàng -->
            <div class="cart-summary">
                <h2 class="cart-summary-title">Tóm tắt đơn hàng</h2>
                <div class="summary-row">
                    <span>Tổng tiền sản phẩm:</span>
                    <span id="subtotal"><?= number_format($total + ($discount ?? 0)) ?>₫</span>
                </div>

                <?php if (!empty($_SESSION['voucher'])): ?>
                    <div class="summary-row">
                        <span>Giảm giá (<?= htmlspecialchars($_SESSION['voucher']['code'] ?? '') ?>):</span>
                        <span>-<?= number_format($_SESSION['voucher']['discount'] ?? 0) ?>₫</span>
                    </div>
                <?php endif; ?>

                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>

                <div class="summary-total">
                    <span>Tổng cộng:</span>
                    <span id="total"><?= number_format($total) ?>₫</span>
                </div>

                <!-- Form nhập voucher -->
                <form method="post" action="?act=/cart/applyVoucher" class="voucher-form my-3">
                    <div class="input-group">
                        <input type="text" name="voucher_code" class="form-control" placeholder="Nhập mã giảm giá" required>
                        <button type="submit" class="btn btn-success">Áp dụng</button>
                    </div>
                </form>

                <a href="?act=/checkout" class="btn-checkout btn-primary">Tiến hành thanh toán</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include './views/layouts/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id   = this.dataset.id;
            const type = this.dataset.type;
            const input = document.querySelector(`.qty-input[data-id="${id}"]`);
            let qty = parseInt(input.value || '1', 10);
            if (type === 'plus') qty++;
            if (type === 'minus' && qty > 1) qty--;
            updateQuantity(id, qty);
        });
    });

    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function() {
            let qty = parseInt(this.value || '1', 10);
            if (qty < 1) qty = 1;
            updateQuantity(this.dataset.id, qty);
        });
    });

    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const orderDetailId = cartItem.querySelector('.qty-input').dataset.id;

            if (!confirm('Xóa sản phẩm này?')) return;
            fetch('?act=/cart/remove', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `orderdetail_id=${orderDetailId}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') location.reload();
            })
            .catch(console.error);
        });
    });

    function updateQuantity(orderDetailId, qty) {
        fetch('?act=/cart/update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `orderdetail_id=${orderDetailId}&quantity=${qty}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status !== 'success') return;
            const input = document.querySelector(`.qty-input[data-id="${orderDetailId}"]`);
            input.value = qty;
            const row = input.closest('.cart-item');
            if (row) {
                const itemTotalElem = row.querySelector('.item-total');
                if (itemTotalElem) {
                    itemTotalElem.innerText = data.item_total.toLocaleString('vi-VN') + '₫';
                }
            }
            document.getElementById('subtotal').innerText = data.total.toLocaleString('vi-VN') + '₫';
            document.getElementById('total').innerText    = data.total.toLocaleString('vi-VN') + '₫';
        })
        .catch(console.error);
    }
});
</script>
