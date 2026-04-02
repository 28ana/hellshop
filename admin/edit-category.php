<?php
include_once "../middleware/adminMiddleWare.php";
include_once "../functions/userfunctions.php";
include_once "includes/header.php";

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $data = getById('categories', $id);
                if ($data) {
            ?>
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4>Izmeni kategoriju
                                <a href="category.php" class="btn btn-primary float-end">Nazad</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="category_id" value="<?= $data['id']; ?>">
                                        <label for="">Ime</label>
                                        <input type="text" name="name" value="<?= $data['ime']; ?>" placeholder="Enter category name" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Status</label>
                                        <input type="text" name="slug" value="<?= $data['status']; ?>" placeholder="Enter slug" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Opis</label>
                                        <input type="text" name="description" value="<?= $data['opis']; ?>" placeholder="Enter description" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Dodaj sliku</label>
                                        <input type="file" name="image" class="form-control">
                                        <label for="">Trenutna slika</label>
                                        <input type="hidden" name="old_image" value="<?= $data['image']; ?>">
                                        <img src="../uploads/<?= $data['image']; ?>" height="50px" width="50px" alt="Stara slika">
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_category_btn">Ažuriraj</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                } else {
                    echo "Kategorija nije pronađena.";
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