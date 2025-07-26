<?php
include 'firstBanner_db_connect.php';

$message = '';

// Handle Add/Edit Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_product'])) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $image_url = $_POST['image_url'];
    $stock_quantity = intval($_POST['stock_quantity']);
    // Available Colors
    $available_colors_input = $_POST['available_colors'];
    $colors_array = array_map('trim', explode(',', $available_colors_input));
    $available_colors_json = json_encode($colors_array);

    // නව එකතු කිරීම: Available Sizes
    $available_sizes_input = $_POST['available_sizes'];
    // Comma-separated string එකක් JSON Array එකකට පරිවර්තනය කිරීම
    $sizes_array = array_map('trim', explode(',', $available_sizes_input));
    $available_sizes_json = json_encode($sizes_array); // JSON format එකට encode කිරීම

    if ($id > 0) {
        // Update product
        $stmt = $conn->prepare("UPDATE firstBanner SET product_name=?, description=?, price=?, image_url=?, stock_quantity=?, available_colors=?, available_sizes=? WHERE id=?");
        //                        ^ note 's' for available_colors_json and available_sizes_json
        $stmt->bind_param("ssdsissi", $product_name, $description, $price, $image_url, $stock_quantity, $available_colors_json, $available_sizes_json, $id);
        if ($stmt->execute()) {
            $message = "Product updated successfully!";
        } else {
            $message = "Error updating product: " . $conn->error;
        }
        $stmt->close();
    } else {
        // Add new product
        $stmt = $conn->prepare("INSERT INTO firstBanner (product_name, description, price, image_url, stock_quantity, available_colors, available_sizes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        //                        ^ note 's' for available_colors_json and available_sizes_json
        $stmt->bind_param("ssdsiss", $product_name, $description, $price, $image_url, $stock_quantity, $available_colors_json, $available_sizes_json);
        if ($stmt->execute()) {
            $message = "Product added successfully!";
        } else {
            $message = "Error adding product: " . $conn->error;
        }
        $stmt->close();
    }
}

// Handle Delete Product
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM firstBanner WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $message = "Product deleted successfully!";
    } else {
        $message = "Error deleting product: " . $conn->error;
    }
    $stmt->close();
    header("Location: firstBanner_admin.php"); // Redirect to refresh the page after deletion
    exit();
}

