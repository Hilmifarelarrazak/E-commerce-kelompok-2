<?php
require 'includes/auth.php';
if (me()) redirect(home_of(me()['role']));
$title = 'Beranda';
include 'includes/header.php';

$kat = q('SELECT * FROM categories');
$tenants = q("SELECT * FROM tenants WHERE status_verifikasi='terverifikasi' LIMIT 4");
$produk = q("SELECT p.*,t.nama_tenant FROM products p JOIN tenants t USING(id_tenant) WHERE p.status='aktif' AND t.status_verifikasi='terverifikasi' ORDER BY p.id_produk DESC LIMIT 4");
?>

<!-- 1. Editorial Hero Section -->
<section class="hero-editorial">
    <div class="pill-tag">
        <span>Solusi Lengkap Kebutuhan Kampus — Kuliner, Cetak & ATK</span>
    </div>

    <h1 class="hero-title">
        Kebutuhan kampus?<br><em>Dikampus Aja.</em>
    </h1>

    <p class="hero-desc">
        Temukan kantin favorit, cetak berkas & skripsi tanpa antre, dan penuhi seluruh kebutuhan kuliahmu dalam satu ekosistem kampus terpadu.
    </p>

    <div class="hero-search-wrap">
        <form class="hero-search-box" action="<?= BASE ?>/mahasiswa/produk.php">
            <svg class="search-icon-svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input name="q" placeholder="Cari menu makanan, fotokopi, atau nama warung..." autocomplete="off">
            <button class="btn-search">Cari</button>
        </form>
        <div class="hero-subtext">Bebas Antre · Langsung Ambil · Terverifikasi Resmi Kampus</div>
    </div>

    <!-- Hero Visual Showcase -->
    <div class="showcase-container">
        <div class="showcase-frame">
            <img src="<?= BASE ?>/assets/images/hero_showcase.jpg" alt="Dikampus Aja Digital Campus Marketplace" class="showcase-img">
            <div class="float-pill pill-top-right">
                <span class="pulse-dot"></span>
                <span>⚡ Siap Diambil 10 Menit</span>
            </div>
            <div class="float-pill pill-bottom-left">
                <span>⭐ 4.9/5 Kepuasan Mahasiswa</span>
            </div>
        </div>
    </div>
</section>

<!-- 2. Trust Badges Strip -->
<div class="trust-strip">
    <div class="trust-item"><span class="trust-icon">🏛️</span> Mitra Kantin Kampus</div>
    <div class="trust-item"><span class="trust-icon">🖨️</span> Layanan Print Kilat</div>
    <div class="trust-item"><span class="trust-icon">⚡</span> Bebas Antre Kuliah</div>
    <div class="trust-item"><span class="trust-icon">🔒</span> Transaksi Terpercaya</div>
</div>

<!-- 3. Category Filter Chips (Segmented Controls) -->
<div class="section-intro">
    <span class="eyebrow">KATEGORI & LAYANAN</span>
    <h2>Semua Kebutuhan Kampus Jadi Lebih Praktis</h2>
    <p>Pilih kategori yang kamu cari dan pesan langsung sebelum jam istirahat tiba.</p>
</div>

<div class="chips">
    <a class="chip active" href="<?= BASE ?>/mahasiswa/produk.php">Semua Kategori</a>
    <?php foreach ($kat as $k): ?>
        <a class="chip" href="<?= BASE ?>/mahasiswa/produk.php?k=<?= $k['id_kategori'] ?>"><?= e($k['nama_kategori']) ?></a>
    <?php endforeach; ?>
</div>

<!-- 4. Feature Split Rows (Alternating Layout) -->
<!-- Row 1: Kuliner Kampus -->
<div class="feature-row">
    <div class="feature-text">
        <span class="eyebrow">KULINER KAMPUS</span>
        <h3>Pesan Kuliner Favorit, Ambil Tepat Waktu</h3>
        <p>Tak perlu lagi membuang waktu 20 menit antre di kantin saat jam istirahat yang sempit. Cukup pesan lebih awal dari ruang kelas, dan makanan hangatmu sudah siap diambil begitu perkuliahan selesai.</p>
        <a href="<?= BASE ?>/mahasiswa/produk.php" class="btn">Eksplor Menu Kampus →</a>
    </div>
    <div class="feature-img-card">
        <img src="<?= BASE ?>/assets/images/feature_food.jpg" alt="Menu Makanan Kampus">
    </div>
