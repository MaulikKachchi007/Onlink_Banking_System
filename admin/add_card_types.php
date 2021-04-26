<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
if (isset($_POST["add_card"])) {
    $card_type = $_POST["card_type"];
    $prefix = $_POST["card_prefix"];
    $status = $_POST["status"];
    if (empty($card_type) || empty($status) || empty($prefix)) {
        $_SESSION["error_message"] = "All must fill required.";
    }elseif ($card_type == "Select" || $status=="Select") {
        $_SESSION["error_message"] = "At least one input selected";
    }else {
        global $con;
        $sql = "INSERT INTO card_type_master (card_type,prefix,status) VALUES (:card_type,:prefix,:status)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':card_type',$card_type);
        $stmt->bindValue(':prefix',$prefix);
        $stmt->bindValue(':status',$status);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Cards Added Successfully";
            redirect('view_cards_type.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
            redirect('view_cards_type.php');
        }
    }
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
                                            <h1 class="text-dark">Add Card Type</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add Account</li>
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
                            <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="card_type">Card Type</label>
                                        <select class="form-control" name="card_type">
                                            <option value="Select" selected>Select</option>
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
                                        <input class="form-control" name="card_prefix" placeholder="Account Prefix">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Card Status</label>
                                        <select class="form-control" name="status">
                                            <option value="Select" selected>Select</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="add_card" class="btn btn-primary">Add Card</button>
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