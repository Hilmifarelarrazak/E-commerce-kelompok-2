<?php
require '../includes/auth.php';
$u = need('mahasiswa');
$title = 'Home';
include '../includes/header.php';
$kat = q('SELECT * FROM categories');
$tenants = q("SELECT * FROM tenants WHERE status_verifikasi='terverifikasi' ORDER BY buka DESC, nama_tenant");
$icon = ['Makanan' => '🍛', 'Minuman' => '🥤', 'ATK' => '📚', 'Fotokopi' => '🖨️', 'Produk Mahasiswa' => '👕', 'Snack' => '🍟'];
?>
<div class="hero dark">
    <h1>Halo, <?= e($u['nama']) ?></h1>
    <p>Mau cari apa hari ini?</p>
    <form class="search" action="produk.php"><input name="q" placeholder="🔍 Cari makanan, minuman, atau kebutuhan kampus"><button class="btn out">Cari</button></form>
</div>
<h2>Kategori</h2>
<div class="chips"><?php foreach ($kat as $k) {
                        $href = $k['nama_kategori'] === 'Fotokopi' ? 'print.php' : 'produk.php?k=' . $k['id_kategori'];
                        echo '<a class="chip" href="' . $href . '">' . ($icon[$k['nama_kategori']] ?? '🛍️') . ' ' . e($k['nama_kategori']) . '</a>';
                    } ?></div>
<h2>Tenant Tersedia</h2>
<div class="grid"><?php foreach ($tenants as $t) echo tenant_card($t); ?></div>
<?php include '../includes/footer.php';
