<?php
    include_once 'include/DB.php';
    include_once 'include/function.php';
    include_once 'include/session.php';
    global $con;
    $get_id = $_GET['id'];
    $sql = "SELECT * FROM loan_type_master WHERE id='$get_id'";
    $stmt = $con->query($sql);
    $stmt->execute();
    while ($row = $stmt->fetch()){
    $change_Status = $row['status'];
    }
    if ($change_Status == 'deactive'){
        $sql = "Update loan_type_master SET status='active' WHERE id='$get_id'";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
        $_SESSION['success_message'] = "Loan types Actived.!";
        redirect('view_loan_type.php');
        } else {
        $_SESSION['error_message'] = "Something went wrong.Try again!";
        redirect('view_loan_type.php');
        }
    }elseif ($change_Status == 'active') {
        $sql = "Update loan_type_master SET status='deactive' WHERE id='$get_id'";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Loan types Deactived.!";
            redirect('view_loan_type.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('view_loan_type.php');
        }
    }
