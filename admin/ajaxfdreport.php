<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['id'];
//$g_id = $_GET['id'];
$statement = $_GET['statement'];
?>
<?php
if($statement == "Select"){
    echo '<div id="customer_loading"><img src="image/LoadingSmall.gif" width="172" height="172" /></div>';
} else if($statement == "week"){
    ?>
    <div class="form-group">
        <?php
        $todate = date("Y-m-d");
        $d=strtotime("-1 week");
        $fromDate = date("Y-m-d",$d);
        ?>
        <input type="hidden" name="weekfrom" id="fromDate" value="<?php echo $fromDate;?>"></div>
    <input type="hidden" name="weekto" id="toDate" value="<?php echo $todate;?>"></div>
    <input type="button" class="btn btn-primary" name="submit" onclick="load_report(fromDate.value,toDate.value)" value="Download Statement">
    <br><br>
    </div>

    <?php
} else if($statement == "month"){
    ?>
    <div class="form-group">
        <?php
        $toDate = date("Y-m-d");
        $d=strtotime("-1 month");
        $fromDate = date("Y-m-d",$d);
        ?>
        <input type="hidden" name="monthfrom" id="fromDate" value="<?php echo $fromDate;?>"></div>
    <input type="hidden" name="monthto" id="toDate" value="<?php echo $toDate;?>"></div>
    <input type="button" class="btn btn-primary" name="submit" onclick="load_report(fromDate.value,toDate.value)" value="Download Statement">
    <br><br>
    </div>

    <?php
} else if($statement == "year"){
    ?>
    <div class="form-group">
        <?php
        $toDate = date("Y-m-d");
        $d=strtotime("-1 year");
        $fromDate = date("Y-m-d",$d);
        ?>
        <input type="hidden" name="yearFrom" id="fromDate" value="<?php echo $fromDate;?>"></div>
    <input type="hidden" name="yearTo" id="toDate" value="<?php echo $toDate;?>"></div>
    <input type="button" class="btn btn-primary" name="submit" onclick="load_report(fromDate.value,toDate.value)" value="Download Statement">
    <br><br>
    </div>

    <?php
}elseif($statement=="custom") {
    ?>
    <div class="form-group">
        <label for="fromDate">From</label>
        <input class="form-control" type="date" id="fromDate" name="fromDate">
    </div>
    <div class="form-group">
        <label for="toDate">To</label>
        <input class="form-control" type="date" id="toDate" name="toDate">
    </div>
    <div class="form-group">
        <input type="button" class="btn btn-primary" name="submit" onclick="load_report(fromDate.value,toDate.value)" value="Search">
    </div>
    </div>
    <?php
}
?>
<!-- Display Table -->
<div id="report_load">
</div>