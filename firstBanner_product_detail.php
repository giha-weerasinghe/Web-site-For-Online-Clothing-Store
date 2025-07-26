<?php
include 'firstBanner_db_connect.php';

$product = null;
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // Ensure ID is an integer
    $sql = "SELECT * FROM firstBanner WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}

// Define available sizes - now fetched from DB
$product_sizes = [];
if ($product && !empty($product['available_sizes'])) {
    // JSON string එක PHP array එකකට decode කිරීම
    $decoded_sizes = json_decode($product['available_sizes'], true);
    if (is_array($decoded_sizes)) {
        $product_sizes = $decoded_sizes;
    }
}
// Default sizes if none are provided in DB or decoding fails
if (empty($product_sizes)) {
    $product_sizes = ['S', 'M', 'L']; // Default sizes if DB is empty
}

$product_colors = [];
if ($product && !empty($product['available_colors'])) {
    // JSON string එක PHP array එකකට decode කිරීම
    $decoded_colors = json_decode($product['available_colors'], true);
    if (is_array($decoded_colors)) {
        $product_colors = $decoded_colors;
    }
}
// Default colors if none are provided in DB or decoding fails
if (empty($product_colors)) {
    $product_colors = ['Black', 'White', 'Red', 'Blue']; // Default colors if DB is empty
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product ? htmlspecialchars($product['product_name']) : 'Product Not Found'; ?> - Global Deals</title>
    <link rel="stylesheet" href="firstBanner_style.css">
    <link rel="stylesheet" href="footer/style.css">
    <script src="firstBanner_script.js" defer></script>
</head>
<body>
    <nav class="breadcrumbs">
            <span><a href="Home.html">Home</a></span> &gt; <span><a href="firstBanner_products.php">Global Deals</span>&gt; <span>Product</span>
        </nav>

    <main class="container product-detail-page">
        <?php if ($product): ?>
            <div class="detail-container">
                <div class="product-image-container">
                    <div class="image-zoom-wrapper">
                        <img id="product-main-image" src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                    </div>
                    </div>
                <div class="product-info-container">
                    <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
                    
                    <div class="social-share">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fas fa-envelope"></i></a>
                </div>
                    

                    <div class="options-group">
                        <label for="size-select">Size:</label>
                        <select id="size-select" name="product_size">
                            <?php foreach ($product_sizes as $size): ?>
                                 <option value="<?php echo htmlspecialchars($size); ?>"><?php echo htmlspecialchars($size); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

<div class="options-group">
                        <label>Color:</label>
                        <div class="color-options">
                            <?php foreach ($product_colors as $color): ?>
                                <input type="radio" id="color_<?php echo strtolower($color); ?>" name="product_color" value="<?php echo htmlspecialchars($color); ?>">
                                <label for="color-<?php echo strtolower($color); ?>" class="color-box" style="background-color: <?php echo strtolower($color); ?>;" title="<?php echo htmlspecialchars($color); ?>"></label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="options-group quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity"
                               value="<?php echo ($product['stock_quantity'] > 0 ? '1' : '0'); ?>"
                               min="<?php echo ($product['stock_quantity'] > 0 ? '1' : '0'); ?>"
                               max="<?php echo htmlspecialchars($product['stock_quantity']); ?>"
                               <?php echo ($product['stock_quantity'] == 0 ? 'disabled' : ''); ?>>
                    </div>

                    <div class="base-price" data-base-price="<?php echo htmlspecialchars($product['price']); ?>">
                      <label>Price Per Item:</label>
                       <p class="base">Rs. <span id="single-item-price"><?php echo number_format($product['price'], 2); ?></span></p>
                    </div>

                     <div class="total-price">
                     <label>Total Price:</label>
                      <p class="total">Rs. <b><span id="total-display-price"><?php echo number_format($product['price'], 2); ?></span></b></p>
                     </div>

                     <p class="stock-status <?php echo ($product['stock_quantity'] > 0 ? 'in-stock' : 'out-of-stock'); ?>">
                        <?php echo ($product['stock_quantity'] > 0 ? 'In Stock' : 'Out of Stock'); ?>
                    </p>

                    <button class="add-to-cart-button" id="addToCartButton"
                            data-product-id="<?php echo $product['id']; ?>"
                            data-product-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                            data-product-price="<?php echo htmlspecialchars($product['price']); ?>"
                            data-product-color="<?php echo htmlspecialchars($product_colors[0] ?? ''); // Set default color, or leave empty if no colors ?>"
                            data-product-size="<?php echo htmlspecialchars($product_sizes[0] ?? ''); // Set default size, or leave empty if no sizes ?>"
                            data-product-image-url="<?php echo htmlspecialchars($product['image_url']); ?>"
                            <?php echo ($product['stock_quantity'] == 0 ? 'disabled' : ''); ?>>
                        Add to Cart
                    </button>                   
                    </div>
                    <div class="options-group">
                      <label>Description</label>
                      <p class="Description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    </div>
            </div>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
        <p><a href="firstBanner_products.php">Back to Products</a></p>
    </main>

    <footer>
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> [ZAYNO] All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

<?php
$conn->close();
?>