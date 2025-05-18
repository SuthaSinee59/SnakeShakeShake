-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 11:40 AM
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
-- Database: `snake_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `profile_image` varchar(50) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `profile_picture`, `display_name`, `profile_image`) VALUES
(1, 'testuser', 'pvzrziua ', NULL, NULL, 'default.png'),
(2, 'ABC1', '$2y$10$KVFpMP.dRcvxAzSBcr/b9ukbC7r/2Qzzj4BPOcSp8X8bk1yswcs0y', NULL, NULL, 'default.png'),
(6, 'Asd123', '$2y$10$hX7eH53SHwWhrSsRuln29O9WQfdFJdNAHurFSYHLPE56VNjTWDRg2', NULL, 'เลิฟฟ', '681b5522e4417.png'),
(7, 'marx', '$2y$10$mzMCVBqCUF3.iSqh73vxqeXDXMOsRrjRSo0y5Vec3adPK9mPLCz8q', NULL, NULL, 'default.png'),
(8, 'w8', '$2y$10$AtTuF/vvnWi0KWNmm6nMOewOk54HKhJnT4qRyIdpgBAf8m8SnQQOO', NULL, 'ยัยบี๋', '68213000b8029.jpg'),
(9, 'Aq1', '$2y$10$amVV9sQZTcobgZHWTIkNFelncZN3OFGlWXPFWtqvxcrMJ27echPf2', NULL, NULL, 'default.png'),
(10, 'DARKNESS', '$2y$10$N9i5wC9T4Qo6guMxzgLQ5O1YLFZt6xqneeEjZn50HrQmrBx1PEv5K', NULL, 'ดลพ่อทุกสถาบัน', 'default.png'),
(11, 'replay1', '$2y$10$B7Hdmb6gMaK/hNr42C9Kn..1mXl8f6IckEcdLeVTr6MlJB4FcKIlG', NULL, 'ดอกไม้', '6825598c4a369.jpg'),
(13, 'tester1', 'TTtt1234@', NULL, NULL, 'default.png'),
(14, 'q1', 'QQqq123!', NULL, NULL, 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
