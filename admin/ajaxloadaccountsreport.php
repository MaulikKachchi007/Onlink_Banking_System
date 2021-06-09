<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
global $con;
?>
<div class="card card-primary">
    <div class="card-header border-0">
        <h3 class="card-title">Accounts Statement</h3>
        <div class="card-tools">
            <a href="export_account_pdf_report.php?fromDate=<?php echo $fromDate;?>&toDate=<?php echo $toDate;?>" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
            </a>
        </div>
    </div>
    <div class="card card-body">
        <table id="example1" class="table table-striped table-bordered table-responsive">
            <thead>
            <tr>
                <th>IFSC Code</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Account Number</th>
                <th>Account Type</th>
                <th>Accounts Balance</th>
                <th>Intrest</th>
                <th>Accounts Open Date</th>
                <th>Accounts Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                global $con;
                $sql = "SELECT * FROM accounts
                        INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
                        WHERE  (accounts.account_type='Saving Account' or accounts.account_type='Current Account')
                        and  accounts.account_open_date BETWEEN '$fromDate' AND '$toDate'";
                $stmt = $con->query($sql);
                $rcount = $stmt->rowCount();
                if ($rcount > 0) {
                while ($row = $stmt->fetch()) {
                $account_no = $row['account_no'];
                $account_open_date = $row['account_open_date'];
                $account_type = $row['account_type'];
                $ifsccode = $row['ifsccode'];
                $f_name = $row['f_name'];
                $l_name = $row['l_name'];
                $account_status = $row['account_status'];
                $interest = $row['interest'];
                $account_balance = $row['account_balance'];
                ?>
                <td><?php echo $ifsccode;?></td>
                <td><?php echo $f_name;?></td>
                <td><?php echo $l_name;?></td>
                <td><?php echo $account_no;?></td>
                <td><?php echo $account_type;?></td>
                <td><?php echo $account_balance;?></td>
                <td><?php echo $interest;?></td>
                <td><?php echo $account_open_date;?></td>
                <td><?php echo $account_status;?></td>
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