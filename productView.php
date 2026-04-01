<?php
include "includes/header.php";
include "functions/userfunctions.php";
include "functions/myfunctions.php";

if (isset($_GET['product'])) {
    $product_id = $_GET['product'];
    $product_data = getByID("products", $product_id); 
    $product = mysqli_fetch_array($product_data);

    if ($product) {
?>
        <div class="py-3 bg-secondary fs-4">
            <div class="container">
                <h6 class="text-white">
                    <a class="text-white text-decoration-none  fs-4" href="index.php">Početna /</a>
                    <a class="text-white  text-decoration-none fs-4" href="categories.php">Kategorije /</a>
                    <?= $product['ime']; ?>
                </h6>
            </div>
        </div>
        <div class="bg-light py-4">
            <div class="container col-md-12 product_data mt-3 d-flex">
                <div class="row topview justify-content-center">
                    <div class="col-md-4">
                        <div class="shadow d-inline-block">
                            <img src="uploads/<?= $product['image'] ?>" alt="Product image" class="img-fluid" 
                            style="max-height: 350px; width: 100%; object-fit: contain;">
                        </div>
                    </div>
                     <div class="col-md-6 mt-4">
                        <h2 class="fw-bold"><?= $product['ime'] ?></h2>

                        <p><?= $product['kratkiOpis'] ?></p>

                        <hr>
                        <div class="row topview justify-content-center">
                            <div class="col-md-4">
                                <h4>Stara cena:<br><br> <span class="text-danger fw-bold"><?= $product['orginalnaCena'] ?></span>DIN 
                                </h4>
                            </div>
                            <div class="col-md-4">
                                <h2>Nova cena:<br><br><span class="text-success fw-bold"><?= $product['prodajnaCena'] ?></span>DIN 
                                </h2>
                            </div>
                           <div class="row product_data justify-content-center"> 
                                <div class="col-md-4 mt-4">
                                    <h2 class="fw-bold">Količina</h2>
                                    <div class="input-group mb-3" style="width: 20vw; height:30px">
                                        <button class="input-group-text decrement-btn fw-bold fs-4">-</button>
                                        <input type="text" class="form-control fw-bold fs-4 text-center input-qty bg-white" value="1" disabled>
                                        <button class="input-group-text increment-btn fw-bold fs-4">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 justify-content-center">
                                <div class="col-md-6">
                                    <button class="btn btn-primary px-4 addToCartBtn" value="<?= $product['id']; ?>">
                                        <i class="fa fa-shoping-cart me-2"></i>
                                        Ubaci u korpu
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary px-4 addToWishList" value="<?= $product['id'];?> ">
                                        <i class="fa fa-heart me-2"></i>
                                        Lista želja
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="container">
            <div class=" col-md-12 bg-light 8">
                <hr>
                <h3 class="ml-3 topview">Opis proizvoda:</h3>
                <p class="prod fs-5"><?= $product['opis'] ?></p>
            </div>
        </div>
<?php
    } else {
        echo "Proizvod nije pronađen";
    }
} else {
    echo "Nešto je pošlo po zlu";
}
include "includes/footer.php";
?>