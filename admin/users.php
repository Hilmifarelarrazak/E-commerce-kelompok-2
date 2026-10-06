<?php
require '../includes/auth.php'; need('admin');
$rows = q('SELECT * FROM users ORDER BY role, nama');
$title = 'Users'; include '../includes/header.php'; ?>
<h1>Data Pengguna</h1><div class="scroll"><table class="tbl"><tr><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Terdaftar</th></tr>
<?php foreach ($rows as $r) echo '<tr><td>' . e($r['nama']) . '</td><td>' . e($r['username']) . '</td><td>' . e($r['email']) . '</td><td>' . e($r['role']) . '</td><td>' . e($r['created_at']) . '</td></tr>'; ?></table></div>
<?php include '../includes/footer.php';
