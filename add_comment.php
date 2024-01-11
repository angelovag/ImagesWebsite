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

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $image_id = $_POST['image_id'];
    $comment_text = $_POST['comment'];
    $currentDate = date("Y-m-d");

    // Insert the comment into the database
    $insertCommentQuery = "INSERT INTO comments (user_id, image_id, comment_text, comment_date) VALUES ('$user_id', '$image_id', '$comment_text', '$currentDate')";
    $result = mysqli_query($conn, $insertCommentQuery);

    if ($result) {
        echo "Comment added successfully!";
        // Redirect the user to another page after a delay
        header("refresh:5;url=potfolio.php");
    } else {
        echo "Error adding comment: " . mysqli_error($conn);
    }
}

?>
