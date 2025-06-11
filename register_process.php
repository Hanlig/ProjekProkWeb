<?php
require_once 'db.php'; // Panggil file koneksi database

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil data dari form
    $fullname = $_POST['fullname'];
    $companyname = $_POST['companyname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validasi dasar
    if (empty($email) || empty($password) || empty($role)) {
        header("Location: register.php?error=Semua field wajib diisi kecuali nama.");
        exit();
    }
    if (($role == 'Pencari Kerja' && empty($fullname)) || ($role == 'Perusahaan' && empty($companyname))) {
        header("Location: register.php?error=Nama lengkap atau nama perusahaan wajib diisi sesuai peran.");
        exit();
    }

    // Cek apakah email sudah terdaftar
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    if ($result_check->num_rows > 0) {
        header("Location: register.php?error=Email sudah terdaftar, silakan gunakan email lain.");
        exit();
    }
    $stmt_check->close();

    // HASH PASSWORD! Ini adalah bagian yang paling penting.
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Memulai transaksi database untuk memastikan data konsisten
    $conn->begin_transaction();

    try {
        // 1. Masukkan data ke tabel 'users'
        $stmt_user = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $stmt_user->bind_param("sss", $email, $hashed_password, $role);
        $stmt_user->execute();

        // Ambil ID dari user yang baru saja dibuat
        $user_id = $conn->insert_id;
        $stmt_user->close();

        // 2. Masukkan data ke tabel spesifik berdasarkan peran (role)
        if ($role == 'Pencari Kerja') {
            $stmt_profile = $conn->prepare("INSERT INTO pencari_kerja (user_id, nama_lengkap) VALUES (?, ?)");
            $stmt_profile->bind_param("is", $user_id, $fullname);
            $stmt_profile->execute();
            $stmt_profile->close();
        } elseif ($role == 'Perusahaan') {
            // Untuk perusahaan, kita butuh input 'lokasi' juga, tapi untuk sementara kita isi default
            $lokasi_default = 'Belum diisi';
            $stmt_profile = $conn->prepare("INSERT INTO perusahaan (user_id, nama_perusahaan, lokasi) VALUES (?, ?, ?)");
            $stmt_profile->bind_param("iss", $user_id, $companyname, $lokasi_default);
            $stmt_profile->execute();
            $stmt_profile->close();
        }

        // Jika semua berhasil, commit transaksi
        $conn->commit();
        header("Location: login.php?success=Registrasi berhasil! Silakan login.");
        exit();

    } catch (mysqli_sql_exception $exception) {
        // Jika ada error, batalkan semua perubahan
        $conn->rollback();
        header("Location: register.php?error=Terjadi kesalahan pada server.");
        exit();
    }
}
?>