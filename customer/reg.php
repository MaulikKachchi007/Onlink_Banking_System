<?php
include_once "include/DB.php";
include_once "include/session.php";
include_once "include/function.php";
ob_start();
if (isset($_POST['submit'])){
    $firstname = $_POST['FirstName'];
    $ifsccode = $_POST['branch'];
    $lastname = $_POST['LastName'];
    $email = $_POST['email'];
    $photo = $_FILES['photo']['name'];
    $idproof = $_FILES['idproof']['name'];
    $phone = $_POST['phone'];
    $houseno = $_POST['h_no'];
    $locality = $_POST['locality'];
    $pincode = $_POST['pincode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $adharnumber = $_POST['adharnumber'];
    $marital = $_POST['marital'];
    $occuption = $_POST['occuption'];
    $account_type = $_POST['accounttype'];
    $password = base64_encode($_POST['password']);
    $confirm_password = $_POST['rpwd'];
    $pin = base64_encode($_POST['pin']);
    $cpin = $_POST['cpin'];
    $token = bin2hex(random_bytes(15));
    $target = "customer image/" . basename($_FILES["photo"]["name"]);
    $targetidproof = "customer image/" . basename($_FILES["idproof"]["name"]);

//    $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
    if (checkUserExists($email)) {
        $_SESSION['error_message'] = "User already exists";
        redirect('reg.php');
    }
    else {
        global $con;
        $sql = "INSERT INTO customers_master(f_name,l_name,email,phone,photo,idproof,h_no,locality,ifsccode,pincode,city,state,country,adharnumber,gender,birthdate,marital,occuption,account_type,password,token,pin,accountstatus)
               VALUES(:f_Name,:l_name,:email,:phone,:photo,:idproof,:h_no,:locality,:ifsccode,:pincode,:city,:state,:country,:adharnumber,:gender,:birthdate,:marital,:occupation,:account_type,:password,:token,:pin,:accountstatus)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':f_Name', $firstname);
        $stmt->bindValue(':l_name', $lastname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':photo', $photo);
        $stmt->bindValue(':idproof', $idproof);
        $stmt->bindValue('h_no', $houseno);
        $stmt->bindValue('locality', $locality);
        $stmt->bindValue('ifsccode', $ifsccode);
        $stmt->bindValue('pincode', $pincode);
        $stmt->bindValue('city', $city);
        $stmt->bindValue(':state', $state);
        $stmt->bindValue(':country', $country);
        $stmt->bindValue(':adharnumber', $adharnumber);
        $stmt->bindValue(':gender', $gender);
        $stmt->bindValue(':birthdate', $birthdate);
        $stmt->bindValue(':marital', $marital);
        $stmt->bindValue(':occupation', $occuption);
        $stmt->bindValue(':account_type', $account_type);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':pin', $pin);
        $stmt->bindValue(':accountstatus', 'Inactive');
        $result = $stmt->execute();
        //Move Upload File
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target);
        move_uploaded_file($_FILES["idproof"]["tmp_name"], $targetidproof);
        include_once 'include/sendmail.php';
        $msg = "<strong>Dear Mr/Mrs. $firstname,</strong><br><br>
                        <p>Welcome to OctoPrime E-Banking. Join the Family.</p>
                    	 <P>In case you need any further clarification for the same, please do get in touch with your Branch</P></br>
                    	 <hr>
                        <p>Please do not reply to this email. Emails sent to this address will not be answered. Copyright ©2021 OctoPrime E-Banking. </p>
                        <p>Thank you for banking with OctoPrime E-Banking.<br> </p>";
        if ($result){
            sendmail($email,"OctoPrime E-Banking Openging Banking Account",$msg,"OctoPrime E-Banking");
            $_SESSION['success_message'] = "Your Account was created successfully You have received Notifications Send to Mail";
            redirect('reg.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong! Try again.";
            redirect('reg.php');
        }
    }
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in | Prime Bank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="border border-info mt-3 rounded my_form" style="background-color: #e9ecef;">
                    <h4>Customer Registration</h4>
                    <p class="text-muted">Please Register with us to take the benefits of Our Online Banking Facilities</p>
                    <div class="container p-1">
                        <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                        ?>
                    </div>
                    <form method="post"  role="form" name="register" onsubmit="return validation()" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label class="b_name">Branch Name</label>
                                <select name="branch" id="branch" class="form-control form-control-sm">
                                    <option value="select" selected>Select</option>
                                    <?php
                                        global $con;
                                        $sql = "SELECT * FROM branch";
                                        $stmt = $con->query($sql);
                                        while ($row = $stmt->fetch()) {
                                            $ifsccode = $row['ifsccode'];
                                            $bname = $row['bname'];
                                            $address = $row['address'];
                                            $city = $row['city'];
                                            ?>
                                         <option value='<?php echo $ifsccode;?>'><?php echo $ifsccode;?> (<?php echo $bname;?> <?php echo  $address;?>,<?php echo $city; ?>)</option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                <span class="text-danger" id="errorbranch"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label class="f_name">First Name</label>
                                <input class="form-control form-control-sm" type="text" name="FirstName" id="first_name" placeholder="First Name">
                                <span class="text-danger" id="first_name_error"></span>
                            </div>
                            <div class="col-lg-6">
                                <label class="l_name">Last Name</label>
                                <input type="text" class="form-control form-control-sm" name="LastName" id="lastname" placeholder="Last Name">
                                <span class="text-danger" id="last_name_error"></span>
                            </div>
                        </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label class="email">Email ID</label>
                            <input type="text" class="form-control form-control-sm" name="email"  placeholder="Email ID" id="email">
                            <span class="text-danger" id="email_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="phone">Mobile Number</label>
                            <input type="number" class="form-control form-control-sm" name="phone" placeholder="Mobile Number" id="phone">
                            <span class="text-danger" id="phoneerror"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label class="pwd">Password</label>
                            <input type="password" class="form-control form-control-sm" name="password" placeholder="Password" id="password">
                            <span class="text-danger" id="pwd_error"></span>
                        </div>
                        <div class="col-lg-6">
                            <label class="confirmpwd">Confirm Password</label>
                            <input type="password" class="form-control form-control-sm" name="rpwd" placeholder="Confirm Password" id="confirm_password">
                            <span class="text-danger" id="confirm_pwd_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label class="pin">Transaction Pin</label>
                            <input type="password" class="form-control form-control-sm" name="pin" id="pin" placeholder="Transaction Pin" id="pin">
                            <span class="text-danger" id="pin_error"></span>
                        </div>
                        <div class="col-lg-6">
                            <label class="confirm_pin">Confirm Pin</label>
                            <input type="password" class="form-control form-control-sm" name="cpin" id="cpin" placeholder="Confirm Transaction Pin" id="cpin">
                            <span class="text-danger" id="cpin_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label class="h_no">House Number</label>
                            <input class="form-control form-control-sm" type="text" name="h_no" id="h_no" placeholder="House Number">
                            <span class="text-danger" id="h_no_error"></span>
                        </div>
                        <div class="col-lg-6">
                            <label class="locality">Locality/Street name</label>
                            <input type="text" class="form-control form-control-sm" name="locality" id="locality" placeholder="Locality">
                            <span class="text-danger" id="locality_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label class="pincode">Pincode</label>
                            <input class="form-control form-control-sm" type="text" id="pincode" name="pincode" placeholder="pincode">
                            <span class="text-danger" id="pincode_error"></span>
                        </div>
                        <div class="col-lg-6">
                            <label class="City">City</label>
                            <input type="text" class="form-control form-control-sm" name="city" id="city" placeholder="City">
                            <span class="text-danger" id="city_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label class="State">State</label>
                            <select class="form-control form-control-sm" name="state" id="state">
                                <option value="Select" selected>Select</option>
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
                            <span class="text-danger" id="stateerror"></span>
                        </div>
                        <div class="col-lg-6">
                            <label class="Country">Country</label>
                            <input type="text" class="form-control form-control-sm" name="country" id="country" readonly value="India" placeholder="Country">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="adharnumber">Adhar Number</label>
                            <input type="number" class="form-control form-control-sm" name="adharnumber" id="adharnumber" placeholder="Adhar Number">
                            <span class="text-danger" id=adharnumber_error></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Gender</label>
                            <select class="form-control form-control-sm" id="gender" name="gender">
                                <option value="Select" selected>Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <span class="text-danger" id="gender_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Date of Birth</label>
                            <input type="date" min="06/02/2001" id="birthdate" name="birthdate" class="form-control form-control-sm">
                            <span class="text-danger" id="datebirth_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Marital Status</label>
                            <select class="form-control form-control-sm" id="marital" name="marital">
                                <option value="Select" selected>Select</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Other">Other</option>
                            </select>
                            <span class="text-danger" id="marital_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Occupation</label>
                            <select class="form-control form-control-sm" name="occuption" id="occuption">
                                <option value="Select" selected>None</option>
                                <option value="Salary">Salary</option>
                                <option value="Self Employed">Self Employed</option>
                                <option value="Professional">Professional</option>
                                <option value="House Wife">House Wife</option>
                                <option value="Retired">Retired</option>
                                <option value="Student">Student</option>
                            </select>
                            <span class="text-danger" id="occuption_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                        <label class="a_type">Accounts Type</label>
                            <select class="form-control form-control-sm" id="accounttype" name="accounttype">
                                <option value="Select" selected>Select</option>
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
                            <span class="text-danger" id="a_type_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="photo">Photo</label>
                            <div class="custom-file">
                                <input type="file" name="photo"  class="custom-file-input form-control-sm" id="photo">
                                <label class="custom-file-label"for="customFile">Choose file</label>
                            </div>
                            <span class="text-danger" id="photo_error"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="proof">Proof</label>
                            <div class="custom-file">
                                <input type="file" name="idproof"  class="custom-file-input custom-file-input-sm" id="idproof">
                                <label class="custom-file-label"for="customFile">Choose file</label>
                            </div>
                            <span class="text-danger" id="idprooferror"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <input type="submit" name="submit" class="btn btn-md btn-block btn-primary" value="Register">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">
                            <a href="login.php" class="list-link">Click Here To Login</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- jQuery -->
    <script type="text/javascript">
        function validation(){
            var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
            var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
            var alphanumbericExp = /^[a-zA-Z0-9]+$/; //Variable to validate only alphabets and space
            var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
            let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; //Email
            document.getElementById("errorbranch").innerHTML = "";
            document.getElementById("first_name_error").innerHTML = "";
            document.getElementById("last_name_error").innerHTML = "";
            document.getElementById("email_error").innerHTML = "";
            document.getElementById("pwd_error").innerHTML = "";
            document.getElementById("confirm_pwd_error").innerHTML = "";
            document.getElementById("pin_error").innerHTML = "";
            document.getElementById("cpin_error").innerHTML = "";
            document.getElementById("h_no_error").innerHTML = "";
            document.getElementById("locality_error").innerHTML = "";
            document.getElementById("pincode_error").innerHTML = "";
            document.getElementById("city_error").innerHTML = "";
            document.getElementById("stateerror").innerHTML = "";
            document.getElementById("adharnumber_error").innerHTML = "";
            document.getElementById("gender_error").innerHTML = "";
            document.getElementById("datebirth_error").innerHTML = "";
            document.getElementById("marital_error").innerHTML = "";
            document.getElementById("occuption_error").innerHTML = "";
            document.getElementById("a_type_error").innerHTML = "";
            document.getElementById("photo_error").innerHTML = "";
            document.getElementById("idprooferror").innerHTML = "";
            // var validateform =0;
            if (document.register.branch.value == "select") {
                document.getElementById("errorbranch").innerHTML = "Branch must be Selected";
                validateform=1;
            }if(document.register.first_name.value =="")
            {
                document.getElementById("first_name_error").innerHTML ="First Name Must Required.";
                validateform=1;
            }else
            {
                if(!document.register.first_name.value.match(alphaExp))
                {
                    document.getElementById("first_name_error").innerHTML = "Only Alphabets allowed";
                    validateform=1;
                }
            }
            if(document.register.lastname.value == "")
            {
                document.getElementById("last_name_error").innerHTML ="Last Name Must Required.";
                validateform=1;
            }else {
                if (!document.register.lastname.value.match(alphaExp)) {
                    document.getElementById("last_name_error").innerHTML = "Only Alphabets allowed";
                    validateform = 1;
                }
            }
            if(document.register.email.value == "")
            {
                document.getElementById("email_error").innerHTML ="Email Must Required.";
                validateform=1;
            }else {
                if (!document.register.email.value.match(regexEmail)) {
                    document.getElementById("email_error").innerHTML = "Enter Valid Email Format";
                    validateform = 1;
                }
            }
            if(document.register.phone.value == "")
            {
                document.getElementById("phoneerror").innerHTML ="Mobile Number Must Required.";
                validateform=1;
            }else {
                var pnumber = document.register.phone.value;
                if (!document.register.phone.value.match(numericExpression)) {
                    document.getElementById("phoneerror").innerHTML = "Enter Valid Mobile Number Format";
                    validateform = 1;
                }else if(pnumber.length  != 10){
                    document.getElementById("phoneerror").innerHTML = "Mobile Number Must be 10 Digit";
                    validateform = 1;
                }
            }
            if(document.register.password.value == "")
            {
                document.getElementById("pwd_error").innerHTML ="Password Must Required.";
                validateform=1;
            }else {
                var pwd_num_length = /[0-9]/g;
                var lowerCaseLetters = /[a-z]/g;
                var upperCaseLetters = /[A-Z]/g;
                var special = /['^£$%&*()}{@#~?><>,|=_+¬-]/g;
                var pwd_length = document.register.password.value;
                if(pwd_length.length  <= 8 && pwd_length.length <=12){
                    document.getElementById("pwd_error").innerHTML = "Password Must be 8 to 12 Character";
                    validateform = 1;
                }else if(!document.register.password.value.match(pwd_num_length)){
                    document.getElementById("pwd_error").innerHTML = "One Character Digit";
                    validateform = 1;
                }else if(!document.register.password.value.match(lowerCaseLetters)){
                    document.getElementById("pwd_error").innerHTML = "One Character Lowercase";
                    validateform = 1;
                }else if(!document.register.password.value.match(upperCaseLetters)){
                    document.getElementById("pwd_error").innerHTML = "One Character Uppercase";
                    validateform = 1;
                }else if(!document.register.password.value.match(special)){
                    document.getElementById("pwd_error").innerHTML = "One Character Special Characters";
                    validateform = 1;
                }
            }
            if(document.register.confirm_password.value == "")
            {
                document.getElementById("confirm_pwd_error").innerHTML ="Confirm Password Must Required.";
                validateform=1;
            }
            if(document.register.password.value!=document.register.confirm_password.value){
                document.getElementById("pwd_error").innerHTML ="Password and Confirm Password Not Match.";
                validateform=1;
            }
            if(document.register.pin.value == "")
            {
                document.getElementById("pin_error").innerHTML ="Pin Must Required.";
                validateform=1;
            }else {
                var pin_length = document.register.pin.value;
                if(pin_length.length  !=6){
                    document.getElementById("pin_error").innerHTML = "Password Must be 6 Digit";
                    validateform = 1;
                }else if(!document.register.pin.value.match(numericExpression)){
                    document.getElementById("pin_error").innerHTML = "Only Digit Allowed";
                    validateform = 1;
                }
            }
            if(document.register.cpin.value == "")
            {
                document.getElementById("cpin_error").innerHTML ="Confirm Pin Must Required.";
                validateform=1;
            }
            if(document.register.pin.value!=document.register.cpin.value){
                document.getElementById("pin_error").innerHTML ="Pin and Confirm Pin Not Match.";
                validateform=1;
            }
            if(document.register.h_no.value == "")
            {
                document.getElementById("h_no_error").innerHTML ="House Number Must Required.";
                validateform=1;
            }
            if(document.register.locality.value == "")
            {
                document.getElementById("locality_error").innerHTML ="Street/Locality Must Required.";
                validateform=1;
            }
            if(document.register.pincode.value == "")
            {
                document.getElementById("pincode_error").innerHTML ="Pincode Must Required.";
                validateform=1;
            }else{
                if (!document.register.pincode.value.match(numericExpression)) {
                    document.getElementById("pincode_error").innerHTML = "Enter Valid Pincode Format";
                    validateform = 1;
                }else if(document.register.pincode.length != 6){
                    document.getElementById("pincode_error").innerHTML = "Pincode Must be 6 Digit";
                    validateform = 1;
                }
            }
            if(document.register.city.value == "") {
                document.getElementById("city_error").innerHTML = "City Must Required.";
                validateform = 1;
            }else {
                if(!document.register.city.value.match(alphaExp))
                {
                    document.getElementById("city_error").innerHTML = "Only Alphabets allowed";
                    validateform=1;
                }
            }

            if (document.register.state.value == "Select") {
                document.getElementById("stateerror").innerHTML = "State must be Selected";
                validateform=1;
            }
            if(document.register.adharnumber.value == "")
            {
                document.getElementById("adharnumber_error").innerHTML ="Adhar Number  Must Required.";
                validateform=1;
            }else{
                if (!document.register.adharnumber.match(numericExpression)) {
                    document.getElementById("adharnumber_error").innerHTML = "Enter Adhar Number Format.";
                    validateform = 1;
                }else if(document.register.adharnumber.length  != 12){
                    document.getElementById("adharnumber_error").innerHTML = "Adhar NumberMust be 12 Digit.";
                    validateform = 1;
                }
            }
            if (document.register.gender.value == "Select") {
                document.getElementById("gender_error").innerHTML = "Gender must be Selected.";
                validateform=1;
            }
            if (document.register.birthdate.value == "") {
                document.getElementById("datebirth_error").innerHTML = "Birthdate must be Required.";
                validateform=1;
            }
            if (document.register.marital.value == "Select") {
                document.getElementById("marital_error").innerHTML = "Marital Staus must be Selected.";
                validateform=1;
            }
            if (document.register.occuption.value == "Select") {
                document.getElementById("occuption_error").innerHTML = "Occupation must be Selected.";
                validateform=1;
            }
            if (document.register.accounttype.value == "Select") {
                document.getElementById("a_type_error").innerHTML = "Occupation must be Selected.";
                validateform=1;
            }
            if (document.register.photo.value == "")
            {
                document.getElementById("photo_error").innerHTML = "Please Select any image.";
                validateform=1;
            }else{
                var  validext = ["jpeg","jpg"];
                var pos_of_dot = document.register.photo.value.lastIndexOf('.')+1;
                var img_ext = document.register.photo.value.substring(pos_of_dot);
                var result =  validext.includes(img_ext);
                if (result==false) {
                    document.getElementById("photo_error").innerHTML = "Only JPG Files Allowed.";
                    validateform=1;
                }else{
                    if (parseFloat(document.register.photo.files[0].size/(1024*1024))>= 3){
                        document.getElementById("photo_error").innerHTML = "Files Size Must be Smaller than 3MB.";
                        validateform=1;
                    }
                }
            }
            if (document.register.idproof.value == "")
            {
                document.getElementById("idprooferror").innerHTML = "Please Select any image.";
                validateform=1;
            }else {
                var  validext = ["jpeg","jpg"];
                var pos_of_dot = document.register.idproof.value.lastIndexOf('.')+1;
                var img_ext = document.register.idproof.value.substring(pos_of_dot);
                var result =  validext.includes(img_ext);
                if (result==false) {
                    document.getElementById("idprooferror").innerHTML = "Only JPG Files Allowed.";
                    validateform=1;
                }else{
                    if (parseFloat(document.register.idproof.files[0].size/(1024*1024))>= 3){
                            document.getElementById("idprooferror").innerHTML = "Files Size Must be Smaller than 3MB.";
                        validateform=1;
                    }
                }
            }

            if (validateform==0){
                return true;
            }else{
                return false;
            }
        }
    </script>
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<!-- <script src="../../plugins/jquery-validation/additional-methods.min.js"></script> -->
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
</body>
</html>