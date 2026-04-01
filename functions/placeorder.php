<?php
session_start();
include "../config/dbcon.php";

if (isset($_SESSION['auth']) && $_SESSION['auth'] == true) 
{
    if (isset($_POST['placeOrderBtn'])) 
    {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $payment_mode = mysqli_real_escape_string($conn, $_POST['payment_mode']);
        $payment_id = mysqli_real_escape_string($conn, $_POST['payment_id'] ?? "");

        if (empty($name) || empty($email) || empty($phone) || empty($pincode) || empty($address)) {
            $_SESSION['message'] = "Sva polja su obavezna!";
            header('Location: ../checkout.php');
            exit(0);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "Neispravan format email adrese!";
            header('Location: ../checkout.php');
            exit(0);
        }

        $userId = $_SESSION['auth_user']['user_id'];

        // DOHVATANJE STAVKI IZ KORPE I PROVERA LAGERA
        $cart_query = "SELECT c.prodQty, c.prodId, p.ime, p.prodajnaCena, p.kolicina as lager 
                       FROM carts c, products p 
                       WHERE c.prodId=p.id AND c.userId='$userId'";
        $cart_query_run = mysqli_query($conn, $cart_query);

        $totalPrice = 0;
        $cartItems = [];

        while($row = mysqli_fetch_assoc($cart_query_run)) 
        {
            // Provera da li ima dovoljno na stanju
            if($row['prodQty'] > $row['lager']) {
                $_SESSION['message'] = "Nažalost, proizvod '" . $row['ime'] . "' trenutno nema dovoljno na stanju (Dostupno: " . $row['lager'] . ").";
                header('Location: ../cart.php');
                exit(0);
            }
            
            $cartItems[] = $row;
            $totalPrice += $row['prodajnaCena'] * $row['prodQty'];
        }

        if(count($cartItems) == 0) {
            $_SESSION['message'] = "Vaša korpa je prazna!";
            header('Location: ../index.php');
            exit(0);
        }

        // GENERISANJE TRACKING BROJA I UPIS NARUDZBINE
        $tracking_no = "anacode" . rand(1111, 9999) . substr($phone, -4);

        $insert_query = "INSERT INTO orders (userId, trackingNo, imePrezime, email, telefon, adresa, pincode, totalPrice, payMode, payId) 
                         VALUES ('$userId', '$tracking_no', '$name', '$email', '$phone', '$address', '$pincode', '$totalPrice', '$payment_mode', '$payment_id')";
        
        $insert_query_run = mysqli_query($conn, $insert_query);

        if ($insert_query_run) 
        {
            $orderId = mysqli_insert_id($conn);

            foreach ($cartItems as $citem) 
            {
                $prodId = $citem['prodId'];
                $qty = $citem['prodQty'];
                $price = $citem['prodajnaCena'];

                // Upis stavki u order_items
                $insert_items_query = "INSERT INTO order_items (orderId, prodId, oiKolicina, cena) 
                                       VALUES ('$orderId', '$prodId', '$qty', '$price')";
                mysqli_query($conn, $insert_items_query);

                // Azuriranje lagera (smanjujemo kolicinu u products)
                $updateQty_query = "UPDATE products SET kolicina = kolicina - '$qty' WHERE id='$prodId'";
                mysqli_query($conn, $updateQty_query);
            }

            // BRISANJE KORPE NAKON USPESNE KUPOVINE
            $deleteCartQuery = "DELETE FROM carts WHERE userId='$userId'";
            mysqli_query($conn, $deleteCartQuery);

            $_SESSION['message'] = "Narudžbina je uspešno kreirana!";
            header('Location: ../my-orders.php');
            exit();
        }
        else 
        {
            $_SESSION['message'] = "Greška pri upisu narudžbine: " . mysqli_error($conn);
            header('Location: ../checkout.php');
            exit();
        }
    }
} 
else 
{
    header('Location: ../index.php');
    exit();
}
?>