<?php
include 'firstBanner_db_connect.php'; // Connect to the database where 'orders' table resides

$sql_orders = "SELECT * FROM orders ORDER BY order_date DESC";
$result_orders = $conn->query($sql_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - View Orders</title>
    <link rel="stylesheet" href="firstBanner_style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Admin Panel - Orders</h1>
            <nav>
                <ul>
                    <li><a href="firstBanner_products.php">Shop</a></li>
                    <li><a href="firstBanner_admin.php">Manage Products</a></li>
                    <li><a href="firstBanner_admin_orders.php">View Orders</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container admin-panel">
        <h2>Customer Orders</h2>
        <?php if ($result_orders->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Shipping Address</th>
                        <th>Total Amount</th>
                        <th>Order Date</th>
                        <th>Payment Status</th>
                        <th>Payment Method</th>
                        <th>Card Last 4</th>
                        <th>Order Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($order = $result_orders->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['user_email']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></td>
                            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
                            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($order['card_last_four']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                            <td>
                                <button class="view-order-details-btn" data-order-id="<?php echo $order['order_id']; ?>">View Items</button>
                            </td>
                        </tr>
                        <tr id="order-items-<?php echo $order['order_id']; ?>" class="order-items-row" style="display: none;">
                            <td colspan="11">
                                <div class="order-items-details">
                                    <h4>Items for Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h4>
                                    <table class="nested-table">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Price Per Item</th>
                                                <th>Size</th>
                                                <th>Color</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql_items = "SELECT product_name, quantity, price_per_item, selected_size, selected_color FROM order_items WHERE order_id = " . $order['order_id'];
                                            $result_items = $conn->query($sql_items);
                                            if ($result_items->num_rows > 0) {
                                                while($item = $result_items->fetch_assoc()) {
                                                    echo '<tr>';
                                                    echo '<td>' . htmlspecialchars($item['product_name']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
                                                    echo '<td>$' . number_format($item['price_per_item'], 2) . '</td>';
                                                    echo '<td>' . htmlspecialchars($item['selected_size']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($item['selected_color']) . '</td>';
                                                    echo '</tr>';
                                                }
                                            } else {
                                                echo '<tr><td colspan="5">No items found for this order.</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders placed yet.</p>
        <?php endif; ?>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Global Deals. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.querySelectorAll('.view-order-details-btn').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.dataset.orderId;
                const detailsRow = document.getElementById(`order-items-${orderId}`);
                if (detailsRow.style.display === 'none') {
                    detailsRow.style.display = 'table-row';
                    this.textContent = 'Hide Items';
                } else {
                    detailsRow.style.display = 'none';
                    this.textContent = 'View Items';
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>