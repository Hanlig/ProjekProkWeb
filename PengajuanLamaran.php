<?php
// Mulai session dan panggil file koneksi
session_start();
require_once 'db.php';

// --- Blok Keamanan dan Pengambilan Data Awal ---

// 1. Wajib login untuk akses halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. Hanya 'Pencari Kerja' yang dapat mengakses
if ($_SESSION['user_role'] !== 'Pencari Kerja') {
    die("Error: Hanya pencari kerja yang dapat mengakses halaman ini.");
}

// 3. Pastikan ID lowongan ada dan valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Error: ID lowongan tidak valid.");
}
$lowongan_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// 4. Cek lagi apakah pengguna sudah pernah melamar (keamanan tambahan)
$stmt_cek = $conn->prepare("SELECT id FROM lamaran WHERE user_id = ? AND lowongan_id = ?");
$stmt_cek->bind_param("ii", $user_id, $lowongan_id);
$stmt_cek->execute();
if ($stmt_cek->get_result()->num_rows > 0) {
    die("Anda sudah pernah melamar lowongan ini sebelumnya.");
}
$stmt_cek->close();

// --- Ambil data untuk ditampilkan di halaman ---
// Ambil detail lowongan dan perusahaan (INI BAGIAN YANG MENGHASILKAN $lowongan)
$stmt_lowongan = $conn->prepare("SELECT lp.nama_pekerjaan, p.nama_perusahaan FROM lowongan_pekerjaan lp JOIN perusahaan p ON lp.perusahaan_id = p.id WHERE lp.id = ?");
$stmt_lowongan->bind_param("i", $lowongan_id);
$stmt_lowongan->execute();
$lowongan = $stmt_lowongan->get_result()->fetch_assoc(); // Variabel $lowongan dibuat di sini
if (!$lowongan) die("Lowongan tidak ditemukan.");
$stmt_lowongan->close();

// Ambil detail pencari kerja untuk mengisi form otomatis
$stmt_pencaker = $conn->prepare("SELECT nama_lengkap, tanggal_lahir, nomor_hp FROM pencari_kerja WHERE user_id = ?");
$stmt_pencaker->bind_param("i", $user_id);
$stmt_pencaker->execute();
$pencaker = $stmt_pencaker->get_result()->fetch_assoc();
$stmt_pencaker->close();

$errors = []; // Variabel untuk menampung pesan error

