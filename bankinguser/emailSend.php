<?php

// include "./../vendor/PHPMailer/PHPMailer";
require_once('include/DB.php');
require_once('include/function.php');
require_once('include/session.php');

function emailSend($from) {
    global $con;
    try {
        $subject = "OctoPrime e-Banking";
        $headers =  "noreply@gmail.com";
        $body = "<h2>Account Created Successfully.</h2>";
        $result = mail($headers,$from, $subject, $body);
        if ($result) {
            $_SESSION['success_message'] = "Mail Send Success";
        } else {
            $_SESSION['error_message'] = "Something Wrong! Try again.";
        }
    }
    catch (PDOException $e) {
        $_SESSION['error_message'] = "Something Wrong! Try again.";
    }
}
?>