<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$get_id = $_SESSION['id'];
global $con;
$sql = "SELECT * from customers_master 
        INNER JOIN loan_payment ON customers_master.c_id=loan_payment.c_id";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()){
    $f_name = $row['f_name'];
    $l_name = $row['l_name'];
    $loan_amount = $row['loan_amt'];
    $paid = $row['paid'];
    $ifsccode = $row['ifsccode'];
    $balance = $row['balance'];
    $payment_type = $row['payment_type'];
    $total_amt = $row['total_amt'];
    $paid_date = $row['paid_date'];
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
                            <div class="card-title"><h1 class="text-dark">View Loan Accounts</h1>
                                <p>View Loan Accounts</p>
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
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                global $con;
                                $sql = "SELECT * from loan_type_master 
                                    INNER JOIN loan ON loan_type_master.id=loan.id WHERE loan.status='Approved'";
                                $stmt = $con->query($sql);
                                $result = $stmt->rowcount();
                                if ($result > 0)
                                {
                                    while ($row = $stmt->fetch()) {
                                        $loan_id = $row['loan_id'];
                                        $loan_account_number = $row['loan_account_number'];
                                        $loan_amount  = $row['loan_amount'];
                                        $interest = $row['intrest'];
                                        $loan_interest = $row['interest'];
                                        $term=  "$row[terms] years";
                                        $created_date = $row['created_date'];
                                        $total_payable = $loan_amount + $interest;
                                        $status = $row['status'];
                                        ?>
                                        <tr>
                                            <td><?php echo $f_name; ?></td>
                                            <td><?php echo $loan_account_number; ?></td>
                                            <td>&#8377; <?php echo $loan_amount;?></td>
                                            <td>&#8377; <?php echo $interest;?> (<?php echo $loan_interest; ?>)</td>
                                            <td>&#8377; <?php echo $total_payable;?></td>
                                            <td>&#8377; <?php echo $paid;?></td>
                                            <td><?php echo $payment_type; ?></td>
                                            <td>&#8377;<?php echo $balance;?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                        <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a  class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $loan_id; ?>">View</a></li>
                                                    </ul>
                                                </div>
                                                <div class="modal fade" id="ExampleModal<?php echo $row['loan_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Loan Payment Receipt</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div  class="modal-body">
                                                                <table class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <th>Customer Name</th>
                                                                        <td><?php echo $f_name; ?> <?php echo $l_name; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>IFSC Code</th>
                                                                        <td><?php echo $ifsccode; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Loan Account Number</th>
                                                                        <td><?php echo $row['loan_account_number']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Payment Type</th>
                                                                        <td><?php echo $payment_type; ?></td>
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
                                                                        <th>Paid Date</th>
                                                                        <td><?php echo $paid_date; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Total Balance</th>
                                                                        <td><?php echo $balance; ?></td>
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
require_once 'include/footer.php';
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