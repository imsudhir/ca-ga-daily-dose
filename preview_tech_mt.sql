-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2022 at 09:52 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `preview_tech_mt`
--

-- --------------------------------------------------------

--
-- Table structure for table `districtmasters`
--

CREATE TABLE `districtmasters` (
  `id` int(10) NOT NULL,
  `statemaster_id` int(10) DEFAULT NULL,
  `DistrictName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `districtmasters`
--

INSERT INTO `districtmasters` (`id`, `statemaster_id`, `DistrictName`) VALUES
(1, 1, 'Gonda'),
(2, 1, 'Sitapur'),
(3, 1, 'Ayodhya'),
(4, 2, 'Jaipur'),
(5, 2, 'Kota');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statemasters`
--

CREATE TABLE `statemasters` (
  `id` int(10) NOT NULL,
  `StateName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statemasters`
--

INSERT INTO `statemasters` (`id`, `StateName`) VALUES
(1, 'Utter Pradesh'),
(2, 'Rajsthan');

-- --------------------------------------------------------

--
-- Table structure for table `useraddresses`
--

CREATE TABLE `useraddresses` (
  `id` int(10) NOT NULL,
  `UserName` varchar(255) DEFAULT NULL,
  `districtmaster_id` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `useraddresses`
--

INSERT INTO `useraddresses` (`id`, `UserName`, `districtmaster_id`, `created_at`, `updated_at`) VALUES
(1, 'sudhir singh', 1, NULL, NULL),
(2, 'Ramesh ', 5, NULL, NULL),
(3, 'Mohan', 3, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `districtmasters`
--
ALTER TABLE `districtmasters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statemasters`
--
ALTER TABLE `statemasters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `useraddresses`
--
ALTER TABLE `useraddresses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `districtmasters`
--
ALTER TABLE `districtmasters`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statemasters`
--
ALTER TABLE `statemasters`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `useraddresses`
--
ALTER TABLE `useraddresses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
