<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết thanh toán</title>
</head>
<div class="main-content">
    <h2>Chi tiết thanh toán <?= $payment['payment_id'] ?></h2>

    <p><strong>Khách hàng:</strong> <?= htmlspecialchars($payment['user_name']) ?></p>
    <p><strong>Mã đơn hàng:</strong> <?= $payment['order_id'] ?></p>
    <p><strong>Phương thức:</strong> <?= $payment['payment_method'] ?></p>
    <p><strong>Trạng thái:</strong> <?= $payment['payment_status'] ?></p>
    <p><strong>Ngày thanh toán:</strong> <?= $payment['payment_date'] ?></p>
    <p><strong>Mã giao dịch:</strong> <?= $payment['transaction_id'] ?></p>

    <br>
    <a class="btn" href="?act=/payments">← Quay lại danh sách</a>

</div>

<?php include './views/layouts/footer.php'; ?>
