<?php
require_once "DB.php";
require_once "session.php";
#redirect
function redirect($new_location){
    header('Location:'. $new_location);
    exit();
}
# Check User Exits or not
function checkUserExists($email){
    global $con;
    $sql = "SELECT * FROM customers_master WHERE email =:eMail";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':eMail',$email);
    $stmt->execute();
    $row_count = $stmt->rowcount();
    if ($row_count == 1){
        return true;
    }else{
        return false;
    }
}
#login attempt
function login_attempt($email,$password){
    global $con;
    $get_Password = base64_encode($password);
    $sql = "SELECT * from customers_master WHERE email=:eMail AND password=:passWord LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':eMail',$email);
    $stmt->bindValue(':passWord',$get_Password);
    $stmt->execute();
    $result = $stmt->rowcount();
    if ($result==1){
        return $found_account=$stmt->fetch();
    }else{
        return null;
    }   
}
#confirm Login
function confirm_login() {
    if (isset($_SESSION['c_id'])) {
        return true;
    }
    else {
        $_SESSION['error_message'] = "Login Required!";
        redirect('login.php');
    }
}
# Credit Transaction 
function CreditTransaction()
{
    global $con;
    $g_id = $_SESSION['c_id'];
    $sql = "SELECT SUM(amount) FROM transaction INNER JOIN accounts ON  accounts.account_no = transaction.to_account_no
                WHERE accounts.c_id = '$g_id'   and transaction.transaction_type = 'Credit' and (transaction.payment_status='Approved' or transaction.payment_status='Active')";
    $stmt = $con->query($sql);
    $totalRows = $stmt->fetch();
    $total = array_shift($totalRows);
    echo $total;
}
# Credit Transaction 
function DebitTransaction()
{
    global $con;
    $g_id = $_SESSION['c_id'];
    $sql = "SELECT SUM(amount) FROM transaction INNER JOIN accounts ON  accounts.account_no = transaction.to_account_no
                WHERE accounts.c_id = '$g_id'   and transaction.transaction_type = 'Debit' and (transaction.payment_status='Approved' or transaction.payment_status='Active')";
    $stmt = $con->query($sql);
    $totalRows = $stmt->fetch();
    $total = array_shift($totalRows);
    echo $total;
}
# Fixed Deposite

function total_fixed_deposits()
{
    global $con;
    $g_id = $_SESSION['c_id'];
    $sql = "SELECT SUM(account_balance) FROM accounts WHERE c_id='$g_id' AND account_type='Fixed Deposite Account'";
    $stmt = $con->query($sql);
    $totalRows = $stmt->fetch();
    $total = array_shift($totalRows);
    echo $total;
}

function total_loan_account()
{
    global $con;
    $g_id = $_SESSION['c_id'];
    $sql = "SELECT SUM(loan_amount) FROM loan WHERE c_id ='$g_id'";
    $stmt = $con->query($sql);
    $totalRows = $stmt->fetch();
    $total = array_shift($totalRows);
    echo $total;
}
# Load
function IncomebarChart(){
    global $con;
    // Jan
    $jsy=date('Y');$jsm=date('01');$jsd=date('01');
    $jan_start_date = $jsy.'-'.$jsm.'-'.$jsd;
    $jey=date('Y');$jem=date('01');$jed=date('31');
    $jan_end_date = $jey.'-'.$jem.'-'.$jed;
    $sql = "SELECT sum(amount) FROM transaction 
            INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
            WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$jan_start_date'  AND '$jan_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $janamount = array_shift($row);
    // Feb
    $fsy=date('Y');$fsm=date('02');$fsd=date('01');
    $feb_start_date = $fsy.'-'.$fsm.'-'.$fsd;
    $fey=date('Y');$fem=date('02');$fed=date('28');
    $feb_end_date = $fey.'-'.$fem.'-'.$fed;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')    
    and  transaction.trans_date_time BETWEEN '$feb_start_date'  AND '$feb_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $febamount = array_shift($row);
    // march
    $marchsy=date('Y');$marchsm=date('03');$marchsd=date('01');
    $march_start_date = $marchsy.'-'.$marchsm.'-'.$marchsd;
    $marchey=date('Y');$marchem=date('03');$marched=date('31');
    $march_end_date = $marchey.'-'.$marchem.'-'.$marched;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')   
    and  transaction.trans_date_time BETWEEN '$march_start_date'  AND '$march_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $marchamount = array_shift($row);
    #april
    $apsy=date('Y');$apsm=date('04');$apsd=date('01');
    $april_start_date = $apsy.'-'.$apsm.'-'.$apsd;
    $apey=date('Y');$apem=date('04');$aped=date('30');
    $april_end_date = $apey.'-'.$apem.'-'.$aped;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')    
    and  transaction.trans_date_time BETWEEN '$april_start_date'  AND '$april_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $apramount = array_shift($row);
    #may
    $maysy=date('Y');$maysm=date('05');$maysd=date('01');
    $may_start_date = $maysy.'-'.$maysm.'-'.$maysd;
    $mayey=date('Y');$mayem=date('05');$mayed=date('31');
    $may_end_date = $mayey.'-'.$mayem.'-'.$mayed;
    $sql = "SELECT sum(transaction.amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' and transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$may_start_date'  AND '$may_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $mayamount = array_shift($row);
//    June
    $junesy=date('Y');$junesm=date('06');$junesd=date('01');
    $june_start_date = $junesy.'-'.$junesm.'-'.$junesd;
    $juneey=date('Y');$juneem=date('06');$juneed=date('30');
    $june_end_date = $juneey.'-'.$juneem.'-'.$juneed;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' or transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' and transaction .payment_status='Active')   
    and  transaction.trans_date_time BETWEEN '$june_start_date'  AND '$june_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $juneamount = array_shift($row);
