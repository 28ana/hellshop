<?php
include "includes/header.php";
include "functions/userfunctions.php";
include "functions/authcode.php";
?>

<div class="py-3 bg-secondary">
    <div class="container">
        <h6 class="text-white fs-4">
            <a href="home.php" class="text-white text-decoration-none fs-4">Početna /</a>
            Korpa
        </h6>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="card card-body shadow mt-3">
            <div id="mycart">
                <?php
                $items = getCartItems();

                if (mysqli_num_rows($items) > 0) { 
                ?>
                    <div class="row align-items-center d-none d-md-flex mb-2">
                        <div class="col-md-5"><h4 class="fw-bold">Proizvod</h4></div>
                        <div class="col-md-2 text-center"><h4 class="fw-bold">Cena</h4></div>
                        <div class="col-md-3 text-center"><h4 class="fw-bold">Količina</h4></div>
                        <div class="col-md-2 text-center"><h4 class="fw-bold">Akcija</h4></div>
                    </div>

                    <?php
                    $totalPrice = 0;
                    foreach ($items as $citem) {
                        $subPrice = $citem['prodajnaCena'] * $citem['prodQty'];
                        $totalPrice += $subPrice;
                    ?>
                        <div class="card product_data shadow-sm mb-3">
                            <div class="row align-items-center p-2">
                                <div class="col-md-2 text-center">
                                    <img src="uploads/<?= $citem['image']; ?>" alt="<?= $citem['ime']; ?>" class="w-50">
                                </div>
                                <div class="col-md-3">
                                    <h5><?= $citem['ime']; ?></h5>
                                </div>
                                <div class="col-md-2 text-center">
                                    <h5><?= number_format($citem['prodajnaCena'], 2); ?> RSD</h5>
                                </div>
                                <div class="col-md-3 text-center">
                                    <input type="hidden" class="prodId" value="<?= $citem['prodId']; ?>">
                                    <div class="input-group mb-3 mx-auto" style="width: 110px;">
                                        <button class="input-group-text decrement-btn updateQty">-</button>
                                        <input type="text" class="form-control text-center input-qty bg-white" value="<?= $citem['prodQty']; ?>" disabled>
                                        <button class="input-group-text increment-btn updateQty">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <button class="btn btn-danger btn-sm deleteItem" value="<?= $citem['cid']; ?>">
                                        <i class="fa fa-trash"></i> Ukloni
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php 
                    }
                    ?>

                    <hr>
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4 text-end">
                            <h5>Ukupno: <span class="fw-bold fs-3"><?= number_format($totalPrice, 2) ?> RSD</span></h5>
                            <a href="checkout.php" class="btn btn-primary w-100 mt-2">Nastavi na plaćanje</a>
                        </div>
                    </div>

                <?php
                } else {
                ?>
                    <div class="card card-body text-center shadow">
                        <h4 class="py-3">Vaša korpa je prazna</h4>
                        <a href="index.php" class="btn btn-outline-primary mx-auto">Kreni u kupovinu</a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>


<?php include "includes/footer.php"; ?>