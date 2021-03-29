<?php
// include_once "include/DB.php";
// include_once "include/session.php";
// include_once "include/function.php";

if (isset($_POST['finish'])){
    // echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // echo "</pre>";
    // $firstname = $_POST['firstname'];
    // $lastname = $_POST['lastname'];
    // $email = $_POST['email'];
    // $photo = $_POST['photo'];
    // $houseno = $_POST['houseno'];
    // $locality = $_POST['locality'];
    // $area = $_POST['area'];
    // $pincode = $_POST['pincode'];
    // $city = $_POST['city'];
    // $gender = $_POST['gender'];
    // $date = $_POST['date'];
    // $marital = $_POST['marital'];
    // $occuption = $_POST['occuption'];
    // $password = $_POST['password'];
    // $cpwd = $_POST['rpwd'];
    // $pin = $_POST['pin'];
    // $cpin = $_POST['cpin'];
    // $accountopendate = date("d/m/Y");
    // if ($password != $cpwd){
    //     $_SESSION['error_message'] = "Password and Confirm Password Not Match.";
    //     redirect('register.php');
    // }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    //     $_SESSION['error_message'] = "* Please enter Valid Email";
    //     redirect('register.php');
    // }elseif (checkUserExists($email)) {
    //         $_SESSION['error_message'] = "User already exists";
    //         redirect('register.php');
    // }else{
    //     global $con;
    //     $sql = "INSERT INTO customers_master(f_name,l_name,email,photo,h_no,locality,area,pincode,city,gender,birhdate,marital,occuption,password,pin,a_opendate) 
    //     VALUES(:f_name,:l_name,:email,:photo,:h_no,:locality,:area,:pincode,:city,:gender,:birhdate,:marital,:occuption,:password,:pin,:a_opendate)";
    //     $stmt = $con->prepare($sql);
    //     $stmt->bindValue(':f_name',$firstname);
    //     $stmt->bindValue(':l_name',$lastname);
    //     $stmt->bindValue(':email',$email);
    //     $stmt->bindValue(':photo',$photo);
    //     $stmt->bindValue(':h_no',$houseno);;
    //     $stmt->bindValue(':locality',$locality);
    //     $stmt->bindValue(':area',$area);
    //     $stmt->bindValue(':pincode',$pincode);
    //     $stmt->bindValue(':city',$city);
    //     $stmt->bindValue(':gender',$gender);
    //     $stmt->bindValue(':birthdate',$firstname);
    //     $stmt->bindValue(':marital',$marital);
    //     $stmt->bindValue(':occuption',$occuption);
    //     $stmt->bindValue(':password',$password);
    //     $stmt->bindValue(':pin',$pin);
    //     $stmt->bindValue(':a_opendate',$accountopendate);
    //     $result = $stmt->execute();
    //     echo $sql;
        // if ($result){
        //     $_SESSION['success_message'] = "Your Account was created successfully You have received Notifications Send to Mail";
        // }else{
        //     $_SESSION['error_message'] = "Something went wrong. Try again.";
        //     redirect('register.php');
        // }
    // }
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Registration Page</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!--     Fonts and icons     -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">

    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/gsdk-bootstrap-wizard.css" rel="stylesheet" />

</head>

<body class="hold-transition register-page">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-sm-offset-2">

                <!--      Wizard container        -->
                <div class="wizard-container">

                    <div class="card wizard-card" data-color="orange" id="wizardProfile">
                        <form  method="post" enctype="multipart/form-data">
                            <!--        You can switch ' data-color="orange" '  with one of the next bright colors: "blue", "green", "orange", "red"          -->

                            <div class="wizard-header">
                                <h3>
                                    <b>Create</b> YOUR Account <br>
                                    <small> Please Register with us to take the benefits of Our Online Banking
                                        Facilities</small>
                                </h3>
                            </div>

                            <div class="wizard-navigation">
                                <ul>
                                    <li><a href="#step1" data-toggle="tab">STEP1</a></li>
                                    <li><a href="#step2" data-toggle="tab">STEP2</a></li>
                                    <li><a href="#step3" data-toggle="tab">STEP3</a></li>
                                    <li><a href="#step4" data-toggle="tab">STEP4</a></li>
                                </ul>

                            </div>
                            <?php 
                                    // echo ErrorMessage();
                                    // echo SuccessMessage();
                                
                                ?>
                            <div class="tab-content">
                                <div class="tab-pane" id="step1">
                                    <div class="row">
                                        <div class="col-sm-4 col-sm-offset-1">
                                            <div class="picture-container">
                                                <div class="picture">
                                                    <img src="assets/img/default-avatar.png" class="picture-src"
                                                        id="wizardPicturePreview" title="" />
                                                    <input type="file" name="photo" id="wizard-picture">
                                                </div>
                                                <h6>Choose Picture</h6>
                                                <label id="photoError" style="color:red"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>First Name <small>(required)</small></label>
                                                <input name="firstname" type="text" class="form-control"
                                                    placeholder="Your First Name">
                                            </div>
                                            <div class="form-group">
                                                <label>Last Name <small>(required)</small></label>
                                                <input name="lastname" type="text" class="form-control"
                                                    placeholder="Your Last Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="form-group">
                                                <label>Email <small>(required)</small></label>
                                                <input name="email" type="email" class="form-control"
                                                    placeholder="Your email address">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="step2">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="info-text"> Where can we reach you? </h4>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Houser Number/Building Number</label>
                                                <input type="text" class="form-control" name="houseno"
                                                    placeholder="House name">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Locality/Street name</label>
                                                <input type="text" class="form-control" name="locality"
                                                    placeholder="Locality/Street">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Area</label>
                                                <input type="text" class="form-control" name="area" placeholder="Area">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Pincode</label>
                                                <input type="text" class="form-control" name="pincode"
                                                    placeholder="Pincode">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="city" placeholder="City">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="step3">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="info-text"> Tell us a little bit about yourself </h4>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select class="form-control" name="gender">
                                                    <option value="Male" selected>Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input type="date" min="06/02/2001" name="date" class="form-control"
                                                    placeholder="Locality/Street">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Marital Status</label>
                                                <select class="form-control" name="marital">
                                                    <option value="Single" selected>Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="None">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Occupation</label>
                                                <select class="form-control" name="occuption">
                                                    <option value="None" selected>None</option>
                                                    <option value="Salary">Salary</option>
                                                    <option value="Self Employed">Self Employed</option>
                                                    <option value="Professional">Professional</option>
                                                    <option value="House Wife">House Wife</option>
                                                    <option value="Retired">Retired</option>
                                                    <option value="Student">Student</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="step4">
                                    <h4 class="info-text"> </h4>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="info-text"> Set your Passwords</h4>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input required name="password" id="password" type="password"
                                                        class="form-control" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label>Confirm Password </label>
                                                    <input required name="rpwd" type="password" class="form-control"
                                                        placeholder="Confirm password">
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label>Account Pin</label>
                                                    <input required name="pin" id="pin" type="password"
                                                        class="form-control" placeholder="Account PIN">
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label>Verify Pin Number</label>
                                                    <input required name="cpin" type="password" class="form-control"
                                                        placeholder="Verify Pin">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="wizard-footer height-wizard">
                                <div class="pull-right">
                                    <input type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm'
                                        name='next' value='Next' />
                                    <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd btn-sm'
                                        name='finish' value='Finish' />

                                </div>

                                <div class="pull-left">
                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm'
                                        name='previous' value='Previous' />
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </form>
                    </div>
                </div> <!-- wizard container -->
            </div>
        </div><!-- end row -->
    </div> <!--  big container -->


    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>
    <script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

    <!--  Plugin for the Wizard -->
    <script src="assets/js/gsdk-bootstrap-wizard.js"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
    <script src="assets/js/jquery.validate.min.js"></script>
    <style>
    </style>
    </style>
</body>

</html>