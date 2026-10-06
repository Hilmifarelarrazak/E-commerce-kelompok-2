<?php
// Koneksi MySQL (XAMPP/WAMP default: user root, password kosong)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli('localhost', 'root', '', 'dikampus_aja');
if ($db->connect_error) die('Koneksi database gagal: ' . $db->connect_error);
$db->set_charset('utf8mb4');

// q(): jalankan prepared statement.
// SELECT -> array baris | INSERT -> id baru | UPDATE/DELETE -> jumlah baris terpengaruh
function q($sql, $types = '', ...$p) {
    global $db;
    $st = $db->prepare($sql);
    if ($types) $st->bind_param($types, ...$p);
    $st->execute();
    $r = $st->get_result();
    if ($r) return $r->fetch_all(MYSQLI_ASSOC);
    return $st->insert_id ?: $st->affected_rows;
}
// one(): ambil satu baris saja (atau null)
function one($sql, $types = '', ...$p) { $r = q($sql, $types, ...$p); return $r ? $r[0] : null; }
