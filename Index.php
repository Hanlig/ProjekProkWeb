<?php
// Mulai session untuk mengakses data pengguna yang login
session_start();

// Panggil file koneksi database
require_once 'db.php';

// ... (sisa kode PHP tidak berubah) ...
$sql = "SELECT 
            lp.id, 
            lp.nama_pekerjaan, 
            lp.kategori_pekerjaan, 
            lp.gaji_awal, 
            lp.gaji_akhir, 
            p.nama_perusahaan, 
            p.lokasi 
        FROM 
            lowongan_pekerjaan lp
        JOIN 
            perusahaan p ON lp.perusahaan_id = p.id
        WHERE 
            lp.tanggal_batas_lamaran >= CURDATE()
        ORDER BY 
            lp.created_at DESC";

$result = $conn->query($sql);

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
                        <input type="text" name="q" placeholder="Nama Perusahaan atau Pekerjaan" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <select class="form-select" name="kategori">
                            <option value="">Pilih Kategori</option>
                            <option value="IT">IT</option>
                            <option value="Desain">Desain</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Pendidikan">Pendidikan</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <select class="form-select" name="lokasi">
                            <option value="">Pilih Lokasi</option>
                            <option value="Jakarta">Jakarta</option>
                            <option value="Bandung">Bandung</option>
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
                                    <h3 class="job-title"><?php echo htmlspecialchars($row['nama_pekerjaan']); ?></h3>
                                    <span class="company-name"><?php echo htmlspecialchars($row['nama_perusahaan']); ?></span>
                                </div>
                                <div class="job-details">
                                    <p class="job-category"><i class="fas fa-briefcase"></i> <?php echo htmlspecialchars($row['kategori_pekerjaan']); ?></p>
                                    <p class="job-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['lokasi']); ?></p>
                                    <p class="job-salary"><i class="fas fa-money-bill-wave"></i> 
                                        <?php 
                                            // Format gaji
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
                        <p style="text-align: center; grid-column: 1 / -1;">Saat ini tidak ada lowongan yang tersedia.</p>
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
$conn->close();
?>