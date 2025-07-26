<?php
session_start();
include 'firstBanner_db_connect.php'; // For potential user data from 'users' table

// Dummy user data (replace with actual session data from your registration system)
// For demonstration, we'll load fixed data. In a real app, this would be from $_SESSION after login.
// Example: if ($_SESSION['user_id']) { fetch user details from DB }
$user_id_from_session = 1; // Replace with $_SESSION['user_id'] after user login

$registered_user_name = ""; // Initialize
$registered_user_email = ""; // Initialize
$user_full_address = ""; //Initialize

// Try to fetch user details from the dummy 'users' table if it exists
$stmt_user = $conn->prepare("SELECT username, email FROM users WHERE id = ?"); // Assuming your 'users' table has 'name' and 'email'
if ($stmt_user) {
    $stmt_user->bind_param("i", $user_id_from_session);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    if ($user_data = $result_user->fetch_assoc()) {
        $registered_user_name = htmlspecialchars($user_data['username']);
        $registered_user_email = htmlspecialchars($user_data['email']);
    }
    $stmt_user->close();
}
$stmt_address = $conn->prepare("SELECT full_name, street_address, city, zip_code, country, phone_number FROM user_addresses WHERE user_id = ? ORDER BY is_default DESC LIMIT 1"); // get default or any address
if ($stmt_address) {
    $stmt_address->bind_param("i", $user_id_from_session);
    $stmt_address->execute();
    $result_address = $stmt_address->get_result();
    if ($address_data = $result_address->fetch_assoc()) {
        // Construct the full address string from columns
        $user_full_address = htmlspecialchars($address_data['street_address']) . "\n" .
                             htmlspecialchars($address_data['city']) . ", " .
                             htmlspecialchars($address_data['zip_code']) . "\n" .
                             htmlspecialchars($address_data['country']) . "\n" .
                             "Phone: " . htmlspecialchars($address_data['phone_number']);
        // If 'full_name' from user_addresses is preferred over 'name' from 'users'
        // $registered_user_name = htmlspecialchars($address_data['full_name']);
    }
    $stmt_address->close();
}


$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['quantity'] * $item['price_per_item'];
}
$shipping_cost = 10.00; // Example shipping cost
$total_amount = $subtotal + $shipping_cost;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Global Deals</title>
    <link rel="stylesheet" href="firstBanner_style.css">
    <script src="firstBanner_script.js" defer></script>
</head>
<body>
    <header>
        <div class="container">
            <h1>Global Deals</h1>
            <nav>
                <ul>
                    <li><a href="firstBanner_products.php">Shop</a></li>
                    <li><a href="firstBanner_admin.php">Admin</a></li>
                    <li><a href="firstBanner_checkout.php">Cart/Checkout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container checkout-page">
        <h2>Checkout</h2>

        <?php if (empty($cart_items)): ?>
            <p class="empty-cart-message">Your cart is empty. Please add some products to proceed to checkout.</p>
            <p><a href="firstBanner_products.php" class="back-to-shop-link">Continue Shopping</a></p>
        <?php else: ?>
            <div class="checkout-grid">
                <div class="checkout-section order-summary">
                    <h3>Order Summary</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $key => $item): ?>
                            <tr>
                                <td class="product-info-cell">
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="checkout-thumbnail">
                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($item['selected_size']); ?></td>
                                <td><?php echo htmlspecialchars($item['selected_color']); ?></td>
                                <td>$<?php echo number_format($item['price_per_item'], 2); ?></td>
                                <td>$<?php echo number_format($item['quantity'] * $item['price_per_item'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="total-label">Subtotal:</td>
                                <td class="total-value">$<?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="total-label">Shipping:</td>
                                <td class="total-value">$<?php echo number_format($shipping_cost, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="total-label grand-total">Grand Total:</td>
                                <td class="total-value grand-total">$<span id="grand-total"><?php echo number_format($total_amount, 2); ?></span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="checkout-section shipping-payment">
                    <h3>Shipping Information</h3>
                    <form id="checkout-form" action="firstBanner_process_order.php" method="POST">
                        <div class="form-group">
                            <label for="name">Full Name:</label>
                            <input type="text" id="name" name="name" value="<?php echo $registered_user_name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo $registered_user_email; ?>" required>
                        </div>
                        <div class="form-group">
    <label for="address">Shipping Address:</label>
    <textarea id="address" name="address" rows="4" required><?php echo $user_full_address; ?></textarea>
    <small class="address-note">This address is pre-filled from your profile/registration.</small>
</div>

                        <h3>Payment Details</h3>
                        <div class="form-group">
                            <label for="card_number">Card Number:</label>
                            <input type="text" id="card_number" name="card_number" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" required>
                            <small>Enter 16 digits without spaces</small>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="expiry_month">Expiry Month:</label>
                                <input type="text" id="expiry_month" name="expiry_month" placeholder="MM" maxlength="2" required>
                            </div>
                            <div class="form-group">
                                <label for="expiry_year">Expiry Year:</label>
                                <input type="text" id="expiry_year" name="expiry_year" placeholder="YY" maxlength="2" required>
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV:</label>
                                <input type="text" id="cvv" name="cvv" placeholder="XXX" maxlength="4" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="card_name">Name on Card:</label>
                            <input type="text" id="card_name" name="card_name" required>
                        </div>

                        <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
                        <button type="submit" id="pay-now-button" class="pay-now-button">Pay Now</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> [ZAYNO] All rights reserved.</p>
        </div>
    </footer>
</body>
</html>