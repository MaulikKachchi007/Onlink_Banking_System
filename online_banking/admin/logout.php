<?php
require_once ('include/DB.php');
require_once ('include/session.php');
require_once ('include/function.php');
    session_start();
    session_unset();
    session_destroy();
    redirect('login.php');