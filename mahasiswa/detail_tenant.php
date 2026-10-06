<?php
require '../includes/auth.php';
need('mahasiswa');

$id = (int)($_GET['id'] ?? 0);
$t = one("SELECT * FROM tenants WHERE id_tenant=? AND status_verifikasi='terverifikasi'", 'i', $id);
if (!$t) {
    http_response_code(404);
    die('Tenant tidak ditemukan.');
}

$prod = q("SELECT * FROM products WHERE id_tenant=? AND status='aktif' ORDER BY nama_produk", 'i', $t['id_tenant']);
$title = $t['nama_tenant'];
include '../includes/header.php'; 
?>

<!-- Tombol Kembali -->
<a href="tenant.php" class="back-link">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="19" y1="12" x2="5" y2="12"></line>
        <polyline points="12 19 5 12 12 5"></polyline>
    </svg>
    Kembali ke Daftar Tenant
</a>

<!-- Kartu Utama Detail Tenant: Gambar di Atas, Keterangan Rapi di Bawah -->
<div class="tenant-detail-card">
    <div class="tenant-cover-wrap">
        <?= img('tenant', $t['foto'], '🏪') ?>
    </div>
    
    <div class="tenant-detail-body">
        <div class="tenant-header-row">
            <div class="tenant-title-wrap">
                <div class="tenant-title-row">
                    <h1><?= e($t['nama_tenant']) ?></h1>
                    <span class="badge terverifikasi">✓ Terverifikasi</span>
                </div>
                <div class="tenant-badges-row">
                    <span class="badge <?= $t['buka'] ? 'selesai' : 'dibatalkan' ?>">
                        <?= $t['buka'] ? '🟢 Buka' : '🔴 Tutup' ?>
                    </span>
                    <span class="badge" style="background: var(--bg-muted); color: var(--t);">
                        <?= e($t['jenis_tenant']) ?>
                    </span>
                </div>
            </div>

            <?php if ($t['jenis_tenant'] === 'Fotokopi/Print'): ?>
                <a class="btn" href="print.php">🖨️ Kirim Dokumen untuk Print</a>
            <?php endif; ?>
        </div>

        <div class="tenant-meta-grid">
            <div class="tenant-meta-item">
                <span class="icon">📍</span>
                <span><b>Lokasi:</b> <?= e($t['lokasi']) ?></span>
            </div>
            <div class="tenant-meta-item">
                <span class="icon">🍽️</span>
                <span><b>Katalog:</b> <?= count($prod) ?> Produk Tersedia</span>
            </div>
            <div class="tenant-meta-item">
                <span class="icon">⚡</span>
                <span><b>Layanan:</b> Pesan & Ambil Langsung Bebas Antre</span>
            </div>
        </div>

        <?php if (!empty($t['deskripsi'])): ?>
            <div class="tenant-description">
                <h4>Deskripsi & Keterangan</h4>
                <p><?= nl2br(e($t['deskripsi'])) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Daftar Produk / Menu Tenant -->
<div class="section-subhead">
    <div>
        <span class="eyebrow">KATALOG MENU</span>
        <h2>Menu & Produk Tersedia (<?= count($prod) ?>)</h2>
    </div>
</div>

<?php if (!$prod): ?>
    <div class="box center" style="padding: 48px 20px; color: var(--mut);">
        <p style="font-size: 1.05rem; margin: 0;">Belum ada produk aktif yang tersedia dari tenant ini saat ini.</p>
    </div>
<?php else: ?>
    <div class="grid">
        <?php foreach ($prod as $p): 
            $p['nama_tenant'] = $t['nama_tenant'];
            $is_disabled = ($p['stok'] < 1 || !$t['buka']);
            $btn_text = '+ Tambah ke Keranjang';
            if (!$t['buka']) {
                $btn_text = 'Tenant Tutup';
            } elseif ($p['stok'] < 1) {
                $btn_text = 'Stok Habis';
            }
        ?>
            <div>
                <?= produk_card($p) ?>
                <form method="post" action="keranjang.php" style="margin-top: 10px;">
                    <input type="hidden" name="aksi" value="tambah">
                    <input type="hidden" name="id" value="<?= $p['id_produk'] ?>">
                    <input type="hidden" name="jumlah" value="1">
                    <button class="btn sm block" <?= $is_disabled ? 'disabled' : '' ?>>
                        <?= $btn_text ?>
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
