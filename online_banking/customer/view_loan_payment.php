<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$get_id = $_SESSION['c_id'];
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$sql = "SELECT * from loan_type_master 
        INNER JOIN loan ON loan_type_master.id=loan.id WHERE loan.status='Approved'";
$stmt = $con->query($sql);
while ($rowdata = $stmt->fetch()){
    $loan_amount = $rowdata['loan_amount'];
    $loan_type = $rowdata['loan_type'];
    $interest  = $rowdata['interest'];
    $loan_amount  = $rowdata['loan_amount'];
    $interest_amt = $loan_amount * $interest /100;
    $terms  = $rowdata['terms'];
    }
?>
<?php
require_once 'include/header.php';
require_once 'include/topbar.php';
require_once 'include/sidebar.php';
?>
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default mt-2">
                        <div class="card-header">
                            <div class="card-title"><h1 class="text-dark">View Loan Payments</h1>
                                <p>View Loan Payments</p>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-header -->
                </div>
                <div class="card card-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12">
                            <div class="container p-1">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                ?>
                            </div>
                            <table id="example1" class="table table-bordered table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Loan Account Number</th>
                                    <th>Loan Amount</th>
                                    <th>Interest Amount</th>
                                    <th>Total Payble</th>
                                    <th>Total Paid</th>
                                    <th>Payment Type</th>
                                    <th>Balance</th>
                                    <th>Paid Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                global $con;
                                $sql = "SELECT * from customers_master
                                    INNER JOIN loan_payment ON customers_master.c_id=loan_payment.c_id WHERE loan_payment.c_id='$get_id'";
                                $stmt = $con->query($sql);
                                $result = $stmt->rowcount();
                                if ($result > 0)
                                {
                                    while ($row = $stmt->fetch()) {
                                        $loan_id = $row['payment_id'];
                                        $f_name = $row['f_name'];
                                        $loan_account_number = $row['loan_account_number'];
                                        $paid = $row['paid'];
                                        $payment_type = $row['payment_type'];
                                        $paid_date = $row['paid_date'];
                                        $total_payable = $loan_amount + $interest;
                                        $balance = $row['balance'];
                                        ?>
                                        <tr>
                                            <td><?php echo $f_name; ?></td>
                                            <td><?php echo $loan_account_number; ?></td>
                                            <td>&#8377; <?php echo $loan_amount;?></td>
                                            <td>&#8377; <?php echo $interest_amt;?> (<?php echo $interest; ?>)</td>
                                            <td>&#8377; <?php echo $total_payable;?></td>
                                            <td>&#8377; <?php echo $paid;?></td>
                                            <td><?php echo $payment_type; ?></td>
                                            <td>&#8377;<?php echo $balance;?></td>
                                            <td><?php echo $paid_date;?></td>
                                            <td><a href="loan_payment_receipt.php?id=<?php echo $loan_id;?>" id="pdf" target="_blank" class="btn btn-info nav-link" >Print</a></td>
                                        </tr>
                                        <?php
                                    }
                                }else {
                                    $_SESSION['error_message']= "Record not found.";
                                }
                                ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
</div>
</div>
</section>
</div>
<?php
include 'include/footer.php';
?>
<script>
    $(function () {
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });
    });
</script>
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>