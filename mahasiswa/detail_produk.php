<?php
require '../includes/auth.php'; need('mahasiswa');
$p = one("SELECT p.*,t.nama_tenant,t.buka,k.nama_kategori FROM products p JOIN tenants t USING(id_tenant) LEFT JOIN categories k USING(id_kategori)
 WHERE p.id_produk=? AND p.status='aktif' AND t.status_verifikasi='terverifikasi'", 'i', (int)($_GET['id'] ?? 0));
if (!$p) { http_response_code(404); die('Produk tidak ditemukan.'); }
$title = $p['nama_produk']; include '../includes/header.php'; $ok = $p['stok'] > 0 && $p['buka']; ?>
<a href="detail_tenant.php?id=<?= $p['id_tenant'] ?>">← Kembali</a>
<div class="box two"><div><?= img('produk', $p['foto']) ?></div><div>
<h1><?= e($p['nama_produk']) ?></h1><small><?= e($p['nama_tenant']) ?> · <?= e($p['nama_kategori']) ?></small>
<h2 class="price"><?= rp($p['harga']) ?></h2>
<?= $p['stok'] > 0 ? '<span class="badge selesai">Stok tersedia (' . (int)$p['stok'] . ')</span>' : '<span class="badge dibatalkan">HABIS</span>' ?>
<?= $p['buka'] ? '' : '<span class="badge dibatalkan">Tenant tutup</span>' ?>
<p><b>Deskripsi:</b><br><?= e($p['deskripsi']) ?></p>
<form method="post" action="keranjang.php"><input type="hidden" name="aksi" value="tambah"><input type="hidden" name="id" value="<?= $p['id_produk'] ?>">
<div class="qty"><button type="button" data-step="-1">-</button><input type="number" name="jumlah" value="1" min="1" max="<?= $p['stok'] ?>"><button type="button" data-step="1">+</button></div><br><br>
<button class="btn block" <?= $ok ? '' : 'disabled' ?>>Tambah ke Keranjang</button></form></div></div>
<?php include '../includes/footer.php';
