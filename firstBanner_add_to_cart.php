<?php
session_start(); // Start the session to use $_SESSION

header('Content-Type: application/json'); // Respond with JSON

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['productId'], $data['productName'], $data['quantity'], $data['pricePerItem'])) {
        $productId = intval($data['productId']);
        $productName = htmlspecialchars($data['productName']);
        $quantity = intval($data['quantity']);
        $pricePerItem = floatval($data['pricePerItem']);
        $selectedSize = isset($data['selectedSize']) ? htmlspecialchars($data['selectedSize']) : 'N/A';
        $selectedColor = isset($data['selectedColor']) ? htmlspecialchars($data['selectedColor']) : 'N/A';

        if ($quantity <= 0) {
            $response['message'] = 'Quantity must be at least 1.';
            echo json_encode($response);
            exit();
        }

        // Initialize cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Create a unique cart item ID (e.g., using product_id, size, and color)
        $cart_item_key = $productId . '_' . $selectedSize . '_' . $selectedColor;

        // Check if product with same size/color already in cart
        if (isset($_SESSION['cart'][$cart_item_key])) {
            $_SESSION['cart'][$cart_item_key]['quantity'] += $quantity;
            $response['message'] = 'Quantity updated in cart!';
        } else {
            $_SESSION['cart'][$cart_item_key] = [
                'product_id' => $productId,
                'product_name' => $productName,
                'quantity' => $quantity,
                'price_per_item' => $pricePerItem,
                'selected_size' => $selectedSize,
                'selected_color' => $selectedColor,
                'image_url' => isset($data['imageUrl']) ? htmlspecialchars($data['imageUrl']) : '' // Add image_url
            ];
            $response['message'] = 'Product added to cart!';
        }

        $response['success'] = true;
    } else {
        $response['message'] = 'Invalid product data received.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>