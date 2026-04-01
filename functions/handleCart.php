<?php
session_start();
include(__DIR__ . '/../config/dbcon.php'); 

if (isset($_SESSION['auth'])) {
    if (isset($_POST['scope'])) {
        $scope = $_POST['scope'];
        $user_id = $_SESSION['auth_user']['user_id'];

        switch ($scope) {
            case "add":
                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];

                $chk_existing_cart = "SELECT * FROM carts WHERE prodId='$prod_id' AND userId='$user_id'";
                $chk_existing_cart_run = mysqli_query($conn, $chk_existing_cart);

                if (mysqli_num_rows($chk_existing_cart_run) > 0) {
                    echo "existing";
                } else {
                    $insert_query = "INSERT INTO carts (userId, prodId, prodQty) VALUES ('$user_id','$prod_id','$prod_qty')";
                    $insert_query_run = mysqli_query($conn, $insert_query);

                    if ($insert_query_run) { echo 201; } else { echo 500; }
                }
                break;

            case "update":
                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];

                $update_query = "UPDATE carts SET prodQty='$prod_qty' WHERE prodId='$prod_id' AND userId='$user_id'";
                $update_query_run = mysqli_query($conn, $update_query);
                
                if ($update_query_run) { echo 200; } else { echo 500; }
                break;

            case "delete":
                $cart_id = $_POST['cart_id'];
                $delete_query = "DELETE FROM carts WHERE id='$cart_id' AND userId='$user_id'";
                $delete_query_run = mysqli_query($conn, $delete_query);
                
                if ($delete_query_run) { echo 200; } else { echo 500; }
                break;

            default:
                echo 500;
        }
    }
} else {
    echo 401; // nije ulogovan
}