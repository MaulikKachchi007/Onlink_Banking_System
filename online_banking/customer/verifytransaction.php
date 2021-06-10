<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$c_id = $_SESSION['c_id'];
if (isset($_GET['trpass'])) {
    $transaction_password = $_GET['trpass'];
    $otp = $_GET['otp'];
//    $tr_pss=$_POST['transaction_password'];
    $sql = "SELECT * FROM customers_master WHERE c_id='$c_id' AND pin='$transaction_password'";
    $stmt = $con->query($sql);
    $countrow = $stmt->rowCount();
    if (($countrow==1) && ($_SESSION['otp']==$otp)) {
        ?>
        <button type="button" class="btn btn-primary" onclick="otpverification();">Verify</button>
            <?php
    }else{
        ?>
        <div id="divvalidate">Invalid Otp and password</div>
<?php
    }
}else{
    $sql = "SELECT * FROM customers_master WHERE c_id='$c_id'";
    $stmt = $con->query($sql);
    while ($row = $stmt->fetch()) {
        $email = $row['email'];
        $f_name = $row['f_name'];
    }
    require_once 'include/sendmail.php';
    $_SESSION['otp'] = rand(100000,999999);
    $msg = "<strong>Dear $f_name,</strong><br><br>
	Thank you for banking with OctoPrime E-Banking.<br>
	You have requested for Internet Banking and and your OTP number is <b>$_SESSION[otp]</b>";
    sendmail($email,"OTP for Transaction from eBanking..",$msg,"OctoPrime E-Banking");
}