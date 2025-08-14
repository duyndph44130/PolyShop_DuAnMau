<?php include './views/layouts/header.php'; ?>

<div class="order-list-container container">
    <h1 class="order-list-title">📦 Đơn hàng</h1>

    <?php if (empty($orders)): ?>
        <div class="order-empty-message empty-message">Bạn chưa có đơn hàng nào.</div>
    <?php else: ?>
        <div class="order-table-wrapper">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= $order['order_id'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                            <td><?= number_format($order['total_amount'] ?? 0, 0, ',', '.') ?> ₫</td>
                            <td>
                                <?php
                                    $statusLabels = [
                                        'pending' => 'Chờ xác nhận',
                                        'processing' => 'Đang giao',
                                        'completed' => 'Hoàn tất',
                                        'canceled' => 'Đã hủy'
                                    ];
                                    $status = $order['status'];
                                    $statusText = $statusLabels[$status] ?? ucfirst($status);
                                ?>
                                <span class="order-status status-<?= $status ?>">
                                    <?= $statusText ?>
                                </span>
                            </td>
                            <td>
                                <a href="?act=/order/detail&id=<?= $order['order_id'] ?>" class="order-detail-btn btn-primary">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include './views/layouts/footer.php'; ?>
