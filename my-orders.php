<?php
include "includes/header.php";
include "functions/userfunctions.php";
include "functions/authcode.php";

?>
<div class="py-3 bg-secondary">
    <div class="container">
        <h6 class="text-white fs-4">
            <a href="index.php" class="text-white text-decoration-none">Početna /</a>
            Moje porudžbine /
        </h6>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="card card-body shadow mt-3 mb-5">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped fs-5">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Broj za praćenje</th>
                                <th>Cena</th>
                                <th>Datum</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $orders = getOrders();
                            $orderList = $orders->fetchAll(PDO::FETCH_ASSOC);
                            if (!empty($orderList)) {
                                
                                foreach ($orderList as $item) {
                            ?>
                                    <tr>
                                        <td><?= $item['id']; ?></td>
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
                                    <td colspan="5">Nemate porudzbina jos uvek!</td>
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
<?php include "includes/footer.php"; ?>