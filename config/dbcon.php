<?php
    // if (!defined('SERVER')) {
    // define('SERVER', 'localhost');
    // }

    // if (!defined('USERNAME')) {
    //     define('USERNAME', 'root');
    // }

    // if (!defined('PASSWORD')) {
    //     define('PASSWORD', '');
    // }

    // if (!defined('DATABASE')) {
    //     define('DATABASE', 'bike_shop');
    // }
    // try {
    //     $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);

    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // }
    // catch(PDOException $ex){
    //     die("PDO GREŠKA: " . $ex->getMessage());
    // }

$host = getenv('MYSQLHOST');
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT');

try {
    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Greška pri povezivanju: " . $e->getMessage());
} 
?>