<?php
// SecondBanner_add_product.php
include 'SecondBanner_config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount_percentage = $_POST['discount_percentage'];

    // Handle image upload
    $target_dir = "images/";
    $image_file_name = basename($_FILES["image_url"]["name"]);
    $target_file = $target_dir . $image_file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image_url"]["tmp_name"]);
    if($check !== false) {
        // file is an image
    } else {
        $message .= "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check file size (e.g., 5MB limit)
    if ($_FILES["image_url"]["size"] > 5000000) {
        $message .= "Sorry, your file is too large (max 5MB).<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $message .= "Sorry, your file was not uploaded.<br>";
    } else {
        if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
            // Insert product into database
            $stock_quantity = $_POST['stock_quantity'];
            $available_sizes = $_POST['available_sizes'];
            $available_colors = $_POST['available_colors'];

            $stmt = $conn->prepare("INSERT INTO SecondBanner (name, description, price, image_url, discount_percentage, stock_quantity, available_sizes, available_colors) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssiss", $name, $description, $price, $target_file, $discount_percentage, $stock_quantity, $available_sizes, $available_colors);

            if ($stmt->execute()) {
                $message = "New product added successfully!";
                // Clear form fields if successful
                $_POST = array(); // Clears all POST data
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message .= "Sorry, there was an error uploading your file.<br>";
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - SecondBanner Admin</title>
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
</style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Add New Product</h1>
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
            <h2>Add Product</h2>
            <?php if ($message): ?>
                <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="SecondBanner_add_product.php" method="POST" enctype="multipart/form-data" class="product-form">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">

                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>

                <label for="stock_quantity">Stock Quantity:</label>
                <input type="number" id="stock_quantity" name="stock_quantity" min="0" required value="<?php echo isset($_POST['stock_quantity']) ? htmlspecialchars($_POST['stock_quantity']) : '0'; ?>">

                <label for="available_sizes">Available Sizes (e.g., S,M,L):</label>
                <input type="text" id="available_sizes" name="available_sizes" value="<?php echo isset($_POST['available_sizes']) ? htmlspecialchars($_POST['available_sizes']) : ''; ?>">

                <label for="available_colors">Available Colors (e.g., Red,Blue,Green):</label>
                <input type="text" id="available_colors" name="available_colors" value="<?php echo isset($_POST['available_colors']) ? htmlspecialchars($_POST['available_colors']) : ''; ?>">

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">

                <label for="discount_percentage">Discount Percentage (0-100):</label>
                <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" value="<?php echo isset($_POST['discount_percentage']) ? htmlspecialchars($_POST['discount_percentage']) : '0'; ?>">

                <label for="image_url">Product Image:</label>
                <input type="file" id="image_url" name="image_url" accept="image/*" required>

                <button type="submit">Add Product</button>
            </form>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> [ZAYNO] Admin Panel.</p>
        </div>
    </footer>
</body>
</html>