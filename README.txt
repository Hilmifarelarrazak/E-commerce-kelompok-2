DIKAMPUS AJA - Kebutuhan kampus? Dikampus Aja.

CARA MENJALANKAN (XAMPP/WAMP)
1. Salin folder dikampus_aja ke htdocs (XAMPP) atau www (WAMP).
2. Nyalakan Apache + MySQL, buka phpMyAdmin, Import file database.sql.
3. Buka http://localhost/dikampus_aja/
4. Bila user/password MySQL berbeda, ubah config/database.php.

AKUN DEMO
admin@dikampusaja.com        / admin123      (Admin)
warung1@dikampusaja.com      / tenant123     (Tenant - Warung A)
mahasiswa@dikampusaja.com    / mahasiswa123  (Mahasiswa)
fotokopi@dikampusaja.com     / fotokopi123   (Petugas Fotokopi)
Tenant lain: warung2/warung3/kantinfakultas/kantinkampus @dikampusaja.com (tenant123)
kopimhs@dikampusaja.com (tenant123) = tenant "pending" untuk uji verifikasi admin.

CATATAN
- Jika folder tidak bernama dikampus_aja, ubah konstanta BASE di includes/auth.php.
- Folder uploads harus bisa ditulis oleh Apache.
