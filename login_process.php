<?php
// Selalu mulai session di paling atas untuk mengelola data login
session_start();

// Panggil file koneksi database
require_once 'db.php';

// Pastikan form dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil data dari form dan bersihkan dari spasi tak terlihat
    // Menggunakan trim() adalah praktik terbaik untuk menangani input pengguna
    $email = trim($_POST['username']); // form login menggunakan name="username"
    $password = trim($_POST['password']);

    // 2. Siapkan query untuk mencari pengguna berdasarkan email
    // Menggunakan prepared statement untuk mencegah SQL Injection
    $stmt = $conn->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
    
    // Jika statement gagal disiapkan, hentikan proses
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("s", $email);
    
    // 3. Jalankan query
    $stmt->execute();
    $result = $stmt->get_result();

    // 4. Periksa apakah pengguna ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // 5. Verifikasi password yang diinput dengan hash di database
        if (password_verify($password, $user['password'])) {
            // Jika password cocok, login berhasil!
            // Simpan informasi pengguna ke dalam session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            // Arahkan pengguna ke halaman utama
            header("Location: index.php");
            exit(); // Penting untuk menghentikan eksekusi setelah redirect

        } else {
            // Jika password salah
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // Jika email tidak ditemukan
        header("Location: login.php?error=1");
        exit();
    }

    // Menutup statement
    $stmt->close();
}

// Menutup koneksi database
$conn->close();
?>