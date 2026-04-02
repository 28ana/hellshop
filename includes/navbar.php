<nav class="navbar fs-3 navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <div class="logo">
        <a class="navbar-brand bg-danger fs-3" href="home.php"> .HELL SHOP. </a>
        <img src="uploads/favicon.ico" alt="" width="30">
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <?php
        $query = "SELECT * FROM nav_items  ORDER BY position ASC";
        $stmt = $conn->query($query);

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
            <li class="nav-item">
                <a class="nav-link" href="<?= $row['link']; ?>">
                    <?= $row['ime']; ?>
                </a>
            </li>
        <?php endif; } ?>

<!-- user deo -->
        <?php if (isset($_SESSION['auth'])): ?> 
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <?= $_SESSION['auth_user']['name'] ?? '' ?>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item fs-3" href="wishlist.php">Lista želja</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item fs-3" href="logout.php">Izloguj se</a></li>
                </ul>
            </li>

        <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="register.php">Registracija</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Uloguj se</a></li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>