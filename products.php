<?php
include "includes/header.php";
include "functions/myfunctions.php";
include "functions/userfunctions.php";

if (isset($_GET['categoryId'])) {
    $categoryId = $_GET['categoryId'];
    $category = getByID("categories", $categoryId);
 if ($category) {
?>
        <div class="py-3 bg-secondary">
            <div class="container">
                <h6 class="text-white fs-4">
                    <a class="text-white text-decoration-none " href="index.php">Početna /</a>
                    <a class="text-white text-decoration-none " href="categories.php">Kategorije /</a>
                    <?= $category['ime']; ?>
                </h6>
            </div>
        </div>
        <div class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 mb-5 mt-5">
                        <div class="row " height='250px' >
                            <h2><?= $category['ime']; ?></h2>
                            <hr>
                            <?php
                            $products = getProByCategory($categoryId);
                            if ($products->rowCount() > 0) {
                                foreach ($products as $item) {
                            ?>
                            <div class="col-12 col-lg-3 col-md-6 mb-2 mt-5">
                                <a class="text-dark  text-decoration-none "  href="productView.php?product=<?= $item['id']; ?>">
                                    <div class="card shadow" style="height: 280px" >
                                        <div class="card-body text-center mt-5">
                                            <img class="w-50 mb-3" height='100px' src="uploads/<?= $item['image'] ?>" alt="Product image">
                                            <h4 class="text-center mt-5 mb-5"><?= $item['ime']; ?></h4>
                                                
                                            <h4 class="text-center text-danger mt-5"><?= $item['prodajnaCena']; ?> DIN</h4>
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
<?php
    } else {
        echo "Nešto nije u redu";
    }
} else {
    echo "Nešto je pošlo po zlu";
}
include "includes/footer.php"; ?>