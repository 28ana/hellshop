<div class="py-5 bg-dark mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h4 class="text-white">E-shop</h4>
                <div class="underline mb-2"></div><br>
                
<?php
    $query = "SELECT * FROM nav_items ORDER BY position ASC";
    $stmt = $conn->query($query)

?>
        <?php
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $show = false;

            // svi
            if($row['role'] == 0) {
                $show = true;
            }

            // samo ulogovani
            if($row['role'] == 1 && isset($_SESSION['auth'])) {
                $show = true;
            }

            // samo admin
            if($row['role'] == 2 && isset($_SESSION['auth']) && $_SESSION['role_as'] == 1) {
                $show = true;
            }

            if($show):
        ?>
            
                <a class="nav-link text-light fs-4" href="<?= $row['link']; ?>">
                    <?= $row['ime']; ?>
                </a>
           
        <?php endif; } ?>
            </div>
            <div class="col-md-3">
                <h4 class="text-white fs-4">Adresa</h4>
                <div class="underline mb-2"></div><br>
                <p class="text-white fs-4">
                    Nemanjina 1,<br>
                    Beograd, Srbija
                </p>
                <a href="tel:+381645556664" class="text-white fs-4"><i class="fa fa-phone"></i> +381 645556664</a><br>
                <a href="mailto:xyz@gmail.com" class="text-white fs-4"><i class="fa fa-envelope"></i> xyz@gmail.com</a>
            </div>
            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2830.6710956565694!2d20.4571736!3d44.8078912!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a7aa979a545d5%3A0x60cf4ceb300aca4e!2z0J3QtdC80LDRmtC40L3QsCAxLCDQkdC10L7Qs9GA0LDQtA!5e0!3m2!1ssr!2srs!4v1674742824644!5m2!1ssr!2srs" class="w-100" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="py-2 bg-danger">
    <div class="text-center">
        <p class="mb-0 text-white fs-4">All rights reserved. Copyright @ <a href="#" class="text-dark">Ana Markovic 46/24</a> <?= date('Y') ?></p>
    </div>
</div>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script>
    alertify.set('notifier','position', 'top-center');
    <?php if(isset($_SESSION['message'])) { ?>
        alertify.success("<?= $_SESSION['message']; ?>");
        <?php unset($_SESSION['message']); ?>
    <?php } ?>
</script>

</body>
</html>