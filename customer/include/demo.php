<?php
require_once "DB.php";
//require_once "function.php";
require_once "session.php";
    global $con;
$token = bin2hex(random_bytes(15));
$sql = "Update customers_master SET token='$token' WHERE c_id='4'";
$stmt = $con->query($sql);
$rcount = $stmt->rowCount();
if ($rcount){
    echo "rc update";
}else{
    echo "rc not update";
}