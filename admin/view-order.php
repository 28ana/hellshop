<?php
include_once __DIR__ . "/../middleware/adminMiddleware.php";
include_once __DIR__ . "/../functions/userfunctions.php";
include "includes/header.php";

if (isset($_GET['t'])) {
    $trackingNo = $_GET['t'];
    $orderData = adminCheckTrackingNoValid($trackingNo);
    $data = $orderData->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
?>
        <h4>Nešto nije u redu.</h4>
    <?php
        die();
    }
} else { ?>
    <h4>Nešto je krenulo po zlu.</h4>
<?php
    die();
}
?>

<div class="py-2">
    <div class="container">
        <div class="card card-body shadow">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <span class="text-dark text-bold fs-4">Vidi porudžbinu</span>
                            <a href="orders.php" class="btn btn-primary float-end">Nazad</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Detalji o isporuci</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold" for="name">Ime</label>
                                            <div class="border p-1">
                                                <?= $data['imePrezime']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold" for="email">Email</label>
                                            <div class="border p-1">
                                                <?= $data['email']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold" for="phone">Telefon</label>
                                            <div class="border p-1">
                                                <?= $data['telefon']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold" for="trackingNo">Tracking no</label>
                                            <div class="border p-1">
                                                <?= $data['trackingNo']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold" for="address">Adresa</label>
                                            <div class="border p-1">
                                                <?= $data['adresa']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <label class="fw-bold" for="pincode">Poštanski broj</label>
                                            <div class="border p-1">
                                                <?= $data['pincode']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4>Detalji porudžbine</h4>
                                    <hr>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Proizvod</th>
                                                <th>Cena</th>
                                                <th>Količina</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $order_query = "SELECT o.id as oid, o.trackingNo, o.userId, oi.*, oi.oiKolicina as ordersqty, p.* FROM orders o, order_items oi, products p 
                                            WHERE oi.orderId=o.id AND p.id=oi.prodId AND o.trackingNo=:trackingNo ";
                                            $stmt_items=$conn->prepare($order_query);
                                            $stmt_items->bindParam(":trackingNo", $trackingNo);
                                            if ($item = $stmt_items->fetch(PDO::FETCH_ASSOC)) {
                                                //foreach ($order_query_run as $item) {
                                            ?>
                                                    <tr>
                                                        <td class="align-middle">
                                                            <img src="../uploads/<?= $item['image']; ?>" alt="" width="50px" height="50px">
                                                        </td>
                                                        <td class="align-middle">
                                                            <?= $item['cena']; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?= $item['oiKolicina']; ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                //}
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h5>Total Price: <span class="float-end fw-bold"><?= $data['totalPrice']; ?></span></h5>
                                    <hr>
                                    <label class="fw-bold">Payment Mode</label>
                                    <div class="border p-1">
                                        <?= $data['payMode']; ?>
                                    </div>
                                    <label class="fw-bold">Status</label>
                                    <div class="mb-3">
                                        <form action="code.php" method="POST">
                                            <input type="hidden" name="trackingNo" class="tracking_no" value="<?= $data['trackingNo'] ?>">
                                            <select name="status" class="form-select">
                                                <option value="0" <?= $data['status'] == 0 ? "selected" : "" ?>>U procesu</option>
                                                <option value="1" <?= $data['status'] == 1 ? "selected" : "" ?>>Kompletirano</option>
                                                <option value="2" <?= $data['status'] == 2 ? "selected" : "" ?>>Otkazano</option>
                                            </select>
                                            <button type="submit" name="update_order_btn" class=" btn btn-primary mt-2">Ažuriraj status</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>