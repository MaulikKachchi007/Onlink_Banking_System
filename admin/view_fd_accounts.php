<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$sql = "SELECT * FROM accounts 
        INNER JOIN fixed_deposite ON fixed_deposite.f_id=accounts.f_id
        where accounts.f_id!='0'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()){
    $d_type = $row['d_type'];
    $interest = $row['interest'];
    $term = "$row[terms] years";
}
$stmt = $con->query($sql);
?>
<?php
include_once 'include/header.php';
include_once 'include/topbar.php';
include_once 'include/sidebar.php';
?>
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default mt-2">
                        <div class="card-header">
                            <div class="card-title"><h1 class="text-dark">View FD Accounts</h1>
                                <p class="text-muted">Views FD Accounts Records</p>
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
                                    <?php
                                    global $con;
                                    $q = "SELECT * FROM accounts 
                                          INNER JOIN customers_master ON customers_master.c_id=accounts.c_id
                                          where accounts.account_type='Fixed Deposite Account' and accounts.f_id!='0'";
                                    $stmt = $con->query($q);
                                    $result = $stmt->rowCount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $account_no = $row['account_no'];
                                            $f_name = $row['f_name'];
                                            $l_name = $row['l_name'];
                                            $account_open_date = $row['account_open_date'];
                                            $balance = $row['account_balance'];
                                            $status = $row['account_status'];
                                            $md = date('Y-m-d',strtotime($term,strtotime($account_open_date)));
                                            $profit = $balance * $interest/100;
                                            $total = $balance + $profit;
                                            ?>
                                            <tr>
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
<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>