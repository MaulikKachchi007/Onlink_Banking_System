    <?php

    require('./../config/db.config.php');

    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $phonenumber = $_POST['phonenumber'];
    $DOB = $_POST['DOB'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $adharnumber = $_POST['adharnumber'];
    $accounttype = $_POST['accounttype'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $ZIP = $_POST['ZIP'];



    $tempName = $_FILES['adharimg']['tmp_name'];
    $fileLocation = "adharimg_" . time() . "_" . $_FILES['adharimg']['size'] . "_" . $_FILES['adharimg']["name"];
    $imgPath = "http://localhost/Rutvik/Core-php/UserPanel-PHP/public/user_image/" . $fileLocation;
    $uploadImgPath = "./../public/user_image/" . $fileLocation;

    $query = "INSERT INTO user_info (first_name,middle_name,last_name,phone_number,DOB,gender,usermail,adhar_number,adhar_img,account_type, address, city, state,country, zip) VALUES ('$firstname','$middlename','$lastname','$phonenumber','$DOB','$gender','$email','$adharnumber','$imgPath','$accounttype','$address','$city','$state','$country','$ZIP')";
    if (move_uploaded_file($tempName, $uploadImgPath) && $con->exec($query)) {



        echo "login";
    } else {
        echo "somthing Wrong";
    }
