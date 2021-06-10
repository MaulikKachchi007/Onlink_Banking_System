<?php
include('include/DB.php');
//include('include/session.php');
include('include/function.php');

$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_GET['id'];

        $get_id = $_GET['id'];
        $qr = "SELECT * FROM fixed_deposite WHERE f_id='$get_id'";
        $stmt = $con->query($qr);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $change_status = $row['status'];
        }
        if ($change_status == 'Inactive') {
            $sql = "Update fixed_deposite SET status='Active' WHERE f_id='$get_id'";
            $stmt = $con->query($sql);
            $result = $stmt->execute();
            if ($result) {
                $_SESSION['success_message'] = "Deposite Verify.!";
                redirect('view_deposite.php');
            } else {
                $_SESSION['error_message'] = "Something went wrong.Try again!";
                redirect('view_deposite.php');
            }
        } elseif ($change_status == 'Active') {
            $sql = "Update fixed_deposite SET status='Inactive' WHERE f_id='$get_id'";
            $stmt = $con->query($sql);
            $result = $stmt->execute();
            if ($result) {
                $_SESSION['success_message'] = "Deposite Un-Verify.!";
                redirect('view_deposite.php');
            } else {
                $_SESSION['error_message'] = "Something went wrong.Try again!";
                redirect('view_deposite.php');
            }
        }
?>