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
                                                <td><?php echo $status; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="delete_loan_type.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure Delete Loan Type.');" class="dropdown-item"><i class="menu-icon icon-trash"></i>Delete</a></li>

                                                            <li><a href="update_loan_type.php?id=<?php echo $id; ?>" class="dropdown-item"><i class="menu-icon icon-edit"></i>Update</a></li>
                                                            <li>
                                                                <?php if ($status == "active") {
                                                                    ?>
                                                                    <a href="loantype_change_status.php?id=<?php echo  $id; ?>" onclick="return confirm('Are you sure you want to Loan type Deactived?')" class="dropdown-item">Deactive</a>
                                                                    <?php
                                                                }
                                                                else{
                                                                    ?>
                                                                    <a href="loantype_change_status.php?id=<?php echo $id ?>" onclick="return confirm('Are you sure you want to Loan type activated?')" class="dropdown-item">Active</a>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </li>

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