//    July
    $julysy=date('Y');$julysm=date('07');$julysd=date('01');
    $july_start_date = $julysy.'-'.$julysm.'-'.$julysd;
    $julyey=date('Y');$julyem=date('07');$julyed=date('31');
    $july_end_date = $julyey.'-'.$julyem.'-'.$julyed;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$july_start_date'  AND '$july_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $julyamount = array_shift($row);
//    aug
    $augsy=date('Y');$augsm=date('08');$augsd=date('01');
    $aug_start_date = $augsy.'-'.$augsm.'-'.$augsd;
    $augey=date('Y');$augem=date('08');$auged=date('31');
    $aug_end_date = $augey.'-'.$augem.'-'.$auged;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')   
    and  transaction.trans_date_time BETWEEN '$aug_start_date'  AND '$aug_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $augamount = array_shift($row);
    //    septamber
    $sepsy=date('Y');$sepsm=date('09');$sepsd=date('01');
    $sep_start_date = $sepsy.'-'.$sepsm.'-'.$sepsd;
    $sepey=date('Y');$sepem=date('09');$seped=date('30');
    $sep_end_date = $sepey.'-'.$sepem.'-'.$seped;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$sep_start_date'  AND '$sep_end_date'";
    $stmt = $con->query($sql);
     $row = $stmt->fetch();
     $sepamount = array_shift($row);
    //    october
    $octsy=date('Y');$octsm=date('10');$octsd=date('01');
    $oct_start_date = $octsy.'-'.$octsm.'-'.$octsd;
    $octey=date('Y');$octem=date('10');$octed=date('31');
    $oct_end_date = $octey.'-'.$octem.'-'.$octed;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$oct_start_date'  AND '$oct_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $octamount = array_shift($row);
//    november
    $novsy=date('Y');$novsm=date('11');$novsd=date('01');
    $nov_start_date = $novsy.'-'.$novsm.'-'.$novsd;
    $novey=date('Y');$novem=date('11');$noved=date('30');
    $nov_end_date = $novey.'-'.$novem.'-'.$noved;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$nov_start_date'  AND '$nov_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $novamount = array_shift($row);
