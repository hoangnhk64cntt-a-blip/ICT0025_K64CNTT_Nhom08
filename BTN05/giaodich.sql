-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 17, 2026 at 08:46 AM
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
-- Database: `chi_tieu`
--

-- --------------------------------------------------------

--
-- Table structure for table `giaodich`
--

CREATE TABLE `giaodich` (
  `id` int(11) NOT NULL,
  `vi_tien_id` int(11) NOT NULL,
  `danh_muc_id` int(11) NOT NULL,
  `doi_tuong` enum('ca_nhan','gia_dinh') NOT NULL DEFAULT 'ca_nhan',
  `so_tien` decimal(15,2) NOT NULL,
  `ngay_giao_dich` date NOT NULL,
  `ghi_chu` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `giaodich`
--
ALTER TABLE `giaodich`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vi_tien_id` (`vi_tien_id`),
  ADD KEY `danh_muc_id` (`danh_muc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `giaodich`
--
ALTER TABLE `giaodich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `giaodich`
--
ALTER TABLE `giaodich`
  ADD CONSTRAINT `giaodich_ibfk_1` FOREIGN KEY (`vi_tien_id`) REFERENCES `vi_tien` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `giaodich_ibfk_2` FOREIGN KEY (`danh_muc_id`) REFERENCES `danhmuc` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
