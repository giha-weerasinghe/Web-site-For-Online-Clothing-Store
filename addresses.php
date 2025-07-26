<?php
session_start(); // Start the session for managing user data

// --- User Authentication Simulation ---
// In a real application, the user_id would be securely set upon successful login.
// For demonstration, we'll set a dummy user_id if not already set.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // Dummy user ID for testing
    // In production, if $_SESSION['user_id'] is not set, you should redirect to login.
    // header('Location: login.php');
    // exit();
}
// Start the session at the very beginning of the script

// Check if the user is logged in (i.e., if 'username' is set in the session)
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
 // Start session to get user details later

// Dummy user data for demonstration
// In a real application, you would fetch this from your database after user login
// From users table
$user_address = ""; // From users table, or specific address table
// This page would typically allow editing and saving the address.
// For this scenario, we just provide the data.

// User is logged in, get their full name from the session
$loggedInFullName = $_SESSION['username']; // You might also want the username
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - My Addresses</title>
    <!-- Link to the custom CSS file -->
    <link rel="stylesheet" href="Address/style.css">
    <link rel="stylesheet" href="footer/style.css">
</head>
<body>
    <section class="about-hero">
            <h2>Hello, <?php echo htmlspecialchars($loggedInFullName); ?></h2>
        </section>
    <div class="page-wrapper">
      <div class="page-wrapper">
        <!-- Breadcrumbs section -->
        <nav class="breadcrumbs">
            <span><a href="Home.html"> Home</a></span> &gt; <span><a href="dashboard.php"> My account</a></span> &gt; <span>My addresses</span>
        </nav>

        <div class="account-container">
            <!-- Sidebar navigation -->
            <aside class="sidebar">
                <nav>
                    <ul>
                        <li><a href="dashboard.php">My orders</a></li>
                        <li><a href="addresses.php" class="active">My addresses</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Main content area -->
            <main class="content-area">
                <div class="header-with-button">
                    <h1>My addresses (<span id="addressCount">0</span>)</h1>
                    <button class="add-new-address-button" id="addNewAddressButton">Add a new address</button>
                </div>

                <div class="addresses-list" id="addressesList">
                    <!-- Addresses will be loaded here by JavaScript -->
                    <div class="no-addresses-state">
                        <p>Loading addresses...</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add/Edit Address Modal -->
    <div id="addressModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 id="modalTitle">Add New Address</h2>
            <form id="addressForm">
                <input type="hidden" id="addressId" name="id">
                <label for="fullName">Full Name:</label>
                <input type="text" id="fullName" name="name" required>

                <label for="streetAddress">Street Address:</label>
                <input type="text" id="streetAddress" name="street" required>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>

                <label for="zipCode">Zip/Postal Code:</label>
                <input type="text" id="zipCode" name="zip" required>

                <label for="country">Country:</label>
                <input type="text" id="country" name="country" required>

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>

                <div class="checkbox-group">
                    <input type="checkbox" id="isDefault" name="is_default" value="true">
                    <label for="isDefault">Set as default address</label>
                </div>
                
                <button type="submit" id="saveAddressButton">Save Address</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content small-modal">
            <span class="close-button">&times;</span>
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this address?</p>
            <div class="modal-actions">
                <button id="confirmDeleteButton" class="confirm-delete">Delete</button>
                <button id="cancelDeleteButton" class="cancel-delete">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Success/Error Message Box -->
    <div id="messageBox" class="message-box"></div>

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
    <script src="Address/script.js"></script>
</body>
</html>
