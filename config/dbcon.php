<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "bike_shop"; 

    $conn = new mysqli($host, $user, $pass, $database);
    if($conn->connect_errno) {
        echo ("Neuspesna konekcija: $conn->connect_errno, poruka: $conn->connect_error");
        exit();
    }
?>