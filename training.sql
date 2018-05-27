-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2018 at 11:45 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `training`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_type` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'super:1, admin:2',
  `ins_id` int(11) NOT NULL COMMENT '登録者ID',
  `upd_id` int(11) DEFAULT NULL COMMENT '更新者ID',
  `ins_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `upd_datetime` timestamp NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新日時',
  `del_flag` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '削除フラグ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`, `email`, `avatar`, `role_type`, `ins_id`, `upd_id`, `ins_datetime`, `upd_datetime`, `del_flag`) VALUES
(1, 'Hoang Pham', '4297f44b13955235245b2497399d7a93', 'hoangph.paraline@gmail.com', 'avatar_20180523135742.jpg', '1', 1, 1, '2018-05-09 03:06:02', '2018-05-23 06:57:42', '0'),
(2, 'hoang2', '4297f44b13955235245b2497399d7a93', 'hoang2@gmail.com', 'avatar_20180523140725.jpg', '2', 1, 1, '2018-05-11 02:47:14', '2018-05-23 07:07:25', '0'),
(3, 'Cristiano Admin', '4297f44b13955235245b2497399d7a93', 'admin1@gmail.com', 'avatar_20180523140615.jpg', '2', 1, 1, '2018-05-11 06:42:00', '2018-05-24 07:59:39', '0'),
(4, 'admin4', '4297f44b13955235245b2497399d7a93', 'admin4@gmail.com', 'avatar_20180523140604.jpg', '2', 1, 1, '2018-05-11 07:42:34', '2018-05-23 07:06:04', '0'),
(5, 'admin2', '4297f44b13955235245b2497399d7a93', 'admin2@gmail.com', 'avatar_20180523140950.jpg', '2', 1, 1, '2018-05-03 01:44:03', '2018-05-23 07:09:50', '0'),
(6, 'Hoang Pham', '4297f44b13955235245b2497399d7a93', 'hoangpham2395@gmail.com', 'avatar_20180523141155.jpg', '1', 1, 1, '2018-05-30 16:43:30', '2018-05-24 07:56:59', '0'),
(7, 'Admin Y', '4297f44b13955235245b2497399d7a93', 'yadmin@gmail.com', 'avatar_20180523140511.jpg', '2', 6, 1, '0000-00-00 00:00:00', '2018-05-23 07:05:11', '0'),
(8, 'B Admin', '4297f44b13955235245b2497399d7a93', 'adminb@gmail.com', 'avatar_20180523140439.jpg', '2', 6, 1, '0000-00-00 00:00:00', '2018-05-23 07:04:39', '0'),
(9, 'acxcxcx', '4297f44b13955235245b2497399d7a93', 'admin3@gmail.com', '', '2', 6, 1, '0000-00-00 00:00:00', '2018-05-17 15:39:19', '0'),
(10, 'adc ad', '4297f44b13955235245b2497399d7a93', 'admin5@gmail.com', 'avatar_20180523140419.jpg', '2', 6, 1, '0000-00-00 00:00:00', '2018-05-23 07:04:19', '0'),
(11, '123', '4297f44b13955235245b2497399d7a93', 'ty@gmail.com', '', '2', 6, 1, '2018-05-02 18:23:03', '2018-05-18 06:59:54', '0'),
(12, 'vysin', '4297f44b13955235245b2497399d7a93', 'sinvy@gmail.com111', 'avatar_20180523140402.jpg', '2', 1, 1, '0000-00-00 00:00:00', '2018-05-23 07:04:02', '0'),
(13, 'admin 7', '4297f44b13955235245b2497399d7a93', 'admin7@gmail.com', 'avatar_20180523140340.jpg', '2', 1, 1, '2018-05-21 06:27:08', '2018-05-24 04:27:50', '0'),
(14, 'admin 8', '4297f44b13955235245b2497399d7a93', 'admin8@gmail.com', 'avatar_20180523140330.jpg', '2', 1, 1, '2018-05-21 06:28:38', '2018-05-23 07:03:30', '0'),
(15, 'admin 10', '4297f44b13955235245b2497399d7a93', 'admin10@gmail.com', 'avatar_20180523140317.jpg', '2', 1, 1, '2018-05-21 08:03:36', '2018-05-23 07:03:17', '0'),
(16, 'admin 11', '4297f44b13955235245b2497399d7a93', 'admin11@gmail.com', 'avatar_20180523140257.jpg', '2', 1, 1, '2018-05-22 08:20:56', '2018-05-24 07:40:32', '0'),
(17, 'admin 12', '4297f44b13955235245b2497399d7a93', 'admin12@gmail.com', 'avatar_20180523135039.jpg', '2', 1, 1, '2018-05-22 08:26:45', '2018-05-23 06:50:39', '0'),
(18, 'admin 20', '4297f44b13955235245b2497399d7a93', 'admin20@gmail.com', 'avatar_20180524113320.jpg', '2', 1, 1, '2018-05-24 04:32:52', '2018-05-24 08:09:57', '1'),
(19, '123', '4297f44b13955235245b2497399d7a93', '123@SDSD', 'avatar_20180524114710.jpg', '2', 6, 1, '2018-05-24 04:41:00', '2018-05-24 08:07:36', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '1:hoạt động, 2:khóa',
  `ins_id` int(11) NOT NULL COMMENT '登録者ID',
  `upd_id` int(11) DEFAULT NULL COMMENT '更新者ID',
  `ins_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `upd_datetime` timestamp NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新日時',
  `del_flag` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '削除フラグ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `facebook_id`, `status`, `ins_id`, `upd_id`, `ins_datetime`, `upd_datetime`, `del_flag`) VALUES
(1, 'PH Hoang', 'phhoang@gmail.com', '1231312314645121', '1', 1, 6, '2018-05-09 09:54:53', '2018-05-15 17:19:35', '0'),
(2, 'hoatv', 'hoale1195@yahoo.com', '1231231231231123', '1', 1, 1, '2018-05-10 05:39:29', '2018-05-17 20:59:25', '0'),
(5, 'B Hoang', 'bhoang@gmail.com', '1127051477448889', '1', 1, 1, '2018-05-15 03:55:18', '2018-05-15 03:55:18', '0'),
(6, 'E Hoang', 'xhoang@gmail.com', '1127051477448811', '1', 1, 6, '2018-05-15 09:31:53', '2018-05-15 16:55:42', '0'),
(7, 'Y Hoang ', 'qhoang@gmail.com', '1127051477448821', '2', 1, 6, '2018-05-15 09:55:03', '2018-05-16 10:28:11', '0'),
(9, 'z name', 'choang@gmail.com', '1212121243126534', '1', 1, 6, '2018-05-15 17:36:29', '2018-05-16 10:28:31', '0'),
(10, 'b name', 'fname@gmail.com', '1812737362877634', '1', 1, 1, '2018-05-15 17:36:29', '2018-05-17 21:34:49', '0'),
(11, 'd name', 'tname@gmail.com', '1275837584739748', '2', 2, 1, '2018-05-15 17:37:37', '2018-05-22 07:15:27', '0'),
(12, 'u name', 'aname@gmail.com', '1247564738474658', '1', 1, 1, '2018-05-15 17:39:10', '2018-05-24 02:04:23', '0'),
(13, 'm name', 'gname@gmail.com', '1246738572947295', '1', 1, 1, '2018-05-15 17:40:55', '2018-05-24 02:27:34', '0'),
(14, 'abc', 'xaaaa@gmail.com', '1231231231231231', '1', 1, 1, '2018-05-15 17:40:55', '2018-05-24 01:52:03', '0'),
(21, 'Gunner The', 'vuchung6161@gmail.com', '207747136684696', '2', 1, 0, '2018-05-17 02:40:27', '2018-05-23 08:38:33', '0'),
(22, 'Hoang Pham', 'hoangpham2395@gmail.com', '1127051477448880', '1', 1, 1, '2018-05-17 05:41:45', '2018-05-17 05:41:45', '1'),
(23, 'Hoang Pham', 'hoangpham2395@gmail.com', '1127051477448880', '1', 1, 1, '2018-05-22 10:03:08', '2018-05-22 10:03:08', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
