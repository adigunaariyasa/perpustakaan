<div class="border-end bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading border-bottom bg-light"><?= SITE_NAME ?></div>
    <a class="<?= $active == "dashboard" ? "active" : "" ?> list-group-item list-group-item-action list-group-item-light p-3" href="index.php">Dashboard</a>
    <?php if ($currentUser['is_admin'] == 1) : ?>
        <div class="list-group list-group-flush">
            <a class="<?= $active == "anggota" ? "active" : "" ?> list-group-item list-group-item-action list-group-item-light p-3" href="anggota.php">Anggota</a>
            <a class="<?= $active == "kategori-buku" ? "active" : "" ?> list-group-item list-group-item-action list-group-item-light p-3" href="kategori-buku.php">Kategori Buku</a>
            <a class="<?= $active == "buku" ? "active" : "" ?> list-group-item list-group-item-action list-group-item-light p-3" href="buku.php">Buku</a>
            <a class="<?= $active == "peminjaman" ? "active" : "" ?> list-group-item list-group-item-action list-group-item-light p-3" href="#">Peminjaman</a>
            <a class="<?= $active == "pengembalian" ? "active" : "" ?> list-group-item list-group-item-action list-group-item-light p-3" href="#">Pengembalian</a>
            <a class="<?= $active == "laporan" ? "active" : "" ?> list-group-item list-group-item-action list-group-item-light p-3" href="#">Laporan</a>
        </div>
    <?php else : ?>
        <div class="list-group list-group-flush">
            <a class="<?= $active == "buku" ? "active" : "" ?> list-group-item list-group-item-action list-group-item-light p-3" href="#">Peminjaman saya</a>
        </div>
    <?php endif ?>
</div>