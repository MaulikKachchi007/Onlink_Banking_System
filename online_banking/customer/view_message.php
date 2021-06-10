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
                            <div class="card-title"><h1 class="text-dark">Message Send Admin</h1>
                                <p class="text-muted">Views Reply Messages Records</p>
                            </div>
                            <div class="pull-right" style="text-align: right;">
                                <a href="send_message.php" class="btn btn-info"><i class="fas fa-plus"></i> Compose</a>
                                <a href="view_send_message.php" class="btn btn-info"><i class="fas fa-paper-plane"></i> Send Mail</a>
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
                                        <th>Account Number</th>
                                        <th>Send Date</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $sql = "SELECT * FROM mail WHERE sender_id='$get_id' and status='Adminstrator Replied'";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowCount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $id = $row['m_id'];
                                            $subject = $row['subject'];
                                            $message = $row['message'];
                                            $datetime = $row['datetime'];
                                            $account_no = $row['account_no'];
                                            $status = $row['status'];
                                            ?>
                                            <tr>
                                                <td><?php  echo str_pad(substr($account_no,-2),13,'X',STR_PAD_LEFT); ?></td>
                                                <td><?php echo $datetime; ?></td>
                                                <td><?php echo $subject; ?></td>
                                                <td>
                                                    <?php
                                                    if($status == "Adminstrator Replied") {
                                                        echo "<div class='badge badge-success'>".$status.'</div>';
                                                    }
                                                    else{
                                                        echo "<div class='badge badge-danger'>".$status.'</div>';
                                                    }?>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="delete_mail.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure Delete Mail.');" class="dropdown-item"><i class="menu-icon icon-trash"></i>Delete</a></li>
                                                            <li><a class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $row['m_id']; ?>"><i class="menu-icon icon-edit"></i>View</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal fade" id="ExampleModal<?php echo $row['m_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">View Customers</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table id="example1" class="table table-bordered table-striped">
                                                                        <tr>
                                                                            <th>Date</th>
                                                                            <th><?php echo  $row['datetime']; ?></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Account Number</th>
                                                                            <td><?php echo  $row['account_no']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Subject</th>
                                                                            <td><?php echo  $row['subject']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Message</th>
                                                                            <td>
                                                                                <textarea class="form-control" rows="5" cols="30" readonly><?php echo  $row['admin_response']; ?></textarea>
                                                                            </td>
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
<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>