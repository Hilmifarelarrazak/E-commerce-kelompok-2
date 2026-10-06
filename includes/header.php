<?php
// Header + navbar sesuai role. Set $title sebelum include.
$u = me();
$cnt = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']['items']) : 0;
$m = [
    'guest' => [['/index.php', 'Home'], ['/auth/login.php', 'Login'], ['/auth/register.php', 'Daftar']],
    'mahasiswa' => [
        ['/mahasiswa/dashboard.php', 'Home'],
        ['/mahasiswa/tenant.php', 'Tenant'],
        ['/mahasiswa/pesanan.php', 'Pesanan'],
        ['/mahasiswa/print.php', 'Fotokopi'],
        ['/mahasiswa/keranjang.php', "Keranjang ($cnt)"],
        ['/auth/logout.php', 'Logout']
    ],
    'tenant' => [
        ['/tenant/dashboard.php', 'Dashboard'],
        ['/tenant/produk.php', 'Produk'],
        ['/tenant/pesanan.php', 'Pesanan'],
        ['/tenant/profil.php', 'Profil'],
        ['/auth/logout.php', 'Logout']
    ],
    'fotokopi' => [
        ['/fotokopi/dashboard.php', 'Dashboard'],
        ['/fotokopi/layanan.php', 'Layanan'],
        ['/fotokopi/profil.php', 'Profil'],
        ['/auth/logout.php', 'Logout']
    ],
    'admin' => [
        ['/admin/dashboard.php', 'Dashboard'],
        ['/admin/users.php', 'Users'],
        ['/admin/tenant.php', 'Tenant'],
        ['/admin/kategori.php', 'Kategori'],
        ['/admin/laporan.php', 'Laporan'],
        ['/auth/logout.php', 'Logout']
    ],
][$u ? $u['role'] : 'guest'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= e($title ?? '') ?> - Dikampus Aja</title>
    <link rel="icon" type="image/svg+xml" href="<?= BASE ?>/assets/images/logo.svg">
    <link rel="alternate icon" type="image/png" href="<?= BASE ?>/assets/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE ?>/assets/css/style.css?v=<?= filemtime(__DIR__ . '/../assets/css/style.css') ?>">
</head>

<body>
    <header class="site-header">
        <nav class="nav">
            <div class="nav-container">
                <a class="brand" href="<?= BASE ?>/index.php">
                    <img src="<?= BASE ?>/assets/images/logo.svg" alt="Logo Dikampus Aja" class="brand-logo" width="36" height="36" style="height:36px;width:36px;object-fit:contain;border-radius:8px;" onerror="this.onerror=null;this.src='<?= BASE ?>/assets/images/logo.png';">
                    <span class="brand-name">DIKAMPUS AJA<?= $u && $u['role'] == 'admin' ? ' <span class="badge-role">ADMIN</span>' : '' ?></span>
                </a>
                <button class="nav-toggle" onclick="document.querySelector('.links').classList.toggle('open')" aria-label="Toggle Menu">☰</button>
                <div class="links">
                    <?php 
                    $last_i = count($m) - 1;
                    foreach ($m as $i => $x) {
                        $is_cta = ($u === null && $i === $last_i) || ($x[1] === 'Logout');
                        $cls = $is_cta ? ' class="nav-cta"' : '';
                        echo '<a href="' . BASE . $x[0] . '"' . $cls . '>' . e($x[1]) . '</a>'; 
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
    <main class="wrap">
        <?php if ($f = flash()) echo '<div class="alert">' . e($f) . '</div>'; ?>