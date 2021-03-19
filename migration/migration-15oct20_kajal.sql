--
-- Table structure for table `mdl_facetoface_enrolment_log`
--
DROP TABLE IF EXISTS `mdl_facetoface_enrolment_log`;
CREATE TABLE `mdl_facetoface_enrolment_log` (
  `id` int(11) NOT NULL,
  `facetoface` int(11) NOT NULL DEFAULT 0,
  `sessionid` int(11) NOT NULL DEFAULT 0,
  `course` int(11) NOT NULL DEFAULT 0,
  `userids_selected` text DEFAULT NULL,
  `cohortids_selected` text DEFAULT NULL,
  `total_users` int(11) NOT NULL DEFAULT 0,
  `enrolled_list` longtext DEFAULT NULL,
  `already_enrolled_list` longtext DEFAULT NULL,
  `failed_list` longtext DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for table `mdl_facetoface_enrolment_log`
--
ALTER TABLE `mdl_facetoface_enrolment_log`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for table `mdl_facetoface_enrolment_log`
--
ALTER TABLE `mdl_facetoface_enrolment_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;
