<?php
include 'include/DB.php';
include 'include/function.php';
//include 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$g_id = $_SESSION['id'];
$sql = "SELECT * FROM employees_master WHERE id ='$g_id'";
$result = $con->query($sql);
$c_id= '';
while ($row = $result->fetch()) {
    $ifsccode = $row['ifsccode'];
}
$search_number = $_POST['search_number'];
$sql = "SELECT * FROM accounts 
        INNER JOIN customers_master ON customers_master.c_id=accounts.c_id  
        WHERE customers_master.ifsccode='$ifsccode' and accounts.account_no='$search_number' and accounts.account_status='Active' 
        and accounts.account_type='Saving Account' or accounts.account_type='Current Account'";
$stmt = $con->query($sql);
$rowcount = $stmt->rowCount();
?>
<br>
<table class="table table-striped table-bordered table-responsive">
    <tbody>
    <tr>
        <th>IFSC Code</th>
        <th>Name</th>
        <th>Birth Date</th>
        <th>Gender</th>
        <th>Account Type</th>
        <th>Account Number</th>
        <th>Account Open Date</th>
        <th>Account Balance</th>
        <th>Status</th>
    </tr>
    <?php
            if ($rowcount >     0 ) {
        while ($row = $stmt->fetch()) {
            $c_id = $row['c_id'];
            $ifsccode = $row['ifsccode'];
            $f_name = $row['f_name'];
            $l_name = $row['l_name'];
            $gender = $row['gender'];
            $birthdate = $row['birthdate'];
            $account_no = $row['account_no'];
            $account_type = $row['account_type'];
            $account_balance = $row['account_balance'];
            $account_open_date = $row['account_open_date'];
            $status = $row['account_status'];
    ?>
        <td><?php echo $ifsccode;?></td>
        <td><?php echo $f_name;?> <?php echo $l_name; ?></td>
        <td><?php echo $birthdate;?></td>
        <td><?php echo $gender;?></td>
        <td><?php echo $account_type;?></td>
        <td><?php echo $account_no;?></td>
        <td><?php echo $account_open_date;?></td>
        <td><?php echo $account_balance;?></td>
        <td>
            <?php
            if($status == "Active") {
                echo "<div class='badge badge-success'>".$status.'</div>';
            }
            else{
                echo "<div class='badge badge-danger'>".$status.'</div>';
            }?>
        </td>
    </tr>
    <tr>

            <?php
            }
            }else{
            ?>
                <td colspan="9" class="text-bold text-center text-danger"><?php echo "No Record Found";?></td>
            <?php
            }
            ?>
    </tr>
    </tbody>
</table>
<?php
$sql = "SELECT * from customers_master
INNER JOIN loan_payment ON customers_master.c_id=loan_payment.c_id WHERE customers_master.c_id='$c_id'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()){
$f_name = $row['f_name'];
$l_name = $row['l_name'];
$paid = $row['paid'];
$balance = $row['balance'];
$total_amt = $row['total_amt'];
$paid_date = $row['paid_date'];
}
?>
<br>
<h3>Loan Accounts Details</h3>
<table id="example1" class="table table-bordered table-striped table-sm">
    <thead>
    <tr>
        <th>Customer Name</th>
        <th>Loan Account Number</th>
        <th>Loan Type</th>
        <th>Created Date</th>
        <th>Last Date</th>
        <th>Loan Amount</th>
        <th>Interest Amount</th>
        <th>Total Payble</th>
        <th>Total Paid</th>
        <th>Balance</th>
    </tr>
    </thead>
    <tbody>
    <?php
    global $con;
    $sql = "SELECT * from loan_type_master 
            INNER JOIN loan ON loan_type_master.id=loan.id WHERE loan.c_id='$c_id' and loan.status='Approved'";
    $stmt = $con->query($sql);
    $result = $stmt->rowcount();
    if ($result > 0)
    {
    while ($row = $stmt->fetch()) {
    $loan_id = $row['loan_id'];
    $loan_account_number = $row['loan_account_number'];
    $l_type = $row['loan_type'];
    $loan_amount  = $row['loan_amount'];
    $interest = $row['intrest'];
    $loan_interest = $row['interest'];
    $term=  "$row[terms] years";
    $created_date = $row['created_date'];
    $total_payable = $loan_amount + $interest;
    $status = $row['status'];
    ?>
    <tr>
        <td><?php echo $f_name; ?></td>
        <td><?php echo $loan_account_number; ?></td>
        <td><?php echo $l_type; ?></td>
        <td><?php echo $created_date; ?></td>
        <td><?php echo date('d-M-Y', strtotime($term, strtotime($created_date))); ?></td>
        <td>&#8377; <?php echo $loan_amount;?></td>
        <td>&#8377; <?php echo $interest;?> (<?php echo $loan_interest; ?>)</td>
        <td>&#8377; <?php echo $total_payable;?></td>
        <td>&#8377; <?php echo $paid;?></td>
        <td>&#8377;<?php echo $balance;?></td>
    </tr>
    <tr>

        <?php
        }
        }else{
            ?>
            <td colspan="10" class="text-bold text-center text-danger"><?php echo "No Record Found";?></td>
            <?php
        }
        ?>
    </tr>
    </tbody>
</table>