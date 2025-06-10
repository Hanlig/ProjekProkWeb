# Project ProkWeb

![GitHub contributors](https://img.shields.io/github/contributors/Hanlig/ProjekProkWeb)

<div align="center">

<img src="IMAGE/batch-logo-removebg-preview.png" alt="Logo Proyek" width="150"/>

# **Portal Lowongan Pekerjaan**

Sebuah platform pencarian kerja dinamis yang menghubungkan talenta dengan peluang. Dibangun dengan PHP native, proyek ini menyediakan fungsionalitas inti untuk portal pekerjaan modern.

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://www.w3.org/Style/CSS/Overview.en.html)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://html.spec.whatwg.org/multipage/)

</div>

---

> Misi kami adalah menciptakan jembatan digital antara perusahaan dan para pencari kerja di Indonesia, mempermudah proses rekrutmen dan pencarian karir.

<br>

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Galeri](#-galeri)
- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi)
- [Panduan Instalasi](#-panduan-instalasi)
- [Struktur Database](#-struktur-database)
- [Roadmap](#-roadmap)
- [Kontributor](#-kontributor)

---

## 🌟 Tentang Proyek

Portal Lowongan Pekerjaan ini adalah aplikasi web yang dirancang untuk menjadi solusi lengkap bagi proses rekrutmen. Aplikasi ini memungkinkan perusahaan untuk mempublikasikan lowongan dan membantu pencari kerja menemukan pekerjaan impian mereka. Proyek ini dibangun dari dasar menggunakan **PHP Native**, menunjukkan pemahaman fundamental tentang pengembangan web sisi server.

### ✨ Galeri

<table>
  <tr>
    <td align="center"><strong>Halaman Utama</strong></td>
    <td align="center"><strong>Detail Lowongan</strong></td>
  </tr>
  <tr>
    <td><img src="https://via.placeholder.com/400x300.png?text=Halaman+Utama" alt="Halaman Utama"></td>
    <td><img src="https://via.placeholder.com/400x300.png?text=Halaman+Detail" alt="Halaman Detail"></td>
  </tr>
  <tr>
    <td align="center"><strong>Halaman Login</strong></td>
    <td align="center"><strong>Formulir Lamaran</strong></td>
  </tr>
  <tr>
    <td><img src="https://via.placeholder.com/400x300.png?text=Halaman+Login" alt="Halaman Login"></td>
    <td><img src="https://via.placeholder.com/400x300.png?text=Formulir+Lamaran" alt="Halaman Lamaran"></td>
  </tr>
</table>

---

## 🚀 Fitur Utama

-   **🔍 Pencarian & Filter Canggih:** Temukan lowongan berdasarkan kata kunci, kategori, dan lokasi.
-   **👤 Sistem Pengguna Berbasis Peran:**
    -   **Pencari Kerja**: Bisa menjelajahi dan melamar lowongan.
    -   **Perusahaan**: Bisa memposting dan mengelola lowongan.
-   **📄 Proses Lamaran Mudah:** Formulir aplikasi yang intuitif dengan fitur unggah CV dan portofolio.
-   **🔐 Keamanan Terjamin:** Proses autentikasi aman menggunakan `password_verify` dan manajemen sesi yang handal.
-   **🚫 Anti Lamaran Ganda:** Sistem secara cerdas mencegah pengguna melamar pekerjaan yang sama lebih dari sekali.
-   **⏰ Lowongan Aktif:** Hanya menampilkan pekerjaan yang masih dalam periode lamaran.

---

## 🛠️ Teknologi

Berikut adalah teknologi utama yang menjadi fondasi proyek ini:

| Teknologi                                                                                                 | Deskripsi                                 |
| --------------------------------------------------------------------------------------------------------- | ----------------------------------------- |
| [**PHP**](https.php.net)                                                                                | Bahasa utama untuk logika backend.        |
| [**MySQL**](https://mysql.com)                                                                            | Sistem manajemen database relasional.     |
| [**HTML5**](https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/HTML5)                                | Markup standar untuk membuat halaman web. |
| [**CSS3**](https://developer.mozilla.org/en-US/docs/Web/CSS)                                              | Styling untuk mempercantik tampilan.      |

---

## ⚙️ Panduan Instalasi

Ikuti langkah-langkah ini untuk menjalankan proyek secara lokal.

1.  **Prasyarat**
    -   Pastikan Anda memiliki web server lokal seperti [XAMPP](https://www.apachefriends.org/index.html) atau [WAMP](http://www.wampserver.com/en/).
    -   Akses ke phpMyAdmin atau *database client* lainnya.

2.  **Clone Proyek**
    ```sh
    git clone https://URL_REPOSITORI_ANDA.git
    cd nama_folder_proyek
    ```

3.  **Setup Database**
    -   Buka phpMyAdmin.
    -   Buat database baru dengan nama `db_job_portal`.
    -   Impor file `.sql` Anda ke dalam database ini untuk membuat semua tabel yang diperlukan.

4.  **Konfigurasi Koneksi**
    -   Buka file `db.php`.
    -   Sesuaikan detail koneksi dengan konfigurasi server lokal Anda.
        ```php
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'db_job_portal';
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, 3307); // Sesuaikan port jika perlu
        ```

5.  **Buat Folder `uploads`**
    -   Di dalam direktori utama proyek, buat sebuah folder baru bernama `uploads`.
        ```sh
        mkdir uploads
        ```
    -   Folder ini akan digunakan untuk menyimpan CV dan portofolio yang diunggah pelamar.

6.  **Jalankan Proyek**
    -   Letakkan folder proyek di dalam direktori web server Anda (`htdocs` atau `www`).
    -   Buka browser dan kunjungi `http://localhost/nama_folder_proyek/`.

---

## 🗄️ Struktur Database

Proyek ini menggunakan beberapa tabel utama untuk mengelola data:

-   `users`: Menyimpan data login pengguna (email, password, peran).
-   `perusahaan`: Menyimpan detail perusahaan (nama, lokasi, logo).
-   `pencari_kerja`: Menyimpan profil pencari kerja (nama, tgl lahir, dll).
-   `lowongan_pekerjaan`: Menyimpan semua detail lowongan pekerjaan.
-   `lamaran`: Mencatat riwayat lamaran dari pencari kerja ke lowongan tertentu.

---

## 🗺️ Roadmap

Berikut adalah beberapa ide fitur yang bisa dikembangkan selanjutnya untuk membuat platform ini lebih hebat:

-   [ ] **Dashboard Perusahaan**: Halaman bagi perusahaan untuk melihat daftar pelamar di setiap lowongan.
-   [ ] **Dashboard Pelamar**: Halaman bagi pencari kerja untuk melacak status lamaran mereka (dilihat, diproses, ditolak).
-   [ ] **Notifikasi Email**: Mengirim email otomatis saat lamaran berhasil dikirim atau saat statusnya berubah.
-   [ ] **Panel Admin**: Halaman super-user untuk mengelola semua data di platform.
-   [ ] **Fitur "Simpan Lowongan"**: Memungkinkan pengguna menyimpan pekerjaan yang mereka minati.

---

## 🧑‍💻 Kontributor

Proyek ini dikembangkan dengan penuh dedikasi oleh:

| Nama       | NIM      |
| ---------- | -------- |
| **Hanli** | 71220875 |
| **Dandy** | 71220873 |

<br>
<div align="center">
Made with ❤️ in Indonesia
</div>