</div>

<!-- Row 2: Fotokopi & Cetak Dokumen Online (Numbered Feature List) -->
<div class="feature-row reverse">
    <div class="feature-text">
        <span class="eyebrow">LAYANAN PRINT & JILID</span>
        <h3>Cetak Tugas & Skripsi dari Kamar Kos</h3>
        <p>Unggah file dokumen secara online tanpa perlu repot bawa flashdisk rawan virus. Atur opsi cetak warna, hitam-putih, hingga jilid langsung dari HP atau laptopmu.</p>

        <div class="numbered-list">
            <div class="numbered-item">
                <span class="numbered-num">01</span>
                <div class="numbered-content">
                    <b>Unggah Berkas Digital</b>
                    <span>Mendukung PDF, Word (DOCX), dan gambar tugas.</span>
                </div>
            </div>
            <div class="numbered-item">
                <span class="numbered-num">02</span>
                <div class="numbered-content">
                    <b>Kustomisasi Halaman & Jilid</b>
                    <span>Tentukan halaman berwarna, hitam-putih, softcover atau lakban.</span>
                </div>
            </div>
            <div class="numbered-item">
                <span class="numbered-num">03</span>
                <div class="numbered-content">
                    <b>Pantau Status Pengerjaan</b>
                    <span>Dapatkan notifikasi realtime saat dokumen sedang dicetak.</span>
                </div>
            </div>
            <div class="numbered-item">
                <span class="numbered-num">04</span>
                <div class="numbered-content">
                    <b>Ambil Dokumen Bebas Antre</b>
                    <span>Tinggal tunjukkan kode pesanan di loket fotokopi kampus.</span>
                </div>
            </div>
        </div>

        <a href="<?= BASE ?>/mahasiswa/print.php" class="btn">Mulai Cetak Online →</a>
    </div>
    <div class="feature-img-card">
        <img src="<?= BASE ?>/assets/images/feature_print.jpg" alt="Layanan Cetak Skripsi dan Dokumen">
    </div>
</div>

<!-- 5. Popular Tenants Grid -->
<div class="section-subhead">
    <div>
        <span class="eyebrow">TENANT TERVERIFIKASI</span>
        <h2>Tenant Populer</h2>
    </div>
    <a href="<?= BASE ?>/mahasiswa/tenant.php" class="link-more">Lihat Semua Tenant →</a>
</div>
<div class="grid">
    <?php foreach ($tenants as $t) echo tenant_card($t); ?>
</div>

<!-- 6. Latest Products Grid -->
<div class="section-subhead">
    <div>
        <span class="eyebrow">PILIHAN HARI INI</span>
        <h2>Menu & Produk Terbaru</h2>
    </div>
    <a href="<?= BASE ?>/mahasiswa/produk.php" class="link-more">Lihat Semua Produk →</a>
</div>
<div class="grid">
    <?php foreach ($produk as $p) echo produk_card($p); ?>
</div>

<!-- 7. Large Serif Impact Stats Strip -->
<div class="stats-strip">
    <div class="stat-item">
        <div class="stat-big-num">15+</div>
        <div class="stat-title">Mitra Tenant Resmi</div>
        <div class="stat-desc">Kantin fakultas, warung kuliner, dan sentra fotokopi kampus terintegrasi.</div>
    </div>
    <div class="stat-item">
        <div class="stat-big-num">1.500+</div>
        <div class="stat-title">Pesanan Sukses</div>
        <div class="stat-desc">Transaksi harian mahasiswa yang terselesaikan tanpa kendala antre.</div>
    </div>
    <div class="stat-item">
        <div class="stat-big-num">15 Mnt</div>
        <div class="stat-title">Waktu Terhemat</div>
        <div class="stat-desc">Rata-rata waktu istirahat yang berhasil dihemat setiap kali memesan.</div>
    </div>
</div>

<!-- 8. Testimonials Section -->
<div class="section-intro">
    <span class="eyebrow">TESTIMONI</span>
    <h2>Dipercaya Mahasiswa & Pengelola Kantin</h2>
    <p>Cerita nyata kenyamanan beraktivitas di kampus bersama Dikampus Aja.</p>
