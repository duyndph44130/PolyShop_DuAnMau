<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Danh sách mã giảm giá</h2>

    <form method="GET">
        <input type="hidden" name="act" value="/vouchers">
        <input type="text" name="keyword" placeholder="Tìm theo mã voucher..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button class="btn" type="submit">Tìm</button>
    </form>
    <br>

    <?php if (!empty($keyword)): ?>
        <p>Đã tìm thấy <?= count($listVouchers) ?> kết quả cho từ khóa: <strong><?= htmlspecialchars($keyword) ?></strong></p>
    <?php endif; ?>

    <a class="btn mb-2" href="?act=/voucher/add">+ Thêm mới voucher</a>

    <table border="1" cellspacing="0" cellpadding="8">
        <tr style="background-color: #007bff; color: white;">
            <th>ID</th>
            <th>Mã</th>
            <th>Giảm (%)</th>
            <th>Giảm tối đa</th>
            <th>Giá trị tối thiểu</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Sản phẩm áp dụng</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($listVouchers as $voucher): ?>
        <tr>
            <td><?= $voucher['voucher_id'] ?></td>
            <td><?= htmlspecialchars($voucher['name']) ?></td>
            <td><?= $voucher['discount_value'] ?>%</td>
            <td><?= isset($voucher['max_discount']) ? number_format($voucher['max_discount']) . '₫' : '-' ?></td>
            <td><?= isset($voucher['min_order_value']) ? number_format($voucher['min_order_value']) . '₫' : '-' ?></td>
            <td><?= htmlspecialchars($voucher['start_date']) ?></td>
            <td style="color: <?= (strtotime($voucher['end_date']) < time()) ? 'red' : 'green' ?>">
                <?= htmlspecialchars($voucher['end_date']) ?>
            </td>
            <td><?= $voucher['product_name'] ?? '<i>Toàn bộ sản phẩm</i>' ?></td>
            <td>
                <a href="?act=/voucher/edit&id=<?= $voucher['voucher_id'] ?>">Sửa</a> |
                <a href="?act=/voucher/delete&id=<?= $voucher['voucher_id'] ?>" onclick="return confirm('Bạn chắc chắn muốn xoá?')"> Xoá</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include './views/layouts/footer.php'; ?>
