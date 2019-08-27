<?php
    $dsn = "mysql:host=localhost;dbname=ecommerce";
    $user = "root";
    $password = "MidoLove123";
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    );

    try {
        $con = new PDO($dsn,$user,$password,$options);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        echo "<div class='alert-success text-center'>Connected to Database successfully</div>";
    }
    catch (PDOException $e) {
        echo "<div class='alert-danger text-center'>Failed to Connect to Database Error: " . $e->getMessage() . " </div>";
    }