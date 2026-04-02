<?php
session_start();
include(__DIR__ . '/../config/dbcon.php'); 
header('Content-Type: text/plain');

if (isset($_SESSION['auth'])) {
    if (isset($_POST['scope'])) {

        $scope = $_POST['scope'];
        $user_id = $_SESSION['auth_user']['user_id'];

        switch ($scope) {

            case "add":
                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];
                $user_id = $_SESSION['auth_user']['user_id'];

                // Provera da li već postoji
                $stmt = $conn->prepare("SELECT * FROM carts WHERE prodId = :prodId AND userId = :userId");
                $stmt->execute([':prodId' => $prod_id, ':userId' => $user_id]);

                if (ob_get_length()) ob_clean(); // Čišćenje bafera pre bilo kakvog echo-a

                if ($stmt->rowCount() > 0) {
                    echo "existing";
                } else {
                    $insert = $conn->prepare("INSERT INTO carts (userId, prodId, prodQty) VALUES (:userId, :prodId, :qty)");
                    $result = $insert->execute([
                        ':userId' => $user_id,
                        ':prodId' => $prod_id,
                        ':qty' => $prod_qty
                    ]);

                    echo $result ? "200" : "500";
                }
                exit;
                break;
            case "update":
                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];

                $update = $conn->prepare("UPDATE carts SET prodQty = :qty WHERE prodId = :prodId AND userId = :userId");
                $update->bindParam(':qty', $prod_qty, PDO::PARAM_INT);
                $update->bindParam(':prodId', $prod_id, PDO::PARAM_INT);
                $update->bindParam(':userId', $user_id, PDO::PARAM_INT);

                echo $update->execute() ? "200" : "500";
                exit;
                break;

            case "delete":
                $cart_id = $_POST['cart_id'];

                $delete = $conn->prepare("DELETE FROM carts WHERE id = :id AND userId = :userId");
                $delete->bindParam(':id', $cart_id, PDO::PARAM_INT);
                $delete->bindParam(':userId', $user_id, PDO::PARAM_INT);

                if($delete->execute()) {
                    ob_clean(); 
                    echo "200";
                } else {
                    echo "500";
                }
                exit;
            }
    }
} else {
    echo "401";
    exit;
}
?>