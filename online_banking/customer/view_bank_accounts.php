<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['c_id'];
global $con;
$sql = "SELECT customers_master.*, accounts.* FROM customers_master  INNER JOIN accounts ON   customers_master.c_id='$get_id' and accounts.account_type = 'Saving Account' or accounts.account_type = 'Current Account'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $f_name = $row['f_name'];
    $l_name = $row['l_name'];
    $account_no = $row['account_no'];
    $account_type = $row['account_type'];
    $balance = $row['account_balance'];
    $account_open_date = $row['account_open_date'];
    $interest = $row['interest'];
    $ifsccode= $row['ifsccode'];
    $city= $row['city'];
    $adharnumber= $row['adharnumber'];
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
                            <div class="card-title"><h1 class="text-dark">View Bank Accounts</h1>
                                <p class="text-muted">Views Bank Accounts</p>
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
                                <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo $f_name; ?> <?php echo $l_name; ?></td>
                                </tr>
                                <tr>
                                    <th>Account Number</th>
                                    <td><?php echo $account_no; ?></td>
                                </tr>
                                <tr>
                                    <th>Account Type</th>
                                    <td><?php echo $account_type; ?></td>
                                </tr>
                                <tr>
                                    <th>Account Interest</th>
                                    <td><?php echo $interest; ?></td>
                                </tr>
                                <tr>
                                <th>Branch</th>
                                    <td><?php echo $ifsccode; ?><?php $city; ?></td>
                                </tr>
                                <tr>
                                    <th>Account Type</th>
                                    <td><?php echo $account_type; ?></td>
                                </tr>    
                                <tr>
                                    <th>City</th>
                                    <td><?php echo $city; ?></td>
                                </tr>
                                <tr>
                                    <th>Adhar Number</th>
                                    <td><?php echo  str_pad(substr($adharnumber,-4),14,'X',STR_PAD_LEFT); ?></td>
                                </tr>
                        </div>

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
