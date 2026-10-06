<?php
require '../includes/auth.php'; $u = need('mahasiswa');
$o = one('SELECT o.*,t.nama_tenant FROM orders o JOIN tenants t USING(id_tenant) WHERE o.id_order=? AND o.id_user=?', 'ii', (int)($_GET['id'] ?? 0), $u['id']);
if (!$o) { http_response_code(404); die('Pesanan tidak ditemukan.'); }
$items = q('SELECT d.*,p.nama_produk FROM order_details d JOIN products p USING(id_produk) WHERE d.id_order=?', 'i', $o['id_order']);
$steps = ['menunggu' => 'Pesanan dibuat (Menunggu)', 'diproses' => 'Pesanan diproses', 'siap_diambil' => 'Siap diambil', 'selesai' => 'Selesai'];
$idx = array_search($o['status'], array_keys($steps));
$title = 'Status Pesanan'; include '../includes/header.php'; ?>
<?php if (isset($_GET['baru'])) echo '<div class="box center"><div class="big">✅</div><h2>Pesanan berhasil dibuat!</h2><p>Nomor Pesanan: <b>' . nomor($o['id_order']) . '</b><br>Status: Menunggu<br>Silakan menunggu pesanan diproses oleh tenant.</p></div>'; ?>
<a href="pesanan.php">← Kembali</a><h1>Status Pesanan <?= nomor($o['id_order']) ?></h1>
<div class="box"><p><?= e($o['nama_tenant']) ?> · <?= e($o['created_at']) ?> · <?= badge($o['status']) ?></p>
<?php if ($o['status'] === 'dibatalkan') echo '<p>❌ Pesanan dibatalkan.</p>'; else { echo '<ul class="tl">'; $i = 0;
foreach ($steps as $s) { echo '<li class="' . ($i <= $idx ? 'done' : '') . '">' . e($s) . '</li>'; $i++; } echo '</ul>'; } ?>
<?php foreach ($items as $d) echo '<div class="row between"><span>' . e($d['nama_produk']) . ' x' . $d['jumlah'] . '</span><span>' . rp($d['subtotal']) . '</span></div>'; ?>
<h3 class="row between"><span>Total</span><span class="price"><?= rp($o['total']) ?></span></h3>
<p><small>Catatan: <?= e($o['catatan'] ?: '-') ?> · Bayar saat mengambil pesanan</small></p>
<?php if ($o['status'] === 'menunggu') echo '<form method="post" action="pesanan.php" onsubmit="return confirm(\'Batalkan pesanan?\')"><input type="hidden" name="aksi" value="batal"><input type="hidden" name="id" value="' . $o['id_order'] . '"><button class="btn red">Batalkan Pesanan</button></form>'; ?></div>
<?php include '../includes/footer.php';
