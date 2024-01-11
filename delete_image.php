<?php
// Database connection file
include('config.php');

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the index page
    header('Location: index.html');
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $imageId = $_POST['image_id'];
    $userId = $_SESSION['user_id'];

    // Check if the image belongs to the logged-in user
    $checkOwnershipQuery = "SELECT user_id FROM images WHERE id = ?";

    $stmt = mysqli_prepare($conn, $checkOwnershipQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $imageId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ownerId);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($ownerId === $userId) {
            // Delete the image and associated data from the database
            $deleteImageQuery = "DELETE FROM images WHERE id = ?";
            $deleteCommentsQuery = "DELETE FROM comments WHERE image_id = ?";

            $stmtImage = mysqli_prepare($conn, $deleteImageQuery);
            $stmtComments = mysqli_prepare($conn, $deleteCommentsQuery);

            if ($stmtImage && $stmtComments) {
                mysqli_stmt_bind_param($stmtImage, "i", $imageId);
                mysqli_stmt_bind_param($stmtComments, "i", $imageId);

                $resultImage = mysqli_stmt_execute($stmtImage);
                $resultComments = mysqli_stmt_execute($stmtComments);

                mysqli_stmt_close($stmtImage);
                mysqli_stmt_close($stmtComments);

                if ($resultImage && $resultComments) {
                    // Image and associated comments deleted successfully
                    header('Location: portfolio.php'); // Redirect to the portfolio page
                    exit;
                } else {
                    // Handle deletion errors
                    echo "Error deleting image or comments: " . mysqli_error($conn);
                }
            } else {
                // Handle prepared statement errors
                echo "Error preparing statements: " . mysqli_error($conn);
            }
        } else {
            // Image does not belong to the logged-in user
            echo "Unauthorized access.";
        }
    } else {
        // Handle prepared statement error
        echo "Error preparing statement: " . mysqli_error($conn);
    }
} else {
    // Invalid request method
    echo "Invalid request.";
}
?>
