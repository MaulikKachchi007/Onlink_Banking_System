<?php
include 'include/DB.php';
include 'include/function.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_GET['id'];
$sql = "SELECT * FROM fixed_deposite WHERE f_id='$get_id'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()){
    $min_amt = $row['min_amt'];
    $max_amt = $row['max_amt'];
    $interest = $row['interest'];
    $term = $row['terms'];
}
?>
<div class="form-group">
    <label for="min_amt">Minimum Amount</label>
    <input class="form-control" style="color: red;" value="<?php echo $min_amt;?>" name="min_amt" readonly>
</div>
<div class="form-group">
    <label for="max_amt">Maximum Amount</label>
    <input class="form-control" style="color: red;" value="<?php echo $max_amt;?>" name="max_amt" readonly>
</div>
<div class="form-group">
    <label for="interest">Interest (In Percentage %)</label>
    <input class="form-control" style="color: red;" id="interest" value="<?php echo $interest;?>" name="interest" readonly>
</div>
<div class="form-group">
    <label for="term">Terms (in year)</label>
    <input class="form-control" style="color: red;" id="terms" value="<?php echo $term;?>" name="term" readonly>
</div>
<div class="form-group">
    <label for="inv_amt">Invesment Amount</label>
    <input class="form-control"  name="inv_amt" id="inv_amt" onkeyup="calculategrandtotal()" placeholder="Enter Invesment amount">
</div>
<div class="form-group">
    <label for="total_profit">Total Profit</label>
    <input class="form-control" id="total_profit" readonly  name="total_profit" placeholder="Total Profit Calculates automatically">
</div>
<div class="form-group">
    <label for="total_amt_rec">Amount Receivable</label>
    <input class="form-control" id="grandtotal" readonly  name="total_amt_rec" placeholder="Total Receivable Calculates automatically">
</div>
<div class="form-group">
    <label for="maturity_date">Maturity date</label>
    <input class="form-control" placeholder="Maturity date" value="<?php $year=$term."years"; echo $futuredate=date("Y-m-d",strtotime($year)); ?>" readonly  name="maturity_date">
</div>
<div class="form-group">
    <button type="submit" name="add_fd_account" class="btn btn-primary">Apply Fixed Deposite</button>
    <button type="reset" name="reset" class="btn btn-danger">Reset</button>
</div>