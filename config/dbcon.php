<!-- <?php
    // $host = "localhost";
    // $user = "root";
    // $pass = "";
    // $database = "bike_shop"; 

    // $conn = new mysqli($host, $user, $pass, $database);
    // if($conn->connect_errno) {
    //     echo ("Neuspesna konekcija: $conn->connect_errno, poruka: $conn->connect_error");
    //     exit();
    // }
?> -->
<?php
$host = getenv('mysql.railway.internal');
$user = getenv('root');
$pass = getenv('grCgOyiEgdtKMFCJLykCJOcWKLtghWfb');
$db   = getenv('railway');
$port = getenv('3306');

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Greška pri povezivanju: " . $conn->connect_error);
}
?>