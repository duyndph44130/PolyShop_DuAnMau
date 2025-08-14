<?php include './views/layouts/header.php'; ?>

<div class="contact-container container">
    <h1 class="contact-title">Liên hệ với PolyShop</h1>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php
    $errors = $_SESSION['errors'] ?? [];
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['errors'], $_SESSION['old']);
    ?>

    <form action="?act=/contact/send" method="POST" class="contact-form" novalidate>
        <div class="form-group">
            <label for="name">Họ và tên <span class="required">*</span></label>
            <input type="text" name="name" id="name" required
                    value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                    class="form-input <?= isset($errors['name']) ? 'input-error' : '' ?>">
            <?php if (isset($errors['name'])): ?>
                <p class="error-text"><?= htmlspecialchars($errors['name']) ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email <span class="required">*</span></label>
            <input type="email" name="email" id="email" required
                    value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                    class="form-input <?= isset($errors['email']) ? 'input-error' : '' ?>">
            <?php if (isset($errors['email'])): ?>
                <p class="error-text"><?= htmlspecialchars($errors['email']) ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="tel" name="phone" id="phone"
                    value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                    class="form-input">
        </div>

        <div class="form-group">
            <label for="subject">Tiêu đề <span class="required">*</span></label>
            <input type="text" name="subject" id="subject" required
                    value="<?= htmlspecialchars($old['subject'] ?? '') ?>"
                    class="form-input <?= isset($errors['subject']) ? 'input-error' : '' ?>">
            <?php if (isset($errors['subject'])): ?>
                <p class="error-text"><?= htmlspecialchars($errors['subject']) ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="message">Nội dung <span class="required">*</span></label>
            <textarea name="message" id="message" rows="6" required
                        class="form-input <?= isset($errors['message']) ? 'input-error' : '' ?>"><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <p class="error-text"><?= htmlspecialchars($errors['message']) ?></p>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-submit btn-primary">
            Gửi liên hệ
        </button>
    </form>
</div>

<?php include './views/layouts/footer.php'; ?>
