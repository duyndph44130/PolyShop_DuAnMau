<?php include './views/layouts/header.php'; ?>

<div class="checkout-container container">
    <h1 class="checkout-title">🛍 Thanh toán</h1>

    <form action="?act=/checkout/place" method="POST" class="checkout-grid">
        
        <!-- Cột trái: Thông tin -->
        <div class="checkout-left">

            <!-- Thông tin người đặt -->
            <div class="checkout-box user-info-box">
                <h2 class="checkout-box-title">Thông tin người đặt</h2>
                <div class="checkout-info">
                    <p><strong>Họ tên:</strong> <?= htmlspecialchars($_SESSION['user']['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
                    <p><strong>Điện thoại:</strong> <?= htmlspecialchars($_SESSION['user']['phone']) ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($_SESSION['user']['address']) ?></p>
                </div>
            </div>

            <!-- Thông tin người nhận -->
            <div class="checkout-box receiver-info-box">
                <h2 class="checkout-box-title">Thông tin người nhận</h2>
                <div class="checkout-field">
                    <label for="receiver_name">Họ tên người nhận</label>
                    <input type="text" id="receiver_name" name="receiver_name" value="<?= htmlspecialchars($_POST['receiver_name'] ?? '') ?>" class="form-input">
                    <?php if (!empty($errors['receiver_name'])): ?>
                        <p class="error-text"><?= $errors['receiver_name'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="checkout-field">
                    <label for="receiver_phone">Số điện thoại</label>
                    <input type="text" id="receiver_phone" name="receiver_phone" value="<?= htmlspecialchars($_POST['receiver_phone'] ?? '') ?>" class="form-input">
                    <?php if (!empty($errors['receiver_phone'])): ?>
                        <p class="error-text"><?= $errors['receiver_phone'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="checkout-field">
                    <label for="receiver_address">Địa chỉ giao hàng</label>
                    <input type="text" id="receiver_address" name="receiver_address" value="<?= htmlspecialchars($_POST['receiver_address'] ?? '') ?>" class="form-input">
                    <?php if (!empty($errors['receiver_address'])): ?>
                        <p class="error-text"><?= $errors['receiver_address'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="checkout-box payment-method-box">
                <h2 class="checkout-box-title">Phương thức thanh toán</h2>
                <label class="checkout-radio">
                    <input type="radio" name="payment" value="COD" checked>
                    <span>Thanh toán khi nhận hàng (COD)</span>
                </label>
                <label class="checkout-radio">
                    <input type="radio" name="payment" value="Bank">
                    <span>Chuyển khoản ngân hàng</span>
                </label>
            </div>

        </div>

        <!-- Cột phải: Tóm tắt đơn hàng -->
        <div class="checkout-right order-summary-box">
            <h2 class="checkout-box-title">Đơn hàng của bạn</h2>
            
            <?php foreach ($items as $item): ?>
                <div class="checkout-item">
                    <div class="checkout-item-info">
                        <p class="checkout-item-name"><?= htmlspecialchars($item['product_name']) ?></p>
                        <p class="checkout-item-qty">x<?= $item['quantity'] ?></p>
                    </div>
                    <span class="checkout-item-price"><?= number_format($item['price'] * $item['quantity']) ?>₫</span>
                </div>
            <?php endforeach; ?>

            <div class="checkout-summary">
                <div class="checkout-summary-row">
                    <span>Tạm tính:</span>
                    <span><?= number_format($total + ($discount ?? 0)) ?>₫</span>
                </div>

                <?php if (!empty($_SESSION['voucher'])): ?>
                <div class="checkout-summary-row">
                    <span>Giảm giá (<?= htmlspecialchars($_SESSION['voucher']['code']) ?>):</span>
                    <span>-<?= number_format($_SESSION['voucher']['discount']) ?>₫</span>
                </div>
                <?php endif; ?>

                <div class="checkout-summary-row">
                    <span>Phí giao hàng:</span>
                    <span>35.000₫</span>
                </div>

                <div class="checkout-summary-row total">
                    <span>Tổng cộng:</span>
                    <span><?= number_format($total + 35000) ?>₫</span>
                </div>
            </div>

            <button type="submit" class="checkout-btn btn-primary">Đặt hàng</button>
        </div>

    </form>
</div>

<?php include './views/layouts/footer.php'; ?>
