<?php
// SecondBanner_delete_review.php
include 'SecondBanner_config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $review_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM SecondBannerReview WHERE id = ?");
    $stmt->bind_param("i", $review_id);

    if ($stmt->execute()) {
        $status = 'success';
    } else {
        $status = 'error';
        error_log("Error deleting review: " . $stmt->error); // Log the error
    }
    $stmt->close();
    $conn->close();

    header("Location: SecondBanner_view_reviews.php?delete_status=" . $status);
    exit();
} else {
    header("Location: SecondBanner_view_reviews.php?delete_status=error&message=Invalid review ID.");
    exit();
}
?>