// Fetch all products for display
$sql = "SELECT * FROM firstBanner ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Global Deals</title>
    <link rel="stylesheet" href="firstBanner_style.css">
    <link rel="stylesheet" href="footer/style.css">
    <style>
        header {
            background-color: #343a40; /* Orange from the banner */
            color: white;
            padding: 10px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
        .container {
            background-color:  #343a40;
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
}
        .admin-panel {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

        .admin-panel h2, .admin-panel h3 {
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
}
.admin-panel .message {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    text-align: center;
}

.product-form {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
    margin-bottom: 40px;
    padding: 20px;
    border: 1px solid #eee;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.product-form label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

.product-form input[type="text"],
.product-form input[type="number"],
.product-form textarea {
    width: calc(100% - 20px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
}

.product-form textarea {
    min-height: 80px;
    resize: vertical;
}

.product-form button {
    background-color:#343a40;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.2s;
    margin-right: 10px;
}

.product-form button[type="button"] {
    background-color: #6c757d; /* Gray for clear button */
}

.product-form button:hover {
    background-color: #e65c00;
}
.product-form button[type="button"]:hover {
    background-color: #5a6268;
}


.product-list table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.product-list th, .product-list td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.product-list th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.product-list .admin-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.product-list .edit-btn, .product-list .delete-btn {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 4px;
    text-decoration: none;
    color: white;
    cursor: pointer;
    margin-right: 5px;
    font-size: 0.9em;
}

.product-list .edit-btn {
    background-color: #343a40; /* Blue for edit */
}

.product-list .edit-btn:hover {
    background-color:rgb(1, 44, 90);
}

.product-list .delete-btn {
    background-color: #dc3545; /* Red for delete */
}

.product-list .delete-btn:hover {
    background-color: #c82333;
}



</style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Admin Panel</h1>
            <p>Manage Global Discounted Products</p>
            <nav>
                <ul>
                    <li><a href="firstBanner_products.php">Shop</a></li>                   
                    <li><a href="AdminHome.html">Dashboard</a></li> </ul>
            </nav>
        </div>
    </header>

    <main class="container admin-panel">
        <h2>Manage Products</h2>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <h3>Add/Edit Product</h3>
        <form action="firstBanner_admin.php" method="POST" class="product-form">
            <input type="hidden" name="id" id="product_id">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="image_url">Image URL:</label>
            <input type="text" id="image_url" name="image_url" placeholder="e.g., images/firstBanner_pink_dress.jpg">

            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" id="stock_quantity" name="stock_quantity" required>

            <label for="available_colors">Available Colors:</label>
            <input type="text" id="available_colors" name="available_colors" placeholder="e.g., Red, Blue, Green">

            <label for="available_sizes">Available Sizes:</label>
            <input type="text" id="available_sizes" name="available_sizes" placeholder="e.g., S, M, L, XL">

            <button type="submit" name="submit_product">Save Product</button>
            <button type="button" onclick="clearForm()">Clear Form</button>
        </form>

        <h3>Current Products</h3>
        <div class="product-list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Colors</th>
                        <th>Sizes</th>
                        <th>Image</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
                            echo '<td>' . htmlspecialchars($row["product_name"]) . '</td>';
                            echo '<td>$' . number_format($row["price"], 2) . '</td>';
                            echo '<td>' . htmlspecialchars($row["stock_quantity"]) . '</td>';
                            echo '<td>';
                            $colors_from_db = json_decode($row["available_colors"], true);
                            if (is_array($colors_from_db) && !empty($colors_from_db)) {
                                echo implode(', ', array_map('htmlspecialchars', $colors_from_db));
                            } else {
                                echo 'N/A';
                            }
                            echo '</td>';
                            echo '<td>';
                                    // JSON string එක PHP array එකකට convert කිරීම
                                    $sizes_from_db = json_decode($row["available_sizes"], true);
                                    if (is_array($sizes_from_db) && !empty($sizes_from_db)) {
                                        echo implode(', ', array_map('htmlspecialchars', $sizes_from_db));
                                    } else {
                                        echo 'N/A';
                                    }
                            echo '</td>';
                            // මෙතනින් ඉහළට අලුත් කේතය නිවැරදිව එකතු කළා
                            echo '<td><img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '" class="admin-thumbnail"></td>';
                            echo '<td>';
                            echo '<button class="edit-btn" onclick="editProduct(' . htmlspecialchars(json_encode($row)) . ')">Edit</button>';                            
                            echo '<a href="firstBanner_admin.php?delete_id=' . $row["id"] . '" onclick="return confirm(\'Are you sure you want to delete this product?\')" class="delete-btn">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6">No products found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> [ZAYNO] All rights reserved.</p>
        </div>
    </footer>

    <script>
        function editProduct(product) {
            document.getElementById('product_id').value = product.id;
            document.getElementById('product_name').value = product.product_name;
            document.getElementById('description').value = product.description;
            document.getElementById('price').value = product.price;
            document.getElementById('image_url').value = product.image_url;
            document.getElementById('stock_quantity').value = product.stock_quantity;
            if (product.available_colors) {
                // JSON string එක JavaScript array එකකට convert කර, comma-separated string එකක් ලෙස පෙන්වීම
                const colorsArray = JSON.parse(product.available_colors);
                document.getElementById('available_colors').value = colorsArray.join(', ');
            } else {
                document.getElementById('available_colors').value = '';
            }
            // නව එකතු කිරීම: sizes field එක update කිරීමට
            if (product.available_sizes) {
                const sizesArray = JSON.parse(product.available_sizes);
                document.getElementById('available_sizes').value = sizesArray.join(', ');
            } else {
                document.getElementById('available_sizes').value = '';
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        
        }

        function clearForm() {
            document.getElementById('product_id').value = '';
            document.getElementById('product_name').value = '';
            document.getElementById('description').value = '';
            document.getElementById('price').value = '';
            document.getElementById('image_url').value = '';
            document.getElementById('stock_quantity').value = '';
            document.getElementById('available_colors').value = ''; // Clear colors field
            document.getElementById('available_sizes').value = ''; // Clear sizes field
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>