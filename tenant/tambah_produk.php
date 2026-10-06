<?php
require '../includes/auth.php'; need('tenant'); $t = my_tenant(); $p = null;
if ($t['status_verifikasi'] !== 'terverifikasi') { flash('Tenant belum diverifikasi admin.'); redirect('/tenant/dashboard.php'); }
include '../includes/produk_form.php';
