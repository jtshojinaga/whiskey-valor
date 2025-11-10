-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 08, 2025 at 08:09 PM
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
-- Table structure for table `dbevents`
--

CREATE TABLE `dbevents` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` enum('Retreat','Normal') NOT NULL DEFAULT 'Normal',
  `startDate` char(10) NOT NULL,
  `startTime` char(5) NOT NULL,
  `endTime` char(5) NOT NULL,
  `endDate` char(10) NOT NULL,
  `description` text NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` text DEFAULT NULL,
  `affiliation` int(11) DEFAULT NULL,
  `branch` int(11) DEFAULT NULL,
  `access` enum('Public','Private') NOT NULL DEFAULT 'Public',
  `completed` enum('Y','N') NOT NULL DEFAULT 'N',
  `series_id` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbevents`
--

INSERT INTO `dbevents` (`id`, `name`, `type`, `startDate`, `startTime`, `endTime`, `endDate`, `description`, `capacity`, `location`, `affiliation`, `branch`, `access`, `completed`, `series_id`) VALUES
(119, 'party :)', 'Normal', '2026-01-14', '01:00', '01:01', '', 'dancin', 1, 'my house', NULL, NULL, 'Public', 'N', ''),
(120, 'SDLFjkafs', 'Normal', '2025-09-10', '12:00', '14:00', '', 'j;aksdfj', 99999, 'asdf;j', NULL, NULL, 'Public', 'N', ''),
(121, 'Whikey Valor Tasting', 'Normal', '2025-09-24', '15:00', '18:00', '', 'Come have a taste of fine barrel aged whiskey with fellow Vets.', 25, 'Old Silk Mill', NULL, NULL, 'Public', 'N', ''),
(122, 'Event', 'Normal', '2025-12-01', '13:00', '14:00', '', 'Use Case Event', 77, 'UMW', NULL, NULL, 'Public', 'N', ''),
(123, 'Ethan&#039;s Birthday Party', 'Normal', '2025-10-03', '07:30', '19:30', '', 'Ethan is going to eat my cake.', 2147483647, 'Eagle 225', NULL, NULL, 'Public', 'N', ''),
(124, 'Example event', 'Normal', '2025-09-11', '12:00', '14:00', '', 'This is a test event', 42, 'UMW', NULL, NULL, 'Public', 'N', ''),
(125, 'Pet Adoption', 'Normal', '2025-09-13', '11:00', '17:00', '', 'Pet Adoption', 50, 'Fredericksburg, Virginia', NULL, NULL, 'Public', 'N', ''),
(126, 'Squirrel Watching', 'Normal', '2025-09-22', '06:00', '09:00', '', 'Watch the squirrels to make sure they do not eat the bird seed', 6, '275 Butler Rd, Fredericksburg, VA 22405', NULL, NULL, 'Public', 'N', ''),
(127, 'Whoosky Volar Tasting', 'Normal', '2025-09-15', '09:00', '13:00', '', 'Test Event', 42, 'House', NULL, NULL, 'Public', 'N', ''),
(128, 'Event', 'Normal', '2025-12-01', '13:30', '14:00', '', 'Use Case Event', 77, 'UMW', NULL, NULL, 'Public', 'N', ''),
(129, 'Test event Woak', 'Normal', '2025-10-31', '15:00', '18:00', '', 'testing thsi woa', 99, 'required but not listed', NULL, NULL, 'Public', 'N', ''),
(130, 'Class Example', 'Normal', '2025-09-24', '12:00', '14:00', '', 'This is an example', 10, 'Farmer', NULL, NULL, 'Public', 'N', ''),
(132, 'Retreat', 'Retreat', '2025-11-20', '08:00', '20:00', '2025-11-20', 'Retreat', 20, 'Fredericksburg', NULL, NULL, 'Public', 'N', ''),
(144, 'Alia&#039;s Event', 'Normal', '2025-11-06', '08:30', '20:30', '2025-11-06', 'Alias event', 20, 'Fredericksburg', NULL, NULL, 'Public', 'N', ''),
(145, 'Event', 'Normal', '2025-11-07', '08:00', '20:00', '2025-11-07', 'Fun', 20, 'Normal', NULL, NULL, 'Public', 'N', ''),
(146, 'Retrea', 'Normal', '2025-11-12', '08:00', '20:00', '2025-11-12', 'Description', 20, 'Fredericksburg', NULL, NULL, 'Public', 'N', ''),
(147, 'Reoccurring Tester', 'Normal', '2025-11-12', '08:00', '18:00', '2025-11-12', 'Testing Testing', 10, 'Fredericksburg10', NULL, NULL, 'Public', 'N', ''),
(148, 'Reoccurring Tester', 'Normal', '2025-11-19', '08:00', '18:00', '2025-11-19', 'Testing Testing', 10, 'Fredericksburg10', NULL, NULL, 'Public', 'N', ''),
(149, 'Reoccurring Tester', 'Normal', '2025-11-26', '08:00', '18:00', '2025-11-26', 'Testing Testing', 10, 'Fredericksburg10', NULL, NULL, 'Public', 'N', ''),
(150, 'Reoccurring Tester', 'Normal', '2025-12-03', '08:00', '18:00', '2025-12-03', 'Testing Testing', 10, 'Fredericksburg10', NULL, NULL, 'Public', 'N', ''),
(151, 'Reoccurring Tester', 'Normal', '2025-12-10', '08:00', '18:00', '2025-12-10', 'Testing Testing', 10, 'Fredericksburg10', NULL, NULL, 'Public', 'N', ''),
(152, 'Reoccurring Tester', 'Normal', '2025-12-17', '08:00', '18:00', '2025-12-17', 'Testing Testing', 10, 'Fredericksburg10', NULL, NULL, 'Public', 'N', ''),
(153, 'Reoccurring Tester', 'Normal', '2025-12-24', '08:00', '18:00', '2025-12-24', 'Testing Testing', 10, 'Fredericksburg10', NULL, NULL, 'Public', 'N', ''),
(154, 'Reoccurring Tester', 'Normal', '2025-12-31', '08:00', '18:00', '2025-12-31', 'Testing Testing', 10, 'Fredericksburg10', NULL, NULL, 'Public', 'N', ''),
(155, 'Reoccurring Tester', 'Normal', '2026-01-07', '08:00', '18:00', '2026-01-07', 'Testing Testing', 10, 'Fredericksburg10', NULL, NULL, 'Public', 'N', ''),
(157, 'Testing Monthly', 'Normal', '2025-12-13', '08:00', '20:00', '2025-12-13', 'Testing monthly', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(158, 'Testing Monthly', 'Normal', '2026-01-13', '08:00', '20:00', '2026-01-13', 'Testing monthly', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(159, 'Testing Monthly', 'Normal', '2026-02-13', '08:00', '20:00', '2026-02-13', 'Testing monthly', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(160, 'Testing Monthly', 'Normal', '2026-03-13', '08:00', '20:00', '2026-03-13', 'Testing monthly', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(161, 'Testing Monthly', 'Normal', '2026-04-13', '08:00', '20:00', '2026-04-13', 'Testing monthly', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(162, 'Testing Monthly', 'Normal', '2026-05-13', '08:00', '20:00', '2026-05-13', 'Testing monthly', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(163, 'Testing Daily', 'Normal', '2025-11-08', '08:00', '20:00', '2025-11-08', 'TESTING DAILY', 20, 'Fredericksburg', NULL, NULL, 'Public', 'N', ''),
(169, 'Testing Daily', 'Normal', '2025-11-14', '08:00', '20:00', '2025-11-14', 'TESTING DAILY', 20, 'Fredericksburg', NULL, NULL, 'Public', 'N', ''),
(170, 'Testing Daily', 'Normal', '2025-11-15', '08:00', '20:00', '2025-11-15', 'TESTING DAILY', 20, 'Fredericksburg', NULL, NULL, 'Public', 'N', ''),
(172, 'Testing Daily', 'Normal', '2025-11-17', '08:00', '20:00', '2025-11-17', 'TESTING DAILY', 20, 'Fredericksburg', NULL, NULL, 'Public', 'N', ''),
(173, 'Testing Daily', 'Normal', '2025-11-18', '08:00', '20:00', '2025-11-18', 'TESTING DAILY', 20, 'Fredericksburg', NULL, NULL, 'Public', 'N', ''),
(175, 'TESTING CUSTOM', 'Normal', '2025-11-15', '08:00', '20:00', '2025-11-15', 'TESTING', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(176, 'TESTING CUSTOM', 'Normal', '2025-11-20', '08:00', '20:00', '2025-11-20', 'TESTING', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(177, 'TESTING CUSTOM', 'Normal', '2025-11-25', '08:00', '20:00', '2025-11-25', 'TESTING', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(178, 'TESTING CUSTOM', 'Normal', '2025-11-30', '08:00', '20:00', '2025-11-30', 'TESTING', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(179, 'TESTING CUSTOM', 'Normal', '2025-12-05', '08:00', '20:00', '2025-12-05', 'TESTING', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(180, 'TESTING CUSTOM', 'Normal', '2025-12-10', '08:00', '20:00', '2025-12-10', 'TESTING', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(181, 'TESTING CUSTOM', 'Normal', '2025-12-15', '08:00', '20:00', '2025-12-15', 'TESTING', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(182, 'TESTING CUSTOM', 'Normal', '2025-12-20', '08:00', '20:00', '2025-12-20', 'TESTING', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(184, 'Daily tester #2', 'Normal', '2025-11-11', '12:00', '20:00', '2025-11-11', 'Daily test', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(185, 'Daily tester #2', 'Normal', '2025-11-12', '12:00', '20:00', '2025-11-12', 'Daily test', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(186, 'Daily tester #2', 'Normal', '2025-11-13', '12:00', '20:00', '2025-11-13', 'Daily test', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(187, 'Daily tester #2', 'Normal', '2025-11-14', '12:00', '20:00', '2025-11-14', 'Daily test', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(188, 'Daily tester #2', 'Normal', '2025-11-15', '12:00', '20:00', '2025-11-15', 'Daily test', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(189, 'Daily tester #2', 'Normal', '2025-11-16', '12:00', '20:00', '2025-11-16', 'Daily test', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(190, 'Daily tester #2', 'Normal', '2025-11-17', '12:00', '20:00', '2025-11-17', 'Daily test', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(191, 'Daily tester #2', 'Normal', '2025-11-18', '12:00', '20:00', '2025-11-18', 'Daily test', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(192, 'Daily tester #2', 'Normal', '2025-11-19', '12:00', '20:00', '2025-11-19', 'Daily test', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(193, 'Daily tester #2', 'Normal', '2025-11-20', '12:00', '20:00', '2025-11-20', 'Daily test', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(199, 'Daily Testing #3', 'Normal', '2025-11-13', '12:00', '20:00', '2025-11-13', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(200, 'Daily Testing #3', 'Normal', '2025-11-14', '12:00', '20:00', '2025-11-14', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(201, 'Daily Testing #3', 'Normal', '2025-11-15', '12:00', '20:00', '2025-11-15', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(203, 'Daily Testing #3', 'Normal', '2025-11-17', '12:00', '20:00', '2025-11-17', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(205, 'Daily Testing #3', 'Normal', '2025-11-19', '12:00', '20:00', '2025-11-19', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(206, 'Daily Testing #3', 'Normal', '2025-11-20', '12:00', '20:00', '2025-11-20', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(207, 'Daily Testing #3', 'Normal', '2025-11-21', '12:00', '20:00', '2025-11-21', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(208, 'Daily Testing #3', 'Normal', '2025-11-22', '12:00', '20:00', '2025-11-22', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(209, 'Daily Testing #3', 'Normal', '2025-11-23', '12:00', '20:00', '2025-11-23', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(210, 'Daily Testing #3', 'Normal', '2025-11-24', '12:00', '20:00', '2025-11-24', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(211, 'Daily Testing #3', 'Normal', '2025-11-25', '12:00', '20:00', '2025-11-25', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(212, 'Daily Testing #3', 'Normal', '2025-11-26', '12:00', '20:00', '2025-11-26', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(213, 'Daily Testing #3', 'Normal', '2025-11-27', '12:00', '20:00', '2025-11-27', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(214, 'Daily Testing #3', 'Normal', '2025-11-28', '12:00', '20:00', '2025-11-28', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(215, 'Daily Testing #3', 'Normal', '2025-11-29', '12:00', '20:00', '2025-11-29', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(216, 'Daily Testing #3', 'Normal', '2025-11-30', '12:00', '20:00', '2025-11-30', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(217, 'Daily Testing #3', 'Normal', '2025-12-01', '12:00', '20:00', '2025-12-01', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(218, 'Daily Testing #3', 'Normal', '2025-12-02', '12:00', '20:00', '2025-12-02', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(219, 'Daily Testing #3', 'Normal', '2025-12-03', '12:00', '20:00', '2025-12-03', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(220, 'Daily Testing #3', 'Normal', '2025-12-04', '12:00', '20:00', '2025-12-04', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(221, 'Daily Testing #3', 'Normal', '2025-12-05', '12:00', '20:00', '2025-12-05', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(222, 'Daily Testing #3', 'Normal', '2025-12-06', '12:00', '20:00', '2025-12-06', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(223, 'Daily Testing #3', 'Normal', '2025-12-07', '12:00', '20:00', '2025-12-07', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(224, 'Daily Testing #3', 'Normal', '2025-12-08', '12:00', '20:00', '2025-12-08', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(225, 'Daily Testing #3', 'Normal', '2025-12-09', '12:00', '20:00', '2025-12-09', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(229, 'Weekly Tester #3', 'Normal', '2025-11-24', '08:00', '20:30', '2025-11-24', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(230, 'Weekly Tester #3', 'Normal', '2025-12-01', '08:00', '20:30', '2025-12-01', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(231, 'Weekly Tester #3', 'Normal', '2025-12-08', '08:00', '20:30', '2025-12-08', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(232, 'Weekly Tester #3', 'Normal', '2025-12-15', '08:00', '20:30', '2025-12-15', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(233, 'Weekly Tester #3', 'Normal', '2025-12-22', '08:00', '20:30', '2025-12-22', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(234, 'Weekly Tester #3', 'Normal', '2025-12-29', '08:00', '20:30', '2025-12-29', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(235, 'Weekly Tester #3', 'Normal', '2026-01-05', '08:00', '20:30', '2026-01-05', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(236, 'Weekly Tester #3', 'Normal', '2026-01-12', '08:00', '20:30', '2026-01-12', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(237, 'Weekly Tester #3', 'Normal', '2026-01-19', '08:00', '20:30', '2026-01-19', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(238, 'Weekly Tester #3', 'Normal', '2026-01-26', '08:00', '20:30', '2026-01-26', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(239, 'Weekly Tester #3', 'Normal', '2026-02-02', '08:00', '20:30', '2026-02-02', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(242, 'MONTHLY TESTER #3', 'Normal', '2025-12-11', '08:00', '18:00', '2025-12-11', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(243, 'MONTHLY TESTER #3', 'Normal', '2026-01-11', '08:00', '18:00', '2026-01-11', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(244, 'MONTHLY TESTER #3', 'Normal', '2026-02-11', '08:00', '18:00', '2026-02-11', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(245, 'MONTHLY TESTER #3', 'Normal', '2026-03-11', '08:00', '18:00', '2026-03-11', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(246, 'MONTHLY TESTER #3', 'Normal', '2026-04-11', '08:00', '18:00', '2026-04-11', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', ''),
(247, 'MONTHLY TESTER #3', 'Normal', '2026-05-11', '08:00', '18:00', '2026-05-11', 'dt', 10, 'Fred', NULL, NULL, 'Public', 'N', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbevents`
--
ALTER TABLE `dbevents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_id` (`series_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbevents`
--
ALTER TABLE `dbevents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
