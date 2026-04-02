<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include(__DIR__ . '/../config/dbcon.php');
include_once "userfunctions.php";

if (isset($_POST['register_btn'])) 
{
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']); 
    $password = $_POST['password']; 
    $cpassword = $_POST['cpassword'];

    $nameReg = "/^[A-ZĐŽĆČŠ][a-zđžćčš]+(\s[A-ZĐŽĆČŠ][a-zđžćčš]+)*$/";
    $phoneReg="/^(\+3816\d{7,8}|06\d{7,8})$/";
    $passReg = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
    

    if (empty($name) || empty($email) || empty($password)) {
        redirect("../register.php", "Sva polja su obavezna.");
    }

    if (!preg_match($nameReg, $name)) {
        redirect("../register.php", "Ime nije u dobrom formatu.");
    }

    if (!preg_match($phoneReg, $phone)) {
        redirect("../register.php", "Telefon nije u dobrom formatu.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect("../register.php", "Unesite ispravnu email adresu (nedostaje @ ili domen).");
    }

    if (!preg_match($passReg, $password)) {
        redirect("../register.php", "Lozinka mora imati najmanje 8 karaktera.");
    }

    if ($password != $cpassword) {
        redirect("../register.php", "Lozinke se ne podudaraju.");
    }

    $stmt = $conn->prepare("SELECT email FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        redirect("../register.php", "Email je već registrovan.");
    } 
    else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt_insert = $conn->prepare("
            INSERT INTO users (ime, phone, email, password) 
            VALUES (:name, :phone, :email, :password)
        ");

        $stmt_insert->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt_insert->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt_insert->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_insert->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        if ($stmt_insert->execute()) {
            redirect("../login.php", "Registracija uspešno završena. Prijavite se.");
        } else {
            redirect("../register.php", "Greška pri upisu u bazu podataka.");
        }
    }
} 
else if (isset($_POST['login_btn'])) 
{
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        redirect("../login.php", "Sva polja moraju biti popunjena.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect("../login.php", "Unesite ispravnu email adresu.");
    }

    $stmt_login = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt_login->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_login->execute();

    $userdata = $stmt_login->fetch(PDO::FETCH_ASSOC);

    if ($userdata) {
        if (password_verify($password, $userdata['password'])) {

            $_SESSION['auth'] = true;
            $_SESSION['role_as'] = $userdata['role_as'];
            $_SESSION['auth_user'] = [
                'user_id' => $userdata['id'],
                'name' => $userdata['ime'],
                'email' => $userdata['email']
            ];

            if ($userdata['role_as'] == 1) {
                redirect("../admin/index.php", "Uspešno ste se prijavili na Admin Panel.");
            } else {
                redirect("../index.php", "Uspešno ste se ulogovali. Dobrodošli!");
            }

        } else {
            redirect("../login.php", "Pogrešna lozinka. Pokušajte ponovo.");
        }
    } else {
        redirect("../login.php", "Korisnik sa tim emailom ne postoji.");
    }
}
?>