-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2025 at 10:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `universitas_lord_dream`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `nip` varchar(10) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `matkul_ajar` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`nip`, `nama`, `matkul_ajar`, `password`) VALUES
('198001', 'Dr. H. Ahmad Santoso, M.Kom', 'Pemrograman Web', 'admin'),
('198002', 'Ust. Fadli Hamzah, M.Ag', 'Pendidikan Islam', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `kode_mk` varchar(10) DEFAULT NULL,
  `nip` varchar(10) DEFAULT NULL,
  `nama_dosen` varchar(30) DEFAULT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `ruang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `kode_mk`, `nip`, `nama_dosen`, `hari`, `jam_mulai`, `jam_selesai`, `ruang`) VALUES
(1, 'IF001', '198001', 'Dr. H. Ahmad Santoso, M.Kom', 'Senin', '08:00:00', '10:00:00', 'Ruang A1'),
(2, 'PAI01', '198002', 'Ust. Fadli Hamzah, M.Ag', 'Selasa', '10:00:00', '12:00:00', 'Ruang B2'),
(3, 'IF002', '198001', 'Dr. H. Ahmad Santoso, M.Kom', 'Rabu', '13:00:00', '15:00:00', 'Ruang C3'),
(4, 'UM001', '198002', 'Ust. Fadli Hamzah, M.Ag', 'Jumat', '13:00:00', '15:00:00', 'Ruang C3');

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id_krs` int(11) NOT NULL,
  `nim` varchar(10) DEFAULT NULL,
  `kode_mk` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id_krs`, `nim`, `kode_mk`) VALUES
(1, '230001', 'IF001'),
(2, '230001', 'IF002'),
(3, '230002', 'PAI01'),
(4, '230002', 'UM001'),
(5, '230003', 'IF001'),
(6, '230003', 'UM001'),
(7, '230004', 'PAI01'),
(8, '230004', 'UM001'),
(9, '230005', 'IF002'),
(10, '230005', 'PAI01');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(10) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `jurusan`, `alamat`, `password`) VALUES
('230001', 'Deni Pratama Wijaya', 'Teknik Informatika', 'Jl. Mimpi No. 1', '12345'),
('230002', 'Nabila Nur Ismayanti', 'Pendidikan Agama Islam', 'Jl. Harapan No. 2', '12345'),
('230003', 'Rizky Maulana', 'Sistem Informasi', 'Jl. Teknologi No. 3', '12345'),
('230004', 'Putri Ayu Lestari', 'Sastra Arab', 'Jl. Melati No. 4', '12345'),
('230005', 'Fahmi Ridwan', 'Manajemen Pendidikan', 'Jl. Pendidikan No. 5', '12345'),
('230006', 'Moch Firdaus Ridzky Ramadhan', 'Teknik Mesin', NULL, '12345');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `kode_mk` varchar(10) NOT NULL,
  `nama_mk` varchar(100) DEFAULT NULL,
  `sks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`kode_mk`, `nama_mk`, `sks`) VALUES
('IF001', 'Pemrograman Web', 3),
('IF002', 'Basis Data', 3),
('PAI01', 'Pendidikan Islam', 2),
('UM001', 'Bahasa Indonesia', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `nim` varchar(10) DEFAULT NULL,
  `kode_mk` varchar(10) DEFAULT NULL,
  `nilai` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `nim`, `kode_mk`, `nilai`) VALUES
(1, '230001', 'IF001', 'A'),
(2, '230001', 'IF002', 'B'),
(3, '230002', 'PAI01', 'A'),
(4, '230002', 'UM001', 'A'),
(5, '230003', 'IF001', 'B'),
(6, '230003', 'UM001', 'B'),
(7, '230004', 'PAI01', 'A'),
(8, '230004', 'UM001', 'B'),
(9, '230005', 'IF002', 'B'),
(10, '230005', 'PAI01', 'B');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `kode_mk` (`kode_mk`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id_krs`),
  ADD KEY `nim` (`nim`),
  ADD KEY `kode_mk` (`kode_mk`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`kode_mk`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `nim` (`nim`),
  ADD KEY `kode_mk` (`kode_mk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id_krs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`kode_mk`) REFERENCES `matakuliah` (`kode_mk`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`nip`) REFERENCES `dosen` (`nip`);

--
-- Constraints for table `krs`
--
ALTER TABLE `krs`
  ADD CONSTRAINT `krs_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`),
  ADD CONSTRAINT `krs_ibfk_2` FOREIGN KEY (`kode_mk`) REFERENCES `matakuliah` (`kode_mk`);

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`),
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`kode_mk`) REFERENCES `matakuliah` (`kode_mk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
