<?php
session_start();
include(__DIR__ . '/../config/dbcon.php');

if (isset($_SESSION['auth']) == true) {

    if (isset($_POST['scope2'])) {

        $scope2 = $_POST['scope2'];
        $userId = $_SESSION['auth_user']['user_id'];

        switch ($scope2) {

            case "add":
                $prodId = $_POST['prodId'];

                $stmt = $conn->prepare("SELECT * FROM wishlist WHERE prodId = :prodId AND userId = :userId");
                $stmt->bindParam(':prodId', $prodId, PDO::PARAM_INT);
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->execute();

                if (ob_get_length()) ob_clean();
                if ($stmt->rowCount() > 0) {
                    echo "existing";
                } else {
                    $insert = $conn->prepare("INSERT INTO wishlist (userId, prodId) VALUES (:userId, :prodId)");
                    echo $insert->execute([':userId' => $userId, ':prodId' => $prodId]) ? "200" : "500";
                }
                exit; 
                break;

            case "delete":
                if (isset($_POST['id'])) {

                    $wishId = $_POST['id'];

                    $stmt = $conn->prepare("SELECT * FROM wishlist WHERE id = :id AND userId = :userId");
                    $stmt->bindParam(':id', $wishId, PDO::PARAM_INT);
                    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {

                        $delete = $conn->prepare("DELETE FROM wishlist WHERE id = :id AND userId = :userId");
                        $delete->bindParam(':id', $wishId, PDO::PARAM_INT);
                        $delete->bindParam(':userId', $userId, PDO::PARAM_INT);

                        $res = $delete->execute();
                        if (ob_get_length()) ob_clean(); 
                        echo $res ? "200" : "500";
                    } else {
                        echo "Stavka nije pronađena";
                    }

                } else {
                    echo "ID nije poslat";
                }
                exit;
                break;

            default:
                if (ob_get_length()) ob_clean();
                echo "500";
                exit;
        }
    }
} else {
    echo 401;
}
?>