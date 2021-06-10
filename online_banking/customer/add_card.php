<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_SESSION['c_id'];
$lastid='';
$q = "SELECT * FROM cards order by card_no desc limit  1";
$stmt = $con->query($q);
$res = $stmt->execute();
while ($row = $stmt->fetch()) {
    $lastid = $row['card_no'];
}
if ($lastid == "") {
    $card_num = "5453200000000001";
}else {
    $card_num = substr($lastid,15);
    $card_num = intval($card_num);
    $card_num = "545320000000000".($card_num + 1);
}
$q = "SELECT * FROM cards order by card_application_number desc limit  1";
$stmt = $con->query($q);
if ($lastid == "") {
    $card_app_num = "CT00000001";
}else {
    $card_app_num = substr($lastid,10);
    $card_app_num = intval($card_num);
    $card_app_num = "CT0000000".($card_app_num + 1);
}
if (isset($_POST["apply_card"])) {
    $account_number = $_POST['account_number'];
    $card_application_number = $_POST['card_application_number'];
    $card_type = $_POST['card_type'];
    $reason = $_POST['reason'];
    $balance = $_POST['balance'];
    $get_id = $_SESSION['c_id'];
    $card_number = $_POST['card_number'];
    $startdate = date('Y-m-d');
        $q = "Select * from card_type_master WHERE id='$card_type'";
        $stmt = $con->query($q);
        while ($row = $stmt->fetch()) {
            $min_amt = $row['min_amt'];
            $max_amt = $row['max_amt'];
            $terms = "$row[terms] years";
        }
    $enddate = date('Y-m-d',strtotime($terms,strtotime($startdate)));
    $cvv = rand(0,1000);
    $status = "Pending";
    if (empty($card_type) || empty($reason)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('add_card.php');
    }elseif($balance <= $min_amt){
        $_SESSION["error_message"] = "Insufficient Balance.";
        redirect('add_card.php');
    }else {
        global $con;
        $sql = "INSERT INTO cards(card_application_number,card_no,c_id,id,reason,startdate,enddate,cvv,status)
                VALUES(:card_application_number,:card_no,:c_id,:id,:reason,:startdate,:enddate,:cvv,:status)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':card_application_number',$card_application_number);
        $stmt->bindValue(':card_no',$card_number);
        $stmt->bindValue(':c_id',$get_id);
        $stmt->bindValue(':id',$card_type);
        $stmt->bindValue(':reason',$reason);
        $stmt->bindValue(':startdate',$startdate);
        $stmt->bindValue(':enddate',$enddate);
        $stmt->bindValue(':cvv',$cvv);
        $stmt->bindValue(':status',$status);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Cards Apply Successfully";
            redirect('add_card.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
            redirect('add_card.php');
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
                                            <h1 class="text-dark">Card Application</h1>
                                            <p class="text-muted">Enter Card Details</p>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add Cards</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_cards.php" class="btn btn-info float-right text-white">View Record</a>
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
                                    <input type="hidden" name="card_number" value="<?php echo $card_num;?>">
                                    <input type="hidden" name="card_application_number" value="<?php echo $card_app_num;?>">
                                    <div class="form-group">
                                        <label for="account_number">Account Number</label>
                                         <select name="account_number" class="form-control" id="account_number" onchange="loadcustomer(this.value)">
                                            <option value="Select" selected>Select</option>
                                        <?php
                                        global $con;
                                        $q = "SELECT * FROM accounts WHERE c_id='$get_id'";
                                        $stmt = $con->query($q);
                                        $row = $stmt->fetch();
                                        $account_no = $row['account_no'];
                                        ?>
                                                <option value="<?php echo $account_no;?>"><?php echo $account_no;?></option>
                                        </select>
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
        function loadcustomer(id) {
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
            xmlhttp.open("GET","ajaxcards.php?id="+id,true);
            xmlhttp.send();
        }
    </script>
<?php
require_once 'include/footer.php';
?>