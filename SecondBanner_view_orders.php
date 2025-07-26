<?php
// SecondBanner_view_orders.php
include 'SecondBanner_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - SecondBanner Admin</title>
    <link rel="stylesheet" href="SecondBanner.css">
    <style>
        /* Header */
header {
    background-color: #343a40;
    color: white;
    padding: 15px 0;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 2em;
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 10px 0 0;
    display: flex;
    justify-content: center;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

nav ul li a:hover {
    text-decoration: underline;
}
/* Footer */
footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 20px 0;
    margin-top: 30px;
    margin-bottom: 0;
}
/* Admin Page */
.admin-panel {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.admin-panel h2 {
    color: #343a40;
    margin-bottom: 25px;
}

.admin-panel .add-product-btn {
    background-color: #343a40;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    margin-bottom: 20px;
    transition: background-color 0.3s ease;
}

.admin-panel .add-product-btn:hover {
    background-color: #0d0d0d;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.admin-table th,
.admin-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.admin-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.admin-table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
}

.admin-actions a {
    display: inline-block;
    margin-right: 10px;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 3px;
}

.admin-actions .edit-btn {
    background-color:  #343a40;
    color: #fff;
}

.admin-actions .edit-btn:hover {
    background-color:rgb(0, 30, 59);    
}

.admin-actions .delete-btn {
    background-color: #dc3545;
    color: white;
}

.admin-actions .delete-btn:hover {
    background-color: #c82333;
}
</style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Admin Panel</h1>
            <nav>
                <ul>
                    <li><a href="SecondBanner_index.php">View Store</a></li>
                    <li><a href="SecondBanner_admin.php">Manage Products</a></li>
                    <li><a href="SecondBanner_view_orders.php">View Orders</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="admin-panel">
            <h2>Customer Orders</h2>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order Ref ID</th>
                        <th>Product Name</th>
                        <th>Price (at order)</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Color</th> 
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, order_reference_id, product_id, product_name, product_price, quantity, customer_name, customer_email, order_date, selected_size, selected_color FROM SecondBannerOrder ORDER BY order_date DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["order_reference_id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["product_name"]); ?></td>
                            <td>Rs.<?php echo number_format($row["product_price"], 2); ?></td>
                            <td><?php echo htmlspecialchars($row["quantity"]); ?></td>
                            <td><?php echo htmlspecialchars($row["selected_size"] ?: 'N/A'); ?></td>
                             <td><?php echo htmlspecialchars($row["selected_color"] ?: 'N/A'); ?></td> 
                            <td><?php echo htmlspecialchars($row["customer_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["customer_email"]); ?></td>
                            <td><?php echo htmlspecialchars($row["order_date"]); ?></td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No orders found yet.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> [ZAYNO] Admin Panel.</p>
        </div>
    </footer>
</body>
</html>