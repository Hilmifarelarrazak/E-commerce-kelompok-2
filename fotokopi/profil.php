<?php
require '../includes/auth.php';
need('fotokopi');
$t = my_tenant();
if (!$t) die('Akun belum terhubung ke tenant.');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $foto = upload_img($_FILES['foto'] ?? null, 'tenant');
    if (!$nama) flash('Nama tenant wajib diisi.');
    elseif ($foto === false) flash('Foto harus JPG/PNG/WEBP, maksimal 2MB.');
    else {
        q(
            'UPDATE tenants SET nama_tenant=?,deskripsi=?,lokasi=?,buka=?,foto=COALESCE(?,foto) WHERE id_tenant=?',
            'sssisi',
            $nama,
            trim($_POST['deskripsi'] ?? ''),
            trim($_POST['lokasi'] ?? ''),
            isset($_POST['buka']) ? 1 : 0,
            $foto,
            $t['id_tenant']
        );
        flash('Profil disimpan.');
    }
    redirect('/fotokopi/profil.php');
}
$title = 'Profil Fotokopi';
include '../includes/header.php'; ?>
<div class="box narrow">
    <h2>Profil Fotokopi</h2>
    <div style="max-width:200px;margin-bottom:10px"><?= img('tenant', $t['foto'], '🖨️') ?></div>
    <form method="post" enctype="multipart/form-data">
        <label>Nama Tenant</label><input name="nama" value="<?= e($t['nama_tenant']) ?>" required>
        <label>Lokasi</label><input name="lokasi" value="<?= e($t['lokasi']) ?>">
        <label>Deskripsi</label><textarea name="deskripsi" rows="3"><?= e($t['deskripsi']) ?></textarea>
        <label><input type="checkbox" name="buka" style="width:auto" <?= $t['buka'] ? 'checked' : '' ?>> Sedang buka</label>
        <label>Ganti Foto/Logo</label><input type="file" name="foto" accept="image/*"><br><br>
        <button class="btn block">Simpan</button>
    </form>
</div>
<?php include '../includes/footer.php';
