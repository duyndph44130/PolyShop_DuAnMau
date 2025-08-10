
    <!-- BANNER + DANH MỤC -->
    <section class="container mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- DANH MỤC -->
        <div class="bg-white shadow rounded-lg p-4 h-fit max-h-[400px] overflow-y-auto sticky top-32">
            <h3 class="text-lg font-semibold mb-3 border-b pb-2">📂 Danh mục</h3>
            <ul class="space-y-2">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="?act=/category&id=<?= $category['category_id'] ?>"
                                class="block px-3 py-2 rounded hover:bg-blue-50 hover:text-blue-600">
                                <?= htmlspecialchars($category['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="text-gray-400">Không có danh mục</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- BANNER + DỊCH VỤ -->
        <div class="md:col-span-3 space-y-6">
            <!-- BANNER -->
            <div class="relative rounded-lg overflow-hidden shadow-lg h-64 md:h-80">
                <img src="assets/images/banner1.jpg" class="absolute w-full h-full object-cover banner-slide active" alt="Banner 1">
                <img src="assets/images/banner2.jpg" class="absolute w-full h-full object-cover banner-slide hidden" alt="Banner 2">
                <img src="assets/images/banner3.jpg" class="absolute w-full h-full object-cover banner-slide hidden" alt="Banner 3">

                <button id="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 text-white text-3xl bg-black/30 px-3 py-1 rounded-full hover:bg-black/50">‹</button>
                <button id="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 text-white text-3xl bg-black/30 px-3 py-1 rounded-full hover:bg-black/50">›</button>
            </div>

            <!-- DỊCH VỤ -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    🚚
                    <p class="font-semibold mt-2 text-sm">Miễn phí vận chuyển</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    🔁
                    <p class="font-semibold mt-2 text-sm">Đổi trả trong 7 ngày</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    📞
                    <p class="font-semibold mt-2 text-sm">Hỗ trợ 24/7</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    💳
                    <p class="font-semibold mt-2 text-sm">Thanh toán linh hoạt</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Script -->
    <script>
        const slides = document.querySelectorAll('.banner-slide');
        let index = 0;

        function showSlide(i) {
            slides.forEach((slide, idx) => {
                slide.classList.toggle('hidden', idx !== i);
                slide.classList.toggle('active', idx === i);
            });
        }

        document.getElementById('prevSlide').onclick = () => {
            index = (index - 1 + slides.length) % slides.length;
            showSlide(index);
        };

        document.getElementById('nextSlide').onclick = () => {
            index = (index + 1) % slides.length;
            showSlide(index);
        };

        setInterval(() => {
            index = (index + 1) % slides.length;
            showSlide(index);
        }, 5000);
    </script>