<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$get_id = $_SESSION['id'];
global $con;
$sql = "SELECT * from employees_master where id='$get_id'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $ifsccode = $row['ifsccode'];
}
?>
<?php
require_once 'include/header.php';
require_once 'include/topbar.php';
require_once 'include/sidebar.php';
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default mt-2">
                        <div class="card-header">
                            <div class="card-title"><h1 class="text-dark">View Transactions</h1>
                                <p>View Transactions Records</p>
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
                                    <th>Accounts Number</th>
                                    <th>Account</th>
                                    <th>Commission</th>
                                    <th>Particulars</th>
                                    <th>Transaction Type</th>
                                    <th>Transaction Date</th>
                                    <th>Approve Date</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                global $con;
                                $sql = "SELECT * from transaction WHERE payment_status='Approved' or payment_status='Active'";
                                $stmt = $con->query($sql);
                                $result = $stmt->rowcount();
                                if ($result > 0)
                                {
                                    while ($row = $stmt->fetch()) {
                                        $trans_id = $row['trans_id'];
                                        $to_account_no = $row['to_account_no'];
                                        $amount = $row['amount'];
                                        $commision = $row['comission'];
                                        $particulars = $row["particulars"];
                                        $trans_date_time = $row['trans_date_time'];
                                        $transaction_type = $row['transaction_type'];
                                        $approve_date_time = $row['approve_date_time'];
                                        $status = $row['payment_status'];
                                        ?>
                                        <tr>
                                            <td><?php echo $to_account_no; ?></td>
                                            <td><?php echo $amount; ?></td>
                                            <td><?php echo $commision; ?></td>
                                            <td><?php echo $particulars; ?></td>
                                            <td><?php echo $transaction_type; ?></td>
                                            <td><?php echo $trans_date_time; ?></td>
                                            <td><?php echo $approve_date_time; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                      <li><a  class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $trans_id; ?>">View</a></li>
                                                    </ul>
                                                </div>

                                                <div class="modal fade" id="ExampleModal<?php echo $trans_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">View Paid Loan Receipt</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div  class="modal-body">
                                                                <table class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <th>Account Number</th>
                                                                        <td><?php echo $to_account_no; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Loan Account Number</th>
                                                                        <td><?php echo $row['loan_account_number']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Loan Type</th>
                                                                        <td><?php echo $row['loan_type']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Loan Amount</th>
                                                                        <td><?php echo $row['loan_amount']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Interest Amount</th>
                                                                        <td><?php echo $row['intrest']; ?> (<?php echo $loan_interest; ?> %)</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Total Amount</th>
                                                                        <td><?php echo $total_amt; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Total Paid</th>
                                                                        <td><?php echo $paid; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Total Balance</th>
                                                                        <td><?php echo $balance; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Paid Date</th>
                                                                        <td><?php echo $paid_date; ?></td>
                                                                    </tr>

                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php  }
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
<?php
require_once 'include/footer.php';
?>
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>