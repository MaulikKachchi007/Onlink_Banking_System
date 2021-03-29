<?php
require_once "DB.php";
require_once "session.php";
#redirect
function redirect($new_location){
    header('Location:'. $new_location);
    exit();
}
# Check User Exits or not
function checkUserExists($logid){
    global $con;
    $sql = "SELECT * FROM employees_master WHERE loginid=:logid";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':logid',$logid);
    $stmt->execute();
    $row_count = $stmt->rowcount();
    if ($row_count == 1){
        return true;
    }else{
        return false;
    }
}
#login attempt
function login_attempt($logid,$password){
    global $con;
    $sql = "SELECT * from employees_master WHERE loginid=:logid AND pwd=:passWord LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':logid',$logid);
    $stmt->bindValue(':passWord',$password);
    $stmt->execute();
    $result = $stmt->rowcount();
    if ($result==1){
        return $found_account=$stmt->fetch();
    }else{
        return null;
    }
}
#confirm Login
function confirm_login() {
    if (isset($_SESSION['id'])) {
        return true;
    }
    else {
        $_SESSION['error_message'] = "Login Required !";
        redirect('login.php');
    }
}
function getsid($id){
    return $id;
}