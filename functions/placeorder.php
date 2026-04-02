<?php
session_start();
include "../config/dbcon.php";

if (isset($_SESSION['auth']) && $_SESSION['auth'] == true) 
{
    if (isset($_POST['placeOrderBtn'])) 
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $pincode = $_POST['pincode'];
        $address = $_POST['address'];
        $payment_mode = $_POST['payment_mode'];
        $payment_id = $_POST['payment_id'] ?? "";
        
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
                       WHERE c.prodId=p.id AND c.userId=:userId";
        $cart = $conn->prepare($cart_query);
        $cart->bindParam(':userId', $userId, PDO::PARAM_INT);
        $cart->execute();

        $totalPrice = 0;
        $cartItems = [];

        while($row = $cart->fetch(PDO::FETCH_ASSOC))
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
                         VALUES (:userId, :tracking_no, :name, :email, :phone, :address, :pincode, :totalPrice, :payment_mode, :payment_id)";
        
        $stmt = $conn->prepare($insert_query);

        if ($stmt->execute([
            ':userId' => $userId,
            ':tracking_no' => $tracking_no,
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':pincode' => $pincode,
            ':totalPrice' => $totalPrice,
            ':payment_mode' => $payment_mode,
            ':payment_id' => $payment_id
        ])) 
        {
            $orderId = $conn->lastInsertId();

            foreach ($cartItems as $citem) 
            {
                $prodId = $citem['prodId'];
                $qty = $citem['prodQty'];
                $price = $citem['prodajnaCena'];

                // Upis stavki u order_items
                $insert_items_query = "INSERT INTO order_items (orderId, prodId, oiKolicina, cena) 
                                       VALUES (:orderId, :prodId, :qty, :price)";
                $stmtItem = $conn->prepare($insert_items_query);
                $stmtItem->execute([
                    ':orderId' => $orderId,
                    ':prodId' => $prodId,
                    ':qty' => $qty,
                    ':price' => $price
                ]);

                // Azuriranje lagera (smanjujemo kolicinu u products)
                $updateQty_query = "UPDATE products SET kolicina = kolicina - :qty WHERE id=:prodId";
                $stmtUpdate=$conn->prepare($updateQty_query);
                $stmtUpdate->execute([
                ':qty' => $qty,
                ':prodId' => $prodId
                ]);
            }

            // BRISANJE KORPE NAKON USPESNE KUPOVINE
            $deleteCartQuery = "DELETE FROM carts WHERE userId=:userId";
            $delete_cart = $conn->prepare($deleteCartQuery);
            $delete_cart->execute([':userId' => $userId]);

            $_SESSION['message'] = "Narudžbina je uspešno kreirana!";
            header('Location: ../my-orders.php');
            exit();
        }
        else 
        {
            $error = $stmt->errorInfo();
            $_SESSION['message'] = "Greška pri upisu narudžbine: " . $error[2];
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