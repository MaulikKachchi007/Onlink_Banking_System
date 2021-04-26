<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
$get_id = $_SESSION['c_id'];
global $con;
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
                            <div class="card-title"><h1 class="text-dark">View Registered Payee</h1>
                                <p>View Registered Payee Records</p>
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
                                    <th>Payee Name</th>
                                    <th>Bank Account Number</th>
                                    <th>Account Type</th>
                                    <th>Bank Name</th>
                                    <th>IFSC Code</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                global $con;
                                $sql = "SELECT * from registered_payee 
                                        WHERE status='Active'";
                                $stmt = $con->query($sql);
                                $result = $stmt->rowcount();
                                if ($result > 0)
                                {
                                    while ($row = $stmt->fetch()) {
                                        $registered_payee_id  = $row['registered_payee_id'];
                                        $payee_name = $row['payee_name'];
                                        $account_no = $row['account_no'];
                                        $account_type = $row['account_type'];
                                        $bank_name = $row['bank_name'];
                                        $ifsccode = $row['ifsccode'];
                                        $status = $row['status'];
                                        ?>
                                        <tr>
                                            <td><?php echo $payee_name; ?></td>
                                            <td><?php echo $account_no; ?></td>
                                            <td><?php echo $account_type; ?></td>
                                            <td><?php echo $bank_name; ?></td>
                                            <td><?php echo $ifsccode; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                        <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="update_custregisteredpayee.php?id=<?php echo $registered_payee_id;?>"  class="dropdown-item">Edit</a></li>
                                                    </ul>
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