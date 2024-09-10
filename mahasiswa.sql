-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 05:16 PM
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
-- Database: `mahasiswa`
--
CREATE DATABASE IF NOT EXISTS `mahasiswa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mahasiswa`;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `jurusan` varchar(10) DEFAULT NULL,
  `ikut_mbkm` tinyint(1) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nama`, `kelas`, `jurusan`, `ikut_mbkm`, `gender`) VALUES
(1, 'Mahasiswa 1', 'A', 'TI', 1, 'L'),
(2, 'Mahasiswa 2', 'B', 'TI', 1, 'L'),
(3, 'Mahasiswa 3', 'A', 'TI', 0, 'L'),
(4, 'Mahasiswa 4', 'B', 'TI', 0, 'P'),
(5, 'Mahasiswa 5', 'A', 'TI', 1, 'L'),
(6, 'Mahasiswa 6', 'B', 'TI', 1, 'L'),
(7, 'Mahasiswa 7', 'A', 'TI', 0, 'P'),
(8, 'Mahasiswa 8', 'B', 'TI', 0, 'L'),
(9, 'Mahasiswa 9', 'A', 'TI', 1, 'L'),
(10, 'Mahasiswa 10', 'B', 'TI', 1, 'P'),
(11, 'Mahasiswa 11', 'A', 'TI', 0, 'L'),
(12, 'Mahasiswa 12', 'B', 'TI', 0, 'L'),
(13, 'Mahasiswa 13', 'A', 'TI', 1, 'P'),
(14, 'Mahasiswa 14', 'B', 'TI', 1, 'L'),
(15, 'Mahasiswa 15', 'A', 'TI', 0, 'L'),
(16, 'Mahasiswa 16', 'B', 'TI', 0, 'L'),
(17, 'Mahasiswa 17', 'A', 'TI', 1, 'L'),
(18, 'Mahasiswa 18', 'B', 'TI', 1, 'L'),
(19, 'Mahasiswa 19', 'A', 'TI', 0, 'L'),
(20, 'Mahasiswa 20', 'B', 'TI', 0, 'P'),
(21, 'Mahasiswa 21', 'A', 'TI', 0, 'L'),
(22, 'Mahasiswa 22', 'B', 'TI', 1, 'L'),
(23, 'Mahasiswa 23', 'A', 'TI', 0, 'P'),
(24, 'Mahasiswa 24', 'B', 'TI', 0, 'L'),
(25, 'Mahasiswa 25', 'A', 'TI', 1, 'L'),
(26, 'Mahasiswa 26', 'A', 'TI', 1, 'P'),
(27, 'Mahasiswa 27', 'B', 'TI', 0, 'L'),
(28, 'Mahasiswa 28', 'B', 'TI', 0, 'L'),
(29, 'Mahasiswa 29', 'A', 'TI', 1, 'P'),
(30, 'Mahasiswa 30', 'A', 'TI', 1, 'L'),
(31, 'Mahasiswa 31', 'B', 'TI', 0, 'L'),
(32, 'Mahasiswa 32', 'B', 'TI', 0, 'L'),
(33, 'Mahasiswa 33', 'A', 'TI', 1, 'L'),
(34, 'Mahasiswa 34', 'A', 'TI', 1, 'L'),
(35, 'Mahasiswa 35', 'B', 'TI', 0, 'L'),
(36, 'Mahasiswa 36', 'B', 'TI', 0, 'P'),
(37, 'Mahasiswa 37', 'A', 'TI', 1, 'L'),
(38, 'Mahasiswa 38', 'A', 'TI', 1, 'P'),
(39, 'Mahasiswa 39', 'A', 'SI', 1, 'L'),
(40, 'Mahasiswa 40', 'A', 'SI', 0, 'L'),
(41, 'Mahasiswa 41', 'B', 'SI', 1, 'L'),
(42, 'Mahasiswa 42', 'B', 'SI', 0, 'P'),
(43, 'Mahasiswa 43', 'A', 'SI', 1, 'L'),
(44, 'Mahasiswa 44', 'A', 'SI', 0, 'L'),
(45, 'Mahasiswa 45', 'B', 'SI', 1, 'P'),
(46, 'Mahasiswa 46', 'B', 'SI', 0, 'L'),
(47, 'Mahasiswa 47', 'A', 'SI', 1, 'L'),
(48, 'Mahasiswa 48', 'A', 'SI', 0, 'P'),
(49, 'Mahasiswa 49', 'B', 'SI', 1, 'L'),
(50, 'Mahasiswa 50', 'B', 'SI', 0, 'L'),
(51, 'Mahasiswa 51', 'A', 'SI', 1, 'P'),
(52, 'Mahasiswa 52', 'A', 'SI', 0, 'L'),
(53, 'Mahasiswa 53', 'B', 'SI', 1, 'L'),
(54, 'Mahasiswa 54', 'B', 'SI', 0, 'L'),
(55, 'Mahasiswa 55', 'A', 'SI', 1, 'L'),
(56, 'Mahasiswa 56', 'A', 'SI', 0, 'L'),
(57, 'Mahasiswa 57', 'B', 'SI', 1, 'L'),
(58, 'Mahasiswa 58', 'B', 'SI', 0, 'P'),
(59, 'Mahasiswa 59', 'A', 'SI', 0, 'L'),
(60, 'Mahasiswa 60', 'A', 'SI', 1, 'L'),
(61, 'Mahasiswa 61', 'B', 'SI', 1, 'P'),
(62, 'Mahasiswa 62', 'B', 'SI', 0, 'L'),
(63, 'Mahasiswa 63', 'A', 'SI', 1, 'L'),
(64, 'Mahasiswa 64', 'A', 'SI', 0, 'P'),
(65, 'Mahasiswa 65', 'B', 'SI', 1, 'L'),
(66, 'Mahasiswa 66', 'B', 'SI', 0, 'L'),
(67, 'Mahasiswa 67', 'A', 'SI', 1, 'P'),
(68, 'Mahasiswa 68', 'A', 'SI', 0, 'L'),
(69, 'Mahasiswa 69', 'B', 'SI', 1, 'L'),
(70, 'Mahasiswa 70', 'B', 'SI', 0, 'L'),
(71, 'Mahasiswa 71', 'A', 'SI', 1, 'L'),
(72, 'Mahasiswa 72', 'A', 'SI', 0, 'L'),
(73, 'Mahasiswa 73', 'B', 'SI', 1, 'L'),
(74, 'Mahasiswa 74', 'B', 'SI', 0, 'P'),
(75, 'Mahasiswa 75', 'A', 'SI', 1, 'L'),
(76, 'Mahasiswa 76', 'A', 'SI', 0, 'L');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
