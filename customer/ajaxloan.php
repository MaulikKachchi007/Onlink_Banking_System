<?php
include 'include/DB.php';
include 'include/function.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_GET['id'];
$sql = "SELECT * FROM loan_type_master WHERE id='$get_id'";
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
    <input class="form-control" style="color: red;" id="interest" value="<?php echo $interest;?>" name="Interest" readonly>
</div>
<div class="form-group">
    <label for="term">Terms (in year)</label>
    <input class="form-control" style="color: red;" id="terms" value="<?php echo $term;?>" name="term" readonly>
</div>
<div class="form-group">
    <label for="loan_amt">Loan Amount</label>
    <input class="form-control"  name="loan_amt" id="loan_amt" onkeyup="calculategrandtotal()" placeholder="Enter Loan amount">
    <div class="col-md-6 margin-bottom-15"><br /><br />
        <span id="jsloanamount" ></span>
</div>
<div class="form-group">
    <label for="int_amt">Interest amount</label>
    <input class="form-control" id="totalintrest" readonly  name="int_amt" placeholder="Interest amount Calculates automatically">
    <div class="col-md-6 margin-bottom-15"><br /><br />
        <span id="jsloanamount" ></span>
</div>
<div class="form-group">
    <label for="total_payable">Total Payable</label>
    <input class="form-control" id="grandtotal" readonly  name="total_payable" placeholder="Total Payable Calculates automatically">
    <div class="col-md-6 margin-bottom-15"><br /><br />
        <span id="jsloanamount" ></span>
</div>
<div class="form-group">
    <button type="submit" name="apply_loan" class="btn btn-primary">Apply Loan</button>
    <button type="reset" name="reset" class="btn btn-danger">Reset</button>
</div>
</div>