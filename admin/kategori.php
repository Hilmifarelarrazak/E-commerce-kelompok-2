<?php
require '../includes/auth.php'; need('admin');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = $_POST['aksi'] ?? ''; $nama = trim($_POST['nama'] ?? ''); $id = (int)($_POST['id'] ?? 0);
    if ($a === 'tambah' && $nama) q('INSERT INTO categories(nama_kategori) VALUES(?)', 's', $nama);
    elseif ($a === 'edit' && $nama) q('UPDATE categories SET nama_kategori=? WHERE id_kategori=?', 'si', $nama, $id);
    elseif ($a === 'hapus') q('DELETE FROM categories WHERE id_kategori=?', 'i', $id);
    flash('Kategori diperbarui.'); redirect('/admin/kategori.php');
}
$rows = q('SELECT * FROM categories ORDER BY nama_kategori');
$title = 'Kategori'; include '../includes/header.php'; ?>
<h1>Kategori</h1><form method="post" class="row box"><input type="hidden" name="aksi" value="tambah"><input name="nama" placeholder="Nama kategori baru" style="flex:1" required><button class="btn">Tambah</button></form>
<?php foreach ($rows as $k) { ?><form method="post" class="row box"><input type="hidden" name="id" value="<?= $k['id_kategori'] ?>"><input name="nama" value="<?= e($k['nama_kategori']) ?>" style="flex:1">
<button class="btn sm" name="aksi" value="edit">Simpan</button><button class="btn sm red" name="aksi" value="hapus" onclick="return confirm('Hapus kategori?')">Hapus</button></form><?php } ?>
<?php include '../includes/footer.php';
