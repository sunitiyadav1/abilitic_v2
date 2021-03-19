--
-- Table structure for table `mdl_trainingform`
--

DROP TABLE IF EXISTS `mdl_trainingform`;
CREATE TABLE IF NOT EXISTS `mdl_trainingform` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `formtype` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `formtype_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `userid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `courseid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL',
  `start_date` bigint(11) DEFAULT NULL,
  `end_date` bigint(11) DEFAULT NULL,
  `training_program_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_provider_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_certification_program` bigint(11) DEFAULT '0',
  `certificate_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_by` bigint(18) DEFAULT NULL,
  `created_at` bigint(18) DEFAULT NULL,
  `updated_by` bigint(18) DEFAULT NULL,
  `updated_at` bigint(18) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='' ROW_FORMAT=COMPRESSED;

--
-- Table structure for table `mdl_trainingform_files`
--

DROP TABLE IF EXISTS `mdl_trainingform_files`;
CREATE TABLE IF NOT EXISTS `mdl_trainingform_files` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `trainingformid` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_by` bigint(18) DEFAULT NULL,
  `created_at` bigint(18) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_trainingform_user_files`
--

DROP TABLE IF EXISTS `mdl_trainingform_user_files`;
CREATE TABLE IF NOT EXISTS `mdl_trainingform_user_files` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `trainingformid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `fileid` int(11) DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_by` bigint(18) DEFAULT NULL,
  `created_at` bigint(18) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='' ROW_FORMAT=COMPRESSED;
