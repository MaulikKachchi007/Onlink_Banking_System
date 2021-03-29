<?php
include_once 'include/DB.php';
    include_once 'include/function.php';
    include_once 'include/session.php';
//    include_once 'include/header.php';
    global $con;
    header('Content-Type: application/csv charset=utf-8');
    header('Content-Disposition:attachment; filename=loan_type_report.csv');
    $output = fopen("php://output","w");
    fputcsv($output,array('ID','Loan Type','Prefix','Minimum Amount','Maximum Amount','Interest','Status','Time'));
    $sql = "SELECT * FROM loan_type_master";
    $stmt = $con->prepare($sql);
    if (!$stmt->execute()) { echo $stmt->errorInfo();}
    $result = $stmt->rowcount();
    if($result > 0 ) {
        while ($row = $stmt->fetch()) {
          $row_data =  array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]);
          fputcsv($output,$row_data,",");
        }
    }
fclose($output);
//    include_once 'include/footer.php';