-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 22, 2025 at 06:20 PM
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
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"whiskeydb\",\"table\":\"dbpersons\"},{\"db\":\"whiskeydb\",\"table\":\"dbevents\"},{\"db\":\"taskmanager\",\"table\":\"tasks\"},{\"db\":\"whiskeydb\",\"table\":\"dbeventmedia\"},{\"db\":\"whiskeydb\",\"table\":\"dbshifts\"},{\"db\":\"whiskeydb\",\"table\":\"dbpersonhours\"},{\"db\":\"whiskeydb\",\"table\":\"dbpendingsignups\"},{\"db\":\"whiskeydb\",\"table\":\"dbmessages\"},{\"db\":\"whiskeydb\",\"table\":\"dbarchived_volunteers\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'whiskeydb', 'dbpersons', '{\"sorted_col\":\"`type` DESC\"}', '2025-10-08 16:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-10-22 16:20:29', '{\"Console\\/Mode\":\"collapse\",\"NavigationWidth\":0}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `taskmanager`
--
CREATE DATABASE IF NOT EXISTS `taskmanager` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `taskmanager`;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(1023) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','complete') NOT NULL DEFAULT 'pending',
  `startDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `test`;
--
-- Database: `whiskeydb`
--
CREATE DATABASE IF NOT EXISTS `whiskeydb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `whiskeydb`;

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
  `eventID` int(11) NOT NULL,
  `userID` varchar(256) NOT NULL,
  `position` text NOT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbeventpersons`
--

INSERT INTO `dbeventpersons` (`eventID`, `userID`, `position`, `notes`) VALUES
(64, 'vmsroot', 'v', 'Skills:  | Dietary restrictions:  | Disabilities:  | Materials: '),
(100, 'john_doe', 'v', 'Skills:  | Dietary restrictions:  | Disabilities:  | Materials: '),
(64, 'vmsroot', 'v', 'Skills:  | Dietary restrictions:  | Disabilities:  | Materials: '),
(100, 'john_doe', 'v', 'Skills:  | Dietary restrictions:  | Disabilities:  | Materials: ');

-- --------------------------------------------------------

--
-- Table structure for table `dbevents`
--

CREATE TABLE `dbevents` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
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
(118, 'Halloween Event', '', '2025-10-31', '18:00', '20:30', '', 'It is halloween!!', 50, 'Fredericksburg, VA', NULL, NULL, 'Public', 'N'),
(119, 'party :)', '', '2026-01-14', '01:00', '01:01', '', 'dancin', 1, 'my house', NULL, NULL, 'Public', 'N'),
(120, 'SDLFjkafs', '', '2025-09-10', '12:00', '14:00', '', 'j;aksdfj', 99999, 'asdf;j', NULL, NULL, 'Public', 'N'),
(121, 'Whikey Valor Tasting', '', '2025-09-24', '15:00', '18:00', '', 'Come have a taste of fine barrel aged whiskey with fellow Vets.', 25, 'Old Silk Mill', NULL, NULL, 'Public', 'N'),
(122, 'Event', '', '2025-12-01', '13:00', '14:00', '', 'Use Case Event', 77, 'UMW', NULL, NULL, 'Public', 'N'),
(123, 'Ethan&#039;s Birthday Party', '', '2025-10-03', '07:30', '19:30', '', 'Ethan is going to eat my cake.', 2147483647, 'Eagle 225', NULL, NULL, 'Public', 'N'),
(124, 'Example event', '', '2025-09-11', '12:00', '14:00', '', 'This is a test event', 42, 'UMW', NULL, NULL, 'Public', 'N'),
(125, 'Pet Adoption', '', '2025-09-13', '11:00', '17:00', '', 'Pet Adoption', 50, 'Fredericksburg, Virginia', NULL, NULL, 'Public', 'N'),
(126, 'Squirrel Watching', '', '2025-09-22', '06:00', '09:00', '', 'Watch the squirrels to make sure they do not eat the bird seed', 6, '275 Butler Rd, Fredericksburg, VA 22405', NULL, NULL, 'Public', 'N'),
(127, 'Whoosky Volar Tasting', '', '2025-09-15', '09:00', '13:00', '', 'Test Event', 42, 'House', NULL, NULL, 'Public', 'N'),
(128, 'Event', '', '2025-12-01', '13:30', '14:00', '', 'Use Case Event', 77, 'UMW', NULL, NULL, 'Public', 'N'),
(129, 'Test event Woak', '', '2025-10-31', '15:00', '18:00', '', 'testing thsi woa', 99, 'required but not listed', NULL, NULL, 'Public', 'N'),
(130, 'Class Example', '', '2025-09-24', '12:00', '14:00', '', 'This is an example', 10, 'Farmer', NULL, NULL, 'Public', 'N');

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
(428, 'vmsroot', 'vmsroot', 'vmsroot has replied to test. View under discussions page.', 'A user has replied to a discussion.', '2025-09-10-11:40', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `dbpendingsignups`
--

CREATE TABLE `dbpendingsignups` (
  `username` varchar(25) NOT NULL,
  `eventname` varchar(100) NOT NULL,
  `role` varchar(5) NOT NULL,
  `notes` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dbpendingsignups`
