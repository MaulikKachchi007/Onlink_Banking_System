<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
    $get_id = $_GET['customeracid'];
    $tr_type = $_GET['fund_transfer_type'];
    $sql = "SELECT * FROM accounts INNER JOIN customers_master ON customers_master.c_id = accounts.c_id WHERE accounts.c_id='$get_id' AND accounts.account_type != '' AND accounts.account_status='Active'";
    $stmt = $con->query($sql);
    $rcount = $stmt->rowCount();
    if($stmt->rowCount() != 0){
        ?>
        <img src='image/LoadingSmall.gif' width='172' height='172' /></div>
    <?php
    }else{
    ?>
        <?php
        if($tr_type == "OctoPrime E-Banking") {
    ?>
            <div class="form-group">
            <label for="bank_account_number">Bank Account Number</label>
            <input class="form-control" type="text" name="bank_account_number" id="bank_account_number"  placeholder="Account Number" onkeyup="loadbankaccount(this.value)" />
            </div>
            <div id="bankaccount">
            </div>
            <div class="form-group">
            <input class="btn btn-primary" type="submit" name="add_registred"  value="Add Account To Registered Payee" />
            </div>
    <?php
        }
        if($_GET['fund_transfer_type']== "Other"){
            ?>
            <div class="form-group">
                <label for="acc_holder_name">Account Holder Name</label>
                <input class="form-control" type="text" name="payeename" placeholder="Account Holder Name"  />
            </div>
            <div class="form-group">
                <label for="acc_bank_no">Bank Account Number</label>
                <input class="form-control" type="text" name="bank_account_number" placeholder="Bank Account Number" />
            </div>
            <div class="form-group">
                <label for="bank_name">Bank Name</label>
                <input class="form-control" type="text" name="bankname" placeholder="Bank Name" />
            </div>
            <div class="form-group">
                <label for="account_type">Account Type</label>
                <select class="form-control" name="accounttype">
                    <option value="Select">Select</option>
                    <?php
                        $sql = "SELECT * FROM account_master";
                        $stmt = $con->query($sql);
                        while ($row = $stmt->fetch()) {
                            $account_type = $row['account_type'];
                        ?>
                            <option value="<?php echo $account_type;?>"><?php echo $account_type;?></option>
                        <?php
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ifsccode">IFSC Code</label>
                <input class="form-control" type="text" name="ifsccode" placeholder="IFSC Code" />
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="add_registred"  value="Add Account To Registered Payee" />
            </div>
<?php
        }
    }
    ?>