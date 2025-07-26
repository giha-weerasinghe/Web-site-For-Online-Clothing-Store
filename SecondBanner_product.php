<?php
// SecondBanner_product.php
include 'SecondBanner_config.php';

$product = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, description, price, image_url, discount_percentage, stock_quantity, available_sizes, available_colors FROM SecondBanner WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<p>Product not found!</p>";
    }
    $stmt->close();
} else {
    header("Location: SecondBanner_index.php"); // Redirect if no ID is provided
    exit();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product ? htmlspecialchars($product['name']) : 'Product Not Found'; ?> - SecondBanner</title>
    <link rel="stylesheet" href="SecondBanner.css">
     <link rel="stylesheet" href="footer/style.css">
     <style>
        /* Reviews Section on Product Details Page */
.reviews-section {
    margin-top: 40px;
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.reviews-section h2 {
    color: #0056b3;
    margin-bottom: 25px;
    border-bottom: 2px solid #eee;
    padding-bottom: 10px;
}

.review-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    background-color: #f9f9f9;
}

.review-item .reviewer-info {
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

.review-item .rating {
    color: #ffc107; /* Star color */
    margin-bottom: 5px;
    font-size: 1.2em;
}

.review-item .review-text {
    line-height: 1.6;
    color: #555;
}

.review-item .review-date {
    font-size: 0.9em;
    color: #888;
    text-align: right;
}

/* Review Submission Form */
.review-form {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eeeeee;
}

.review-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.review-form input[type="text"],
.review-form select,
.review-form textarea {
    width: calc(100% - 22px);
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
    box-sizing: border-box;
}

.review-form textarea {
    resize: vertical;
    min-height: 100px;
}

.review-form button[type="submit"] {
    background-color: #28a745; /* Green */
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 5px;
    font-size: 1.1em;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.review-form button[type="submit"]:hover {
    background-color: #218838;
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
        
</nav>
    </header>

    <main class="container">
        <?php if ($product): ?>
            <div class="product-detail">
                <div class="product-detail-image">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="product-detail-info">
                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p class="price">
                        <?php
                        $original_price = $product["price"];
                        $discount_percentage = $product["discount_percentage"];
                        if ($discount_percentage > 0) {
                            $discount_price = $original_price * (1 - $discount_percentage / 100);
                            echo '<span class="original-price">Rs.' . number_format($original_price, 2) . '</span>';
                            echo '<span class="discount-price">Rs.' . number_format($discount_price, 2) . '</span>';
                            echo '<span class="discount-tag">-' . htmlspecialchars($discount_percentage) . '%</span>';
                        } else {
                            echo '<span>$' . number_format($original_price, 2) . '</span>';
                        }
                        ?>
                    </p>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <div class="product-options">
                        <?php
                        $sizes = array_filter(array_map('trim', explode(',', $product['available_sizes'])));
                        if (!empty($sizes)) {
                            echo '<label for="selected_size">Size:</label>';
                            echo '<select id="selected_size" name="selected_size" required>';
                            echo '<option value="">Select Size</option>';
                            foreach ($sizes as $size) {
                                echo '<option value="' . htmlspecialchars($size) . '">' . htmlspecialchars($size) . '</option>';
                            }
                            echo '</select>';
                        }

                        $colors = array_filter(array_map('trim', explode(',', $product['available_colors'])));
                        if (!empty($colors)) {
                            echo '<label for="selected_color">Color:</label>';
                            echo '<select id="selected_color" name="selected_color" required>';
                            echo '<option value="">Select Color</option>';
                            foreach ($colors as $color) {
                                echo '<option value="' . htmlspecialchars($color) . '">' . htmlspecialchars($color) . '</option>';
                            }
                            echo '</select>';
                        }
                        ?>

                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required>

                    </div>

                    <?php if ($product['stock_quantity'] > 0): ?>
                        <form action="SecondBanner_checkout.php" method="GET" style="display: inline-block;">
                            <input type="hidden" name="add_product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <input type="hidden" name="selected_size_hidden" id="selected_size_hidden">
                            <input type="hidden" name="selected_color_hidden" id="selected_color_hidden">
                            <input type="hidden" name="quantity_hidden" id="quantity_hidden">
                            <button type="submit" class="buy-now-btn">Buy Now</button>
                        </form>
                        <script>
                            // Update hidden fields before submitting the form
                            document.querySelector('.buy-now-btn').parentNode.addEventListener('submit', function(event) {
                                const selectedSizeElement = document.getElementById('selected_size');
                                const selectedColorElement = document.getElementById('selected_color');
                                const quantityElement = document.getElementById('quantity');

                                if (selectedSizeElement) {
                                    document.getElementById('selected_size_hidden').value = selectedSizeElement.value;
                                    if (selectedSizeElement.value === "") {
                                        alert('Please select a size.');
                                        event.preventDefault();
                                        return;
                                    }
                                }
                                if (selectedColorElement) {
                                    document.getElementById('selected_color_hidden').value = selectedColorElement.value;
                                    if (selectedColorElement.value === "") {
                                        alert('Please select a color.');
                                        event.preventDefault();
                                        return;
                                    }
                                }
                                if (quantityElement.value < 1 || quantityElement.value > <?php echo htmlspecialchars($product['stock_quantity']); ?>) {
                                     alert('Please enter a valid quantity.');
                                     event.preventDefault();
                                     return;
                                }
                                document.getElementById('quantity_hidden').value = quantityElement.value;
                            });
                        </script>
                    <?php else: ?>
                        <p style="color: red; font-weight: bold;">Out of Stock</p>
                    <?php endif; ?>
                    </div>
            </div>

            <section class="reviews-section">
                <h2>Customer Reviews</h2>
                <?php
                // Re-establish connection as it might have been closed by product fetch
                include 'SecondBanner_config.php';

                $review_message = '';
                if (isset($_GET['review_status'])) {
                    if ($_GET['review_status'] == 'success') {
                        $review_message = '<p style="color: green; font-weight: bold;">Review submitted successfully!</p>';
                    } elseif ($_GET['review_status'] == 'error') {
                        $review_message = '<p style="color: red; font-weight: bold;">Error submitting review. Please try again.</p>';
                    }
                }
                echo $review_message;

                $stmt_reviews = $conn->prepare("SELECT reviewer_name, rating, review_text, review_date FROM SecondBannerReview WHERE product_id = ? ORDER BY review_date DESC");
                $stmt_reviews->bind_param("i", $product_id);
                $stmt_reviews->execute();
                $result_reviews = $stmt_reviews->get_result();

                if ($result_reviews->num_rows > 0) {
                    while($review = $result_reviews->fetch_assoc()) {
                ?>
                        <div class="review-item">
                            <div class="reviewer-info"><?php echo htmlspecialchars($review['reviewer_name']); ?></div>
                            <div class="rating">
                                <?php
                                for ($i = 0; $i < $review['rating']; $i++) {
                                    echo '★'; // Unicode star character
                                }
                                for ($i = $review['rating']; $i < 5; $i++) {
                                    echo '☆'; // Unicode empty star character
                                }
                                ?>
                            </div>
                            <p class="review-text"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                            <p class="review-date">Reviewed on: <?php echo date("Y-m-d", strtotime($review['review_date'])); ?></p>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>No reviews yet. Be the first to review this product!</p>";
                }
                $stmt_reviews->close();
                $conn->close(); // Close connection here as well
                ?>

                <h3>Write a Review</h3>
                <form action="SecondBanner_submit_review.php" method="POST" class="review-form">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    
                    <label for="reviewer_name">Your Name:</label>
                    <input type="text" id="reviewer_name" name="reviewer_name" required>

                    <label for="rating">Rating:</label>
                    <select id="rating" name="rating" required>
                        <option value="">Select a rating</option>
                        <option value="5">5 Stars - Excellent</option>
                        <option value="4">4 Stars - Very Good</option>
                        <option value="3">3 Stars - Good</option>
                        <option value="2">2 Stars - Fair</option>
                        <option value="1">1 Star - Poor</option>
                    </select>

                    <label for="review_text">Your Review:</label>
                    <textarea id="review_text" name="review_text" rows="5"></textarea>

                    <button type="submit">Submit Review</button>
                </form>
            </section>


        <?php else: ?>
            <p>Product details could not be loaded.</p>
            <a href="SecondBanner_index.php">Back to Products</a>
        <?php endif; ?>
    </main>

    <footer>
       
        <div class="footer-bottom">
            <p>&copy; 2025 [ZAYNO] All rights reserved.</p>
        </div>
    </footer>

    <script src="SecondBanner.js"></script>
</body>
</html>