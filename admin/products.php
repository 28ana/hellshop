<?php
include_once __DIR__ . "/middleware/adminMiddleWare.php";
include_once __DIR__ . "/functions/userfunctions.php";
include_once "includes/header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4>Proizvodi</h4>
                </div>
                <div class="card-body" id="products_table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ime</th>
                                    <th>Slika</th>
                                    <th>Status</th>
                                    <th>Akcija</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $products = getAll("products");
                                if (!empty($products)) {
                                    foreach ($products as $item) { ?>
                                        <tr>
                                            <td><?= $item['id']; ?></td>
                                            <td><?= $item['ime']; ?></td>
                                            <td>
                                                <img src="../uploads/<?= $item['image']; ?>" width="50px" height="50px" alt="<?= $item['ime']; ?>">
                                            </td>
                                            <td><?= ($item['status'] == 0) ? "Visible" : "Hidden" ?></td>
                                            <td>
                                                <a href="edit-product.php?id=<?= $item['id']; ?>" class="btn btn-primary">Izmeni</a>
                                                <form action="code.php" method="POST">
                                                <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                                <button type="submit" name="delete_product_btn" class="btn btn-danger">Izbriši</button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php  }
                                } else {
                                    echo "Proizvod nije pronadjen.";
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