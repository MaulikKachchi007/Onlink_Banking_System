<?php
include 'include/DB.php';
include 'include/function.php';
//include 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$c_id = $_SESSION['c_id'];
//if (isset($_POST["add_branch"])) {
//    $ifsc_code = $_POST["icode"];
//    $branch_name = $_POST["branch_name"];
//    $address = $_POST["address"];
//    $city = $_POST["city"];
//    $state = $_POST["state"];
//    $country = $_POST["country"];
//    $status = $_POST["status"];
//    if (empty($branch_name) || empty($address) || empty($city) || empty($state) || empty($country) || empty($status)) {
//        $_SESSION["error_message"] = "All must fill required.";
//    }else {
//        global $con;
//        $sql = "INSERT INTO branch(ifsccode,bname,address,city,state,country,status) VALUES(:ifsccode,:bname,:address,:city,:state,:country,:status)";
//        $stmt = $con->prepare($sql);
//        $stmt->bindValue(':ifsccode',$ifsc_code);
//        $stmt->bindValue(':bname',$branch_name);
//        $stmt->bindValue(':address',$address);
//        $stmt->bindValue(':city',$city);
//        $stmt->bindValue(':state',$state);
//        $stmt->bindValue(':country',$country);
//        $stmt->bindValue(':status',$status);
//        $result = $stmt->execute();
//        if ($result) {
//            $_SESSION['success_message'] = "Branch  Added Successfully";
//        }else{
//            $_SESSION['error_message'] = "Something went wrong. Try again!";
//        }
//    }
//}
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
                                            <h1 class="text-dark">Make Loan Payment</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Loan Payment</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_branch.php" class="btn btn-info float-right text-white">View Record</a>
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
                                        <label for="loan_account_number">Loan Account Number</label>
                                        <select class="form-control"  name="loan_account_number" onChange="load_account_change(this.value)">
                                            <option value="Select" selected>Select</option>
                                            <?php
                                                global $con;
                                                $c_id = $_SESSION['c_id'];
                                                $sql = "SELECT * FROM loan WHERE c_id = '$c_id' AND status = 'Approved'";
                                                $stmt = $con->query($sql);
                                                var_dump($stmt->errorInfo());
                                                while ($row = $stmt->fetch()) {
                                                    $loan_account_number = $row["loan_account_number"];
                                            ?>
                                                <option value="<?php echo $loan_account_number;?>"><?php echo $loan_account_number;?></option>
                                        </select>
                                            <?php
                                            }
                                            ?>

                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div id="loading_data"></div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
<script type="text/javascript">
    function load_account_change(loan_account_number) {
        document.getElementById("loading_data").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText == 0)
                {
                    document.getElementById("loading_data").innerHTML = "<img src='images/LoadingSmall.gif' width='172' height='172' />";
                }
                else
                {
                    document.getElementById("loading_data").innerHTML = this.responseText;
                }
            }
        };
        xmlhttp.open("GET","ajaxloanaccount.php?loan_account_number="+loan_account_number,true);
        xmlhttp.send();
    }

</script>
<?php
include 'include/footer.php';
?>