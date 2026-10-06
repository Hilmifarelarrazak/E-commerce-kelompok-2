<?php
require '../includes/auth.php'; need('admin');
$c = function ($sql) { return one($sql)['c']; };
$title = 'Dashboard Admin'; include '../includes/header.php'; ?>
<h1>Admin Panel</h1>
<div class="stats"><div class="stat"><b><?= $c("SELECT COUNT(*) c FROM users WHERE role='mahasiswa'") ?></b><span>Total Mahasiswa</span></div>
<div class="stat"><b><?= $c('SELECT COUNT(*) c FROM tenants') ?></b><span>Total Tenant</span></div>
<div class="stat"><b><?= $c('SELECT COUNT(*) c FROM products') ?></b><span>Total Produk</span></div>
<div class="stat"><b><?= $c('SELECT COUNT(*) c FROM orders') ?></b><span>Total Pesanan</span></div></div>
<h2>Statistik</h2><div class="stats"><div class="stat"><b><?= $c('SELECT COUNT(*) c FROM orders WHERE DATE(created_at)=CURDATE()') ?></b><span>Pesanan Hari Ini</span></div>
<div class="stat"><b><?= $c("SELECT COUNT(*) c FROM orders WHERE status='selesai'") ?></b><span>Pesanan Selesai</span></div>
<div class="stat"><b><?= $c("SELECT COUNT(*) c FROM orders WHERE status='menunggu'") ?></b><span>Pesanan Menunggu</span></div>
<div class="stat"><b><?= $c("SELECT COUNT(*) c FROM tenants WHERE status_verifikasi='pending'") ?></b><span>Tenant Menunggu Verifikasi</span></div></div>
<?php include '../includes/footer.php';
