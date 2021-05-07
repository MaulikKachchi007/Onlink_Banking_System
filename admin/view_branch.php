<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
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
                            <div class="card-title">
                                <h1 class="text-dark">Branch Details</h1>
                                <p class="text text-muted">View Branch Detatils</p>
                            </div>

                            <div class="pull-right" style="text-align: right;">
                                <a href="add_branch.php" class="btn btn-info text-white">Add Record</a>
                                <a href="import_branch.php" class="btn btn-info text-white">Import</a>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <span class="caret"></span></button>
                                        <a class="dropdown-item"  href="export_branch.php">Export CSV</a>
                                        <a class="dropdown-item" target="_blank" href="export_branch_report_pdf.php">Export PDF</a>
                                    </div>
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
                                        <th>Branch Id</th>
                                        <th>IFSC Code</th>
                                        <th>Branch name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $sql = "SELECT * from branch";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowcount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $id = $row['bid'];
                                            $bname = $row['bname'];
                                            $ifsccode = $row['ifsccode'];
                                            $status = $row['status'];
                                            ?>
                                            <tr>
                                                <td><?php echo $id; ?></td>
                                                <td><?php echo $ifsccode; ?></td>
                                                <td><?php echo $bname; ?></td>
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
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="delete_branch.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure Delete Account.');" class="dropdown-item"><i class="menu-icon icon-trash"></i>Delete</a></li>

                                                            <li><a href="update_branch.php?id=<?php echo $id; ?>" class="dropdown-item"><i class="menu-icon icon-edit"></i>Update</a></li>
                                                            <li><a  class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $row['ifsccode']; ?>">View</a></li>
                                                            <li>
                                                                <?php if ($status == "Active") {
                                                                    ?>
                                                                    <a href="change_branch_status.php?id=<?php echo $id; ?>" class="dropdown-item">Un-Verify Branch</a>
                                                                    <?php
                                                                }
                                                                else  if ($status == "Inactive"){
                                                                    ?>
                                                                    <a href="change_branch_status.php?id=<?php echo $id; ?>"  class="dropdown-item">Verify Branch</a>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <div class="modal fade" id="ExampleModal<?php echo $row['ifsccode']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">View Branch</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div  class="modal-body">
                                                                    <table class="table table-bordered table-striped">
                                                                        <tr>
                                                                            <th>IFSC Code</th>

                                                                            <td><?php echo $row['ifsccode']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Branch Name</th>
                                                                            <td><?php echo $row['bname']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Address</th>
                                                                            <td><?php echo $row['address']; ?></td>
                                                                        </tr><tr>
                                                                            <th>City</th>
                                                                            <td><?php echo $row['city']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>state</th>
                                                                            <td><?php echo $row['state']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>country</th>
                                                                            <td><?php echo $row['country']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Status</th>
                                                                            <td><?php echo $row['status']; ?></td>
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