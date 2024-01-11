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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the image_id is set
    if (isset($_POST['image_id'])) {
        $image_id = $_POST['image_id'];

        // Perform deletion query
        $deleteQuery = "DELETE FROM images WHERE id = '$image_id'";
        $result = mysqli_query($conn, $deleteQuery);

        if ($result) {
            // Deletion successful
            header("Location: delete-success.php");
            exit;
        } else {
            // Error in deletion
            echo "Error deleting image. Please try again.";
        }
    } else {
        // image_id not set
        echo "Invalid request.";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
}

// Close the database connection
mysqli_close($conn);
?>
