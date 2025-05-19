-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 08:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jadwal_gilang`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru_mapel`
--

CREATE TABLE `guru_mapel` (
  `guru_id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru_mapel`
--

INSERT INTO `guru_mapel` (`guru_id`, `mapel_id`) VALUES
(2, 1),
(2, 2),
(3, 3),
(3, 4),
(4, 5),
(4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `hari` int(11) NOT NULL COMMENT '1-5 (Senin-Jumat)',
  `jam_ke` int(11) NOT NULL COMMENT '1-12',
  `sampai_jam_ke` int(11) NOT NULL COMMENT '1-12',
  `jam_mulai` time NOT NULL COMMENT '07:00-dst',
  `jam_selesai` time NOT NULL COMMENT '07:00-dst',
  `mapel_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `ruangan_id` int(11) NOT NULL,
  `semester` int(11) NOT NULL DEFAULT 1,
  `tahun_ajaran` varchar(9) NOT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `hari`, `jam_ke`, `sampai_jam_ke`, `jam_mulai`, `jam_selesai`, `mapel_id`, `kelas_id`, `guru_id`, `ruangan_id`, `semester`, `tahun_ajaran`, `tanggal`) VALUES
(1, 1, 1, 6, '07:00:00', '12:30:00', 1, 4, 3, 3, 1, '2025/2026', '2025-04-28');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`) VALUES
(1, 'X RPL A'),
(2, 'X RPL B'),
(3, 'X RPL C'),
(4, 'XI RPL A'),
(5, 'XI RPL B'),
(6, 'XI RPL C'),
(7, 'XII RPL A'),
(8, 'XII RPL B'),
(9, 'XII RPL C');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int(11) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `kode_mapel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `nama_mapel`, `kode_mapel`) VALUES
(1, 'Kompetensi Keahlian Pemrograman Perangkat Bergerak', 'MOBILE'),
(2, 'MP PPLG', 'MPPPLG'),
(3, 'KK-BD', 'KKBD'),
(4, 'KK-PTGM', 'KKPTGM'),
(5, 'Kompetensi Keahlian Pemrogaman Web', 'WEB'),
(6, 'Bahasa Indonesia', 'BINDO'),
(7, 'Bahasa Inggris', 'BING'),
(8, 'Matematika', 'MAT');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id` int(11) NOT NULL,
  `nama_ruangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id`, `nama_ruangan`) VALUES
(1, 'Lab ASM 1'),
(2, 'Lab ASM 2'),
(3, 'Lab ASM 3'),
(4, 'R 201'),
(5, 'R 202');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('admin','guru','murid') NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `role`, `kelas_id`, `created_at`) VALUES
(1, 'admin', '$2y$10$WtVXXbD8bIHKealMIEcavORjfMbKwuePgiAvX3RzmZ4s6zyWX15b2', 'Admin Sekolah', 'admin', NULL, '2025-04-28 09:42:53'),
(2, 'guru1', '$2y$10$WtVXXbD8bIHKealMIEcavORjfMbKwuePgiAvX3RzmZ4s6zyWX15b2', 'Ahmad Ridwan', 'guru', NULL, '2025-04-28 09:42:53'),
(3, 'guru2', '$2y$10$WtVXXbD8bIHKealMIEcavORjfMbKwuePgiAvX3RzmZ4s6zyWX15b2', 'Siti Nurhaliza', 'guru', NULL, '2025-04-28 09:42:53'),
(4, 'guru3', '$2y$10$WtVXXbD8bIHKealMIEcavORjfMbKwuePgiAvX3RzmZ4s6zyWX15b2', 'Budi Santoso', 'guru', NULL, '2025-04-28 09:42:53'),
(5, 'murid1', '$2y$10$WtVXXbD8bIHKealMIEcavORjfMbKwuePgiAvX3RzmZ4s6zyWX15b2', 'Andi Pratama', 'murid', 1, '2025-04-28 09:42:53'),
(6, 'murid2', '$2y$10$WtVXXbD8bIHKealMIEcavORjfMbKwuePgiAvX3RzmZ4s6zyWX15b2', 'Dewi Lestari', 'murid', 2, '2025-04-28 09:42:53'),
(7, 'murid3', '$2y$10$WtVXXbD8bIHKealMIEcavORjfMbKwuePgiAvX3RzmZ4s6zyWX15b2', 'Rizki Prasetyo', 'murid', 3, '2025-04-28 09:42:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  ADD PRIMARY KEY (`guru_id`,`mapel_id`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mapel_id` (`mapel_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `ruangan_id` (`ruangan_id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_mapel` (`kode_mapel`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  ADD CONSTRAINT `guru_mapel_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `guru_mapel_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`);

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`id`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `jadwal_ibfk_4` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