// --- Blok Pemrosesan Formulir (saat disubmit) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil data dari form
    $nama_lengkap = $_POST['fullname'];
    $tanggal_lahir = $_POST['birthdate'];
    $email = $_POST['email']; 
    $nomor_hp = $_POST['phone'];
    $surat_lamaran = $_POST['coverletter'];

    // --- Penanganan Unggahan File CV ---
    $path_cv = null;
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
        $cv_file = $_FILES['cv'];
        if ($cv_file['size'] > 5 * 1024 * 1024) { // Maks 5MB
            $errors[] = "Ukuran file CV tidak boleh lebih dari 5MB.";
        } else {
            $target_dir = "uploads/";
            $file_extension = strtolower(pathinfo($cv_file['name'], PATHINFO_EXTENSION));
            $unique_filename = "cv_" . $user_id . "_" . $lowongan_id . "_" . time() . "." . $file_extension;
            $path_cv = $target_dir . $unique_filename;

            if (!move_uploaded_file($cv_file['tmp_name'], $path_cv)) {
                $errors[] = "Gagal mengunggah CV.";
                $path_cv = null;
            }
        }
    } else {
        $errors[] = "File CV wajib diunggah.";
    }

    // --- Penanganan Unggahan File Portofolio (Opsional) ---
    $path_portofolio = null;
    if (isset($_FILES['portfolio']) && $_FILES['portfolio']['error'] == UPLOAD_ERR_OK) {
        // (logika serupa untuk portofolio bisa ditambahkan di sini)
    }
    
    // --- Simpan ke Database jika tidak ada error ---
    if (empty($errors)) {
        $stmt_insert = $conn->prepare("INSERT INTO lamaran (user_id, lowongan_id, nama_lengkap, tanggal_lahir, nomor_hp, path_cv, path_portofolio, surat_lamaran) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("iissssss", $user_id, $lowongan_id, $nama_lengkap, $tanggal_lahir, $nomor_hp, $path_cv, $path_portofolio, $surat_lamaran);

        if ($stmt_insert->execute()) {
            echo "<script>alert('Lamaran Anda berhasil dikirim!'); window.location.href='index.php';</script>";
            exit();
        } else {
            $errors[] = "Gagal menyimpan lamaran ke database: " . $stmt_insert->error;
        }
        $stmt_insert->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pengajuan Lamaran - <?php echo htmlspecialchars($lowongan['nama_pekerjaan']); ?></title>
  <link rel="stylesheet" href="CSS/stylelamarkerja.css" />
</head>
<body>
  <header class="login-header">
    <div class="container">
      <a href="detail.php?id=<?php echo $lowongan_id; ?>" class="back-button">
        <img src="IMAGE/icont back.png" alt="Back" class="back-icon" />
      </a>
      <a href="logout.php">logout</a>
      <div class="logo">
        <img src="IMAGE/batch-logo-removebg-preview.png" alt="logo-web" width="50px" height="100px">
      </div>
    </div>
  </header>

  <main class="login-main">
    <div class="login-wrapper">
      <div class="job-apply-section">
        <h2><?php echo htmlspecialchars($lowongan['nama_pekerjaan']); ?> - <?php echo htmlspecialchars($lowongan['nama_perusahaan']); ?></h2>
        <section class="job-detail">
          <div class="col">
            <h3>Formulir Pengajuan Lamaran</h3>
            <?php if (!empty($errors)): ?>
                <div style="color: #ff6b6b; background: rgba(255,0,0,0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php foreach($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="PengajuanLamaran.php?id=<?php echo $lowongan_id; ?>" method="post" enctype="multipart/form-data">
              <label for="fullname">Nama Lengkap <span class="required">*</span></label>
              <input type="text" id="fullname" name="fullname" required placeholder="Nama lengkap Anda" value="<?php echo htmlspecialchars($pencaker['nama_lengkap'] ?? ''); ?>" />

              <label for="birthdate">Tanggal Lahir <span class="required">*</span></label>
              <input type="date" id="birthdate" name="birthdate" required value="<?php echo htmlspecialchars($pencaker['tanggal_lahir'] ?? ''); ?>" />

              <label for="email">Email <span class="required">*</span></label>
              <input type="email" id="email" name="email" required placeholder="email@example.com" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" readonly />

              <label for="phone">Nomor HP <span class="required">*</span></label>
              <input type="tel" id="phone" name="phone" required placeholder="081234567890" pattern="[0-9]{8,15}" value="<?php echo htmlspecialchars($pencaker['nomor_hp'] ?? ''); ?>" />

              <label for="cv">CV (PDF, maks 5MB) <span class="required">*</span></label>
              <input type="file" id="cv" name="cv" accept="application/pdf" required />

              <label for="portfolio">Portofolio (PDF, opsional)</label>
              <input type="file" id="portfolio" name="portfolio" accept="application/pdf" />

              <label for="coverletter">Surat Lamaran (opsional)</label>
              <textarea id="coverletter" name="coverletter" rows="5" placeholder="Tulis surat lamaran Anda di sini..."></textarea>

              <button type="submit">Kirim Lamaran</button>
            </form>
          </div>
        </section>
      </div>
    </div>
  </main>
  
  <footer class="login-footer">
    <div class="container">
      <p><u>Web by Hanli-71220875 & Dandy - 71220873</u></p>
    </div>
  </footer>
</body>
</html>