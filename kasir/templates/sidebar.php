<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu</div>
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? "active" : "" ?>" href="dashboard.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'kasir.php') ? "active" : "" ?>" href="kasir.php">
                <div class="sb-nav-link-icon"><i class="fa fa-shopping-cart"></i></div>
                Kasir
            </a>

            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'transaksi.php') ? "active" : "" ?>" href="transaksi.php">
                <div class="sb-nav-link-icon"><i class="fa fa-list"></i></div>
                Transaksi
            </a>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages2" aria-expanded="false" aria-controls="collapsePages2">
                <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
                Pengaturan
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse" id="collapsePages2" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'ganti_password.php') ? "active" : "" ?> " href="ganti_password.php" aria-controls="pagesCollapseMaster">
                        <div class="sb-nav-link-icon"><i class="fa fa-key"></i></div>
                        Ganti Password
                    </a>

                </nav>
            </div>

        </div>
    </div>
    <div class="sb-sidenav-footer">
    <div class="medium">Nama : <?php echo  $_SESSION["nama"]; ?></div>
        <div class="medium">Role : <?php echo  $_SESSION["role"]; ?></div>
    </div>
</nav>