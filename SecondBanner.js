// js/SecondBanner.js

document.addEventListener('DOMContentLoaded', function() {
    // Example: Simple alert for "Buy Now" on product details page
    const buyNowBtn = document.querySelector('.product-detail-info .buy-now-btn');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            // In a real application, this would redirect to checkout
            // For now, let's simulate adding to cart/redirecting
            // alert('Item added to cart!');
            // window.location.href = 'SecondBanner_checkout.php?product_id=' + this.dataset.productId;
        });
    }

    // Example: Basic form validation for checkout
    const checkoutForm = document.querySelector('.checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(event) {
            const name = document.getElementById('customer_name').value.trim();
            const email = document.getElementById('customer_email').value.trim();
            const address = document.getElementById('customer_address').value.trim();

            if (!name || !email || !address) {
                alert('Please fill in all required fields.');
                event.preventDefault(); // Stop form submission
            } else if (!isValidEmail(email)) {
                alert('Please enter a valid email address.');
                event.preventDefault();
            }
        });
    }

    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

});
// js/SecondBanner.js

document.addEventListener('DOMContentLoaded', function() {
    // ... (existing JS code) ...

    // Image Zoom on Product Detail Page
    const productDetailImageContainer = document.querySelector('.product-detail-image');
    const productDetailImage = document.querySelector('.product-detail-image img');

    if (productDetailImageContainer && productDetailImage) {
        productDetailImageContainer.addEventListener('mousemove', function(e) {
            const rect = productDetailImageContainer.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // Calculate percentage position
            const x_percent = (x / rect.width) * 100;
            const y_percent = (y / rect.height) * 100;

            productDetailImage.style.transformOrigin = `${x_percent}% ${y_percent}%`;
            productDetailImage.classList.add('zoomed');
        });

        productDetailImageContainer.addEventListener('mouseleave', function() {
            productDetailImage.classList.remove('zoomed');
            productDetailImage.style.transformOrigin = 'center center'; // Reset origin
        });
    }

    // Example: Basic form validation for checkout
    // ... (existing checkout form validation) ...
});