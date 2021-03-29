<?php
    include_once "include/DB.php";
    include_once "include/session.php";
    include_once "include/function.php";
    session_start();
    session_unset();
    session_destroy();
    redirect('login.php ');    

?>