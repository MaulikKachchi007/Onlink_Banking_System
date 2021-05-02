<?php
include_once 'include/DB.php';
include_once 'include/function.php';
//    include_once 'include/session.php';
//    include_once 'include/header.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_SESSION['id'];
$q = "SELECT * FROM employees_master WHERE id='$get_id'";
$stmt = $con->query($q);
$result = $stmt->execute();
if ($row = $stmt->fetch()){
    $ifsccode = $row['ifsccode'];
}
header('Content-Type: application/csv charset=utf-8');
header('Content-Disposition:attachment; filename=customer_record.csv');
$output = fopen("php://output","w");
fputcsv($output,array('ID','Branch','First Name','Last Name','Email','Mobile Number','Account type','Address','city','Adhar Number','Gender','Occupation','Status'));
global $con;
$sql = "SELECT * FROM customers_master INNER JOIN accounts ON customers_master.c_id = accounts.c_id  WHERE ifsccode='$ifsccode' and  accounts.account_type='Saving Account' or accounts.account_type='Current  Account' and accounts.account_status='Active'";
$stmt = $con->prepare($sql);
$stmt->execute();
//    $result = $stmt->rowcount();
while ($row = $stmt->fetch()){
    $row_data =  array($row['c_id'],$row['ifsccode'],$row['f_name'],$row['l_name'],$row['email'],$row['phone'],$row['locality'],$row['city'],$row['adharnumber'],$row['gender'],$row['occuption'],$row['accountstatus']);
    fputcsv($output,$row_data);
}
fclose($output);
//    include_once 'include/footer.php';