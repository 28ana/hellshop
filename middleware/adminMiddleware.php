<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../functions/myfunctions.php";


if (isset($_SESSION['auth'])) {
    if ($_SESSION['role_as'] != 1) {
        redirect("../index.php", "Nemate ovlašćenje da pristupite ovoj stranici.");
    }
} else {
    redirect("../login.php", "Prijavite se da biste nastavili.");
}
?>