<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $messageContent = $_POST["message"];

    $error_message_name = "";
    $error_message_email = "";    
    $error_message_content = "";


    if (empty($name)) {
        $error_message_name = "Името е задължително.";
    } else {
        // First name is valid
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message_email = "Невалиден email address.";
    } else {
        // Email is valid
    }

    if (empty($messageContent)) {
        $error_message_content = "Съобщението е задължително.";
    } else {
        // Message is valid
    }

    // Display validation errors
    if (!empty($error_message_name) || !empty($error_message_email) || !empty($error_message_content)) {
        // echo '<div style="color: red;">';
        if (!empty($error_message_name)) {
            echo $error_message_name . '<br>';
        }
        if (!empty($error_message_email)) {
            echo $error_message_email . '<br>';
        }
        if (!empty($error_message_content)) {
            echo $error_message_content . '<br>';
        }
    } else {

        $to       = 'gerganaangelova1994@gmail.com';
        $subject  = 'New Inquiry: Images';

        // Construct the message by concatenating the values
        $message = "<p><strong>Name:</strong> $name</p>";
        $message .= "<p><strong>Email:</strong> $email</p>";
        $message .= "<p><strong>Message:</strong> $messageContent</p>";

        $headers  = 'From: [your_gmail_account_username]@gmail.com' . "\r\n" .
                    'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=utf-8';
                        
        if(mail($to, $subject, $message, $headers)) {
            header("Location: contact-success.php");
        }else{
            echo "Email sending failed";
        }
    }
}

?>