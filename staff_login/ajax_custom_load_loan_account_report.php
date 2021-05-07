<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();

$get_id = $_SESSION['id'];
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
global $con;
$sql = "SELECT * FROM employees_master WHERE id='$get_id'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $ifsccode = $row['ifsccode'];
}
?>
<div class="card card-primary">
    <div class="card-header border-0">
        <h3 class="card-title">Accounts Statement</h3>
        <div class="card-tools">
            <a href="export_loan_pdf_report.php?fromDate=<?php echo $fromDate;?>&toDate=<?php echo $toDate;?>" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
            </a>
        </div>
    </div>
    <div class="card card-body">
        <table id="example1" class="table table-striped table-bordered table-responsive">
            <thead>
            <tr>
                <th>IFSC Code</th>
                <th>Customer Name</th>
                <th>Loan Account Number</th>
                <th>Loan Type</th>
                <th>Created Date</th>
                <th>Last Date</th>
                <th>Loan Amount</th>
                <th>Interest Amount</th>
                <th>Total Payble</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                global $con;
                $sql = "SELECT * from loan_type_master 
                        INNER JOIN loan ON loan_type_master.id=loan.id 
                        INNER JOIN customers_master ON customers_master.c_id=loan.c_id
                        WHERE loan.status='Approved' and ifsccode='$ifsccode' and loan.created_date BETWEEN '$fromDate' AND '$toDate'";
                $stmt = $con->query($sql);
                $rcount = $stmt->rowCount();
                if ($rcount > 0) {
                while ($row = $stmt->fetch()) {
                $f_name = $row['f_name'];
                $l_name = $row['l_name'];
                $loan_id = $row['loan_id'];
                $loan_account_number = $row['loan_account_number'];
                $l_type = $row['loan_type'];
                $loan_amount = $row['loan_amount'];
                $interest = $row['intrest'];
                $loan_interest = $row['interest'];
                $term = "$row[terms] years";
                $created_date = $row['created_date'];
                $total_payable = $loan_amount + $interest;
                $status = $row['status'];
                $ifsccode = $row['ifsccode'];
                ?>
                <td><?php echo $ifsccode;?></td>
                <td><?php echo $f_name; ?></td>
                <td><?php echo $loan_account_number; ?></td>
                <td><?php echo $l_type; ?></td>
                <td><?php echo $created_date; ?></td>
                <td><?php echo date('d-M-Y', strtotime($term, strtotime($created_date))); ?></td>
                <td>&#8377; <?php echo $loan_amount;?></td>
                <td>&#8377; <?php echo $interest;?> (<?php echo $loan_interest; ?>)</td>
                <td>&#8377; <?php echo $total_payable;?></td>
            </tr>
            <?php
            }
            }else{
                echo "<tr><td colspan='9' class='text-bold text-center text-danger'>No Record Found</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>