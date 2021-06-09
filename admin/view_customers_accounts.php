<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
?>
<?php
include_once 'include/header.php';
include_once 'include/topbar.php';
include_once 'include/sidebar.php';
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default mt-2">
                        <div class="card-header">
                            <div class="card-title"><h1 class="text-dark">View Bank Accounts</h1>
                                <p class="text-muted">Views Bank Account Records</p>
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
                                        <th>IFSC Code</th>
                                        <th>Customer Name</th>
                                        <th>A/C Open Date</th>
                                        <th>Account No.</th>
                                        <th>Account Type</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $account_balance="";
                                    $sql = "SELECT customers_master.*, accounts.*  FROM customers_master  INNER JOIN accounts ON customers_master.c_id = accounts.c_id where accounts.account_type = 'Saving Account' or accounts.account_type = 'Current Account'";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowcount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $ifsccode = $row['ifsccode'];
                                            $cname = $row['f_name'];
                                            $email = $row['email'];
                                            $acno= $row['account_no'];
                                            $a_type = $row['account_type'];
                                            $account_balance= $row['account_balance'];
                                            $aopendate = $row['account_open_date'];
                                            $status = $row['account_status'];

                                            ?>
                                            <tr>
                                                <td><?php echo $ifsccode; ?></td>
                                                <td><?php echo $cname; ?></td>
                                                <td><?php echo $aopendate; ?></td>
                                                <td><?php echo $acno; ?></td>
                                                <td><?php echo $a_type; ?></td>
                                                <td><?php echo $account_balance; ?></td>
                                                <td>
                                                    <?php
                                                        if($status == "Active") {
                                                        echo "<div class='badge badge-success'>".$status.'</div>';
                                                        }
                                                        elseif($status == "Inactive"){
                                                        echo "<div class='badge badge-danger'>".$status.'</div>';
                                                        }
                                                    ?>
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