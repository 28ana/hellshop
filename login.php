<?php
include "includes/header.php";
if (isset($_SESSION['auth'])) {
    $_SESSION['message'] = "Već ste prijavljeni na sistem.";
    header('Location: index.php');
    exit();
}
include "functions/myfunctions.php";
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow"> 
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Prijava na nalog</h4>
                    </div>
                    <div class="card-body">
                        <form action="functions/authcode.php" method="POST" novalidate>
                            <div class="mb-3">
                                <label class="form-label fs-5">Email adresa</label>
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="Unesite email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fs-5">Lozinka</label>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Unesite lozinku" required>
                            </div>
                            <div class="d-grid gap-2"> 
                                <button type="submit" name="login_btn" class="btn btn-primary">Prijavi se</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>