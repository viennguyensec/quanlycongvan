-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 22, 2018 at 11:51 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlycongvan`
--

-- --------------------------------------------------------

--
-- Table structure for table `CONGVANDEN`
--

CREATE TABLE `CONGVANDEN` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `kyhieu` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngaybanhanh` datetime DEFAULT CURRENT_TIMESTAMP,
  `coquanbanhanhId` int(11) DEFAULT NULL,
  `loaiId` int(11) DEFAULT NULL,
  `ngaynhan` datetime DEFAULT CURRENT_TIMESTAMP,
  `nguoinhan` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `nguoiky` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nguoiduyet` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `noidung` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `file` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `CONGVANDI`
--

CREATE TABLE `CONGVANDI` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `kihieu` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngaybanhanh` datetime DEFAULT CURRENT_TIMESTAMP,
  `noinhan` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `loaiId` int(11) DEFAULT NULL,
  `ngaynhan` datetime DEFAULT CURRENT_TIMESTAMP,
  `nguoigui` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nguoiky` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nguoiduyet` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `noidung` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `file` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coquanbanhanh`
--

CREATE TABLE `coquanbanhanh` (
  `id` int(11) NOT NULL,
  `ten` varchar(50) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL,
  `mota` varchar(100) CHARACTER SET utf16 COLLATE utf16_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loaicongvan`
--

CREATE TABLE `loaicongvan` (
  `id` int(11) NOT NULL,
  `ten` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mota` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CONGVANDEN`
--
ALTER TABLE `CONGVANDEN`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `loaiId` (`loaiId`),
  ADD KEY `coquanbanhanhId` (`coquanbanhanhId`);

--
-- Indexes for table `CONGVANDI`
--
ALTER TABLE `CONGVANDI`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `loaiId` (`loaiId`);

--
-- Indexes for table `coquanbanhanh`
--
ALTER TABLE `coquanbanhanh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loaicongvan`
--
ALTER TABLE `loaicongvan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CONGVANDEN`
--
ALTER TABLE `CONGVANDEN`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `CONGVANDI`
--
ALTER TABLE `CONGVANDI`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coquanbanhanh`
--
ALTER TABLE `coquanbanhanh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loaicongvan`
--
ALTER TABLE `loaicongvan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `CONGVANDEN`
--
ALTER TABLE `CONGVANDEN`
  ADD CONSTRAINT `congvanden_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `congvanden_ibfk_2` FOREIGN KEY (`loaiId`) REFERENCES `loaicongvan` (`id`),
  ADD CONSTRAINT `congvanden_ibfk_3` FOREIGN KEY (`coquanbanhanhId`) REFERENCES `coquanbanhanh` (`id`);

--
-- Constraints for table `CONGVANDI`
--
ALTER TABLE `CONGVANDI`
  ADD CONSTRAINT `congvandi_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `congvandi_ibfk_2` FOREIGN KEY (`loaiId`) REFERENCES `loaicongvan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
