-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 19, 2025 at 05:23 PM
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
(1, 'test_person', 118, 'Approved', 1, ''),
(2, 'test_acc', 121, 'Pending', 0, ''),
(3, 'test_persona', 126, 'Pending', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `dbapplication_comments`
--

CREATE TABLE `dbapplication_comments` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `user_id` varchar(256) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dbarchived_volunteers`
--

CREATE TABLE `dbarchived_volunteers` (
  `id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` text DEFAULT NULL,
  `first_name` text NOT NULL,
  `last_name` text DEFAULT NULL,
  `street_address` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `zip_code` text DEFAULT NULL,
  `phone1` varchar(12) NOT NULL,
  `phone1type` text DEFAULT NULL,
  `emergency_contact_phone` varchar(12) DEFAULT NULL,
  `emergency_contact_phone_type` text DEFAULT NULL,
  `birthday` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `emergency_contact_first_name` text NOT NULL,
  `contact_num` varchar(12) NOT NULL,
  `emergency_contact_relation` text NOT NULL,
  `contact_method` text DEFAULT NULL,
  `type` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `skills` text NOT NULL,
  `interests` text NOT NULL,
  `archived_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `emergency_contact_last_name` text NOT NULL,
  `is_new_volunteer` tinyint(1) NOT NULL DEFAULT 1,
  `is_community_service_volunteer` tinyint(1) NOT NULL DEFAULT 0,
  `total_hours_volunteered` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dbarchived_volunteers`
--

INSERT INTO `dbarchived_volunteers` (`id`, `start_date`, `first_name`, `last_name`, `street_address`, `city`, `state`, `zip_code`, `phone1`, `phone1type`, `emergency_contact_phone`, `emergency_contact_phone_type`, `birthday`, `email`, `emergency_contact_first_name`, `contact_num`, `emergency_contact_relation`, `contact_method`, `type`, `status`, `notes`, `password`, `skills`, `interests`, `archived_date`, `emergency_contact_last_name`, `is_new_volunteer`, `is_community_service_volunteer`, `total_hours_volunteered`) VALUES
('stephen_davies', '2022-05-10', 'Stephen', 'Davies', '456 Maple Avenue', 'Fredericksburg', 'VA', '22401', '5405557890', 'mobile', '5405551111', 'home', '1988-11-02', 'stephendavies@email.com', 'Robert', '5405551111', 'Father', 'phone', 'volunteer', 'Inactive', 'Archived due to relocation', '$2y$10$ABC789xyz456LMN123DEF', 'Music, Painting', 'Event Coordination', '2025-03-18 16:56:44', 'Davies', 0, 1, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `dbdiscussions`
--

CREATE TABLE `dbdiscussions` (
  `author_id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbdiscussions`
--

INSERT INTO `dbdiscussions` (`author_id`, `title`, `body`, `time`) VALUES
('vmsroot', 'test', 'this is test', '2025-04-30-10:13');

-- --------------------------------------------------------

--
-- Table structure for table `dbdrafts`
--

CREATE TABLE `dbdrafts` (
  `userID` varchar(256) NOT NULL,
  `recipientID` varchar(256) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `scheduledSend` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbdrafts`
--

INSERT INTO `dbdrafts` (`userID`, `recipientID`, `subject`, `body`, `scheduledSend`) VALUES
('vmsroot', 'Jlipinsk', 'Testing', 'Hopefully this works!', '2025-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `dbeventmedia`
--

CREATE TABLE `dbeventmedia` (
  `id` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `file_name` text NOT NULL,
  `type` text NOT NULL,
  `file_format` text NOT NULL,
  `description` text NOT NULL,
  `altername_name` text NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dbeventpersons`
--

CREATE TABLE `dbeventpersons` (
  `id` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `userID` varchar(256) NOT NULL,
  `notes` text NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbeventpersons`
--

INSERT INTO `dbeventpersons` (`id`, `eventID`, `userID`, `notes`, `attended`) VALUES
(6, 118, 'test_person', '', 0);

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
  `completed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbevents`
--

INSERT INTO `dbevents` (`id`, `name`, `type`, `startDate`, `startTime`, `endTime`, `endDate`, `description`, `capacity`, `location`, `affiliation`, `branch`, `access`, `completed`) VALUES
(118, 'Halloween Event', 'Normal', '2025-10-31', '18:00', '20:30', '', 'It is halloween!!', 50, 'Fredericksburg, VA', NULL, NULL, 'Public', 'Y'),
(119, 'party :)', 'Normal', '2026-01-14', '01:00', '01:01', '', 'dancin', 1, 'my house', NULL, NULL, 'Public', 'N'),
(120, 'SDLFjkafs', 'Normal', '2025-09-10', '12:00', '14:00', '', 'j;aksdfj', 99999, 'asdf;j', NULL, NULL, 'Public', 'N'),
(121, 'Whikey Valor Tasting', 'Normal', '2025-09-24', '15:00', '18:00', '', 'Come have a taste of fine barrel aged whiskey with fellow Vets.', 25, 'Old Silk Mill', NULL, NULL, 'Public', 'N'),
(122, 'Event', 'Normal', '2025-12-01', '13:00', '14:00', '', 'Use Case Event', 77, 'UMW', NULL, NULL, 'Public', 'N'),
(123, 'Ethan&#039;s Birthday Party', 'Normal', '2025-10-03', '07:30', '19:30', '', 'Ethan is going to eat my cake.', 2147483647, 'Eagle 225', NULL, NULL, 'Public', 'N'),
(124, 'Example event', 'Normal', '2025-09-11', '12:00', '14:00', '', 'This is a test event', 42, 'UMW', NULL, NULL, 'Public', 'N'),
(125, 'Pet Adoption', 'Normal', '2025-09-13', '11:00', '17:00', '', 'Pet Adoption', 50, 'Fredericksburg, Virginia', NULL, NULL, 'Public', 'N'),
(126, 'Squirrel Watching', 'Normal', '2025-09-22', '06:00', '09:00', '', 'Watch the squirrels to make sure they do not eat the bird seed', 6, '275 Butler Rd, Fredericksburg, VA 22405', NULL, NULL, 'Public', 'Y'),
(127, 'Whoosky Volar Tasting', 'Normal', '2025-09-15', '09:00', '13:00', '', 'Test Event', 42, 'House', NULL, NULL, 'Public', 'N'),
(128, 'Event', 'Normal', '2025-12-01', '13:30', '14:00', '', 'Use Case Event', 77, 'UMW', NULL, NULL, 'Public', 'N'),
(129, 'Test event Woak', 'Normal', '2025-10-31', '15:00', '18:00', '', 'testing thsi woa', 99, 'required but not listed', NULL, NULL, 'Public', 'Y'),
(130, 'Class Example', 'Normal', '2025-09-24', '12:00', '14:00', '', 'This is an example', 10, 'Farmer', NULL, NULL, 'Public', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `dbgroups`
--

CREATE TABLE `dbgroups` (
  `group_name` varchar(255) NOT NULL,
  `color_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbgroups`
--

INSERT INTO `dbgroups` (`group_name`, `color_level`) VALUES
('cool guys', 'green'),
('test', 'green');

-- --------------------------------------------------------

--
-- Table structure for table `dbmessages`
--

CREATE TABLE `dbmessages` (
  `id` int(11) NOT NULL,
  `senderID` varchar(256) NOT NULL,
  `recipientID` varchar(256) NOT NULL,
  `title` varchar(256) NOT NULL,
  `body` text NOT NULL,
  `time` varchar(16) NOT NULL,
  `wasRead` tinyint(1) NOT NULL DEFAULT 0,
  `prioritylevel` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbmessages`
--

INSERT INTO `dbmessages` (`id`, `senderID`, `recipientID`, `title`, `body`, `time`, `wasRead`, `prioritylevel`) VALUES
(27, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:35', 0, 0),
(28, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:35', 0, 0),
(29, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:35', 0, 0),
(30, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:35', 0, 0),
(32, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:35', 0, 0),
(34, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:35', 0, 0),
(36, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:36', 0, 0),
(37, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:36', 0, 0),
(38, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:36', 0, 0),
(39, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:36', 0, 0),
(41, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:36', 0, 0),
(43, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:36', 0, 0),
(45, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:38', 0, 0),
(46, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:38', 0, 0),
(47, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:38', 0, 0),
(48, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:38', 0, 0),
(50, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:38', 0, 0),
(52, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-15:38', 0, 0),
(54, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-16:47', 0, 0),
(55, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-16:47', 0, 0),
(56, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-16:47', 0, 0),
(57, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-16:47', 0, 0),
(59, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-16:47', 0, 0),
(61, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-16:47', 0, 0),
(63, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:48', 0, 0),
(64, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:48', 0, 0),
(65, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:48', 0, 0),
(66, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:48', 0, 0),
(68, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:48', 0, 0),
(70, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:48', 0, 0),
(72, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:50', 0, 0),
(73, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:50', 0, 0),
(74, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:50', 0, 0),
(75, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:50', 0, 0),
(77, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:50', 0, 0),
(79, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:50', 0, 0),
(81, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:52', 0, 0),
(82, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:52', 0, 0),
(83, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:52', 0, 0),
(84, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:52', 0, 0),
(86, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:52', 0, 0),
(88, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:52', 0, 0),
(90, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:53', 0, 0),
(91, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:53', 0, 0),
(92, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:53', 0, 0),
(93, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:53', 0, 0),
(95, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:53', 0, 0),
(97, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:53', 0, 0),
(99, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(100, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(101, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(102, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(104, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(106, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(108, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(109, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(110, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(111, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(113, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(115, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-19:55', 0, 0),
(117, 'vmsroot', 'BobVolunteer', 'You have been added to a group. View under Groups page.', 'You have been added to a', '2025-04-29-19:58', 0, 0),
(119, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(120, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(121, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(122, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(124, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(126, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(128, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(129, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(130, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(131, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(133, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(135, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(137, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(138, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(139, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(140, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(142, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(144, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:01', 0, 0),
(152, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(153, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(154, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(155, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(157, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(159, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(161, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(162, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(163, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(164, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(166, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(168, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(170, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(171, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(172, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(173, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(175, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(177, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(179, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(180, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(181, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(182, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(184, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(186, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:03', 0, 0),
(188, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(189, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(190, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(191, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(193, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(195, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(197, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(198, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(199, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(200, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(202, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(204, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:06', 0, 0),
(206, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(207, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(208, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(209, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(211, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(213, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(215, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(216, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(217, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(218, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(220, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(222, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(224, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(225, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(226, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(227, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(229, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(231, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:08', 0, 0),
(233, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(234, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(235, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(236, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(238, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(240, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(242, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(243, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(244, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(245, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(247, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(249, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:09', 0, 0),
(251, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(252, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(253, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(254, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(256, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(258, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(260, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(261, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(262, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(263, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(265, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(267, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(269, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(270, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(271, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(272, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(274, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(276, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(278, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(279, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(280, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(281, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(283, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(285, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:13', 0, 0),
(288, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:54', 0, 0),
(289, 'vmsroot', 'jane_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:54', 0, 0),
(290, 'vmsroot', 'john_doe', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:54', 0, 0),
(291, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:54', 0, 0),
(292, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:54', 0, 0),
(293, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:54', 0, 0),
(295, 'vmsroot', 'volunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-20:54', 0, 0),
(300, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:21', 0, 0),
(301, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:21', 0, 0),
(302, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:21', 0, 0),
(303, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:21', 0, 0),
(309, 'vmsroot', 'ameyer3', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:30', 1, 0),
(310, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:30', 0, 0),
(311, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:30', 0, 0),
(312, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:30', 0, 0),
(313, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:30', 0, 0),
(315, 'vmsroot', 'Volunteer1', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:30', 0, 0),
(318, 'vmsroot', 'ameyer3', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-29-21:31', 1, 0),
(319, 'vmsroot', 'maddiev', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-29-21:31', 0, 0),
(323, 'vmsroot', 'ameyer3', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:43', 1, 0),
(324, 'vmsroot', 'ameyer32', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:43', 0, 0),
(325, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:43', 0, 0),
(326, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:43', 0, 0),
(327, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:43', 0, 0),
(328, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:43', 0, 0),
(330, 'vmsroot', 'Volunteer1', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:43', 0, 0),
(332, 'vmsroot', 'ameyer3', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:44', 1, 0),
(333, 'vmsroot', 'ameyer32', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:44', 0, 0),
(334, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:44', 0, 0),
(335, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:44', 0, 0),
(336, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:44', 0, 0),
(337, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:44', 0, 0),
(339, 'vmsroot', 'Volunteer1', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:44', 0, 0),
(340, 'vmsroot', 'ameyer32', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-29-21:45', 0, 0),
(343, 'vmsroot', 'ameyer123', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:50', 0, 0),
(344, 'vmsroot', 'ameyer3', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:50', 1, 0),
(345, 'vmsroot', 'ameyer32', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:50', 0, 0),
(346, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:50', 0, 0),
(347, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:50', 0, 0),
(348, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:50', 0, 0),
(349, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:50', 0, 0),
(351, 'vmsroot', 'Volunteer1', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:50', 0, 0),
(352, 'vmsroot', 'ameyer3', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:52', 1, 0),
(353, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:52', 0, 0),
(354, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:52', 0, 0),
(355, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:52', 0, 0),
(356, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-21:52', 0, 0),
(358, 'vmsroot', 'BobVolunteer', 'You have been added to a group. View under Groups page.', 'You have been added to DAWGS', '2025-04-29-21:52', 0, 0),
(360, 'vmsroot', 'lukeg', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-29-21:53', 0, 0),
(361, 'vmsroot', 'maddiev', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-29-21:53', 0, 0),
(364, 'vmsroot', 'ameyer3', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-29-22:00', 1, 0),
(370, 'vmsroot', 'michellevb', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-29-22:07', 0, 0),
(372, 'vmsroot', 'ameyer3', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 1, 0),
(373, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 0, 0),
(374, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 0, 0),
(375, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 0, 0),
(376, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 0, 0),
(377, 'vmsroot', 'michellevb', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 0, 0),
(381, 'vmsroot', 'ameyer3', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 1, 0),
(382, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 0, 0),
(383, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 0, 0),
(384, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 0, 0),
(385, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 0, 0),
(386, 'vmsroot', 'michellevb', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-29-22:20', 0, 0),
(388, 'vmsroot', 'ameyer3', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-29-22:21', 1, 0),
(389, 'vmsroot', 'maddiev', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-29-22:22', 0, 0),
(392, 'vmsroot', 'test_acc', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-29-23:44', 0, 0),
(394, 'vmsroot', 'BobVolunteer', 'You have been added to a group. View under Groups page.', 'You have been added to t', '2025-04-30-08:16', 0, 0),
(395, 'vmsroot', 'ameyer3', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-30-10:13', 1, 0),
(396, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-30-10:13', 0, 0),
(397, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-30-10:13', 0, 0),
(398, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-30-10:13', 0, 0),
(399, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-30-10:13', 0, 0),
(400, 'vmsroot', 'michellevb', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-30-10:13', 0, 0),
(401, 'vmsroot', 'test_acc', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-04-30-10:13', 0, 0),
(405, 'vmsroot', 'ameyer3', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-30-10:15', 1, 0),
(406, 'vmsroot', 'BobVolunteer', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-30-10:15', 0, 0),
(407, 'vmsroot', 'lukeg', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-30-10:15', 0, 0),
(409, 'vmsroot', 'Volunteer25', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-30-10:21', 1, 0),
(412, 'vmsroot', 'lukeg', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-04-30-13:13', 0, 0),
(414, 'vmsroot', 'ameyer3', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-05-01-11:32', 1, 0),
(415, 'vmsroot', 'BobVolunteer', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-05-01-11:32', 0, 0),
(416, 'vmsroot', 'lukeg', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-05-01-11:32', 0, 0),
(417, 'vmsroot', 'maddiev', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-05-01-11:32', 0, 0),
(418, 'vmsroot', 'michael_smith', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-05-01-11:32', 0, 0),
(419, 'vmsroot', 'michellevb', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-05-01-11:32', 0, 0),
(420, 'vmsroot', 'test_acc', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-05-01-11:32', 0, 0),
(422, 'vmsroot', 'Volunteer25', 'A new discussion has been created. View under discussions page.', 'New Discussion', '2025-05-01-11:32', 0, 0),
(423, 'vmsroot', 'maddiev', 'You have been added to a group. View under Groups page.', 'You have been added to test', '2025-05-01-11:32', 0, 0),
(427, 'vmsroot', 'vmsroot', 'You have been added to a group. View under Groups page.', 'You have been added to cool guys', '2025-09-10-11:35', 1, 0),
(428, 'vmsroot', 'vmsroot', 'vmsroot has replied to test. View under discussions page.', 'A user has replied to a discussion.', '2025-09-10-11:40', 1, 0),
(429, 'vmsroot', 'vmsroot', 'test_person has been added as a volunteer', 'New volunteer account has been created', '2025-10-26-22:59', 1, 0),
(430, 'vmsroot', 'vmsroot', 'test_persona has been added as a volunteer', 'New volunteer account has been created', '2025-10-28-13:53', 1, 0),
(431, 'vmsroot', 'test_person', 'You are now signed up for Ethan&#039;s Birthday Party!', 'Thank you for signing up for Ethan&#039;s Birthday Party!', '2025-10-29-12:21', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `dbpendingsignups`
--

CREATE TABLE `dbpendingsignups` (
  `username` varchar(25) NOT NULL,
  `eventname` varchar(100) NOT NULL,
  `notes` varchar(100) NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbpendingsignups`
--

INSERT INTO `dbpendingsignups` (`username`, `eventname`, `notes`, `attended`, `role`) VALUES
('vmsroot', '108', 'Skills: non | Dietary restrictions: ojnjo | Disabilities: jonoj | Materials: knock', 0, ''),
('vmsroot', '101', 'Skills: rvwav | Dietary restrictions: varv | Disabilities: var | Materials: arv', 0, ''),
('vmsroot', '108', 'Skills: non | Dietary restrictions: ojnjo | Disabilities: jonoj | Materials: knock', 0, ''),
('vmsroot', '101', 'Skills: rvwav | Dietary restrictions: varv | Disabilities: var | Materials: arv', 0, ''),
('john_doe', '118', '', 0, ''),
('ameyer123', '126', '', 0, ''),
('test_persona', '129', '', 0, ''),
('test_persona', '129', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `dbpersonhours`
--

CREATE TABLE `dbpersonhours` (
  `personID` varchar(256) NOT NULL,
  `eventID` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbpersonhours`
--

INSERT INTO `dbpersonhours` (`personID`, `eventID`, `start_time`, `end_time`) VALUES
('john_doe', 100, '2024-11-23 22:00:00', '2024-11-23 23:00:00'),
('john_doe', 100, '2024-11-23 22:00:00', '2024-11-23 23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `dbpersons`
--

CREATE TABLE `dbpersons` (
  `id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` text DEFAULT NULL,
  `first_name` text NOT NULL,
  `last_name` text DEFAULT NULL,
  `street_address` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip_code` text DEFAULT NULL,
  `phone1` varchar(12) DEFAULT NULL,
  `over21` enum('true','false') DEFAULT NULL,
  `phone1type` text DEFAULT NULL,
  `emergency_contact_phone` varchar(12) DEFAULT NULL,
  `emergency_contact_phone_type` text DEFAULT NULL,
  `birthday` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `email_prefs` enum('true','false') DEFAULT NULL,
  `emergency_contact_first_name` text DEFAULT NULL,
  `contact_num` varchar(255) DEFAULT 'n/a',
  `emergency_contact_relation` text DEFAULT NULL,
  `contact_method` text DEFAULT NULL,
  `type` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `affiliation` varchar(100) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT NULL,
  `emergency_contact_last_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dbpersons`
--

INSERT INTO `dbpersons` (`id`, `start_date`, `first_name`, `last_name`, `street_address`, `city`, `state`, `zip_code`, `phone1`, `over21`, `phone1type`, `emergency_contact_phone`, `emergency_contact_phone_type`, `birthday`, `email`, `email_prefs`, `emergency_contact_first_name`, `contact_num`, `emergency_contact_relation`, `contact_method`, `type`, `status`, `notes`, `password`, `affiliation`, `branch`, `archived`, `emergency_contact_last_name`) VALUES
('ameyer123', '2025-05-01', 'Aidan', 'Meyer', '1541 Surry Hill Court', 'Charlottesville', 'VA', '22901', '4344222910', NULL, 'home', '4344222910', 'home', '2003-08-17', 'aidanmeyer32@gmail.com', NULL, 'Aidan', 'n/a', 'Father', NULL, 'participant', 'Inactive', NULL, '$2y$10$2VDZjrW0EacO0VA5hIYIl.fKqPC5wUdSSQ1lXXRSgC0eWxVslPcOC', NULL, NULL, 0, 'Meyer'),
('ameyer3', '2025-03-26', 'Aidan', 'Meyer', '1541 Surry Hill Court', 'Charlottesville', 'VA', '22901', '4344222910', NULL, 'home', '4344222910', 'home', '2003-08-17', 'aidanmeyer32@gmail.com', NULL, 'Aidan', 'n/a', 'Father', NULL, 'volunteer', 'Active', NULL, '$2y$10$0R5pX4uTxS0JZ4rc7dGprOK4c/d1NEs0rnnaEmnW4sz8JIQVyNdBC', NULL, NULL, 0, 'Meyer'),
('BobVolunteer', '2025-04-29', 'Bob', 'SPCA', '123 Dog Ave', 'Dogville', 'VA', '54321', '9806761234', NULL, 'home', '1234567788', 'home', '2020-03-03', 'fred54321@gmail.com', NULL, 'Luke', 'n/a', 'Bff', NULL, 'volunteer', 'Active', NULL, '$2y$10$4wUwAW0yoizxi5UFy1/OZu.yfYY7rzUsuYcZCdvfplLj95r7OknvG', NULL, NULL, 0, 'Blair'),
('exampleuser', '2025-10-20', 'example', 'user', '', 'test', 'VA', '', '2344564645', NULL, '', '', '', '', 'example@test.com', NULL, '', 'n/a', '', NULL, 'v', 'Active', NULL, '$2y$10$J0NgBjoyg9F6YMyy/qQpv.f94OLM2r19sY80BZMhMdcl38SN5vdre', NULL, NULL, 0, ''),
('lukeg', '2025-04-29', 'Luke', 'Gibson', '22 N Ave', 'Fredericksburg', 'VA', '22401', '1234567890', NULL, 'cellphone', '1234567890', 'cellphone', '2025-04-28', 'volunteer@volunteer.com', NULL, 'NoName', 'n/a', 'Brother', NULL, 'volunteer', 'Active', NULL, '$2y$10$KsNVJYhvO5D287GpKYsIPuci9FnL.Eng9R6lBpaetu2Y0yVJ7Uuiq', NULL, NULL, 0, 'YesName'),
('maddiev', '2025-04-28', 'maddie', 'van buren', '123 Blue st', 'fred', 'VA', '12343', '1234567890', NULL, 'cellphone', '1234567819', 'cellphone', '2003-05-17', 'mvanbure@mail.umw.edu', NULL, 'mommy', 'n/a', 'mom', NULL, 'volunteer', 'Active', NULL, '$2y$10$0mv3.e6gjqoIg.HfT5qVXOsI.Ca5E93DAy8BnT124W1PvMDxpfoxy', NULL, NULL, 0, 'van buren'),
('michael_smith', '2025-03-16', 'Michael', 'Smith', '789 Pine Street', 'Charlottesville', 'VA', '22903', '4345559876', NULL, 'mobile', '4345553322', 'work', '1995-08-22', 'michaelsmith@email.com', NULL, 'Sarah', '4345553322', 'Sister', 'email', 'volunteer', 'Active', '', '$2y$10$XYZ789xyz456LMN123DEF', NULL, NULL, 0, 'Smith'),
('michellevb', '2025-04-29', 'Michelle', 'Van Buren', '1234 Red St', 'Freddy', 'VA', '22401', '1234567890', NULL, 'cellphone', '0987654321', 'cellphone', '1980-08-18', 'michelle.vb@gmail.com', NULL, 'Madison', 'n/a', 'daughter', NULL, 'volunteer', 'Active', NULL, '$2y$10$bkqOWUdIJoSa6kZoRo5KH.cerZkBQf74RYsponUUgefJxNc8ExppK', NULL, NULL, 0, 'Van Buren'),
('test_acc', '2025-04-29', 'test', 'test', 'test', 'test', 'VA', '22405', '5555555555', NULL, 'cellphone', '5555555555', 'cellphone', '2003-03-03', 'test@gmail.com', NULL, 'test', 'n/a', 't', NULL, 'volunteer', 'Active', NULL, '$2y$10$kpVA41EXvoJyv896uDBEF.fHCPmSlkVSaXjHojBl7DqbRnEm//kxy', NULL, NULL, 0, 'test'),
('test_person', '2025-10-26', 'Testina', 'Tester', NULL, 'Testville', 'VA', NULL, '5555555555', 'true', 'mobile', NULL, NULL, '1980-08-18', 'testing@gmail.com', 'false', NULL, 'n/a', NULL, NULL, NULL, NULL, NULL, '$2y$10$blAQaBgCChBv5qRtBFVVAe1m6gIfwPf/wJ8HxzLFTYiY3aWpvaW8e', 'civilian', 'Army', NULL, NULL),
('test_persona', '2025-10-28', 'Testana', 'Tester', NULL, 'Testinaville', 'VA', NULL, '5555555555', 'true', NULL, NULL, NULL, NULL, 'testerana@gmail.com', 'true', NULL, 'n/a', NULL, NULL, NULL, NULL, NULL, '$2y$10$s90qlNAJE9EbgLhZbhG5vO4IGSM.PIbK3Ve9IvpfoicMwXbFEXQFi', 'active', 'air_force', NULL, NULL),
('testing123', '2025-10-26', 'Test', 'User', NULL, 'City', 'VA', NULL, '', 'true', NULL, NULL, NULL, NULL, 'example@email.com', 'true', NULL, 'n/a', NULL, NULL, NULL, NULL, NULL, '$2y$10$XbXkJUMSAGo9m1/GZQ3faebtJWbPMZYm/AeTA3jpDCaxZBNnMclxC', 'civ', 'marine_corp', NULL, NULL),
('vmsroot', NULL, 'vmsroot', '', 'N/A', 'N/A', 'VA', 'N/A', '', NULL, 'N/A', 'N/A', 'N/A', NULL, '', NULL, 'vmsroot', 'N/A', 'N/A', 'email', 'superadmin', 'Active', 'System root user account', '$2y$10$.3p8xvmUqmxNztEzMJQRBesLDwdiRU3xnt/HOcJtsglwsbUk88VTO', NULL, NULL, 0, 'vmsroot'),
('Volunteer25', '2025-04-30', 'Volley', 'McTear', '123 Dog St', 'Dogville', 'VA', '56748', '9887765543', NULL, 'home', '6565651122', 'home', '2025-04-29', 'volly@gmail.com', NULL, 'Holly', 'n/a', 'Besty', NULL, 'volunteer', 'Active', NULL, '$2y$10$45gKdbjW78pNKX/5ROtb7eU9OykSCsP/QCyTAvqBtord4J7V3Ywga', NULL, NULL, 0, 'McTear');

-- --------------------------------------------------------

--
-- Table structure for table `dbshifts`
--

CREATE TABLE `dbshifts` (
  `shift_id` int(11) NOT NULL,
  `person_id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time DEFAULT NULL,
  `totalHours` decimal(5,2) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbshifts`
--

INSERT INTO `dbshifts` (`shift_id`, `person_id`, `date`, `startTime`, `endTime`, `totalHours`, `description`) VALUES
(14, 'maddiev', '2025-04-29', '20:22:29', '00:30:40', 0.13, 'a'),
(15, 'ameyer3', '2025-04-29', '20:24:27', '00:30:36', 0.10, 'a'),
(16, 'jane_doe', '2025-04-29', '20:26:29', '00:30:40', 0.07, 'a'),
(17, 'ameyer3', '2025-04-29', '20:31:30', '00:32:09', 0.00, 'a'),
(18, 'jane_doe', '2025-04-29', '20:31:31', '00:32:09', 0.00, 'a'),
(19, 'ameyer3', '2025-04-29', '20:32:14', '00:32:39', 0.00, 'hello'),
(20, 'ameyer3', '2025-04-29', '21:25:49', '01:26:17', 0.00, 'hello'),
(21, 'ameyer32', '2025-04-29', '21:35:01', '01:35:25', 0.00, 'hello'),
(22, 'ameyer123', '2025-04-29', '21:48:53', '01:49:13', 0.00, 'hello'),
(23, 'ameyer3', '2025-04-29', '21:56:37', '01:56:54', 0.00, 'hello'),
(24, 'ameyer3', '2025-04-29', '22:03:00', '02:03:18', 0.00, 'hello'),
(25, 'michellevb', '2025-04-29', '22:08:04', '02:08:36', 0.00, 'yay'),
(26, 'ameyer3', '2025-04-29', '22:24:27', '02:24:43', 0.00, 'hello'),
(27, 'test_acc', '2025-04-29', '23:44:58', '23:45:40', -23.99, 'test'),
(28, 'BobVolunteer', '2025-04-30', '08:14:55', '12:15:09', 0.00, 'good job'),
(29, 'BobVolunteer', '2025-04-30', '08:15:29', NULL, NULL, NULL),
(30, 'Volunteer25', '2025-04-30', '10:21:39', '14:22:09', 0.00, 'test'),
(31, 'ameyer3', '2025-05-01', '11:37:23', '15:37:49', 0.00, 'hello'),
(32, 'lukeg', '2025-07-09', '10:57:46', '10:57:57', 0.00, 'Laundry'),
(33, 'lukeg', '2025-07-09', '11:04:46', NULL, NULL, NULL),
(34, 'vmsroot', '2025-09-10', '11:36:05', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discussion_replies`
--

CREATE TABLE `discussion_replies` (
  `reply_id` int(11) NOT NULL,
  `user_reply_id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discussion_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_reply_id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discussion_replies`
--

INSERT INTO `discussion_replies` (`reply_id`, `user_reply_id`, `author_id`, `discussion_title`, `reply_body`, `parent_reply_id`, `created_at`) VALUES
(12, 'Volunteer25', 'Volunteer25', 'test', 'great idea!', '9', '2025-04-30-10:24'),
(13, 'vmsroot', 'vmsroot', 'test', 'test', NULL, '2025-05-01-11:31'),
(14, 'ameyer3', 'ameyer3', 'test', 'hello', '13', '2025-05-01-11:38'),
(15, 'ameyer3', 'vmsroot', 'test', 'hello', NULL, '2025-05-01-11:38'),
(16, 'vmsroot', 'vmsroot', 'test', 'testt', NULL, '2025-09-10-11:40');

-- --------------------------------------------------------

--
-- Table structure for table `monthly_hours_snapshot`
--

CREATE TABLE `monthly_hours_snapshot` (
  `id` int(11) NOT NULL,
  `person_id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `month_year` date DEFAULT NULL,
  `hours` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monthly_hours_snapshot`
--

INSERT INTO `monthly_hours_snapshot` (`id`, `person_id`, `month_year`, `hours`) VALUES
(36, 'ameyer3', '2025-03-15', 77),
(37, 'jane_doe', '2025-03-15', 0),
(38, 'john_doe', '2025-03-15', 0),
(39, 'michael_smith', '2025-03-15', 0),
(40, 'vmsroot', '2025-03-15', 0),
(57, 'ameyer3', '2025-04-01', 96),
(58, 'jane_doe', '2025-04-01', 3),
(59, 'john_doe', '2025-04-01', 6),
(60, 'michael_smith', '2025-04-01', 8),
(61, 'vmsroot', '2025-04-01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `user_id` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`user_id`, `group_name`) VALUES
('ameyer3', 'test'),
('BobVolunteer', 'test'),
('vmsroot', 'cool guys');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbapplications`
--
ALTER TABLE `dbapplications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbarchived_volunteers`
--
ALTER TABLE `dbarchived_volunteers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbdiscussions`
--
ALTER TABLE `dbdiscussions`
  ADD PRIMARY KEY (`author_id`(255),`title`);

--
-- Indexes for table `dbeventpersons`
--
ALTER TABLE `dbeventpersons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKeventID` (`eventID`),
  ADD KEY `FKpersonID` (`userID`);

--
-- Indexes for table `dbevents`
--
ALTER TABLE `dbevents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbgroups`
--
ALTER TABLE `dbgroups`
  ADD PRIMARY KEY (`group_name`);

--
-- Indexes for table `dbmessages`
--
ALTER TABLE `dbmessages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbpersonhours`
--
ALTER TABLE `dbpersonhours`
  ADD KEY `FkpersonID2` (`personID`),
  ADD KEY `FKeventID3` (`eventID`);

--
-- Indexes for table `dbpersons`
--
ALTER TABLE `dbpersons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbshifts`
--
ALTER TABLE `dbshifts`
  ADD PRIMARY KEY (`shift_id`);

--
-- Indexes for table `discussion_replies`
--
ALTER TABLE `discussion_replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `fk_author` (`author_id`),
  ADD KEY `fk_user` (`user_reply_id`),
  ADD KEY `fk_parent` (`parent_reply_id`);

--
-- Indexes for table `monthly_hours_snapshot`
--
ALTER TABLE `monthly_hours_snapshot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`user_id`,`group_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbapplications`
--
ALTER TABLE `dbapplications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dbeventpersons`
--
ALTER TABLE `dbeventpersons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dbevents`
--
ALTER TABLE `dbevents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `dbmessages`
--
ALTER TABLE `dbmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=432;

--
-- AUTO_INCREMENT for table `dbshifts`
--
ALTER TABLE `dbshifts`
  MODIFY `shift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `discussion_replies`
--
ALTER TABLE `discussion_replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `monthly_hours_snapshot`
--
ALTER TABLE `monthly_hours_snapshot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Table structure for table `dbattendance`
--

CREATE TABLE `dbattendance` (
  `id` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `userId` varchar(256) NOT NULL,
  `loggedById` varchar(256) DEFAULT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0,
  `attendanceNote` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbattendance`
--
ALTER TABLE `dbattendance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbattendance`
--
ALTER TABLE `dbattendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;





