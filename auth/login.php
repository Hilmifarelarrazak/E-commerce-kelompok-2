<?php
require '../includes/auth.php';
if (me()) redirect(home_of(me()['role']));
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = one('SELECT * FROM users WHERE email=?', 's', trim($_POST['email'] ?? ''));
    if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $u['id_user'], 'nama' => $u['nama'], 'role' => $u['role']];
        redirect(home_of($u['role']));
    }
    $err = 'Email atau password salah.';
}
$title = 'Login'; 
include '../includes/header.php'; 
?>

<div class="box narrow">
    <div class="center" style="margin-bottom: 20px;">
        <img src="<?= BASE ?>/assets/images/logo.svg" alt="Logo Dikampus Aja" style="height: 48px; width: 48px; border-radius: 12px; margin-bottom: 8px;" onerror="this.onerror=null;this.src='<?= BASE ?>/assets/images/logo.png';">
        <h1 style="font-size: 2.1rem; margin: 0;">Dikampus Aja</h1>
        <span class="eyebrow" style="margin-top: 6px;">Kebutuhan kampus? Dikampus Aja.</span>
    </div>

    <h2 style="font-size: 1.5rem; margin-bottom: 16px;">Masuk ke Akun</h2>
    <?php if ($err) echo '<div class="alert">' . e($err) . '</div>'; ?>
    
    <form method="post">
        <label>Alamat Email</label>
        <input type="email" name="email" required placeholder="nama@mahasiswa.ac.id" autocomplete="email">
        
        <label>Password</label>
        <input type="password" name="password" required placeholder="Masukkan kata sandi" autocomplete="current-password">
        
        <br><br>
        <button class="btn block">Masuk Sekarang</button>
    </form>

    <p class="center" style="margin-top: 24px; font-size: 0.92rem; color: var(--mut);">
        Belum punya akun? <a href="register.php" style="font-weight: 600; text-decoration: underline;">Daftar gratis</a>
    </p>
    
    <div style="background: var(--bg-warm); border: 1px solid var(--border); border-radius: 12px; padding: 12px 14px; margin-top: 20px; font-size: 0.82rem; color: var(--mut); text-align: center;">
        <b>Akun Demo:</b> mahasiswa@dikampusaja.com / mahasiswa123
    </div>
</div>

<?php include '../includes/footer.php'; ?>
