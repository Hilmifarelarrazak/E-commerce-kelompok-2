<?php
// Unduh dokumen: hanya petugas fotokopi pemilik tenant yang bersangkutan
require '../includes/auth.php'; need('fotokopi'); $t = my_tenant();
$p = one('SELECT * FROM print_orders WHERE id_print=? AND id_tenant=?', 'ii', (int)($_GET['id'] ?? 0), $t['id_tenant']);
$path = $p ? __DIR__ . '/../uploads/dokumen/' . basename($p['nama_file']) : '';
if (!$p || !is_file($path)) { http_response_code(404); die('File tidak ditemukan.'); }
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($p['nama_file']) . '"');
readfile($path);
