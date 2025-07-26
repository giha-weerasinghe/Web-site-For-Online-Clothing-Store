<?php
// SecondBanner_submit_review.php
include 'SecondBanner_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $reviewer_name = htmlspecialchars(trim($_POST['reviewer_name']));
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $review_text = htmlspecialchars(trim($_POST['review_text']));

    // Basic validation
    if ($product_id > 0 && !empty($reviewer_name) && $rating >= 1 && $rating <= 5) {
        $stmt = $conn->prepare("INSERT INTO SecondBannerReview (product_id, reviewer_name, rating, review_text) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $product_id, $reviewer_name, $rating, $review_text);

        if ($stmt->execute()) {
            $status = 'success';
        } else {
            $status = 'error';
            error_log("Error submitting review: " . $stmt->error); // Log the error for debugging
        }
        $stmt->close();
    } else {
        $status = 'error';
        error_log("Invalid review submission data.");
    }
    $conn->close();

    // Redirect back to the product page with status
    header("Location: SecondBanner_product.php?id=" . $product_id . "&review_status=" . $status);
    exit();
} else {
    // If accessed directly without POST data, redirect to home or product page
    header("Location: SecondBanner_index.php");
    exit();
}
?>