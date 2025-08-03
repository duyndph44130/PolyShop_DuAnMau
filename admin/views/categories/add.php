<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">
    <h1>Thêm danh mục</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="?act=/category/add" method="post">
        <label for="name">Tên danh mục:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        <br><br>

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>

        <br><br>
        <button type="submit">Thêm</button>
        <a class="btn" href="?act=/categories">Quay lại danh sách</a>
    </form>
</div>

<?php include './views/layouts/footer.php'; ?>