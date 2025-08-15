<?php include './views/layouts/header.php'; ?>

<div class="order-detail-container container">
    <h1 class="order-title">📦 Chi tiết đơn hàng #<?= $order['order_id'] ?></h1>

    <!-- Thông tin chung -->
    <div class="order-info-box">
        <h2 class="order-info-title">Thông tin đơn hàng</h2>
        <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
        <p><strong>Người nhận:</strong> <?= htmlspecialchars($order['recipient_name']) ?></p>
        <p><strong>Điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']) ?></p>
        <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
        <?php
        $statusMap = [
            'cart'       => 'Giỏ hàng',
            'pending'    => 'Chờ xác nhận',
            'processing' => 'Đang giao',
            'completed'  => 'Hoàn tất',
            'canceled'   => 'Đã hủy'
        ];
        $statusLabel = $statusMap[$order['status']] ?? $order['status'];
        ?>
        <p><strong>Trạng thái:</strong> <span class="order-status status-<?= $order['status'] ?>"><?= htmlspecialchars($statusLabel) ?></span></p>
        <p><strong>Tạm tính:</strong> <?= number_format($tam_tinh) ?>₫</p>
        <?php if ($discount_amount > 0): ?>
            <p><strong>Giảm giá:</strong> -<?= number_format($discount_amount) ?>₫</p>
        <?php endif; ?>
        <p><strong>Tổng tiền:</strong> <?= number_format($tong_cong) ?>₫</p>
        <p><strong>Tổng tiền sau giảm:</strong> <span class="order-total-amount"><?= number_format($order['total_amount']) ?>₫</span></p>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="order-items-section">
        <h2 class="order-items-title">Sản phẩm trong đơn</h2>
        <div class="order-table-wrapper">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <img src="admin/<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="product-image">
                        </td>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= number_format($item['price']) ?>₫</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'] * $item['quantity']) ?>₫</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Nút quay lại -->
    <div class="order-back">
        <a href="?act=/account/orders" class="btn-back btn-secondary">⬅ Quay lại</a>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>
