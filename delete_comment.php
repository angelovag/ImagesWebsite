<?php
// Database connection file
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the comment_id is set
    if (isset($_POST['id'])) {
        $comment_id = $_POST['id'];

        // Perform deletion query
        $deleteQuery = "DELETE FROM comments WHERE comment_id = '$comment_id'";
        $result = mysqli_query($conn, $deleteQuery);

        if ($result) {
            // Deletion successful
            header("Location: image_details_admin.php?id=$imageId"); // Redirect back to the image details page
            exit;
        } else {
            // Error in deletion
            echo "Error deleting comment. Please try again.";
        }
    } else {
        // comment_id not set
        echo "Invalid request.";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
}

// Close the database connection
mysqli_close($conn);
?>
