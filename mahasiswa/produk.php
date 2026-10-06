<?php
require '../includes/auth.php'; need('mahasiswa');
$qs = trim($_GET['q'] ?? ''); $k = (int)($_GET['k'] ?? 0); $like = '%' . $qs . '%';
$sql = "SELECT p.*,t.nama_tenant FROM products p JOIN tenants t USING(id_tenant) LEFT JOIN categories c USING(id_kategori)
 WHERE p.status='aktif' AND t.status_verifikasi='terverifikasi' AND (p.nama_produk LIKE ? OR t.nama_tenant LIKE ? OR c.nama_kategori LIKE ?)";
$types = 'sss'; $par = [$like, $like, $like];
if ($k) { $sql .= ' AND p.id_kategori=?'; $types .= 'i'; $par[] = $k; }
$prod = q($sql . ' ORDER BY p.nama_produk', $types, ...$par);
$tn = $qs ? q("SELECT * FROM tenants WHERE status_verifikasi='terverifikasi' AND nama_tenant LIKE ?", 's', $like) : [];
$title = 'Produk'; include '../includes/header.php'; ?>
<form class="search" style="max-width:100%"><input name="q" value="<?= e($qs) ?>" placeholder="Cari produk, tenant, atau kategori"><button class="btn">Cari</button></form>
<?php if ($tn) { echo '<h2>Tenant</h2><div class="grid">'; foreach ($tn as $t) echo tenant_card($t); echo '</div>'; } ?>
<h2>Produk<?= $qs ? ' untuk "' . e($qs) . '"' : '' ?></h2>
<?php if (!$prod) echo '<p>Produk tidak ditemukan.</p>'; ?>
<div class="grid"><?php foreach ($prod as $p) echo produk_card($p); ?></div>
<?php include '../includes/footer.php';
