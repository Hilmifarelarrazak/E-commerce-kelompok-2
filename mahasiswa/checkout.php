<?php
require '../includes/auth.php'; $u = need('mahasiswa');
$cart = $_SESSION['cart'] ?? null;
if (!$cart) { flash('Keranjang kosong.'); redirect('/mahasiswa/keranjang.php'); }
$catatan = substr(trim($_POST['catatan'] ?? ''), 0, 300);
$t = one("SELECT * FROM tenants WHERE id_tenant=? AND status_verifikasi='terverifikasi'", 'i', $cart['tenant']);
if (!$t || !$t['buka']) { flash('Tenant sedang tutup / tidak tersedia.'); redirect('/mahasiswa/keranjang.php'); }

if (($_POST['aksi'] ?? '') === 'buat') {
    $db->begin_transaction();
    try {
        $total = 0; $rows = [];
        foreach ($cart['items'] as $pid => $qty) {
            // FOR UPDATE: kunci baris agar stok tidak bentrok antar pembeli
            $p = one("SELECT * FROM products WHERE id_produk=? AND id_tenant=? AND status='aktif' FOR UPDATE", 'ii', $pid, $cart['tenant']);
            if (!$p || $p['stok'] < $qty) throw new Exception('Stok ' . ($p['nama_produk'] ?? 'produk') . ' tidak mencukupi.');
            $rows[] = [$p, $qty]; $total += $p['harga'] * $qty;
        }
        $oid = q("INSERT INTO orders(id_user,id_tenant,total,catatan,status) VALUES(?,?,?,?,'menunggu')", 'iiis', $u['id'], $cart['tenant'], $total, $catatan);
        foreach ($rows as [$p, $qty]) {
            q('INSERT INTO order_details(id_order,id_produk,jumlah,harga,subtotal) VALUES(?,?,?,?,?)', 'iiiii', $oid, $p['id_produk'], $qty, $p['harga'], $p['harga'] * $qty);
            q('UPDATE products SET stok=stok-? WHERE id_produk=?', 'ii', $qty, $p['id_produk']); // stok berkurang
        }
        $db->commit(); unset($_SESSION['cart']);
        redirect('/mahasiswa/status_pesanan.php?id=' . $oid . '&baru=1');
    } catch (Exception $ex) { $db->rollback(); flash($ex->getMessage()); redirect('/mahasiswa/keranjang.php'); }
}
$total = 0; $rows = [];
foreach ($cart['items'] as $pid => $qty) { $p = one('SELECT * FROM products WHERE id_produk=?', 'i', $pid); $rows[] = [$p, $qty]; $total += $p['harga'] * $qty; }
$title = 'Checkout'; include '../includes/header.php'; ?>
<h1>Checkout</h1><div class="box"><p><b>Tenant:</b> <?= e($t['nama_tenant']) ?> · <?= e($t['lokasi']) ?></p>
<?php foreach ($rows as [$p, $qty]) echo '<div class="row between"><span>' . e($p['nama_produk']) . ' x' . $qty . '</span><span>' . rp($p['harga'] * $qty) . '</span></div>'; ?>
<h3 class="row between"><span>Total</span><span class="price"><?= rp($total) ?></span></h3>
<p><b>Catatan:</b> <?= e($catatan ?: '-') ?></p><p><b>Metode pembayaran:</b> Bayar saat mengambil pesanan</p>
<form method="post"><input type="hidden" name="aksi" value="buat"><input type="hidden" name="catatan" value="<?= e($catatan) ?>"><button class="btn block">Buat Pesanan</button></form></div>
<?php include '../includes/footer.php';
