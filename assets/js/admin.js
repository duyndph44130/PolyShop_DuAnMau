// admin.js

document.addEventListener('DOMContentLoaded', function() {
    // 1. Sidebar Active Link Highlight
    const currentPath = window.location.search; // Get query string like "?act=/users"
    const sidebarLinks = document.querySelectorAll('.sidebar a');

    sidebarLinks.forEach(link => {
        // Check if the link's href matches the current path
        // Special handling for dashboard: "?act=/" or just "/"
        const linkAct = link.getAttribute('href');
        if (linkAct === currentPath || (linkAct === '?act=/' && currentPath === '')) {
            link.classList.add('active');
        }
    });

    // 2. Toggle Password Visibility (already in your HTML, but good to centralize)
    // This function is already defined inline in login.php and register.php,
    // but if you want to move it here, ensure the IDs match.
    // For example, if you have multiple password fields, you might pass the ID.
    window.togglePassword = function(id = "password") {
        const passwordInput = document.getElementById(id);
        if (passwordInput) {
            passwordInput.type = (passwordInput.type === "password") ? "text" : "password";
        }
    };

    // 3. Dynamic Table Row Highlighting on Hover (CSS handles this, but JS can add more)
    // This is mostly handled by CSS `:hover`, but if you wanted more complex JS effects,
    // you'd add them here. For now, CSS is sufficient and more performant.

    // 4. Form Submission Feedback (Optional: for AJAX forms or more complex validation)
    // If you were using AJAX for form submissions, you'd add loading spinners,
    // success/error messages here. For traditional form submits, server-side
    // validation and redirection are common.

    // 5. Confirmation Dialog for Delete Actions (already in your HTML, but can be enhanced)
    // The `onclick="return confirm('...')"` is basic. For a more visually appealing
    // and user-friendly confirmation, you'd use a modal dialog.

    // Example of a more advanced delete confirmation (requires a modal HTML structure)
    const deleteButtons = document.querySelectorAll('a[href*="delete"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Prevent default link behavior
            event.preventDefault();

            const confirmMessage = this.getAttribute('onclick') ?
                                    this.getAttribute('onclick').replace("return confirm('", "").replace("')", "") :
                                    "Bạn có chắc chắn muốn xóa mục này?";
            const deleteUrl = this.href;

            // In a real application, you'd show a custom modal here
            // For simplicity, we'll use the native confirm for now, but this is where
            // you'd integrate a library like SweetAlert2 or a custom modal.
            if (confirm(confirmMessage)) {
                window.location.href = deleteUrl;
            }
        });
    });

    // 6. Smooth Scroll for Anchor Links (if you had any on a single page)
    // document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    //     anchor.addEventListener('click', function (e) {
    //         e.preventDefault();
    //         document.querySelector(this.getAttribute('href')).scrollIntoView({
    //             behavior: 'smooth'
    //         });
    //     });
    // });

    // 7. Simple Fade-in for main content (already handled by CSS animations for errors)
    // You could add a general fade-in for the main-content area on page load
    // const mainContent = document.querySelector('.main-content');
    // if (mainContent) {
    //     mainContent.style.opacity = 0;
    //     setTimeout(() => {
    //         mainContent.style.transition = 'opacity 0.8s ease-out';
    //         mainContent.style.opacity = 1;
    //     }, 100); // Small delay to ensure CSS is applied
    // }

    // 8. Live Search Feedback (for search inputs)
    const searchInputs = document.querySelectorAll('input[name="keyword"]');
    searchInputs.forEach(input => {
        let typingTimer;
        const doneTypingInterval = 500; // milliseconds

        input.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                // Trigger search or show live results feedback
                // For now, just a console log, but you could add a visual cue
                // console.log('User finished typing:', input.value);
                // If you want live search without full page reload, you'd use AJAX here.
            }, doneTypingInterval);
        });
    });

    // 9. Image Preview for Product Add/Edit (add.php, edit.php)
    const productImageInput = document.querySelector('input[name="image"]');
    if (productImageInput) {
        const imgPreview = document.createElement('img');
        imgPreview.style.maxWidth = '200px';
        imgPreview.style.maxHeight = '200px';
        imgPreview.style.marginTop = '1rem';
        imgPreview.style.display = 'block';
        imgPreview.style.border = '1px solid var(--border-color)';
        imgPreview.style.borderRadius = 'var(--border-radius)';
        imgPreview.style.boxShadow = 'var(--box-shadow)';
        imgPreview.alt = 'Image Preview';

        // Find the parent label or a suitable container to append the image
        const parentLabel = productImageInput.closest('label');
        if (parentLabel) {
            parentLabel.appendChild(imgPreview);
        } else {
            productImageInput.parentNode.insertBefore(imgPreview, productImageInput.nextSibling);
        }

        productImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imgPreview.src = '';
                imgPreview.style.display = 'none';
            }
        });

        // If editing, show existing image
        const existingImg = document.querySelector('form img[alt="Ảnh sản phẩm hiện tại"]');
        if (existingImg) {
            imgPreview.src = existingImg.src;
            imgPreview.style.display = 'block';
            existingImg.style.display = 'none'; // Hide the original existing image
        } else {
            imgPreview.style.display = 'none'; // Hide if no image initially
        }
    }

    // 10. Tooltips for icons (requires a tooltip library or custom implementation)
    // For example, using Bootstrap's built-in tooltips if you fully integrate Bootstrap JS.
    // Or a simple custom tooltip:
    // const iconsWithTooltips = document.querySelectorAll('.sidebar a i');
    // iconsWithTooltips.forEach(icon => {
    //     icon.addEventListener('mouseenter', function() {
    //         const tooltipText = this.parentNode.textContent.trim(); // Get text from parent link
    //         const tooltip = document.createElement('span');
    //         tooltip.className = 'custom-tooltip';
    //         tooltip.textContent = tooltipText;
    //         document.body.appendChild(tooltip);
    //         // Position tooltip
    //         tooltip.style.left = (this.getBoundingClientRect().left + this.offsetWidth / 2) + 'px';
    //         tooltip.style.top = (this.getBoundingClientRect().top - tooltip.offsetHeight - 5) + 'px';
    //     });
    //     icon.addEventListener('mouseleave', function() {
    //         const tooltip = document.querySelector('.custom-tooltip');
    //         if (tooltip) tooltip.remove();
    //     });
    // });
    // You'd also need CSS for `.custom-tooltip`

});
