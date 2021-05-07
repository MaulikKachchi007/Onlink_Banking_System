<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$q = "SELECT * FROM accounts";
$stmt = $con->query($q);
while($row = $stmt->fetch()){
    $c_id = $row['c_id'];
}
if (isset($_POST["make_payment"])) {
    $acc_no = $_POST["acc_no"];
    $payment_type = $_POST["payment_type"];
    $paidamt = $_POST["paidamt"];
    $c_id = $_POST["custid"];
    $interest = $_POST["interest"];
    $balance = $_POST['balanceamt'];
    $loan_amount = $_POST['loan_amount'];
    $particulars = $_POST["particulars"];
    $balanceamt = $_POST['balanceamt'];
    $paid_date = date("Y-m-d");
    if (empty($paidamt)  || empty($payment_type)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('loanpayment.php');
    } elseif($paidamt <= 0){
        $_SESSION["error_message"] = "Insufficient Balance.";
        redirect('loanpayment.php');
    } else{
        global $con;
        $sql = "insert into loan_payment(c_id,loan_account_number,loan_amt,interest,total_amt,paid,payment_type,balance,paid_date) 
            VALUES(:c_id,:loan_account_number,:loan_amt,:interest,:total_amt,:paid,:payment_type,:balance,:paid_date)";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(':c_id', $c_id);
        $stmt->bindValue(':loan_account_number', $acc_no);
        $stmt->bindValue(':loan_amt', $loan_amount);
        $stmt->bindValue(':interest', $interest);
        $stmt->bindValue(':total_amt', $_POST['totamt']);
        $stmt->bindValue(':paid', $_POST['paidamt']);
        $stmt->bindValue(':payment_type', 'Account');
        $stmt->bindValue(':balance', $balanceamt);
        $stmt->bindValue(':paid_date', $paid_date);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['success_message'] = "Make Loan Payment Successfully";
        } else {
            $_SESSION['error_message'] = "Something went wrong. Try again!";
        }
    }
}
?>
<?php
include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';
?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card card-default mt-2">
                            <div class="card-header">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6 col-md-6">
                                            <h1 class="text-dark">Make Loan Payemnt</h1>
                                            <p class="text-muted">Enter transaction Detail</p>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Make Loan Payment</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                            </div>
                            <div class="container p-1">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                ?>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="acc_no">Loan Account Number</label>
                                        <input class="form-control" placeholder="Loan Account Number" name="acc_no" onKeyUp="loadloanaccount(this.value)">
                                    </div>
                                    <div id="divcustrecloadid">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
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
<script type="text/javascript">
        function calculatebal(totamt,paidamt)
        {
        document.getElementById("balanceamt").value = totamt - paidamt;
        }
        function loadloanaccount(loanid)
        {
            document.getElementById("divcustrecloadid").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText == 0)
                    {
                        document.getElementById("divcustrecloadid").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
                    }
                    else
                    {
                        document.getElementById("divcustrecloadid").innerHTML = this.responseText;
                    }
                }
            };
            xmlhttp.open("GET","ajaxloanaccount.php?loanaccid="+loanid,true);
            xmlhttp.send();
        }
    </script>