-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 11 Jun 2025 pada 06.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `lamaran`
--

CREATE TABLE `lamaran` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lowongan_id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nomor_hp` varchar(20) NOT NULL,
  `path_cv` varchar(255) NOT NULL,
  `path_portofolio` varchar(255) DEFAULT NULL,
  `surat_lamaran` text DEFAULT NULL,
  `tanggal_lamaran` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lowongan_pekerjaan`
--

CREATE TABLE `lowongan_pekerjaan` (
  `id` int(11) NOT NULL,
  `perusahaan_id` int(11) NOT NULL,
  `nama_pekerjaan` varchar(255) NOT NULL,
  `kategori_pekerjaan` varchar(100) NOT NULL,
  `jenis_pekerjaan` enum('Full-time','Part-time','Remote','Freelance','Kontrak','Magang') NOT NULL,
  `deskripsi` text NOT NULL,
  `syarat_kualifikasi` text NOT NULL,
  `gaji_awal` int(11) DEFAULT NULL,
  `gaji_akhir` int(11) DEFAULT NULL,
  `tanggal_batas_lamaran` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lowongan_pekerjaan`
--

INSERT INTO `lowongan_pekerjaan` (`id`, `perusahaan_id`, `nama_pekerjaan`, `kategori_pekerjaan`, `jenis_pekerjaan`, `deskripsi`, `syarat_kualifikasi`, `gaji_awal`, `gaji_akhir`, `tanggal_batas_lamaran`, `created_at`) VALUES
(1, 1, 'Software Quality Assurance', 'IT', 'Full-time', 'Bertanggung jawab untuk memastikan kualitas perangkat lunak melalui pengujian manual dan otomatis sebelum dirilis ke publik.', 'Memiliki pemahaman kuat tentang siklus hidup pengembangan perangkat lunak (SDLC) dan metodologi pengujian. Mampu membuat skenario pengujian yang detail.', 5000000, 8000000, '2025-08-30', '2025-06-11 04:14:17'),
(2, 1, 'UI/UX Designer', 'Desain', 'Full-time', 'Merancang antarmuka pengguna (UI) dan pengalaman pengguna (UX) yang intuitif dan menarik untuk aplikasi web dan mobile kami.', 'Menguasai alat desain seperti Figma, Sketch, atau Adobe XD. Memiliki portofolio yang menunjukkan proses desain dari riset hingga prototipe.', 6000000, 9000000, '2025-08-25', '2025-06-11 04:14:17'),
(3, 2, 'Smartfren Gadget Specialist', 'Sales', 'Full-time', 'Memberikan penjelasan produk dan layanan Smartfren kepada pelanggan di galeri, serta membantu proses aktivasi dan penjualan.', 'Pria/Wanita, maks. 26 tahun, berpenampilan menarik, memiliki kemampuan komunikasi yang baik, dan tertarik pada dunia gadget.', 3500000, 5000000, '2025-08-15', '2025-06-11 04:14:17'),
(4, 2, 'Customer Service Representative', 'Layanan Pelanggan', 'Kontrak', 'Menangani keluhan dan pertanyaan pelanggan melalui telepon, email, dan media sosial dengan ramah dan solutif.', 'Sabar, memiliki kemampuan problem-solving, bersedia bekerja dalam sistem shift.', 3000000, 4500000, '2025-08-20', '2025-06-11 04:14:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pencari_kerja`
--

CREATE TABLE `pencari_kerja` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `nomor_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pencari_kerja`
--

INSERT INTO `pencari_kerja` (`id`, `user_id`, `nama_lengkap`, `tanggal_lahir`, `nomor_hp`) VALUES
(1, 1, 'Hanli', '2000-01-01', '081234567890');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `logo_perusahaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `user_id`, `nama_perusahaan`, `lokasi`, `logo_perusahaan`) VALUES
(1, 2, 'Volantis Technology', 'Yogyakarta', 'IMAGE/Lowongan-Kerja-di-Volantis-Technology-2-100x87.png'),
(2, 3, 'PT. Smartfren Telecom Tbk', 'Yogyakarta', 'IMAGE/Lowongan-Kerja-di-PT.-Smartfren-100x87.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Pencari Kerja','Perusahaan') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'hanli@gmail.com', 'GANTI_DENGAN_HASH_YANG_ANDA_BUAT', 'Pencari Kerja', '2025-06-11 04:14:17'),
(2, 'hr@volantis.com', '$2y$10$wK1y3eOPdJc8W5aQv7b.y.rZ1nZ.s5G9uO7x/t8C0e2F6aD4E3b.G', 'Perusahaan', '2025-06-11 04:14:17'),
(3, 'hr@smartfren.com', '$2y$10$t2mC/I.n/x9.E9d/j.j4h.a7R7.d6x/gK5.s4jJ.d3a6x/l9k7J3.', 'Perusahaan', '2025-06-11 04:14:17');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_lamaran` (`user_id`,`lowongan_id`),
  ADD KEY `lowongan_id` (`lowongan_id`);

--
-- Indeks untuk tabel `lowongan_pekerjaan`
--
ALTER TABLE `lowongan_pekerjaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perusahaan_id` (`perusahaan_id`);

--
-- Indeks untuk tabel `pencari_kerja`
--
ALTER TABLE `pencari_kerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lowongan_pekerjaan`
--
ALTER TABLE `lowongan_pekerjaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pencari_kerja`
--
ALTER TABLE `pencari_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  ADD CONSTRAINT `lamaran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lamaran_ibfk_2` FOREIGN KEY (`lowongan_id`) REFERENCES `lowongan_pekerjaan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lowongan_pekerjaan`
--
ALTER TABLE `lowongan_pekerjaan`
  ADD CONSTRAINT `lowongan_pekerjaan_ibfk_1` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pencari_kerja`
--
ALTER TABLE `pencari_kerja`
  ADD CONSTRAINT `pencari_kerja_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD CONSTRAINT `perusahaan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
