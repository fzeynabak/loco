-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2025 at 09:26 PM
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
-- Database: `locomotive_errors`
--

-- --------------------------------------------------------

--
-- Table structure for table `error_categories`
--

CREATE TABLE `error_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locomotive_errors`
--

CREATE TABLE `locomotive_errors` (
  `id` int(11) NOT NULL,
  `error_code` varchar(50) NOT NULL,
  `severity` enum('critical','major','minor','warning') NOT NULL,
  `description` text NOT NULL,
  `symptoms` text NOT NULL,
  `cause` text NOT NULL,
  `diagnosis_steps` text NOT NULL,
  `solution_steps` text NOT NULL,
  `required_tools` text DEFAULT NULL,
  `required_parts` text DEFAULT NULL,
  `estimated_repair_time` varchar(50) DEFAULT NULL,
  `safety_notes` text DEFAULT NULL,
  `technical_diagram` varchar(255) DEFAULT NULL,
  `video_guide` varchar(255) DEFAULT NULL,
  `maintenance_history` text DEFAULT NULL,
  `prevention_steps` text DEFAULT NULL,
  `solution` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `locomotive_type` varchar(100) NOT NULL,
  `component` varchar(100) NOT NULL,
  `sub_component` varchar(100) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locomotive_types`
--

CREATE TABLE `locomotive_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `technical_specs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`technical_specs`)),
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `attempt_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES
(1, 'registration_enabled', '1', 'فعال/غیرفعال کردن ثبت نام کاربران', '2025-04-24 20:18:03'),
(2, 'site_name', 'سیستم مدیریت خطاهای لوکوموتیو', 'نام سایت', '2025-04-24 20:18:03');

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action_type` enum('login','logout','create','update','delete','view') NOT NULL,
  `entity_type` varchar(50) NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `old_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_data`)),
  `new_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_data`)),
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('pending','active','blocked') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`, `last_login`) VALUES
(3, 'مصطفی اکرادی', 'akradim', 'akradim@gmail.com', '$2y$10$GwMsgcbbVR8sKBRDbPwaKexo1sB0Cw0AUBVtTFrigt8HZDEfaX6Qa', 'user', 'pending', '2025-04-24 20:30:11', NULL, NULL),
(4, 'مدیر سیستم', 'admin', 'admin@localhost', '$2y$10$qD9DHVgZXp8yKr6xQ2v7NuV5.MyVuE3/qtZZn0E/uXpKRzFvuaY6e', 'admin', 'active', '2025-04-24 22:41:11', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `error_categories`
--
ALTER TABLE `error_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `locomotive_errors`
--
ALTER TABLE `locomotive_errors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `error_code` (`error_code`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `locomotive_types`
--
ALTER TABLE `locomotive_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_attempts_username_idx` (`username`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `action_type` (`action_type`),
  ADD KEY `entity_type` (`entity_type`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `error_categories`
--
ALTER TABLE `error_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locomotive_errors`
--
ALTER TABLE `locomotive_errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locomotive_types`
--
ALTER TABLE `locomotive_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `error_categories`
--
ALTER TABLE `error_categories`
  ADD CONSTRAINT `error_categories_parent_id_fk` FOREIGN KEY (`parent_id`) REFERENCES `error_categories` (`id`);

--
-- Constraints for table `locomotive_errors`
--
ALTER TABLE `locomotive_errors`
  ADD CONSTRAINT `locomotive_errors_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `locomotive_errors_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD CONSTRAINT `system_logs_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
