<?php
require '../includes/auth.php'; need('tenant'); $t = my_tenant();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // hanya boleh mengubah pesanan milik tenant sendiri dan hanya ke status berikutnya
    $o = one('SELECT * FROM orders WHERE id_order=? AND id_tenant=?', 'ii', (int)$_POST['id'], $t['id_tenant']);
    if ($o && next_status($o['status']) === ($_POST['ke'] ?? '')) { q('UPDATE orders SET status=? WHERE id_order=?', 'si', $_POST['ke'], $o['id_order']); flash('Status diperbarui.'); }
    redirect('/tenant/pesanan.php');
}
$rows = q("SELECT o.*,MAX(u.nama) pembeli,GROUP_CONCAT(CONCAT(p.nama_produk,' x',d.jumlah) SEPARATOR ', ') items FROM orders o
 JOIN users u USING(id_user) JOIN order_details d USING(id_order) JOIN products p USING(id_produk)
 WHERE o.id_tenant=? GROUP BY o.id_order ORDER BY o.id_order DESC", 'i', $t['id_tenant']);
$title = 'Pesanan'; include '../includes/header.php'; ?>
<h1>Kelola Pesanan</h1><div class="scroll"><table class="tbl"><tr><th>No</th><th>Pembeli</th><th>Produk</th><th>Total</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
<?php foreach ($rows as $o) { $n = next_status($o['status']); ?><tr><td><?= nomor($o['id_order']) ?></td><td><?= e($o['pembeli']) ?></td>
<td><?= e($o['items']) ?><?= $o['catatan'] ? '<br><small>📝 ' . e($o['catatan']) . '</small>' : '' ?></td><td><?= rp($o['total']) ?></td><td><?= badge($o['status']) ?></td><td><?= e($o['created_at']) ?></td>
<td><?php if ($n) echo '<form method="post"><input type="hidden" name="id" value="' . $o['id_order'] . '"><input type="hidden" name="ke" value="' . $n . '"><button class="btn sm">' . next_label($n) . '</button></form>'; ?></td></tr><?php } ?></table></div>
<?php include '../includes/footer.php';
