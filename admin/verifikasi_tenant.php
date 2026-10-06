<?php
// Proses verifikasi / tolak tenant (dipanggil dari tenant.php)
require '../includes/auth.php'; need('admin');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s = ['verifikasi' => 'terverifikasi', 'tolak' => 'ditolak'][$_POST['aksi'] ?? ''] ?? null;
    if ($s) { q('UPDATE tenants SET status_verifikasi=? WHERE id_tenant=?', 'si', $s, (int)$_POST['id']); flash('Status tenant diperbarui.'); }
}
redirect('/admin/tenant.php');
