-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2020 at 11:18 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_skm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(12) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `status` int(1) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `nama`, `status`, `password`) VALUES
('baak', 'baak', 3, 'akubaak'),
('superadmin', 'superadmin', 5, 'akusuper');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `username` varchar(12) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `alamat` text NOT NULL,
  `password` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`username`, `nama`, `alamat`, `password`, `status`) VALUES
('16.9017', 'Antonius Andri', 'Jl. Bonasel 2', '16.9017', 1),
('16.9063', 'D. Agung Sungkono', 'Jl. Bonasel 1', '16.9063', 1),
('16.9066', 'Dayanti Kharisma', 'Jl. Bonasel 1', '16.9066', 1),
('16.9276', 'Mohamad Yusup', 'Jl. Asem', '16.9276', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_skm`
--

CREATE TABLE `pengajuan_skm` (
  `id` int(11) NOT NULL,
  `username` varchar(12) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `tujuan` text NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1',
  `tgl_setuju` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_final` datetime NOT NULL,
  `no_skm` int(1) NOT NULL,
  `no_surat` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengajuan_skm`
--

INSERT INTO `pengajuan_skm` (`id`, `username`, `nama`, `tujuan`, `tanggal`, `status`, `tgl_setuju`, `tgl_final`, `no_skm`, `no_surat`) VALUES
(1, '16.9063', 'D. Agung Sungkono', 'Kunjungan ke BPS daerah', '2020-08-05 22:31:37', 4, '2020-08-07 19:53:11', '2020-08-07 19:53:54', 12, 'B-012/2710/KM/08/2020'),
(8, '16.9017', 'Antonius Andri', 'Ikut Lomba Nasional', '2020-08-06 00:56:15', 4, '2020-08-07 11:21:10', '0000-00-00 00:00:00', 10, 'B-010/2710/KM/08/2020'),
(9, '16.9017', 'Antonius Andri', 'Untuk SMA', '2020-08-07 11:25:23', 3, '2020-08-07 11:29:33', '0000-00-00 00:00:00', 0, ''),
(10, '16.9017', 'Antonius Andri', 'Lomba Voli Regional Jawa Barat', '2020-08-07 12:17:33', 2, '2020-08-07 21:14:08', '0000-00-00 00:00:00', 1, ''),
(11, '16.9017', 'Antonius Andri', 'OPTK 2021\n', '2020-08-07 12:30:12', 5, '2020-08-07 12:31:44', '0000-00-00 00:00:00', 0, ''),
(12, '16.9276', 'Mohamad Yusup', 'OPTK 2021', '2020-08-07 12:31:02', 0, '2020-08-07 12:31:11', '0000-00-00 00:00:00', 0, ''),
(13, '16.9276', 'Mohamad Yusup', 'Karateka 2020', '2020-08-07 12:31:24', 4, '2020-08-07 12:31:56', '0000-00-00 00:00:00', 11, 'B-011/2710/KM/08/2020'),
(14, '16.9276', 'Mohamad Yusup', 'OPTK 2022', '2020-08-07 18:54:15', 3, '2020-08-07 19:58:53', '0000-00-00 00:00:00', 0, ''),
(15, '16.9017', 'Antonius Andri', 'Lomba Paduan Suara', '2020-08-07 19:10:11', 4, '2020-08-07 19:45:01', '2020-08-07 21:11:38', 13, 'B-013/2710/KM/08/2020'),
(16, '16.9017', 'Antonius Andri', 'Padus 2020', '2020-08-07 20:18:13', 0, '2020-08-07 20:18:13', '0000-00-00 00:00:00', 0, ''),
(17, '16.9017', 'Antonius Andri', 'Minta untuk lomba', '2020-08-07 21:10:25', 2, '2020-08-07 21:10:41', '0000-00-00 00:00:00', 0, ''),
(18, '16.9063', 'D. Agung Sungkono', 'OPTK 2020', '2020-08-07 21:13:37', 4, '2020-08-07 21:14:03', '2020-08-07 22:53:46', 14, 'B-014/2710/KM/08/2020'),
(19, '16.9063', 'D. Agung Sungkono', 'OPTK 2021', '2020-08-07 21:13:45', 2, '2020-08-07 21:14:00', '0000-00-00 00:00:00', 0, ''),
(20, '16.9017', 'Antonius Andri', 'minta surat dokter', '2020-08-07 22:49:34', 1, '2020-08-07 22:49:34', '0000-00-00 00:00:00', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pengajuan_skm`
--
ALTER TABLE `pengajuan_skm`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengajuan_skm`
--
ALTER TABLE `pengajuan_skm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
