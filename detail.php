<?php
session_start();
require_once 'db.php';

// --- 1. Ambil ID Lowongan & Lakukan Validasi ---
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Error: ID lowongan tidak valid.");
}
$lowongan_id = intval($_GET['id']);

// --- 2. Query untuk Mengambil Detail Lowongan ---
$sql_lowongan = "SELECT lp.*, p.nama_perusahaan, p.lokasi, p.logo_perusahaan 
                 FROM lowongan_pekerjaan lp 
                 JOIN perusahaan p ON lp.perusahaan_id = p.id 
                 WHERE lp.id = ?";
$stmt_lowongan = $conn->prepare($sql_lowongan);
$stmt_lowongan->bind_param("i", $lowongan_id);
$stmt_lowongan->execute();
$result_lowongan = $stmt_lowongan->get_result();

if ($result_lowongan->num_rows === 0) {
    die("Lowongan tidak ditemukan.");
}
$lowongan = $result_lowongan->fetch_assoc();

// --- 3. Cek Status Login, Role, dan Riwayat Lamaran ---
$user_logged_in = isset($_SESSION['user_id']);
$role_valid = false;
$sudah_melamar = false;

if ($user_logged_in) {
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Pencari Kerja') {
        $role_valid = true;
    }

    $user_id = $_SESSION['user_id'];
    $sql_cek_lamaran = "SELECT id FROM lamaran WHERE user_id = ? AND lowongan_id = ?";
    $stmt_cek_lamaran = $conn->prepare($sql_cek_lamaran);
    $stmt_cek_lamaran->bind_param("ii", $user_id, $lowongan_id);
    $stmt_cek_lamaran->execute();
    $result_cek_lamaran = $stmt_cek_lamaran->get_result();
    if ($result_cek_lamaran->num_rows > 0) {
        $sudah_melamar = true;
    }
    $stmt_cek_lamaran->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan - <?php echo htmlspecialchars($lowongan['nama_pekerjaan']); ?></title>
    <link rel="stylesheet" href="CSS/styledetail.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php">
                        <img src="IMAGE/batch-logo-removebg-preview.png" alt="Logo" style="max-width: 150px;">
                    </a>
                </div>
                <nav class="user-nav">
                    <?php if ($user_logged_in): ?>
                        <span style="color: white; margin-right: 15px;">Halo, <?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                        <a href="logout.php" class="logout-btn">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="login-btn">Login</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <h1 class="section-title">Detail Lowongan Pekerjaan</h1>
            
            <div class="detail-container">
                <!-- Tampilkan logo perusahaan dengan path lengkap -->
                <img src="IMAGE/<?php echo htmlspecialchars($lowongan['logo_perusahaan']); ?>" 
                     alt="Logo <?php echo htmlspecialchars($lowongan['nama_perusahaan']); ?>" 
                     style="max-width: 150px; display:block; margin-bottom:20px;">

                <h2><?php echo htmlspecialchars($lowongan['nama_pekerjaan']); ?></h2>
                <div class="detail-info">
                    <p><strong>Perusahaan:</strong> <?php echo htmlspecialchars($lowongan['nama_perusahaan']); ?></p>
                    <p><strong>Kategori:</strong> <?php echo htmlspecialchars($lowongan['kategori_pekerjaan']); ?></p>
                    <p><strong>Lokasi:</strong> <?php echo htmlspecialchars($lowongan['lokasi']); ?></p>
                    <p><strong>Jenis Pekerjaan:</strong> <?php echo htmlspecialchars($lowongan['jenis_pekerjaan']); ?></p>
                    <p><strong>Gaji:</strong> 
                        <?php 
                            if (!empty($lowongan['gaji_awal']) && !empty($lowongan['gaji_akhir'])) {
                                echo 'Rp ' . number_format($lowongan['gaji_awal']) . ' - ' . number_format($lowongan['gaji_akhir']);
                            } else {
                                echo 'Tidak ditampilkan';
                            }
                        ?>
                    </p>
                    <p><strong>Batas Lamaran:</strong> <?php echo date('d F Y', strtotime($lowongan['tanggal_batas_lamaran'])); ?></p>
                    <p><strong>Deskripsi:</strong><br><?php echo nl2br(htmlspecialchars($lowongan['deskripsi'])); ?></p>
                    <p><strong>Syarat & Kualifikasi:</strong><br><?php echo nl2br(htmlspecialchars($lowongan['syarat_kualifikasi'])); ?></p>
                </div>

                <div class="apply-button">
                    <?php if ($user_logged_in): ?>
                        <?php if ($role_valid): ?>
                            <?php if ($sudah_melamar): ?>
                                <p class="search-btn applied">Anda Sudah Melamar</p>
                            <?php else: ?>
                                <a href="PengajuanLamaran.php?id=<?php echo $lowongan_id; ?>" class="search-btn">Ajukan Lamaran</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="search-btn disabled">Hanya Pencari Kerja yang Bisa Melamar</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="login.php" class="search-btn">Login untuk Melamar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p class="footer-text">Web by Hanli-71220875 & Dandy - 71220873</p>
        </div>
    </footer>
</body>
</html>
<?php
$stmt_lowongan->close();
$conn->close();
?>