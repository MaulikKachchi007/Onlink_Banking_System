<?php
    require_once('include/DB.php');
    require_once('include/session.php');
    require_once('include/function.php');
   $_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
   confirm_login();
    $get_id = $_SESSION['c_id'];
    global $con;

    $sql = "SELECT * FROM accounts INNER JOIN customers_master ON customers_master.c_id = accounts.c_id WHERE accounts.c_id='$get_id' and accounts.account_type = 'Saving Account' or accounts.account_type = 'Current Account' ";
    $stmt = $con->query($sql);
    while ($row = $stmt->fetch()) {
        $account_no = $row['account_no'];
        $account_type = $row['account_type'];
        $balance = $row['account_balance'];
        $account_open_date = $row['account_open_date'];
        $interest = $row['interest'];
        $birthdate = $row['birthdate'];
    }
?>
<?php
require_once('include/header.php');
require_once('include/topbar.php');
require_once('include/sidebar.php');
?>
<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                            <h3><?php  if(empty(CreditTransaction())) {  echo 0;} else { echo CreditTransaction();}  ?><span>&#8377;</span></h3>

                            <p>Credit Transaction</p>
                        </div>
                        <div class="icon">
                        <i class="fas fa-rupee-sign"></i>
                        </div>
                        <a href="view_transaction.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php if(empty(DebitTransaction())) {  echo 0;} else { echo DebitTransaction();} ?><span>&#8377;</span></h3>
                            <p>Debit Transaction</p>
                        </div>
                        <div class="icon">
                        <i class="fas fa-rupee-sign"></i>
                        </div>
                        <a href="view_transaction.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                        <h3><?php if(empty(total_loan_account())) {  echo 0;} else { echo total_loan_account();} ?><span>&#8377;</span></h3>
                            <p>Loan Account</p>
                        </div>
                        <div class="icon">
                        <i class="fas fa-rupee-sign"></i>
                        </div>
                        <a href="view_loan_accounts.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php if(empty(total_fixed_deposits())) {  echo 0;} else { echo total_fixed_deposits();} ?><span>&#8377;</span></h3>

                            <p>Fixed Deposite</p>
                        </div>
                        <div class="icon">
                        <i class="fas fa-rupee-sign"></i>
                        </div>
                        <a href="view_fd_account.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                <!-- BAR CHART -->
                <div class="card card-primary ml-3">
                    <div class="card-header">
                        <h3 class="card-title">Income and Expense Reports</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- /.card -->
                <div class="row" style="width: 100%;">
                    <div class="col-lg-12 col-md-12">
                        <div class="card card-primary ml-3">
                            <div class="card-header border-0">
                                <h3 class="card-title">Mini Statement</h3>
                                <div class="card-tools">
                                    <a href="mini_statement.php?birthdate=<?php echo substr($birthdate,0,4);?>" class="btn btn-tool btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card card-body">
                                <table id="example1" class="table table-striped table-bordered table-responsive">
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
                                    $sql = "SELECT * FROM transaction 
                                    INNER JOIN accounts ON transaction.to_account_no= accounts.account_no WHERE
                                    accounts.c_id='$get_id' and (accounts.account_type='Saving Account' or accounts.account_type='Current Account') AND (transaction.payment_status='Active' or transaction.payment_status='Approved')  ORDER BY transaction.trans_id DESC LIMIT 0,10";
                                    $stmt = $con->query($sql);
                                    while ($row = $stmt->fetch()) {
                                        $trans_id = $row['trans_id'];
                                        $account_no = $row['account_no'];
                                        $account_balance = $row['amount'];
                                        $particular = $row['particulars'];
                                        $transaction_type = $row['transaction_type'];
                                        $t_datetime = $row['trans_date_time'];
                                        ?>
                                        <tr>
                                            <td><?php echo $account_no;?></td>
                                            <td>&#8377;  <?php echo $account_balance;?></td>
                                            <td><?php echo $particular;?></td>
                                            <td><?php echo $transaction_type;?></td>
                                            <td><?php echo $t_datetime;?></td>
                                            <td><a href="depoitemoneyreceipt.php?id=<?php echo $trans_id;?>" target="_blank" class="btn btn-primary">Receipt</a></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
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
    $exps= ExpensebarChart();
    $data = array();
    foreach($exps as $exp) {
        $expense[] = $exp['y'];
        $label[] = $exp['label'];
    }
    $incs = IncomebarChart();
    $data = array();
    foreach($incs as $inc) {
    $income[] = $inc['y'];
    $label[] = $inc['label'];
    }
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
    var areaChartData = {
        labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October','November','December'],
        datasets: [
            {
                label: 'Expense',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: <?php echo json_encode($expense); ?>
            },
            {
                label               : 'Income',
                backgroundColor     : 'rgba(210, 214, 222, 1)',
                borderColor         : 'rgba(210, 214, 222, 1)',
                pointRadius         : false,
                pointColor          : 'rgba(210, 214, 222, 1)',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: <?php echo json_encode($income); ?>,

            },
        ]
    }
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0
    var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : true,
        datasetFill             : true
    }
    var barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })
    });
</script>
<script src="assets/plugins/chart.js/Chart.min.js"></script>
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
