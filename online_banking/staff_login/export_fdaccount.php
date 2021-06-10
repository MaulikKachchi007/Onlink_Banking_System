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
$sql = "SELECT * FROM accounts 
        INNER JOIN fixed_deposite ON fixed_deposite.f_id=accounts.f_id
        where accounts.f_id!='0'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()){
    $d_type = $row['d_type'];
    $interest = $row['interest'];
    $term = "$row[terms] years";
}
header('Content-Type: application/csv charset=utf-8');
header('Content-Disposition:attachment; filename=fd_accounts.csv');
$output = fopen("php://output","w");
fputcsv($output,array('IFSC Code','Name','Account Number','Account Date','Maturity date','Deposite Type','Invesment Amount','Profit','Total Amount'));
global $con;
$q = "SELECT * FROM accounts 
      INNER JOIN customers_master ON customers_master.c_id=accounts.c_id
      where accounts.account_type='Fixed Deposite Account' and accounts.f_id!='0' and customers_master.ifsccode='$ifsccode'";
$stmt = $con->query($q);
$result = $stmt->rowcount();
if ($result > 0) {
    while ($row = $stmt->fetch()) {
        $account_open_date = $row['account_open_date'];
        $md = date('Y-m-d',strtotime($term,strtotime($account_open_date)));
        $balance = $row['account_balance'];
        $status = $row['account_status'];
        $profit = $balance * $interest/100;
        $total = $balance + $profit;
        $row_data = array($row['ifsccode'],$row['f_name'],$row['account_no'],$row['account_open_date'],$md,$d_type,$balance ,$profit, $total);
        fputcsv($output, $row_data);
    }
}else {
    echo '<b>Record Not found</b>';
}
fclose($output);
//    include_once 'include/footer.php';<?php
