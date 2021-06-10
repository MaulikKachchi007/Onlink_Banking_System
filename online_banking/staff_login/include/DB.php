<?php
    $dsn = "mysql:host=localhost:3308;dbname=online_Banking";
    $username = "root";
    $password = "";
        $con = new PDO($dsn, $username,$password) or die("Couldn't connect to database'");
