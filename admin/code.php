<?php
session_start();
include __DIR__ . "/../config/dbcon.php";
include_once __DIR__ . "/../functions/myfunctions.php";
include_once __DIR__ . "/../functions/userfunctions.php";

$path = "../uploads";

// kategorije

// dodavanje kategorije
if (isset($_POST['add_category_btn'])) {
    
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
    $_SESSION['message'] = "Slika je obavezna!";
    header("Location: add-category.php");
    exit();
    }

    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? '1' : '0';
    
    $image = $_FILES['image']['name'];
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    $stmt = $conn->prepare("INSERT INTO categories (ime, status, opis, image) VALUES (:ime, :status, :opis, :image)");
    $stmt->bindParam(":ime", $name);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":opis", $description);
    $stmt->bindParam(":image", $filename);

    if ($stmt->execute()) {
        $path = "../uploads";
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        redirect("add-category.php", "Kategorija je uspešno dodata");
    } else {
        redirect("add-category.php", "Nešto je krenulo po zlu");
    }
    $stmt = null;
} 

// izmena kategorije
elseif (isset($_POST['update_category_btn'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? '1' : '0';
    
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $stmt = $conn->prepare("UPDATE categories SET ime=:ime, opis=:opis, status=:status, image=:image WHERE id=:id");
    $stmt->bindParam(":ime", $name);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":opis", $description);
    $stmt->bindParam(":image", $update_filename);
    $stmt->bindParam(":id", $id);

    if ($stmt->execute()) {
        if ($new_image != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists("../uploads/" . $old_image)) {
                unlink("../uploads/" . $old_image);
            }
        }
        redirect("edit-category.php?id=$category_id", "Kategorija je uspešno izmenjena");
    } else {
        redirect("edit-category.php?id=$category_id", "Greška pri osvežavanju");
    }
    $stmt = null;
}

// brisanje kategorije
elseif (isset($_POST['delete_category_btn'])) {
    $category_id = $_POST['category_id'];

    $stmt_select = $conn->prepare("SELECT image FROM categories WHERE id=:id");
    $stmt_select->bindParam(":id", $category_id);
    $stmt_select->execute();
    $category_data = $stmt_select->fetch(PDO::FETCH_ASSOC);
    $image = $category_data['image'];
    $stmt_select = null;

    $stmt_delete = $conn->prepare("DELETE FROM categories WHERE id=:id");
    $stmt_delete->bindParam(":id", $category_id);

    if ($stmt_delete->execute()) {
        if (file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
        }
        redirect("category.php", "Kategorija uspešno obrisana");
    } else {
        redirect("category.php", "Nešto je krenulo po zlu");
    }
    $stmt_delete = null;
}

// proizvodi

// dodavanje proizvoda
elseif (isset($_POST['add_product_btn'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $qty = $_POST['qty'];
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';

    $image = $_FILES['image']['name'];
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    if ($name != "" && $description != "") {
        $stmt = $conn->prepare("INSERT INTO products (categoryId, ime, kratkiOpis, opis, orginalnaCena, prodajnaCena, kolicina, status, trending, image) VALUES (:categoryId, :ime, :kratkiOpis, :opis, :orginalnaCena, :prodajnaCena, :kolicina, :status, :trending, :image)");
        $stmt->bindParam(":categoryId", $category_id);
        $stmt->bindParam(":ime", $name);
        $stmt->bindParam(":kratkiOpis", $small_description);
        $stmt->bindParam(":opis", $description);
        $stmt->bindParam(":orginalnaCena", $original_price);
        $stmt->bindParam(":prodajnaCena", $selling_price);
        $stmt->bindParam(":kolicina", $qty);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":trending", $trending);
        $stmt->bindParam(":image", $filename);

        if ($stmt->execute()) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
            redirect("add-product.php", "Proizvod uspešno dodat");
        } else {
            redirect("add-product.php", "Greška u bazi podataka");
        }
        $stmt = null;
    } else {
        redirect("add-product.php", "Sva polja su obavezna");
    }
}

// izmena proizvoda
elseif (isset($_POST['update_product_btn'])) {
    $product_id = $_POST['product_id'];
    $stmtCat = $conn->prepare("SELECT categoryId FROM products WHERE id=:id");
    $stmtCat->execute([':id' => $product_id]);
    $currentCategory = $stmtCat->fetch(PDO::FETCH_ASSOC)['categoryId'];

    $name = $_POST['name'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $qty = $_POST['qty'];
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';


    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $stmt = $conn->prepare("UPDATE products SET categoryId=:categoryId, ime=:ime, kratkiOpis=:kratkiOpis, opis=:opis, orginalnaCena=:orginalnaCena, prodajnaCena=:prodajnaCena, kolicina=:kolicina, status=:status, trending=:trending, image=:image WHERE id=:id");
    $stmt->bindParam(":categoryId", $currentCategory);
    $stmt->bindParam(":ime", $name);
    $stmt->bindParam(":kratkiOpis", $small_description);
    $stmt->bindParam(":opis", $description);
    $stmt->bindParam(":orginalnaCena", $original_price);
    $stmt->bindParam(":prodajnaCena", $selling_price);
    $stmt->bindParam(":kolicina", $qty);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":trending", $trending);
    $stmt->bindParam(":image", $update_filename);
    $stmt->bindParam(":id", $product_id);

    if ($stmt->execute()) {
        if ($new_image != "") {
            $path = "../uploads";
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists("../uploads/" . $old_image)) {
                unlink("../uploads/" . $old_image);
            }
        }
        redirect("edit-product.php?id=$product_id", "Proizvod uspešno izmenjen");
    } else {
        redirect("edit-product.php?id=$product_id", "Greška pri izmeni");
    }
    $stmt = null;
}

// brisanje proizvoda
elseif (isset($_POST['delete_product_btn'])) {
    $product_id = $_POST['product_id'];

    $stmt_select = $conn->prepare("SELECT image FROM products WHERE id=:id");
    $stmt_select->bindParam(":id", $product_id);
    $stmt_select->execute();
    $product_data = $stmt_select->fetch(PDO::FETCH_ASSOC);
    
    if($product_data) {
        $image = $product_data['image'];

        $stmt_delete = $conn->prepare("DELETE FROM products WHERE id=:id");
        $stmt_delete->bindParam(":id", $product_id);

        if ($stmt_delete->execute()) {
            if ($image != "" && file_exists("../uploads/" . $image)) {
                unlink("../uploads/" . $image);
            }
            redirect("products.php", "Proizvod uspešno obrisan");
        } else {
            redirect("products.php", "Greška pri brisanju");
        }
        $stmt_delete = null;
    }
    $stmt_select = null;
}
// porudzbine

// azuriranje porudzbine
elseif (isset($_POST['update_order_btn'])) {
    $track_no = $_POST['trackingNo'];
    $order_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE trackingNo = :trackingNo");
    
    $stmt->bindParam(":status", $order_status);
    $stmt->bindParam(":trackingNo", $track_no);

    if ($stmt->execute()) {
        $stmt = null;
        redirect("view-order.php?t=$track_no", "Status porudžbine je uspešno ažuriran");
    } else {
        $stmt = null;
        redirect("view-order.php?t=$track_no", "Došlo je do greške u bazi");
    }
}
else {
    header('Location: ../index.php');
    exit();
}
?>