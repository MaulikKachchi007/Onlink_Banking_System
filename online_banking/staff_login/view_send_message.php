<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_SESSION['id'];
$q = "SELECT * FROM employees_master WHERE id ='$get_id'";
$stmt = $con->query($q);
while ($row = $stmt->fetch()){
    $ifsccode = $row['ifsccode'];
}
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
                            <div class="card-title"><h1 class="text-dark">Send Message</h1>
                                <p class="text-muted">Views Messages Records</p>
                            </div>
                            <div class="pull-right" style="text-align: right;">
                                <a href="send_message.php" class="btn btn-info"><i class="fas fa-plus"></i> Compose</a>
                                <a href="view_message.php" class="btn btn-info"><i class="fas fa-reply"></i> Replied Mail</a>
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
                                        <th>Date</th>
                                        <th>Received From</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $sql = "SELECT * FROM mail INNER JOIN  customers_master ON mail.sender_id = customers_master.c_id WHERE customers_master.ifsccode='$ifsccode' and mail.status='Waiting for Response'";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowCount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            if($row['status'] == 'Waiting for Response'){
                                            $id = $row['c_id'];
                                            $datetime = $row['datetime'];
                                            $subject = $row['subject'];
                                            $status = $row['status'];
                                            $f_name = $row['f_name'];
                                            $l_name = $row['l_name'];
                                            ?>
                                            <tr>
                                                <td><?php echo $datetime;?></td>
                                                <td><?php echo $f_name; ?> <?php echo $l_name;?></td>
                                                <td><?php echo $subject;?></td>
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
                                                            <li><a href="delete_message.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure Delete Account.');" class="dropdown-item"><i class="fa fa-trash"></i> Delete</a></li>
                                                            <li><a class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $row['m_id']; ?>"><i class="fa fa-reply"></i> View Mail</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal fade" id="ExampleModal<?php echo $row['m_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">View Mail</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div  class="modal-body">
                                                                    <table class="table table-bordered table-striped">
                                                                        <tr>
                                                                            <th>Sent On</th>
                                                                            <td><?php echo $datetime; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Received From</th>
                                                                            <td><?php echo $f_name; ?> <?php echo $l_name; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Subject</th>
                                                                            <td><?php echo $subject; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Message</th>
                                                                            <td>
                                                                                <textarea rows="5" readonly class="form-control" cols="50"><?php echo $row['message']; ?></textarea>
                                                                            </td>
                                                                        </tr>
                                                                    </table>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="reply_mail.php?id=<?php echo $id; ?>" class="btn btn-success"><i class="fas fa-reply"></i> Reply Mail</a>
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            <?php
                                        }
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