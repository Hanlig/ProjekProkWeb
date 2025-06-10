<?php
// ... (Kode PHP tidak berubah) ...
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
              <Cinput type="file" id="portfolio" name="portfolio" accept="application/pdf" />

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