<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
if (isset($_POST["add_feedback"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mno = $_POST["mno"];
    $message = $_POST["message"];
    if (empty($name) || empty($email) || empty($email) || empty($mno) || empty($message)) {
        $_SESSION["error_message"] = "All must fill required.";
    } else {
        global $con;
        $sql = "INSERT INTO feedback (name,email,mno,message) VALUES (:name,:email,:mno,:message)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':name',$name);
        $stmt->bindValue(':email',$email);
        $stmt->bindValue(':mno',$mno);
        $stmt->bindValue(':message',$message);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = 'Feedback Sent Successfully';
            redirect('feedback.php');
        }else{
            $_SESSION['error_message']  = 'Something Things Wrong. Try again later.';
            redirect('feedback.php');
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
 <!-- css -->
  	<!-- <link href="css/bank1.css" rel="stylesheet"> -->
    <link href="css/rg.css" rel="stylesheet">

<!-- font awsome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ==" crossorigin="anonymous" />
  <!-- gogglefont -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet">
<!-- Bootstrap4 CSS  -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <title>Online Banking</title>
    
  
  </head>
  
 
 <body>
 
 <?php include "header.php"?>
 
 
 <div id="relted-product-1" class="background">
   <div class="container my-5" id="relted-product">    
  <section id="form-section">
      <h1 class="h1-tag">Your feedback is important for us</h1><br>
      <?php
        echo ErrorMessage();
        echo SuccessMessage();
      ?>
      <form class="form-content-section" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
      <div class="mb-3">
    <label for="exampleInputText" class="form-label text-danger" >Name</label>
    <input type="text" class="form-control" name="name" required id="exampleInputText" placeholder="Enter your name">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label text-danger">Email address</label>
    <input type="email" class="form-control"  name="email" required id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Enter Email Address">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputText" class="form-label text-danger">Contect number</label>
    <input type="text" class="form-control" name="mno" required id="exampleInputtext" placeholder="Enter Contect Number">
  </div>
  <div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label text-danger">Message</label>
  <textarea class="form-control" name="message" required id="exampleFormControlTextarea1" rows="3" placeholder="Enter Message"></textarea>
</div>
  <center><button type="submit" name="add_feedback" class="btn btn-danger">Submit</button></center>
</form>

      
  </section>
  </div>  
</div>
 











   <?php include "footer.php"?>          
                          

  </body>
</html>