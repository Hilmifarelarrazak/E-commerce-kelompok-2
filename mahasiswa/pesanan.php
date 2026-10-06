<?php
// Riwayat pesanan (produk + fotokopi) dan pembatalan (hanya saat Menunggu)
require '../includes/auth.php'; $u = need('mahasiswa');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'batal') {
    $id = (int)$_POST['id'];
    $db->begin_transaction();
    $o = one("SELECT * FROM orders WHERE id_order=? AND id_user=? AND status='menunggu' FOR UPDATE", 'ii', $id, $u['id']);
    if ($o) {
        q("UPDATE orders SET status='dibatalkan' WHERE id_order=?", 'i', $id);
        foreach (q('SELECT * FROM order_details WHERE id_order=?', 'i', $id) as $d)
            q('UPDATE products SET stok=stok+? WHERE id_produk=?', 'ii', $d['jumlah'], $d['id_produk']); // stok dikembalikan
        flash('Pesanan dibatalkan, stok dikembalikan.');
    } else flash('Pesanan tidak dapat dibatalkan.');
    $db->commit(); redirect('/mahasiswa/pesanan.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'batal_print') {
    q("UPDATE print_orders SET status='dibatalkan' WHERE id_print=? AND id_user=? AND status='menunggu'", 'ii', (int)$_POST['id'], $u['id']);
    flash('Pesanan fotokopi dibatalkan.'); redirect('/mahasiswa/pesanan.php');
}
$orders = q('SELECT o.*,t.nama_tenant FROM orders o JOIN tenants t USING(id_tenant) WHERE o.id_user=? ORDER BY o.id_order DESC', 'i', $u['id']);
$prints = q('SELECT p.*,t.nama_tenant FROM print_orders p JOIN tenants t USING(id_tenant) WHERE p.id_user=? ORDER BY p.id_print DESC', 'i', $u['id']);
$title = 'Pesanan'; include '../includes/header.php'; ?>
<h1>Pesanan Saya</h1>
<?php if (!$orders) echo '<div class="box">Belum ada pesanan.</div>'; foreach ($orders as $o) { ?>
<div class="box row between"><div><b><?= nomor($o['id_order']) ?></b> · <?= e($o['nama_tenant']) ?><br><small><?= e($o['created_at']) ?></small></div>
<div><?= rp($o['total']) ?> <?= badge($o['status']) ?></div>
<div class="row"><a class="btn sm out" href="status_pesanan.php?id=<?= $o['id_order'] ?>">Detail</a></div></div>
<?php } ?>
<h2>Pesanan Fotokopi / Print</h2>
<?php if (!$prints) echo '<div class="box">Belum ada pesanan fotokopi. <a href="print.php">Kirim dokumen</a></div>'; foreach ($prints as $p) { ?>
<div class="box row between"><div><b>PRN<?= str_pad($p['id_print'], 3, '0', STR_PAD_LEFT) ?></b> · <?= e($p['jenis_layanan']) ?> x<?= $p['jumlah'] ?><br><small><?= e($p['nama_tenant']) ?> · <?= e($p['created_at']) ?></small></div>
<div><?= rp($p['estimasi_harga']) ?> <?= badge($p['status']) ?></div>
<?php if ($p['status'] === 'menunggu') echo '<form method="post"><input type="hidden" name="aksi" value="batal_print"><input type="hidden" name="id" value="' . $p['id_print'] . '"><button class="btn sm red">Batalkan</button></form>'; ?></div>
<?php } include '../includes/footer.php';
