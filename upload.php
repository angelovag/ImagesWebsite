<?php
// Database connection file
include("config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    // File details
    $fileName = $_FILES["image"]["name"];
    $fileTmpName = $_FILES["image"]["tmp_name"];
    $fileSize = $_FILES["image"]["size"];
    $fileError = $_FILES["image"]["error"];

    // Directory of uploaded files
    $uploadDirectory = "uploads/";

    // Unique name of the uploaded file
    $newFileName = uniqid() . '_' . $fileName;

    // Check if the uploaded file is an image
    $imageInfo = getimagesize($fileTmpName);
    if ($imageInfo === false) {
        echo "Error: File is not an image.";
        exit;
    }

    $destination = $uploadDirectory . $newFileName;
    move_uploaded_file($fileTmpName, $destination);

    // Current date
    $currentDate = date("Y-m-d");

    // Get user ID from the session
    session_start();
    $user_id = $_SESSION["user_id"];

    // Insert file details into the database
    $sql = "INSERT INTO images (filename, upload_date, user_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $newFileName, $currentDate, $user_id);

    if ($stmt->execute()) {
        echo "File uploaded successfully!";
    } else {
        echo "Error uploading file: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
