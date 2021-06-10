<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();

$get_id = $_SESSION['id'];
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
global $con;
?>
<div class="card card-primary">
    <div class="card-header border-0">
        <h3 class="card-title">Transaction Statement</h3>
        <div class="card-tools">
            <a href="export_pdf_report.php?fromDate=<?php echo $fromDate;?>&toDate=<?php echo $toDate;?>" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
            </a>
        </div>
    </div>
    <div class="card card-body">
        <table id="example1" class="table table-striped table-bordered table-responsive">
            <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Date</th>
            <th>Account Number</th>
            <th>Amount (Rs.)</th>
            <th>Particulars</th>
            <th>Transaction Type</th>
            <th>Payment Status</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            global $con;
            $sql = "SELECT * FROM transaction 
            WHERE transaction.trans_date_time BETWEEN '$fromDate' AND '$toDate'";
            $stmt = $con->query($sql);
            $rcount = $stmt->rowCount();
            if ($rcount > 0) {
            while ($row = $stmt->fetch()) {
                $trans_id = $row['trans_id'];
                $to_account_no = $row['to_account_no'];
                $amount = $row['amount'];
                $particulars = $row['particulars'];
                $transaction_type = $row['transaction_type'];
                $trans_date_time = $row['trans_date_time'];
                $payment_status = $row['payment_status'];
            ?>
            <td><?php echo $trans_id;?></td>
            <td><?php echo $trans_date_time;?></td>
            <td><?php echo $to_account_no;?></td>
            <td><?php echo $amount;?></td>
            <td><?php echo $particulars;?></td>
            <td><?php echo $transaction_type;?></td>
            <td><?php echo $payment_status;?></td>
        </tr>
        <?php
        }
        }else{
                echo "<tr><td colspan='7' class='text-bold text-center text-danger'>No Record Found</td></tr>";
        }
        ?>
        </tbody>
    </table>
    </div>