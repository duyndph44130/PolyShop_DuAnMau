<?php include './views/layouts/header.php'; ?>
<?php include './views/layouts/navbar.php'; ?>
<?php include './views/layouts/sidebar.php'; ?>

<div class="main-content">

    <h1>Sửa danh mục</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <form act="" method="post">
            <label for="name">Tên danh mục:</label>
            <input type="text" id="name" name="name" value="<?= $category['name'] ?? ''?>">
            <br><br>

            <label for="description">Mô tả:</label>
            <textarea id="description" name="description"><?= $category['description'] ?? '' ?></textarea>
            
            <br><br>
            <button type="submit">Cập nhật</button>
            <a class="btn" href="?act=/categories">Quay lại danh sách</a>
        </form>
    </body>
    </html>
    
</div>

<?php include './views/layouts/footer.php'; ?>