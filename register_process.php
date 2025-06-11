<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role = $_POST['role'];

    // Validasi 1: Password dan konfirmasi harus sama
    if ($password !== $confirm_password) {
        header("Location: register.php?error=password_mismatch");
        exit();
    }

    // Validasi 2: Format email harus valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: register.php?error=invalid_email");
        exit();
    }

    // Validasi 3: Cek apakah email sudah ada di database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email sudah terdaftar
        header("Location: register.php?error=email_exists");
        exit();
    }
    $stmt->close();

    // Jika semua validasi lolos, hash password dan masukkan data
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt_insert = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    $stmt_insert->bind_param("sss", $email, $hashed_password, $role);

    if ($stmt_insert->execute()) {
        // Registrasi berhasil, arahkan ke halaman login dengan pesan sukses
        header("Location: login.php?success=1");
        exit();
    } else {
        // Terjadi error saat insert
        header("Location: register.php?error=db_error");
        exit();
    }
    $stmt_insert->close();
    $conn->close();

} else {
    // Jika bukan metode POST, kembalikan ke halaman registrasi
    header("Location: register.php");
    exit();
}
?>