<?php
include('include/DB.php');
include('include/session.php');
include('include/function.php');

$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
?>
<?php
include('include/header.php');
include('include/topbar.php');
include('include/sidebar.php');
?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Customers</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Customer Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Account Number</th>
                                        <th>Account Type</th>
                                        <th>Account Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                echo ErrorMessage();
                                                echo SuccessMessage();
                                                global $con;

                                                $sql = "SELECT customers_master.*, accounts.account_no  FROM customers_master  INNER JOIN accounts ON customers_master.c_id = accounts.c_id";
                                                $stmt = $con->prepare($sql);
                                                $result = $stmt->execute();
                                                $num_rows = $stmt->rowcount();
                                                if($num_rows > 0)
                                                {
                                                while ($row = $stmt->fetch()) {
                                                    $id = $row['c_id'];
                                                    $f_name = $row['f_name'];
                                                    $accounts_type = $row['account_type'];
                                                    $accounts_status = $row['accountstatus'];
                                                    $account_no = $row['account_no'];
                                                ?>

                                            <tr>
                                                <td><?php echo $id;?></td>
                                                <td><?php echo $f_name;?></td>
                                                <td><?php echo $account_no;?></td>
                                                <td><?php echo $accounts_type;?></td>
                                                <td><?php echo $accounts_status;?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action<span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="delete_customer_account.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure Delete Account.');" class="dropdown-item"><i class="menu-icon icon-trash"></i>Delete</a></li>
                                                            <li><a href="update_customers_account.php?id=<?php echo $id; ?>" class="dropdown-item"><i class="menu-icon icon-edit"></i>Update</a></li>
                                                            <li><a href="customer_balance.php?id=<?php echo $id; ?>" class="dropdown-item"><i class="menu-icon icon-edit"></i>Add Amount</a></li>
                                                            <li>
                                                            <?php if ($accounts_status == "active") {
                                                                    ?>
                                                            <li><a href="change_customer_status.php?id=<?php echo $id;?>" class="dropdown-item">Un-verify Account</a></li>
                                                                <?php
                                                                }
                                                                else{
                                                                ?>
                                                                    <li><a href="change_customer_status.php?id=<?php echo $id;?>" class="dropdown-item">Verify Account</a></li>
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
                                            }
                                            else {
                                                $_SESSION['error_message'] = "Record not found";
                                            }
                                            ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Account Number</th>
                                        <th>Account Type</th>
                                        <th>Account Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->

    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<footer class="main-footer text-center">
    <strong>Copyright &copy; <?php  echo date("Y");?> <a href="http://adminlte.io"></a>BOB.com</strong>
    All rights reserved.
</footer>
<?php
include('include/footer.php');
?>

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
</body>
</html>