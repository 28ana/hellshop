<?php
include_once __DIR__ . "/middleware/adminMiddleWare.php";
include_once __DIR__ . "/functions/userfunctions.php";
include_once "includes/header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $product = getById('products', $id);

                if (!empty($product)) {
                    $data = $product;
            ?>
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4>Izmeni proizvod
                                <a href="products.php" class="btn btn-primary float-end">Nazad</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    
                                    <input type="hidden" name="product_id" value="<?= $data['id']; ?>">
                                    <div class="col-md-6">
                                        <label class="mb-0" for="">Ime</label>
                                        <input type="text" required name="name" value="<?= $data['ime']; ?>" placeholder="Unesi ime proizvoda" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="mb-0" for="">Kratki opis</label>
                                        <input type="text" required name="small_description" value="<?= $data['kratkiOpis']; ?>" placeholder="Unesi kratki opis" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="mb-0" for="">Opis</label>
                                        <input type="text" required name="description" value="<?= $data['opis']; ?>" placeholder="Unesi opis" class="form-control mb-2 ">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-0" for="">Originalna cena</label>
                                        <input type="text" required name="original_price" value="<?= $data['orginalnaCena']; ?>" placeholder="Unesi originalnu cenu" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-0" for="">Prodajna cena</label>
                                        <input type="text" required name="selling_price" value="<?= $data['prodajnaCena']; ?>" placeholder="Unesi prodajnu cenu" class="form-control  mb-2">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="mb-0" for="">Dodaj sliku</label>
                                        <input type="hidden" name="old_image" value="<?= $data['image']; ?>">
                                        <input type="file" name="image" class="form-control mb-2">
                                        <label class="mb-0" for="">Trenutna slika</label>
                                        <img src="../uploads/<?= $data['image']; ?>" alt="Slika proizvoda" width="50px" height="50px">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="mb-0" for="">Količina</label>
                                            <input type="text" required name="qty" value="<?= $data['kolicina']; ?>" placeholder="Unesi količinu" class="form-control mb-2">
                                        </div>
                                        <div class="col-md-3  mb-2">
                                            <label class="mb-0" for="">Status</label><br>
                                            <input type="checkbox" name="status" <?= $data['status'] == '0' ? '' : 'checked'; ?>>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="mb-0" for="">Popularno</label><br>
                                            <input type="checkbox" name="trending" <?= $data['trending'] == '0' ? '' : 'checked'; ?>>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_product_btn">Ažuriraj</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                } else {
                    echo "Proizvod nije pronađen.";
                }
            } else {
                echo "Nešto je krenulo po zlu.";
            }
            ?>
        </div>
    </div>
</div>


<?php include "includes/footer.php";
?>