<?php include './views/layouts/header.php'; ?>

<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Đăng nhập tài khoản</h2>

    <?php if (!empty($error)): ?>
        <div class="text-red-600 mb-3"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <!-- Email -->
        <div>
            <label for="email" class="block font-medium mb-1">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                class="w-full border px-3 py-2 rounded <?= !empty($errors['email']) ? 'border-red-500' : '' ?>"
            >
            <?php if (!empty($errors['email'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($errors['email']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Mật khẩu -->
        <div>
            <label for="password" class="block font-medium mb-1">Mật khẩu</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="w-full border px-3 py-2 rounded <?= !empty($errors['password']) ? 'border-red-500' : '' ?>"
            >
            <?php if (!empty($errors['password'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($errors['password']) ?></p>
            <?php endif; ?>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Đăng nhập
        </button>
    </form>
</div>

<?php include './views/layouts/footer.php'; ?>
