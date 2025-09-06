<?php
// Pengaturan untuk koneksi database
$db_host = 'localhost';     // Biasanya 'localhost'
$db_user = 'root';          // Username database Anda
$db_pass = '';              // Password database Anda
$db_name = 'db_job_portal'; // Nama database yang telah dibuat

// Membuat koneksi ke database menggunakan mysqli
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, 3307);

// Memeriksa apakah koneksi berhasil atau gagal
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan skrip dan tampilkan pesan error
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>