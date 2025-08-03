<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h2>Danh sách mã giảm giá</h2>

    <form method="GET">
        <input type="hidden" name="act" value="/vouchers">
        <input type="text" name="keyword" placeholder="Tìm theo mã voucher..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button type="submit">Tìm</button>
    </form>
    <br>

    <?php if (!empty($keyword)): ?>
        <p>Đã tìm thấy <?= count($listVouchers) ?> kết quả cho từ khóa: <strong><?= htmlspecialchars($keyword) ?></strong></p>
    <?php endif; ?>
    <br>

    <a class="btn" href="?act=/voucher/add">+ Thêm mới voucher</a>

    <table border="1" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Mã code</th>
        <th>Giảm (%)</th>
        <th>Giảm tối đa</th>
        <th>Giá trị tối thiểu</th>
        <th>Hạn sử dụng</th>
        <th>Người tạo</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($listVouchers as $voucher): ?>
    <tr>
        <td><?= $voucher['voucher_id'] ?></td>
        <td><?= htmlspecialchars($voucher['code']) ?></td>
        <td><?= $voucher['discount_percent'] ?>%</td>
        <td><?= number_format($voucher['max_discount']) ?>₫</td>
        <td><?= number_format($voucher['min_order_value']) ?>₫</td>
        <td style="color: <?= (strtotime($voucher['expiry_date']) < time()) ? 'red' : 'green' ?>">
            <?= $voucher['expiry_date'] ?>
        </td>
        <td><?= htmlspecialchars($voucher['admin_name']) ?></td>
        <td>
            <a href="?act=/voucher/edit&id=<?= $voucher['voucher_id'] ?>">Sửa</a> |
            <a href="?act=/voucher/delete&id=<?= $voucher['voucher_id'] ?>" onclick="return confirm('Bạn chắc chắn muốn xoá?')">Xoá</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>

</div>

<?php include './views/layouts/footer.php'; ?>
