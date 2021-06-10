<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$c_id = $_SESSION['c_id'];
if (isset($_POST["submit"])) {
    $acc_no = $_POST["loan_account_number"];
    $paidamt = $_POST["paid_amt"];
    $account = $_POST['account'];
    $loan_amount = $_POST['loan_amount'];
    $interest = $_POST["interest"];
    $balance = $_POST['bal_amt'];
    $totamt = $_POST['totamt'];
    $paid_date = date("Y-m-d");
    $trans_date_time =date("Y-m-d");
    if (empty($paid_date)) {
        $_SESSION["error_message"] = "All must fill required.";
    }else {
        global $con;
        $sql = "INSERT INTO loan_payment(c_id,loan_account_number,loan_amt,interest,total_amt,paid,payment_type,balance,paid_date) 
                VALUES(:c_id,:loan_account_number,:loan_amt,:interest,:total_amt,:paid,:payment_type,:balance,:paid_date)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':c_id',$c_id);
        $stmt->bindValue(':loan_account_number',$acc_no);
        $stmt->bindValue(':loan_amt',$loan_amount);
        $stmt->bindValue(':interest',$interest);
        $stmt->bindValue(':total_amt',$totamt);
        $stmt->bindValue(':paid',$paidamt);
        $stmt->bindValue(':payment_type','Debit');
        $stmt->bindValue(':balance',$balance);
        $stmt->bindValue(':paid_date',$paid_date);
        $result = $stmt->execute();
        $sql = "insert into transaction(to_account_no ,amount,comission,particulars,transaction_type,trans_date_time,approve_date_time,payment_status) 
                VALUES(:to_account_no ,:amount,:comission,:particulars,:transaction_type,:trans_date_time,:approve_date_time,:payment_status) ";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':to_account_no', $account);
        $stmt->bindValue(':amount', $paidamt);
        $stmt->bindValue(':comission', '0');
        $stmt->bindValue(':particulars', "To Paid Loan Amount");
        $stmt->bindValue(':transaction_type', 'Debit');
        $stmt->bindValue(':trans_date_time', $trans_date_time);
        $stmt->bindValue(':approve_date_time',$paid_date);
        $stmt->bindValue(':payment_status', 'Active');
        $result = $stmt->execute();
        $sql = "UPDATE accounts SET account_balance= account_balance -  $paidamt  WHERE account_no='$account'";
        $stmt = $con->query($sql);
        if ($result) {
            $_SESSION['success_message'] = "Loan Payment Successfully";
        }else{
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
                                            <h1 class="text-dark">Make Loan Payment</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Loan Payment</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_loan_accounts.php" class="btn btn-info float-right text-white">View Record</a>
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
                                        <label for="loan_account_number">Loan Account Number</label>
                                        <select class="form-control"  name="loan_account_number" id="loan_account_number" onChange="load_account_change(this.value)">
                                            <option value="Select" selected>Select</option>
                                            <?php
                                                global $con;
                                                $c_id = $_SESSION['c_id'];
                                                $sql = "SELECT * FROM loan WHERE c_id = '$c_id' AND status = 'Approved'";
                                                $stmt = $con->query($sql);
                                                while ($row = $stmt->fetch()) {
                                                    $loan_account_number = $row["loan_account_number"];
                                            ?>
                                                <option value="<?php echo $loan_account_number;?>"><?php echo $loan_account_number;?></option>
                                        </select>
                                            <?php
                                                }
                                            ?>

                                    </div>
                                    <div id="loading_data">
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
require_once 'include/footer.php';
?>
<script type="text/javascript">
    function calculatebal(totamt,paidamt)
    {
        document.getElementById("balanceamt").value = totamt - paidamt;
    }
    function load_account_change(loan_account_number) {
        document.getElementById("loading_data").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
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
                    document.getElementById("loading_data").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
                }
                else
                {
                    document.getElementById("loading_data").innerHTML = this.responseText;
                }
            }
        };
        xmlhttp.open("GET","ajaxloanaccount.php?loan_account_number="+loan_account_number,true);
        xmlhttp.send();
    }
</script>
<script>
    function showcustomer(account_number)
    {
        document.getElementById("show_customer_record").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";


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
                    document.getElementById("show_customer_record").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
                }
                else
                {
                    document.getElementById("show_customer_record").innerHTML = this.responseText;
                }
            }
        };
        xmlhttp.open("GET","ajaxloanpayment.php?account_number="+account_number,true);
        xmlhttp.send();
    }
</script>

