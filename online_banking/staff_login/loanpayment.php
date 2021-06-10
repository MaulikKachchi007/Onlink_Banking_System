<?php
require_once 'include/DB.php';
require_once 'include/function.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$q = "SELECT * FROM accounts";
$stmt = $con->query($q);
while($row = $stmt->fetch()){
    $c_id = $row['c_id'];
}
if (isset($_POST["make_payment"])) {
    $acc_no = $_POST["account_no"];
    $paidamt = $_POST["paidamt"];
    $c_id = $_POST["custid"];
    $interest = $_POST["interest"];
    $particulars = $_POST["particulars"];
    $approve_date_time = date("Y-m-d");
    $trans_date_time = date("Y-m-d");
    if (empty($paidamt) || empty($particulars)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('loanpayment.php');
    } elseif($paidamt <= 0){
        $_SESSION["error_message"] = "Insufficient Balance.";
        redirect('loanpayment.php');
    } else{
        global $con;
        $sql = "INSERT INTO transaction(to_account_no,amount,comission,particulars,transaction_type,trans_date_time,approve_date_time,payment_status) 
                VALUES(:to_acc_no,:amount,:comission,:particulars,:transaction_type,:trans_date_time,:approve_date_time,:payment_status)";

        $stmt->bindValue(':to_acc_no',$acc_no);
        $stmt->bindValue(':amount',$paidamt);
        $stmt->bindValue(':comission','0');
        $stmt->bindValue(':particulars',$particulars);
        $stmt->bindValue(':transaction_type','Credit');
        $stmt->bindValue(':trans_date_time', $trans_date_time);
        $stmt->bindValue(':approve_date_time',$approve_date_time);
        $stmt->bindValue(':payment_status','Active');
        $result = $stmt->execute();
        $q = "UPDATE accounts SET account_balance= account_balance +  $paidamt  WHERE account_no='$acc_no'";
        $st = $con->query($q);
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
require_once 'include/header.php';
require_once 'include/sidebar.php';
require_once 'include/topbar.php';
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
<?php
require_once 'include/footer.php';
?>