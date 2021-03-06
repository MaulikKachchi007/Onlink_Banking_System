<?php

use PHPMailer\PHPMailer\PHPMailer;

// include "./../vendor/PHPMailer/PHPMailer";

$mail = new PHPMailer();


$mail->IsSMTP();
$mail->CharSet = 'UTF-8';

$mail->Host       = "ssl://smtp.gmail.com";
$mail->SMTPDebug  = 0;
$mail->SMTPAuth   = true;
$mail->Port       = 465;
$mail->Username   = "khenirutvik2002@gmail.com";
$mail->Password   = "Ruttvik@2002";
