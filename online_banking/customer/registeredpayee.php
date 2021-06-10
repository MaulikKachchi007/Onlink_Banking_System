<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$c_id = $_SESSION['c_id'];
if (isset($_POST["add_registred"])) {
    $bank_account_number = $_POST["bank_account_number"];
    $fund_transfer_type = $_POST["fund_transfer_type"];
    $payeename = $_POST["payeename"];
    $accounttype = $_POST["accounttype"];
    $bankname = $_POST["bankname"];
    $ifsccode = $_POST["ifsccode"];
    if (empty($bank_account_number)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('registeredpayee.php');
    }else{
        global $con;
        $sql = "insert into registered_payee(c_id,registered_payee_type,payee_name,account_no,account_type,bank_name,ifsccode,status)
            VALUES(:c_id,:registered_payee_type,:payee_name,:account_no,:account_type,:bank_name,:ifsccode,:status)";
        // echo "insert into registered_payee(c_id,registered_payee_type,payee_name,account_no,account_type,bank_name,ifsccode,status)
        //     VALUES('$c_id','$fund_transfer_type','$payeename','$bank_account_number','$accounttype','$bankname','$ifsccode','Active')";
        //     die();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':c_id', $c_id);
        $stmt->bindValue(':registered_payee_type', $fund_transfer_type);
        $stmt->bindValue(':payee_name', $payeename);
        $stmt->bindValue(':account_no', $bank_account_number);
        $stmt->bindValue(':account_type', $accounttype);
        $stmt->bindValue(':bank_name', $bankname);
        $stmt->bindValue(':ifsccode', $ifsccode);
        $stmt->bindValue(':status', 'Active');
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['success_message'] = "Registered payee Added Successfully";
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
                                        <h1 class="text-dark">Add Registered Payee</h1>
                                        <p class="text-muted">Enter Registered Detail</p>
                                    </div><!-- /.col -->
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                            <li class="breadcrumb-item active">Add Registered Payee</li>
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
                                    <label for="fund_transfer_type">Fund Transfer Type</label>
                                    <select name="fund_transfer_type" id="fund_transfer_type" class="form-control" onChange="showcustomer(0,this.value)">
                                        <option value="Select" selected>Select Fund Transfer Type</option>
                                        <option value="OctoPrime E-Banking">OctoPrime E-Banking</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div id="regpayee">
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
    function showcustomer(customeracid,fund_transfer_type)
    {
        document.getElementById("regpayee").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
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
                    document.getElementById("regpayee").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
                }
                else
                {
                    document.getElementById("regpayee").innerHTML = this.responseText;
                }
            }
        };
        xmlhttp.open("GET","ajaxregisteredpayee.php?customeracid="+customeracid+"&fund_transfer_type="+fund_transfer_type,true);
        xmlhttp.send();
    }
    function loadbankaccount(customeracid)
    {
        document.getElementById("bankaccount").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
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
                    document.getElementById("bankaccount").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
                }
                else
                {
                    document.getElementById("bankaccount").innerHTML = this.responseText;
                }
            }
        };
        xmlhttp.open("GET","ajaxbankaccount.php?customeracid="+customeracid,true);
        xmlhttp.send();
    }
</script>