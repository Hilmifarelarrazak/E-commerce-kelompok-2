<?php
require '../includes/auth.php'; need('mahasiswa');
$title = 'Tenant'; include '../includes/header.php';
$tenants = q("SELECT * FROM tenants WHERE status_verifikasi='terverifikasi' ORDER BY nama_tenant");
?><h1>Semua Tenant</h1><div class="grid"><?php foreach ($tenants as $t) echo tenant_card($t); ?></div>
<?php include '../includes/footer.php';
