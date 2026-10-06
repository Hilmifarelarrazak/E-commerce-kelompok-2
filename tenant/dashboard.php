<?php
require '../includes/auth.php';
need('tenant');

$t = my_tenant();
if (!$t) {
    die('Data tenant tidak ditemukan.');
}
$id = (int) $t['id_tenant'];

// Total produk
$np = (int) (one('SELECT COUNT(*) AS c FROM products WHERE id_tenant = ?', 'i', $id)['c'] ?? 0);

// Jumlah pesanan per status (satu query)
$hitung = [];
foreach (q('SELECT status, COUNT(*) AS c FROM orders WHERE id_tenant = ? GROUP BY status', 'i', $id) as $r) {
    $hitung[$r['status']] = (int) $r['c'];
}
$baru     = $hitung['menunggu'] ?? 0;
$diproses = $hitung['diproses'] ?? 0;
$selesai  = $hitung['selesai'] ?? 0;

// Pesanan terbaru
$last = q(
    'SELECT o.*, u.nama FROM orders o
     JOIN users u ON u.id_user = o.id_user
     WHERE o.id_tenant = ? ORDER BY o.id_order DESC LIMIT 5',
    'i',
    $id
);

$title = 'Dashboard';
include '../includes/header.php';
?>

<h1>Selamat datang, <?= e($t['nama_tenant']) ?></h1>

<?php if (($t['status_verifikasi'] ?? '') !== 'terverifikasi'): ?>
    <div class="alert">
        Status tenant: <strong><?= e($t['status_verifikasi'] ?? 'belum diverifikasi') ?></strong>.
        Tenant belum bisa berjualan sampai diverifikasi oleh admin.
    </div>
<?php endif; ?>

<div class="stats">
    <div class="stat"><b><?= $np ?></b><span>Total Produk</span></div>
    <div class="stat"><b><?= $baru ?></b><span>Pesanan Baru</span></div>
    <div class="stat"><b><?= $diproses ?></b><span>Diproses</span></div>
    <div class="stat"><b><?= $selesai ?></b><span>Selesai</span></div>
</div>

<h2>Pesanan Terbaru</h2>
<div class="scroll">
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Pembeli</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($last)): ?>
                <?php foreach ($last as $o): ?>
                    <tr>
                        <td><?= nomor($o['id_order']) ?></td>
                        <td><?= e($o['nama']) ?></td>
                        <td><?= rp($o['total']) ?></td>
                        <td><?= badge($o['status']) ?></td>
                        <td><?= e($o['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Belum ada pesanan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>