<?php
//session_start();
//if (!isset($_SESSION['user_id'])) {
   // header("Location: login.html");
   // exit;
// Start the session at the very beginning of the script
session_start();

// Check if the user is logged in (i.e., if 'username' is set in the session)
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
// User is logged in, get their full name from the session
$loggedInFullName = $_SESSION['username']; // You might also want the username
$loggedInuser_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Account - My Orders</title>
    <link rel="stylesheet" href="UserAccount/style.css">
    <link rel="stylesheet" href="footer/style.css">
</head>
<body>


    <section class="about-hero">
            <h2>Hello, <?php echo htmlspecialchars($loggedInFullName); ?></h2>
        </section>
    <div class="page-wrapper">
        <!-- Breadcrumbs section -->
        <nav class="breadcrumbs">
            <span><a href="Home.html">Home</a></span> &gt; <span>My account</span> &gt; <span>My orders</span>
        </nav>
        <div class="account-container">
            <!-- Sidebar navigation -->
            <aside class="sidebar">
                <nav>              
                    <ul>
                        <li><a href="#" class="active">My orders</a></li>
                        <li><a href="addresses.php">My addresses</a></li>
                        <li><a href="logout.php">Logout</a></li>
                        </ul>
                </nav>
            </aside>

            <!-- Main content area -->
            <main class="content-area">
                <h1>My orders</h1>

                <div class="orders-section">
                    <?php if (empty($userOrders)): ?>
                        <!-- Display when there are no orders -->
                        <div class="no-orders-state">
                            <!-- SVG icon for the package -->
                            <svg class="package-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect>
                                <path d="M12 7V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v3"></path>
                                <path d="M2 7h20"></path>
                                <path d="M12 7v3"></path>
                                <circle cx="18" cy="9" r="2" fill="#ef4444" stroke="none"/> <!-- Small red circle for notification -->
                                <text x="18" y="10" font-family="Arial" font-size="10" fill="white" text-anchor="middle" alignment-baseline="middle">!</text>
                            </svg>
                            <p class="no-orders-text">No orders yet</p>
                            <button class="make-order-button" onclick="window.location.href='Home.html'">Make your first order</button>
                        </div>
                    <?php else: ?>
                        <!-- Display when orders exist (placeholder for future expansion) -->
                        <div class="has-orders-state">
                            <p>Here are your orders, <?php echo htmlspecialchars($userName); ?>:</p>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($userOrders as $order): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                            <td><?php echo htmlspecialchars($order['date']); ?></td>
                                            <td>$<?php echo number_format($order['total'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
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
        <li><a href="About/About.html">About US</a></li>
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

    <!-- Link to the custom JavaScript file -->
    <script src="UserAccount/script.js"></script>
</body>
</html>


