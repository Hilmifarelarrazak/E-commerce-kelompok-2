<?php
require '../includes/auth.php';
$u = need('mahasiswa');
$layanan = q("SELECT l.*,t.nama_tenant FROM print_services l JOIN tenants t USING(id_tenant)
 WHERE l.aktif=1 AND t.jenis_tenant='Fotokopi/Print' AND t.status_verifikasi='terverifikasi' AND t.buka=1 ORDER BY t.nama_tenant,l.nama_layanan");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $l = one("SELECT l.* FROM print_services l JOIN tenants t USING(id_tenant)
     WHERE l.id_layanan=? AND l.aktif=1 AND t.status_verifikasi='terverifikasi' AND t.buka=1", 'i', (int)($_POST['layanan'] ?? 0));
    $n = (int)($_POST['jumlah'] ?? 0);
    $f = $_FILES['file'] ?? null;
    $ext = $f ? strtolower(pathinfo($f['name'], PATHINFO_EXTENSION)) : '';
    if (!$l || $n < 1 || $n > 500) flash('Data tidak valid.');
    elseif (!$f || $f['error'] !== UPLOAD_ERR_OK || $f['size'] > 5 * 1024 * 1024 || !in_array($ext, ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']))
        flash('Upload file PDF/DOC/DOCX/JPG/PNG maksimal 5MB.');
    else {
        $name = bin2hex(random_bytes(6)) . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $f['name']);
        move_uploaded_file($f['tmp_name'], '../uploads/dokumen/' . $name);
        q(
            'INSERT INTO print_orders(id_user,id_tenant,nama_file,jenis_layanan,jumlah,catatan,estimasi_harga) VALUES(?,?,?,?,?,?,?)',
            'iissisi',
            $u['id'],
            $l['id_tenant'],
            $name,
            $l['nama_layanan'],
            $n,
            substr(trim($_POST['catatan'] ?? ''), 0, 300),
            $l['harga'] * $n
        );
        flash('Dokumen terkirim. Bayar saat mengambil hasil.');
        redirect('/mahasiswa/pesanan.php');
    }
    redirect('/mahasiswa/print.php');
}
$title = 'Fotokopi & Print';
include '../includes/header.php'; ?>
<h1>🖨️ Fotokopi & Print</h1>
<div class="box narrow" style="margin:0 auto 20px"><?php if (!$layanan) echo 'Layanan fotokopi sedang tutup atau belum tersedia.';
                                                    else { ?>
        <form method="post" enctype="multipart/form-data">
            <label>Layanan</label><select name="layanan"><?php foreach ($layanan as $l) echo '<option value="' . $l['id_layanan'] . '">' . e($l['nama_layanan']) . ' (' . rp($l['harga']) . ') - ' . e($l['nama_tenant']) . '</option>'; ?></select>
            <label>Jumlah (lembar/unit)</label><input type="number" name="jumlah" value="1" min="1" max="500">
            <label>File dokumen</label><input type="file" name="file" required>
            <label>Catatan</label><textarea name="catatan" rows="2"></textarea><br>
            <button class="btn block">Kirim Pesanan Print</button>
        </form><?php } ?>
</div>
<?php include '../includes/footer.php';