--

INSERT INTO `dbpendingsignups` (`username`, `eventname`, `role`, `notes`) VALUES
('vmsroot', '108', 'v', 'Skills: non | Dietary restrictions: ojnjo | Disabilities: jonoj | Materials: knock'),
('vmsroot', '101', 'v', 'Skills: rvwav | Dietary restrictions: varv | Disabilities: var | Materials: arv'),
('vmsroot', '108', 'v', 'Skills: non | Dietary restrictions: ojnjo | Disabilities: jonoj | Materials: knock'),
('vmsroot', '101', 'v', 'Skills: rvwav | Dietary restrictions: varv | Disabilities: var | Materials: arv');

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
  `phone1` varchar(12) NOT NULL,
  `phone1type` text DEFAULT NULL,
  `emergency_contact_phone` varchar(12) DEFAULT NULL,
  `emergency_contact_phone_type` text DEFAULT NULL,
  `birthday` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `emergency_contact_first_name` text NOT NULL,
  `contact_num` varchar(255) DEFAULT 'n/a',
  `emergency_contact_relation` text NOT NULL,
  `contact_method` text DEFAULT NULL,
  `type` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `skills` text NOT NULL,
  `interests` text NOT NULL,
  `archived` tinyint(1) NOT NULL,
  `emergency_contact_last_name` text NOT NULL,
  `is_new_volunteer` tinyint(1) NOT NULL DEFAULT 1,
  `is_community_service_volunteer` tinyint(1) NOT NULL DEFAULT 0,
  `total_hours_volunteered` decimal(5,2) DEFAULT 0.00,
  `volunteer_of_the_month` tinyint(1) DEFAULT 0,
  `votm_awarded_month` date DEFAULT NULL,
  `training_level` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dbpersons`
--

INSERT INTO `dbpersons` (`id`, `start_date`, `first_name`, `last_name`, `street_address`, `city`, `state`, `zip_code`, `phone1`, `phone1type`, `emergency_contact_phone`, `emergency_contact_phone_type`, `birthday`, `email`, `emergency_contact_first_name`, `contact_num`, `emergency_contact_relation`, `contact_method`, `type`, `status`, `notes`, `password`, `skills`, `interests`, `archived`, `emergency_contact_last_name`, `is_new_volunteer`, `is_community_service_volunteer`, `total_hours_volunteered`, `volunteer_of_the_month`, `votm_awarded_month`, `training_level`) VALUES
('ameyer123', '2025-05-01', 'Aidan', 'Meyer', '1541 Surry Hill Court', 'Charlottesville', 'VA', '22901', '4344222910', 'home', '4344222910', 'home', '2003-08-17', 'aidanmeyer32@gmail.com', 'Aidan', 'n/a', 'Father', NULL, 'participant', 'Inactive', NULL, '$2y$10$2VDZjrW0EacO0VA5hIYIl.fKqPC5wUdSSQ1lXXRSgC0eWxVslPcOC', 'a', 'a', 0, 'Meyer', 0, 0, 0.00, 0, NULL, 'None'),
('ameyer3', '2025-03-26', 'Aidan', 'Meyer', '1541 Surry Hill Court', 'Charlottesville', 'VA', '22901', '4344222910', 'home', '4344222910', 'home', '2003-08-17', 'aidanmeyer32@gmail.com', 'Aidan', 'n/a', 'Father', NULL, 'volunteer', 'Active', NULL, '$2y$10$0R5pX4uTxS0JZ4rc7dGprOK4c/d1NEs0rnnaEmnW4sz8JIQVyNdBC', 'a', 'a', 0, 'Meyer', 0, 0, 70.00, 1, '2025-09-10', NULL),
('BobVolunteer', '2025-04-29', 'Bob', 'SPCA', '123 Dog Ave', 'Dogville', 'VA', '54321', '9806761234', 'home', '1234567788', 'home', '2020-03-03', 'fred54321@gmail.com', 'Luke', 'n/a', 'Bff', NULL, 'volunteer', 'Active', NULL, '$2y$10$4wUwAW0yoizxi5UFy1/OZu.yfYY7rzUsuYcZCdvfplLj95r7OknvG', 'No epic skills', 'No interests', 0, 'Blair', 0, 0, 70.00, 0, NULL, 'None'),
('lukeg', '2025-04-29', 'Luke', 'Gibson', '22 N Ave', 'Fredericksburg', 'VA', '22401', '1234567890', 'cellphone', '1234567890', 'cellphone', '2025-04-28', 'volunteer@volunteer.com', 'NoName', 'n/a', 'Brother', NULL, 'volunteer', 'Active', NULL, '$2y$10$KsNVJYhvO5D287GpKYsIPuci9FnL.Eng9R6lBpaetu2Y0yVJ7Uuiq', 'reading', 'none', 0, 'YesName', 0, 0, 0.00, 0, NULL, 'None'),
('maddiev', '2025-04-28', 'maddie', 'van buren', '123 Blue st', 'fred', 'VA', '12343', '1234567890', 'cellphone', '1234567819', 'cellphone', '2003-05-17', 'mvanbure@mail.umw.edu', 'mommy', 'n/a', 'mom', NULL, 'volunteer', 'Active', NULL, '$2y$10$0mv3.e6gjqoIg.HfT5qVXOsI.Ca5E93DAy8BnT124W1PvMDxpfoxy', 'coding', 'yoga', 0, 'van buren', 0, 0, -8.98, 0, NULL, 'None'),
('michael_smith', '2025-03-16', 'Michael', 'Smith', '789 Pine Street', 'Charlottesville', 'VA', '22903', '4345559876', 'mobile', '4345553322', 'work', '1995-08-22', 'michaelsmith@email.com', 'Sarah', '4345553322', 'Sister', 'email', 'volunteer', 'Active', '', '$2y$10$XYZ789xyz456LMN123DEF', 'Cooking, Basketball', 'Homeless Shelter Assistance', 0, 'Smith', 0, 1, 0.00, 0, NULL, NULL),
('michellevb', '2025-04-29', 'Michelle', 'Van Buren', '1234 Red St', 'Freddy', 'VA', '22401', '1234567890', 'cellphone', '0987654321', 'cellphone', '1980-08-18', 'michelle.vb@gmail.com', 'Madison', 'n/a', 'daughter', NULL, 'volunteer', 'Active', NULL, '$2y$10$bkqOWUdIJoSa6kZoRo5KH.cerZkBQf74RYsponUUgefJxNc8ExppK', 'programming', 'doggies', 0, 'Van Buren', 0, 0, 60.00, 0, NULL, 'None'),
('test_acc', '2025-04-29', 'test', 'test', 'test', 'test', 'VA', '22405', '5555555555', 'cellphone', '5555555555', 'cellphone', '2003-03-03', 'test@gmail.com', 'test', 'n/a', 't', NULL, 'volunteer', 'Active', NULL, '$2y$10$kpVA41EXvoJyv896uDBEF.fHCPmSlkVSaXjHojBl7DqbRnEm//kxy', '', '', 0, 'test', 0, 0, -4.99, 0, NULL, 'None'),
('vmsroot', NULL, 'vmsroot', '', 'N/A', 'N/A', 'VA', 'N/A', '', 'N/A', 'N/A', 'N/A', NULL, '', 'vmsroot', 'N/A', 'N/A', 'email', 'superadmin', 'Active', 'System root user account', '$2y$10$.3p8xvmUqmxNztEzMJQRBesLDwdiRU3xnt/HOcJtsglwsbUk88VTO', 'N/A', 'N/A', 0, 'vmsroot', 0, 0, 0.00, 0, NULL, NULL),
('Volunteer25', '2025-04-30', 'Volley', 'McTear', '123 Dog St', 'Dogville', 'VA', '56748', '9887765543', 'home', '6565651122', 'home', '2025-04-29', 'volly@gmail.com', 'Holly', 'n/a', 'Besty', NULL, 'volunteer', 'Active', NULL, '$2y$10$45gKdbjW78pNKX/5ROtb7eU9OykSCsP/QCyTAvqBtord4J7V3Ywga', 'None', 'None', 0, 'McTear', 0, 0, 10.00, 0, NULL, 'None');

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
-- AUTO_INCREMENT for table `dbevents`
--
ALTER TABLE `dbevents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `dbmessages`
--
ALTER TABLE `dbmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=429;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
