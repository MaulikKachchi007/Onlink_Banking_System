<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['c_id'];
?>
<?php
require_once 'include/header.php';
require_once 'include/topbar.php';
require_once 'include/sidebar.php';
?>
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default mt-2">
                        <div class="card-header">
                            <div class="card-title"><h1 class="text-dark">Views Loan Accounts</h1>
                                <p class="text-muted">Views Loan Accounts</p>
                            </div>
                            <div class="pull-right" style="text-align: right;">
                                <a href="customer_loan.php" class="btn btn-info"><i class="fas fa-plus"></i> Apply For Loan</a>
                                <a href="loan_status.php" class="btn btn-info"><i class="fas fa-reply"></i> Loan Status</a>
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
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Loan Account Number</th>
                                        <th>Loan Type</th>
                                        <th>Created Date</th>
                                        <th>Loan Amount</th>
                                        <th>Interest Amount</th>
                                        <th>Total Payble</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $sql = "SELECT loan.loan_id,loan.loan_account_number,loan.c_id,loan_type_master.loan_type,loan.c_id,loan.created_date,loan_amount,loan.intrest,loan.status from loan_type_master 
                                    INNER JOIN loan ON loan_type_master.id=loan.id WHERE loan.c_id='$get_id' and loan.status='Approved'";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowCount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $loan_id = $row['loan_id'];
                                            $loan_account_number = $row['loan_account_number'];
                                            $l_type = $row['loan_type'];
                                            $loan_amount  = $row['loan_amount'];
                                            $interest = $row['intrest'];
                                            $created_date = $row['created_date'];
                                            $total_payable = $loan_amount + $interest;
                                            $status = $row['status'];
                                            ?>
                                            <tr>
                                                <td><?php echo $loan_account_number; ?></td>
                                                <td><?php echo $l_type; ?></td>
                                                <td><?php echo $created_date; ?></td>
                                                <td><?php echo $loan_amount;?></td>
                                                <td><?php echo $interest;?></td>
                                                <td><?php echo $total_payable;?></td>
                                                <td>
                                                    <?php
                                                    if ($status == "Pending") {
                                                        echo "<div class='badge badge-warning'>$status</div>";
                                                    }elseif ($status == "Denied"){
                                                        echo "<div class='badge badge-danger'>$status</div>";
                                                    }elseif ($status == "Approved"){
                                                        echo "<div class='badge badge-success'>$status</div>";
                                                    }

                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $row['loan_id']; ?>"><i class="menu-icon icon-edit"></i>View</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal fade" id="ExampleModal<?php echo $row['loan_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Views Loan Accounts</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table id="example1" class="table table-bordered table-striped">
                                                                        <tr>
                                                                            <th>Loan Account Number</th>
                                                                            <td><?php echo $row['loan_account_number']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Loan Type</th>
                                                                            <td><?php echo $row['loan_type']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Created Date</th>
                                                                            <td><?php echo $row['created_date']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Loan Amount</th>
                                                                            <td><?php echo $row['loan_amount']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Interest Amount</th>
                                                                            <td><?php echo $row['intrest']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Total Payble</th>
                                                                            <td><?php echo $total_payable; ?></td>
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
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<?php
include 'include/footer.php';
?>
<script type="text/javascript">
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
<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>