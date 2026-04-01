<?php
session_start();
include "../config/dbcon.php";
include "../functions/myfunctions.php";
include "../functions/userfunctions.php";

$path = "../uploads";

// kategorije

// dodavanje kategorije
if (isset($_POST['add_category_btn'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? '1' : '0';
    
    $image = $_FILES['image']['name'];
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    $stmt = $conn->prepare("INSERT INTO categories (ime, status, opis, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $status, $description, $filename);

    if ($stmt->execute()) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        redirect("add-category.php", "Kategorija je uspešno dodata");
    } else {
        redirect("add-category.php", "Nešto je krenulo po zlu");
    }
    $stmt->close();
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

    $stmt = $conn->prepare("UPDATE categories SET ime=?, opis=?, status=?, image=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $description, $status, $update_filename, $category_id);

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
    $stmt->close();
}

// brisanje kategorije
elseif (isset($_POST['delete_category_btn'])) {
    $category_id = $_POST['category_id'];

    $stmt_select = $conn->prepare("SELECT image FROM categories WHERE id=?");
    $stmt_select->bind_param("i", $category_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $category_data = $result->fetch_assoc();
    $image = $category_data['image'];
    $stmt_select->close();

    $stmt_delete = $conn->prepare("DELETE FROM categories WHERE id=?");
    $stmt_delete->bind_param("i", $category_id);

    if ($stmt_delete->execute()) {
        if (file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
        }
        redirect("category.php", "Kategorija uspešno obrisana");
    } else {
        redirect("category.php", "Nešto je krenulo po zlu");
    }
    $stmt_delete->close();
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
        $stmt = $conn->prepare("INSERT INTO products (categoryId, ime, kratkiOpis, opis, orginalnaCena, prodajnaCena, kolicina, status, trending, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // i = integer, s = string, d = double
        $stmt->bind_param("issssdisss", $category_id, $name, $small_description, $description, $original_price, $selling_price, $qty, $status, $trending, $filename);

        if ($stmt->execute()) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
            redirect("add-product.php", "Proizvod uspešno dodat");
        } else {
            redirect("add-product.php", "Greška u bazi podataka");
        }
        $stmt->close();
    } else {
        redirect("add-product.php", "Sva polja su obavezna");
    }
}

// izmena proizvoda
elseif (isset($_POST['update_product_btn'])) {
    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id'];
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

    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $stmt = $conn->prepare("UPDATE products SET categoryId=?, ime=?, kratkiOpis=?, opis=?, orginalnaCena=?, prodajnaCena=?, kolicina=?, status=?, trending=?, image=? WHERE id=?");
    $stmt->bind_param("issssdisssi", $category_id, $name, $small_description, $description, $original_price, $selling_price, $qty, $status, $trending, $update_filename, $product_id);

    if ($stmt->execute()) {
        if ($new_image != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists("../uploads/" . $old_image)) {
                unlink("../uploads/" . $old_image);
            }
        }
        redirect("edit-product.php?id=$product_id", "Proizvod uspešno izmenjen");
    } else {
        redirect("edit-product.php?id=$product_id", "Greška pri izmeni");
    }
    $stmt->close();
}

// brisanje proizvoda
elseif (isset($_POST['delete_product_btn'])) {
    $product_id = $_POST['product_id'];

    $stmt_select = $conn->prepare("SELECT image FROM products WHERE id=?");
    $stmt_select->bind_param("i", $product_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    
    if($result->num_rows > 0) {
        $product_data = $result->fetch_assoc();
        $image = $product_data['image'];

        $stmt_delete = $conn->prepare("DELETE FROM products WHERE id=?");
        $stmt_delete->bind_param("i", $product_id);

        if ($stmt_delete->execute()) {
            if ($image != "" && file_exists("../uploads/" . $image)) {
                unlink("../uploads/" . $image);
            }
            redirect("products.php", "Proizvod uspešno obrisan");
        } else {
            redirect("products.php", "Greška pri brisanju");
        }
        $stmt_delete->close();
    }
    $stmt_select->close();
}
// porudzbine

// azuriranje porudzbine
elseif (isset($_POST['update_order_btn'])) {
    $track_no = $_POST['trackingNo'];
    $order_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE trackingNo = ?");
    
    $stmt->bind_param("ss", $order_status, $track_no);

    if ($stmt->execute()) {
        $stmt->close();
        redirect("view-order.php?t=$track_no", "Status porudžbine je uspešno ažuriran");
    } else {
        $stmt->close();
        redirect("view-order.php?t=$track_no", "Došlo je do greške u bazi");
    }
}
else {
    header('Location: ../index.php');
    exit();
}
?>