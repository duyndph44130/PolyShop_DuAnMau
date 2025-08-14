</div>
    <!-- views/layouts/footer.php -->
        <footer class="bg-dark text-white text-center py-2 mt-auto">
            © 2025 PolyShop. All rights reserved.
        </footer>
    </div> <!-- Kết thúc main-content -->
    </div> <!-- Kết thúc wrapper -->
    <!-- Custom Admin JS -->
    <script src="<?= BASE_URL ?>assets/js/admin.js"></script>
    </body>
    </html>
    
    <!-- Footer HTML -->
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
