<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>
<div class="main-content">

    <h1>📊 Thống kê doanh số</h1>
    <table>
        <thead><tr><th>Tháng</th><th>Số lượng bán</th><th>Doanh thu</th></tr></thead>
        <tbody>
            <?php $total = 0; foreach ($monthlySales as $row): $total += $row['total_amount']; ?>
            <tr>
                <td>Tháng <?= $row['month'] ?></td>
                <td><?= $row['total_orders'] ?></td>
                <td><?= number_format($row['total_amount']) ?> VND</td>
            </tr>
            <?php endforeach; ?>
            <tr><td colspan="2"><strong>Tổng doanh thu</strong></td><td><strong><?= number_format($total) ?> VND</strong></td></tr>
        </tbody>
    </table>

    <hr>

    <!-- Danh mục & Người dùng -->
    <div class="flex-columns">
        <div class="card-box">
            <h3>📂 Danh mục</h3>
            <ul class="styled-list">
                <?php foreach ($categories as $cat): ?>
                    <li><strong><?= $cat['name'] ?></strong> – <?= $cat['description'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="card-box">
            <h3>👤 Người dùng</h3>
            <ul class="styled-list">
                <?php foreach ($users as $u): ?>
                    <li><strong><?= $u['name'] ?></strong> – <?= $u['email'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <hr>

    <!-- Sản phẩm mới -->
    <h3>🆕 Sản phẩm mới nhất</h3>
    <table>
        <thead><tr><th>Tên</th><th>Giá</th><th>Số lượng</th><th>Danh mục</th></tr></thead>
        <tbody>
            <?php foreach ($recentProducts as $p): ?>
                <tr>
                    <td><?= $p['name'] ?></td>
                    <td><?= number_format($p['price']) ?></td>
                    <td><?= $p['stock_quantity'] ?></td>
                    <td><?= $p['category_name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Đơn hàng gần đây -->
    <h3>📦 Đơn hàng gần đây</h3>
    <table>
        <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Ngày đặt</th><th>Trạng thái</th><th>Tổng</th></tr></thead>
        <tbody>
            <?php foreach ($recentOrders as $order): ?>
                <tr>
                    <td>#<?= $order['order_id'] ?></td>
                    <td><?= $order['name'] ?></td>
                    <td><?= $order['created_at'] ?></td>
                    <td><?= $order['status'] ?></td>
                    <td><?= number_format($order['total_amount']) ?>₫</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Bình luận -->
    <h3>💬 Bình luận gần đây</h3>
    <table>
        <thead><tr><th>Nội dung</th><th>Người dùng</th><th>Sản phẩm</th></tr></thead>
        <tbody>
            <?php foreach ($recentComments as $c): ?>
                <tr>
                    <td><?= $c['content'] ?></td>
                    <td><?= $c['user_name'] ?></td>
                    <td><?= $c['product_name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php include './views/layouts/footer.php'; ?>
