--
-- Table structure for table `mdl_resource_attachment`
-- This table is for Resource Management Resources
DROP TABLE IF EXISTS `mdl_resource_attachment`;
CREATE TABLE `mdl_resource_attachment` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `attachment_filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_size` int(11) DEFAULT '0',
  `attachment_filepath` varchar(1000) CHARACTER SET utf8mb4 NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `mdl_resource_attachment`
--
ALTER TABLE `mdl_resource_attachment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `mdl_resource_attachment`
--
ALTER TABLE `mdl_resource_attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;
