<?php
    include 'include/DB.php';
    include 'include/function.php';
//    include 'include/session.php';
    $_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
    confirm_login();

    //Delete Record in Database
    global $con;
    $get_id = $_GET['id'];
    $sql = "DELETE  customers_master.*, accounts.*
            FROM customers_master
            INNER JOIN accounts ON customers_master.c_id= accounts.c_id
            WHERE (customers_master.c_id)='$get_id'";
    $stmt = $con->query($sql);
    $result = $stmt->execute();
    if ($result){
        $_SESSION['success_message'] = "Delete Account Successfully.";
        redirect('customers_detail.php');
    }else{
        $_SESSION['error_message'] = "Something went wrong. Try again.";
        redirect('customers_detail.php');
    }
    $con = null;

