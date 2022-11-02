<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu</div>
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? "active" : "" ?>" href="dashboard.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fa fa-bars"></i></div>
                Data Master
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'pelanggan.php') ? "active" : "" ?> " href="pelanggan.php" aria-controls="pagesCollapseMaster">
                        <div class="sb-nav-link-icon"><i class="fa fa-users"></i></div>
                        Pelanggan
                    </a>
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'barang.php') ? "active" : "" ?>" href="barang.php" aria-controls="pagesCollapseMaster">
                        <div class="sb-nav-link-icon"><i class="fa fa-archive"></i></div>
                        Barang
                    </a>
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'kategori_barang.php') ? "active" : "" ?>" href="kategori_barang.php" aria-controls="pagesCollapseMaster">
                        <div class="sb-nav-link-icon"><i class="fa fa-object-group"></i></div>
                        Kategori Barang
                    </a>
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'diskon.php') ? "active" : "" ?>" href="diskon.php" aria-controls="pagesCollapseMaster">
                        <div class="sb-nav-link-icon"><i class="fa fa-percent"></i></div>
                        Diskon Barang
                    </a>
                </nav>
            </div>
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
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'warung.php') ? "active" : "" ?>" href="warung.php" aria-controls="pagesCollapseMaster">
                        <div class="sb-nav-link-icon"><i class="fa fa-sticky-note"></i></div>
                        Profil Warung
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