</div>

<div class="testimonials-grid">
    <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <p class="testi-quote">"Sangat penyelamat pas jeda kuliah cuma 30 menit. Pesan dari lantai 4, turun ke kantin makanan udah siap diambil. Gak ada lagi drama kehabisan lauk."</p>
        <div class="testi-author">
            <span class="testi-name">Aditya Pratama</span>
            <span class="testi-role">Mahasiswa Teknik Informatika</span>
        </div>
    </div>
    <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <p class="testi-quote">"Cetak laporan praktikum nggak ribet lagi pakai flashdisk yang sering kena virus. Tinggal upload PDF pas malam, paginya tinggal ambil di tempat fotokopi."</p>
        <div class="testi-author">
            <span class="testi-name">Siti Rahmawati</span>
            <span class="testi-role">Mahasiswa FMIPA</span>
        </div>
    </div>
    <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <p class="testi-quote">"Sebagai pengelola warung kantin, orderan jadi lebih teratur dan pesanan langsung tercatat rapi di sistem. Pendapatan kami juga meningkat!"</p>
        <div class="testi-author">
            <span class="testi-name">Ibu Hj. Dewi</span>
            <span class="testi-role">Mitra Tenant Kantin Utama</span>
        </div>
    </div>
</div>

<!-- 9. FAQ Accordion Section -->
<div class="faq-section">
    <div class="faq-left">
        <span class="eyebrow">BANTUAN & INFORMASI</span>
        <h2>Pertanyaan yang Sering Diajukan</h2>
        <p>Masih punya pertanyaan seputar cara memesan, pembayaran, atau bergabung sebagai mitra tenant? Temukan jawabannya di sini.</p>
    </div>
    <div class="faq-list">
        <div class="faq-item">
            <button class="faq-question" type="button">
                <span>Bagaimana cara memesan makanan di Dikampus Aja?</span>
                <span class="faq-icon">›</span>
            </button>
            <div class="faq-answer">
                Cukup pilih tenant atau menu favoritmu, tambahkan ke keranjang belanja, tentukan catatan pesanan, lalu lakukan checkout. Pesanan akan segera diproses oleh pihak kantin dan siap diambil sesuai estimasi.
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question" type="button">
                <span>Apakah bisa cetak dokumen dan jilid dari rumah/kos?</span>
                <span class="faq-icon">›</span>
            </button>
            <div class="faq-answer">
                Ya! Melalui menu Fotokopi, kamu dapat mengunggah berkas (PDF/Word), memilih pengaturan cetak (warna/hitam-putih, rangkap, jilid), dan mengambil dokumen yang sudah rapi di loket fotokopi kampus.
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question" type="button">
                <span>Bagaimana cara mendaftar sebagai tenant atau penjual?</span>
                <span class="faq-icon">›</span>
            </button>
            <div class="faq-answer">
                Klik tombol "Daftar" di navigasi atas, pilih peran sebagai "Tenant (Penjual)", isi nama usaha dan jenis tenant kamu. Setelah diverifikasi oleh admin kampus, kamu dapat langsung mengunggah produk dan menerima pesanan.
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question" type="button">
                <span>Apakah dikenakan biaya tambahan saat bertransaksi?</span>
                <span class="faq-icon">›</span>
            </button>
            <div class="faq-answer">
                Tidak ada biaya tersembunyi. Harga yang tertera adalah harga asli dari masing-masing tenant kantin dan layanan fotokopi resmi kampus.
            </div>
        </div>
    </div>
</div>

<!-- 10. Dark Obsidian Pre-Footer CTA Banner -->
<div class="cta-dark-card">
    <h2>Mulai Nikmati Kemudahan Kampus Hari Ini</h2>
    <p>Bergabunglah dengan ribuan mahasiswa lainnya dan nikmati kepraktisan pesan kuliner serta cetak dokumen tanpa antrean panjang.</p>
    <a href="<?= BASE ?>/auth/register.php" class="cta-white-btn">Daftar Akun Gratis Sekarang</a>
</div>

<?php include 'includes/footer.php'; ?>