<?php

// Database connection file
include("config.php");

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT user_id, name, email FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // User found, retrieve user ID and store in the session
        $stmt->bind_result($user_id, $name, $user_email);
        $stmt->fetch();

        $_SESSION['user_id'] = $user_id;
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $user_email;


        // Redirect to user homepage
        header("Location: welcome.php");
        exit;
        } else {
            // User not found or incorrect password
            echo "Invalid or empty credentials. Please try again.";
        }

    $stmt->close();
}

?>
