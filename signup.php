<?php

// Database connection file
include("config.php");

// Start a session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $error_message_name = "";    
    $error_message_email = "";
    $error_message_password = "";

    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role_id = $_POST["role-id"];


    // Validate input
    if (empty($name)) {
        $error_message_name = "Името е задължително.";
    } elseif (!preg_match("/^[A-Za-zА-Яа-яЁё]+$/u", $name)) {
        $error_message_name = "Името трябва да съдържа само букви.";
    } elseif (mb_strlen($name, 'utf-8') < 2 || mb_strlen($name, 'utf-8') > 50) {
        $error_message_name = "Дължината на името трябва да бъде между 2 и 50 знака.";
    }


    if (empty($email)) {
        $error_message_email = "Email е задължителен.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message_email = "Невалиден формат на email.";
    } else {
    // Email is valid
    }

    if (empty($password)) {
        $error_message_password = "Паролата е задължителен.";
    } elseif (strlen($password) < 6) {
        $error_message_password = "Паролата трябва да е с дължина поне 6 знака.";
    } elseif (!preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $error_message_password = "Паролата трябва да съдържа поне една главна буква, една малка буква и една цифра.";
    } else {
    // Password is valid
    }

    // Insert user data
    $sql = "INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $password, $role_id);

    // Display validation errors
    if (!empty($error_message_name) || !empty($error_message_email) || !empty($error_message_password)) {
        // echo '<div style="color: red;">';
        if (!empty($error_message_name)) {
            echo $error_message_name . '<br>';
        }
        if (!empty($error_message_email)) {
            echo $error_message_email . '<br>';
        }
        if (!empty($error_message_password)) {
            echo $error_message_password . '<br>';
        }
    } else {
        // If there are no validation errors, proceed with the query execution
        if ($stmt->execute()) {

            //Store user information in the session
            $_SESSION["user_id"] = $stmt->insert_id;
            $_SESSION["name"] = $name;

            header("Location: signup-success.php");
            exit;
        } else {
            // There was an error in the query execution
            echo "Error inserting data: " . $conn->error;
        }
    }

    $conn->close();
}

?>