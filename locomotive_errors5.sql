-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 10:03 AM
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
-- Table structure for table `breakdowns`
--

CREATE TABLE `breakdowns` (
  `id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `station_id` int(11) NOT NULL,
  `occurrence_date` datetime NOT NULL,
  `locomotive_type_id` int(11) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `current_mileage` int(11) DEFAULT NULL,
  `breakdown_symptoms` text NOT NULL,
  `actions_taken` text NOT NULL,
  `final_result` text DEFAULT NULL,
  `reported_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `breakdown_images`
--

CREATE TABLE `breakdown_images` (
  `id` int(11) NOT NULL,
  `breakdown_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `breakdown_videos`
--

CREATE TABLE `breakdown_videos` (
  `id` int(11) NOT NULL,
  `breakdown_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Dumping data for table `error_categories`
--

INSERT INTO `error_categories` (`id`, `name`, `description`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'مکانیکی', 'خطاهای مربوط به قطعات مکانیکی', NULL, '2025-04-25 06:51:50', NULL),
(2, 'الکتریکی', 'خطاهای مربوط به سیستم‌های الکتریکی', NULL, '2025-04-25 06:51:50', NULL),
(3, 'هیدرولیک', 'خطاهای مربوط به سیستم‌های هیدرولیک', NULL, '2025-04-25 06:51:50', NULL),
(4, 'الکترونیک', 'خطاهای مربوط به بردها و سیستم‌های الکترونیکی', NULL, '2025-04-25 06:51:50', NULL),
(5, 'موتور', 'خطاهای مربوط به موتور اصلی', NULL, '2025-04-25 06:51:50', NULL);

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

--
-- Dumping data for table `locomotive_errors`
--

INSERT INTO `locomotive_errors` (`id`, `error_code`, `severity`, `description`, `symptoms`, `cause`, `diagnosis_steps`, `solution_steps`, `required_tools`, `required_parts`, `estimated_repair_time`, `safety_notes`, `technical_diagram`, `video_guide`, `maintenance_history`, `prevention_steps`, `solution`, `category`, `locomotive_type`, `component`, `sub_component`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'ab-1605', 'critical', 'مسئولیت هدایت لکوموتیو و قطار را عهده دار می باشد. 16-14-1- شرایط سیر لکوموتیو: لکوموتیو هنگامی مجاز به حرکت است کـه سیستمهای ایمنی', 'ترمز نمیگیرد', 'قسیبل', 'لکومو', 'شرایط سیر لکوموتیو', 'سیب\r\nسیب\r\nیسبل', 'ترمز - 1656-1', '', '', NULL, NULL, NULL, NULL, NULL, '4', '1', 'سی', '', 4, '2025-04-25 07:05:32', NULL, NULL);

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

--
-- Dumping data for table `locomotive_types`
--

INSERT INTO `locomotive_types` (`id`, `name`, `model`, `manufacturer`, `description`, `technical_specs`, `created_at`, `updated_at`) VALUES
(1, 'GT26', 'GT26CW-2', 'جنرال الکتریک', 'لوکوموتیو دیزل-الکتریک', NULL, '2025-04-25 06:51:50', NULL),
(2, 'GE-C30', 'C30-7i', 'جنرال الکتریک', 'لوکوموتیو باری', NULL, '2025-04-25 06:51:50', NULL),
(3, 'زیمنس', 'IranRunner', 'زیمنس', 'لوکوموتیو مسافری', NULL, '2025-04-25 06:51:50', NULL),
(4, 'آلستوم', 'Prima H4', 'آلستوم', 'لوکوموتیو دو منظوره', NULL, '2025-04-25 06:51:50', NULL),
(5, '1', '15', 'امریکا', '', NULL, '2025-04-25 19:46:04', NULL);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission_name`, `description`, `created_at`) VALUES
(1, 'create_error', 'امکان افزودن خطای جدید', '2025-04-24 21:43:55'),
(2, 'view_users', 'امکان مشاهده لیست کاربران', '2025-04-24 21:43:55'),
(3, 'manage_permissions', 'امکان مدیریت دسترسی‌های کاربران', '2025-04-24 21:43:55');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`id`, `user_id`, `action_type`, `entity_type`, `entity_id`, `old_data`, `new_data`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 4, '', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 23:01:39'),
(2, 4, '', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 23:03:59'),
(3, 4, '', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 23:21:51'),
(4, 4, 'login', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 00:35:25'),
(5, 5, '', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 00:41:08'),
(6, 5, 'login', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 00:41:13'),
(7, 5, 'logout', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 01:22:43'),
(8, 4, 'login', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 01:22:53'),
(9, 4, 'create', 'locomotive_error', 1, NULL, '{\"error_code\":\"ab-1605\",\"description\":\"\\u0645\\u0633\\u0626\\u0648\\u0644\\u06cc\\u062a \\u0647\\u062f\\u0627\\u06cc\\u062a \\u0644\\u06a9\\u0648\\u0645\\u0648\\u062a\\u06cc\\u0648 \\u0648 \\u0642\\u0637\\u0627\\u0631 \\u0631\\u0627 \\u0639\\u0647\\u062f\\u0647 \\u062f\\u0627\\u0631 \\u0645\\u06cc \\u0628\\u0627\\u0634\\u062f. 16-14-1- \\u0634\\u0631\\u0627\\u06cc\\u0637 \\u0633\\u06cc\\u0631 \\u0644\\u06a9\\u0648\\u0645\\u0648\\u062a\\u06cc\\u0648: \\u0644\\u06a9\\u0648\\u0645\\u0648\\u062a\\u06cc\\u0648 \\u0647\\u0646\\u06af\\u0627\\u0645\\u06cc \\u0645\\u062c\\u0627\\u0632 \\u0628\\u0647 \\u062d\\u0631\\u06a9\\u062a \\u0627\\u0633\\u062a \\u06a9\\u0640\\u0647 \\u0633\\u06cc\\u0633\\u062a\\u0645\\u0647\\u0627\\u06cc \\u0627\\u06cc\\u0645\\u0646\\u06cc\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 07:05:32'),
(10, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 07:05:35'),
(11, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 07:10:56'),
(12, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 12:19:37'),
(13, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 12:19:45'),
(14, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 12:43:33'),
(15, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 12:48:52'),
(16, 4, 'login', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 18:35:33'),
(17, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 18:35:40'),
(18, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 19:48:03'),
(19, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 19:48:25'),
(20, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 19:50:46'),
(21, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 19:50:48'),
(22, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 19:51:10'),
(23, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 19:54:36'),
(24, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 19:55:33'),
(25, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 19:55:48'),
(26, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 21:30:19'),
(27, 5, '', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 22:21:11'),
(28, 6, '', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 22:21:59'),
(29, 6, 'login', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 22:22:05'),
(30, 4, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 22:26:15'),
(31, 3, 'login', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 09:22:53'),
(32, 3, 'logout', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Mobile Safari/537.36', '2025-04-26 09:25:07'),
(33, 3, 'login', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Mobile Safari/537.36', '2025-04-26 09:36:01'),
(34, 3, 'view', 'locomotive_error', 1, NULL, NULL, '::1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1', '2025-04-26 09:49:43'),
(35, 3, 'login', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Mobile Safari/537.36', '2025-04-26 10:02:05'),
(36, 3, 'logout', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Mobile Safari/537.36', '2025-04-26 10:08:33'),
(37, 3, 'login', 'auth', NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 10:57:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `personnel_number` varchar(10) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('pending','active','blocked') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `national_code` varchar(10) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `station_id` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `railway_station` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `mobile`, `personnel_number`, `password`, `role`, `status`, `created_at`, `updated_at`, `last_login`, `national_code`, `province_id`, `city_id`, `station_id`, `address`, `province`, `city`, `railway_station`) VALUES
(3, 'مصطفی اکرادی', 'akradim', 'akradim@gmail.com', NULL, NULL, '$2y$10$GwMsgcbbVR8sKBRDbPwaKexo1sB0Cw0AUBVtTFrigt8HZDEfaX6Qa', 'user', 'active', '2025-04-24 20:30:11', NULL, '2025-04-26 10:57:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'مدیر سیستم', 'admin', 'admin@localhost', '09911785401', '654635416', '$2y$10$Jh/tXdmgCQGSGqGWvvYQFuhZEJsmyxIqYriWsjj5ilitVO8KgQk7u', 'admin', 'active', '2025-04-24 22:41:11', '2025-04-25 11:25:57', '2025-04-25 18:35:33', '5730008971', NULL, NULL, NULL, 'یبلیسب سیب', '11', '236', 4),
(5, 'مهدی', 'shams', 'shams@hotmail.com', NULL, NULL, '$2y$10$jUHrW0Zgb0JzAvjDfzK7I.sAU4BSalBRDV9FNwQPvEQAVq42E2pim', 'user', 'active', '2025-04-25 00:41:08', NULL, '2025-04-25 00:41:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'مصطفی عباس ابادی', 'abbasabadi', 'abbasabadi@hotmail.com', NULL, NULL, '$2y$10$BczkZXcIrllL9tHgcOo0b.r60.yAyEtOfrIXJP3iGp4gEbSTkFi2S', 'user', 'active', '2025-04-25 22:21:59', NULL, '2025-04-25 22:22:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`user_id`, `permission_id`, `created_at`) VALUES
(3, 1, '2025-04-24 22:06:31'),
(3, 2, '2025-04-24 22:06:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `breakdowns`
--
ALTER TABLE `breakdowns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `station_id` (`station_id`),
  ADD KEY `locomotive_type_id` (`locomotive_type_id`),
  ADD KEY `reported_by` (`reported_by`);

--
-- Indexes for table `breakdown_images`
--
ALTER TABLE `breakdown_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `breakdown_id` (`breakdown_id`);

--
-- Indexes for table `breakdown_videos`
--
ALTER TABLE `breakdown_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `breakdown_id` (`breakdown_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`);

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
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_name` (`permission_name`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`);

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
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`user_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `breakdowns`
--
ALTER TABLE `breakdowns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `breakdown_images`
--
ALTER TABLE `breakdown_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `breakdown_videos`
--
ALTER TABLE `breakdown_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `error_categories`
--
ALTER TABLE `error_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locomotive_errors`
--
ALTER TABLE `locomotive_errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `locomotive_types`
--
ALTER TABLE `locomotive_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `breakdowns`
--
ALTER TABLE `breakdowns`
  ADD CONSTRAINT `breakdowns_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`),
  ADD CONSTRAINT `breakdowns_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `breakdowns_ibfk_3` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`),
  ADD CONSTRAINT `breakdowns_ibfk_4` FOREIGN KEY (`locomotive_type_id`) REFERENCES `locomotive_types` (`id`),
  ADD CONSTRAINT `breakdowns_ibfk_5` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `breakdown_images`
--
ALTER TABLE `breakdown_images`
  ADD CONSTRAINT `breakdown_images_ibfk_1` FOREIGN KEY (`breakdown_id`) REFERENCES `breakdowns` (`id`);

--
-- Constraints for table `breakdown_videos`
--
ALTER TABLE `breakdown_videos`
  ADD CONSTRAINT `breakdown_videos_ibfk_1` FOREIGN KEY (`breakdown_id`) REFERENCES `breakdowns` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

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
-- Constraints for table `stations`
--
ALTER TABLE `stations`
  ADD CONSTRAINT `stations_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Constraints for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD CONSTRAINT `system_logs_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
