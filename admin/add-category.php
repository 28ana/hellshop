<?php
include_once "../middleware/adminMiddleWare.php";
include_once "includes/header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4>Dodaj kategoriju
                        <a href="category.php" class="btn btn-primary float-end">Nazad</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Ime</label>
                                <input type="text" name="name" placeholder="Unesi ime kategorije" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="">Opis</label>
                                <input type="text" name="description" placeholder="Unesi opis" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">Dodaj sliku</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="col-md-3 mt-5">
                                <label for="">Status</label>
                                <input type="checkbox" name="status">
                            </div>
                            <div class="col-md-3 mt-5">
                                <label for="">Popularno</label>
                                <input type="checkbox" name="popular">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_category_btn">Sačuvaj</button>
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