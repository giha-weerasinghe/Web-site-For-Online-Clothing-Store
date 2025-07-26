<?php
// SecondBanner_edit_product.php
include 'SecondBanner_config.php';

$product = null;
$message = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, description, price, image_url, discount_percentage, stock_quantity, available_sizes, available_colors FROM SecondBanner WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        $message = "Product not found!";
    }
    $stmt->close();
} else {
    header("Location: SecondBanner_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $product) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount_percentage = $_POST['discount_percentage'];
    $image_url = $product['image_url']; // Keep existing image by default

    // Handle new image upload if provided
    if (isset($_FILES["image_url"]) && $_FILES["image_url"]["error"] == 0) {
        $target_dir = "images/";
        $image_file_name = basename($_FILES["image_url"]["name"]);
        $new_target_file = $target_dir . $image_file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($new_target_file, PATHINFO_EXTENSION));

        // Check file type, size, etc. (similar to add_product.php)
        $check = getimagesize($_FILES["image_url"]["tmp_name"]);
        if($check === false) { $message .= "File is not an image.<br>"; $uploadOk = 0; }
        if ($_FILES["image_url"]["size"] > 5000000) { $message .= "Sorry, your file is too large (max 5MB).<br>"; $uploadOk = 0; }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) { $message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>"; $uploadOk = 0; }

        if ($uploadOk == 1) {
            // Delete old image if it's not the default placeholder
            if ($product['image_url'] && file_exists($product['image_url']) && $product['image_url'] != 'images/default.jpg') {
                unlink($product['image_url']);
            }
            if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $new_target_file)) {
                $image_url = $new_target_file;
            } else {
                $message .= "Sorry, there was an error uploading your new file.<br>";
            }
        }
    }

    // Update product in database
    $stock_quantity = $_POST['stock_quantity'];
    $available_sizes = $_POST['available_sizes'];
    $available_colors = $_POST['available_colors'];

    // Update product in database
    $stmt = $conn->prepare("UPDATE SecondBanner SET name = ?, description = ?, price = ?, image_url = ?, discount_percentage = ?, stock_quantity = ?, available_sizes = ?, available_colors = ? WHERE id = ?");
    $stmt->bind_param("ssdssiisi", $name, $description, $price, $image_url, $discount_percentage, $stock_quantity, $available_sizes, $available_colors, $product_id);

    if ($stmt->execute()) {
        $message = "Product updated successfully!";
        // Refresh product data after update
        $stmt_refresh = $conn->prepare("SELECT * FROM SecondBanner WHERE id = ?");
        $stmt_refresh->bind_param("i", $product_id);
        $stmt_refresh->execute();
        $result_refresh = $stmt_refresh->get_result();
        $product = $result_refresh->fetch_assoc();
        $stmt_refresh->close();
    } else {
        $message = "Error updating product: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - SecondBanner Admin</title>
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
    background-color: #ffc107;
    color: #333;
}

.admin-actions .edit-btn:hover {
    background-color: #e0a800;
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
            <h1>Edit Product</h1>
            <nav>
                <ul>
                    <li><a href="SecondBanner_index.php">View Store</a></li>
                    <li><a href="SecondBanner_admin.php">Manage Products</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="admin-panel">
            <h2>Edit Product</h2>
            <?php if ($message): ?>
                <p style="color: <?php echo strpos($message, 'Error') !== false ? 'red' : 'green'; ?>; font-weight: bold;"><?php echo $message; ?></p>
            <?php endif; ?>

            <?php if ($product): ?>
            <form action="SecondBanner_edit_product.php?id=<?php echo htmlspecialchars($product['id']); ?>" method="POST" enctype="multipart/form-data" class="product-form">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($product['name']); ?>">

                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

                <label for="stock_quantity">Stock Quantity:</label>
                <input type="number" id="stock_quantity" name="stock_quantity" min="0" required value="<?php echo htmlspecialchars($product['stock_quantity']); ?>">

                <label for="available_sizes">Available Sizes (e.g., S,M,L):</label>
                <input type="text" id="available_sizes" name="available_sizes" value="<?php echo htmlspecialchars($product['available_sizes']); ?>">

                <label for="available_colors">Available Colors (e.g., Red,Blue,Green):</label>
                <input type="text" id="available_colors" name="available_colors" value="<?php echo htmlspecialchars($product['available_colors']); ?>">

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required value="<?php echo htmlspecialchars($product['price']); ?>">

                <label for="discount_percentage">Discount Percentage (0-100):</label>
                <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" value="<?php echo htmlspecialchars($product['discount_percentage']); ?>">

                <label>Current Image:</label>
                <?php if ($product['image_url']): ?>
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Current Product Image" style="width: 150px; height: 150px; object-fit: cover; margin-bottom: 15px; border-radius: 5px;">
                <?php else: ?>
                    <p>No image available.</p>
                <?php endif; ?>
                <label for="image_url">Upload New Image (optional):</label>
                <input type="file" id="image_url" name="image_url" accept="image/*">

                <button type="submit">Update Product</button>
            </form>
            <?php else: ?>
                <p>Product data not found for editing.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> [ZAYNO] Admin Panel.</p>
        </div>
    </footer>
</body>
</html>