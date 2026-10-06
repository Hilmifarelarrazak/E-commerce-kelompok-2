<?php
require '../includes/auth.php'; need('tenant'); $t = my_tenant();
$p = one('SELECT * FROM products WHERE id_produk=? AND id_tenant=?', 'ii', (int)($_GET['id'] ?? 0), $t['id_tenant']); // hanya milik sendiri
if (!$p) { http_response_code(404); die('Produk tidak ditemukan.'); }
include '../includes/produk_form.php';
