<?php
require '../includes/auth.php'; need('admin');
$tot = one("SELECT COUNT(*) n, COALESCE(SUM(total),0) s FROM orders WHERE status='selesai'");
$per = q("SELECT t.nama_tenant, COUNT(o.id_order) n, COALESCE(SUM(o.total),0) s FROM tenants t LEFT JOIN orders o ON o.id_tenant=t.id_tenant AND o.status='selesai' GROUP BY t.id_tenant ORDER BY s DESC");
$hari = q("SELECT DATE(created_at) d, COUNT(*) n, COALESCE(SUM(CASE WHEN status<>'dibatalkan' THEN total END),0) s FROM orders WHERE created_at>=CURDATE()-INTERVAL 6 DAY GROUP BY DATE(created_at) ORDER BY d DESC");
$top = q("SELECT p.nama_produk, SUM(d.jumlah) j FROM order_details d JOIN products p USING(id_produk) JOIN orders o USING(id_order) WHERE o.status<>'dibatalkan' GROUP BY p.id_produk ORDER BY j DESC LIMIT 5");
$title = 'Laporan'; include '../includes/header.php'; ?>
<h1>Laporan Sederhana</h1>
<div class="stats"><div class="stat"><b><?= $tot['n'] ?></b><span>Transaksi Selesai</span></div><div class="stat"><b><?= rp($tot['s']) ?></b><span>Total Nilai Transaksi</span></div></div>
<h2>Per Tenant (pesanan selesai)</h2><div class="scroll"><table class="tbl"><tr><th>Tenant</th><th>Pesanan</th><th>Nilai</th></tr>
<?php foreach ($per as $r) echo '<tr><td>' . e($r['nama_tenant']) . '</td><td>' . $r['n'] . '</td><td>' . rp($r['s']) . '</td></tr>'; ?></table></div>
<h2>7 Hari Terakhir</h2><div class="scroll"><table class="tbl"><tr><th>Tanggal</th><th>Pesanan</th><th>Nilai (tanpa batal)</th></tr>
<?php foreach ($hari as $r) echo '<tr><td>' . e($r['d']) . '</td><td>' . $r['n'] . '</td><td>' . rp($r['s']) . '</td></tr>'; ?></table></div>
<h2>Produk Terlaris</h2><div class="scroll"><table class="tbl"><tr><th>Produk</th><th>Terjual</th></tr>
<?php foreach ($top as $r) echo '<tr><td>' . e($r['nama_produk']) . '</td><td>' . $r['j'] . '</td></tr>'; ?></table></div>
<?php include '../includes/footer.php';
