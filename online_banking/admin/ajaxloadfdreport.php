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
            <a href="export_fdreport_pdf.php?fromDate=<?php echo $fromDate;?>&toDate=<?php echo $toDate;?>" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
            </a>
        </div>
    </div>
    <div class="card card-body">
        <table id="example1" class="table table-striped table-bordered table-responsive">
            <thead>
            <tr>
                <th>Customer Name</th>
                <th>Account Number</th>
                <th>Account Date</th>
                <th>Maturity date</th>
                <th>Deposite Type</th>
                <th>Invesment Amount</th>
                <th>Profit</th>
                <th>Total Receivable Amount</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                global $con;
                $sql = "SELECT * FROM fixed_deposite 
                        INNER JOIN accounts ON fixed_deposite.f_id=accounts.f_id
                        INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
                        WHERE accounts.account_open_date BETWEEN '$fromDate' AND '$toDate'";
                $stmt = $con->query($sql);
                $rcount = $stmt->rowCount();
                if ($rcount > 0) {
                while ($row = $stmt->fetch()) {
                $account_no = $row['account_no'];
                $d_type = $row['d_type'];
                $interest = $row['interest'];
                $term = "$row[terms] years";
                $f_name = $row['f_name'];
                $l_name = $row['l_name'];
                $account_open_date = $row['account_open_date'];
                $balance = $row['account_balance'];
                $status = $row['account_status'];
                $md = date('Y-m-d',strtotime($term,strtotime($account_open_date)));
                $profit = $balance * $interest/100;
                $total = $balance + $profit;
                ?>
                <td><?php echo $f_name; ?> <?php echo $l_name; ?></td>
                <td><?php echo $account_no; ?></td>
                <td><?php echo $account_open_date; ?></td>
                <td><?php echo $md; ?></td>
                <td><?php echo $d_type; ?></td>
                <td>₹ <?php echo $balance; ?></td>
                <td>₹ <?php echo $profit; ?> (<?php echo $interest ?> %)</td>
                <td>₹ <?php echo $total; ?></td>
                <td><?php echo $status; ?></td>
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