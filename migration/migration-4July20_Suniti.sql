


ALTER TABLE `mdl_user` CHANGE `dob` `dob` BIGINT(10) NULL DEFAULT NULL;
ALTER TABLE `mdl_user` CHANGE `date_of_joining` `date_of_joining` BIGINT(10) NULL DEFAULT NULL;
ALTER TABLE `mdl_user` CHANGE `date_of_confirmation` `date_of_confirmation` BIGINT(10) NULL DEFAULT NULL;
ALTER TABLE `mdl_user` CHANGE `date_of_leaving` `date_of_leaving` BIGINT(10) NULL DEFAULT NULL;

update `mdl_user` set `dob`= '0';
update `mdl_user` set `date_of_joining`= '0';
update `mdl_user` set `date_of_confirmation`= '0';
update `mdl_user` set `date_of_leaving`= '0';

-- --------------------------------------------------------

--
-- Table structure for table `mdl_custom_user_field_detail`
--

CREATE TABLE `mdl_custom_user_field_detail` (
  `id` int(11) NOT NULL,
  `field` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_visible` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `allow_distinct` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `field_type` enum('T','TA','YN','DT','D') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mdl_custom_user_field_detail`
--

INSERT INTO `mdl_custom_user_field_detail` (`id`, `field`, `type`, `is_default`, `is_visible`, `allow_distinct`, `field_type`) VALUES
(1, 'id', 'bigint(10)', '1', '0', '0', 'T'),
(2, 'auth', 'varchar(20)', '1', '0', '0', 'T'),
(3, 'confirmed', 'tinyint(1)', '1', '0', '0', 'T'),
(4, 'policyagreed', 'tinyint(1)', '1', '0', '0', 'T'),
(5, 'deleted', 'tinyint(1)', '1', '1', '1', 'YN'),
(6, 'suspended', 'tinyint(1)', '1', '1', '1', 'YN'),
(7, 'mnethostid', 'bigint(10)', '1', '0', '0', 'T'),
(8, 'username', 'varchar(100)', '1', '1', '0', 'T'),
(9, 'password', 'varchar(255)', '1', '0', '0', 'T'),
(10, 'idnumber', 'varchar(255)', '1', '0', '0', 'T'),
(11, 'firstname', 'varchar(100)', '1', '1', '0', 'T'),
(12, 'lastname', 'varchar(100)', '1', '1', '0', 'T'),
(13, 'email', 'varchar(100)', '1', '1', '0', 'T'),
(14, 'emailstop', 'tinyint(1)', '1', '0', '0', 'T'),
(15, 'icq', 'varchar(15)', '1', '0', '0', 'T'),
(16, 'skype', 'varchar(50)', '1', '0', '0', 'T'),
(17, 'yahoo', 'varchar(50)', '1', '0', '0', 'T'),
(18, 'aim', 'varchar(50)', '1', '0', '0', 'T'),
(19, 'msn', 'varchar(50)', '1', '0', '0', 'T'),
(20, 'phone1', 'varchar(20)', '1', '1', '0', 'T'),
(21, 'phone2', 'varchar(20)', '1', '1', '0', 'T'),
(22, 'institution', 'varchar(255)', '1', '1', '1', 'D'),
(23, 'department', 'varchar(255)', '1', '1', '1', 'D'),
(24, 'address', 'varchar(255)', '1', '1', '0', 'TA'),
(25, 'city', 'varchar(120)', '1', '1', '1', 'D'),
(26, 'country', 'varchar(2)', '1', '1', '1', 'D'),
(27, 'lang', 'varchar(30)', '1', '1', '1', 'D'),
(28, 'calendartype', 'varchar(30)', '1', '0', '0', 'T'),
(29, 'theme', 'varchar(50)', '1', '0', '0', 'T'),
(30, 'timezone', 'varchar(100)', '1', '1', '1', 'D'),
(31, 'firstaccess', 'bigint(10)', '1', '1', '0', 'DT'),
(32, 'lastaccess', 'bigint(10)', '1', '1', '0', 'DT'),
(33, 'lastlogin', 'bigint(10)', '1', '1', '0', 'DT'),
(34, 'currentlogin', 'bigint(10)', '1', '1', '0', 'DT'),
(35, 'lastip', 'varchar(45)', '1', '1', '0', 'T'),
(36, 'secret', 'varchar(15)', '1', '0', '0', 'T'),
(37, 'picture', 'bigint(10)', '1', '0', '0', 'T'),
(38, 'url', 'varchar(255)', '1', '0', '0', 'T'),
(39, 'description', 'longtext', '1', '0', '0', 'T'),
(40, 'descriptionformat', 'tinyint(2)', '1', '0', '0', 'T'),
(41, 'mailformat', 'tinyint(1)', '1', '0', '0', 'T'),
(42, 'maildigest', 'tinyint(1)', '1', '0', '0', 'T'),
(43, 'maildisplay', 'tinyint(2)', '1', '0', '0', 'T'),
(44, 'autosubscribe', 'tinyint(1)', '1', '0', '0', 'T'),
(45, 'trackforums', 'tinyint(1)', '1', '0', '0', 'T'),
(46, 'timecreated', 'bigint(10)', '1', '1', '0', 'DT'),
(47, 'timemodified', 'bigint(10)', '1', '1', '0', 'DT'),
(48, 'trustbitmask', 'bigint(10)', '1', '0', '0', 'T'),
(49, 'imagealt', 'varchar(255)', '1', '0', '0', 'T'),
(50, 'lastnamephonetic', 'varchar(255)', '1', '0', '0', 'T'),
(51, 'firstnamephonetic', 'varchar(255)', '1', '0', '0', 'T'),
(52, 'middlename', 'varchar(255)', '1', '1', '0', 'T'),
(53, 'alternatename', 'varchar(255)', '1', '1', '0', 'T'),
(54, 'employee_code', 'varchar(255)', '1', '1', '0', 'T'),
(55, 'employee_status', 'varchar(255)', '1', '1', '1', 'D'),
(56, 'gender', 'varchar(255)', '1', '1', '1', 'D'),
(57, 'dob', 'bigint(10)', '1', '1', '0', 'DT'),
(58, 'company_code', 'varchar(255)', '1', '1', '0', 'T'),
(59, 'date_of_joining', 'bigint(10)', '1', '1', '0', 'DT'),
(60, 'date_of_confirmation', 'bigint(10)', '1', '1', '0', 'DT'),
(61, 'date_of_leaving', 'bigint(10)', '1', '1', '0', 'DT'),
(62, 'reporting_manager_code', 'varchar(255)', '1', '1', '1', 'T'),
(63, 'reporting_manager_name', 'varchar(255)', '1', '1', '0', 'T'),
(64, 'region', 'varchar(255)', '1', '1', '1', 'D'),
(65, 'designation', 'varchar(255)', '1', '1', '1', 'D');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_custom_user_field_detail`
--
ALTER TABLE `mdl_custom_user_field_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_user_field_detail`
--
ALTER TABLE `mdl_custom_user_field_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;


  ALTER TABLE `mdl_custom_user_field_detail` ADD INDEX(`field`);
  ALTER TABLE `mdl_custom_user_field_detail` ADD INDEX(`type`);
  ALTER TABLE `mdl_custom_user_field_detail` ADD INDEX(`is_default`);
  ALTER TABLE `mdl_custom_user_field_detail` ADD INDEX(`is_visible`);
  ALTER TABLE `mdl_custom_user_field_detail` ADD INDEX(`allow_distinct`);
  ALTER TABLE `mdl_custom_user_field_detail` ADD INDEX(`field_type`);

  -- --------------------------------------------------------

--
-- Table structure for table `mdl_custom_user_field_condition`
--

CREATE TABLE `mdl_custom_user_field_condition` (
  `id` int(11) NOT NULL,
  `field_condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mdl_custom_user_field_condition`
--

INSERT INTO `mdl_custom_user_field_condition` (`id`, `field_condition`) VALUES
(1, 'contains'),
(2, 'doesn\'t contain'),
(3, 'is equal to'),
(4, 'starts with'),
(5, 'ends with'),
(6, 'is empty'),
(7, 'distinct'),
(8, 'is not empty'),
(9, 'less than'),
(10, 'greater than'),
(11, 'less & equals to'),
(12, 'greater & equals to'),
(13, 'not equals to'),
(14, 'between'),
(15, 'not between');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_custom_user_field_condition`
--
ALTER TABLE `mdl_custom_user_field_condition`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_user_field_condition`
--
ALTER TABLE `mdl_custom_user_field_condition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

  ALTER TABLE `mdl_custom_user_field_condition` ADD INDEX(`field_condition`);

  -- --------------------------------------------------------

--
-- Table structure for table `mdl_custom_user_field_detail_condition`
--

CREATE TABLE `mdl_custom_user_field_detail_condition` (
  `id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `condition_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mdl_custom_user_field_detail_condition`
--

INSERT INTO `mdl_custom_user_field_detail_condition` (`id`, `field_id`, `condition_id`) VALUES
(1, 5, 3),
(2, 6, 3),
(3, 8, 1),
(4, 8, 2),
(5, 8, 3),
(6, 8, 4),
(7, 8, 5),
(8, 8, 6),
(9, 8, 7),
(10, 8, 8),
(11, 11, 1),
(12, 11, 2),
(13, 11, 3),
(14, 11, 4),
(15, 11, 5),
(16, 11, 6),
(17, 11, 7),
(18, 11, 8),
(19, 12, 1),
(20, 12, 2),
(21, 12, 3),
(22, 12, 4),
(23, 12, 5),
(24, 12, 6),
(25, 12, 7),
(26, 12, 8),
(27, 13, 1),
(28, 13, 2),
(29, 13, 3),
(30, 13, 4),
(31, 13, 5),
(32, 13, 6),
(33, 13, 7),
(34, 13, 8),
(35, 20, 1),
(36, 20, 2),
(37, 20, 3),
(38, 20, 4),
(39, 20, 5),
(40, 20, 6),
(41, 20, 7),
(42, 20, 8),
(43, 21, 1),
(44, 21, 2),
(45, 21, 3),
(46, 21, 4),
(47, 21, 5),
(48, 21, 6),
(49, 21, 7),
(50, 21, 8),
(51, 35, 1),
(52, 35, 2),
(53, 35, 3),
(54, 35, 4),
(55, 35, 5),
(56, 35, 6),
(57, 35, 7),
(58, 35, 8),
(59, 52, 1),
(60, 52, 2),
(61, 52, 3),
(62, 52, 4),
(63, 52, 5),
(64, 52, 6),
(65, 52, 7),
(66, 52, 8),
(67, 53, 1),
(68, 53, 2),
(69, 53, 3),
(70, 53, 4),
(71, 53, 5),
(72, 53, 6),
(73, 53, 7),
(74, 53, 8),
(75, 54, 1),
(76, 54, 2),
(77, 54, 3),
(78, 54, 4),
(79, 54, 5),
(80, 54, 6),
(81, 54, 7),
(82, 54, 8),
(83, 62, 1),
(84, 62, 2),
(85, 62, 3),
(86, 62, 4),
(87, 62, 5),
(88, 62, 6),
(89, 62, 7),
(90, 62, 8),
(91, 63, 1),
(92, 63, 2),
(93, 63, 3),
(94, 63, 4),
(95, 63, 5),
(96, 63, 6),
(97, 63, 7),
(98, 63, 8),
(99, 24, 1),
(100, 24, 2),
(101, 24, 3),
(102, 24, 4),
(103, 24, 5),
(104, 24, 6),
(105, 24, 7),
(106, 24, 8),
(107, 31, 3),
(108, 31, 9),
(109, 31, 10),
(110, 31, 11),
(111, 31, 12),
(112, 31, 13),
(113, 31, 14),
(114, 31, 15),
(115, 32, 3),
(116, 32, 9),
(117, 32, 10),
(118, 32, 11),
(119, 32, 12),
(120, 32, 13),
(121, 32, 14),
(122, 32, 15),
(123, 33, 3),
(124, 33, 9),
(125, 33, 10),
(126, 33, 11),
(127, 33, 12),
(128, 33, 13),
(129, 33, 14),
(130, 33, 15),
(131, 34, 3),
(132, 34, 9),
(133, 34, 10),
(134, 34, 11),
(135, 34, 12),
(136, 34, 13),
(137, 34, 14),
(138, 34, 15),
(139, 46, 3),
(140, 46, 9),
(141, 46, 10),
(142, 46, 11),
(143, 46, 12),
(144, 46, 13),
(145, 46, 14),
(146, 46, 15),
(147, 47, 3),
(148, 47, 9),
(149, 47, 10),
(150, 47, 11),
(151, 47, 12),
(152, 47, 13),
(153, 47, 14),
(154, 47, 15),
(155, 57, 3),
(156, 57, 9),
(157, 57, 10),
(158, 57, 11),
(159, 57, 12),
(160, 57, 13),
(161, 57, 14),
(162, 57, 15),
(163, 59, 3),
(164, 59, 9),
(165, 59, 10),
(166, 59, 11),
(167, 59, 12),
(168, 59, 13),
(169, 59, 14),
(170, 59, 15),
(171, 60, 3),
(172, 60, 9),
(173, 60, 10),
(174, 60, 11),
(175, 60, 12),
(176, 60, 13),
(177, 60, 14),
(178, 60, 15),
(179, 61, 3),
(180, 61, 9),
(181, 61, 10),
(182, 61, 11),
(183, 61, 12),
(184, 61, 13),
(185, 61, 14),
(186, 61, 15),
(187, 22, 3),
(188, 22, 13),
(189, 23, 3),
(190, 23, 13),
(191, 25, 3),
(192, 25, 13),
(193, 26, 3),
(194, 26, 13),
(195, 27, 3),
(196, 27, 13),
(197, 30, 3),
(198, 30, 13),
(199, 55, 3),
(200, 55, 13),
(201, 56, 3),
(202, 56, 13),
(203, 64, 3),
(204, 64, 13),
(205, 65, 3),
(206, 65, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_custom_user_field_detail_condition`
--
ALTER TABLE `mdl_custom_user_field_detail_condition`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_user_field_detail_condition`
--
ALTER TABLE `mdl_custom_user_field_detail_condition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

  ALTER TABLE `mdl_custom_user_field_detail_condition` ADD INDEX(`field_id`);
  ALTER TABLE `mdl_custom_user_field_detail_condition` ADD INDEX(`condition_id`);


  -- --------------------------------------------------------

--
-- Table structure for table `mdl_custom_cron_logs`
--

CREATE TABLE `mdl_custom_cron_logs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `execution_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_count` int(11) NOT NULL DEFAULT '0',
  `total_data` text COLLATE utf8mb4_unicode_ci,
  `insert_count` int(11) NOT NULL DEFAULT '0',
  `insert_data` text COLLATE utf8mb4_unicode_ci,
  `delete_count` int(11) NOT NULL DEFAULT '0',
  `delete_data` text COLLATE utf8mb4_unicode_ci,
  `update_count` int(11) NOT NULL DEFAULT '0',
  `update_data` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Indexes for table `mdl_custom_cron_logs`
--
ALTER TABLE `mdl_custom_cron_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`(191)),
  ADD KEY `total_count` (`total_count`),
  ADD KEY `insert_count` (`insert_count`),
  ADD KEY `delete_count` (`delete_count`),
  ADD KEY `update_count` (`update_count`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_cron_logs`
--
ALTER TABLE `mdl_custom_cron_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

  ALTER TABLE `mdl_custom_cron_logs` ADD INDEX(`execution_datetime`);
