<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết người dùng</title>
</head>
<body>
    <h1>Chi tiết người dùng</h1>
    <ul>
        <li>ID: <?= $user['user_id'] ?></li>
        <li>Tên: <?= htmlspecialchars($user['name']) ?></li>
        <li>Email: <?= htmlspecialchars($user['email']) ?></li>
        <li>Địa chỉ: <?= htmlspecialchars($user['address']) ?></li>
        <li>Mật khẩu: <?= htmlspecialchars($user['password']) ?></li>
        <li>Quyền: <?= htmlspecialchars($user['role']) ?></li>
    </ul>
<a href="?act=/users">Quay lại</a></body>
</html>