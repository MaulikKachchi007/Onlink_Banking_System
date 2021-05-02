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
header('Content-Disposition:attachment; filename=fd_accounts.csv');
$output = fopen("php://output","w");
fputcsv($output,array('IFSC Code','Employee Name','Login ID','Email ID','Contact','Employee Type','Status'));
global $con;
$sql = "SELECT * from employees_master INNER JOIN branch ON employees_master.ifsccode = branch.ifsccode  WHERE employees_master.ifsccode='$ifsccode'";
$stmt = $con->query($sql);
$result = $stmt->rowcount();
if ($result > 0) {
    while ($row = $stmt->fetch()){
        $id = $row['id'];
        $ename = $row['ename'];
        $loginid = $row['loginid'];
        $email = $row['email'];
        $bname = $row['bname'];
        $contact = $row['contact'];
        $employee_type = $row['employee_type'];
        $ifsccode = $row['ifsccode'];
        $status = $row['status'];
        $row_data = array($ifsccode,$ename,$loginid,$email,$contact,$employee_type,$status);
        fputcsv($output, $row_data);
    }
}else {
    echo '<b>Record Not found</b>';
}
fclose($output);
//    include_once 'include/footer.php';<?php
