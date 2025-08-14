// assets/js/main.js

document.addEventListener('DOMContentLoaded', function() {
    // --- Global UI Enhancements ---

    // Smooth scroll for anchor links (if any are added later)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add active class to current navigation item
    const currentPath = window.location.search;
    const navItems = document.querySelectorAll('.main-nav .nav-item');
    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href === currentPath || (currentPath === '' && href === '?act=/')) {
            item.classList.add('active-nav-item'); // Add a new class for active state
        }
    });

    // --- Header User Menu Toggle (already in header.php, but good to have here for consistency) ---
    // function toggleUserMenu() {
    //     document.getElementById("userMenu").classList.toggle("open");
    // }
    // document.addEventListener("click", function(e) {
    //     const menu = document.getElementById("userMenu");
    //     if (menu && !menu.contains(e.target)) {
    //         menu.classList.remove("open");
    //     }
    // });

    // --- Banner Slider (already in menu.php, but good to have here for consistency) ---
    // const slides = document.querySelectorAll('.banner-slide');
    // let index = 0;
    // function showSlide(i) {
    //     slides.forEach((slide, idx) => {
    //         slide.classList.toggle('active', idx === i);
    //     });
    // }
    // if (slides.length > 0) {
    //     showSlide(index);
    //     document.getElementById('prevSlide').onclick = () => {
    //         index = (index - 1 + slides.length) % slides.length;
    //         showSlide(index);
    //     };
    //     document.getElementById('nextSlide').onclick = () => {
    //         index = (index + 1) % slides.length;
    //         showSlide(index);
    //     };
    //     setInterval(() => {
    //         index = (index + 1) % slides.length;
    //         showSlide(index);
    //     }, 5000);
    // }

    // --- Product Card Animation (Home Page) ---
    // This is already in home.php, but keeping it here for reference.
    // const cards = document.querySelectorAll(".product-card");
    // const observer = new IntersectionObserver(entries => {
    //     entries.forEach(entry => {
    //         if (entry.isIntersecting) {
    //             entry.target.style.opacity = 1;
    //             entry.target.style.transform = "translateY(0)";
    //             observer.unobserve(entry.target);
    //         }
    //     });
    // }, { threshold: 0.15 });
    // cards.forEach(card => {
    //     card.style.opacity = 0;
    //     card.style.transform = "translateY(20px)";
    //     observer.observe(card);
    // });


    // --- Cart Page Quantity Update & Remove (already in cart.php) ---
    // This logic is already embedded in cart.php, which is fine for specific page scripts.
    // If you want to centralize, you'd move it here and ensure elements are present before attaching listeners.

    // --- Product Detail Page Quantity Control & Add to Cart (already in productdetail.php) ---
    // This logic is already embedded in productdetail.php.

    // --- Profile Update Page Password Toggle (already in profileupdate.php) ---
    // This logic is already embedded in profileupdate.php.

    // --- Register Page Password Toggle (already in register.php) ---
    // This logic is already embedded in register.php.

    // --- Track Order Page Functionality ---
    const trackOrderForm = document.getElementById('trackOrderForm');
    const orderResultsDiv = document.getElementById('orderResults');

    if (trackOrderForm && orderResultsDiv) {
        trackOrderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const orderCodeInput = document.getElementById('orderCode');
            const orderCode = orderCodeInput.value.trim();

            if (orderCode) {
                // Simulate API call or fetch from backend
                // In a real application, you would send an AJAX request to a PHP endpoint
                // e.g., fetch(`?act=/api/trackOrder&code=${orderCode}`)
                // For now, let's simulate some data
                orderResultsDiv.innerHTML = '<p class="empty-message">Đang tìm kiếm đơn hàng...</p>';

                setTimeout(() => {
                    const dummyOrders = {
                        '#12345': {
                            status: 'processing',
                            items: [
                                { name: 'Áo thun nam', qty: 2, price: 150000 },
                                { name: 'Quần jean nữ', qty: 1, price: 300000 }
                            ],
                            total: 600000,
                            date: '2023-10-26 10:30:00',
                            recipient: 'Nguyễn Văn A',
                            address: '123 Đường ABC, Quận XYZ, TP.HCM'
                        },
                        '#67890': {
                            status: 'completed',
                            items: [
                                { name: 'Váy maxi', qty: 1, price: 450000 }
                            ],
                            total: 450000,
                            date: '2023-10-20 14:00:00',
                            recipient: 'Trần Thị B',
                            address: '456 Đường DEF, Quận UVW, Hà Nội'
                        }
                    };

                    const order = dummyOrders[orderCode];

                    if (order) {
                        let statusText = '';
                        let statusClass = '';
                        switch (order.status) {
                            case 'pending': statusText = 'Chờ xác nhận'; statusClass = 'status-pending'; break;
                            case 'processing': statusText = 'Đang giao'; statusClass = 'status-processing'; break;
                            case 'completed': statusText = 'Hoàn tất'; statusClass = 'status-completed'; break;
                            case 'canceled': statusText = 'Đã hủy'; statusClass = 'status-canceled'; break;
                            default: statusText = order.status; statusClass = '';
                        }

                        let itemsHtml = order.items.map(item => `
                            <li>${item.name} (x${item.qty}) - ${item.price.toLocaleString('vi-VN')}₫</li>
                        `).join('');

                        orderResultsDiv.innerHTML = `
                            <div class="order-info-box">
                                <h2 class="order-info-title">Thông tin đơn hàng ${orderCode}</h2>
                                <p><strong>Người nhận:</strong> ${order.recipient}</p>
                                <p><strong>Địa chỉ:</strong> ${order.address}</p>
                                <p><strong>Ngày đặt:</strong> ${new Date(order.date).toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
                                <p><strong>Trạng thái:</strong> <span class="order-status ${statusClass}">${statusText}</span></p>
                                <p><strong>Tổng tiền:</strong> <span class="order-total-amount">${order.total.toLocaleString('vi-VN')}₫</span></p>
                            </div>
                            <div class="order-items-section">
                                <h2 class="order-items-title">Sản phẩm</h2>
                                <ul>${itemsHtml}</ul>
                            </div>
                        `;
                    } else {
                        orderResultsDiv.innerHTML = `
                            <p class="empty-message">Không tìm thấy đơn hàng với mã "<strong>${orderCode}</strong>". Vui lòng kiểm tra lại.</p>
                        `;
                    }
                }, 1000); // Simulate network delay
            } else {
                orderResultsDiv.innerHTML = `
                    <p class="empty-message">Vui lòng nhập mã đơn hàng để theo dõi.</p>
                `;
            }
        });
    }

    // --- General Form Validation Feedback (for required fields) ---
    document.querySelectorAll('form:not(.contact-form):not(#trackOrderForm)').forEach(form => {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            form.querySelectorAll('[required]').forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('input-error');
                    isValid = false;
                    // Add a simple error message if not already present
                    if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-text')) {
                        const errorMsg = document.createElement('p');
                        errorMsg.classList.add('error-text');
                        errorMsg.textContent = 'Trường này là bắt buộc.';
                        input.parentNode.insertBefore(errorMsg, input.nextSibling);
                    }
                } else {
                    input.classList.remove('input-error');
                    // Remove existing error message if valid
                    if (input.nextElementSibling && input.nextElementSibling.classList.contains('error-text')) {
                        input.nextElementSibling.remove();
                    }
                }
            });

            if (!isValid) {
                event.preventDefault(); // Prevent form submission if validation fails
                Swal.fire({
                    title: "Lỗi nhập liệu!",
                    text: "Vui lòng điền đầy đủ các trường bắt buộc.",
                    icon: "warning",
                    showConfirmButton: true
                });
            }
        });

        // Remove error class on input change
        form.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('input-error');
                    if (this.nextElementSibling && this.nextElementSibling.classList.contains('error-text')) {
                        this.nextElementSibling.remove();
                    }
                }
            });
        });
    });

    // --- SweetAlert2 for success/error messages (already in footer.php, but good to know) ---
    // The PHP part in footer.php directly injects the Swal.fire calls.
    // This means the JS here doesn't need to handle it, but it relies on Swal2 being loaded.

});
