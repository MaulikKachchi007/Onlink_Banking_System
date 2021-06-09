
<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST["update_card"])) {
    $card_type = $_POST["card_type"];
    $cardprefix = $_POST["card_prefix"];
    $max_amt = $_POST["max_amt"];
    $min_amt = $_POST["min_amt"];
    $terms = $_POST["terms"];
    if (empty($card_type) || empty($cardprefix) || empty($min_amt) ||empty($max_amt) || empty($terms)) {
        $_SESSION["error_message"] = "All must fill required.";
    }else {
        global $con;
        $q = "Update card_type_master SET card_type='$card_type',min_amt='$min_amt',max_amt='$min_amt',terms='$terms',prefix='$cardprefix' WHERE id='$get_id'";
        $stmt = $con->prepare($q);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Card Update Successfully";
            redirect('view_cards_type.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
        }
    }
}
global $con;
$sql = "SELECT * from card_type_master WHERE id ='$get_id'";
$stmt = $con->query($sql);
$result = $stmt->execute();
while ($row = $stmt->fetch()) {
    $card_type = $row['card_type'];
    $prefix = $row['prefix'];
    $min_amount = $row['min_amt'];
    $max_amount = $row['max_amt'];
    $terms = $row['terms'];

}
?>
<?php
include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';
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
                                        <h1 class="text-dark">Update Card</h1>
                                    </div><!-- /.col -->
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                            <li class="breadcrumb-item active">Update Card</li>
                                        </ol>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div>
                            <a href="view_cards_type.php" class="btn btn-info float-right text-white">View Record</a>
                        </div>
                        <div class="container p-1">
                            <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            ?>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="update_card.php?id=<?php echo $get_id; ?>" method="post"

                        <div class="card-body">
                            <div class="form-group">
                            <label for="card_type">Card Type</label>
                            <select class="form-control" name="card_type">
                                <option value="<?php echo $card_type; ?>"><?php echo $card_type; ?></option>
                                <option value="Credit Master Card">Credit Master Card</option>
                                <option value="Debit Master Card">Debit Master Card</option>
                                <option value="Credit RuPay Card">Credit RuPay Card</option>
                                <option value="Debit RuPay Card">Debit RuPay Card</option>
                                <option value="Credit Visa Card">Credit Visa Card</option>
                                <option value="Debit Visa Card">Debit RuPay Card</option>
                            </select>
                        </div>
                            <div class="form-group">
                                <label for="card_prefix">Card Prefix</label>
                                <input class="form-control" name="card_prefix" value="<?php echo $prefix;?>" placeholder="Account Prefix">
                            </div>
                            <div class="form-group">
                                <label for="min_amt">Minimum Amount</label>
                                <input class="form-control" name="min_amt" value="<?php echo $min_amount;?>" placeholder="Minimum Amount">
                            </div>
                            <div class="form-group">
                                <label for="max_amt">Maximum Amount</label>
                                <input class="form-control" name="max_amt" value="<?php echo $max_amount;?>" placeholder="Maximum Amount">
                            </div>
                            <div class="form-group">
                                <label for="terms">Terms</label>
                                <input class="form-control" name="terms" value="<?php echo $terms;?>" placeholder="Terms">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="update_card" class="btn btn-primary">Update Record</button>
                            </div>
                        </div>
                        <!-- /.card-body -->


                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
<?php
include 'include/footer.php';
?>