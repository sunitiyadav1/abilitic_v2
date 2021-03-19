

--
-- Table structure for table `mdl_dynamic_cohort_rule_set`
--

CREATE TABLE `mdl_dynamic_cohort_rule_set` (
  `id` int(11) NOT NULL,
  `cohort_id` int(11) NOT NULL DEFAULT '0',
  `sqlselect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sqlwhere` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sqlparam` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_all_users` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `mdl_dynamic_cohort_rule_set`
--
ALTER TABLE `mdl_dynamic_cohort_rule_set`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cohort_id` (`cohort_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_dynamic_cohort_rule_set`
--
ALTER TABLE `mdl_dynamic_cohort_rule_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


--
-- Alter Table structure for table `mdl_sessions` w.r.t session security
--
ALTER TABLE `mdl_sessions` ADD `gui_code` VARCHAR(255) NULL AFTER `lastip`;
ALTER TABLE `mdl_sessions` ADD `browser` VARCHAR(255) NULL AFTER gui_code;
ALTER TABLE `mdl_sessions` ADD `version` VARCHAR(255) NULL AFTER `browser`;
ALTER TABLE `mdl_sessions` ADD `platform` VARCHAR(255) NULL AFTER `version`;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_dynamic_cohort_cust_rule_set`
--

CREATE TABLE `mdl_dynamic_cohort_cust_rule_set` (
  `id` int(11) NOT NULL,
  `rule_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cohort_id` int(11) NOT NULL DEFAULT '0',
  `sqlselect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sqlwhere` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sqlparam` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_all_users` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `total_users` int(11) NOT NULL DEFAULT '0',
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
  ADD KEY `cohort_id` (`cohort_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_dynamic_cohort_cust_rule_set`
--
ALTER TABLE `mdl_dynamic_cohort_cust_rule_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

  ALTER TABLE `mdl_dynamic_cohort_cust_rule_set` ADD `is_default` ENUM('1','0') NOT NULL DEFAULT '0' AFTER `cohort_id`;

  ALTER TABLE `mdl_dynamic_cohort_cust_rule_set` ADD INDEX(`rule_name`);
  ALTER TABLE `mdl_dynamic_cohort_cust_rule_set` ADD INDEX(`is_default`);
  ALTER TABLE `mdl_dynamic_cohort_cust_rule_set` ADD INDEX(`is_active`);

  ALTER TABLE `mdl_dynamic_cohort_cust_rule_set` ADD `is_deleted` INT(11) NOT NULL DEFAULT '0' AFTER `total_users`;
  ALTER TABLE `mdl_dynamic_cohort_cust_rule_set` ADD INDEX(`is_deleted`);

  ALTER TABLE `mdl_custom_configurations` ADD `updated_by` INT(11) NOT NULL DEFAULT '0' AFTER `created_at`, ADD `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_by`;
