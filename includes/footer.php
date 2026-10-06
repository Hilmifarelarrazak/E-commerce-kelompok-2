    </main>
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-brand-col">
                    <a class="brand" href="<?= BASE ?>/index.php">
                        <img src="<?= BASE ?>/assets/images/logo.svg" alt="Logo Dikampus Aja" class="brand-logo" width="36" height="36" style="height:36px;width:36px;object-fit:contain;border-radius:8px;" onerror="this.onerror=null;this.src='<?= BASE ?>/assets/images/logo.png';">
                        <span class="brand-name">DIKAMPUS AJA</span>
                    </a>
                    <p>Platform ekosistem kampus terintegrasi untuk pemesanan kuliner kantin, fotokopi online, dan ATK mahasiswa tanpa antre.</p>
                    <div class="footer-socials">
                        <a href="#" class="social-link" title="Instagram">📸</a>
                        <a href="#" class="social-link" title="Twitter / X">🐦</a>
                        <a href="#" class="social-link" title="WhatsApp">💬</a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Layanan Kampus</h4>
                    <ul>
                        <li><a href="<?= BASE ?>/mahasiswa/produk.php">Kantin & Kuliner</a></li>
                        <li><a href="<?= BASE ?>/mahasiswa/print.php">Fotokopi & Print Kilat</a></li>
                        <li><a href="<?= BASE ?>/mahasiswa/tenant.php">Daftar Mitra Tenant</a></li>
                        <li><a href="<?= BASE ?>/mahasiswa/produk.php">ATK & Perlengkapan</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Akses Cepat</h4>
                    <ul>
                        <li><a href="<?= BASE ?>/index.php">Beranda</a></li>
                        <li><a href="<?= BASE ?>/auth/login.php">Masuk Akun</a></li>
                        <li><a href="<?= BASE ?>/auth/register.php">Daftar Mahasiswa</a></li>
                        <li><a href="<?= BASE ?>/auth/register.php">Gabung Jadi Tenant</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Bantuan & Info</h4>
                    <ul>
                        <li><a href="#faq">Panduan Pemesanan</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Bantuan Mahasiswa</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div>© <?= date('Y') ?> <b>Dikampus Aja</b>. Hak cipta dilindungi undang-undang.</div>
                <div>Kebutuhan kampus? <em>Dikampus Aja.</em></div>
            </div>
        </div>
    </footer>
    <script src="<?= BASE ?>/assets/js/script.js?v=<?= filemtime(__DIR__ . '/../assets/js/script.js') ?>"></script>
</body>
</html>
