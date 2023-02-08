-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2022 at 08:32 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `name`, `created_at`, `updated_at`) VALUES
(23, 'Alfando', '2022-08-07 11:52:56', '2022-08-07 11:52:56'),
(24, 'Auliyaur', '2022-08-07 11:53:03', '2022-08-07 11:53:03'),
(25, 'Franata', '2022-08-07 11:53:08', '2022-08-07 11:53:08'),
(26, 'Hasbi', '2022-08-07 11:53:15', '2022-08-07 11:53:15'),
(27, 'Naufal', '2022-08-07 11:53:20', '2022-08-07 11:53:20'),
(28, 'Sulistya', '2022-08-07 11:53:28', '2022-08-07 11:53:28'),
(29, 'Zulfikar', '2022-08-07 11:53:33', '2022-08-07 11:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_criterias`
--

CREATE TABLE `candidate_criterias` (
  `id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidate_criterias`
--

INSERT INTO `candidate_criterias` (`id`, `criteria_id`, `candidate_id`, `value`, `created_at`, `updated_at`) VALUES
(97, 22, 23, 71, '2022-08-07 11:52:56', '2022-08-07 12:22:15'),
(98, 23, 23, 99, '2022-08-07 11:52:56', '2022-08-07 12:22:15'),
(99, 24, 23, 2, '2022-08-07 11:52:56', '2022-08-07 11:53:45'),
(100, 22, 24, 74, '2022-08-07 11:53:03', '2022-08-07 12:17:47'),
(101, 23, 24, 85, '2022-08-07 11:53:03', '2022-08-07 11:58:31'),
(102, 24, 24, 3, '2022-08-07 11:53:03', '2022-08-07 11:58:31'),
(103, 22, 25, 86, '2022-08-07 11:53:08', '2022-08-07 12:23:43'),
(104, 23, 25, 70, '2022-08-07 11:53:08', '2022-08-07 11:58:46'),
(105, 24, 25, 2, '2022-08-07 11:53:08', '2022-08-07 11:54:25'),
(106, 22, 26, 78, '2022-08-07 11:53:15', '2022-08-07 11:58:56'),
(107, 23, 26, 58, '2022-08-07 11:53:15', '2022-08-07 11:58:56'),
(108, 24, 26, 1, '2022-08-07 11:53:15', '2022-08-07 11:58:56'),
(109, 22, 27, 87, '2022-08-07 11:53:20', '2022-08-07 12:02:18'),
(110, 23, 27, 41, '2022-08-07 11:53:20', '2022-08-07 12:15:04'),
(111, 24, 27, 3, '2022-08-07 11:53:20', '2022-08-07 11:54:51'),
(112, 22, 28, 49, '2022-08-07 11:53:28', '2022-08-07 11:59:18'),
(113, 23, 28, 73, '2022-08-07 11:53:28', '2022-08-07 12:16:38'),
(114, 24, 28, 1, '2022-08-07 11:53:28', '2022-08-07 11:59:18'),
(115, 22, 29, 85, '2022-08-07 11:53:33', '2022-08-07 11:59:29'),
(116, 23, 29, 52, '2022-08-07 11:53:33', '2022-08-07 12:23:17'),
(117, 24, 29, 1, '2022-08-07 11:53:33', '2022-08-07 11:55:24');

-- --------------------------------------------------------

--
-- Table structure for table `comparison`
--

CREATE TABLE `comparison` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `value` float NOT NULL,
  `method` enum('fuzzy','smarter') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `criterias`
--

CREATE TABLE `criterias` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `ranking` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `criterias`
--

INSERT INTO `criterias` (`id`, `name`, `ranking`, `created_at`, `updated_at`) VALUES
(22, 'Kemampuan Pemrograman', 1, '2022-08-07 11:37:51', '2022-08-07 11:37:51'),
(23, 'Hasil Wawancara', 2, '2022-08-07 11:38:02', '2022-08-07 11:38:02'),
(24, 'Pengalaman Kerja', 3, '2022-08-07 11:38:12', '2022-08-07 11:38:12');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_subs`
--

CREATE TABLE `criteria_subs` (
  `id` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `criteria_subs`
--

INSERT INTO `criteria_subs` (`id`, `min`, `max`, `criteria_id`, `created_at`, `updated_at`) VALUES
(1, 41, 60, 1, '2022-07-28 02:34:28', '2022-07-28 02:35:10'),
(2, 0, 40, 1, '2022-07-28 02:34:54', '2022-07-28 02:34:54'),
(3, 61, 80, 1, '2022-07-28 02:35:29', '2022-07-28 02:35:29'),
(4, 81, 100, 1, '2022-07-28 02:35:46', '2022-07-28 02:35:46'),
(5, 0, 1, 2, '2022-07-28 02:41:39', '2022-07-28 02:41:39'),
(6, 2, 3, 2, '2022-07-28 02:41:57', '2022-07-28 02:41:57'),
(7, 4, 10, 2, '2022-07-28 02:42:04', '2022-07-28 02:42:10'),
(9, 0, 40, 3, '2022-07-28 02:42:52', '2022-07-28 02:42:52'),
(10, 41, 60, 3, '2022-07-28 02:42:58', '2022-07-28 02:42:58'),
(11, 61, 80, 3, '2022-07-28 02:43:03', '2022-07-28 02:43:03'),
(12, 81, 100, 3, '2022-07-28 02:43:11', '2022-07-28 02:43:17'),
(13, 0, 40, 22, '2022-08-07 11:41:06', '2022-08-07 11:41:06'),
(14, 41, 60, 22, '2022-08-07 11:41:11', '2022-08-07 11:41:18'),
(15, 61, 80, 22, '2022-08-07 11:41:23', '2022-08-07 11:41:23'),
(16, 81, 100, 22, '2022-08-07 11:41:30', '2022-08-07 11:41:30'),
(17, 0, 40, 23, '2022-08-07 11:41:42', '2022-08-07 11:41:42'),
(18, 41, 60, 23, '2022-08-07 11:41:47', '2022-08-07 11:41:47'),
(19, 61, 80, 23, '2022-08-07 11:41:52', '2022-08-07 11:41:52'),
(20, 81, 100, 23, '2022-08-07 11:41:57', '2022-08-07 11:41:57'),
(21, 0, 1, 24, '2022-08-07 11:42:14', '2022-08-07 11:42:14'),
(22, 2, 3, 24, '2022-08-07 11:42:23', '2022-08-07 11:42:23'),
(23, 4, 10, 24, '2022-08-07 11:42:29', '2022-08-07 11:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_values`
--

CREATE TABLE `criteria_values` (
  `id` int(11) NOT NULL,
  `value` varchar(128) NOT NULL,
  `domain_min` int(11) NOT NULL,
  `domain_max` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `criteria_values`
--

INSERT INTO `criteria_values` (`id`, `value`, `domain_min`, `domain_max`, `criteria_id`, `created_at`, `updated_at`) VALUES
(14, 'Diterima', 70, 100, 0, '2022-07-18 07:42:25', '2022-07-18 07:42:25'),
(15, 'Ditolak', 0, 70, 0, '2022-07-18 07:42:51', '2022-07-18 07:42:51'),
(18, 'Kurang', 40, 60, 22, '2022-08-07 11:38:41', '2022-08-07 11:38:41'),
(19, 'Cukup', 40, 80, 22, '2022-08-07 11:38:51', '2022-08-07 11:38:51'),
(20, 'Baik', 60, 80, 22, '2022-08-07 11:39:09', '2022-08-07 11:39:09'),
(21, 'Kurang', 40, 60, 23, '2022-08-07 11:39:40', '2022-08-07 11:39:40'),
(22, 'Cukup', 40, 80, 23, '2022-08-07 11:39:47', '2022-08-07 11:39:47'),
(23, 'Baik', 60, 80, 23, '2022-08-07 11:39:52', '2022-08-07 11:39:52'),
(24, 'Kurang Berpengalaman', 1, 2, 24, '2022-08-07 11:40:16', '2022-08-07 11:40:16'),
(25, 'Cukup Berpengalaman', 1, 4, 24, '2022-08-07 11:40:26', '2022-08-07 11:40:26'),
(26, 'Sangat Berpengalaman', 2, 4, 24, '2022-08-07 11:40:45', '2022-08-07 11:40:45');

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `id` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `result_id`, `created_at`, `updated_at`) VALUES
(1, 15, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(2, 15, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(3, 15, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(4, 15, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(5, 15, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(6, 15, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(7, 15, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(8, 15, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(9, 15, '2022-09-13 19:36:34', '2022-09-19 18:30:34'),
(10, 15, '2022-09-13 19:36:34', '2022-09-19 18:30:34'),
(11, 15, '2022-09-13 19:36:34', '2022-09-19 18:30:34'),
(12, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(13, 15, '2022-09-13 19:36:34', '2022-09-19 18:30:34'),
(14, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(15, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(16, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(17, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(18, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(19, 15, '2022-09-13 19:36:34', '2022-09-19 18:30:34'),
(20, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(21, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(22, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(23, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(24, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(25, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(26, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43'),
(27, 14, '2022-09-13 19:36:34', '2022-09-13 19:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `rule_criterias`
--

CREATE TABLE `rule_criterias` (
  `id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `value_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rule_criterias`
--

INSERT INTO `rule_criterias` (`id`, `criteria_id`, `value_id`, `rule_id`, `created_at`, `updated_at`) VALUES
(1, 22, 18, 1, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(2, 23, 21, 1, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(3, 24, 24, 1, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(4, 22, 18, 2, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(5, 23, 21, 2, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(6, 24, 25, 2, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(7, 22, 18, 3, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(8, 23, 21, 3, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(9, 24, 26, 3, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(10, 22, 18, 4, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(11, 23, 22, 4, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(12, 24, 24, 4, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(13, 22, 18, 5, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(14, 23, 22, 5, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(15, 24, 25, 5, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(16, 22, 18, 6, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(17, 23, 22, 6, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(18, 24, 26, 6, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(19, 22, 18, 7, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(20, 23, 23, 7, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(21, 24, 24, 7, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(22, 22, 18, 8, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(23, 23, 23, 8, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(24, 24, 25, 8, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(25, 22, 18, 9, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(26, 23, 23, 9, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(27, 24, 26, 9, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(28, 22, 19, 10, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(29, 23, 21, 10, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(30, 24, 24, 10, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(31, 22, 19, 11, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(32, 23, 21, 11, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(33, 24, 25, 11, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(34, 22, 19, 12, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(35, 23, 21, 12, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(36, 24, 26, 12, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(37, 22, 19, 13, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(38, 23, 22, 13, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(39, 24, 24, 13, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(40, 22, 19, 14, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(41, 23, 22, 14, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(42, 24, 25, 14, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(43, 22, 19, 15, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(44, 23, 22, 15, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(45, 24, 26, 15, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(46, 22, 19, 16, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(47, 23, 23, 16, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(48, 24, 24, 16, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(49, 22, 19, 17, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(50, 23, 23, 17, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(51, 24, 25, 17, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(52, 22, 19, 18, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(53, 23, 23, 18, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(54, 24, 26, 18, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(55, 22, 20, 19, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(56, 23, 21, 19, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(57, 24, 24, 19, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(58, 22, 20, 20, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(59, 23, 21, 20, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(60, 24, 25, 20, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(61, 22, 20, 21, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(62, 23, 21, 21, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(63, 24, 26, 21, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(64, 22, 20, 22, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(65, 23, 22, 22, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(66, 24, 24, 22, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(67, 22, 20, 23, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(68, 23, 22, 23, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(69, 24, 25, 23, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(70, 22, 20, 24, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(71, 23, 22, 24, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(72, 24, 26, 24, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(73, 22, 20, 25, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(74, 23, 23, 25, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(75, 24, 24, 25, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(76, 22, 20, 26, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(77, 23, 23, 26, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(78, 24, 25, 26, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(79, 22, 20, 27, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(80, 23, 23, 27, '2022-09-13 19:36:34', '2022-09-13 19:36:34'),
(81, 24, 26, 27, '2022-09-13 19:36:34', '2022-09-13 19:36:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` text NOT NULL,
  `level` enum('admin','ceo','','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Esa Dandy A', 'ezu', 'b88970fb4d0493c53abdf7c31b86edc7', 'admin', '2022-07-12 07:02:42', '2022-07-12 07:02:42'),
(2, 'Admin', 'admin', '4f4684e8a38eaa639ada010ffd626093', 'admin', '2022-07-12 21:07:45', '2022-07-12 21:07:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidate_criterias`
--
ALTER TABLE `candidate_criterias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comparison`
--
ALTER TABLE `comparison`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criterias`
--
ALTER TABLE `criterias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_subs`
--
ALTER TABLE `criteria_subs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_values`
--
ALTER TABLE `criteria_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rule_criterias`
--
ALTER TABLE `rule_criterias`
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
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `candidate_criterias`
--
ALTER TABLE `candidate_criterias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `comparison`
--
ALTER TABLE `comparison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criterias`
--
ALTER TABLE `criterias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `criteria_subs`
--
ALTER TABLE `criteria_subs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `criteria_values`
--
ALTER TABLE `criteria_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `rule_criterias`
--
ALTER TABLE `rule_criterias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
