<?php
// SecondBanner_index.php
include 'SecondBanner_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZAYNO - More Deals</title>
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

                     
            </div>
            </nav>
    </header>
    <div class="banner-slide" style="background: linear-gradient(to right, #0044cc, #66ccff);">
        <img src="images/b2.png" alt="Global Deals Banner 2">
        <div class="banner-content">
            <h1>MORE DEALS</h1>
            <h2>DON'T MISS OUT</h2>
            <a href="SecondBanner_index.php"><button class="shop-now-button">Shop Now</button></a>
        </div>
    </div>


    <main class="container" id="product-listings">
        <h2>Our Latest Products</h2>
        <div class="product-grid">
            <?php
            $sql = "SELECT * FROM SecondBanner";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $original_price = $row["price"];
                    $discount_percentage = $row["discount_percentage"];
                    $discount_price = $original_price * (1 - $discount_percentage / 100);
            ?>
                <div class="product-item">
                    <img src="<?php echo htmlspecialchars($row["image_url"]); ?>" alt="<?php echo htmlspecialchars($row["name"]); ?>">
                    <h3><?php echo htmlspecialchars($row["name"]); ?></h3>
                    <p class="price">
                        <?php if ($discount_percentage > 0) { ?>
                            <span class="original-price">Rs.<?php echo number_format($original_price, 2); ?></span>
                            <span class="discount-price">Rs.<?php echo number_format($discount_price, 2); ?></span>
                            <span class="discount-tag">-<?php echo htmlspecialchars($discount_percentage); ?>%</span>
                        <?php } else { ?>
                            <span>$<?php echo number_format($original_price, 2); ?></span>
                        <?php } ?>
                    </p>
                    <a href="SecondBanner_product.php?id=<?php echo $row["id"]; ?>" class="view-details-btn">View Details</a>
                </div>
            <?php
                }
            } else {
                echo "<p>No products found.</p>";
            }
            $conn->close();
            ?>
        </div>
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

    <script src="SecondBanner.js"></script>
</body>
</html>