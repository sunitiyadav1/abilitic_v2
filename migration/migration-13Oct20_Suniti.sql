

INSERT INTO `mdl_custom_user_field_detail_condition` (`id`, `field_id`, `condition_id`) VALUES (NULL, '22', '7'), (NULL, '23', '7');
INSERT INTO `mdl_custom_user_field_detail_condition` (`id`, `field_id`, `condition_id`) VALUES (NULL, '25', '7'), (NULL, '26', '7');
INSERT INTO `mdl_custom_user_field_detail_condition` (`id`, `field_id`, `condition_id`) VALUES (NULL, '27', '7'), (NULL, '30', '7');
INSERT INTO `mdl_custom_user_field_detail_condition` (`id`, `field_id`, `condition_id`) VALUES (NULL, '55', '7'), (NULL, '56', '7');
INSERT INTO `mdl_custom_user_field_detail_condition` (`id`, `field_id`, `condition_id`) VALUES (NULL, '64', '7'), (NULL, '65', '7');

ALTER TABLE `mdl_custom_user_field_detail` CHANGE `type` `type` VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'varchar(255)';

ALTER TABLE `mdl_custom_user_field_detail` ADD `attributeTypeId` INT(11) NULL AFTER `field_type`, ADD `attributeTypeUnitID` INT(11) NULL AFTER `attributeTypeId`, ADD `attributeTypeUnitCode` VARCHAR(255) NULL AFTER `attributeTypeUnitID`, ADD `attributeTypeDescription` VARCHAR(255) NULL AFTER `attributeTypeUnitCode`, ADD `attributeTypeUnitDescription` VARCHAR(255) NULL AFTER `attributeTypeDescription`;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_user_attribute_mapping`
--
ALTER TABLE `mdl_user_attribute_mapping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `attribute_id` (`attribute_id`),
  ADD KEY `attribute_value` (`attribute_value`(191));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_user_attribute_mapping`
--
ALTER TABLE `mdl_user_attribute_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `mdl_dynamic_cohort_cust_rule_set` ADD `sql_group` VARCHAR(255) NULL AFTER `sqlparam`;

ALTER TABLE `mdl_dynamic_cohort_cust_rule_set` ADD `version` VARCHAR(100) NOT NULL DEFAULT 'A:V1' AFTER `is_deleted`;
