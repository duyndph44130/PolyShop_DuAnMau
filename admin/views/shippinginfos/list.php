<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Danh sách vận chuyển</h2>

    <!-- Form tìm kiếm -->
    <form method="GET" style="margin-bottom: 15px;">
        <input type="hidden" name="act" value="/shippinginfos">
        <input type="text" name="keyword" placeholder="Nhập tên, SĐT, địa chỉ..." 
            value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button class="btn" type="submit">Tìm kiếm</button>
    </form>

    <?php if (!empty($keyword)): ?>
        <p>Đã tìm thấy <?= count($shippingInfos) ?> kết quả cho từ khóa: <strong><?= htmlspecialchars($keyword) ?></strong></p>
    <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <tr style="background-color: #007bff; color: white;">
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Người nhận</th>
            <th>Địa chỉ</th>
            <th>Điện thoại</th>
            <th>Phương thức</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($shippingInfos as $shippinginfo): ?>
            <tr>
                <td><?= $shippinginfo['shipping_id'] ?></td>
                <td><?= htmlspecialchars($shippinginfo['user_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($shippinginfo['recipient_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($shippinginfo['address'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($shippinginfo['phone'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($shippinginfo['shipping_method'] ?? 'N/A') ?></td>
                <td><?= $shippinginfo['shipping_status_label'] ?></td>
                <td><?= !empty($shippinginfo['created_at']) ? date('d/m/Y H:i', strtotime($shippinginfo['created_at'])) : 'N/A' ?></td>
                <td>
                    <a href="?act=/shippinginfo/edit&id=<?= $shippinginfo['shipping_id'] ?>">Sửa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include './views/layouts/footer.php'; ?>
