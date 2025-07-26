document.addEventListener('DOMContentLoaded', () => {
    const quantityInput = document.getElementById('quantity');
    const basePriceElement = document.querySelector('.base-price');
    const totalDisplayPriceElement = document.getElementById('total-display-price');
    const singleItemPriceElement = document.getElementById('single-item-price');
    const addToCartButton = document.getElementById('addToCartButton');

    // Ensure elements exist before trying to access their properties
    if (!quantityInput || !basePriceElement || !totalDisplayPriceElement || !singleItemPriceElement || !addToCartButton) {
        console.warn("One or more required elements not found on the product detail page.");
        return; // Exit if essential elements are missing
    }

    const basePrice = parseFloat(basePriceElement.dataset.basePrice);

    function updateTotalPrice() {
        let quantity = parseInt(quantityInput.value);
        if (isNaN(quantity) || quantity < 1) {
            quantity = 1;
            quantityInput.value = 1;
        }

        const maxStock = parseInt(quantityInput.max);
            if (quantity > maxStock && maxStock > 0) { // Ensure not to exceed available stock if stock > 0
                quantity = maxStock;
                quantityInput.value = maxStock;
                alert(`You can only add up to ${maxStock} items (available stock).`);
            } else if (maxStock === 0) { // If out of stock, set quantity to 0
                quantity = 0;
                quantityInput.value = 0;
            }

        const totalPrice = basePrice * quantity;
        totalDisplayPriceElement.textContent = totalPrice.toFixed(2);
        singleItemPriceElement.textContent = basePrice.toFixed(2); // Ensure single item price is always correct
    }

    // Initial price update on page load
    updateTotalPrice();


    // Event listener for quantity input changes
    quantityInput.addEventListener('input', updateTotalPrice);

    // Add to Cart functionality (simplified for this example)
    addToCartButton.addEventListener('click', () => {
        const productId = addToCartButton.dataset.productId;
        const productName = addToCartButton.dataset.productName;
        const selectedQuantity = quantityInput.value;
        const imageUrl = addToCartButton.dataset.productImageUrl; // Get image URL
        const selectedSize = document.getElementById('size-select') ? document.getElementById('size-select').value : 'N/A';
        const selectedColorElement = document.querySelector('input[name="product_color"]:checked');
        const selectedColor = selectedColorElement ? selectedColorElement.value : 'N/A';

         if (selectedQuantity <= 0) {
                alert('Please select a quantity greater than zero.');
                return;
            }

            // AJAX request to add to cart
            fetch('firstBanner_add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    productId: productId,
                    productName: productName,
                    quantity: selectedQuantity,
                    pricePerItem: pricePerItem,
                    selectedSize: selectedSize,
                    selectedColor: selectedColor,
                    imageUrl: imageUrl // Pass image URL to cart
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message + "\nRedirecting to Checkout page.");
                    window.location.href = 'firstBanner_checkout.php'; // Redirect to checkout
                } else {
                    alert('Error adding to cart: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding to cart.');
            });
        });


    // --- Checkout Page Logic ---
    const checkoutForm = document.getElementById('checkout-form');
    const payNowButton = document.getElementById('pay-now-button');

    if (checkoutForm && payNowButton) {
        payNowButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission

            if (!validatePaymentForm()) {
                return; // Stop if validation fails
            }

            // Show a loading indicator or disable the button
            payNowButton.textContent = 'Processing...';
            payNowButton.disabled = true;

            // Collect form data manually or use FormData for better handling
            const formData = new FormData(checkoutForm);

            fetch('firstBanner_process_order.php', {
                method: 'POST',
                body: formData // FormData automatically sets Content-Type to multipart/form-data
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message); // Show success message
                    // Redirect to a confirmation page or home page
                    window.location.href = 'firstBanner_products.php';
                } else {
                    alert('Order failed: ' + data.message); // Show error message
                    payNowButton.textContent = 'Pay Now';
                    payNowButton.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during payment processing.');
                payNowButton.textContent = 'Pay Now';
                payNowButton.disabled = false;
            });
        });

        function validatePaymentForm() {
            const cardNumber = document.getElementById('card_number').value.replace(/\s/g, ''); // Remove spaces
            const expiryMonth = document.getElementById('expiry_month').value;
            const expiryYear = document.getElementById('expiry_year').value;
            const cvv = document.getElementById('cvv').value;

            // Card Number Validation
            if (!/^\d{13,19}$/.test(cardNumber)) { // Common card lengths 13-19 digits
                alert('Please enter a valid card number (13-19 digits).');
                return false;
            }

            // Expiry Date Validation (MM/YY)
            if (!/^(0[1-9]|1[0-2])$/.test(expiryMonth)) {
                alert('Please enter a valid expiry month (MM).');
                return false;
            }
            if (!/^\d{2}$/.test(expiryYear)) {
                alert('Please enter a valid expiry year (YY).');
                return false;
            }

            const currentYear = new Date().getFullYear() % 100; // Get last two digits of current year
            const currentMonth = new Date().getMonth() + 1; // getMonth() is 0-indexed

            const inputYear = parseInt(expiryYear, 10);
            const inputMonth = parseInt(expiryMonth, 10);

            if (inputYear < currentYear || (inputYear === currentYear && inputMonth < currentMonth)) {
                alert('Card has expired. Please enter a valid expiry date.');
                return false;
            }

            // CVV Validation (3 or 4 digits)
            if (!/^\d{3,4}$/.test(cvv)) {
                alert('Please enter a valid CVV (3 or 4 digits).');
                return false;
            }

            // Add more specific validations (e.g., Luhn algorithm for card number) in a real application

            return true; // All client-side validations passed
        }
    }
});
    
        //alert(`Added to Cart:\nProduct: ${productName}\nID: ${productId}\nQuantity: ${selectedQuantity}\nSize: ${selectedSize}\nColor: ${selectedColor}\nTotal Price: $${totalDisplayPriceElement.textContent}\n\n(This is a demo. In a real system, this would add to a shopping cart.)`);

        // In a real application, you would send an AJAX request to a backend script
        // to add the item to a session-based cart or a database cart.
        /*
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                productId: productId,
                quantity: selectedQuantity,
                size: selectedSize,
                color: selectedColor
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product added to cart!');
                // Update cart icon/count
            } else {
                alert('Failed to add to cart: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding to cart.');
        });
        */

    // Optional: Thumbnail image gallery functionality
    // If you uncomment the thumbnail-gallery in HTML, enable this:
    /*
    const mainImage = document.getElementById('product-main-image');
    const thumbnails = document.querySelectorAll('.thumbnail-image');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
            // Change main image source
            mainImage.src = thumbnail.src;

            // Remove active class from all thumbnails
            thumbnails.forEach(t => t.classList.remove('active'));
            // Add active class to clicked thumbnail
            thumbnail.classList.add('active');
        });
    });*/