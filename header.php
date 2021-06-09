<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
 <!-- css -->
  	<link href="css/bank2.css" rel="stylesheet">
    
<!-- font awsome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ==" crossorigin="anonymous" />
  <!-- gogglefont -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet">
<!-- Bootstrap CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<!--  -->
    <title>Online Banking</title>
  </head>
  <body>



  <nav class="navbar navbar-expand-lg navbar-dark bg-dark   fixed-top  custom_nav">
        <div class="container">
          <a class="navbar-brand" href="index.php">Online Banking</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbardemo" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="navbardemo">
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ACCOUNTS
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="saving.php">Saving Accounts</a></li>
  
                    <li><a class="dropdown-item" href="current.php">Current Account</a></li>
                    <li><a class="dropdown-item" href="fixed.php">Fixed Accounts</a></li>
                  </ul>
                </li>
          
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                CARDS
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="debit.php">Debit Card</a></li>
                <li><a class="dropdown-item" href="credit.php">Credit Card</a></li>
                <li><a class="dropdown-item" href="fastag.php">FasTag/Forex Card</a></li>
              </ul>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                LOANS
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="home.php">Home Loan</a></li>
                <li><a class="dropdown-item" href="car.php">Car Loan</a></li>
                <li><a class="dropdown-item" href="personal.php">Personal Loan</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                INVESTMENT
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="mutual.php">Mutual Fund</a></li>
                <li><a class="dropdown-item" href="asba.php">Online Banking ASBA Facility</a></li>
                <li><a class="dropdown-item" href="tax.php">Tax Saving Option</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                INSURANCE
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="life.php">Life Insurance</a></li>
                <li><a class="dropdown-item" href="health.php">Health Insurance</a></li>
                <li><a class="dropdown-item" href="pm.php">Pradhan Mantri Jeevan Jyoti Bima Yojana</a></li>
              </ul>
            </li>
            <li class="nav-item">
                <li class="nav-item"><a class="nav-link" href="feedback.php">Feedback</a></li>
            </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  LOGINS 
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="customer/login.php">Customer Login</a></li>
                    <li><a class="dropdown-item" href="admin/login.php">Admin Login</a></li>
                    <li><a class="dropdown-item" href="staff_login/login.php">Staff Login</a></li>
                </ul>
              </li>
        </ul> 
          </div>
        </div>
      </nav> 