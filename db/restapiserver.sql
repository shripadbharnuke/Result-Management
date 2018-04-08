-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2018 at 06:38 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restapiserver`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$08$7Bkco6JXtC3Hu6g9ngLZDuHsFLvT7cyAxiz1FzxlX5vwccvRT7nKW', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1523189933, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(12, '::1', 'shripad', '$2y$08$U/HjFtFszEbzKvjvAOzUvesihltnojyZBx0C4uyH/S3wMkc9kGpDi', NULL, 'shripad@admin.com', NULL, NULL, NULL, NULL, 1523181828, NULL, 1, 'Shripad', NULL, NULL, NULL),
(13, '::1', 'john', '$2y$08$Kja0FvE9//LzVJ92LLBU8uFIXcPsQiXDELFkoFlBnNdpKFEmIxqBq', NULL, 'john@admin.com', NULL, NULL, NULL, NULL, 1523181919, 1523186345, 1, 'John', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_groups`
--

CREATE TABLE `admin_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_groups`
--

INSERT INTO `admin_groups` (`id`, `name`, `code`, `description`) VALUES
(1, 'admin', 'WE32MN', 'Administrator'),
(2, 'teacher', 'FCV4RS', 'Teacher'),
(3, 'student', '', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `admin_login_attempts`
--

CREATE TABLE `admin_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users_groups`
--

CREATE TABLE `admin_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_users_groups`
--

INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(13, 12, 2),
(14, 13, 3);

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_shortcode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `apps`
--

INSERT INTO `apps` (`id`, `app_name`, `app_shortcode`) VALUES
(1, 'Rest', 'rest');

-- --------------------------------------------------------

--
-- Table structure for table `app_api_access_keys`
--

CREATE TABLE `app_api_access_keys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_id` int(10) NOT NULL DEFAULT '1',
  `device_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT '0',
  `api_access_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_api_access_keys`
--

INSERT INTO `app_api_access_keys` (`id`, `app_id`, `device_id`, `user_id`, `api_access_token`) VALUES
(6, 1, '123456789012345', 1, '01F56BE9-F7B5-7E23-BE5B-A0C1784B0AA2');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'imei',
  `device_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Device OS',
  `device_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Device model',
  `imsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'subscriber id',
  `vendor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Device Manufacturer',
  `width` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Device Window Width',
  `height` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Device Window Height',
  `locale` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL COMMENT 'Device Language',
  `wifi_mac` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Mac Address',
  `display_resolution` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'screen resolution',
  `display_size` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'screen size',
  `device_memory` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'device memory',
  `ts_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ts_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices_app_details`
--

CREATE TABLE `devices_app_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_id` int(10) NOT NULL DEFAULT '1',
  `device_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'imei',
  `package` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'App Package Name',
  `version_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'App Version Name',
  `version_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'App Version Code',
  `sdk` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SDK version of app development',
  `channel` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Google or other markets'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices_token`
--

CREATE TABLE `devices_token` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_id` int(10) NOT NULL DEFAULT '1',
  `device_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'imei',
  `device_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_identifier` varchar(170) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `math_marks` int(11) NOT NULL,
  `science_marks` int(11) NOT NULL,
  `english_marks` int(11) NOT NULL,
  `updated_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `user_id`, `math_marks`, `science_marks`, `english_marks`, `updated_on`, `active`) VALUES
(5, 8, 33, 28, 55, '2018-04-08 13:04:44', 1),
(6, 9, 55, 77, 88, '2018-04-08 13:11:03', 1),
(7, 10, 88, 77, 99, '2018-04-08 15:59:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `id` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`id`, `age`, `name`, `updated_on`, `active`) VALUES
(8, 14, 'student 1', '2018-04-08 13:04:44', 1),
(9, 14, 'student 2', '2018-04-08 13:11:03', 1),
(10, 12, 'student 3', '2018-04-08 14:14:14', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_groups`
--
ALTER TABLE `admin_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_login_attempts`
--
ALTER TABLE `admin_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users_groups`
--
ALTER TABLE `admin_users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_api_access_keys`
--
ALTER TABLE `app_api_access_keys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`),
  ADD KEY `api_access_token` (`api_access_token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`),
  ADD KEY `device_type` (`device_type`);

--
-- Indexes for table `devices_app_details`
--
ALTER TABLE `devices_app_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `devices_token`
--
ALTER TABLE `devices_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`),
  ADD KEY `device_type` (`device_type`),
  ADD KEY `push_identifier` (`push_identifier`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `admin_groups`
--
ALTER TABLE `admin_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_login_attempts`
--
ALTER TABLE `admin_login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_users_groups`
--
ALTER TABLE `admin_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_api_access_keys`
--
ALTER TABLE `app_api_access_keys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices_app_details`
--
ALTER TABLE `devices_app_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices_token`
--
ALTER TABLE `devices_token`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_users_groups`
--
ALTER TABLE `admin_users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `admin_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
