-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 03, 2025 at 05:43 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `whiskeydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `dbapplications`
--

CREATE TABLE `dbapplications` (
  `id` int(11) NOT NULL,
  `user_id` varchar(256) NOT NULL,
  `event_id` int(11) NOT NULL,
  `status` enum('Approved','Denied','Pending') NOT NULL DEFAULT 'Pending',
  `flagged` tinyint(1) NOT NULL DEFAULT 0,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbapplications`
--

INSERT INTO `dbapplications` (`id`, `user_id`, `event_id`, `status`, `flagged`, `note`) VALUES
(1, 'test_person', 118, 'Denied', 1, ''),
(2, 'test_acc', 121, 'Pending', 0, ''),
(3, 'test_persona', 126, 'Pending', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbapplications`
--
ALTER TABLE `dbapplications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbapplications`
--
ALTER TABLE `dbapplications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
