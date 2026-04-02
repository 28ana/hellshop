<?php
include(__DIR__ . '/../config/dbcon.php'); 

function getAllActive($table)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE STATUS='0'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt;
}
function getAllTrending()
{
    global $conn;
    $query = "SELECT * FROM products WHERE trending='1'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt;
}
function getProByCategory($categoryId)
{
    global $conn;
    $query = "SELECT * FROM products  WHERE categoryId=:categoryId AND status='0'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;

}
function getIDActive($table, $id)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE id=:id AND status='0'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}
function getSlugActive($table, $slug)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE opis=:slug AND status='0' LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt;
}
function getCartItems()
{
    global $conn;

    $user_id = $_SESSION['auth_user']['user_id'];

    $query = "SELECT c.id as cid, c.prodId, c.prodQty, 
                         p.id as pid, p.ime as ime, p.image, p.prodajnaCena as prodajnaCena 
                  FROM carts c
                  INNER JOIN products p ON c.prodId = p.id 
                  WHERE c.userId = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}

function getWishItems()
{
    global $conn;
    $userId = $_SESSION['auth_user']['user_id'];

    $query = "SELECT w.id as wid, p.* FROM wishlist w, products p WHERE w.prodId=p.id AND w.userId=:userId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}
function getOrders()
{
    global $conn;
    $user_id = $_SESSION['auth_user']['user_id'];

    $query = "SELECT * FROM orders WHERE userId=:user_id ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}

function checkTrackingNoValid($trackingNo)
{
    global $conn;
    $userId = $_SESSION['auth_user']['user_id'];

    $query = "SELECT * FROM orders WHERE trackingNo=:trackingNo AND userId=:userId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':trackingNo', $trackingNo);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    return $stmt;
}

function redirect($url, $message)
{
    $_SESSION['message'] = $message;
    header('Location: ' . $url);
    exit();
}

function getById($table, $id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM $table WHERE id = :id LIMIT 1");
    $stmt->execute([
        ':id' => $id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
