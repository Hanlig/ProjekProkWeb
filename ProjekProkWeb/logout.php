<?php
// Selalu mulai session di awal
session_start();

// Hapus semua variabel session
$_SESSION = array();

// Hancurkan session
session_destroy();

// Arahkan pengguna kembali ke halaman utama
header("Location: index.php");
exit();
?>