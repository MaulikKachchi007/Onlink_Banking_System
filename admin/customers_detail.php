<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['id'];
global $con;
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
                            <div class="card-title"><h1 class="text-dark">View Customers Records</h1>
                                <p class="text-muted">Views Customers Records</p>
                            </div>
                            <div class="pull-right" style="text-align: right;">
                                <a href="add_customer.php" class="btn btn-info text-white">Add Customer</a>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <span class="caret"></span></button>
                                        <a class="dropdown-item"  href="export_customer_account.php">Export CSV</a>
                                        <a class="dropdown-item" target="_blank" href="export_customer_account_pdf.php">Export PDF</a>
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
                                        <th>Customer Name</th>
                                        <th>Email ID</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $sql = "SELECT * FROM customers_master";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowCount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $id = $row['c_id'];
                                            $ifsccode = $row['ifsccode'];
                                            $fname = $row['f_name'];
                                            $lname = $row['l_name'];
                                            $email = $row['email'];
                                            $contact = $row['phone'];
                                            $city = $row['city'];
                                            $status = $row['accountstatus'];

                                            ?>
                                            <tr>
                                                <td><?php echo $ifsccode; ?></td>
                                                <td><?php echo $fname; ?></td>
                                                <td><?php echo $email; ?></td>
                                                <td><?php echo $contact; ?></td>
                                                <td><?php echo $city; ?></td>
                                                <td>
                                                    <?php
                                                    if($status == "active") {
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
                                                            <li><a href="delete_customer_account.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure Delete Account.');" class="dropdown-item"><i class="menu-icon icon-trash"></i>Delete</a></li>
                                                            <li><a href="update_customers_account.php?id=<?php echo $id; ?>" class="dropdown-item"><i class="menu-icon icon-edit"></i>Update</a></li>
                                                            <li><a href="add_acc.php?id=<?php echo $id; ?>" class="dropdown-item"><i class="menu-icon icon-edit"></i>Add Bank Accounts</a></li>
                                                            <li><a class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $row['c_id']; ?>"><i class="menu-icon icon-edit"></i>View</a></li>
                                                            <li>
                                                                <?php if ($status == "active") {
                                                                    ?>
                                                                    <a href="change_customer_status.php?id=<?php echo $id; ?>"  class="dropdown-item">Deactive</a>
                                                                    <?php
                                                                }
                                                                else{
                                                                    ?>
                                                                    <a href="change_customer_status.php?id=<?php echo $id; ?>"  class="dropdown-item">Active</a>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <div class="modal fade" id="ExampleModal<?php echo $row['c_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">View Customers</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div  class="modal-body">
                                                                    <table class="table table-bordered table-striped">
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <td><?php echo $row['c_id']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Branch</th>
                                                                            <td><?php echo $row['ifsccode']; ?> (<?php echo $row['city']; ?>)</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>First Name</th>
                                                                            <td><?php echo $row['f_name']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Last Name</th>
                                                                            <td><?php echo $row['l_name']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Email</th>
                                                                            <td><?php echo $row['email']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Mobile No</th>
                                                                            <td><?php echo $row['phone']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Account Type</th>
                                                                            <td><?php echo  $row['account_type']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Pincode</th>
                                                                            <td><?php echo  $row['pincode']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>City</th>
                                                                            <td><?php echo  $row['city']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Adhar Number</th>
                                                                            <td><?php echo  $row['adharnumber']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Gender</th>
                                                                            <td><?php echo  $row['gender']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Occupation</th>
                                                                            <td><?php echo  $row['occuption']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Status</th>
                                                                            <td><?php echo  $row['accountstatus']; ?></td>
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
