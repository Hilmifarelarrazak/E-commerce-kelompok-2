<?php
require '../includes/auth.php';
if (me()) redirect(home_of(me()['role']));
$err = ''; $v = $_POST;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($v['nama'] ?? ''); $un = trim($v['username'] ?? ''); $em = trim($v['email'] ?? '');
    $pw = $v['password'] ?? ''; $as = ($v['sebagai'] ?? '') === 'tenant' ? 'tenant' : 'mahasiswa';
    $nt = trim($v['nama_tenant'] ?? '');
    if (!$nama || !$un || !$em) $err = 'Semua kolom wajib diisi.';
    elseif (!filter_var($em, FILTER_VALIDATE_EMAIL)) $err = 'Format email tidak valid.';
    elseif (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $un)) $err = 'Username 3-30 karakter (huruf, angka, _).';
    elseif (strlen($pw) < 6) $err = 'Password minimal 6 karakter.';
    elseif ($pw !== ($v['konfirmasi'] ?? '')) $err = 'Konfirmasi password tidak sama.';
    elseif ($as === 'tenant' && !$nt) $err = 'Nama tenant wajib diisi.';
    elseif (one('SELECT 1 FROM users WHERE email=? OR username=?', 'ss', $em, $un)) $err = 'Email atau username sudah dipakai.';
    else {
        $id = q('INSERT INTO users(nama,username,email,password,role) VALUES(?,?,?,?,?)', 'sssss', $nama, $un, $em, password_hash($pw, PASSWORD_DEFAULT), $as);
        if ($as === 'tenant') {
            $jenis = in_array($v['jenis'] ?? '', ['Warung', 'Kantin', 'Usaha Mahasiswa']) ? $v['jenis'] : 'Warung';
            q('INSERT INTO tenants(id_user,nama_tenant,jenis_tenant) VALUES(?,?,?)', 'iss', $id, $nt, $jenis);
        }
        flash('Pendaftaran berhasil. ' . ($as === 'tenant' ? 'Tenant perlu diverifikasi admin sebelum berjualan. ' : '') . 'Silakan login.');
        redirect('/auth/login.php');
    }
}
$title = 'Daftar'; include '../includes/header.php'; ?>
<div class="box narrow">
    <div class="center" style="margin-bottom: 20px;">
        <img src="<?= BASE ?>/assets/images/logo.svg" alt="Logo Dikampus Aja" style="height: 48px; width: 48px; border-radius: 12px; margin-bottom: 8px;" onerror="this.onerror=null;this.src='<?= BASE ?>/assets/images/logo.png';">
        <h1 style="font-size: 2.1rem; margin: 0;">Dikampus Aja</h1>
        <span class="eyebrow" style="margin-top: 6px;">Buat Akun Baru</span>
    </div>
    <h2>Pendaftaran</h2>
    <?php if ($err) echo '<div class="alert">' . e($err) . '</div>'; ?>
<form method="post">
<label>Nama Lengkap</label><input name="nama" value="<?= e($v['nama'] ?? '') ?>" required>
<label>Username</label><input name="username" value="<?= e($v['username'] ?? '') ?>" required>
<label>Email</label><input type="email" name="email" value="<?= e($v['email'] ?? '') ?>" required>
<label>Password</label><input type="password" name="password" required placeholder="Minimal 6 karakter">
<label>Konfirmasi Password</label><input type="password" name="konfirmasi" required>
<label>Daftar sebagai</label><select name="sebagai" id="sb" onchange="document.getElementById('tn').style.display=this.value=='tenant'?'block':'none'">
<option value="mahasiswa">Mahasiswa (pembeli)</option><option value="tenant">Tenant (penjual)</option></select>
<div id="tn" style="display:none"><label>Nama Tenant</label><input name="nama_tenant" value="<?= e($v['nama_tenant'] ?? '') ?>">
<label>Jenis Tenant</label><select name="jenis"><option>Warung</option><option>Kantin</option><option>Usaha Mahasiswa</option></select></div>
<br><br><button class="btn block">Daftar</button></form>
<p class="center">Sudah punya akun? <a href="login.php">Login</a></p></div>
<?php include '../includes/footer.php';
