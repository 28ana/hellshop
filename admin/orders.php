<?php
include_once __DIR__ . "/../middleware/adminMiddleware.php";
include_once __DIR__ . "/../functions/userfunctions.php";
include "includes/header.php";
?>

<div class="py-5">
    <div class="container">
        <div class="card card-body shadow">
            <div class="row">
                <div class="card-header bg-primary">
                    <h4>Porudžbine</h4>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Korisnik</th>
                                    <th>Tracking number</th>
                                    <th>Iznos</th>
                                    <th>Datum</th>
                                    <th>Vidi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $orders = getAllOrders();
                                $orderList = $orders->fetchAll(PDO::FETCH_ASSOC);
                                if (!empty($orderList)) {
                                    foreach ($orderList as $item) {
                                ?>
                                        <tr>
                                            <td><?= $item['id']; ?></td>
                                            <td><?= $item['userId']; ?></td>
                                            <td><?= $item['trackingNo']; ?></td>
                                            <td><?= $item['totalPrice']; ?></td>
                                            <td><?= $item['created_at']; ?></td>
                                            <td><a href="view-order.php?t=<?= $item['trackingNo']; ?>" class="btn btn-primary">Vidi detalje</a></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5">Još nema porudžbina.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>