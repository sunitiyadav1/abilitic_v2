
-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_module_sess_track`
--

CREATE TABLE `mdl_course_module_sess_track` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sess_start_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sess_end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `mdl_course_module_sess_track`
--
ALTER TABLE `mdl_course_module_sess_track`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_course_module_sess_track`
--
ALTER TABLE `mdl_course_module_sess_track`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

  ALTER TABLE `mdl_course_module_sess_track` CHANGE `sess_start_time` `access_start_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
  ALTER TABLE `mdl_course_module_sess_track` CHANGE `sess_end_time` `access_end_time` DATETIME NULL DEFAULT NULL;

  ALTER TABLE `mdl_course_module_sess_track` ADD `session_id` INT(11) NOT NULL DEFAULT '0' AFTER `user_id`;


  ALTER TABLE `mdl_sessions` ADD `client_ip` VARCHAR(255) NULL AFTER `platform`;

  ALTER TABLE `mdl_sessions` ADD `description` VARCHAR(255) NULL AFTER `client_ip`;
  ALTER TABLE `mdl_sessions` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
