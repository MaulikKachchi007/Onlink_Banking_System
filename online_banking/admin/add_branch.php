<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
    global $con;
    $lastid='';
    $q = "SELECT * FROM branch order by ifsccode desc limit  1";
    $stmt = $con->query($q);
    $res = $stmt->execute();
    $row = $stmt->fetch();
    $lastid = $row['ifsccode'];
    if ($lastid == "") {
        $ifsccode = "OBP00001";
    }else {
        $ifsccode = substr($lastid,6);
        $ifsccode = intval($ifsccode);
        $ifsccode = "OBP0000".($ifsccode + 1);
    }
if (isset($_POST["add_branch"])) {
    $ifsc_code = $_POST["icode"];
    $branch_name = $_POST["branch_name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $country = $_POST["country"];
    $status = $_POST["status"];
    if (empty($branch_name) || empty($address) || empty($city) || empty($state) || empty($country) || empty($status)) {
        $_SESSION["error_message"] = "All must fill required.";
    }else {
        global $con;
            $sql = "INSERT INTO branch(ifsccode,bname,address,city,state,country,status) VALUES(:ifsccode,:bname,:address,:city,:state,:country,:status)";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':ifsccode',$ifsc_code);
            $stmt->bindValue(':bname',$branch_name);
            $stmt->bindValue(':address',$address);
            $stmt->bindValue(':city',$city);
            $stmt->bindValue(':state',$state);
            $stmt->bindValue(':country',$country);
            $stmt->bindValue(':status',$status);
            $result = $stmt->execute();
            if ($result) {
                $_SESSION['success_message'] = "Branch  Added Successfully";
            }else{
                $_SESSION['error_message'] = "Something went wrong. Try again!";
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
                                            <h1 class="text-dark">Add Branch</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add Branch</li>
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
                                        <label for="ifsc_Code">IFSC Code</label>
                                        <input class="form-control" style="color: red;" value="<?php echo $ifsccode; ?>" name="icode" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="b_name">Branch Name</label>
                                        <input class="form-control" name="branch_name" placeholder="Branch Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="add">Address</label>
                                        <textarea class="form-control" name="address" rows="5" cols="25" placeholder="Address"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input class="form-control" name="city" placeholder="City">
                                    </div>
                                    <div class="form-group">
                                        <label for="city">State</label>
                                        <select class="form-control" name="state">
                                            <option value="None" selected>None</option>
                                            <?php
                                                $state = array('AP' => 'Andhra Pradesh',
                                                    'AR' => 'Arunachal Pradesh',
                                                    'AS' => 'Assam',
                                                    'BR' => 'Bihar',
                                                    'CT' => 'Chhattisgarh',
                                                    'GA' => 'Goa',
                                                    'GJ' => 'Gujarat',
                                                    'HR' => 'Haryana',
                                                    'HP' => 'Himachal Pradesh',
                                                    'JK' => 'Jammu and Kashmir',
                                                    'JH' => 'Jharkhand',
                                                    'KA' => 'Karnataka',
                                                    'KL' => 'Kerala',
                                                    'MP' => 'Madhya Pradesh',
                                                    'MH' => 'Maharashtra',
                                                    'MN' => 'Manipur',
                                                    'ML' => 'Meghalaya',
                                                    'MZ' => 'Mizoram',
                                                    'NL' => 'Nagaland',
                                                    'OR' => 'Odisha',
                                                    'PB' => 'Punjab',
                                                    'RJ' => 'Rajasthan',
                                                    'SK' => 'Sikkim',
                                                    'TN' => 'Tamil Nadu',
                                                    'TG' => 'Telangana',
                                                    'TR' => 'Tripura',
                                                    'UT' => 'Uttarakhand',
                                                    'UP' => 'Uttar Pradesh',
                                                    'WB' => 'West Bengal',
                                                    'AN' => 'Andaman and Nicobar Islands',
                                                    'CH' => 'Chandigarh',
                                                    'DN' => 'Dadra and Nagar Haveli',
                                                    'DD' => 'Daman and Diu',
                                                    'DL' => 'Delhi',
                                                    'LD' => 'Lakshadweep',
                                                    'PY' => 'Puducherry'
                                                    );
                                                    foreach ($state as $st => $value) {
                                          ?>
                                                        <option value='<?php echo $value; ?>'><?php echo $value; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select class="form-control" name="country">
                                            <option value="None" selected>None</option>
                                            <option value="India">India</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="None" selected>None</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="add_branch" class="btn btn-primary">Add Branch</button>
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