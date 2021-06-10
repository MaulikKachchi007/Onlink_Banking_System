<?php
include 'include/DB.php';
include 'include/function.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
ob_start();
//$get_id = $_GET['id'];
if (isset($_POST['add_account'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $photo = $_FILES['photo']['name'];
    $idproof = $_FILES['idproof']['name'];
    $phone = $_POST['phonenumber'];
    $houseno = $_POST['h_no'];
    $locality = $_POST['locality'];
    $ifsccode = $_POST['branch'];
    $pincode = $_POST['pincode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $adharnumber = $_POST['adharnumber'];
    $marital = $_POST['marital'];
    $occuption = $_POST['occupation'];
    $account_type = $_POST['accounttype'];
    $password = $_POST['password'];
    $confirm_password = $_POST['rpwd'];
    $pin = $_POST['pin'];
    $cpin = $_POST['cpin'];
    $accountstatus = $_POST['account_status'];
    $target = "image/" . basename($_FILES["photo"]["name"]);
    $targetidproof = "image/" . basename($_FILES["idproof"]["name"]);
//    $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
    if (checkcustExists($email)) {
        $_SESSION['error_message'] = "User already exists";
        redirect('add_customer.php');
    }
    if (empty($firstname)  || empty($lastname) || empty($email) || empty($phone) || empty($houseno) || empty($locality)  || empty($pincode) || empty($city) || empty($birthdate)  || empty($adharnumber)|| empty($password) || empty($confirm_password) ||empty($pin) ||empty($cpin)){
        $_SESSION['error_message'] = "All must fill Required.";
        redirect('add_customer.php');
    }
    elseif(strlen($adharnumber) > 12){
        $_SESSION['error_message'] = "Adhar Card Must Be 12 Number.";
        redirect('add_customer.php');
    }elseif($_FILES['photo']['size'] > 3000000 || $_FILES['idproof']['size'] > 3000000){
        $_SESSION["error_message"] = "image size must be 3MB or less than.";
        redirect('add_customer.php');
    }
    elseif($_FILES["idproof"]["type"] != "image/jpg" && $_FILES["photo"]["type"] != "image/jpeg" ) {
        $_SESSION['error_message'] = "Sorry, only JPG files are allowed.";
        redirect('add_customer.php');
    }else if($gender=="Select" || $ifsccode=="Select" || $state=="Select" || $country=="Select" || $gender=="Select" || $marital=="Select" || $occuption=="Select" || $account_type=="Select" || $accountstatus=="Select"){
        $_SESSION['error_message'] = "All Select must fill Required.";
        redirect('add_customer.php');
    }else if(!preg_match('/^[0-9]{10}+$/', $phone)) {
        $_SESSION['error_message'] = "Mobile Number Must be 10 Number.";
        redirect('add_customer.php');
    }else if(!preg_match('/^\d{6}$/', $pincode)){
        $_SESSION['error_message'] = "Pincode must be 6 Number.";
        redirect('add_customer.php');
    }elseif (strlen($pin)  > 6) {
        $_SESSION['error_message'] = "Your Transaction Pin  Less than 6 characters!";
        redirect('add_customer.php');
    }elseif(!preg_match('/^[0-9]{6}+$/',$pin)) {
        $_SESSION['error_message'] = "Your Password Must Contain At Least 1 Number!";
        redirect('add_customer.php');
    } else if($password != $confirm_password){
        $_SESSION['error_message'] = "Password and Confirm Password Not Same.";
        redirect('add_customer.php');
    }else if($pin != $cpin){
        $_SESSION['error_message'] = "Transaction Pin and Confirm Transaction Pin Confirm Password Not Same.";
        redirect('add_customer.php');
    }elseif (strlen($password)  > 11) {
        $_SESSION['error_message'] = "Your Password  Less than 10 characters!";
        redirect('add_customer.php');
    }elseif(!preg_match("#[0-9]+#",$password)) {
        $_SESSION['error_message'] = "Your Password Must Contain At Least 1 Number!";
        redirect('add_customer.php');
    }elseif(!preg_match("#[A-Z]+#",$password)) {
        $_SESSION['error_message'] = "Your Password Must Contain At Least 1 Capital Letter!";
        redirect('add_customer.php');
    }elseif(!preg_match("#[a-z]+#",$password)) {
        $_SESSION['error_message'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
        redirect('add_customer.php');
    }elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
        $_SESSION['error_message'] = "Your Password Must Contain At Least 1 Special Character !";
        redirect('add_customer.php');
    } else if($password != $confirm_password){
        $_SESSION['error_message'] = "Password and Confirm Password Not Same.";
        redirect('add_customer.php');
    }
    else{
        global $con;
        $sql = "INSERT INTO customers_master(f_name,l_name,email,phone,photo,idproof,h_no,locality,ifsccode,pincode,city,state,country,adharnumber,gender,birthdate,marital,occuption,account_type,password,pin,accountstatus) 
               VALUES(:f_Name,:l_name,:email,:phone,:photo,:idproof,:h_no,:locality,:ifsccode,:pincode,:city,:state,:country,:adharnumber,:gender,:birthdate,:marital,:occupation,:account_type,:password,:pin,:accountstatus)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':f_Name',$firstname);
        $stmt->bindValue(':l_name',$lastname);
        $stmt->bindValue(':email',$email);
        $stmt->bindValue(':phone',$phone);
        $stmt->bindValue(':photo',$photo);
        $stmt->bindValue(':idproof',$idproof);
        $stmt->bindValue('h_no',$houseno);
        $stmt->bindValue('locality',$locality);
        $stmt->bindValue('ifsccode',$ifsccode);
        $stmt->bindValue('pincode',$pincode);
        $stmt->bindValue('city',$city);
        $stmt->bindValue(':state',$state);
        $stmt->bindValue(':country',$country);
        $stmt->bindValue(':adharnumber',$adharnumber);
        $stmt->bindValue(':gender',$gender);
        $stmt->bindValue(':birthdate',$birthdate);
        $stmt->bindValue(':marital',$marital);
        $stmt->bindValue(':occupation',$occuption);
        $stmt->bindValue(':account_type',$account_type);
        $stmt->bindValue(':password',$password);
        $stmt->bindValue(':pin',$pin);
        $stmt->bindValue(':accountstatus',$accountstatus);
        $result = $stmt->execute();
        print_r($con->errorInfo());
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target);
        move_uploaded_file($_FILES["idproof"]["tmp_name"], $targetidproof);
                    include_once 'include/sendmail.php';
                     $msg = "<strong>Dear Mr/Mrs. $firstname,</strong><br><br>                                                                                
                    	 <P>In case you need any further clarification for the same, please do get in touch with your Branch</P></br>                         
                    	 <hr>                                                                                                                                 
                        <p>Please do not reply to this email. Emails sent to this address will not be answered. Copyright ©2021 OctoPrime E-Banking. </p>     
                        <p>Thank you for banking with OctoPrime E-Banking.<br> </p>";                                                                           
        if ($result){
                sendmail($email,"OctoPrime E-Banking Openging Banking Account",$msg,"OctoPrime E-Banking");
                $_SESSION['success_message'] = "Your Account was created successfully You have received Notifications Send to Mail";
                redirect('add_customer.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong! Try again.";
            redirect('add_customer.php');
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
                                        <h1 class="text-dark">Add Customers</h1>
                                        <p class="text text-muted">Enter Customers Records</p>
                                    </div><!-- /.col -->
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                            <li class="breadcrumb-item active">Add Customers</li>
                                        </ol>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div>
                            <a href="view_customers.php" class="btn btn-info float-right text-white">View Record</a>
                        </div>
                        <div class="container p-1">
                            <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            ?>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="quickForm" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="area">Branch</label>
                                    <select class="form-control" name="branch">
                                        <option value="Select">Select</option>
                                    <?php
                                        global $con;
                                        $g_id = $_SESSION['id'];
                                        $sql = "SELECT * FROM employees_master 
                                                INNER JOIN branch ON employees_master.ifsccode=branch.ifsccode
                                                WHERE employees_master.id='$g_id'";
                                        $stmt = $con->query($sql);
                                        while ($row = $stmt->fetch()) {
                                            $bname = $row['bname'];
                                            $ifsccode = $row['ifsccode'];
                                            $city = $row['city'];
                                            $state = $row['state'];
                                            $country = $row['country'];
                                             echo "<option value='$ifsccode'>$ifsccode ($bname,$state,$country) </option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>First Name <small>(required)</small></label>
                                    <input name="firstname" type="text" class="form-control" placeholder="Your First Name">
                                </div>
                                <div class="form-group">
                                    <label>Last Name <small>(required)</small></label>
                                    <input name="lastname" type="text" class="form-control" placeholder="Your Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Mobile</label>
                                    <input class="form-control" type="text" name="phonenumber" placeholder="Phone">
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                </div>
                                <div class="form-group custom-file">
                                    <input type="file" name="photo" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <div class="form-group">
                                    <label for="idproof">ID Proof</label>
                                </div>
                                <div class="form-group custom-file">
                                    <input type="file" name="idproof" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <div class="form-group">
                                    <label for="h_no">House No</label>
                                    <input type="text" name="h_no" placeholder="House No" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="locality">Locality</label>
                                    <input type="text" name="locality" placeholder="Locality" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" placeholder="Pincode" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" placeholder="City" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="State">State</label>
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

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Country">Country</label>
                                    <select name="country" class="form-control">
                                        <option value="Select">Select</option>
                                        <option value="India">India</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="adharnumber">Adhar Number</label>
                                    <input type="text" name="adharnumber" placeholder="Adhar Number" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="gender">gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="Select">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="birthdate" >Birth Date</label>
                                    <input type="date" name="birthdate" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Marital">Marital</label>
                                    <select name="marital" class="form-control">
                                        <option value="Select">Select</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="occupation">Occupation</label>
                                    <select name="occupation" class="form-control">
                                        <option value="Select">Select</option>
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
                                        <option value="Select">Select</option>
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
                                    <label>Password</label>
                                    <input name="password" id="password" type="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password </label>
                                    <input name="rpwd" type="password" class="form-control" placeholder="Confirm password">
                                </div>
                                <div class="form-group">
                                    <label>Account Pin</label>
                                    <input name="pin" id="pin" type="password" class="form-control" placeholder="Account PIN">
                                </div>
                                <div class="form-group">
                                    <label>Verify Pin Number</label>
                                    <input name="cpin" type="password" class="form-control" placeholder="Verify Pin">
                                </div>
                                <div class="form-group">
                                    <label for="account_status">Account Status</label>
                                    <select name="account_status" class="form-control">
                                        <option value="Select">Select</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="add_account" class="btn btn-primary">Add Record</button>
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
<script src="assets/js/gsdk-bootstrap-wizard.js"></script>

</script>
