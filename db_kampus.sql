-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2026 at 06:34 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kampus`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(15) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `usia` int(3) DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `alamat`, `tanggal_lahir`, `usia`, `gender`) VALUES
('A727727', 'jaka', 'solo', '2018-02-02', 8, 'Laki-laki'),
('B54566', 'cece', 'solo', '2026-02-05', 0, 'Perempuan'),
('J8273737', 'ara', ' raya', '2026-02-03', 0, 'Perempuan'),
('K352201288', 'pppp', 'solo', '2020-02-06', 6, 'Laki-laki'),
('L4278877', 'kkk', 'kjjj', '2026-02-21', 0, 'Laki-laki'),
('L8888', 'kkkp', 'kkkpp', '2026-02-21', 0, 'Perempuan'),
('P488448', 'llllpp', 'llllkkk', '2021-02-01', 5, 'Laki-laki'),
('W4345555', 'asa', 'solo', '2002-02-07', 24, 'Perempuan'),
('Z522636', 'santo', 'solo raya', '2026-02-06', 0, 'Laki-laki');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
