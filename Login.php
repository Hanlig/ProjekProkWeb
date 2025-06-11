<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Progweb</title>
  <link rel="stylesheet" href="CSS/stylelogin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <header class="login-header">
    <div class="container">
      <a href="index.php" class="back-button">
        <img src="IMAGE/icont back.png" alt="Back" class="back-icon" />
      </a>
      <div class="logo">
        <img src="IMAGE/batch-logo-removebg-preview.png" alt="logo-web" width="50px" height="100px">
      </div>
    </div>
  </header>

  <main class="login-main">
    <div class="login-wrapper">
      <div class="welcome-side">
        <h1 class="welcome-text">Welcome!</h1>
        <p class="welcome-desc">If you already have an account, please log in to access your dashboard. If you don't have an account, you can create one to get started.</p>
        <div class="role-info">
          <div class="role-card">
            <i class="fas fa-user-tie"></i>
            <h3>Job Seeker</h3>
            <p>Find your dream job and apply easily</p>
          </div>
          <div class="role-card">
            <i class="fas fa-building"></i>
            <h3>Company</h3>
            <p>Post jobs and manage applicants</p>
          </div>
        </div>
      </div>

      <section class="login-section">
        <h1 class="signin-title">HALO, LOGIN DI SINI</h1>

        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<p style="color: #ff6b6b; text-align: center; background: rgba(255,0,0,0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px;">Username atau password salah!</p>';
        }
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo '<p style="color: #2ecc71; text-align: center; background: rgba(0,255,0,0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px;">Akun berhasil dibuat! Silakan login.</p>';
        }
        ?>

        <form class="login-form" action="login_process.php" method="POST">
          <div class="form-group">
            <label for="username">Username or Email</label>
            <input type="text" id="username" name="username" placeholder="Enter your username or email" required>
          </div>

          <div class="form-group password-wrapper">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="button" class="toggle-password">
              <i class="far fa-eye"></i>
            </button>
          </div>

          <div class="form-footer">
            <a href="register.php">Create your Account</a>
            <button type="submit" class="submit-btn">Login</button>
          </div>
        </form>

        <div class="social-icons">
          <p>Or sign in with:</p>
          <div class="social-buttons">
            <a href="#" class="social-btn google"><i class="fab fa-google"></i></a>
            <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-btn twitter"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </section>
    </div>
  </main>

  <footer class="login-footer">
    <div class="container">
      <p><u>Web by Hanli-71220875 & Dandy - 71220873</u></p>
    </div>
  </footer>

  <script>
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
    });
  </script>
</body>
</html>