<?php
// SecondBanner_admin.php
include 'SecondBanner_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SecondBanner</title>
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
                    <li><a href="AdminHome.html">Home</a></li>
                    <li><a href="SecondBanner_index.php">View Store</a></li>
                    <li><a href="SecondBanner_admin.php">Manage Products</a></li>
                    <li><a href="SecondBanner_view_orders.php">View Orders</a></li> <!-- ADD THIS LINE -->
                    <li><a href="SecondBanner_view_reviews.php">Manage Reviews</a></li> <!-- ADD THIS LINE -->
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="admin-panel">
            <h2>Manage Products</h2>
            <a href="SecondBanner_add_product.php" class="add-product-btn">Add New Product</a>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Discount (%)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM SecondBanner ORDER BY id DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["id"]); ?></td>
                            <td><img src="<?php echo htmlspecialchars($row["image_url"]); ?>" alt="<?php echo htmlspecialchars($row["name"]); ?>"></td>
                            <td><?php echo htmlspecialchars($row["name"]); ?></td>
                            <td>Rs.<?php echo number_format($row["price"], 2); ?></td>
                            <td><?php echo htmlspecialchars($row["discount_percentage"]); ?></td>
                            <td class="admin-actions">
                                <a href="SecondBanner_edit_product.php?id=<?php echo $row["id"]; ?>" class="edit-btn">Edit</a>
                                <a href="SecondBanner_delete_product.php?id=<?php echo $row["id"]; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>No products found in the database.</td></tr>";
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