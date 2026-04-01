<?php
include "includes/header.php";
include "functions/userfunctions.php";
include "functions/authcode.php";

?>
<div class="py-3 bg-secondary">
    <div class="container">
        <h4 class="text-white">
            <a href="index.php" class="text-white text-decoration-none">Početna /</a>
            <a href="checkout.php" class="text-white text-decoration-none">Poruči</a>
        </h4>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="card">
            <div class="card card-body shadow mt-3">
                <form action="functions/placeorder.php" method="POST" novalidate>
                    <div class="row">
                        <div class="col-md-7">
                            <h5>Osnovni podaci</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold fs-5">Ime i prezime</label>
                                    <input type="text" name="name" required placeholder="Unesite ime" class="form-control form-control-lg">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold fs-5">Email</label>
                                    <input type="email" name="email" required placeholder="Unesite email" class="form-control form-control-lg">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold fs-5">Telefon</label>
                                    <input type="text" name="phone" required placeholder="Unesite broj telefona" class="form-control form-control-lg">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold fs-5">Poštanski broj</label>
                                    <input type="text" name="pincode" required placeholder="Unesite poštanski broj" class="form-control form-control-lg">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="fw-bold fs-5">Adresa</label>
                                    <textarea name="address" class="form-control form-control-lg" rows="5" style="resize: none;"  required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h5>Detalji porudžbine</h5>
                            <hr>
                            <?php

                            $items = getCartItems();
                            $totalPrice = 0;
                            foreach ($items as $citem) {
                            ?>
                                <div class="card product_data shadow-sm mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <img src="uploads/<?= $citem['image']; ?>" alt="" width="60px">
                                        </div>
                                        <div class="col-md-5">
                                            <label><?= $citem['ime']; ?></label>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label>x<?= $citem['prodajnaCena']; ?></label>
                                        </div>

                                    </div>
                                </div>
                            <?php
                                $totalPrice += $citem['prodajnaCena'] * $citem['prodQty'];
                            }
                            ?>
                            <h4>Ukupna cena : <span class="float-end fw-bold"><?= $totalPrice ?></span></h4>
                            <div>
                                <input type="hidden" name="payment_mode" value="COD">
                                <button type="submit" name="placeOrderBtn" class="btn btn-primary w-100">Potvrdi i poruči</button>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
</div>
<?php include "includes/footer.php"; ?>