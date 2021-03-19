
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `field_condition` (`field_condition`(191));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_user_field_condition`
--
ALTER TABLE `mdl_custom_user_field_condition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
-- COMMIT;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_custom_user_field_detail`
--

CREATE TABLE `mdl_custom_user_field_detail` (
  `id` int(11) NOT NULL,
  `field` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'varchar(255)',
  `is_default` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_visible` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `allow_distinct` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `field_type` enum('T','TA','YN','DT','D') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'T',
  `attributeTypeId` int(11) DEFAULT NULL,
  `attributeTypeUnitID` int(11) DEFAULT NULL,
  `attributeTypeUnitCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributeTypeDescription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributeTypeUnitDescription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mdl_custom_user_field_detail`
--

INSERT INTO `mdl_custom_user_field_detail` (`id`, `field`, `type`, `is_default`, `is_visible`, `allow_distinct`, `field_type`, `attributeTypeId`, `attributeTypeUnitID`, `attributeTypeUnitCode`, `attributeTypeDescription`, `attributeTypeUnitDescription`) VALUES
(1, 'id', 'bigint(10)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(2, 'auth', 'varchar(20)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(3, 'confirmed', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(4, 'policyagreed', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(5, 'deleted', 'tinyint(1)', '1', '1', '1', 'YN', NULL, NULL, NULL, NULL, NULL),
(6, 'suspended', 'tinyint(1)', '1', '1', '1', 'YN', NULL, NULL, NULL, NULL, NULL),
(7, 'mnethostid', 'bigint(10)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(8, 'username', 'varchar(100)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(9, 'password', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(10, 'idnumber', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(11, 'firstname', 'varchar(100)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(12, 'lastname', 'varchar(100)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(13, 'email', 'varchar(100)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(14, 'emailstop', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(15, 'icq', 'varchar(15)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(16, 'skype', 'varchar(50)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(17, 'yahoo', 'varchar(50)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(18, 'aim', 'varchar(50)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(19, 'msn', 'varchar(50)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(20, 'phone1', 'varchar(20)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(21, 'phone2', 'varchar(20)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(22, 'institution', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(23, 'department', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(24, 'address', 'varchar(255)', '1', '1', '0', 'TA', NULL, NULL, NULL, NULL, NULL),
(25, 'city', 'varchar(120)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(26, 'country', 'varchar(2)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(27, 'lang', 'varchar(30)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(28, 'calendartype', 'varchar(30)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(29, 'theme', 'varchar(50)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(30, 'timezone', 'varchar(100)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(31, 'firstaccess', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(32, 'lastaccess', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(33, 'lastlogin', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(34, 'currentlogin', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(35, 'lastip', 'varchar(45)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(36, 'secret', 'varchar(15)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(37, 'picture', 'bigint(10)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(38, 'url', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(39, 'description', 'longtext', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(40, 'descriptionformat', 'tinyint(2)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(41, 'mailformat', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(42, 'maildigest', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(43, 'maildisplay', 'tinyint(2)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(44, 'autosubscribe', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(45, 'trackforums', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(46, 'timecreated', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(47, 'timemodified', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(48, 'trustbitmask', 'bigint(10)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(49, 'imagealt', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(50, 'lastnamephonetic', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(51, 'firstnamephonetic', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(52, 'middlename', 'varchar(255)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(53, 'alternatename', 'varchar(255)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(54, 'employee_code', 'varchar(255)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(55, 'employee_status', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(56, 'gender', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(57, 'dob', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(58, 'company_code', 'varchar(255)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(59, 'date_of_joining', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(60, 'date_of_confirmation', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(61, 'date_of_leaving', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(62, 'reporting_manager_code', 'varchar(255)', '1', '1', '1', 'T', NULL, NULL, NULL, NULL, NULL),
(63, 'reporting_manager_name', 'varchar(255)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(64, 'region', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(65, 'designation', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL);

-- optional fields 
INSERT INTO `mdl_custom_user_field_detail` (`id`, `field`, `type`, `is_default`, `is_visible`, `allow_distinct`, `field_type`, `attributeTypeId`, `attributeTypeUnitID`, `attributeTypeUnitCode`, `attributeTypeDescription`, `attributeTypeUnitDescription`) VALUES
(67, 'Band', 'varchar(255)', '0', '1', '0', 'T', 54, NULL, NULL, 'Band', NULL),
(68, 'Branch', 'varchar(255)', '0', '1', '0', 'T', 78, NULL, NULL, 'Branch', NULL),
(69, 'Business', 'varchar(255)', '0', '1', '0', 'T', 74, NULL, NULL, 'Business', NULL),
(70, 'Category', 'varchar(255)', '0', '1', '0', 'T', 2139, NULL, NULL, 'Category', NULL),
(71, 'Channel', 'varchar(255)', '0', '1', '0', 'T', 75, NULL, NULL, 'Channel', NULL),
(72, 'Company', 'varchar(255)', '0', '1', '0', 'T', 40, NULL, NULL, 'Company', NULL),
(73, 'Cost Code', 'varchar(255)', '0', '1', '0', 'T', 53, NULL, NULL, 'Cost Code', NULL),
(74, 'Division', 'varchar(255)', '0', '1', '0', 'T', 41, NULL, NULL, 'Division', NULL),
(75, 'Function', 'varchar(255)', '0', '1', '0', 'T', 50, NULL, NULL, 'Function', NULL),
(76, 'Grade', 'varchar(255)', '0', '1', '0', 'T', 64, NULL, NULL, 'Grade', NULL),
(77, 'Group', 'varchar(255)', '0', '1', '0', 'T', 52, NULL, NULL, 'Group', NULL),
(78, 'Location', 'varchar(255)', '0', '1', '0', 'T', 43, NULL, NULL, 'Location', NULL),
(79, 'Shift Pattern', 'varchar(255)', '0', '1', '0', 'T', 47, NULL, NULL, 'Shift Pattern', NULL),
(80, 'State', 'varchar(255)', '0', '1', '0', 'T', 88, NULL, NULL, 'State', NULL),
(81, 'Sub Department', 'varchar(255)', '0', '1', '0', 'T', 48, NULL, NULL, 'Sub Department', NULL),
(82, 'Sub Location', 'varchar(255)', '0', '1', '0', 'T', 44, NULL, NULL, 'Sub Location', NULL),
(83, 'TESTING 20', 'varchar(255)', '0', '1', '0', 'T', 3202, NULL, NULL, 'TESTING 20202020', NULL),
(84, 'Vertical', 'varchar(255)', '0', '1', '0', 'T', 55, NULL, NULL, 'Vertical', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_custom_user_field_detail`
--
ALTER TABLE `mdl_custom_user_field_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `field` (`field`),
  ADD KEY `type` (`type`),
  ADD KEY `is_default` (`is_default`),
  ADD KEY `is_visible` (`is_visible`),
  ADD KEY `allow_distinct` (`allow_distinct`),
  ADD KEY `field_type` (`field_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_user_field_detail`
--
ALTER TABLE `mdl_custom_user_field_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
-- COMMIT;


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
(206, 65, 13),
(207, 22, 7),
(208, 23, 7),
(209, 25, 7),
(210, 26, 7),
(211, 27, 7),
(212, 30, 7),
(213, 55, 7),
(214, 56, 7),
(215, 64, 7),
(216, 65, 7);

-- optional fields 

INSERT INTO `mdl_custom_user_field_detail_condition` (`id`, `field_id`, `condition_id`) VALUES
(217, 67, 1),
(218, 67, 2),
(219, 67, 3),
(220, 67, 4),
(221, 67, 5),
(222, 67, 6),
(223, 67, 7),
(224, 67, 8),
(225, 68, 1),
(226, 68, 2),
(227, 68, 3),
(228, 68, 4),
(229, 68, 5),
(230, 68, 6),
(231, 68, 7),
(232, 68, 8),
(233, 69, 1),
(234, 69, 2),
(235, 69, 3),
(236, 69, 4),
(237, 69, 5),
(238, 69, 6),
(239, 69, 7),
(240, 69, 8),
(241, 70, 1),
(242, 70, 2),
(243, 70, 3),
(244, 70, 4),
(245, 70, 5),
(246, 70, 6),
(247, 70, 7),
(248, 70, 8),
(249, 71, 1),
(250, 71, 2),
(251, 71, 3),
(252, 71, 4),
(253, 71, 5),
(254, 71, 6),
(255, 71, 7),
(256, 71, 8),
(257, 72, 1),
(258, 72, 2),
(259, 72, 3),
(260, 72, 4),
(261, 72, 5),
(262, 72, 6),
(263, 72, 7),
(264, 72, 8),
(265, 73, 1),
(266, 73, 2),
(267, 73, 3),
(268, 73, 4),
(269, 73, 5),
(270, 73, 6),
(271, 73, 7),
(272, 73, 8),
(273, 74, 1),
(274, 74, 2),
(275, 74, 3),
(276, 74, 4),
(277, 74, 5),
(278, 74, 6),
(279, 74, 7),
(280, 74, 8),
(281, 75, 1),
(282, 75, 2),
(283, 75, 3),
(284, 75, 4),
(285, 75, 5),
(286, 75, 6),
(287, 75, 7),
(288, 75, 8),
(289, 76, 1),
(290, 76, 2),
(291, 76, 3),
(292, 76, 4),
(293, 76, 5),
(294, 76, 6),
(295, 76, 7),
(296, 76, 8),
(297, 77, 1),
(298, 77, 2),
(299, 77, 3),
(300, 77, 4),
(301, 77, 5),
(302, 77, 6),
(303, 77, 7),
(304, 77, 8),
(305, 78, 1),
(306, 78, 2),
(307, 78, 3),
(308, 78, 4),
(309, 78, 5),
(310, 78, 6),
(311, 78, 7),
(312, 78, 8),
(313, 79, 1),
(314, 79, 2),
(315, 79, 3),
(316, 79, 4),
(317, 79, 5),
(318, 79, 6),
(319, 79, 7),
(320, 79, 8),
(321, 80, 1),
(322, 80, 2),
(323, 80, 3),
(324, 80, 4),
(325, 80, 5),
(326, 80, 6),
(327, 80, 7),
(328, 80, 8),
(329, 81, 1),
(330, 81, 2),
(331, 81, 3),
(332, 81, 4),
(333, 81, 5),
(334, 81, 6),
(335, 81, 7),
(336, 81, 8),
(337, 82, 1),
(338, 82, 2),
(339, 82, 3),
(340, 82, 4),
(341, 82, 5),
(342, 82, 6),
(343, 82, 7),
(344, 82, 8),
(345, 83, 1),
(346, 83, 2),
(347, 83, 3),
(348, 83, 4),
(349, 83, 5),
(350, 83, 6),
(351, 83, 7),
(352, 83, 8),
(353, 84, 1),
(354, 84, 2),
(355, 84, 3),
(356, 84, 4),
(357, 84, 5),
(358, 84, 6),
(359, 84, 7),
(360, 84, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_custom_user_field_detail_condition`
--
ALTER TABLE `mdl_custom_user_field_detail_condition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `field_id` (`field_id`),
  ADD KEY `condition_id` (`condition_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_user_field_detail_condition`
--
ALTER TABLE `mdl_custom_user_field_detail_condition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;
-- COMMIT;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_user_attribute_mapping`
--

CREATE TABLE `mdl_user_attribute_mapping` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `mdl_user_attribute_mapping`
--
ALTER TABLE `mdl_user_attribute_mapping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_user_attribute_mapping`
--
ALTER TABLE `mdl_user_attribute_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

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
  ADD KEY `update_count` (`update_count`),
  ADD KEY `execution_datetime` (`execution_datetime`);

--
-- AUTO_INCREMENT for table `mdl_custom_cron_logs`
--
ALTER TABLE `mdl_custom_cron_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_dynamic_cohort_cust_rule_set`
--

CREATE TABLE `mdl_dynamic_cohort_cust_rule_set` (
  `id` int(11) NOT NULL,
  `rule_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cohort_id` int(11) NOT NULL DEFAULT '0',
  `is_default` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sqlselect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sqlwhere` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sqlparam` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sql_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_all_users` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `total_users` int(11) NOT NULL DEFAULT '0',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `version` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A:V1',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `mdl_dynamic_cohort_cust_rule_set`
--
ALTER TABLE `mdl_dynamic_cohort_cust_rule_set`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cohort_id` (`cohort_id`),
  ADD KEY `rule_name` (`rule_name`(191)),
  ADD KEY `is_default` (`is_default`),
  ADD KEY `is_active` (`is_active`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- AUTO_INCREMENT for table `mdl_dynamic_cohort_cust_rule_set`
--
ALTER TABLE `mdl_dynamic_cohort_cust_rule_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

-- ---------------------------------------------------------------------------------------------------------------------------------------------------
-- Below table is for user bulk scenario
-- ---------------------------------------------------------------------------------------------------------------------------------------------------

--
-- Table structure for table `mdl_custom_user_bulk_field_detail`
--

CREATE TABLE `mdl_custom_user_bulk_field_detail` (
  `id` int(11) NOT NULL,
  `field` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'varchar(255)',
  `is_default` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_visible` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `allow_distinct` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `field_type` enum('T','TA','YN','DT','D') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'T',
  `attributeTypeId` int(11) DEFAULT NULL,
  `attributeTypeUnitID` int(11) DEFAULT NULL,
  `attributeTypeUnitCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributeTypeDescription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributeTypeUnitDescription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mdl_custom_user_bulk_field_detail`
--

INSERT INTO `mdl_custom_user_bulk_field_detail` (`id`, `field`, `type`, `is_default`, `is_visible`, `allow_distinct`, `field_type`, `attributeTypeId`, `attributeTypeUnitID`, `attributeTypeUnitCode`, `attributeTypeDescription`, `attributeTypeUnitDescription`) VALUES
(1, 'id', 'bigint(10)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(2, 'auth', 'varchar(20)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(3, 'confirmed', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(4, 'policyagreed', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(5, 'deleted', 'tinyint(1)', '1', '1', '1', 'YN', NULL, NULL, NULL, NULL, NULL),
(6, 'suspended', 'tinyint(1)', '1', '1', '1', 'YN', NULL, NULL, NULL, NULL, NULL),
(7, 'mnethostid', 'bigint(10)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(8, 'username', 'varchar(100)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(9, 'password', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(10, 'idnumber', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(11, 'firstname', 'varchar(100)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(12, 'lastname', 'varchar(100)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(13, 'email', 'varchar(100)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(14, 'emailstop', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(15, 'icq', 'varchar(15)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(16, 'skype', 'varchar(50)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(17, 'yahoo', 'varchar(50)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(18, 'aim', 'varchar(50)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(19, 'msn', 'varchar(50)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(20, 'phone1', 'varchar(20)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(21, 'phone2', 'varchar(20)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(22, 'institution', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(23, 'department', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(24, 'address', 'varchar(255)', '1', '1', '0', 'TA', NULL, NULL, NULL, NULL, NULL),
(25, 'city', 'varchar(120)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(26, 'country', 'varchar(2)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(27, 'lang', 'varchar(30)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(28, 'calendartype', 'varchar(30)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(29, 'theme', 'varchar(50)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(30, 'timezone', 'varchar(100)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(31, 'firstaccess', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(32, 'lastaccess', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(33, 'lastlogin', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(34, 'currentlogin', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(35, 'lastip', 'varchar(45)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(36, 'secret', 'varchar(15)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(37, 'picture', 'bigint(10)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(38, 'url', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(39, 'description', 'longtext', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(40, 'descriptionformat', 'tinyint(2)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(41, 'mailformat', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(42, 'maildigest', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(43, 'maildisplay', 'tinyint(2)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(44, 'autosubscribe', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(45, 'trackforums', 'tinyint(1)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(46, 'timecreated', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(47, 'timemodified', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(48, 'trustbitmask', 'bigint(10)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(49, 'imagealt', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(50, 'lastnamephonetic', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(51, 'firstnamephonetic', 'varchar(255)', '1', '0', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(52, 'middlename', 'varchar(255)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(53, 'alternatename', 'varchar(255)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(54, 'employee_code', 'varchar(255)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(55, 'employee_status', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(56, 'gender', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(57, 'dob', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(58, 'company_code', 'varchar(255)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(59, 'date_of_joining', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(60, 'date_of_confirmation', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(61, 'date_of_leaving', 'bigint(10)', '1', '1', '0', 'DT', NULL, NULL, NULL, NULL, NULL),
(62, 'reporting_manager_code', 'varchar(255)', '1', '1', '1', 'T', NULL, NULL, NULL, NULL, NULL),
(63, 'reporting_manager_name', 'varchar(255)', '1', '1', '0', 'T', NULL, NULL, NULL, NULL, NULL),
(64, 'region', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(65, 'designation', 'varchar(255)', '1', '1', '1', 'D', NULL, NULL, NULL, NULL, NULL),
(67, 'trainer', 'int(1)', '1', '1', '1', 'YN', NULL, NULL, NULL, NULL, NULL),
(68, 'main_group', 'varchar(255)', '1', '1', '0', 'T', 78, NULL, NULL, NULL, NULL),
(69, 'sub_group', 'varchar(255)', '1', '1', '0', 'T', 74, NULL, NULL, NULL, NULL),
(70, 'zone', 'varchar(150)', '1', '1', '0', 'T', 2139, NULL, NULL, NULL, NULL),
(71, 'state', 'varchar(150)', '1', '1', '0', 'T', 75, NULL, NULL, NULL, NULL),
(72, 'branch_code', 'varchar(150)', '1', '1', '0', 'T', 40, NULL, NULL, NULL, NULL),
(73, 'old_role', 'varchar(150)', '1', '1', '0', 'T', 53, NULL, NULL, NULL, NULL),
(74, 'cost_center', 'varchar(150)', '1', '1', '0', 'T', 41, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_custom_user_bulk_field_detail`
--
ALTER TABLE `mdl_custom_user_bulk_field_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `field` (`field`),
  ADD KEY `type` (`type`),
  ADD KEY `is_default` (`is_default`),
  ADD KEY `is_visible` (`is_visible`),
  ADD KEY `allow_distinct` (`allow_distinct`),
  ADD KEY `field_type` (`field_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_user_bulk_field_detail`
--
ALTER TABLE `mdl_custom_user_bulk_field_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_custom_user_bulk_field_detail_condition`
--

CREATE TABLE `mdl_custom_user_bulk_field_detail_condition` (
  `id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `condition_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mdl_custom_user_bulk_field_detail_condition`
--

INSERT INTO `mdl_custom_user_bulk_field_detail_condition` (`id`, `field_id`, `condition_id`) VALUES
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
(206, 65, 13),
(207, 22, 7),
(208, 23, 7),
(209, 25, 7),
(210, 26, 7),
(211, 27, 7),
(212, 30, 7),
(213, 55, 7),
(214, 56, 7),
(215, 64, 7),
(216, 65, 7),
(217, 67, 3),
(225, 68, 1),
(226, 68, 2),
(227, 68, 3),
(228, 68, 4),
(229, 68, 5),
(230, 68, 6),
(231, 68, 7),
(232, 68, 8),
(233, 69, 1),
(234, 69, 2),
(235, 69, 3),
(236, 69, 4),
(237, 69, 5),
(238, 69, 6),
(239, 69, 7),
(240, 69, 8),
(241, 70, 1),
(242, 70, 2),
(243, 70, 3),
(244, 70, 4),
(245, 70, 5),
(246, 70, 6),
(247, 70, 7),
(248, 70, 8),
(249, 71, 1),
(250, 71, 2),
(251, 71, 3),
(252, 71, 4),
(253, 71, 5),
(254, 71, 6),
(255, 71, 7),
(256, 71, 8),
(257, 72, 1),
(258, 72, 2),
(259, 72, 3),
(260, 72, 4),
(261, 72, 5),
(262, 72, 6),
(263, 72, 7),
(264, 72, 8),
(265, 73, 1),
(266, 73, 2),
(267, 73, 3),
(268, 73, 4),
(269, 73, 5),
(270, 73, 6),
(271, 73, 7),
(272, 73, 8),
(273, 74, 1),
(274, 74, 2),
(275, 74, 3),
(276, 74, 4),
(277, 74, 5),
(278, 74, 6),
(279, 74, 7),
(280, 74, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_custom_user_bulk_field_detail_condition`
--
ALTER TABLE `mdl_custom_user_bulk_field_detail_condition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `field_id` (`field_id`),
  ADD KEY `condition_id` (`condition_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_custom_user_bulk_field_detail_condition`
--
ALTER TABLE `mdl_custom_user_bulk_field_detail_condition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;
COMMIT;






