<?php
require '../includes/auth.php';
need('fotokopi');
$t = my_tenant();
if (!$t) die('Akun belum terhubung ke tenant.');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = $_POST['aksi'] ?? '';
    $id = (int)($_POST['id'] ?? 0);
    $nama = trim($_POST['nama'] ?? '');
    $harga = (int)($_POST['harga'] ?? -1);
    $aktif = isset($_POST['aktif']) ? 1 : 0;
    if ($a === 'tambah' && $nama && $harga >= 0)
        q('INSERT INTO print_services(id_tenant,nama_layanan,harga) VALUES(?,?,?)', 'isi', $t['id_tenant'], $nama, $harga);
    elseif ($a === 'edit' && $nama && $harga >= 0)
        q('UPDATE print_services SET nama_layanan=?,harga=?,aktif=? WHERE id_layanan=? AND id_tenant=?', 'siiii', $nama, $harga, $aktif, $id, $t['id_tenant']);
    elseif ($a === 'hapus')
        q('DELETE FROM print_services WHERE id_layanan=? AND id_tenant=?', 'ii', $id, $t['id_tenant']);
    else {
        flash('Data tidak valid.');
        redirect('/fotokopi/layanan.php');
    }
    flash('Layanan diperbarui.');
    redirect('/fotokopi/layanan.php');
}
$rows = q('SELECT * FROM print_services WHERE id_tenant=? ORDER BY nama_layanan', 'i', $t['id_tenant']);
$title = 'Layanan';
include '../includes/header.php'; ?>
<h1>Layanan & Harga</h1>
<form method="post" class="row box"><input type="hidden" name="aksi" value="tambah">
    <input name="nama" placeholder="Nama layanan baru" style="flex:2" required><input type="number" name="harga" min="0" placeholder="Harga (Rp)" style="flex:1" required><button class="btn">Tambah</button>
</form>
<?php foreach ($rows as $l) { ?>
    <form method="post" class="row box"><input type="hidden" name="id" value="<?= $l['id_layanan'] ?>">
        <input name="nama" value="<?= e($l['nama_layanan']) ?>" style="flex:2"><input type="number" name="harga" min="0" value="<?= $l['harga'] ?>" style="flex:1">
        <label style="margin:0"><input type="checkbox" name="aktif" style="width:auto" <?= $l['aktif'] ? 'checked' : '' ?>> Aktif</label>
        <button class="btn sm" name="aksi" value="edit">Simpan</button>
        <button class="btn sm red" name="aksi" value="hapus" onclick="return confirm('Hapus layanan?')">Hapus</button>
    </form>
<?php }
include '../includes/footer.php';
