<?php
include_once __DIR__ . "../middleware/adminMiddleWare.php";
include_once "includes/header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4>Dodaj proizvod
                        <a href="products.php" class="btn btn-primary float-end">Nazad</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12  mb-2">
                                <label for="">Izaberi kategoriju</label>
                                <select name="category_id" class="form-select">
                                    <option selected>Izaberi kategoriju</option>
                                    <?php
                                    $category = getAll("categories");

                                    if ($category) {
                                        foreach ($category as $item) {
                                    ?>
                                            <option value="<?= $item['id']; ?>"><?= $item['ime'] ?></option>
                                    <?php
                                        }
                                    } else {
                                        echo "Nema dostupne kategorije.";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0" for="">Ime</label>
                                <input type="text" required name="name" placeholder="Unesi ime proizvoda" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0" for="">Kratki opis</label>
                                <input type="text" required name="small_description" placeholder="Unesi kratki opis" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0" for="">Opis</label>
                                <input type="text" required name="description" placeholder="Unesi opis" class="form-control mb-2 ">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0" for="">Originalna cena</label>
                                <input type="text" required name="original_price" placeholder="Unesi originalnu cenu" class="form-control mb-2">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0" for="">Prodajna cena</label>
                                <input type="text" required name="selling_price" placeholder="Unesi prodajnu cenu" class="form-control  mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0" for="">Dodaj sliku</label>
                                <input type="file" required name="image" class="form-control mb-2">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="mb-0" for="">Količina</label>
                                    <input type="text" required name="qty" placeholder="Unesi količinu" class="form-control mb-2">
                                </div>
                                <div class="col-md-3  mb-2">
                                    <label class="mb-0" for="">Status</label><br>
                                    <input type="checkbox" name="status">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="mb-0" for="">Popularno</label><br>
                                    <input type="checkbox" name="trending">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_product_btn">Sačuvaj</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "includes/footer.php";
?>