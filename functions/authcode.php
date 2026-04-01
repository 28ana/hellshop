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


    $stmt = mysqli_prepare($conn, "SELECT email FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        redirect("../register.php", "Email je već registrovan.");
    } 
    else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (ime, phone, email, password) VALUES (?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt_insert, "ssss", $name, $phone, $email, $hashed_password);
        
        if (mysqli_stmt_execute($stmt_insert)) {
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

    $login_query = "SELECT * FROM users WHERE email=?";
    $stmt_login = mysqli_prepare($conn, $login_query);
    mysqli_stmt_bind_param($stmt_login, "s", $email);
    mysqli_stmt_execute($stmt_login);
    $result = mysqli_stmt_get_result($stmt_login);

    if (mysqli_num_rows($result) > 0) {
        $userdata = mysqli_fetch_array($result);
        
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