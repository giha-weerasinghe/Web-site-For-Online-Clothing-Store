<?php
// SecondBanner_process_checkout.php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'SecondBanner_config.php'; // Ensure database connection is established

    $customer_name = htmlspecialchars($_POST['customer_name']);
    $customer_email = htmlspecialchars($_POST['customer_email']);
    $customer_address = htmlspecialchars($_POST['customer_address']);
    $payment_method = htmlspecialchars($_POST['payment_method']);

    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $total_price = 0;

    // Generate a unique order reference ID for this checkout
    // Using a timestamp combined with a random string for uniqueness
    $order_reference_id = uniqid('order_', true) . time();

    // Prepare statement for inserting order items
    // Prepare statement for inserting order items
    $stmt_insert_order_item = $conn->prepare("INSERT INTO SecondBannerOrder (order_reference_id, product_id, product_name, product_price, quantity, customer_name, customer_email, selected_size, selected_color) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Prepare statement for updating product stock
    $stmt_update_stock = $conn->prepare("UPDATE SecondBanner SET stock_quantity = stock_quantity - ? WHERE id = ?");

    foreach ($cart_items as $item_key => $item) { // Loop through items in session cart
        $product_id = $item['id']; // This is the original product ID
        $product_name = $item['name'];
        $product_price = $item['price'];
        $quantity = $item['quantity'];
        $selected_size = $item['selected_size'];
        $selected_color = $item['selected_color'];

        $total_price += ($product_price * $quantity);

        // 1. Insert into SecondBannerOrder table
       $stmt_insert_order_item->bind_param("sisdsssss", $order_reference_id, $product_id, $product_name, $product_price, $quantity, $customer_name, $customer_email, $selected_size, $selected_color);
        $stmt_insert_order_item->execute();

        // 2. Decrement stock_quantity in SecondBanner table
        $stmt_update_stock->bind_param("ii", $quantity, $product_id);
        $stmt_update_stock->execute();
    }
    $stmt_insert_order_item->close();
    $stmt_update_stock->close();

    $conn->close(); // Close connection after all database operations

    // Clear the cart after successful purchase
    unset($_SESSION['cart']);

    // ... (rest of your existing code for displaying confirmation)
    // The HTML output for confirmation should remain as is, or you can update it to show the order_reference_id.
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Confirmation</title>
        <link rel="stylesheet" href="SecondBanner.css">
        <link rel="stylesheet" href="footer/style.css">
    </head>
    <body>
        <header>
            <nav>        
        <div class="header-container">
        <div class="logo">
             <a href="Home.html"><img src="images/logo1.png" alt="Store Logo" /></a>
        </div>
</nav>
        </header>
        <main class="container">
            <section class="checkout-section">
                <h2>Order Confirmed!</h2>
                <p>Thank you, <strong>' . $customer_name . '</strong>, for your purchase!</p>
                <p>Your order reference ID is: <strong>' . $order_reference_id . '</strong></p>
                <p>Your order details have been sent to <strong>' . $customer_email . '</strong>.</p>
                <p>Total amount paid: <strong>Rs.' . number_format($total_price, 2) . '</strong></p>
                <p>We will ship your order to: <em>' . $customer_address . '</em></p>
                <p>Payment method: ' . ucfirst(str_replace('_', ' ', $payment_method)) . '</p>
                <p><a href="SecondBanner_index.php" class="view-details-btn">Continue Shopping</a></p>
            </section>
        </main>
        <footer>
            <div class="footer-sections">
        <div class="footer-container">    
      <h3>Customer Care</h3>
      <ul>
        <li><a href="Home.php">Help Center</a></li>
        <li><a href="Home.php">How to Buy</a></li>
        <li><a href="Shipping_policy.html">Shipping Policy</a></li>
        <li><a href="Return_&_Exchange.html">Returns & Exchange Policy</a></li>
        <li><a href="Contact.html">Contact Us</a></li>
      </ul>
    </div>
    <div class="footer-column">
      <h3>ZAYNO</h3>
      <ul>
        <li><a href="Home.html">Home</a></li>
        <li><a href="About.html">About US</a></li>
        <li><a href="Where_we_are.html">Where we are?</a></li>       
        <li><a href="#">ZAYNO Blog</a></li>
        <li><a href="Terms_of_service.html">Terms Of Service</a></li>
        <li><a href="Privacy_Policy.html">Privacy Policy</a></li>
        <li><a href="#">PayLater Edu</a></li>
        <li><a href="#">Code of Conduct</a></li>
        <li><a href="#">Join the ZAYNO Affiliate Program</a></li>
      </ul>
    </div>
    
            <div class="contact" id="contact-info">
                <h3>Contact Information</h3>
                <p><img src="images/email.png" alt="email" /> support@zaynoonlineshop.com</p>
                <p><img src="images/phone.png" alt="phone" /> +94 (76) 3951645</p>
                <p><img src="images/address.png" alt="address" /> Palawela Rd , Rathnapura , Sri Lanka</p>
            </div>
            <div class="social-media">
                <h3>Follow Us</h3>
                <a href="https://facebook.com" target="_blank" rel="noopener">
                    <img src="images/facebook.webp" alt="Facebook" />
                </a>
                <a href="https://twitter.com" target="_blank" rel="noopener">
                    <img src="images/twitter.webp" alt="Twitter" />
                </a>
                <a href="https://instagram.com" target="_blank" rel="noopener">
                    <img src="images/instergame.webp" alt="Instagram" />
                </a>
                <a href="https://whatsapp.com" target="_blank" rel="noopener">
                    <img src="images/whatsapp.png" alt="Instagram" />
                </a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 [ZAYNO] All rights reserved.</p>
        </div>
        </footer>
    </body>
    </html>';

} else {
    // If accessed directly without POST data
    header("Location: SecondBanner_checkout.php");
    exit();
}
?>
