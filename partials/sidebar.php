<?php

$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
//  $uriSegments[2] 

?>
<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
  <div class="sb-sidenav-menu overflow-visible">
    <div class="nav">
      <div class="sb-sidenav-menu-heading">Menu</div>
      <?php if ($_SESSION["login"] === true && $_SESSION['id_role'] === 1 || $_SESSION['id_role'] === 2) { ?>
        <a class="nav-link <?php echo ($uriSegments[2] == 'dashboard') || ($uriSegments[2] == '') ? "active" : "" ?>" href="<?php echo BASEURL; ?>/dashboard">
          Dashboard
        </a>
      <?php } ?>

      <!-- DROPDOWN 1  start-->

      <a class="nav-link <?php echo ($uriSegments[2] == 'pelanggan') || ($uriSegments[2] == 'produk') || ($uriSegments[2] == 'kategori') || ($uriSegments[2] == 'satuan-produk') || ($uriSegments[2] == 'diskon') ? "active" : "" ?> collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages1" aria-expanded="false" aria-controls="collapsePages1">
        Master
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
      <div class="collapse <?php echo ($uriSegments[2] == 'pelanggan') || ($uriSegments[2] == 'produk') || ($uriSegments[2] == 'kategori-produk') || ($uriSegments[2] == 'satuan-produk') || ($uriSegments[2] == 'diskon') ? "show" : "" ?>" id="collapsePages1" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <!-- kasir -->
        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
          <?php if ($_SESSION["login"] === true && $_SESSION['id_role'] === 1 || $_SESSION['id_role'] === 2) { ?>
            <a class="nav-link <?php echo ($uriSegments[2] == 'pelanggan') ? "active" : "" ?> " href="<?php echo BASEURL; ?>/pelanggan">
              Pelanggan
            </a>
          <?php } ?>
          <?php if ($_SESSION["login"] === true && $_SESSION['id_role'] === 1) { ?>
            <a class="nav-link <?php echo ($uriSegments[2] == 'produk') ? "active" : "" ?>" href="<?php echo BASEURL; ?>/produk">
              Produk
            </a>
            <a class="nav-link <?php echo ($uriSegments[2] == 'kategori-produk') ? "active" : "" ?>" href="<?php echo BASEURL; ?>/kategori-produk">
              Kategori Produk
            </a>
            <a class="nav-link <?php echo ($uriSegments[2] == 'satuan-produk') ? "active" : "" ?>" href="<?php echo BASEURL; ?>/satuan-produk">
              Satuan Produk
            </a>
            <a class="nav-link <?php echo ($uriSegments[2] == 'diskon') ? "active" : "" ?>" href="<?php echo BASEURL; ?>/diskon">
              Diskon Produk
            </a>
          <?php } ?>

        </nav>
      </div>

      <!-- DROPDOWN 1 start-->


      <!-- DROPDOWN 2  start-->
      <a class="nav-link <?php echo ($uriSegments[2] == 'stok-masuk') || ($uriSegments[2] == 'stok-keluar') || ($uriSegments[2] == 'penjualan') ? "active" : "" ?> collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages2" aria-expanded="false" aria-controls="collapsePages2">
        Transaksi
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
      <div class="collapse <?php echo ($uriSegments[2] == 'stok-masuk') || ($uriSegments[2] == 'stok-keluar') || ($uriSegments[2] == 'penjualan') ? "show" : "" ?>" id="collapsePages2" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">

        <!-- kasir -->
        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
          <?php if ($_SESSION["login"] === true && $_SESSION['id_role'] === 1) { ?>
            <a class="nav-link <?php echo ($uriSegments[2] == 'stok-masuk') ? "active" : "" ?> " href="<?php echo BASEURL; ?>/stok-masuk">
              Stok Masuk
            </a>

            <a class="nav-link <?php echo ($uriSegments[2] == 'stok-keluar') ? "active" : "" ?>" href="<?php echo BASEURL; ?>/stok-keluar">
              Stok Keluar
            </a>
          <?php } ?>

          <?php if ($_SESSION["login"] === true && $_SESSION['id_role'] === 1 || $_SESSION['id_role'] === 2) { ?>
            <a class="nav-link <?php echo ($uriSegments[2] == 'penjualan') ? "active" : "" ?>" href="<?php echo BASEURL; ?>/penjualan">
              Penjualan
            </a>
          <?php } ?>

        </nav>
      </div>
      <!-- DROPDOWN 2  start-->
      <?php if ($_SESSION["login"] === true && $_SESSION['id_role'] === 1 || $_SESSION['id_role'] === 2) { ?>
        <a class="nav-link <?php echo ($uriSegments[2] == 'laporan-penjualan') || ($uriSegments[2] == '') ? "active" : "" ?>" href="<?php echo BASEURL; ?>/laporan-penjualan">
          Laporan Penjualan
        </a>
      <?php } ?>
      <?php if ($_SESSION["login"] === true && $_SESSION['id_role'] === 1) { ?>
        <a class="nav-link <?php echo ($uriSegments[2] == 'profil-warung') || ($uriSegments[2] == '') ? "active" : "" ?>" href="<?php echo BASEURL; ?>/profil-warung">
          Profil Warung
        </a>
      <?php } ?>
    </div>
  </div>
  <div class="sb-sidenav-footer">
    <div class="medium">Nama :
      <?php echo $username ?>
    </div>
    <div class="medium">Role :
      <?php echo $role; ?>
    </div>
  </div>
</nav>