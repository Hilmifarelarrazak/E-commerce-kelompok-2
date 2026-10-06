<?php
require '../includes/auth.php';
need('fotokopi');
$t = my_tenant();
if (!$t) die('Akun belum terhubung ke tenant.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $o = one('SELECT * FROM print_orders WHERE id_print=? AND id_tenant=?', 'ii', (int)$_POST['id'], $t['id_tenant']);
    if ($o && ($_POST['aksi'] ?? '') === 'harga' && !in_array($o['status'], ['selesai', 'dibatalkan']))
        q('UPDATE print_orders SET estimasi_harga=? WHERE id_print=?', 'ii', max(0, (int)$_POST['harga']), $o['id_print']);
    elseif ($o && ($_POST['aksi'] ?? '') === 'status' && next_status($o['status']) === ($_POST['ke'] ?? ''))
        q('UPDATE print_orders SET status=? WHERE id_print=?', 'si', $_POST['ke'], $o['id_print']);
    redirect('/fotokopi/dashboard.php');
}

// Jumlah pesanan print per status (satu query)
$hitung = [];
foreach (q('SELECT status, COUNT(*) AS c FROM print_orders WHERE id_tenant=? GROUP BY status', 'i', $t['id_tenant']) as $r) {
    $hitung[$r['status']] = (int)$r['c'];
}

$rows = q('SELECT p.*,u.nama FROM print_orders p JOIN users u USING(id_user) WHERE p.id_tenant=? ORDER BY p.id_print DESC', 'i', $t['id_tenant']);
$title = 'Dashboard Fotokopi';
include '../includes/header.php'; ?>
<h1>Dashboard <?= e($t['nama_tenant']) ?></h1>
<div class="stats">
    <div class="stat"><b><?= $hitung['menunggu'] ?? 0 ?></b><span>Baru</span></div>
    <div class="stat"><b><?= $hitung['diproses'] ?? 0 ?></b><span>Diproses</span></div>
    <div class="stat"><b><?= $hitung['siap_diambil'] ?? 0 ?></b><span>Siap Diambil</span></div>
    <div class="stat"><b><?= $hitung['selesai'] ?? 0 ?></b><span>Selesai</span></div>
</div>
<div class="scroll">
    <table class="tbl">
        <tr>
            <th>No</th>
            <th>Pemesan</th>
            <th>Layanan</th>
            <th>File</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($rows as $p) {
            $n = next_status($p['status']); ?><tr>
                <td>PRN<?= str_pad($p['id_print'], 3, '0', STR_PAD_LEFT) ?></td>
                <td><?= e($p['nama']) ?></td>
                <td><?= e($p['jenis_layanan']) ?> x<?= $p['jumlah'] ?><?= $p['catatan'] ? '<br><small>📝 ' . e($p['catatan']) . '</small>' : '' ?></td>
                <td><a href="unduh.php?id=<?= $p['id_print'] ?>">Unduh</a></td>
                <td>
                    <form method="post" class="row"><input type="hidden" name="aksi" value="harga"><input type="hidden" name="id" value="<?= $p['id_print'] ?>"><input type="number" name="harga" value="<?= $p['estimasi_harga'] ?>" style="width:90px"><button class="btn sm out">OK</button></form>
                </td>
                <td><?= badge($p['status']) ?></td>
                <td><?php if ($n) echo '<form method="post"><input type="hidden" name="aksi" value="status"><input type="hidden" name="id" value="' . $p['id_print'] . '"><input type="hidden" name="ke" value="' . $n . '"><button class="btn sm">' . next_label($n) . '</button></form>'; ?></td>
            </tr><?php } ?>
    </table>
</div>
<?php include '../includes/footer.php';
