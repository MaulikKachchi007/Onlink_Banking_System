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
fputcsv($output,array('IFSC Code','Account Number','Name','Account Type','Account Balance','Account OpenDate','Status'));
global $con;
$sql = "SELECT customers_master.*, accounts.*  FROM customers_master  INNER JOIN accounts ON customers_master.c_id = accounts.c_id where accounts.account_status ='Active' and accounts.account_type='Saving Account' or accounts.account_type='Current Account' and customers_master.ifsccode='$ifsccode'";
$stmt = $con->query($sql);
    $result = $stmt->rowcount();
    if ($result > 0) {
        while ($row = $stmt->fetch()) {
            $row_data = array($row['ifsccode'],$row['account_no'], $row['f_name'],$row['account_type'], $row['account_balance'],$row['account_open_date'], $row['accountstatus']);
            fputcsv($output, $row_data);
        }
    }else {
        echo '<b>Record Not found</b>';
    }
fclose($output);
//    include_once 'include/footer.php';