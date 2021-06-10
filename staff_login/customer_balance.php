<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST["update_account"])) {
    $amt = $_POST["bal_amt"];
    $t_type = $_POST["t_type"];
    $t_description = $_POST["t_description"];
    $status = "active";
    if (empty($amt)||empty($t_type)||empty($t_description)) {
        $_SESSION["error_message"] = "All must fill required.";
    }else {
        global $con;
        $sql  = "";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Account Fund Tranfer Successfully.";
            redirect('customers_detail.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
                redirect('customers_detail.php');
        }
    }
}
?>
<?php
require_once 'include/header.php';
require_once 'include/sidebar.php';
require_once 'include/topbar.php';
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
                                            <h1 class="text-dark">CREDIT/DEBIT Account</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="bankinguser/index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add Balance</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="customers_detail.php" class="btn btn-info float-right text-white">View Record</a>
                            </div>
                            <div class="container p-1">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                ?>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="customer_balance.php?id=<?php echo $get_id; ?>" method="post">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="amt">Amount</label>
                                        <input class="form-control" type="text" name="bal_amt"  placeholder="Balance">
                                    </div>
                                    <div class="form-group">
                                        <label for="t_type">Select Transact Type</label>
                                        <select name="t_type" class="form-control">
                                            <option value="None">None</option>
                                            <option value="Credit Fund">Credit Fund</option>
                                            <option value="Debit Fund">Debit Fund</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="t_description">Tranfer Description</label>
                                        <textarea class="form-control"  placeholder="Tranfer Description" name="t_description" rows="5" cols="10"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="" class="btn btn-primary">Credit/Debit Account</button>
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
    <script>

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
    </script>
<?php

include 'require_once/footer.php';
