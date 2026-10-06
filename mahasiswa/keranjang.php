<?php
require '../includes/auth.php'; need('mahasiswa');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = $_POST['aksi'] ?? ''; $id = (int)($_POST['id'] ?? 0); $n = max(0, (int)($_POST['jumlah'] ?? 1));
    if ($a === 'tambah') {
        $p = one("SELECT p.*,t.buka,t.status_verifikasi FROM products p JOIN tenants t USING(id_tenant) WHERE p.id_produk=? AND p.status='aktif'", 'i', $id);
        if (!$p || $p['stok'] < 1 || $p['status_verifikasi'] !== 'terverifikasi' || !$p['buka']) flash('Produk tidak tersedia.');
        elseif (isset($_SESSION['cart']) && $_SESSION['cart']['tenant'] != $p['id_tenant'])
            flash('Keranjang berisi produk dari tenant lain. Satu checkout hanya untuk satu tenant — kosongkan keranjang dulu.');
        else {
            $_SESSION['cart']['tenant'] = $p['id_tenant'];
            $now = $_SESSION['cart']['items'][$id] ?? 0;
            $_SESSION['cart']['items'][$id] = min($p['stok'], $now + max(1, $n));
            flash('Ditambahkan ke keranjang.');
        }
    } elseif ($a === 'ubah' && isset($_SESSION['cart']['items'][$id])) {
        $p = one('SELECT stok FROM products WHERE id_produk=?', 'i', $id);
        if ($n < 1) unset($_SESSION['cart']['items'][$id]); else $_SESSION['cart']['items'][$id] = min($n, (int)$p['stok']);
    } elseif ($a === 'hapus') unset($_SESSION['cart']['items'][$id]);
    elseif ($a === 'kosong') unset($_SESSION['cart']);
    if (isset($_SESSION['cart']) && !$_SESSION['cart']['items']) unset($_SESSION['cart']);
    redirect('/mahasiswa/keranjang.php');
}
$title = 'Keranjang'; include '../includes/header.php';
$cart = $_SESSION['cart'] ?? null; $rows = []; $sub = 0;
if ($cart) {
    $t = one('SELECT nama_tenant FROM tenants WHERE id_tenant=?', 'i', $cart['tenant']);
    foreach ($cart['items'] as $pid => $qty) { $p = one('SELECT * FROM products WHERE id_produk=?', 'i', $pid); if ($p) { $p['qty'] = $qty; $rows[] = $p; $sub += $p['harga'] * $qty; } }
}
?><h1>Keranjang</h1>
<?php if (!$rows) echo '<div class="box center">Keranjang kosong. <a href="tenant.php">Lihat tenant</a></div>'; else { ?>
<div class="box"><h3>🏪 <?= e($t['nama_tenant']) ?></h3>
<?php foreach ($rows as $p) { ?>
<div class="row between" style="border-bottom:1px solid #eee;padding:10px 0"><div><b><?= e($p['nama_produk']) ?></b><br><small><?= rp($p['harga']) ?></small></div>
<form method="post" class="row"><input type="hidden" name="aksi" value="ubah"><input type="hidden" name="id" value="<?= $p['id_produk'] ?>">
<div class="qty"><button type="button" data-step="-1">-</button><input type="number" name="jumlah" value="<?= $p['qty'] ?>" min="1" max="<?= $p['stok'] ?>"><button type="button" data-step="1">+</button></div>
<button class="btn sm out">Ubah</button></form>
<b><?= rp($p['harga'] * $p['qty']) ?></b>
<form method="post"><input type="hidden" name="aksi" value="hapus"><input type="hidden" name="id" value="<?= $p['id_produk'] ?>"><button class="btn sm red">Hapus</button></form></div>
<?php } ?>
<h3 class="row between"><span>Subtotal</span><span class="price"><?= rp($sub) ?></span></h3>
<form method="post" action="checkout.php"><label>Catatan (opsional)</label><textarea name="catatan" rows="2" placeholder="Tulis catatan untuk tenant..."></textarea><br>
<button class="btn block">Lanjut Checkout</button></form>
<form method="post"><input type="hidden" name="aksi" value="kosong"><button class="btn sm out">Kosongkan keranjang</button></form></div>
<?php } include '../includes/footer.php';
