<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
$get_id = $_SESSION['id'];
global $con;
$q = "SELECT * FROM employees_master WHERE id ='$get_id'";
$stmt = $con->query($q);
$stmt->execute();
$row = $stmt->fetch();
    $ifsc_code = $row['ifsccode'];
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
                                <div class="card-title"><h1 class="text-dark">Employee Details</h1></div>

                                <div class="pull-right" style="text-align: right;">
                                    <a href="add_employee.php" class="btn btn-info text-white">Add Record</a>
                                    <a href="import_employee.php" class="btn btn-info text-white">Import</a>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Export
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <span class="caret"></span></button>
                                            <a class="dropdown-item"  href="export_employees.php">Export CSV</a>
                                            <a class="dropdown-item" target="_blank" href="export_employees_pdf.php">Export PDF</a>
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
                                            <th>IFSC Code</th>
                                            <th>Employee Id</th>
                                            <th>Employee name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        global $con;
                                        $sql = "SELECT * from employees_master INNER JOIN branch ON employees_master.ifsccode = branch.ifsccode  WHERE employees_master.ifsccode='$ifsc_code'";
                                        $stmt = $con->query($sql);
                                        $result = $stmt->rowcount();
                                        if ($result > 0)
                                        {
                                            while ($row = $stmt->fetch()) {
                                                $id = $row['id'];
                                                $ename = $row['ename'];
                                                $bname = $row['bname'];
                                                $ifsccode = $row['ifsccode'];
                                                $status = $row['status'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $ifsccode; ?>( <?php echo $bname;?> )</td>
                                                    <td><?php echo $id; ?></td>
                                                    <td><?php echo $ename; ?></td>
                                                    <td><?php echo $status; ?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                                <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="delete_employee.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure Delete Account.');" class="dropdown-item"><i class="menu-icon icon-trash"></i>Delete</a></li>

                                                                <li><a href="update_employee.php?id=<?php echo $id; ?>" class="dropdown-item"><i class="menu-icon icon-edit"></i>Update</a></li>
                                                                <li><a  class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $row['ifsccode']; ?>">View</a></li>
                                                                <li>
                                                                    <?php if ($status == "active") {
                                                                        ?>
                                                                        <a href="change_employee_status.php?id=<?php echo $id; ?>" class="dropdown-item">Un-Verify Employee</a>
                                                                        <?php
                                                                    }
                                                                    else{
                                                                        ?>
                                                                        <a href="change_employee_status.php?id=<?php echo $id; ?>"  class="dropdown-item">Verify Employee</a>
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
                                                                                <th>Employee Name</th>
                                                                                <td><?php echo $row['ename']; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Login ID</th>
                                                                                <td><?php echo $row['loginid']; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Email ID</th>
                                                                                <td><?php echo $row['email']; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Contact</th>
                                                                                <td><?php echo $row['contact']; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Employee Type</th>
                                                                                <td><?php echo $row['employee_type']; ?></td>
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