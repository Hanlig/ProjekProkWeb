<?php
// Memulai session untuk menyimpan data login pengguna
session_start();

// Memanggil file koneksi database
require_once 'db.php';

// Memeriksa apakah form telah disubmit dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Mengambil data dari form dan membersihkannya dari karakter yang tidak diinginkan
    $email = $conn->real_escape_string($_POST['username']); // form login menggunakan name="username" untuk email
    $password = $_POST['password'];

    // Menyiapkan query SQL untuk mencari pengguna berdasarkan email
    // Menggunakan prepared statement untuk mencegah SQL Injection
    $stmt = $conn->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    
    // Menjalankan query
    $stmt->execute();
    $result = $stmt->get_result();

    // Memeriksa apakah pengguna dengan email tersebut ditemukan (jumlah baris > 0)
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Memverifikasi password yang diinput dengan hash password di database
        if (password_verify($password, $user['password'])) {
            // Jika password cocok, simpan informasi pengguna ke dalam session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            // Arahkan pengguna ke halaman utama
            header("Location: index.php");
            exit();
        } else {
            // Jika password salah, arahkan kembali ke halaman login dengan pesan error
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // Jika email tidak ditemukan, arahkan kembali ke halaman login dengan pesan error
        header("Location: login.php?error=1");
        exit();
    }

    // Menutup statement
    $stmt->close();
}

// Menutup koneksi database
$conn->close();
?>