-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2020 at 12:50 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_2_0`
--

-- --------------------------------------------------------

--
-- Alter Table structure for table `mdl_user`
--

ALTER TABLE `mdl_user` ADD `employee_code` VARCHAR(255) NOT NULL DEFAULT 'NA' AFTER `alternatename`;
ALTER TABLE `mdl_user` ADD `employee_status` VARCHAR(255) NOT NULL DEFAULT 'Existing' AFTER `employee_code`;
ALTER TABLE `mdl_user` ADD `gender` VARCHAR(255) NOT NULL DEFAULT 'Male' AFTER `employee_status`;
ALTER TABLE `mdl_user` ADD `dob` VARCHAR(255) NOT NULL DEFAULT 'NA' AFTER `gender`;
ALTER TABLE `mdl_user` ADD `company_code` VARCHAR(255) NOT NULL DEFAULT 'NA' AFTER `dob`;
ALTER TABLE `mdl_user` ADD `date_of_joining` VARCHAR(255) NOT NULL DEFAULT 'NA' AFTER `company_code`;
ALTER TABLE `mdl_user` ADD `date_of_confirmation` VARCHAR(255) NOT NULL DEFAULT 'NA' AFTER `date_of_joining`;
ALTER TABLE `mdl_user` ADD `date_of_leaving` VARCHAR(255) NOT NULL DEFAULT 'NA' AFTER `date_of_confirmation`;
ALTER TABLE `mdl_user` ADD `reporting_manager_code` VARCHAR(255) NOT NULL DEFAULT 'NA' AFTER `date_of_leaving`;
ALTER TABLE `mdl_user` ADD `reporting_manager_name` VARCHAR(255) NOT NULL DEFAULT 'NA' AFTER `reporting_manager_code`;
ALTER TABLE `mdl_user` ADD `region` VARCHAR(255) NOT NULL DEFAULT 'NA' AFTER `reporting_manager_name`;
ALTER TABLE `mdl_user` ADD `designation` VARCHAR(255) NOT NULL DEFAULT 'NA' AFTER `region`;


ALTER TABLE `mdl_user` ADD INDEX(`employee_code`);
ALTER TABLE `mdl_user` ADD INDEX(`company_code`);
ALTER TABLE `mdl_user` ADD INDEX(`reporting_manager_code`);
ALTER TABLE `mdl_user` ADD INDEX(`date_of_joining`);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_custom_configurations`
--

CREATE TABLE `mdl_custom_configurations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `defination` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mdl_custom_configurations`
--

INSERT INTO `mdl_custom_configurations` (`id`, `name`, `defination`, `is_active`, `created_by`, `created_at`) VALUES
(1, 'Manual enrolment email notification', 'Manual enrolment email notification when admin or manager enrols.', 1, 2, '2020-05-02 06:55:09'),
(2, 'Activity Modification', 'On Activity/ Module modification such as add or edit to notify admin.', 1, 2, '2020-05-02 06:55:10'),
(3, 'Activity Deletion', 'On Activity/ Module Deletion to notify admin.', 1, 2, '2020-05-02 06:55:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_custom_configurations`
--
ALTER TABLE `mdl_custom_configurations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_configurations`
--
ALTER TABLE `mdl_custom_configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_custom_configurations_logs`
--

CREATE TABLE `mdl_custom_configurations_logs` (
  `id` int(11) NOT NULL,
  `userid_notified` int(11) NOT NULL,
  `action_userid` int(11) NOT NULL,
  `is_email_sent` int(11) NOT NULL,
  `cust_config_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `mdl_custom_configurations_logs`
--
ALTER TABLE `mdl_custom_configurations_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_configurations_logs`
--
ALTER TABLE `mdl_custom_configurations_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- COMMIT;

ALTER TABLE `mdl_custom_configurations_logs` ADD `action_userid_ip_address` VARCHAR(255) NULL AFTER `action_userid`;

ALTER TABLE `mdl_custom_configurations` ADD INDEX(`name`);
ALTER TABLE `mdl_custom_configurations` ADD INDEX(`is_active`);


-- --------------------------------------------------------

