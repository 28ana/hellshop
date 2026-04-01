<footer class="footer pt-5">
</footer>
</main>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/perfect-scrollbar.min.js"></script>
<script src="assets/js/smooth-scrollbar.min.js"></script>

<script src="assets/js/custom.js"></script>

<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    <?php if (isset($_SESSION['message'])) {
    ?>
        alertify.set('notifier', 'position', 'top-right');
        alertify.success("<?= $_SESSION['message'] ?>");
    <?php
        unset($_SESSION['message']);
    }
    ?>

document.addEventListener("DOMContentLoaded", function () {
    const body = document.querySelector("body");
    const openBtn = document.getElementById("iconNavbarSidenav");
    const closeBtn = document.getElementById("iconSidenav");

    openBtn.addEventListener("click", function () {
        body.classList.toggle("g-sidenav-pinned");
    });

    closeBtn.addEventListener("click", function () {
        body.classList.remove("g-sidenav-pinned");
    });
});
</script>
</body>

</html>