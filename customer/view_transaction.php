<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_SESSION['c_id'];

?>
<?php
include_once 'include/header.php';
include_once 'include/topbar.php';
include_once 'include/sidebar.php';
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
                            <div class="card-title"><h1 class="text-dark">View Transactions</h1>
                                <p class="text-muted">View Transactions Records</p>
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
                                <table id="example1" class="table table-striped table-bordered table-responsive">
                                    <thead>
                                    <tr>
                                        <th>Account No</th>
                                        <th>Amount</th>
                                        <th>Particulars</th>
                                        <th>Transaction Types</th>
                                        <th>Transaction Date Time</th>
                                        <th>Approved Date Time</th>
                                        <th>Payment Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    //                            $sql ="SELECT * FROM transaction INNER JOIN  accounts ON transaction.to_acc_no=accounts.acc_no WHERE accounts.customer_id='$_SESSION[customer_id]' AND (transaction.payment_status='Active' OR transaction.payment_status='Approved')  LIMIT 0,10 ";
                                    $sql = "SELECT * FROM transaction 
                                        INNER JOIN accounts ON transaction.to_account_no=accounts.account_no WHERE
                                        accounts.c_id='$get_id' and accounts.account_type='Saving Account' or accounts.account_type='Current Account' AND (transaction.payment_status='Active' OR transaction.payment_status='Approved')  ORDER BY transaction.trans_id DESC";
                                    $stmt = $con->query($sql);
                                    while ($row = $stmt->fetch()) {
                                        $trans_id = $row['trans_id'];
                                        $account_no = $row['account_no'];
                                        $account_balance = $row['amount'];
                                        $particular = $row['particulars'];
                                        $transaction_type = $row['transaction_type'];
                                        $payment_status = $row['payment_status'];
                                        $approve_date_time = $row['approve_date_time'];
                                        $t_datetime = $row['trans_date_time'];
                                        ?>
                                        <tr>
                                            <td><?php echo $account_no;?></td>
                                            <td>&#8377;  <?php echo $account_balance;?></td>
                                            <td><?php echo $particular;?></td>
                                            <td><?php echo $transaction_type;?></td>
                                            <td><?php echo $t_datetime;?></td>
                                            <td><?php echo $approve_date_time;?></td>
                                            <td><?php echo $payment_status;?></td>
                                            <td><a href="depoitemoneyreceipt.php?id=<?php echo $trans_id;?>" target="_blank" class="btn btn-primary">Receipt</a></td>
                                        </tr>
                                        <?php
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
        <!-- Modal -->
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