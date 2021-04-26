<?php
include('include/DB.php');
include('include/session.php');
include('include/function.php');
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['c_id'];
global $con;
$sql = "SELECT * from loan_type_master 
        INNER JOIN loan ON loan_type_master.id=loan.id WHERE loan.status='Approved'";
$stmt = $con->query($sql);
while ($rowdata = $stmt->fetch()){
    $loan_amount = $rowdata['loan_amount'];
    $loan_type = $rowdata['loan_type'];
    $interest  = $rowdata['interest'];
    $loan_amount  = $rowdata['loan_amount'];
    $interest_amt = $loan_amount * $interest /100;
    $terms  = $rowdata['terms'];
}
$sql = "SELECT * from customers_master
        INNER JOIN loan_payment ON customers_master.c_id=loan_payment.c_id WHERE loan_payment.c_id='$get_id'";
$stmt = $con->query($sql);
$result = $stmt->rowcount();
while ($row = $stmt->fetch()) {
    $pay_id = $row['payment_id'];
    $f_name = $row['f_name'];
    $loan_account_number = $row['loan_account_number'];
    $paid = $row['paid'];
    $payment_type = $row['payment_type'];
    $paid_date = $row['paid_date'];
    $ifsccode = $row['ifsccode'];
    $total_payable = $loan_amount + $interest;
    $balance = $row['balance'];
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
                    <h1 class="text text-center">Transaction Receipt</h1>
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
                                        if(strlen($paid_date)>11){$t_datetime= substr($paid_date,0,11);}
                                        echo $paid_date; ?></small>
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
                                <b>Receipt #<?php echo $pay_id; ?></b><br>
                                <b>Payment Date: </b><?php echo $paid_date; ?></small><br>
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
                                        <td><?php echo $f_name; ?></td>
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
                                        <th>Loan Account Number</th>
                                        <td><?php echo $loan_account_number; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Transaction Date</th>
                                        <td><?php echo $paid_date; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Transaction Amount</th>
                                        <td><?php echo $paid; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Type</th>
                                        <td><?php echo $payment_type; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Account Balance</th>
                                        <td><?php echo $balance; ?></td>
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