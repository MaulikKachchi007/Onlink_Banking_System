<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST["update_branch"])) {
    $get_id = $_GET['id'];
    $branch_name = $_POST["branch_name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $country = $_POST["country"];
    if (empty($ifsc_code) || empty($emp_name ) || empty($l_id) || empty($pwd) || empty($cpwd) || empty($email) || empty($mno) || empty($e_type) || empty($status)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('add_employee.php');
    }else {
        global $con;
        $sql = "Update branch SET bname='$branch_name',address='$address',city='$city',state='$state',country='$country' WHERE bid='$get_id'";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Branch Updated Successfully";
            redirect('view_branch.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";

        }
    }
}
global $con;
$q = "SELECT * FROM branch WHERE bid='$get_id'";
$stmt = $con->query($q);
$res = $stmt->execute();
while($row = $stmt->fetch()) {
     $icode = $row["ifsccode"];
     $bname = $row["bname"];
    $add = $row["address"];
    $bcity = $row["city"];
    $bstate = $row["state"];
    $bcountry = $row["country"];
    $status = $row["status"];
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
                                            <h1 class="text-dark">Update Branch</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Update Branch</li>
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
                            <form role="form" action="update_branch.php?id=<?php echo $get_id; ?>" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="ifsc_Code">IFSC Code</label>
                                        <input class="form-control" style="color: red;" value="<?php echo $icode;  ?>" name="icode" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="b_name">Branch Name</label>
                                        <input class="form-control" name="branch_name" value="<?php echo $bname;  ?>" placeholder="Branch Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="add">Address</label>
                                        <textarea class="form-control" name="address" rows="5" cols="25"><?php echo $add;  ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input class="form-control" name="city" value="<?php echo $bcity;  ?>" Branch placeholder="City">
                                    </div>
                                    <div class="form-group">
                                        <label for="city">State</label>
                                        <select class="form-control" name="state">
                                            <option value="<?php echo $bstate;  ?>" selected><?php echo $bstate;  ?></option>
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
                                            <option value="<?php echo $bcountry;?>" selected><?php echo $bcountry;  ?></option>
                                            <option value="India">India</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="update_branch" class="btn btn-primary">Update Branch</button>
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