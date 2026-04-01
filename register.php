<?php
if (isset($_SESSION['auth'])) {
    $_SESSION['message'] = "Već ste registrovani i prijavljeni.";
    header('Location: index.php');
    exit();
}

include "includes/header.php";
?>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">

        <div class="card shadow">
          <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Registracija korisnika</h2>
          </div>
          <div class="card-body">
            <form action="functions/authcode.php" method="POST"  novalidate>
              <div class="mb-3">
                <label class="form-label fs-5">Ime i prezime</label>
                <input type="text" id="name" name="name" class="form-control form-control-lg" placeholder="Unesite ime" required>
                <span id="name-error" class="error"></span>
              </div>
              <div class="mb-3">
                <label class="form-label fs-5">Broj telefona</label>
                <input type="text" id="phone" name="phone" class="form-control form-control-lg" placeholder="Unesite broj telefona" required>
                <span id="phone-error" class="error"></span>
              </div>
              <div class="mb-3">
                <label class="form-label fs-5">Email adresa</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Unesite email adresu" id="exampleInputEmail1" required>
                <span id="email-error" class="error"></span>
              </div>
              <div class="mb-3">
                <label class="form-label fs-5">Lozinka</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Minimum 8 karaktera" required>
                <span id="password-error" class="error"></span>
              </div>
              <div class="mb-3">
                <label class="form-label fs-5">Potvrdite lozinku</label>
                <input type="password" id="cpassword" name="cpassword" placeholder="Ponovite lozinku" class="form-control form-control-lg" required>
                <span id="cpassword-error" class="error"></span>
              </div>
              <div class="d-grid mt-4">
                <button type="submit" name="register_btn" class="btn btn-primary">Registruj se</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/validation.js"></script>
<?php include "includes/footer.php"; ?>