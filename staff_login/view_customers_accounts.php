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
                            <div class="pull-right" style="text-align: right;">
                                <a href="add_account.php" class="btn btn-info text-white">Add Record</a>
                                <a href="import_account.php" class="btn btn-info text-white">Import</a>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Export
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <span class="caret"></span></button>
                                        <a class="dropdown-item"  href="export_account.php">Export CSV</a>
                                        <a class="dropdown-item" target="_blank" href="account_type_export_pdf.php">Export PDF</a>
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
                                        <th>Customer Name</th>
                                        <th>Login ID</th>
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
                                    $sql = "SELECT customers_master.*, accounts.*  FROM customers_master  INNER JOIN accounts ON customers_master.c_id = accounts.c_id";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowcount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $cname = $row['f_name'];
                                            $email = $row['email'];
                                            $acno= $row['account_no'];
                                            $a_type = $row['account_type'];
                                            $account_balance= $row['account_balance'];
                                            $aopendate = $row['account_open_date'];
                                            $status = $row['account_status'];

                                            ?>
                                            <tr>
                                                <td><?php echo $cname; ?></td>
                                                <td><?php echo $email; ?></td>
                                                <td><?php echo $aopendate; ?></td>
                                                <td><?php echo $acno; ?></td>
                                                <td><?php echo $a_type; ?></td>
                                                <td><?php echo $account_balance; ?></td>
                                                <td><?php echo $status; ?></td>

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
