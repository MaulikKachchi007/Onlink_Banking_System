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
                            <div class="card-title"><h1 class="text-dark">View Bank Accounts</h1>
                                <p class="text-muted">Views Bank Account Records</p>
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
                                        <th>A/C Open Date</th>
                                        <th>Account No.</th>
                                        <th>Account Type</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $account_balance="";
                                    $sql = "SELECT customers_master.*, accounts.*  FROM customers_master  INNER JOIN accounts ON customers_master.c_id = accounts.c_id where accounts.account_type = 'Saving Account' or accounts.account_type = 'Current Account'";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowcount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $ifsccode = $row['ifsccode'];
                                            $cname = $row['f_name'];
                                            $email = $row['email'];
                                            $acno= $row['account_no'];
                                            $a_type = $row['account_type'];
                                            $account_balance= $row['account_balance'];
                                            $aopendate = $row['account_open_date'];
                                            $status = $row['account_status'];

                                            ?>
                                            <tr>
                                                <td><?php echo $ifsccode; ?></td>
                                                <td><?php echo $cname; ?></td>
                                                <td><?php echo $aopendate; ?></td>
                                                <td><?php echo $acno; ?></td>
                                                <td><?php echo $a_type; ?></td>
                                                <td><?php echo $account_balance; ?></td>
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
                                                            <li><a href="delete_customer_account.php?id=<?php echo $row['c_id']; ?>" onclick="return confirm('Are you sure Delete Account.');" class="dropdown-item"><i class="menu-icon icon-trash"></i>Delete</a></li>
                                                            <li><a href="update_customers_account.php?id=<?php echo $row['c_id']; ?>" class="dropdown-item"><i class="menu-icon icon-edit"></i>Update</a></li>
                                                            <li><a class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $row['c_id']; ?>"><i class="menu-icon icon-edit"></i>View</a></li>
                                                            <li>
                                                                <?php if ($status == "active") {
                                                                    ?>
                                                                    <a href="change_customer_status.php?id=<?php echo $row['c_id']; ?>"  class="dropdown-item">Deactive</a>
                                                                    <?php
                                                                }
                                                                else{
                                                                    ?>
                                                                    <a href="change_customer_status.php?id=<?php echo $row['c_id']; ?>"  class="dropdown-item">Active</a>
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
                                                                            <th>Account Number</th>
                                                                            <td><?php echo  $row['account_no']; ?></td>
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