<?php
session_start();
require_once __DIR__ . '/../config/database.php';
define('BASE', '/dikampus_aja');

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function rp($n) { return 'Rp' . number_format((int)$n, 0, ',', '.'); }
function nomor($id) { return '#ORD' . str_pad($id, 3, '0', STR_PAD_LEFT); }
function me() { return $_SESSION['user'] ?? null; }
function redirect($p) { header('Location: ' . BASE . $p); exit; }
function flash($m = null) {
    if ($m !== null) { $_SESSION['flash'] = $m; return; }
    $f = $_SESSION['flash'] ?? ''; unset($_SESSION['flash']); return $f;
}
function home_of($role) {
    return ['mahasiswa' => '/mahasiswa/dashboard.php', 'tenant' => '/tenant/dashboard.php',
            'fotokopi' => '/fotokopi/dashboard.php', 'admin' => '/admin/dashboard.php'][$role];
}
// need(): wajib login dan role sesuai (role-based access)
function need($roles) {
    $u = me();
    if (!$u) redirect('/auth/login.php');
    if (!in_array($u['role'], (array)$roles)) { http_response_code(403); die('Akses ditolak.'); }
    return $u;
}
function my_tenant() { return one('SELECT * FROM tenants WHERE id_user=?', 'i', me()['id']); }
function badge($s) { return '<span class="badge ' . e($s) . '">' . e(ucwords(str_replace('_', ' ', $s))) . '</span>'; }
function next_status($s) { return ['menunggu' => 'diproses', 'diproses' => 'siap_diambil', 'siap_diambil' => 'selesai'][$s] ?? null; }
function next_label($s) { return ['diproses' => 'Proses', 'siap_diambil' => 'Siap Diambil', 'selesai' => 'Selesai'][$s] ?? ''; }

// Upload gambar aman: cek ukuran (maks 2MB), tipe asli gambar, ekstensi
function upload_img($f, $dir) {
    if (!isset($f) || $f['error'] !== UPLOAD_ERR_OK) return null;
    if ($f['size'] > 2 * 1024 * 1024 || !@getimagesize($f['tmp_name'])) return false;
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) return false;
    $name = bin2hex(random_bytes(8)) . '.' . $ext;
    return move_uploaded_file($f['tmp_name'], __DIR__ . "/../uploads/$dir/$name") ? $name : false;
}
function img($dir, $f, $emoji = '🍽️') {
    return $f ? '<img src="' . BASE . '/uploads/' . $dir . '/' . e($f) . '" alt="">' : '<div class="ph">' . $emoji . '</div>';
}
function tenant_card($t) {
    return '<a class="card" href="' . BASE . '/mahasiswa/detail_tenant.php?id=' . $t['id_tenant'] . '">' . img('tenant', $t['foto'], '🏪') .
        '<div class="cb"><b>' . e($t['nama_tenant']) . '</b><small>' . e($t['jenis_tenant']) . ' · ' . e($t['lokasi']) . '</small>' .
        ($t['buka'] ? '<span class="badge selesai">Buka</span>' : '<span class="badge dibatalkan">Tutup</span>') . '</div></a>';
}
function produk_card($p) {
    return '<a class="card" href="' . BASE . '/mahasiswa/detail_produk.php?id=' . $p['id_produk'] . '">' . img('produk', $p['foto']) .
        '<div class="cb"><b>' . e($p['nama_produk']) . '</b><small>' . e($p['nama_tenant'] ?? '') . '</small><span class="price">' . rp($p['harga']) . '</span>' .
        ($p['stok'] > 0 ? '<small>Stok ' . (int)$p['stok'] . '</small>' : '<span class="badge dibatalkan">HABIS</span>') . '</div></a>';
}
