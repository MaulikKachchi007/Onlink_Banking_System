<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
global $con;

$get_id = $_GET['id'];
$sql = "SELECT * FROM card_type_master WHERE id='$get_id'";
$stmt = $con->query($sql);
$stmt->execute();
while ($row = $stmt->fetch()){
    $change_Status = $row['status'];
}
if ($change_Status == 'Inactive'){
    $sql = "Update card_type_master SET status='Active' WHERE id='$get_id'";
    $stmt = $con->prepare($sql);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['success_message'] = "Card Actived.!";
        redirect('view_cards_type.php');
    } else {
        $_SESSION['error_message'] = "Something went wrong.Try again!";
        redirect('view_cards_type.php');
    }
}elseif ($change_Status == 'Active') {
    $sql = "Update card_type_master SET status='Inactive' WHERE id='$get_id'";
    $stmt = $con->prepare($sql);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['success_message'] = "Card Inactive.!";
        redirect('view_cards_type.php');
    } else {
        $_SESSION['error_message'] = "Something went wrong.Try again!";
        redirect('view_cards_type.php');
    }
}