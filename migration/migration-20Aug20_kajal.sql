ALTER TABLE `mdl_facetoface_sessions` ADD `name` VARCHAR(255) NOT NULL AFTER `facetoface`;
ALTER TABLE `mdl_facetoface_sessions` ADD `trainer_ids` VARCHAR(255) NOT NULL AFTER `timemodified`;
ALTER TABLE `mdl_facetoface_sessions` CHANGE `trainer_ids` `trainer_id` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
-- --------------------------------------------------------

--
-- Table structure for table `mdl_training_provider`
--

DROP TABLE IF EXISTS `mdl_training_provider`;
CREATE TABLE `mdl_training_provider` (
  `id` int(11) NOT NULL,
  `companyid` int(11) DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Indexes for table `mdl_training_provider`
--
ALTER TABLE `mdl_training_provider`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for table `mdl_training_provider`
--
ALTER TABLE `mdl_training_provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;


-- --------------------------------------------------------

--
-- Table structure for table `mdl_training_center`
--

DROP TABLE IF EXISTS `mdl_training_center`;
CREATE TABLE `mdl_training_center` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addrline1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addrline2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` int(255) DEFAULT NULL,
  `country` int(255) DEFAULT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workers_total` int(11) NOT NULL,
  `deputy_name1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deputy_mobile1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deputy_name2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deputy_mobile2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deputy_name3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deputy_mobile3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_type_id` int(11) NOT NULL DEFAULT 0,
  `vat_registration_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_identification_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `mdl_training_center`
--
ALTER TABLE `mdl_training_center`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for table `mdl_training_center`
--
ALTER TABLE `mdl_training_center`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;


-- --------------------------------------------------------

--
-- Table structure for table `mdl_resources`
--

DROP TABLE IF EXISTS `mdl_resources`;
CREATE TABLE `mdl_resources` (
  `id` int(11) NOT NULL,
  `resource_type_id` int(11) NOT NULL,
  `resource_subtype_id` int(11) NOT NULL,
  `resource_name` varchar(255) NOT NULL,
  `resource_desc` text NOT NULL,
  `max_no_attendees` int(11) NOT NULL,
  `resource_mode` enum('EXTERNAL','INTERNAL') NOT NULL,
  `training_center` varchar(255) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `addrline1` varchar(255) DEFAULT NULL,
  `addrline2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `google_map_lat` float DEFAULT NULL,
  `google_map_long` float DEFAULT NULL,
  `default_seating_arrangement` int(11) NOT NULL DEFAULT 0,
  `training_provider` varchar(255) NOT NULL,
  `reference` text NOT NULL,
  `booking_instruction` text NOT NULL,
  `startdate` datetime DEFAULT current_timestamp(),
  `enddate` datetime NOT NULL DEFAULT current_timestamp(),
  `default_price` float NOT NULL,
  `default_price_unit` int(11) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone_mobile` varchar(255) NOT NULL,
  `attachment_type` varchar(100) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `brief_about_trainer` text DEFAULT NULL,
  `trainer_sign` text DEFAULT NULL,
  `overbooking_flag` int(11) NOT NULL DEFAULT 0,
  `trainer_request_id` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for table `mdl_resources`
--
ALTER TABLE `mdl_resources`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for table `mdl_resources`
--
ALTER TABLE `mdl_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;



-- --------------------------------------------------------

--
-- Table structure for table `mdl_resource_booking`
--

DROP TABLE IF EXISTS `mdl_resource_booking`;
CREATE TABLE `mdl_resource_booking` (
  `id` int(11) NOT NULL,
  `companyid` int(11) NOT NULL DEFAULT 0,
  `facetoface_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `resource_type_id` int(11) DEFAULT 0,
  `resource_subtype_id` int(11) DEFAULT 0,
  `resource_id` int(11) NOT NULL,
  `resource_qty` int(11) NOT NULL DEFAULT 0,
  `resource_option` enum('OPTIONAL','REQUIRED') NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `is_class` int(11) NOT NULL DEFAULT 0,
  `booking_status` enum('PLANNED','CONFIRMED') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Indexes for table `mdl_resource_booking`
--
ALTER TABLE `mdl_resource_booking`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_resource_booking`
--
ALTER TABLE `mdl_resource_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

-- Altering the Training Center table with Taggroup for grouping the training center
ALTER TABLE `mdl_training_center` ADD `taggroup` VARCHAR(255) NULL DEFAULT NULL AFTER `tax_identification_no`;



INSERT INTO `mdl_resources` (`id`, `resource_type_id`, `resource_subtype_id`, `resource_name`, `resource_desc`, `max_no_attendees`, `resource_mode`, `training_center`, `location`, `address`, `addrline1`, `addrline2`, `city`, `state`, `country`, `pincode`, `google_map_lat`, `google_map_long`, `default_seating_arrangement`, `training_provider`, `reference`, `booking_instruction`, `startdate`, `enddate`, `default_price`, `default_price_unit`, `contact_name`, `contact_email`, `contact_phone_mobile`, `attachment_type`, `attachment`, `brief_about_trainer`, `trainer_sign`, `overbooking_flag`, `trainer_request_id`, `is_deleted`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 3, 6, 'Markers', '', 0, 'EXTERNAL', '', '', NULL, '', '', '', 0, 0, '', 0, 0, 0, '', '', '', '2020-12-01 00:00:00', '2021-12-31 00:00:00', 0, 0, 'test', 'test@tesst.com', '123213123', '', NULL, '', '', 0, 0, 0, 2, '2020-12-02 11:19:08', 2, '2020-12-02 11:19:08'),
(2, 1, 1, 'Venue 1', '', 0, 'EXTERNAL', '', '', NULL, '', '', '', 0, 0, '', 0, 0, 0, '', '', '', '2020-12-01 00:00:00', '2025-12-31 00:00:00', 0, 0, 'test', 'test@tesst.com', '1232323123', '', NULL, '', '', 0, 0, 0, 2, '2020-12-02 11:19:53', 2, '2020-12-02 11:19:53');
