<?php
include(__DIR__ . '/../config/dbcon.php'); 


function getAll($table)
{
    global $conn;
    $query = "SELECT * FROM $table";
    $stmt = $conn->query($query);
    return $stmt;
}

function getAllOrders()
{
    global $conn;
    $query = "SELECT * FROM orders WHERE status='0' ";
    $stmt = $conn->query($query);
    return $stmt;
}

function adminCheckTrackingNoValid($trackingNo)
{
    global $conn;
    $query = "SELECT * FROM orders WHERE trackingNo=:trackingNo"; 
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':trackingNo', $trackingNo, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt;
}
