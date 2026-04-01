<?php
include "includes/header.php";
include "functions/myfunctions.php";
include "functions/userfunctions.php";
include "functions/authcode.php";
?>
<div class="py-3 bg-secondary">
    <div class="container">
        <h6 class="text-white fs-4">
            <a href="home.php" class="text-white text-decoration-none fs-4">Početna /</a>
            Lista želja
        </h6>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="card card-body shadow mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div id="mywishlist">
                        <?php
                        
                        $items = getWishItems();
                        if (mysqli_num_rows($items) > 0) { ?>
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <h4>Slika</h4>
                                </div>
                                <div class="col-md-2 text-center">
                                    <h4>Naziv</h4>
                                </div>
                                <div class="col-md-2 text-center">
                                    <h4>Cena</h4>
                                </div>
                                <div class="col-md-2">
                                               
                                </div>
                            </div>
                            <div id="">
                                <?php
                                foreach ($items as $witem) {
                                ?>
                                    <div class="card product_data shadow-sm mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-2 text-center">
                                                <img src="uploads/<?= $witem['image']; ?>" alt="" class="w-50">
                                            </div>
                                            <div class="col-md-2">
                                                <h5><?= $witem['ime']; ?></h5>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <h3> <?= $witem['prodajnaCena']; ?></h3>
                                            </div>
                                            <div class="col-md-2">
                                               
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <button class="btn btn-danger btn-sm  delItem" value="<?= $witem['wid']; ?>">
                                                    <i class="fa fa-trash me-2"></i> Ukloni
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } ?>
                            </div>
                           
                        <?php
                        } else {
                        ?>

                            <div class="card card-body text-center shadow">
                                <h4 class="py-3">Vaša lista želja je prazna</h4>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>