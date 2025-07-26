<?php
include 'firstBanner_db_connect.php'; // Include the database connection

// Fetch products from the database
$sql = "SELECT id, product_name, price, image_url, stock_quantity FROM firstBanner";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Deals - Our Products</title>
    <link rel="stylesheet" href="firstBanner_style.css">
    <link rel="stylesheet" href="Banner/Style.css">
    <link rel="stylesheet" href="footer/style.css">
</head>
<body>

        <nav class="breadcrumbs">
            <span><a href="Home.html">Home</a></span> &gt; <span>Global Deals</span>
        </nav>
    <div class="banner-container">
    <div class="banner-slide active" style="background: linear-gradient(to right, #ff6600, #ffcc00);">
        <img src="images/b1.png" alt="Global Deals Banner 1">
        <div class="banner-content">
            <h1>GLOBAL DEALS</h1><br>
            <h2 class="h2" style="color:white">AT THE BEST PRICES</h2>
        </div>
    </div>
    </div>

    <main class="container product-grid">
        <h2>Our Latest Products</h2>
        <div class="products-container">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="product-card">';
                    echo '<a href="firstBanner_product_detail.php?id=' . $row["id"] . '">';
                    echo '<img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">';
                    echo '<h3>' . htmlspecialchars($row["product_name"]) . '</h3>';
                    echo '<p class="price">Rs.' . number_format($row["price"], 2) . '</p>';
                    echo '<p class="stock-status ' . ($row["stock_quantity"] > 0 ? 'in-stock' : 'out-of-stock') . '">';
                    echo ($row["stock_quantity"] > 0 ? 'In Stock' : 'Out of Stock') . '</p>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No products available yet.</p>';
            }
            ?>
        </div>
    </main>

    <footer>
        <div class="footer-sections">
        <div class="footer-container">    
      <h3>Customer Care</h3>
      <ul>
        <li><a href="Home.html">Help Center</a></li>
        <li><a href="Home.html">How to Buy</a></li>
        <li><a href="#">Corporate & Bulk Purchasing</a></li>
        <li><a href="#">Returns & Refunds</a></li>
        <li><a href="Contact.html">Contact Us</a></li>
      </ul>
    </div>
    <div class="footer-column">
      <h3>ZAYNO</h3>
      <ul>
        <li><a href="#">About ZAYNO</a></li>
        <li><a href="#">Careers</a></li>
        <li><a href="#">ZAYNO Stores</a></li>
        <li><a href="#">ZAYNO Blog</a></li>
        <li><a href="#">Terms & Conditions</a></li>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">PayLater Edu</a></li>
        <li><a href="#">Code of Conduct</a></li>
        <li><a href="#">Join the ZAYNO Affiliate Program</a></li>
      </ul>
    </div>
    
            <div class="contact" id="contact-info">
                <h3>Contact Information</h3>
                <p><img src="images/email.png" alt="email" /> support@onlineshop.com</p>
                <p><img src="images/phone.png" alt="phone" /> +94 (76) 3951645</p>
                <p><img src="images/address.png" alt="address" />173 Niriella Rd, Karawita, Uda Karawita</p>
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
            <p>&copy; <?php echo date("Y"); ?> [ZAYNO] All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

<?php
$conn->close();
?>