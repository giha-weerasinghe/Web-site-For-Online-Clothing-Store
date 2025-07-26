<?php
session_start();
include 'firstBanner_db_connect.php'; // Make sure this connects to your database where 'orders' and 'order_items' tables are.

$response = ['success' => false, 'message' => 'Order failed.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Get cart items from session
    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    if (empty($cart_items)) {
        $response['message'] = 'Your cart is empty. Cannot process order.';
        echo json_encode($response);
        exit();
    }

    // 2. Get form data
    $user_name = htmlspecialchars($_POST['name']);
    $user_email = htmlspecialchars($_POST['email']);
    $shipping_address = htmlspecialchars($_POST['address']);
    $total_amount = floatval($_POST['total_amount']);

    // Card details (for demonstration; NEVER store raw card details in a real app)
    $card_number = str_replace(' ', '', htmlspecialchars($_POST['card_number'])); // Remove spaces
    $expiry_month = htmlspecialchars($_POST['expiry_month']);
    $expiry_year = htmlspecialchars($_POST['expiry_year']);
    $cvv = htmlspecialchars($_POST['cvv']);
    $card_name = htmlspecialchars($_POST['card_name']);

    // Basic server-side validation (add more robust validation in a real app)
    if (empty($user_name) || empty($user_email) || empty($shipping_address) || empty($card_number) || empty($expiry_month) || empty($expiry_year) || empty($cvv) || empty($card_name)) {
        $response['message'] = 'Please fill in all required fields.';
        echo json_encode($response);
        exit();
    }

    // Very basic card number validation (more robust validation is needed for real payments)
    if (!preg_match('/^\d{16}$/', $card_number) && !preg_match('/^\d{13}$/', $card_number) && !preg_match('/^\d{19}$/', $card_number)) { // Common card lengths
        $response['message'] = 'Invalid card number format.';
        echo json_encode($response);
        exit();
    }
    // Basic expiry date validation (MM/YY)
    $current_year = date('y');
    $current_month = date('m');

    if (!preg_match('/^(0[1-9]|1[0-2])$/', $expiry_month) || !preg_match('/^\d{2}$/', $expiry_year) || (intval($expiry_year) < $current_year) || (intval($expiry_year) == $current_year && intval($expiry_month) < $current_month)) {
        $response['message'] = 'Invalid expiry date.';
        echo json_encode($response);
        exit();
    }

    // Basic CVV validation
    if (!preg_match('/^\d{3,4}$/', $cvv)) {
        $response['message'] = 'Invalid CVV.';
        echo json_encode($response);
        exit();
    }

    // In a real application, you would integrate with a payment gateway (e.g., Stripe, PayPal).
    // This is a placeholder for successful payment processing.
    $payment_successful = true; // Simulate successful payment
    $payment_status = $payment_successful ? 'Completed' : 'Failed';
    $payment_method = 'Credit Card';
    $card_last_four = substr($card_number, -4); // Get last 4 digits for storage

    // 3. Save order to 'orders' table
    $conn->begin_transaction(); // Start transaction for atomicity

    try {
        $stmt = $conn->prepare("INSERT INTO orders (user_name, user_email, shipping_address, total_amount, payment_status, payment_method, card_last_four, order_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdssss", $user_name, $user_email, $shipping_address, $total_amount, $payment_status, $payment_method, $card_last_four, $order_status);

        $order_status = 'Pending'; // Initial order status
        $stmt->execute();
        $order_id = $conn->insert_id; // Get the ID of the newly inserted order
        $stmt->close();

        // 4. Save order items to 'order_items' table
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price_per_item, selected_size, selected_color) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $product_name = $item['product_name'];
            $quantity = $item['quantity'];
            $price_per_item = $item['price_per_item'];
            $selected_size = $item['selected_size'];
            $selected_color = $item['selected_color'];

            $stmt_item->bind_param("iisdsss", $order_id, $product_id, $product_name, $quantity, $price_per_item, $selected_size, $selected_color);
            $stmt_item->execute();

            // Optional: Update stock quantity in firstBanner table
            $update_stock_stmt = $conn->prepare("UPDATE firstBanner SET stock_quantity = stock_quantity - ? WHERE id = ? AND stock_quantity >= ?");
            $update_stock_stmt->bind_param("iii", $quantity, $product_id, $quantity);
            $update_stock_stmt->execute();
            $update_stock_stmt->close();
        }
        $stmt_item->close();

        $conn->commit(); // Commit transaction if all good
        $_SESSION['cart'] = []; // Clear the cart after successful order
        $response['success'] = true;
        $response['message'] = 'Order placed successfully! Your Order ID is: ' . $order_id;
    } catch (Exception $e) {
        $conn->rollback(); // Rollback on error
        $response['message'] = 'Order processing failed: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
$conn->close();
?>