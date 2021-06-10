    <?php
include 'include/DB.php';
include 'include/function.php';
//include 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
    $get_id = $_GET['id'];
    global $con;
    $sql = "SELECT * from accounts INNER JOIN customers_master ON accounts.c_id=customers_master.c_id WHERE accounts.account_no='$get_id'";
    $stmt = $con->query($sql);
    while ($row = $stmt->fetch()){
        $f_name = $row['f_name'];
        $account_no = $row['account_no'];
        $ifsccode = $row['ifsccode'];
        $balance = $row['account_balance'];
        $account_type = $row['account_type'];
    }
    $rowcount = $stmt->rowCount();
    if ($rowcount==0) {
        ?>
        <img src='image/LoadingSmall.gif' width='172' height='172'/>
        <?php
    } else{
?>
<table class="table table-striped table-bordered">
    <tr>
        <th>IFSC code</th>
        <td><?php echo $ifsccode;?></td>
    </tr>
    <tr>
        <th>Name</th>
        <td><?php echo $f_name;?></td>
    </tr>
    <tr>
        <th>Account Number</th>
        <td><?php echo $account_no;?></td>
    </tr>
    <tr>
        <th>Account Type</th>
        <td><?php echo $account_type;?></td>
    </tr>
    <tr>
        <th>Account Balance</th>
        <td><?php echo $balance;?></td>
        <input type="hidden" name="balance" value="<?php echo $balance;?>">
    </tr>
</table>
<div class="form-group">
    <label for="Cards Type">Cards Type</label>
    <select name="card_type" class="form-control">
        <option value="Select" selected>Select</option>
        <?php
        global $con;
        $q = "SELECT * FROM card_type_master";
        $stmt = $con->query($q);
        while ($row = $stmt->fetch()) {
            $card_type = $row['card_type'];
            $id = $row['id'];
            ?>
            <option value="<?php echo $id;?>"><?php echo $card_type;?></option>
            <?php
        }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="Reason">Reason</label>
    <textarea class="form-control" name="reason" placeholder="Reason" rows="5" cols="25"></textarea>
</div>
<div class="form-group">
    <input type="submit" class="btn btn-primary"name='apply_card' value="Apply Card">
</div>
 <?php
    }
    ?>