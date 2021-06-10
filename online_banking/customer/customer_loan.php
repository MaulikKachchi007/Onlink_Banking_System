<?php
include 'include/DB.php';
include 'include/function.php';
//include 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_SESSION['c_id'];
$lastid='';
$q = "SELECT * FROM loan order by loan_id desc limit  1";
$stmt = $con->query($q);
$res = $stmt->execute();
while ($row = $stmt->fetch()) {
    $lastid = $row['loan_account_number'];
}
if ($lastid == "") {
    $loanappnum = "LAN0000001";
}else {
    $loanappnum = substr($lastid,8);
    $loanappnum = intval($loanappnum);
    $loanappnum = "LAN000000".($loanappnum + 1);
}
if (isset($_POST["apply_loan"])) {
    $loan_account_number = $_POST['loan_app_number'];
    $min_amt = $_POST['min_amt'];
    $max_amt = $_POST['max_amt'];
    $get_id = $_SESSION['c_id'];
    $loan_type_id = $_POST['l_type'];
    $loan_amount = $_POST['loan_amt'];
    $intrest = $_POST['int_amt'];
    $createddate = date('Y-m-d');
    $status = "Pending";
    if (empty($loan_amount)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('customer_loan.php');
    }elseif($min_amt >= $loan_amount){
         $_SESSION["error_message"] = "Loan amount must be greater than {$min_amt}.";
         redirect('customer_loan.php');
    }elseif ($max_amt <= $loan_amount){
        $_SESSION["error_message"] = "Loan amount must be Less than {$max_amt}.";
        redirect('customer_loan.php');
    }else {
        global $con;
        $sql = "INSERT INTO loan(loan_account_number,c_id,id,loan_amount,intrest,created_date,status)
                VALUES(:loan_account_number,:c_id,:id,:loan_amount,:intrest,:created_date,:status)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':loan_account_number',$loan_account_number);
        $stmt->bindValue(':c_id',$get_id);
        $stmt->bindValue(':id',$loan_type_id);
        $stmt->bindValue(':loan_amount',$loan_amount);
        $stmt->bindValue(':intrest',$intrest);
        $stmt->bindValue(':created_date',$createddate);
        $stmt->bindValue(':status',$status);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Loan Application and Application Number {$loan_account_number} Successfully";
        }else{
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
                                            <h1 class="text-dark">Loan Application</h1>
                                            <p class="text-muted">Enter Loan Details</p>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add Loan</li>
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
                                        <label for="loan_account_number">Loan Application Number</label>
                                        <?php
                                            global $con;
                                            $q = "SELECT * FROM accounts WHERE c_id='$get_id'";
                                            $stmt = $con->query($q);
                                            $row = $stmt->fetch();
                                            $account_no = $row['account_no'];
                                        ?>
                                        <input class="form-control" style="color: red;" value="<?php echo $loanappnum; ?>" name="loan_app_number" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="l_type">Loan Type</label>
                                        <select name="l_type" class="form-control" onchange="loadloanrec(this.value)">
                                            <option value="Select" selected>Select</option>
                                            <?php
                                            global $con;
                                            $q = "SELECT * FROM loan_type_master WHERE status='Active'";
                                            $stmt = $con->query($q);
                                            $row = $stmt->fetch();
                                            while ($row = $stmt->fetch()){
                                                $id = $row['id'];
                                                $loan_type = $row['loan_type'];
                                                $min_amt = $row['min_amt'];
                                                $max_amt = $row['max_amt'];
                                                $interest= $row['interest'];
                                                $term = $row['terms'];
                                            ?>
                                                <option value="<?php echo $id;?>"><?php echo $loan_type;?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 margin-bottom-15">
                                        <span id="jsloantype" ></span>
                                    </div>
                                    <div id="loanloading"><img src="image/LoadingSmall.gif" width="172" height="172" /></div>

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
    function loadloanrec(id) {
        if(window.XMLHttpRequest){
            xmlhttp = new XMLHttpRequest();
        }else{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status==200){
                document.getElementById('loanloading').innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxloan.php?id="+id,true);
        xmlhttp.send();
    }
    function calculategrandtotal()
    {
        //alert(d   ocument.getElementById("amtloanamount").value);
        document.getElementById("totalintrest").value = parseFloat(document.getElementById("loan_amt").value) * parseFloat(document.getElementById("interest").value) /100;
        // )/100;
        document.getElementById("grandtotal").value = parseFloat(document.getElementById("loan_amt").value) * parseFloat(document.getElementById("interest").value) /100 + parseFloat(document.getElementById("loan_amt").value);

    }
</script>
<?php
include 'include/footer.php';
?>