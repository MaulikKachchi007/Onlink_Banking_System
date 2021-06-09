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
                            <div class="card-title"><h1 class="text-dark">Loan Details</h1></div>

                            <div class="pull-right" style="text-align: right;">
                                <a href="add_loantype.php" class="btn btn-info text-white">Add Record</a>
                                <a href="import_loantype.php" class="btn btn-info text-white">Import</a>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export
                                    </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <span class="caret"></span></button>
                                    <a href="loan_export_type.php" name="import_account" class="dropdown-item">Export CSV</a>
                                    <a class="dropdown-item" target="_blank" href="loan_type_export_pdf.php">Export PDF</a>
                                </div>
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
                                        <th>Loan id</th>
                                        <th>Loan Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $sql = "SELECT * from loan_type_master";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowcount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $id = $row['id'];
                                            $l_type = $row['loan_type'];
                                            $status = $row['status'];
                                            ?>
                                            <tr>
                                                <td><?php echo $id; ?></td>
                                                <td><?php echo $l_type; ?></td>
                                                <td>
                                                    <?php
                                                    if($status == "Active"){
                                                        echo "<div class='badge badge-success'>$status</div>";
                                                    }elseif($status == "Inactive"){
                                                        echo "<div class='badge badge-danger'>$status</div>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="delete_loan_type.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure Delete Loan Type.');" class="dropdown-item"><i class="menu-icon icon-trash"></i>Delete</a></li>
                                                            <li><a href="update_loan_type.php?id=<?php echo $id; ?>" class="dropdown-item"><i class="menu-icon icon-edit"></i>Update</a></li>
                                                            <li><a  class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $row['id']; ?>">View</a></li>
                                                            <li>
                                                                <?php if ($status == "Active") {
                                                                    ?>
                                                                    <a href="loantype_change_status.php?id=<?php echo  $id; ?>" onclick="return confirm('Are you sure you want to Loan type Deactived?')" class="dropdown-item">Deactive</a>
                                                                    <?php
                                                                }
                                                                elseif ($status == "Inactive"){
                                                                    ?>
                                                                    <a href="loantype_change_status.php?id=<?php echo $id ?>" onclick="return confirm('Are you sure you want to Loan type activated?')" class="dropdown-item">Active</a>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <div class="modal fade" id="ExampleModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">View Accounts Type</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div  class="modal-body">
                                                                    <table class="table table-bordered table-striped">
                                                                        <tr>
                                                                            <th>Loan ID</th>
                                                                            <td><?php echo $row['id']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Loan Type</th>
                                                                            <td><?php echo $row['loan_type']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Prefix</th>
                                                                            <td><?php echo $row['prefix']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Minimum Balance</th>
                                                                            <td><?php echo $row['min_amt']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Interest</th>
                                                                            <td><?php echo $row['interest']; ?> (percentage)</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Terms</th>
                                                                            <td><?php echo $row['terms']; ?> (years)</td>
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