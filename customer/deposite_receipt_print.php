<?php
include('include/DB.php');
include('include/session.php');
include('include/function.php');
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['c_id'];
global $con;
$sql = "SELECT * FROM transaction INNER JOIN accounts ON transaction.to_account_no=accounts.account_no WHERE accounts.c_id='$get_id' and transaction.trans_id='$_GET[id]'  and accounts.account_type='Saving Account' or accounts.account_type='Current Account' AND (transaction.payment_status='active' OR transaction.payment_status='Approved') LIMIT 0,10";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $trans_id = $row['trans_id'];
    $account_no = $row['account_no'];
    $account_balance = $row['account_balance'];
    $particular = $row['particulars'];
    $amount = $row['amount'];
    $transaction_type = $row['transaction_type'];
    $particulars = $row["particulars"];
    $t_datetime = $row['trans_date_time'];
    $approve_date_time = $row['approve_date_time'];
}
$q = "SELECT * FROM customers_master WHERE c_id='$get_id'";
$st = $con->query($q);
while ($rowdata = $st->fetch()) {
    $ifsccode=$rowdata['ifsccode'];
    $name=$rowdata['f_name'];
}
$q = "SELECT * FROM branch WHERE ifsccode='$ifsccode'";
$stm = $con->query($q);
while ($data = $stm->fetch()) {
    $branch = $data['bname'];
    $address = $data['address'];
    $city = $data['city'];
    $state = $data['state'];
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Receipt Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
    <!-- Content Wrapper. Contains page content -->
    <div class="wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                            <h1>Transaction Receipt</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">


                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fa fa-globe"></i> Octo Prime E-Banking
                                        <small class="float-right">Date: <?php
                                            if(strlen($t_datetime)>11){$t_datetime= substr($t_datetime,0,11);}
                                            echo $t_datetime; ?></small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    <address>
                                        <strong>Octo Prime E-Banking</strong><br>
                                        <?php echo $address; ?><br>
                                        <?php echo $city; ?><br>
                                        <?php echo $state; ?><br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Receipt #<?php echo $trans_id; ?></b><br>
                                    <b>Payment Date: </b><?php if(strlen($approve_date_time)>11){$approve_date_time= substr($approve_date_time,0,11);}
                                    echo $approve_date_time; ?></small><br>
                                    <b>Account Number: </b> <?php  echo $account_no;?><br>
                                    <b>IFSC Code: </b><?php  echo $ifsccode; ?>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td><?php echo $name; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Branch</th>
                                            <td><?php echo $branch; ?></td>
                                        </tr>
                                        <tr>
                                            <th>IFSC Code</th>
                                            <td><?php echo $ifsccode; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Account Number</th>
                                            <td><?php echo $account_no; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Transaction Date</th>
                                            <td><?php echo $t_datetime; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Transaction Amount</th>
                                            <td><?php echo $amount; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Particular</th>
                                            <td><?php echo $particulars; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Account Balance</th>
                                            <td><?php echo $account_balance; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>

                            
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>
</body>
</html>