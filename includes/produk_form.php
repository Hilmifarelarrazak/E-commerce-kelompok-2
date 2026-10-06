<?php
// Form tambah/edit produk (dipakai tambah_produk.php & edit_produk.php). Butuh $t (tenant) dan $p (produk atau null).
$kat = q('SELECT * FROM categories ORDER BY nama_kategori'); $err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? ''); $harga = (int)($_POST['harga'] ?? -1); $stok = (int)($_POST['stok'] ?? -1);
    $kid = (int)($_POST['kategori'] ?? 0) ?: null; $desk = trim($_POST['deskripsi'] ?? '');
    $st = ($_POST['status'] ?? 'aktif') === 'nonaktif' ? 'nonaktif' : 'aktif';
    $foto = upload_img($_FILES['foto'] ?? null, 'produk');
    if (!$nama || $harga < 0 || $stok < 0) $err = 'Nama wajib diisi, harga dan stok tidak boleh negatif.';
    elseif ($foto === false) $err = 'Foto harus JPG/PNG/WEBP, maksimal 2MB.';
    else {
        if ($p) q('UPDATE products SET id_kategori=?,nama_produk=?,deskripsi=?,harga=?,stok=?,status=?,foto=COALESCE(?,foto) WHERE id_produk=? AND id_tenant=?',
            'issiissii', $kid, $nama, $desk, $harga, $stok, $st, $foto, $p['id_produk'], $t['id_tenant']);
        else q('INSERT INTO products(id_tenant,id_kategori,nama_produk,deskripsi,harga,stok,foto,status) VALUES(?,?,?,?,?,?,?,?)',
            'iissiiss', $t['id_tenant'], $kid, $nama, $desk, $harga, $stok, $foto, $st);
        flash('Produk disimpan.'); redirect('/tenant/produk.php');
    }
}
$v = $p ?: ['nama_produk' => '', 'harga' => '', 'stok' => '', 'id_kategori' => 0, 'deskripsi' => '', 'status' => 'aktif'];
$title = $p ? 'Edit Produk' : 'Tambah Produk'; include __DIR__ . '/header.php'; ?>
<div class="box narrow"><h2><?= e($title) ?></h2><?php if ($err) echo '<div class="alert">' . e($err) . '</div>'; ?>
<form method="post" enctype="multipart/form-data">
<label>Nama Produk</label><input name="nama" value="<?= e($v['nama_produk']) ?>" required>
<label>Harga (Rp)</label><input type="number" name="harga" min="0" value="<?= e($v['harga']) ?>" required>
<label>Stok</label><input type="number" name="stok" min="0" value="<?= e($v['stok']) ?>" required>
<label>Kategori</label><select name="kategori"><?php foreach ($kat as $k) echo '<option value="' . $k['id_kategori'] . '"' . ($k['id_kategori'] == $v['id_kategori'] ? ' selected' : '') . '>' . e($k['nama_kategori']) . '</option>'; ?></select>
<label>Deskripsi</label><textarea name="deskripsi" rows="3"><?= e($v['deskripsi']) ?></textarea>
<label>Status</label><select name="status"><option value="aktif">Aktif</option><option value="nonaktif"<?= $v['status'] === 'nonaktif' ? ' selected' : '' ?>>Nonaktif</option></select>
<label>Foto Produk</label><input type="file" name="foto" accept="image/*"><br><br>
<button class="btn block">Simpan Produk</button></form></div>
<?php include __DIR__ . '/footer.php';
