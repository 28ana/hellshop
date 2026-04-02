<?php 
include "includes/header.php";
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

include "config/dbcon.php";
include "functions/userfunctions.php"; 
?>

<div class="container py-5">
    <section class="mb-4">
        <h2 class="h1-responsive font-weight-bold text-center my-4">Kontaktirajte nas</h2>
        <p class="text-center fs-4 w-responsive mx-auto mb-2">Da li imate neka pitanja za nas?</p>
        <p class="text-center fs-4 w-responsive mx-auto">Naš tim će Vam odgovoriti u najkraćem mogućem roku.</p>

        <div class="row px-5 mt-5">
            <div class="col-md-8">
                <form id="contact-form" action="functions/mail.php" method="POST">
                    <div class="row justify-content-center">
                        <div class="col-md-6 mb-3">
                            <label class="fs-4">Vaše ime</label>
                            <input type="text" id="name" name="name" class="form-control form-control-lg">
                            <span id="name-error" class="error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fs-4">Vaš email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg">
                            <span id="email-error" class="error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="fs-4">Tema</label>
                            <input type="text" id="subject" name="subject" class="form-control form-control-lg">
                            <span id="subject-error" class="error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="fs-4">Vaša poruka</label>
                            <textarea id="message" name="message" rows="5" style="resize: none;" class="form-control form-control-lg"></textarea>
                            <span id="message-error" class="error"></span>
                        </div>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary px-5">Pošalji</button>
                    </div>
                </form>
            </div>

            <div class="col-md-4 text-center mt-5">
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt fa-2x"></i>
                        <p class="fs-4">Nemanjina 1, Beograd</p>
                    </li>
                    <li><i class="fa fa-phone mt-4 fa-2x"></i>
                        <p class="fs-4">+8164555666</p>
                    </li>
                    <li><i class="fa fa-envelope mt-4 fa-2x"></i>
                        <p class="fs-4">xzy@gmail.com</p>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <div class="row justify-content-center">
        <div class="col-md-10 text-center">
            <h2 class="mb-4">Naše prodavnice</h2>
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchCity" placeholder="Pretraži grad..." class="form-control form-control-lg">
                </div>
                <div class="col-md-4">
                    <select id="searchParking" class="form-control form-control-lg">
                        <option value="">Sve</option>
                        <option value="da">Sa parkingom</option>
                        <option value="ne">Bez parkinga</option>
                    </select>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table">
                    <thead class="bg-secondary text-white fs-4">
                        <tr>
                            <th>Grad</th>
                            <th>Adresa</th>
                            <th>Telefon</th>
                            <th>Radno vreme</th>
                            <th>Parking</th>
                        </tr>
                    </thead>
                    <tbody class="fs-4">
                        <?php
                        $query = "SELECT * FROM store";
                        $stmt = $conn->query($query);

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $row['grad']; ?></td>
                                    <td><?= $row['adresa']; ?></td>
                                    <td><?= $row['telefon']; ?></td>
                                    <td><?= $row['radnoVreme']; ?></td>
                                    <td><?= $row['parking']; ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='4'>Trenutno nema podataka o prodavnicama.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/contactForm.js"></script>
<?php include "includes/footer.php"; ?>