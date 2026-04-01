<?php
include "includes/header.php";
include "functions/userfunctions.php";

if (isset($_GET['t'])) 
{
    $trackingNo = mysqli_real_escape_string($conn, $_GET['t']);
    
    $orderData = checkTrackingNoValid($trackingNo);

    if (mysqli_num_rows($orderData) == 0) 
    {
        ?>
        <div class="container py-5"><h4>Narudžbina nije pronađena.</h4></div>
        <?php
        die();
    }
} 
else 
{ 
    ?>
    <div class="container py-5"><h4>Neispravan link.</h4></div>
    <?php
    die();
}

$data = mysqli_fetch_array($orderData);
?>

<div class="py-3 bg-secondary">
    <div class="container">
        <h4 class="text-white">
            <a href="index.php" class="text-white text-decoration-none">Početna /</a>
            <a href="my-orders.php" class="text-white text-decoration-none">Moje narudžbine /</a>
            <span class="text-white">Pregled narudžbine</span>
        </h4>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary">
                <span class="text-white fs-4">Detalji narudžbine</span>
                <a href="my-orders.php" class="btn btn-warning float-end">
                    <i class="fa fa-reply me-2"></i>Nazad
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Podaci o dostavi</h3>
                        <hr>
                        <div class="row fs-5">
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Ime i prezime</label>
                                <div class="border p-2"><?= $data['imePrezime']; ?></div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Email</label>
                                <div class="border p-2"><?= $data['email']; ?></div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Telefon</label>
                                <div class="border p-2"><?= $data['telefon']; ?></div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Broj za praćenje</label>
                                <div class="border p-2"><?= $data['trackingNo']; ?></div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Adresa</label>
                                <div class="border p-2"><?= $data['adresa']; ?></div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Poštanski broj</label>
                                <div class="border p-2"><?= $data['pincode']; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h3>Stavke narudžbine</h3>
                        <hr>
                        <table class="table table-bordered fs-5">
                            <thead>
                                <tr>
                                    <th>Proizvod</th>
                                    <th>Cena</th>
                                    <th>Količina</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $userId = $_SESSION['auth_user']['user_id'];
                                $orderId = $data['id'];

                                $order_items_query = "SELECT oi.*, p.ime, p.image FROM order_items oi, products p 
                                                      WHERE oi.orderId='$orderId' AND p.id=oi.prodId";
                                $order_items_run = mysqli_query($conn, $order_items_query);

                                if (mysqli_num_rows($order_items_run) > 0) 
                                {
                                    foreach ($order_items_run as $item) 
                                    {
                                        ?>
                                        <tr>
                                            <td class="align-middle">
                                                <img src="uploads/<?= $item['image']; ?>" alt="<?= $item['ime']; ?>" width="50px">
                                                <?= $item['ime']; ?>
                                            </td>
                                            <td class="align-middle"><?= $item['cena']; ?> RSD</td>
                                            <td class="align-middle"><?= $item['oiKolicina']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <hr>
                        <h5>Ukupno za uplatu: <span class="float-end fw-bold"><?= $data['totalPrice']; ?> RSD</span></h5>
                        <hr>
                        <label class="fw-bold fs-5">Način plaćanja:</label>
                        <div class="border p-2 mb-2 fs-5"><?= $data['payMode']; ?></div>

                        <label class="fw-bold fs-5">Status narudžbine:</label>
                        <div class="border p-2 fs-5">
                            <?php
                            if ($data['status'] == 0) { echo "U procesu"; }
                            elseif ($data['status'] == 1) { echo "Završeno"; }
                            elseif ($data['status'] == 2) { echo "Otkazano"; }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>