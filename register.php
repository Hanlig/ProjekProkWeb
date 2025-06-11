<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Buat Akun - Portal Lowongan</title>
  <link rel="stylesheet" href="CSS/styleregister.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <header class="register-header">
    <div class="container">
      <a href="login.php" class="back-button">
        <img src="IMAGE/icont back.png" alt="Back" class="back-icon" />
        <span>Kembali ke Login</span>
      </a>
    </div>
  </header>

  <main class="register-main">
    <div class="register-wrapper">
      <h1 class="register-title">Buat Akun Baru</h1>
      <p class="register-subtitle">Daftar untuk mulai mencari pekerjaan atau merekrut talenta terbaik.</p>
      
      <?php
        // Menampilkan pesan error jika ada
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            $pesan = '';
            if ($error == 'password_mismatch') {
                $pesan = 'Konfirmasi password tidak cocok!';
            } elseif ($error == 'email_exists') {
                $pesan = 'Email sudah terdaftar, silakan gunakan email lain.';
            } elseif ($error == 'invalid_email') {
                $pesan = 'Format email tidak valid.';
            } else {
                $pesan = 'Terjadi kesalahan. Silakan coba lagi.';
            }
            echo '<p class="error-message">' . $pesan . '</p>';
        }
      ?>

      <form class="register-form" action="register_process.php" method="POST">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukkan alamat email Anda" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Buat password Anda" required>
        </div>

        <div class="form-group">
          <label for="confirm_password">Konfirmasi Password</label>
          <input type="password" id="confirm_password" name="confirm_password" placeholder="Ketik ulang password Anda" required>
        </div>

        <div class="form-group">
            <label>Daftar Sebagai:</label>
            <div class="role-options">
                <input type="radio" id="pencari_kerja" name="role" value="pencari_kerja" checked>
                <label for="pencari_kerja" class="radio-label">Pencari Kerja</label>
                
                <input type="radio" id="perusahaan" name="role" value="perusahaan">
                <label for="perusahaan" class="radio-label">Perusahaan</label>
            </div>
        </div>

        <button type="submit" class="submit-btn">Daftar</button>
      </form>
    </div>
  </main>
</body>
</html>