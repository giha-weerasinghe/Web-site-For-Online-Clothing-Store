<?php
// SecondBanner_delete_product.php
include 'SecondBanner_config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    // Get image URL before deleting product from DB
    $stmt_img = $conn->prepare("SELECT image_url FROM SecondBanner WHERE id = ?");
    $stmt_img->bind_param("i", $product_id);
    $stmt_img->execute();
    $result_img = $stmt_img->get_result();
    $image_row = $result_img->fetch_assoc();
    $image_to_delete = $image_row['image_url'] ?? null;
    $stmt_img->close();

    // Delete product from database
    $stmt = $conn->prepare("DELETE FROM SecondBanner WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        // Delete the image file from the server
        if ($image_to_delete && file_exists($image_to_delete)) {
            unlink($image_to_delete);
        }
        header("Location: SecondBanner_admin.php?message=Product deleted successfully!");
    } else {
        header("Location: SecondBanner_admin.php?message=Error deleting product: " . $stmt->error);
    }
    $stmt->close();
} else {
    header("Location: SecondBanner_admin.php?message=Invalid product ID.");
}
$conn->close();
exit();
?>