<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
    $_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
    confirm_login();
    $get_id = $_GET['id'];
    if (isset($_POST["update_account"])) {
        $get_id = $_GET['id'];
        $fname = $_POST['f_name'];
        $lname = $_POST['l_name'];
        $emailid = $_POST['email'];
        $image = $_FILES['photo']['name'];
        $mno = $_POST['phonenumber'];
        $hno = $_POST['h_no'];
        $c_locality = $_POST['locality'];
        $c_area = $_POST['area'];
        $c_pincode = $_POST['pincode'];
        $c_city = $_POST['city'];
        $c_gender = $_POST['gender'];
        $c_date = $_POST['birthdate'];
        $c_adharnumber = $_POST['adharnumber'];
        $c_marital = $_POST['marital'];
        $c_occuption = $_POST['occupation'];
        $c_account_type = $_POST['accounttype'];
        $status = "active";
        if (empty($fname)) {
            $_SESSION["error_message"] = "All must fill required.";
        }else {
            global $con;

            if (!empty($_FILES["photo"]["name"])) {
            $q = "Update customers_master SET f_name='$fname',l_name='$lname',email='$emailid',phone='$mno',photo='$image',
                  h_no='hno',locality='$c_locality',pincode='$c_pincode',city='$c_city', adharnumber='$c_adharnumber',gender='$c_gender',birthdate='$c_date'
                 ,marital='$c_marital',occuption='$c_occuption',account_type='$c_account_type' WHERE id='$get_id'";
            }else{
                $q = "Update customers_master SET f_name='$fname',l_name='$lname',email='$emailid',phone='$mno',
                  h_no='$hno',locality='$c_locality',pincode='$c_pincode',city='$c_city', adharnumber='$c_adharnumber',gender='$c_gender',birthdate='$c_date'
                 ,marital='$c_marital',occuption='$c_occuption',account_type='$c_account_type' WHERE c_id='$get_id'";
             }
            $stmt = $con->prepare($q);
            $result = $stmt->execute();
            var_dump($result);
            if ($result) {
                $_SESSION['success_message'] = "Customer Details Update Successfully";
                redirect('customers_detail.php');
            }else{
                $_SESSION['error_message'] = "Something went wrong. Try again!";
                print_r($con->errorInfo());
//                redirect('customers_detail.php');
            }
        }
    }
    global $con;
    $firstname = $lastname = $email = $photo = $phone = $houseno = $locality  = $pincode = $city = $gender = $date = $adharnumber = $marital = $occuption = $account_type = $password = $cpwd =$pin = $cpin =  "";
    $sql = "SELECT * from customers_master WHERE c_id ='$get_id'";
    $stmt = $con->query($sql);
    $result = $stmt->execute();
    while ($row = $stmt->fetch()) {
        $firstname = $row['f_name'];
        $lastname = $row['l_name'];
        $email = $row['email'];
        $photo = $row['photo'];
        $phone = $row['phone'];
        $houseno = $row['h_no'];
        $locality = $row['locality'];
        $pincode = $row['pincode'];
        $ifsccode = $row['ifsccode'];
        $city = $row['city'];
        $gender = $row['gender'];
        $date = $row['birthdate'];
        $adharnumber = $row['adharnumber'];
        $marital = $row['marital'];
        $occuption = $row['occuption'];
        $account_type = $row['account_type'];
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
                                        <h1 class="text-dark">Update Account</h1>
                                    </div><!-- /.col -->
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="bankinguser/index.php">Home</a></li>
                                            <li class="breadcrumb-item active">Add Account</li>
                                        </ol>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div>
                            <a href="view_account.php" class="btn btn-info float-right text-white">View Record</a>
                        </div>
                        <div class="container p-1">
                        <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                        ?>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="update_customers_account.php?id=<?php echo $get_id; ?>" method="post">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="f_name">First Name</label>
                                    <input class="form-control" type="text" name="f_name" value="<?php echo $firstname; ?>" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <label for="l_name">Last Name</label>
                                    <input class="form-control" type="text" name="l_name" value="<?php echo $lastname;?>" placeholder="Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="text" name="email" value="<?php echo $email;?>" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Mobile</label>
                                    <input class="form-control" type="text" name="phonenumber" value="<?php echo $phone;?>" placeholder="Phone">
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                </div>
                                <div class="form-group custom-file">
                                        <input type="file" name="photo" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <div class="form-group">
                                    <label for="h_no">House No</label>
                                    <input type="text" name="h_no" class="form-control" value="<?php echo $houseno; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="locality">Locality</label>
                                    <input type="text" name="locality" class="form-control" value="<?php echo $locality; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="area">Area</label>
                                    <input type="text" name="area" class="form-control" value="<?php echo $ifsccode; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" class="form-control" value="<?php echo $pincode; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="adharnumber">Adhar Number</label>
                                    <input type="text" name="adharnumber" class="form-control" value="<?php echo $adharnumber; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="gender">gender</label>
                                    <input type="text" name="gender" class="form-control" value="<?php echo $gender; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="birthdate">Birth Date</label>
                                    <input type="date" name="birthdate" class="form-control" value="<?php echo $date; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Marital">Marital</label>
                                    <select name="marital" class="form-control">
                                        <option value="<?php echo $marital;?>"><?php echo $marital; ?></option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="occupation">Occupation</label>
                                    <select name="occupation" class="form-control">
                                        <option value="<?php echo $occuption;?>"><?php echo $occuption;?></option> ?></option>
                                        <option value="Salary">Salary</option>
                                        <option value="Self Employed">Self Employed</option>
                                        <option value="Professional">Professional</option>
                                        <option value="House Wife">House Wife</option>
                                        <option value="Retired">Retired</option>
                                        <option value="Student">Student</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="accounttype">Account Type</label>
                                    <select name="accounttype" class="form-control">
                                        <option value="<?php echo $account_type;?>"><?php echo $account_type;?></option>
                                          <?php
                                                        $sql = "SELECT * FROM account_master";
                                                        $stmt = $con->prepare($sql);
                                                        $stmt->execute();
                                                        while ($row = $stmt->fetch()) {
                                                            $account_type = $row['account_type'];
                                                            echo "<option value='$account_type'>$account_type</option>";
                                                        }
                                          ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="update_account" class="btn btn-primary">Update Record</button>
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
<script>

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
</script>
