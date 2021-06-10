<?php

// include "./../vendor/PHPMailer/PHPMailer";
require_once('include/DB.php');
require_once('include/function.php');
require_once('include/session.php');


function emailSend($to,$c_id) {
    global $con;
    $sql = "SELECT * FROM accounts WHERE c_id='$c_id'";
    $stmt = $con->query($sql);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $account_no = $row['account_no'];
    }
    $q = "SELECT * FROM customers_masters WHERE c_id='$c_id' email='$to'";
    $stmt = $con->query($q);
    $stmt->execute();
    while ($data = $stmt->fetch()) {
        $f_name = $data['f_name'];
    }
    try {
        $subject = "OctoPrime e-Banking";;
        $headers = "From:noreply@OctoprimeBank.com  <noreply@OctoprimeBank.com> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body = "<!DOCTYPE html>
            <html>
            <head>
                <title></title>
                <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css'>
            </head>
            <body>
                <p class='text-right text-muted font-size: 20;'>Dear,". $f_name."</p>
                <div class='container'>
                <div class='row'>
                <div class='col-lg-12 col-lg-sm-12'>
                    <h1 style='text-align:center; color: white; background-color: #007bff;; margin:10px; padding: 15px;'>
                    A/C: ".$account_no."</h1>
                    </div>
                </div>
                </div>
                    <div class='row'>
                        <div class='col-lg-12 col-lg-sm-12'>
    
                            <p class='text text-muted'>
                            This is to inform you that your Account # 0307431298 is registered successfully with Not A Bank and currently not active. 
                            We will soon contact you once it gets activated.
                            </p>
                            <p class='text text-muted'>In case you need any further clarification for the same, please do get in touch with your Branch.</p>
                            <hr>
                            <p class='text text-muted'>
                            Please do not reply to this email. Emails sent to this address will not be answered. Copyright ©2019 Octo-Prime Bank.
                            </p>
                        </div>
                    </div>

            </body>
        </html>";
        $result = mail($to, $subject, $body, $headers);
        if (!$result) {
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