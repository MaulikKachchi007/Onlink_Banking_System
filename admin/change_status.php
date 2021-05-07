<?php
    include_once 'include/DB.php';
    include_once 'include/function.php';
    include_once 'include/session.php';
    global $con;

    $get_id = $_GET['id'];
    $sql = "SELECT * FROM account_master WHERE id='$get_id'";
    $stmt = $con->query($sql);
    $stmt->execute();
    while ($row = $stmt->fetch()){
        $change_Status = $row['status'];
    }
    if ($change_Status == 'Inactive'){
        $sql = "Update account_master SET status='Active' WHERE id='$get_id'";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Account Actived.!";
            redirect('view_account.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('view_account.php');
        }
    }elseif ($change_Status == 'Active') {
        $sql = "Update account_master SET status='Inactive' WHERE id='$get_id'";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Account Inactive.!";
            redirect('view_account.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('view_account.php');
        }
    }