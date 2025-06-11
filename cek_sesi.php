<?php
// Memulai sesi untuk membaca isinya
session_start();

// Menampilkan semua data yang tersimpan di dalam sesi
echo "<h1>Isi Sesi Login Saat Ini</h1>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>