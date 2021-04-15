<?php
    include('include/DB.php');
    include('include/session.php');
    include('include/function.php');
   $_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
   confirm_login();
    $get_id = $_SESSION['c_id'];
    global $con;
    $sql = "SELECT * FROM accounts WHERE c_id = '$get_id'";
    $stmt = $con->query($sql);
    while ($row = $stmt->fetch()) {
        $account_no = $row['account_no'];
        $account_type = $row['account_type'];
        $balance = $row['account_balance'];
        $account_open_date = $row['account_open_date'];
        $interest = $row['interest'];
    }
?>
<?php
include('include/header.php');
include('include/topbar.php');
include('include/sidebar.php');
?>
<!-- Content Wrapper. Contains page content -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container">
        <?php
            echo ErrorMessage();
            echo SuccessMessage();
        ?>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>

                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>

                            <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Bank Accounts</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <tbody>
                        <tr>
                            <th>Account Open Date</th>
                        
                             <td><?php echo $account_open_date; ?></td>
                        </tr>
                        <tr>
                            <th>Account No.</th>
                            <td><?php echo str_pad(substr($account_no,-2),13,'X',STR_PAD_LEFT); ?></td>
                        </tr>
                        <tr>
                            <th>Account Type.</th>
                            <td><?php echo $account_type; ?></td>
                        </tr>
                        <tr>
                            <th>Interest</th>
                            <td><?php echo $interest; ?></td>
                        </tr>
                        <tr>
                            <th>Balance</th>
                            <td>&#8377; <?php echo $balance; ?></td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="view_bank_accounts.php" class="btn btn-sm btn-primary float-right">View All</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
                <div class="card card-primary ml-3">
                    <div class="card-header border-0">
                        <h3 class="card-title">Mini Statement</h3>
                        <div class="card-tools">
                            <a href="mini_statement.php" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table  id="example1" class="table table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>Account No</th>
                                <th>Amount</th>
                                <th>Particulars</th>
                                <th>Transaction Types</th>
                                <th>Transaction Date Time</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                global $con;
//                            $sql ="SELECT * FROM transaction INNER JOIN  accounts ON transaction.to_acc_no=accounts.acc_no WHERE accounts.customer_id='$_SESSION[customer_id]' AND (transaction.payment_status='Active' OR transaction.payment_status='Approved')  LIMIT 0,10 ";
                                $sql = "SELECT * FROM transaction INNER JOIN accounts ON transaction.to_account_no=accounts.account_no WHERE accounts.c_id='$get_id' AND (transaction.payment_status='active' OR transaction.payment_status='Approved') LIMIT 0,10";
                                $stmt = $con->query($sql);
                                while ($row = $stmt->fetch()) {
                                $trans_id = $row['trans_id'];
                                $account_no = $row['account_no'];
                                $account_balance = $row['account_balance'];
                                $particular = $row['particulars'];
                                $transaction_type = $row['transaction_type'];
                                $t_datetime = $row['trans_date_time'];
                                }
                            ?>
                            <tr>
                                <td><?php echo $account_no;?></td>
                                <td><?php echo $account_balance;?></td>
                                <td><?php echo $particular;?></td>
                                <td><?php echo $transaction_type;?></td>
                                <td><?php echo $t_datetime;?></td>
                                <td><a href="depoitemoneyreceipt.php?id=<?php echo $trans_id;?>" target="_blank" class="btn btn-primary">Receipt</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
          </div>
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer text-center">
    <strong>Copyright &copy; <?php  echo date("Y");?> <a href="http://adminlte.io"></a>BOB.com</strong>
    All rights reserved.
</footer>

<?php
    include('include/footer.php');
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