<?php
require '../includes/auth.php'; need('tenant'); $t = my_tenant();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    try { q('DELETE FROM products WHERE id_produk=? AND id_tenant=?', 'ii', $id, $t['id_tenant']); flash('Produk dihapus.'); }
    catch (mysqli_sql_exception $x) { // sudah pernah dipesan -> tidak boleh dihapus, nonaktifkan saja
        q("UPDATE products SET status='nonaktif' WHERE id_produk=? AND id_tenant=?", 'ii', $id, $t['id_tenant']);
        flash('Produk sudah pernah dipesan, jadi dinonaktifkan (tidak dihapus).');
    }
    redirect('/tenant/produk.php');
}
$prod = q('SELECT * FROM products WHERE id_tenant=? ORDER BY id_produk DESC', 'i', $t['id_tenant']);
$title = 'Produk'; include '../includes/header.php'; ?>
<div class="row between"><h1>Kelola Produk</h1><a class="btn" href="tambah_produk.php">+ Tambah Produk</a></div>
<div class="scroll"><table class="tbl"><tr><th>Nama</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr>
<?php foreach ($prod as $p) { ?><tr><td><?= e($p['nama_produk']) ?></td><td><?= rp($p['harga']) ?></td><td><?= $p['stok'] ?: 'HABIS' ?></td><td><?= badge($p['status'] === 'aktif' ? 'selesai' : 'dibatalkan') ?></td>
<td class="row"><a class="btn sm out" href="edit_produk.php?id=<?= $p['id_produk'] ?>">Edit</a>
<form method="post" onsubmit="return confirm('Hapus produk?')"><input type="hidden" name="id" value="<?= $p['id_produk'] ?>"><button class="btn sm red">Hapus</button></form></td></tr><?php } ?></table></div>
<?php include '../includes/footer.php';
