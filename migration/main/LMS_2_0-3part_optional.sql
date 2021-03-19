/* If primary key & auto increment part missed - specially on local setup. */

ALTER TABLE `mdl_course_categories` ADD PRIMARY KEY (`id`);
ALTER TABLE `mdl_course_categories` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_context` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_context` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_course` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_course` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_user_lastaccess` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_user_lastaccess` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_course_sections` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_course_sections` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_backup_logs` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_backup_logs` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_backup_controllers` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_backup_controllers` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_grade_categories` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_grade_categories` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_grade_categories_history` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_grade_categories_history` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_grade_items` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_grade_items` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_grade_items_history` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_grade_items_history` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_task_adhoc` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_task_adhoc` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_enrol` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_enrol` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_user_enrolments` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_user_enrolments` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_cache_flags` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_cache_flags` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `mdl_cache_flags` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_cache_flags` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_attendance` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_attendance` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_attendance_statuses` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_attendance_statuses` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_block_instances` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_block_instances` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_config` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_config` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_config_plugins` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_config_plugins` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_capabilities` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_capabilities` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_cohort` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_cohort` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_cohort_members` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_cohort_members` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_block` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_block` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_role_capabilities` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_role_capabilities` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `mdl_external_functions` ADD PRIMARY KEY(`id`);
ALTER TABLE `mdl_external_functions` CHANGE `id` `id` BIGINT(10) NOT NULL AUTO_INCREMENT;
