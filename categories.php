<?php
include "functions/userfunctions.php";
include "includes/header.php";
?>

<div class="py-3 bg-secondary">
    <div class="container">
        <h6 class="text-white fs-4"> 
            <a class="text-decoration-none text-white" href="index.php">Početna /</a> Kategorije /
        </h6>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row ">
                    <h1 class="col-md-12 mb-5 mt-5">Kategorije</h1>
                    <hr>
                    <?php
                    $categories = getAllActive("categories");
                    if ($categories->rowCount() > 0) {
                        foreach ($categories as $item) {
                    ?>
                            <div class="col-md-3 mb-5 mt-5">
                                <a class="text-dark  text-decoration-none "  href="products.php?categoryId=<?= $item['id']; ?>">
                                    <div class="card shadow">
                                        <div class="card-body text-center mt-5">
                                            <img class="w-50 " height='100px' src="uploads/<?= $item['image'] ?>" alt="Category image">
                                            <h4 class="text-center fs-3 mt-5"><?= $item['ime']; ?></h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php
                        }
                    } else {
                        echo "Nema dostupnih podataka";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>