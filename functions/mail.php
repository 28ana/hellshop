<?php
session_start();
include_once "userfunctions.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Nevalidan zahtev.");
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Nevalidan CSRF token!");
}

  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $message = trim($_POST['message']);
  $subject = trim($_POST['subject']);

  $nameReg = "/^[A-ZĐŽĆČŠ][a-zđžćčš]+(\s[A-ZĐŽĆČŠ][a-zđžćčš]+)*$/";

  if (!preg_match($nameReg, $name)) {
    redirect("../contact.php", "Ime nije u dobrom formatu.");
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect("../contact.php", "Unesite ispravnu email adresu (nedostaje @ ili domen).");
  }
  
  if ($subject === '') {
    redirect("../contact.php", "Tema ne moze biti prazna.");
  }

  if ($message === '') {
    redirect("../contact.php", "Poruka ne moze biti prazna.");
  }

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64'; 

    $mail->Username = 'markovicana316@gmail.com';
    $mail->Password = 'klwh cfgz qznr zlrp';

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom($email, $name);

    $mail->addAddress('markovicana316@gmail.com');

    $mail->Subject = $subject;
    $mail->Body = "Od: $name\nEmail: $email\n\n$message";

    $mail->send();

    redirect("../contact.php", "Email uspešno poslat!");

} catch (Exception $e) {
  redirect("../contact.php", "Greška pri slanju: {$mail->ErrorInfo}");
}