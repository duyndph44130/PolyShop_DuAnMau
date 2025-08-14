    <!-- Footer HTML -->
    <footer class="main-footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> PolyShop. All rights reserved.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (!empty($_SESSION['success'])): ?>
    <script>
    Swal.fire({
    title: "Thành công",
    text: "<?= addslashes($_SESSION['success']) ?>",
    icon: "success",
    showConfirmButton: false,
    timer: 2000
    });
    </script>
    <?php unset($_SESSION['success']); endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
    <script>
    Swal.fire({
    title: "Thất bại",
    text: "<?= addslashes($_SESSION['error']) ?>",
    icon: "error",
    showConfirmButton: true
    });
    </script>
    <?php unset($_SESSION['error']); endif; ?>
</body>
</html>
