<?php 
    // initialising server variables
    $dbServer = "localhost";
    $dbUsername = "root";
    $dbPassword = "";

    $con = mysqli_connect($dbServer, $dbUsername, $dbPassword, 'stockflowFINALYEARPROJECT_db');

    if (!$con) {
        die("Couldn't connect to database: " . mysqli_connect_error());
    }
?>