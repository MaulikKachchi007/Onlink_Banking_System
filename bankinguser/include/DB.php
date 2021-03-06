<?php
    $dsn = "mysql:host=localhost;dbname=online_Banking";
    $username = "root";
    $password = "";
        $con = new PDO($dsn, $username,$password) or die("Couldn't connect to database'");
