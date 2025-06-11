<?php
// Mulai session untuk mengakses data pengguna yang login
session_start();

// Panggil file koneksi database
require_once 'db.php';

// --- Kueri SQL Diperbarui untuk mengambil logo_perusahaan ---
$sql = "SELECT 
            lp.id, 
            lp.nama_pekerjaan, 
            lp.kategori_pekerjaan, 
            lp.gaji_awal, 
            lp.gaji_akhir, 
            p.nama_perusahaan, 
            p.lokasi,
            p.logo_perusahaan -- Menambahkan kolom logo
        FROM 
            lowongan_pekerjaan lp
        JOIN 
            perusahaan p ON lp.perusahaan_id = p.id
        WHERE 
            lp.tanggal_batas_lamaran >= CURDATE()";

$params = [];
$types = '';

// Filter berdasarkan keyword (nama pekerjaan atau perusahaan)
if (!empty($_GET['q'])) {
    $keyword = '%' . $_GET['q'] . '%';
    $sql .= " AND (lp.nama_pekerjaan LIKE ? OR p.nama_perusahaan LIKE ?)";
    $types .= 'ss';
    array_push($params, $keyword, $keyword);
}

// Filter berdasarkan kategori
if (!empty($_GET['kategori'])) {
    $sql .= " AND lp.kategori_pekerjaan = ?";
    $types .= 's';
    array_push($params, $_GET['kategori']);
}

// Filter berdasarkan lokasi
if (!empty($_GET['lokasi'])) {
    $sql .= " AND p.lokasi = ?";
    $types .= 's';
    array_push($params, $_GET['lokasi']);
}

$sql .= " ORDER BY lp.created_at DESC";

$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Lowongan Pekerjaan</title>
    <link rel="stylesheet" href="CSS/styleindex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php"><img src="IMAGE/batch-logo-removebg-preview.png" alt="Logo Portal Lowongan Kerja"></a>
                </div>
                <nav class="user-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
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
            <section class="search-section">
                <h1 class="section-title">Cari Lowongan Pekerjaan</h1>
                <form class="search-form" action="index.php" method="GET">
                    <div class="form-group">
                        <input type="text" name="q" placeholder="Nama Perusahaan atau Pekerjaan" class="form-input" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <select class="form-select" name="kategori">
                            <option value="">Pilih Kategori</option>
                            <option value="IT" <?php if(($_GET['kategori'] ?? '') == 'IT') echo 'selected'; ?>>IT</option>
                            <option value="Desain" <?php if(($_GET['kategori'] ?? '') == 'Desain') echo 'selected'; ?>>Desain</option>
                            <option value="Marketing" <?php if(($_GET['kategori'] ?? '') == 'Marketing') echo 'selected'; ?>>Marketing</option>
                            <option value="Pendidikan" <?php if(($_GET['kategori'] ?? '') == 'Pendidikan') echo 'selected'; ?>>Pendidikan</option>
                            <option value="Akuntansi" <?php if(($_GET['kategori'] ?? '') == 'Akuntansi') echo 'selected'; ?>>Akuntansi</option>
                            <option value="Manajemen" <?php if(($_GET['kategori'] ?? '') == 'Manajemen') echo 'selected'; ?>>Manajemen</option>
                            <option value="Sales" <?php if(($_GET['kategori'] ?? '') == 'Sales') echo 'selected'; ?>>Sales</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-select" name="lokasi">
                            <option value="">Pilih Lokasi</option>
                            <option value="Yogyakarta" <?php if(($_GET['lokasi'] ?? '') == 'Yogyakarta') echo 'selected'; ?>>Yogyakarta</option>
                            <option value="Jakarta" <?php if(($_GET['lokasi'] ?? '') == 'Jakarta') echo 'selected'; ?>>Jakarta</option>
                            <option value="Bandung" <?php if(($_GET['lokasi'] ?? '') == 'Bandung') echo 'selected'; ?>>Bandung</option>
                        </select>
                    </div>
                    <button type="submit" class="search-btn">Cari Lowongan</button>
                </form>
            </section>

            <section class="job-listings">
                <h2 class="section-title">Daftar Lowongan Pekerjaan</h2>
                
                <div class="job-grid">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <article class="job-card">
                                <div class="job-header">
                                    <img src="<?php echo htmlspecialchars($row['logo_perusahaan']); ?>" alt="Logo <?php echo htmlspecialchars($row['nama_perusahaan']); ?>" class="company-logo">
                                    <div class="job-title-container">
                                        <h3 class="job-title"><?php echo htmlspecialchars($row['nama_pekerjaan']); ?></h3>
                                        <span class="company-name"><?php echo htmlspecialchars($row['nama_perusahaan']); ?></span>
                                    </div>
                                </div>
                                <div class="job-details">
                                    <p class="job-category"><i class="fas fa-briefcase"></i> <?php echo htmlspecialchars($row['kategori_pekerjaan']); ?></p>
                                    <p class="job-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['lokasi']); ?></p>
                                    <p class="job-salary"><i class="fas fa-money-bill-wave"></i> 
                                        <?php 
                                            if (!empty($row['gaji_awal']) && !empty($row['gaji_akhir'])) {
                                                echo 'Rp ' . number_format($row['gaji_awal']) . ' - ' . number_format($row['gaji_akhir']);
                                            } else {
                                                echo 'Gaji tidak ditampilkan';
                                            }
                                        ?>
                                    </p>
                                </div>
                                <a href="detail.php?id=<?php echo $row['id']; ?>" class="detail-btn">Lihat Detail <i class="fas fa-chevron-right"></i></a>
                            </article>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="text-align: center; grid-column: 1 / -1;">Tidak ada lowongan yang cocok dengan kriteria pencarian Anda.</p>
                    <?php endif; ?>
                </div>
            </section>
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
// Menutup koneksi database
$stmt->close();
$conn->close();
?>