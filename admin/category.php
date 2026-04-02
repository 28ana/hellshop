<?php
include_once __DIR__ . "../middleware/adminMiddleWare.php";
include_once __DIR__ . "../functions/userfunctions.php";
include_once "includes/header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4>Kategorije</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive"> 
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ime</th>
                                    <th>Slika</th>
                                    <th>Status</th>
                                    <th>Akcija</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $category = getAll("categories");
                                $categoryList = $category->fetchAll(PDO::FETCH_ASSOC);
                                if (!empty($categoryList)) {
                                    foreach ($categoryList as $item) { ?>
                                        <tr>
                                            <td><?= $item['id']; ?></td>
                                            <td><?= $item['ime']; ?></td>
                                            <td>
                                                <img src="../uploads/<?= $item['image']; ?>" alt="<?= $item['ime']; ?>" style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td><?= $item['status'] == '0' ? "Visible" : "Hidden" ?></td>
                                            <td><a href="edit-category.php?id=<?= $item['id']; ?>" class="btn btn-primary">Izmeni</a>
                                                <form action="code.php" method="post">
                                                    <input type="hidden" name="category_id" value="<?= $item['id']; ?>">
                                                    <button type="submit" class="btn btn-danger" name="delete_category_btn">Izbriši</button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php  }
                                } else {
                                    echo "Nema rezultata";
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>