<?php
include(__DIR__ . '/../config/dbcon.php'); 


function getAll($table)
{
    global $conn;
    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}

function getById($table, $id)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}

function getAllOrders()
{
    global $conn;
    $query = "SELECT * FROM orders WHERE status='0' ";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}

function adminCheckTrackingNoValid($trackingNo)
{
    global $conn;
    $query = "SELECT * FROM orders WHERE trackingNo='$trackingNo' "; 
    return mysqli_query($conn, $query);
}
