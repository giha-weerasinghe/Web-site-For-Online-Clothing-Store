<?php
// SecondBanner_checkout.php
session_start(); // Start the session to manage cart

include 'SecondBanner_config.php';

$cart_items = [];
$total_price = 0;

// Handle adding product from "Buy Now" on product page
if (isset($_GET['add_product_id']) && is_numeric($_GET['add_product_id'])) {
    $product_id_to_add = $_GET['add_product_id'];
    $selected_size = isset($_GET['selected_size_hidden']) ? $_GET['selected_size_hidden'] : '';
    $selected_color = isset($_GET['selected_color_hidden']) ? $_GET['selected_color_hidden'] : '';
    $quantity = isset($_GET['quantity_hidden']) ? (int)$_GET['quantity_hidden'] : 1;
    // Validate quantity against stock before adding
    $stmt_stock = $conn->prepare("SELECT stock_quantity FROM SecondBanner WHERE id = ?");
    $stmt_stock->bind_param("i", $product_id_to_add);
    $stmt_stock->execute();
    $result_stock = $stmt_stock->get_result();
    $stock_data = $result_stock->fetch_assoc();
    $available_stock = $stock_data['stock_quantity'];
    $stmt_stock->close();

    if ($quantity > $available_stock || $quantity <= 0) {
        // Handle invalid quantity, redirect back or show error
        header("Location: SecondBanner_product.php?id=" . $product_id_to_add . "&error=invalid_quantity");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM SecondBanner WHERE id = ?");
    $stmt->bind_param("i", $product_id_to_add);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product_data = $result->fetch_assoc();
        
        // Calculate discounted price
        $price_to_add = $product_data["price"] * (1 - $product_data["discount_percentage"] / 100);

        // Create a unique key for the cart item based on product ID, size, and color
        // This ensures different sizes/colors of the same product are separate cart items
        $cart_item_key = $product_data['id'] . '_' . md5($selected_size . $selected_color);

        // Add to session cart
        if (isset($_SESSION['cart'][$cart_item_key])) {
            $_SESSION['cart'][$cart_item_key]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$cart_item_key] = [
                'id' => $product_data['id'], // Store product ID for database insertion later
                'name' => $product_data['name'],
                'price' => $price_to_add,
                'image_url' => $product_data['image_url'],
                'quantity' => $quantity,
                'selected_size' => $selected_size,
                'selected_color' => $selected_color
            ];
        }
    }
    $stmt->close();
    // Redirect to clean URL to avoid re-adding on refresh
    header('Location: SecondBanner_checkout.php');
    exit();

    }
// Populate cart items from session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $item) {
        $cart_items[] = $item;
        $total_price += ($item['price'] * $item['quantity']);
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - SecondBanner</title>
    <link rel="stylesheet" href="SecondBanner.css">
    <link rel="stylesheet" href="footer/style.css">
    <style>
        .shopping {
    cursor: pointer;
    font-size: 1.1rem;
    padding-right: 20px;
    margin-top: 10px;
    color: #eee;
}
.shopping a{
    text-decoration: none;
}
</style>
</head>
<body>
    <header>
         <nav>        
        <div class="header-container">
        <div class="logo">
             <a href="Home.html"><img src="images/logo1.png" alt="Store Logo" /></a>
        </div>
        <div class="shopping" id="shopping" >
            <a href="SecondBanner_index.php" style="color:white">Shopping </a>
                </div>
</nav>
    </header>

    <main class="container">
        <section class="checkout-section">
            <h2>Your Order Summary</h2>

            <?php if (empty($cart_items)): ?>
                <p>Your cart is empty. <a href="SecondBanner_index.php">Continue Shopping</a></p>
            <?php else: ?>
                <div class="cart-items">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="checkout-item">
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                             <div class="checkout-item-details">
                                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                <p>Price: Rs.<?php echo number_format($item['price'], 2); ?></p>
                                <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                                <?php if (!empty($item['selected_size'])): ?>
                                    <p>Size: <?php echo htmlspecialchars($item['selected_size']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($item['selected_color'])): ?>
                                    <p>Color: <?php echo htmlspecialchars($item['selected_color']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="checkout-total">
                    Total: <span>Rs.<?php echo number_format($total_price, 2); ?></span>
                </div>

                <form action="SecondBanner_process_checkout.php" method="POST" class="checkout-form">
                    <h3>Shipping Information</h3>
                    <label for="customer_name">Full Name:</label>
                    <input type="text" id="customer_name" name="customer_name" required>

                    <label for="customer_email">Email:</label>
                    <input type="email" id="customer_email" name="customer_email" required>

                    <label for="customer_address">Shipping Address:</label>
                    <textarea id="customer_address" name="customer_address" required></textarea>

                    <label for="payment_method">Payment Method:</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="">Select a method</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="bank_transfer">Bank Transfer</option>
                    </select>
                    <br><br>

                    <button type="submit" class="buy-now-btn">Complete Purchase</button>
                </form>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <div class="footer-sections">
        <div class="footer-container">    
      <h3>Customer Care</h3>
      <ul>
        <li><a href="Help Center Page.html">Help Center</a></li>
        <li><a href="Home.html">How to Buy</a></li>
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
        <li><a href="SizeChart.html">Size Guide</a></li>
        <li><a href="Terms_of_service.html">Terms Of Service</a></li>
        <li><a href="Privacy_Policy.html">Privacy Policy</a></li>
        <li><a href="chat.html">Chat With Us</a></li>
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

    <script src="SecondBanner.js"></script>
</body>
</html>