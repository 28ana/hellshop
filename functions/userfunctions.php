<?php
include(__DIR__ . '/../config/dbcon.php'); 

function getAllActive($table)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE STATUS='0'";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}
function getAllTrending()
{
    global $conn;
    $query = "SELECT * FROM products WHERE trending='1'";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}
function getProByCategory($categoryId)
{
    global $conn;
    $query = "SELECT * FROM products  WHERE categoryId='$categoryId' AND status='0'";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}
function getIDActive($table, $id)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE id='$id' AND status='0'";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}
function getSlugActive($table, $slug)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE opis='$slug' AND status='0' LIMIT 1";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}
function getCartItems()
{
    global $conn;

    $user_id = $_SESSION['auth_user']['user_id'];

    $query = "SELECT c.id as cid, c.prodId, c.prodQty, 
                         p.id as pid, p.ime as ime, p.image, p.prodajnaCena as prodajnaCena 
                  FROM carts c
                  INNER JOIN products p ON c.prodId = p.id 
                  WHERE c.userId = '$user_id'";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}

function getWishItems()
{
    global $conn;
    $userId = $_SESSION['auth_user']['user_id'];

    $query = "SELECT w.id as wid, p.* FROM wishlist w, products p WHERE w.prodId=p.id AND w.userId='$userId'";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}
function getOrders()
{
    global $conn;
    $user_id = $_SESSION['auth_user']['user_id'];

    $query = "SELECT * FROM orders WHERE userId='$user_id' ORDER BY id DESC";
    $query_run = mysqli_query($conn, $query);
    return $query_run;
}

function checkTrackingNoValid($trackingNo)
{
    global $conn;
    $userId = $_SESSION['auth_user']['user_id'];

    $query = "SELECT * FROM orders WHERE trackingNo='$trackingNo' AND userId='$userId' ";
    return mysqli_query($conn, $query);
}

function redirect($url, $message)
{
    $_SESSION['message'] = $message;

    header('Location: ' . $url);
    exit();
}

