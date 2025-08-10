<?php include './views/layouts/header.php'; ?>

<div class="container mx-auto px-6 py-12 max-w-3xl bg-white rounded shadow">
    <h1 class="text-3xl font-bold text-blue-700 mb-6">Liên hệ với PolyShop</h1>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php
    $errors = $_SESSION['errors'] ?? [];
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['errors'], $_SESSION['old']);
    ?>

    <form action="?act=/contact/send" method="POST" class="space-y-6" novalidate>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Họ và tên <span class="text-red-600">*</span></label>
            <input type="text" name="name" id="name" required
                    value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                    class="w-full border <?= isset($errors['name']) ? 'border-red-500' : 'border-gray-300' ?> rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
            <?php if (isset($errors['name'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['name']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-600">*</span></label>
            <input type="email" name="email" id="email" required
                    value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                    class="w-full border <?= isset($errors['email']) ? 'border-red-500' : 'border-gray-300' ?> rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
            <?php if (isset($errors['email'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['email']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
            <input type="tel" name="phone" id="phone"
                    value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
        </div>

        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700">Tiêu đề <span class="text-red-600">*</span></label>
            <input type="text" name="subject" id="subject" required
                    value="<?= htmlspecialchars($old['subject'] ?? '') ?>"
                    class="w-full border <?= isset($errors['subject']) ? 'border-red-500' : 'border-gray-300' ?> rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400" />
            <?php if (isset($errors['subject'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['subject']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-700">Nội dung <span class="text-red-600">*</span></label>
            <textarea name="message" id="message" rows="6" required
                        class="w-full border <?= isset($errors['message']) ? 'border-red-500' : 'border-gray-300' ?> rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['message']) ?></p>
            <?php endif; ?>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700 transition">
            Gửi liên hệ
        </button>
    </form>
</div>

<?php include './views/layouts/footer.php'; ?>
