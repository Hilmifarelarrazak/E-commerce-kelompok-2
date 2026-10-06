<?php
require '../includes/auth.php'; need('admin');
$rows = q('SELECT t.*,u.nama pemilik FROM tenants t JOIN users u USING(id_user) ORDER BY FIELD(t.status_verifikasi,"pending","terverifikasi","ditolak"),t.nama_tenant');
$title = 'Tenant'; include '../includes/header.php'; ?>
<h1>Verifikasi Tenant</h1><div class="scroll"><table class="tbl"><tr><th>Nama Tenant</th><th>Pemilik</th><th>Jenis</th><th>Lokasi</th><th>Status</th><th>Aksi</th></tr>
<?php foreach ($rows as $t) { ?><tr><td><?= e($t['nama_tenant']) ?></td><td><?= e($t['pemilik']) ?></td><td><?= e($t['jenis_tenant']) ?></td><td><?= e($t['lokasi']) ?></td><td><?= badge($t['status_verifikasi']) ?></td>
<td><form method="post" action="verifikasi_tenant.php" class="row"><input type="hidden" name="id" value="<?= $t['id_tenant'] ?>">
<?php if ($t['status_verifikasi'] !== 'terverifikasi') echo '<button class="btn sm" name="aksi" value="verifikasi">Verifikasi</button>';
if ($t['status_verifikasi'] !== 'ditolak') echo '<button class="btn sm red" name="aksi" value="tolak">Tolak</button>'; ?></form></td></tr><?php } ?></table></div>
<?php include '../includes/footer.php';