//    dec
    $dsy=date('Y');$dsm=date('12');$dsd=date('01');
    $dec_start_date = $dsy.'-'.$dsm.'-'.$dsd;
    $dey=date('Y');$dem=date('12');$ded=date('31');
    $dec_end_date = $dey.'-'.$dem.'-'.$ded;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Credit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$dec_start_date'  AND '$dec_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $decamount = array_shift($row);
    $datapoints = array(
        array('y'=>floatval($janamount),"label"=>"January"),
        array('y'=>floatval($febamount),"label"=>"February"),
        array('y'=>floatval($marchamount),"label"=>"March"),
        array('y'=>floatval($apramount),"label"=>"April"),
        array('y'=>floatval($mayamount),"label"=>"May"),
        array('y'=>floatval($juneamount),"label"=>"June"),
        array('y'=>floatval($julyamount),"label"=>"July"),
        array('y'=>floatval($augamount),"label"=>"August"),
        array('y'=>floatval($sepamount),"label"=>"September"),
        array('y'=>floatval($octamount),"label"=>"October"),
        array('y'=>floatval($novamount),"label"=>"November"),
        array('y'=>floatval($decamount),"label"=>"December")
    );
    return $datapoints;
}
function ExpensebarChart(){
    global $con;
    // Jan
    $jsy=date('Y');$jsm=date('01');$jsd=date('01');
    $jan_start_date = $jsd.'-'.$jsm.'-'.$jsy;
    $jey=date('Y');$jem=date('01');$jed=date('31');
    $jan_end_date = $jed.'-'.$jem.'-'.$jey;
    $sql = "SELECT sum(amount) FROM transaction 
            INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
            WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$jan_start_date'  AND '$jan_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $janamount = array_shift($row);
    // Feb
    $fsy=date('Y');$fsm=date('02');$fsd=date('01');
    $feb_start_date = $fsd.'-'.$fsm.'-'.$fsy;
    $fey=date('Y');$fem=date('02');$fed=date('28');
    $feb_end_date = $fed.'-'.$fem.'-'.$fey;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
    and (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$feb_start_date'  AND '$feb_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $febamount = array_shift($row);
    // march
    $marchsy=date('Y');$marchsm=date('03');$marchsd=date('01');
    $march_start_date = $marchsd.'-'.$marchsm.'-'.$marchsy;
    $marchey=date('Y');$marchem=date('03');$marched=date('31');
    $march_end_date = $marched.'-'.$marchem.'-'.$marchey;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$march_start_date'  AND '$march_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $marchamount = array_shift($row);
    #april
    $apsy=date('Y');$apsm=date('04');$apsd=date('01');
    $april_start_date = $apsy.'-'.$apsm.'-'.$apsd;
    $apey=date('Y');$apem=date('04');$aped=date('30');
    $april_end_date = $apey.'-'.$apem.'-'.$aped;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$april_start_date'  AND '$april_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $apramount = array_shift($row);
    #may
    $maysy=date('Y');$maysm=date('05');$maysd=date('01');
    $may_start_date = $maysy.'-'.$maysm.'-'.$maysd;
    $mayey=date('Y');$mayem=date('05');$mayed=date('31');
    $may_end_date = $mayey.'-'.$mayem.'-'.$mayed;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$may_start_date'  AND '$may_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $mayamount = array_shift($row);
//    June
    $junesy=date('Y');$junesm=date('06');$junesd=date('01');
    $june_start_date = $junesy.'-'.$junesm.'-'.$junesd;
    $juneey=date('Y');$juneem=date('06');$juneed=date('30');
    $june_end_date = $juneey.'-'.$juneem.'-'.$juneed;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
    and  transaction .payment_status='Approved' or transaction .payment_status='Active'  
    and  transaction.trans_date_time BETWEEN '$june_start_date'  AND '$june_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $juneamount = array_shift($row);
//    July
    $julysy=date('Y');$julysm=date('07');$julysd=date('01');
    $july_start_date = $julysy.'-'.$julysm.'-'.$julysd;
    $julyey=date('Y');$julyem=date('07');$julyed=date('31');
    $july_end_date = $julyey.'-'.$julyem.'-'.$julyed;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')   
    and  transaction.trans_date_time BETWEEN '$july_start_date'  AND '$july_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $julyamount = array_shift($row);
//    aug
    $augsy=date('Y');$augsm=date('08');$augsd=date('01');
    $aug_start_date = $augsy.'-'.$augsm.'-'.$augsd;
    $augey=date('Y');$augem=date('08');$auged=date('31');
    $aug_end_date = $augey.'-'.$augem.'-'.$auged;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$aug_start_date'  AND '$aug_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $augamount = array_shift($row);
    //    septamber
    $sepsy=date('Y');$sepsm=date('09');$sepsd=date('01');
    $sep_start_date = $sepsy.'-'.$sepsm.'-'.$sepsd;
    $sepey=date('Y');$sepem=date('09');$seped=date('30');
    $sep_end_date = $sepey.'-'.$sepem.'-'.$seped;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
    and (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$sep_start_date'  AND '$sep_end_date'";
    $stmt = $con->query($sql);
     $row = $stmt->fetch();
     $sepamount = array_shift($row);
    //    october
    $octsy=date('Y');$octsm=date('10');$octsd=date('01');
    $oct_start_date = $octsy.'-'.$octsm.'-'.$octsd;
    $octey=date('Y');$octem=date('10');$octed=date('31');
    $oct_end_date = $octey.'-'.$octem.'-'.$octed;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$oct_start_date'  AND '$oct_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $octamount = array_shift($row);
//    november
    $novsy=date('Y');$novsm=date('11');$novsd=date('01');
    $nov_start_date = $novsy.'-'.$novsm.'-'.$novsd;
    $novey=date('Y');$novem=date('11');$noved=date('30');
    $nov_end_date = $novey.'-'.$novem.'-'.$noved;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$nov_start_date'  AND '$nov_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $novamount = array_shift($row);
//    dec
    $dsy=date('Y');$dsm=date('12');$dsd=date('01');
    $dec_start_date = $dsy.'-'.$dsm.'-'.$dsd;
    $dey=date('Y');$dem=date('12');$ded=date('31');
    $dec_end_date = $dey.'-'.$dem.'-'.$ded;
    $sql = "SELECT sum(amount)  FROM transaction 
    INNER JOIN accounts ON accounts.account_no=transaction.to_account_no 
    WHERE transaction.transaction_type='Debit' and transaction.transaction_type='Cash'  
    and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
    and  transaction.trans_date_time BETWEEN '$dec_start_date'  AND '$dec_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $decamount = array_shift($row);
    $datapoints = array(
        array('y'=>floatval($janamount),"label"=>"January"),
        array('y'=>floatval($febamount),"label"=>"February"),
        array('y'=>floatval($marchamount),"label"=>"March"),
        array('y'=>floatval($apramount),"label"=>"April"),
        array('y'=>floatval($mayamount),"label"=>"May"),
        array('y'=>floatval($juneamount),"label"=>"June"),
        array('y'=>floatval($julyamount),"label"=>"July"),
        array('y'=>floatval($augamount),"label"=>"August"),
        array('y'=>floatval($sepamount),"label"=>"September"),
        array('y'=>floatval($octamount),"label"=>"October"),
        array('y'=>floatval($novamount),"label"=>"November"),
        array('y'=>floatval($decamount),"label"=>"December")
    );
    return $datapoints;
}