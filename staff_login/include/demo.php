<?php
require_once "DB.php";
require_once "session.php";
#redirect
function IncomebarChart(){
    global $con;
    $id = $_SESSION['id'];
    $q = "SELECT * FROM employees_master WHERE id='$id'";
    $stmt = $con->query($q);
    while ($row = $stmt->fetch()) {
        $ifsccode = $row['ifsccode'];
    }
    // Jan
    $jsy=date('Y');$jsm=date('01');$jsd=date('01');
    $jan_start_date = $jsy.'-'.$jsm.'-'.$jsd;
    $jey=date('Y');$jem=date('01');$jed=date('31');
    $jan_end_date = $jey.'-'.$jem.'-'.$jed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$jan_start_date' AND '$jan_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $janamount = array_shift($row);
    // Feb
    $fsy=date('Y');$fsm=date('02');$fsd=date('01');
    $feb_start_date = $fsy.'-'.$fsm.'-'.$fsd;
    $fey=date('Y');$fem=date('02');$fed=date('28');
    $feb_end_date = $fey.'-'.$fem.'-'.$fed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$feb_start_date' AND '$feb_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $febamount = array_shift($row);
    // march
    $marchsy=date('Y');$marchsm=date('03');$marchsd=date('01');
    $march_start_date = $marchsy.'-'.$marchsm.'-'.$marchsd;
    $marchey=date('Y');$marchem=date('03');$marched=date('31');
    $march_end_date = $marchey.'-'.$marchem.'-'.$marched;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$march_start_date' AND '$march_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $marchamount = array_shift($row);
    #april
    $apsy=date('Y');$apsm=date('04');$apsd=date('01');
    $april_start_date = $apsy.'-'.$apsm.'-'.$apsd;
    $apey=date('Y');$apem=date('04');$aped=date('30');
    $april_end_date = $apey.'-'.$apem.'-'.$aped;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$april_start_date' AND '$april_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $apramount = array_shift($row);
    #may
    $maysy=date('Y');$maysm=date('05');$maysd=date('01');
    $may_start_date = $maysy.'-'.$maysm.'-'.$maysd;
    $mayey=date('Y');$mayem=date('05');$mayed=date('31');
    $may_end_date = $mayey.'-'.$mayem.'-'.$mayed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$may_start_date' AND '$may_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $mayamount = array_shift($row);
//    June
    $junesy=date('Y');$junesm=date('06');$junesd=date('01');
    $june_start_date = $junesy.'-'.$junesm.'-'.$junesd;
    $juneey=date('Y');$juneem=date('06');$juneed=date('30');
    $june_end_date = $juneey.'-'.$juneem.'-'.$juneed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$june_start_date' AND '$june_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $juneamount = array_shift($row);
//    July
    $julysy=date('Y');$julysm=date('07');$julysd=date('01');
    $july_start_date = $julysy.'-'.$julysm.'-'.$julysd;
    $julyey=date('Y');$julyem=date('07');$julyed=date('31');
    $july_end_date = $julyey.'-'.$julyem.'-'.$julyed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$july_start_date' AND '$july_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $julyamount = array_shift($row);
//    aug
    $augsy=date('Y');$augsm=date('08');$augsd=date('01');
    $aug_start_date = $augsy.'-'.$augsm.'-'.$augsd;
    $augey=date('Y');$augem=date('08');$auged=date('31');
    $aug_end_date = $augey.'-'.$augem.'-'.$auged;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$aug_start_date' AND '$aug_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $augamount = array_shift($row);
    //    septamber
    $sepsy=date('Y');$sepsm=date('09');$sepsd=date('01');
    $sep_start_date = $sepsy.'-'.$sepsm.'-'.$sepsd;
    $sepey=date('Y');$sepem=date('09');$seped=date('30');
    $sep_end_date = $sepey.'-'.$sepem.'-'.$seped;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$sep_start_date' AND '$sep_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $sepamount = array_shift($row);
    //    october
    $octsy=date('Y');$octsm=date('10');$octsd=date('01');
    $oct_start_date = $octsy.'-'.$octsm.'-'.$octsd;
    $octey=date('Y');$octem=date('10');$octed=date('31');
    $oct_end_date = $octey.'-'.$octem.'-'.$octed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$oct_start_date' AND '$oct_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $octamount = array_shift($row);
//    november
    $novsy=date('Y');$novsm=date('11');$novsd=date('01');
    $nov_start_date = $novsy.'-'.$novsm.'-'.$novsd;
    $novey=date('Y');$novem=date('11');$noved=date('30');
    $nov_end_date = $novey.'-'.$novem.'-'.$noved;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$nov_start_date' AND '$nov_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $novamount = array_shift($row);
//    dec
    $dsy=date('Y');$dsm=date('12');$dsd=date('01');
    $dec_start_date = $dsy.'-'.$dsm.'-'.$dsd;
    $dey=date('Y');$dem=date('12');$ded=date('31');
    $dec_end_date = $dey.'-'.$dem.'-'.$ded;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Credit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$dec_start_date' AND '$dec_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $decamount = array_shift($row);
    $datapoints = array(
        array('y'=>floatval($janamount)),
        array('y'=>floatval($febamount)),
        array('y'=>floatval($marchamount)),
        array('y'=>floatval($apramount)),
        array('y'=>floatval($mayamount)),
        array('y'=>floatval($juneamount)),
        array('y'=>floatval($julyamount)),
        array('y'=>floatval($augamount)),
        array('y'=>floatval($sepamount)),
        array('y'=>floatval($octamount)),
        array('y'=>floatval($novamount)),
        array('y'=>floatval($decamount))
    );
    return $datapoints;
}
function ExpensebarChart(){
    global $con;
    $id = $_SESSION['id'];
    $q = "SELECT * FROM employees_master WHERE id='$id'";
    $stmt = $con->query($q);
    while ($row = $stmt->fetch()) {
        $ifsccode = $row['ifsccode'];
    }
    // Jan
    $jsy=date('Y');$jsm=date('01');$jsd=date('01');
    $jan_start_date = $jsy.'-'.$jsm.'-'.$jsd;
    $jey=date('Y');$jem=date('01');$jed=date('31');
    $jan_end_date = $jey.'-'.$jem.'-'.$jed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$jan_start_date' AND '$jan_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $janamount = array_shift($row);
    // Feb
    $fsy=date('Y');$fsm=date('02');$fsd=date('01');
    $feb_start_date = $fsy.'-'.$fsm.'-'.$fsd;
    $fey=date('Y');$fem=date('02');$fed=date('28');
    $feb_end_date = $fey.'-'.$fem.'-'.$fed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$feb_start_date' AND '$feb_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $febamount = array_shift($row);
    // march
    $marchsy=date('Y');$marchsm=date('03');$marchsd=date('01');
    $march_start_date = $marchsy.'-'.$marchsm.'-'.$marchsd;
    $marchey=date('Y');$marchem=date('03');$marched=date('31');
    $march_end_date = $marchey.'-'.$marchem.'-'.$marched;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$march_start_date' AND '$march_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $marchamount = array_shift($row);
    #april
    $apsy=date('Y');$apsm=date('04');$apsd=date('01');
    $april_start_date = $apsy.'-'.$apsm.'-'.$apsd;
    $apey=date('Y');$apem=date('04');$aped=date('30');
    $april_end_date = $apey.'-'.$apem.'-'.$aped;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$april_start_date' AND '$april_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $apramount = array_shift($row);
    #may
    $maysy=date('Y');$maysm=date('05');$maysd=date('01');
    $may_start_date = $maysy.'-'.$maysm.'-'.$maysd;
    $mayey=date('Y');$mayem=date('05');$mayed=date('31');
    $may_end_date = $mayey.'-'.$mayem.'-'.$mayed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$may_start_date' AND '$may_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $mayamount = array_shift($row);
//    June
    $junesy=date('Y');$junesm=date('06');$junesd=date('01');
    $june_start_date = $junesy.'-'.$junesm.'-'.$junesd;
    $juneey=date('Y');$juneem=date('06');$juneed=date('30');
    $june_end_date = $juneey.'-'.$juneem.'-'.$juneed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$june_start_date' AND '$june_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $juneamount = array_shift($row);
//    July
    $julysy=date('Y');$julysm=date('07');$julysd=date('01');
    $july_start_date = $julysy.'-'.$julysm.'-'.$julysd;
    $julyey=date('Y');$julyem=date('07');$julyed=date('31');
    $july_end_date = $julyey.'-'.$julyem.'-'.$julyed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$july_start_date' AND '$july_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $julyamount = array_shift($row);
//    aug
    $augsy=date('Y');$augsm=date('08');$augsd=date('01');
    $aug_start_date = $augsy.'-'.$augsm.'-'.$augsd;
    $augey=date('Y');$augem=date('08');$auged=date('31');
    $aug_end_date = $augey.'-'.$augem.'-'.$auged;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$aug_start_date' AND '$aug_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $augamount = array_shift($row);
    //    septamber
    $sepsy=date('Y');$sepsm=date('09');$sepsd=date('01');
    $sep_start_date = $sepsy.'-'.$sepsm.'-'.$sepsd;
    $sepey=date('Y');$sepem=date('09');$seped=date('30');
    $sep_end_date = $sepey.'-'.$sepem.'-'.$seped;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$sep_start_date' AND '$sep_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $sepamount = array_shift($row);
    //    october
    $octsy=date('Y');$octsm=date('10');$octsd=date('01');
    $oct_start_date = $octsy.'-'.$octsm.'-'.$octsd;
    $octey=date('Y');$octem=date('10');$octed=date('31');
    $oct_end_date = $octey.'-'.$octem.'-'.$octed;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$oct_start_date' AND '$oct_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $octamount = array_shift($row);
//    november
    $novsy=date('Y');$novsm=date('11');$novsd=date('01');
    $nov_start_date = $novsy.'-'.$novsm.'-'.$novsd;
    $novey=date('Y');$novem=date('11');$noved=date('30');
    $nov_end_date = $novey.'-'.$novem.'-'.$noved;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$nov_start_date' AND '$nov_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $novamount = array_shift($row);
//    dec
    $dsy=date('Y');$dsm=date('12');$dsd=date('01');
    $dec_start_date = $dsy.'-'.$dsm.'-'.$dsd;
    $dey=date('Y');$dem=date('12');$ded=date('31');
    $dec_end_date = $dey.'-'.$dem.'-'.$ded;
    $sql = "SELECT SUM(amount) FROM transaction 
            INNER JOIN accounts ON transaction.to_account_no=accounts.account_no
            INNER JOIN customers_master ON  customers_master.c_id=accounts.c_id
            WHERE customers_master.ifsccode='$ifsccode' and transaction.transaction_type = 'Debit'
            and  (transaction .payment_status='Approved' or transaction .payment_status='Active')  
            and  transaction.trans_date_time BETWEEN '$dec_start_date' AND '$dec_end_date'";
    $stmt = $con->query($sql);
    $row = $stmt->fetch();
    $decamount = array_shift($row);
    $datapoints = array(
        array('y'=>floatval($janamount)),
        array('y'=>floatval($febamount)),
        array('y'=>floatval($marchamount)),
        array('y'=>floatval($apramount)),
        array('y'=>floatval($mayamount)),
        array('y'=>floatval($juneamount)),
        array('y'=>floatval($julyamount)),
        array('y'=>floatval($augamount)),
        array('y'=>floatval($sepamount)),
        array('y'=>floatval($octamount)),
        array('y'=>floatval($novamount)),
        array('y'=>floatval($decamount))
    );
    return $datapoints;
}
    $datas = IncomebarChart();
//    echo json_encode($data);
    foreach ($datas as $data) {
        echo json_encode($data).'<br>';
    }