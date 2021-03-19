-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 31, 2020 at 12:07 PM
-- Server version: 5.7.29-0ubuntu0.16.04.1
-- PHP Version: 7.3.15-3+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `LMS_2_0`
--

-- --------------------------------------------------------

--
-- Table structure for table `mdl_analytics_indicator_calc`
--

CREATE TABLE `mdl_analytics_indicator_calc` (
  `id` bigint(10) NOT NULL,
  `starttime` bigint(10) NOT NULL,
  `endtime` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `sampleorigin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sampleid` bigint(10) NOT NULL,
  `indicator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` decimal(10,2) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stored indicator calculations' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_analytics_models`
--

CREATE TABLE `mdl_analytics_models` (
  `id` bigint(10) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `trained` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(1333) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `indicators` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timesplitting` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `predictionsprocessor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` bigint(10) NOT NULL,
  `contextids` longtext COLLATE utf8mb4_unicode_ci,
  `timecreated` bigint(10) DEFAULT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Analytic models.' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_analytics_models`
--

INSERT INTO `mdl_analytics_models` (`id`, `enabled`, `trained`, `name`, `target`, `indicators`, `timesplitting`, `predictionsprocessor`, `version`, `contextids`, `timecreated`, `timemodified`, `usermodified`) VALUES
(1, 0, 0, NULL, '\\core_course\\analytics\\target\\course_dropout', '[\"\\\\core\\\\analytics\\\\indicator\\\\any_access_after_end\",\"\\\\core\\\\analytics\\\\indicator\\\\any_access_before_start\",\"\\\\core\\\\analytics\\\\indicator\\\\any_write_action_in_course\",\"\\\\core\\\\analytics\\\\indicator\\\\read_actions\",\"\\\\core_course\\\\analytics\\\\indicator\\\\completion_enabled\",\"\\\\core_course\\\\analytics\\\\indicator\\\\potential_cognitive_depth\",\"\\\\core_course\\\\analytics\\\\indicator\\\\potential_social_breadth\",\"\\\\mod_assign\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_assign\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_book\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_book\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_chat\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_chat\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_choice\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_choice\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_data\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_data\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_feedback\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_feedback\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_folder\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_folder\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_forum\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_forum\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_glossary\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_glossary\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_imscp\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_imscp\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_label\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_label\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_lesson\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_lesson\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_lti\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_lti\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_page\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_page\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_quiz\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_quiz\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_resource\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_resource\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_scorm\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_scorm\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_survey\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_survey\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_url\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_url\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_wiki\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_wiki\\\\analytics\\\\indicator\\\\social_breadth\",\"\\\\mod_workshop\\\\analytics\\\\indicator\\\\cognitive_depth\",\"\\\\mod_workshop\\\\analytics\\\\indicator\\\\social_breadth\"]', NULL, NULL, 1583151915, NULL, 1583151915, 1583151915, 0),
(2, 1, 1, NULL, '\\core_course\\analytics\\target\\no_teaching', '[\"\\\\core_course\\\\analytics\\\\indicator\\\\no_teacher\",\"\\\\core_course\\\\analytics\\\\indicator\\\\no_student\"]', '\\core\\analytics\\time_splitting\\single_range', NULL, 1583151915, NULL, 1583151915, 1583151915, 0),
(3, 1, 1, NULL, '\\core_user\\analytics\\target\\upcoming_activities_due', '[\"\\\\core_course\\\\analytics\\\\indicator\\\\activities_due\"]', '\\core\\analytics\\time_splitting\\upcoming_week', NULL, 1583151915, NULL, 1583151915, 1583151915, 0),
(4, 1, 1, NULL, '\\core_course\\analytics\\target\\no_access_since_course_start', '[\"\\\\core\\\\analytics\\\\indicator\\\\any_course_access\"]', '\\core\\analytics\\time_splitting\\one_month_after_start', NULL, 1583151915, NULL, 1583151915, 1583151915, 0),
(5, 1, 1, NULL, '\\core_course\\analytics\\target\\no_recent_accesses', '[\"\\\\core\\\\analytics\\\\indicator\\\\any_course_access\"]', '\\core\\analytics\\time_splitting\\past_month', NULL, 1583151915, NULL, 1583151915, 1583151915, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_analytics_models_log`
--

CREATE TABLE `mdl_analytics_models_log` (
  `id` bigint(10) NOT NULL,
  `modelid` bigint(10) NOT NULL,
  `version` bigint(10) NOT NULL,
  `evaluationmode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `indicators` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timesplitting` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `info` longtext COLLATE utf8mb4_unicode_ci,
  `dir` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Analytic models changes during evaluation.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_analytics_predictions`
--

CREATE TABLE `mdl_analytics_predictions` (
  `id` bigint(10) NOT NULL,
  `modelid` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `sampleid` bigint(10) NOT NULL,
  `rangeindex` mediumint(5) NOT NULL,
  `prediction` decimal(10,2) NOT NULL,
  `predictionscore` decimal(10,5) NOT NULL,
  `calculations` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timestart` bigint(10) DEFAULT NULL,
  `timeend` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Predictions' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_analytics_prediction_actions`
--

CREATE TABLE `mdl_analytics_prediction_actions` (
  `id` bigint(10) NOT NULL,
  `predictionid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `actionname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timecreated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Register of user actions over predictions.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_analytics_predict_samples`
--

CREATE TABLE `mdl_analytics_predict_samples` (
  `id` bigint(10) NOT NULL,
  `modelid` bigint(10) NOT NULL,
  `analysableid` bigint(10) NOT NULL,
  `timesplitting` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rangeindex` bigint(10) NOT NULL,
  `sampleids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Samples already used for predictions.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_analytics_train_samples`
--

CREATE TABLE `mdl_analytics_train_samples` (
  `id` bigint(10) NOT NULL,
  `modelid` bigint(10) NOT NULL,
  `analysableid` bigint(10) NOT NULL,
  `timesplitting` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sampleids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timecreated` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Samples used for training' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_analytics_used_analysables`
--

CREATE TABLE `mdl_analytics_used_analysables` (
  `id` bigint(10) NOT NULL,
  `modelid` bigint(10) NOT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `analysableid` bigint(10) NOT NULL,
  `firstanalysis` bigint(10) NOT NULL,
  `timeanalysed` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of analysables used by each model' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_analytics_used_analysables`
--

INSERT INTO `mdl_analytics_used_analysables` (`id`, `modelid`, `action`, `analysableid`, `firstanalysis`, `timeanalysed`) VALUES
(1, 2, 'prediction', 1, 1583215379, 1585164607);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_analytics_used_files`
--

CREATE TABLE `mdl_analytics_used_files` (
  `id` bigint(10) NOT NULL,
  `modelid` bigint(10) NOT NULL DEFAULT '0',
  `fileid` bigint(10) NOT NULL DEFAULT '0',
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `time` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Files that have already been used for training and predictio' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assign`
--

CREATE TABLE `mdl_assign` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `alwaysshowdescription` tinyint(2) NOT NULL DEFAULT '0',
  `nosubmissions` tinyint(2) NOT NULL DEFAULT '0',
  `submissiondrafts` tinyint(2) NOT NULL DEFAULT '0',
  `sendnotifications` tinyint(2) NOT NULL DEFAULT '0',
  `sendlatenotifications` tinyint(2) NOT NULL DEFAULT '0',
  `duedate` bigint(10) NOT NULL DEFAULT '0',
  `allowsubmissionsfromdate` bigint(10) NOT NULL DEFAULT '0',
  `grade` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `requiresubmissionstatement` tinyint(2) NOT NULL DEFAULT '0',
  `completionsubmit` tinyint(2) NOT NULL DEFAULT '0',
  `cutoffdate` bigint(10) NOT NULL DEFAULT '0',
  `gradingduedate` bigint(10) NOT NULL DEFAULT '0',
  `teamsubmission` tinyint(2) NOT NULL DEFAULT '0',
  `requireallteammemberssubmit` tinyint(2) NOT NULL DEFAULT '0',
  `teamsubmissiongroupingid` bigint(10) NOT NULL DEFAULT '0',
  `blindmarking` tinyint(2) NOT NULL DEFAULT '0',
  `hidegrader` tinyint(2) NOT NULL DEFAULT '0',
  `revealidentities` tinyint(2) NOT NULL DEFAULT '0',
  `attemptreopenmethod` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `maxattempts` mediumint(6) NOT NULL DEFAULT '-1',
  `markingworkflow` tinyint(2) NOT NULL DEFAULT '0',
  `markingallocation` tinyint(2) NOT NULL DEFAULT '0',
  `sendstudentnotifications` tinyint(2) NOT NULL DEFAULT '1',
  `preventsubmissionnotingroup` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table saves information about an instance of mod_assign' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignfeedback_comments`
--

CREATE TABLE `mdl_assignfeedback_comments` (
  `id` bigint(10) NOT NULL,
  `assignment` bigint(10) NOT NULL DEFAULT '0',
  `grade` bigint(10) NOT NULL DEFAULT '0',
  `commenttext` longtext COLLATE utf8mb4_unicode_ci,
  `commentformat` smallint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Text feedback for submitted assignments' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignfeedback_editpdf_annot`
--

CREATE TABLE `mdl_assignfeedback_editpdf_annot` (
  `id` bigint(10) NOT NULL,
  `gradeid` bigint(10) NOT NULL DEFAULT '0',
  `pageno` bigint(10) NOT NULL DEFAULT '0',
  `x` bigint(10) DEFAULT '0',
  `y` bigint(10) DEFAULT '0',
  `endx` bigint(10) DEFAULT '0',
  `endy` bigint(10) DEFAULT '0',
  `path` longtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'line',
  `colour` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'black',
  `draft` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='stores annotations added to pdfs submitted by students' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignfeedback_editpdf_cmnt`
--

CREATE TABLE `mdl_assignfeedback_editpdf_cmnt` (
  `id` bigint(10) NOT NULL,
  `gradeid` bigint(10) NOT NULL DEFAULT '0',
  `x` bigint(10) DEFAULT '0',
  `y` bigint(10) DEFAULT '0',
  `width` bigint(10) DEFAULT '120',
  `rawtext` longtext COLLATE utf8mb4_unicode_ci,
  `pageno` bigint(10) NOT NULL DEFAULT '0',
  `colour` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'black',
  `draft` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores comments added to pdfs' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignfeedback_editpdf_queue`
--

CREATE TABLE `mdl_assignfeedback_editpdf_queue` (
  `id` bigint(10) NOT NULL,
  `submissionid` bigint(10) NOT NULL,
  `submissionattempt` bigint(10) NOT NULL,
  `attemptedconversions` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Queue for processing.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignfeedback_editpdf_quick`
--

CREATE TABLE `mdl_assignfeedback_editpdf_quick` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `rawtext` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` bigint(10) NOT NULL DEFAULT '120',
  `colour` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'yellow'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores teacher specified quicklist comments' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignfeedback_editpdf_rot`
--

CREATE TABLE `mdl_assignfeedback_editpdf_rot` (
  `id` bigint(10) NOT NULL,
  `gradeid` bigint(10) NOT NULL DEFAULT '0',
  `pageno` bigint(10) NOT NULL DEFAULT '0',
  `pathnamehash` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `isrotated` tinyint(1) NOT NULL DEFAULT '0',
  `degree` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores rotation information of a page.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignfeedback_file`
--

CREATE TABLE `mdl_assignfeedback_file` (
  `id` bigint(10) NOT NULL,
  `assignment` bigint(10) NOT NULL DEFAULT '0',
  `grade` bigint(10) NOT NULL DEFAULT '0',
  `numfiles` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores info about the number of files submitted by a student' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignment`
--

CREATE TABLE `mdl_assignment` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `assignmenttype` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `resubmit` tinyint(2) NOT NULL DEFAULT '0',
  `preventlate` tinyint(2) NOT NULL DEFAULT '0',
  `emailteachers` tinyint(2) NOT NULL DEFAULT '0',
  `var1` bigint(10) DEFAULT '0',
  `var2` bigint(10) DEFAULT '0',
  `var3` bigint(10) DEFAULT '0',
  `var4` bigint(10) DEFAULT '0',
  `var5` bigint(10) DEFAULT '0',
  `maxbytes` bigint(10) NOT NULL DEFAULT '100000',
  `timedue` bigint(10) NOT NULL DEFAULT '0',
  `timeavailable` bigint(10) NOT NULL DEFAULT '0',
  `grade` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines assignments' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignment_submissions`
--

CREATE TABLE `mdl_assignment_submissions` (
  `id` bigint(10) NOT NULL,
  `assignment` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `numfiles` bigint(10) NOT NULL DEFAULT '0',
  `data1` longtext COLLATE utf8mb4_unicode_ci,
  `data2` longtext COLLATE utf8mb4_unicode_ci,
  `grade` bigint(11) NOT NULL DEFAULT '0',
  `submissioncomment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` smallint(4) NOT NULL DEFAULT '0',
  `teacher` bigint(10) NOT NULL DEFAULT '0',
  `timemarked` bigint(10) NOT NULL DEFAULT '0',
  `mailed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Info about submitted assignments' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignment_upgrade`
--

CREATE TABLE `mdl_assignment_upgrade` (
  `id` bigint(10) NOT NULL,
  `oldcmid` bigint(10) NOT NULL DEFAULT '0',
  `oldinstance` bigint(10) NOT NULL DEFAULT '0',
  `newcmid` bigint(10) NOT NULL DEFAULT '0',
  `newinstance` bigint(10) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Info about upgraded assignments' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignsubmission_file`
--

CREATE TABLE `mdl_assignsubmission_file` (
  `id` bigint(10) NOT NULL,
  `assignment` bigint(10) NOT NULL DEFAULT '0',
  `submission` bigint(10) NOT NULL DEFAULT '0',
  `numfiles` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Info about file submissions for assignments' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignsubmission_onlinetext`
--

CREATE TABLE `mdl_assignsubmission_onlinetext` (
  `id` bigint(10) NOT NULL,
  `assignment` bigint(10) NOT NULL DEFAULT '0',
  `submission` bigint(10) NOT NULL DEFAULT '0',
  `onlinetext` longtext COLLATE utf8mb4_unicode_ci,
  `onlineformat` smallint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Info about onlinetext submission' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assign_grades`
--

CREATE TABLE `mdl_assign_grades` (
  `id` bigint(10) NOT NULL,
  `assignment` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `grader` bigint(10) NOT NULL DEFAULT '0',
  `grade` decimal(10,5) DEFAULT '0.00000',
  `attemptnumber` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Grading information about a single assignment submission.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assign_overrides`
--

CREATE TABLE `mdl_assign_overrides` (
  `id` bigint(10) NOT NULL,
  `assignid` bigint(10) NOT NULL DEFAULT '0',
  `groupid` bigint(10) DEFAULT NULL,
  `userid` bigint(10) DEFAULT NULL,
  `sortorder` bigint(10) DEFAULT NULL,
  `allowsubmissionsfromdate` bigint(10) DEFAULT NULL,
  `duedate` bigint(10) DEFAULT NULL,
  `cutoffdate` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='The overrides to assign settings.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assign_plugin_config`
--

CREATE TABLE `mdl_assign_plugin_config` (
  `id` bigint(10) NOT NULL,
  `assignment` bigint(10) NOT NULL DEFAULT '0',
  `plugin` varchar(28) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `subtype` varchar(28) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(28) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Config data for an instance of a plugin in an assignment.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assign_submission`
--

CREATE TABLE `mdl_assign_submission` (
  `id` bigint(10) NOT NULL,
  `assignment` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groupid` bigint(10) NOT NULL DEFAULT '0',
  `attemptnumber` bigint(10) NOT NULL DEFAULT '0',
  `latest` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table keeps information about student interactions with' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assign_user_flags`
--

CREATE TABLE `mdl_assign_user_flags` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `assignment` bigint(10) NOT NULL DEFAULT '0',
  `locked` bigint(10) NOT NULL DEFAULT '0',
  `mailed` smallint(4) NOT NULL DEFAULT '0',
  `extensionduedate` bigint(10) NOT NULL DEFAULT '0',
  `workflowstate` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allocatedmarker` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of flags that can be set for a single user in a single ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assign_user_mapping`
--

CREATE TABLE `mdl_assign_user_mapping` (
  `id` bigint(10) NOT NULL,
  `assignment` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Map an assignment specific id number to a user' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_attendance`
--

CREATE TABLE `mdl_attendance` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` bigint(10) NOT NULL DEFAULT '100',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `intro` longtext COLLATE utf8mb4_unicode_ci,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `subnet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sessiondetailspos` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'left',
  `showsessiondetails` tinyint(1) NOT NULL DEFAULT '1',
  `showextrauserdetails` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Attendance module table' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_attendance_log`
--

CREATE TABLE `mdl_attendance_log` (
  `id` bigint(10) NOT NULL,
  `sessionid` bigint(10) NOT NULL DEFAULT '0',
  `studentid` bigint(10) NOT NULL DEFAULT '0',
  `statusid` bigint(10) NOT NULL DEFAULT '0',
  `statusset` varchar(1333) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timetaken` bigint(10) NOT NULL DEFAULT '0',
  `takenby` bigint(10) NOT NULL DEFAULT '0',
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ipaddress` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='attendance_log table retrofitted from MySQL' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_attendance_rotate_passwords`
--

CREATE TABLE `mdl_attendance_rotate_passwords` (
  `id` bigint(10) NOT NULL,
  `attendanceid` bigint(10) NOT NULL,
  `password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expirytime` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_attendance_sessions`
--

CREATE TABLE `mdl_attendance_sessions` (
  `id` bigint(10) NOT NULL,
  `attendanceid` bigint(10) NOT NULL DEFAULT '0',
  `groupid` bigint(10) NOT NULL DEFAULT '0',
  `sessdate` bigint(10) NOT NULL DEFAULT '0',
  `duration` bigint(10) NOT NULL DEFAULT '0',
  `lasttaken` bigint(10) DEFAULT NULL,
  `lasttakenby` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionformat` tinyint(2) NOT NULL DEFAULT '0',
  `studentscanmark` tinyint(1) NOT NULL DEFAULT '0',
  `autoassignstatus` tinyint(1) NOT NULL DEFAULT '0',
  `studentpassword` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `subnet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `automark` tinyint(1) NOT NULL DEFAULT '0',
  `automarkcompleted` tinyint(1) NOT NULL DEFAULT '0',
  `statusset` mediumint(5) NOT NULL DEFAULT '0',
  `absenteereport` tinyint(1) NOT NULL DEFAULT '1',
  `preventsharedip` tinyint(1) NOT NULL DEFAULT '0',
  `preventsharediptime` bigint(10) DEFAULT NULL,
  `caleventid` bigint(10) NOT NULL DEFAULT '0',
  `calendarevent` tinyint(1) NOT NULL DEFAULT '1',
  `includeqrcode` tinyint(1) NOT NULL DEFAULT '0',
  `rotateqrcode` tinyint(1) NOT NULL DEFAULT '0',
  `rotateqrcodesecret` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='attendance_sessions table' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_attendance_statuses`
--

CREATE TABLE `mdl_attendance_statuses` (
  `id` bigint(10) NOT NULL,
  `attendanceid` bigint(10) NOT NULL DEFAULT '0',
  `acronym` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `grade` decimal(5,2) NOT NULL DEFAULT '0.00',
  `studentavailability` bigint(10) DEFAULT NULL,
  `setunmarked` tinyint(2) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `setnumber` mediumint(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='attendance_statuses table retrofitted from MySQL' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_attendance_statuses`
--

INSERT INTO `mdl_attendance_statuses` (`id`, `attendanceid`, `acronym`, `description`, `grade`, `studentavailability`, `setunmarked`, `visible`, `deleted`, `setnumber`) VALUES
(1, 0, 'P', 'Present', '2.00', NULL, NULL, 1, 0, 0),
(2, 0, 'A', 'Absent', '0.00', NULL, NULL, 1, 0, 0),
(3, 0, 'L', 'Late', '1.00', NULL, NULL, 1, 0, 0),
(4, 0, 'E', 'Excused', '1.00', NULL, NULL, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_attendance_tempusers`
--

CREATE TABLE `mdl_attendance_tempusers` (
  `id` bigint(10) NOT NULL,
  `studentid` bigint(10) DEFAULT NULL,
  `courseid` bigint(10) DEFAULT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores temporary users details' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_attendance_warning`
--

CREATE TABLE `mdl_attendance_warning` (
  `id` bigint(10) NOT NULL,
  `idnumber` bigint(10) NOT NULL,
  `warningpercent` bigint(10) NOT NULL,
  `warnafter` bigint(10) NOT NULL,
  `maxwarn` bigint(10) NOT NULL DEFAULT '1',
  `emailuser` smallint(4) NOT NULL,
  `emailsubject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `emailcontent` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `emailcontentformat` smallint(4) NOT NULL,
  `thirdpartyemails` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Warning configuration' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_attendance_warning_done`
--

CREATE TABLE `mdl_attendance_warning_done` (
  `id` bigint(10) NOT NULL,
  `notifyid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `timesent` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Warnings processed' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_auth_oauth2_linked_login`
--

CREATE TABLE `mdl_auth_oauth2_linked_login` (
  `id` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `issuerid` bigint(10) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmtoken` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `confirmtokenexpires` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Accounts linked to a users Moodle account.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_backup_controllers`
--

CREATE TABLE `mdl_backup_controllers` (
  `id` bigint(10) NOT NULL,
  `backupid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `operation` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backup',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `itemid` bigint(10) NOT NULL,
  `format` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `interactive` smallint(4) NOT NULL,
  `purpose` smallint(4) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `status` smallint(4) NOT NULL,
  `execution` smallint(4) NOT NULL,
  `executiontime` bigint(10) NOT NULL,
  `checksum` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `progress` decimal(15,14) NOT NULL DEFAULT '0.00000000000000',
  `controller` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='To store the backup_controllers as they are used' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_backup_courses`
--

CREATE TABLE `mdl_backup_courses` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL DEFAULT '0',
  `laststarttime` bigint(10) NOT NULL DEFAULT '0',
  `lastendtime` bigint(10) NOT NULL DEFAULT '0',
  `laststatus` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '5',
  `nextstarttime` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='To store every course backup status' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_backup_logs`
--

CREATE TABLE `mdl_backup_logs` (
  `id` bigint(10) NOT NULL,
  `backupid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `loglevel` smallint(4) NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timecreated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='To store all the logs from backup and restore operations (by' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge`
--

CREATE TABLE `mdl_badge` (
  `id` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `usercreated` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL,
  `issuername` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `issuerurl` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `issuercontact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiredate` bigint(10) DEFAULT NULL,
  `expireperiod` bigint(10) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `courseid` bigint(10) DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `messagesubject` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` tinyint(1) NOT NULL DEFAULT '1',
  `notification` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `nextcron` bigint(10) DEFAULT NULL,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imageauthorname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imageauthoremail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imageauthorurl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagecaption` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines badge' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_alignment`
--

CREATE TABLE `mdl_badge_alignment` (
  `id` bigint(10) NOT NULL,
  `badgeid` bigint(10) NOT NULL DEFAULT '0',
  `targetname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `targeturl` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `targetdescription` longtext COLLATE utf8mb4_unicode_ci,
  `targetframework` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `targetcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines alignment for badges' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_backpack`
--

CREATE TABLE `mdl_badge_backpack` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `backpackuid` bigint(10) NOT NULL,
  `autosync` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `externalbackpackid` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines settings for connecting external backpack' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_criteria`
--

CREATE TABLE `mdl_badge_criteria` (
  `id` bigint(10) NOT NULL,
  `badgeid` bigint(10) NOT NULL DEFAULT '0',
  `criteriatype` bigint(10) DEFAULT NULL,
  `method` tinyint(1) NOT NULL DEFAULT '1',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines criteria for issuing badges' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_criteria_met`
--

CREATE TABLE `mdl_badge_criteria_met` (
  `id` bigint(10) NOT NULL,
  `issuedid` bigint(10) DEFAULT NULL,
  `critid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `datemet` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines criteria that were met for an issued badge' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_criteria_param`
--

CREATE TABLE `mdl_badge_criteria_param` (
  `id` bigint(10) NOT NULL,
  `critid` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines parameters for badges criteria' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_endorsement`
--

CREATE TABLE `mdl_badge_endorsement` (
  `id` bigint(10) NOT NULL,
  `badgeid` bigint(10) NOT NULL DEFAULT '0',
  `issuername` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `issuerurl` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `issueremail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `claimid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `claimcomment` longtext COLLATE utf8mb4_unicode_ci,
  `dateissued` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines endorsement for badge' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_external`
--

CREATE TABLE `mdl_badge_external` (
  `id` bigint(10) NOT NULL,
  `backpackid` bigint(10) NOT NULL,
  `collectionid` bigint(10) NOT NULL,
  `entityid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Setting for external badges display' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_external_backpack`
--

CREATE TABLE `mdl_badge_external_backpack` (
  `id` bigint(10) NOT NULL,
  `backpackapiurl` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `backpackweburl` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `apiversion` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.0',
  `sortorder` bigint(10) NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines settings for site level backpacks that a user can co' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_badge_external_backpack`
--

INSERT INTO `mdl_badge_external_backpack` (`id`, `backpackapiurl`, `backpackweburl`, `apiversion`, `sortorder`, `password`) VALUES
(1, 'https://backpack.openbadges.org', 'https://backpack.openbadges.org', '1', 0, ''),
(2, 'https://api.badgr.io/v2', 'https://badgr.io', '2', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_external_identifier`
--

CREATE TABLE `mdl_badge_external_identifier` (
  `id` bigint(10) NOT NULL,
  `sitebackpackid` bigint(10) NOT NULL,
  `internalid` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `externalid` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Setting for external badges mappings' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_issued`
--

CREATE TABLE `mdl_badge_issued` (
  `id` bigint(10) NOT NULL,
  `badgeid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `uniquehash` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateissued` bigint(10) NOT NULL DEFAULT '0',
  `dateexpire` bigint(10) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `issuernotified` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines issued badges' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_manual_award`
--

CREATE TABLE `mdl_badge_manual_award` (
  `id` bigint(10) NOT NULL,
  `badgeid` bigint(10) NOT NULL,
  `recipientid` bigint(10) NOT NULL,
  `issuerid` bigint(10) NOT NULL,
  `issuerrole` bigint(10) NOT NULL,
  `datemet` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Track manual award criteria for badges' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_badge_related`
--

CREATE TABLE `mdl_badge_related` (
  `id` bigint(10) NOT NULL,
  `badgeid` bigint(10) NOT NULL DEFAULT '0',
  `relatedbadgeid` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines badge related for badges' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_block`
--

CREATE TABLE `mdl_block` (
  `id` bigint(10) NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `cron` bigint(10) NOT NULL DEFAULT '0',
  `lastcron` bigint(10) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='contains all installed blocks' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_block`
--

INSERT INTO `mdl_block` (`id`, `name`, `cron`, `lastcron`, `visible`) VALUES
(1, 'activity_modules', 0, 0, 1),
(2, 'activity_results', 0, 0, 1),
(3, 'admin_bookmarks', 0, 0, 1),
(4, 'badges', 0, 0, 1),
(5, 'blog_menu', 0, 0, 1),
(6, 'blog_recent', 0, 0, 1),
(7, 'blog_tags', 0, 0, 1),
(8, 'calendar_month', 0, 0, 1),
(9, 'calendar_upcoming', 0, 0, 1),
(10, 'comments', 0, 0, 1),
(11, 'completionstatus', 0, 0, 1),
(12, 'course_list', 0, 0, 1),
(13, 'course_summary', 0, 0, 1),
(14, 'feedback', 0, 0, 1),
(15, 'globalsearch', 0, 0, 1),
(16, 'glossary_random', 0, 0, 1),
(17, 'html', 0, 0, 1),
(18, 'login', 0, 0, 1),
(19, 'lp', 0, 0, 1),
(20, 'mentees', 0, 0, 1),
(21, 'mnet_hosts', 0, 0, 1),
(22, 'myoverview', 0, 0, 1),
(23, 'myprofile', 0, 0, 1),
(24, 'navigation', 0, 0, 1),
(25, 'news_items', 0, 0, 1),
(26, 'online_users', 0, 0, 1),
(27, 'private_files', 0, 0, 1),
(28, 'quiz_results', 0, 0, 0),
(29, 'recent_activity', 0, 0, 1),
(30, 'recentlyaccessedcourses', 0, 0, 1),
(31, 'recentlyaccesseditems', 0, 0, 1),
(32, 'rss_client', 0, 0, 1),
(33, 'search_forums', 0, 0, 1),
(34, 'section_links', 0, 0, 1),
(35, 'selfcompletion', 0, 0, 1),
(36, 'settings', 0, 0, 1),
(37, 'site_main_menu', 0, 0, 1),
(38, 'social_activities', 0, 0, 1),
(39, 'starredcourses', 0, 0, 1),
(40, 'tag_flickr', 0, 0, 1),
(41, 'tag_youtube', 0, 0, 0),
(42, 'tags', 0, 0, 1),
(43, 'timeline', 0, 0, 1),
(44, 'configurable_reports', 86400, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_block_configurable_reports`
--

CREATE TABLE `mdl_block_configurable_reports` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(11) NOT NULL,
  `ownerid` bigint(11) NOT NULL,
  `visible` smallint(4) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `summary` longtext COLLATE utf8mb4_unicode_ci,
  `summaryformat` smallint(4) NOT NULL DEFAULT '0',
  `type` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pagination` smallint(4) DEFAULT NULL,
  `components` longtext COLLATE utf8mb4_unicode_ci,
  `export` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jsordering` smallint(4) DEFAULT NULL,
  `global` smallint(4) NOT NULL DEFAULT '0',
  `lastexecutiontime` bigint(10) NOT NULL DEFAULT '0',
  `cron` smallint(4) NOT NULL DEFAULT '0',
  `remote` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='block_configurable_reports table retrofitted from MySQL' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_block_instances`
--

CREATE TABLE `mdl_block_instances` (
  `id` bigint(10) NOT NULL,
  `blockname` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `parentcontextid` bigint(10) NOT NULL,
  `showinsubcontexts` smallint(4) NOT NULL,
  `requiredbytheme` smallint(4) NOT NULL DEFAULT '0',
  `pagetypepattern` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `subpagepattern` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `defaultregion` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `defaultweight` bigint(10) NOT NULL,
  `configdata` longtext COLLATE utf8mb4_unicode_ci,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table stores block instances. The type of block this is' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_block_instances`
--

INSERT INTO `mdl_block_instances` (`id`, `blockname`, `parentcontextid`, `showinsubcontexts`, `requiredbytheme`, `pagetypepattern`, `subpagepattern`, `defaultregion`, `defaultweight`, `configdata`, `timecreated`, `timemodified`) VALUES
(1, 'admin_bookmarks', 1, 0, 0, 'admin-*', NULL, 'side-pre', 2, '', 1583152049, 1583152049),
(2, 'timeline', 1, 0, 0, 'my-index', '2', 'side-post', 0, '', 1583152049, 1583152049),
(3, 'private_files', 1, 0, 0, 'my-index', '2', 'side-post', 1, '', 1583152049, 1583152049),
(4, 'online_users', 1, 0, 0, 'my-index', '2', 'side-post', 2, '', 1583152049, 1583152049),
(5, 'badges', 1, 0, 0, 'my-index', '2', 'side-post', 3, '', 1583152050, 1583152050),
(6, 'calendar_month', 1, 0, 0, 'my-index', '2', 'side-post', 4, '', 1583152050, 1583152050),
(7, 'calendar_upcoming', 1, 0, 0, 'my-index', '2', 'side-post', 5, '', 1583152050, 1583152050),
(8, 'lp', 1, 0, 0, 'my-index', '2', 'content', 0, '', 1583152050, 1583152050),
(9, 'recentlyaccessedcourses', 1, 0, 0, 'my-index', '2', 'content', 1, '', 1583152050, 1583152050),
(10, 'myoverview', 1, 0, 0, 'my-index', '2', 'content', 2, '', 1583152050, 1583152050),
(11, 'timeline', 5, 0, 0, 'my-index', '3', 'side-post', 0, '', 1583152683, 1583152683),
(12, 'private_files', 5, 0, 0, 'my-index', '3', 'side-post', 1, '', 1583152683, 1583152683),
(13, 'online_users', 5, 0, 0, 'my-index', '3', 'side-post', 2, '', 1583152683, 1583152683),
(14, 'badges', 5, 0, 0, 'my-index', '3', 'side-post', 3, '', 1583152683, 1583152683),
(15, 'calendar_month', 5, 0, 0, 'my-index', '3', 'side-post', 4, '', 1583152683, 1583152683),
(16, 'calendar_upcoming', 5, 0, 0, 'my-index', '3', 'side-post', 5, '', 1583152684, 1583152684),
(17, 'lp', 5, 0, 0, 'my-index', '3', 'content', 0, '', 1583152684, 1583152684),
(18, 'recentlyaccessedcourses', 5, 0, 0, 'my-index', '3', 'content', 1, '', 1583152684, 1583152684),
(19, 'myoverview', 5, 0, 0, 'my-index', '3', 'content', 2, '', 1583152684, 1583152684);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_block_positions`
--

CREATE TABLE `mdl_block_positions` (
  `id` bigint(10) NOT NULL,
  `blockinstanceid` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `pagetype` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `subpage` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `visible` smallint(4) NOT NULL,
  `region` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `weight` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores the position of a sticky block_instance on a another ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_block_recentlyaccesseditems`
--

CREATE TABLE `mdl_block_recentlyaccesseditems` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `cmid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `timeaccess` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Most recently accessed items accessed by a user' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_block_recent_activity`
--

CREATE TABLE `mdl_block_recent_activity` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `cmid` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `action` tinyint(1) NOT NULL,
  `modname` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Recent activity block' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_block_rss_client`
--

CREATE TABLE `mdl_block_rss_client` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `title` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `preferredtitle` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `shared` tinyint(2) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `skiptime` bigint(10) NOT NULL DEFAULT '0',
  `skipuntil` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Remote news feed information. Contains the news feed id, the' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_blog_association`
--

CREATE TABLE `mdl_blog_association` (
  `id` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `blogid` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Associations of blog entries with courses and module instanc' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_blog_external`
--

CREATE TABLE `mdl_blog_external` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `filtertags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failedlastsync` tinyint(1) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) DEFAULT NULL,
  `timefetched` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='External blog links used for RSS copying of blog entries to ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_book`
--

CREATE TABLE `mdl_book` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `numbering` smallint(4) NOT NULL DEFAULT '0',
  `navstyle` smallint(4) NOT NULL DEFAULT '1',
  `customtitles` tinyint(2) NOT NULL DEFAULT '0',
  `revision` bigint(10) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines book' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_book_chapters`
--

CREATE TABLE `mdl_book_chapters` (
  `id` bigint(10) NOT NULL,
  `bookid` bigint(10) NOT NULL DEFAULT '0',
  `pagenum` bigint(10) NOT NULL DEFAULT '0',
  `subchapter` bigint(10) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contentformat` smallint(4) NOT NULL DEFAULT '0',
  `hidden` tinyint(2) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `importsrc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines book_chapters' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_cache_filters`
--

CREATE TABLE `mdl_cache_filters` (
  `id` bigint(10) NOT NULL,
  `filter` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `version` bigint(10) NOT NULL DEFAULT '0',
  `md5key` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rawtext` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='For keeping information about cached data' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_cache_flags`
--

CREATE TABLE `mdl_cache_flags` (
  `id` bigint(10) NOT NULL,
  `flagtype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Cache of time-sensitive flags' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_cache_flags`
--

INSERT INTO `mdl_cache_flags` (`id`, `flagtype`, `name`, `timemodified`, `value`, `expiry`) VALUES
(2, 'userpreferenceschanged', '2', 1585567939, '1', 1585575139);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_capabilities`
--

CREATE TABLE `mdl_capabilities` (
  `id` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `captype` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contextlevel` bigint(10) NOT NULL DEFAULT '0',
  `component` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `riskbitmask` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='this defines all capabilities' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_capabilities`
--

INSERT INTO `mdl_capabilities` (`id`, `name`, `captype`, `contextlevel`, `component`, `riskbitmask`) VALUES
(1, 'moodle/site:config', 'write', 10, 'moodle', 62),
(2, 'moodle/site:configview', 'read', 10, 'moodle', 0),
(3, 'moodle/site:readallmessages', 'read', 10, 'moodle', 8),
(4, 'moodle/site:manageallmessaging', 'write', 10, 'moodle', 8),
(5, 'moodle/site:deleteanymessage', 'write', 10, 'moodle', 32),
(6, 'moodle/site:sendmessage', 'write', 10, 'moodle', 16),
(7, 'moodle/site:deleteownmessage', 'write', 10, 'moodle', 0),
(8, 'moodle/site:approvecourse', 'write', 40, 'moodle', 4),
(9, 'moodle/backup:backupcourse', 'write', 50, 'moodle', 28),
(10, 'moodle/backup:backupsection', 'write', 50, 'moodle', 28),
(11, 'moodle/backup:backupactivity', 'write', 70, 'moodle', 28),
(12, 'moodle/backup:backuptargetimport', 'write', 50, 'moodle', 28),
(13, 'moodle/backup:downloadfile', 'write', 50, 'moodle', 28),
(14, 'moodle/backup:configure', 'write', 50, 'moodle', 28),
(15, 'moodle/backup:userinfo', 'read', 50, 'moodle', 8),
(16, 'moodle/backup:anonymise', 'read', 50, 'moodle', 8),
(17, 'moodle/restore:restorecourse', 'write', 50, 'moodle', 28),
(18, 'moodle/restore:restoresection', 'write', 50, 'moodle', 28),
(19, 'moodle/restore:restoreactivity', 'write', 50, 'moodle', 28),
(20, 'moodle/restore:viewautomatedfilearea', 'write', 50, 'moodle', 28),
(21, 'moodle/restore:restoretargetimport', 'write', 50, 'moodle', 28),
(22, 'moodle/restore:uploadfile', 'write', 50, 'moodle', 28),
(23, 'moodle/restore:configure', 'write', 50, 'moodle', 28),
(24, 'moodle/restore:rolldates', 'write', 50, 'moodle', 0),
(25, 'moodle/restore:userinfo', 'write', 50, 'moodle', 30),
(26, 'moodle/restore:createuser', 'write', 10, 'moodle', 24),
(27, 'moodle/site:manageblocks', 'write', 80, 'moodle', 20),
(28, 'moodle/site:accessallgroups', 'read', 70, 'moodle', 0),
(29, 'moodle/site:viewfullnames', 'read', 70, 'moodle', 0),
(30, 'moodle/site:viewuseridentity', 'read', 70, 'moodle', 0),
(31, 'moodle/site:viewreports', 'read', 50, 'moodle', 8),
(32, 'moodle/site:trustcontent', 'write', 70, 'moodle', 4),
(33, 'moodle/site:uploadusers', 'write', 10, 'moodle', 24),
(34, 'moodle/filter:manage', 'write', 50, 'moodle', 0),
(35, 'moodle/user:create', 'write', 10, 'moodle', 24),
(36, 'moodle/user:delete', 'write', 10, 'moodle', 40),
(37, 'moodle/user:update', 'write', 10, 'moodle', 24),
(38, 'moodle/user:viewdetails', 'read', 50, 'moodle', 0),
(39, 'moodle/user:viewalldetails', 'read', 30, 'moodle', 8),
(40, 'moodle/user:viewlastip', 'read', 30, 'moodle', 8),
(41, 'moodle/user:viewhiddendetails', 'read', 50, 'moodle', 8),
(42, 'moodle/user:loginas', 'write', 50, 'moodle', 30),
(43, 'moodle/user:managesyspages', 'write', 10, 'moodle', 0),
(44, 'moodle/user:manageblocks', 'write', 30, 'moodle', 0),
(45, 'moodle/user:manageownblocks', 'write', 10, 'moodle', 0),
(46, 'moodle/user:manageownfiles', 'write', 10, 'moodle', 0),
(47, 'moodle/user:ignoreuserquota', 'write', 10, 'moodle', 0),
(48, 'moodle/my:configsyspages', 'write', 10, 'moodle', 0),
(49, 'moodle/role:assign', 'write', 50, 'moodle', 28),
(50, 'moodle/role:review', 'read', 50, 'moodle', 8),
(51, 'moodle/role:override', 'write', 50, 'moodle', 28),
(52, 'moodle/role:safeoverride', 'write', 50, 'moodle', 16),
(53, 'moodle/role:manage', 'write', 10, 'moodle', 28),
(54, 'moodle/role:switchroles', 'read', 50, 'moodle', 12),
(55, 'moodle/category:manage', 'write', 40, 'moodle', 4),
(56, 'moodle/category:viewcourselist', 'read', 40, 'moodle', 0),
(57, 'moodle/category:viewhiddencategories', 'read', 40, 'moodle', 0),
(58, 'moodle/cohort:manage', 'write', 40, 'moodle', 0),
(59, 'moodle/cohort:assign', 'write', 40, 'moodle', 0),
(60, 'moodle/cohort:view', 'read', 50, 'moodle', 0),
(61, 'moodle/course:create', 'write', 40, 'moodle', 4),
(62, 'moodle/course:creategroupconversations', 'write', 50, 'moodle', 4),
(63, 'moodle/course:request', 'write', 40, 'moodle', 0),
(64, 'moodle/course:delete', 'write', 50, 'moodle', 32),
(65, 'moodle/course:update', 'write', 50, 'moodle', 4),
(66, 'moodle/course:view', 'read', 50, 'moodle', 0),
(67, 'moodle/course:enrolreview', 'read', 50, 'moodle', 8),
(68, 'moodle/course:enrolconfig', 'write', 50, 'moodle', 8),
(69, 'moodle/course:reviewotherusers', 'read', 50, 'moodle', 0),
(70, 'moodle/course:bulkmessaging', 'write', 50, 'moodle', 16),
(71, 'moodle/course:viewhiddenuserfields', 'read', 50, 'moodle', 8),
(72, 'moodle/course:viewhiddencourses', 'read', 50, 'moodle', 0),
(73, 'moodle/course:visibility', 'write', 50, 'moodle', 0),
(74, 'moodle/course:managefiles', 'write', 50, 'moodle', 4),
(75, 'moodle/course:ignoreavailabilityrestrictions', 'read', 70, 'moodle', 0),
(76, 'moodle/course:ignorefilesizelimits', 'write', 50, 'moodle', 0),
(77, 'moodle/course:manageactivities', 'write', 70, 'moodle', 4),
(78, 'moodle/course:activityvisibility', 'write', 70, 'moodle', 0),
(79, 'moodle/course:viewhiddenactivities', 'write', 70, 'moodle', 0),
(80, 'moodle/course:viewparticipants', 'read', 50, 'moodle', 0),
(81, 'moodle/course:changefullname', 'write', 50, 'moodle', 4),
(82, 'moodle/course:changeshortname', 'write', 50, 'moodle', 4),
(83, 'moodle/course:changelockedcustomfields', 'write', 50, 'moodle', 16),
(84, 'moodle/course:configurecustomfields', 'write', 10, 'moodle', 16),
(85, 'moodle/course:renameroles', 'write', 50, 'moodle', 0),
(86, 'moodle/course:changeidnumber', 'write', 50, 'moodle', 4),
(87, 'moodle/course:changecategory', 'write', 50, 'moodle', 4),
(88, 'moodle/course:changesummary', 'write', 50, 'moodle', 4),
(89, 'moodle/course:setforcedlanguage', 'write', 50, 'moodle', 0),
(90, 'moodle/site:viewparticipants', 'read', 10, 'moodle', 0),
(91, 'moodle/course:isincompletionreports', 'read', 50, 'moodle', 0),
(92, 'moodle/course:viewscales', 'read', 50, 'moodle', 0),
(93, 'moodle/course:managescales', 'write', 50, 'moodle', 0),
(94, 'moodle/course:managegroups', 'write', 50, 'moodle', 4),
(95, 'moodle/course:reset', 'write', 50, 'moodle', 32),
(96, 'moodle/course:viewsuspendedusers', 'read', 50, 'moodle', 0),
(97, 'moodle/course:tag', 'write', 50, 'moodle', 16),
(98, 'moodle/blog:view', 'read', 10, 'moodle', 0),
(99, 'moodle/blog:search', 'read', 10, 'moodle', 0),
(100, 'moodle/blog:viewdrafts', 'read', 10, 'moodle', 8),
(101, 'moodle/blog:create', 'write', 10, 'moodle', 16),
(102, 'moodle/blog:manageentries', 'write', 10, 'moodle', 16),
(103, 'moodle/blog:manageexternal', 'write', 10, 'moodle', 16),
(104, 'moodle/calendar:manageownentries', 'write', 50, 'moodle', 16),
(105, 'moodle/calendar:managegroupentries', 'write', 50, 'moodle', 16),
(106, 'moodle/calendar:manageentries', 'write', 50, 'moodle', 16),
(107, 'moodle/user:editprofile', 'write', 30, 'moodle', 24),
(108, 'moodle/user:editownprofile', 'write', 10, 'moodle', 16),
(109, 'moodle/user:changeownpassword', 'write', 10, 'moodle', 0),
(110, 'moodle/user:readuserposts', 'read', 30, 'moodle', 0),
(111, 'moodle/user:readuserblogs', 'read', 30, 'moodle', 0),
(112, 'moodle/user:viewuseractivitiesreport', 'read', 30, 'moodle', 8),
(113, 'moodle/user:editmessageprofile', 'write', 30, 'moodle', 16),
(114, 'moodle/user:editownmessageprofile', 'write', 10, 'moodle', 0),
(115, 'moodle/question:managecategory', 'write', 50, 'moodle', 20),
(116, 'moodle/question:add', 'write', 50, 'moodle', 20),
(117, 'moodle/question:editmine', 'write', 50, 'moodle', 20),
(118, 'moodle/question:editall', 'write', 50, 'moodle', 20),
(119, 'moodle/question:viewmine', 'read', 50, 'moodle', 0),
(120, 'moodle/question:viewall', 'read', 50, 'moodle', 0),
(121, 'moodle/question:usemine', 'read', 50, 'moodle', 0),
(122, 'moodle/question:useall', 'read', 50, 'moodle', 0),
(123, 'moodle/question:movemine', 'write', 50, 'moodle', 0),
(124, 'moodle/question:moveall', 'write', 50, 'moodle', 0),
(125, 'moodle/question:config', 'write', 10, 'moodle', 2),
(126, 'moodle/question:flag', 'write', 50, 'moodle', 0),
(127, 'moodle/question:tagmine', 'write', 50, 'moodle', 0),
(128, 'moodle/question:tagall', 'write', 50, 'moodle', 0),
(129, 'moodle/site:doclinks', 'read', 10, 'moodle', 0),
(130, 'moodle/course:sectionvisibility', 'write', 50, 'moodle', 0),
(131, 'moodle/course:useremail', 'write', 50, 'moodle', 0),
(132, 'moodle/course:viewhiddensections', 'write', 50, 'moodle', 0),
(133, 'moodle/course:setcurrentsection', 'write', 50, 'moodle', 0),
(134, 'moodle/course:movesections', 'write', 50, 'moodle', 0),
(135, 'moodle/site:mnetlogintoremote', 'read', 10, 'moodle', 0),
(136, 'moodle/grade:viewall', 'read', 50, 'moodle', 8),
(137, 'moodle/grade:view', 'read', 50, 'moodle', 0),
(138, 'moodle/grade:viewhidden', 'read', 50, 'moodle', 8),
(139, 'moodle/grade:import', 'write', 50, 'moodle', 12),
(140, 'moodle/grade:export', 'read', 50, 'moodle', 8),
(141, 'moodle/grade:manage', 'write', 50, 'moodle', 12),
(142, 'moodle/grade:edit', 'write', 50, 'moodle', 12),
(143, 'moodle/grade:managegradingforms', 'write', 50, 'moodle', 12),
(144, 'moodle/grade:sharegradingforms', 'write', 10, 'moodle', 4),
(145, 'moodle/grade:managesharedforms', 'write', 10, 'moodle', 4),
(146, 'moodle/grade:manageoutcomes', 'write', 50, 'moodle', 0),
(147, 'moodle/grade:manageletters', 'write', 50, 'moodle', 0),
(148, 'moodle/grade:hide', 'write', 50, 'moodle', 0),
(149, 'moodle/grade:lock', 'write', 50, 'moodle', 0),
(150, 'moodle/grade:unlock', 'write', 50, 'moodle', 0),
(151, 'moodle/my:manageblocks', 'write', 10, 'moodle', 0),
(152, 'moodle/notes:view', 'read', 50, 'moodle', 0),
(153, 'moodle/notes:manage', 'write', 50, 'moodle', 16),
(154, 'moodle/tag:manage', 'write', 10, 'moodle', 16),
(155, 'moodle/tag:edit', 'write', 10, 'moodle', 16),
(156, 'moodle/tag:flag', 'write', 10, 'moodle', 16),
(157, 'moodle/tag:editblocks', 'write', 10, 'moodle', 0),
(158, 'moodle/block:view', 'read', 80, 'moodle', 0),
(159, 'moodle/block:edit', 'write', 80, 'moodle', 20),
(160, 'moodle/portfolio:export', 'read', 10, 'moodle', 0),
(161, 'moodle/comment:view', 'read', 50, 'moodle', 0),
(162, 'moodle/comment:post', 'write', 50, 'moodle', 24),
(163, 'moodle/comment:delete', 'write', 50, 'moodle', 32),
(164, 'moodle/webservice:createtoken', 'write', 10, 'moodle', 62),
(165, 'moodle/webservice:managealltokens', 'write', 10, 'moodle', 42),
(166, 'moodle/webservice:createmobiletoken', 'write', 10, 'moodle', 24),
(167, 'moodle/rating:view', 'read', 50, 'moodle', 0),
(168, 'moodle/rating:viewany', 'read', 50, 'moodle', 8),
(169, 'moodle/rating:viewall', 'read', 50, 'moodle', 8),
(170, 'moodle/rating:rate', 'write', 50, 'moodle', 0),
(171, 'moodle/course:markcomplete', 'write', 50, 'moodle', 0),
(172, 'moodle/course:overridecompletion', 'write', 50, 'moodle', 0),
(173, 'moodle/badges:manageglobalsettings', 'write', 10, 'moodle', 34),
(174, 'moodle/badges:viewbadges', 'read', 50, 'moodle', 0),
(175, 'moodle/badges:manageownbadges', 'write', 30, 'moodle', 0),
(176, 'moodle/badges:viewotherbadges', 'read', 30, 'moodle', 0),
(177, 'moodle/badges:earnbadge', 'write', 50, 'moodle', 0),
(178, 'moodle/badges:createbadge', 'write', 50, 'moodle', 16),
(179, 'moodle/badges:deletebadge', 'write', 50, 'moodle', 32),
(180, 'moodle/badges:configuredetails', 'write', 50, 'moodle', 16),
(181, 'moodle/badges:configurecriteria', 'write', 50, 'moodle', 4),
(182, 'moodle/badges:configuremessages', 'write', 50, 'moodle', 16),
(183, 'moodle/badges:awardbadge', 'write', 50, 'moodle', 16),
(184, 'moodle/badges:revokebadge', 'write', 50, 'moodle', 16),
(185, 'moodle/badges:viewawarded', 'read', 50, 'moodle', 8),
(186, 'moodle/site:forcelanguage', 'read', 10, 'moodle', 0),
(187, 'moodle/search:query', 'read', 10, 'moodle', 0),
(188, 'moodle/competency:competencymanage', 'write', 40, 'moodle', 0),
(189, 'moodle/competency:competencyview', 'read', 40, 'moodle', 0),
(190, 'moodle/competency:competencygrade', 'write', 50, 'moodle', 0),
(191, 'moodle/competency:coursecompetencymanage', 'write', 50, 'moodle', 0),
(192, 'moodle/competency:coursecompetencyconfigure', 'write', 70, 'moodle', 0),
(193, 'moodle/competency:coursecompetencygradable', 'read', 50, 'moodle', 0),
(194, 'moodle/competency:coursecompetencyview', 'read', 50, 'moodle', 0),
(195, 'moodle/competency:evidencedelete', 'write', 30, 'moodle', 0),
(196, 'moodle/competency:planmanage', 'write', 30, 'moodle', 0),
(197, 'moodle/competency:planmanagedraft', 'write', 30, 'moodle', 0),
(198, 'moodle/competency:planmanageown', 'write', 30, 'moodle', 0),
(199, 'moodle/competency:planmanageowndraft', 'write', 30, 'moodle', 0),
(200, 'moodle/competency:planview', 'read', 30, 'moodle', 0),
(201, 'moodle/competency:planviewdraft', 'read', 30, 'moodle', 0),
(202, 'moodle/competency:planviewown', 'read', 30, 'moodle', 0),
(203, 'moodle/competency:planviewowndraft', 'read', 30, 'moodle', 0),
(204, 'moodle/competency:planrequestreview', 'write', 30, 'moodle', 0),
(205, 'moodle/competency:planrequestreviewown', 'write', 30, 'moodle', 0),
(206, 'moodle/competency:planreview', 'write', 30, 'moodle', 0),
(207, 'moodle/competency:plancomment', 'write', 30, 'moodle', 0),
(208, 'moodle/competency:plancommentown', 'write', 30, 'moodle', 0),
(209, 'moodle/competency:usercompetencyview', 'read', 30, 'moodle', 0),
(210, 'moodle/competency:usercompetencyrequestreview', 'write', 30, 'moodle', 0),
(211, 'moodle/competency:usercompetencyrequestreviewown', 'write', 30, 'moodle', 0),
(212, 'moodle/competency:usercompetencyreview', 'write', 30, 'moodle', 0),
(213, 'moodle/competency:usercompetencycomment', 'write', 30, 'moodle', 0),
(214, 'moodle/competency:usercompetencycommentown', 'write', 30, 'moodle', 0),
(215, 'moodle/competency:templatemanage', 'write', 40, 'moodle', 0),
(216, 'moodle/analytics:listinsights', 'read', 50, 'moodle', 8),
(217, 'moodle/analytics:managemodels', 'write', 10, 'moodle', 2),
(218, 'moodle/competency:templateview', 'read', 40, 'moodle', 0),
(219, 'moodle/competency:userevidencemanage', 'write', 30, 'moodle', 0),
(220, 'moodle/competency:userevidencemanageown', 'write', 30, 'moodle', 0),
(221, 'moodle/competency:userevidenceview', 'read', 30, 'moodle', 0),
(222, 'moodle/site:maintenanceaccess', 'write', 10, 'moodle', 0),
(223, 'moodle/site:messageanyuser', 'write', 10, 'moodle', 16),
(224, 'moodle/site:managecontextlocks', 'write', 70, 'moodle', 0),
(225, 'moodle/course:togglecompletion', 'write', 70, 'moodle', 0),
(226, 'moodle/analytics:listowninsights', 'read', 10, 'moodle', 0),
(227, 'moodle/h5p:setdisplayoptions', 'write', 70, 'moodle', 0),
(228, 'moodle/h5p:deploy', 'write', 70, 'moodle', 4),
(229, 'moodle/h5p:updatelibraries', 'write', 70, 'moodle', 4),
(230, 'mod/assign:view', 'read', 70, 'mod_assign', 0),
(231, 'mod/assign:submit', 'write', 70, 'mod_assign', 0),
(232, 'mod/assign:grade', 'write', 70, 'mod_assign', 4),
(233, 'mod/assign:exportownsubmission', 'read', 70, 'mod_assign', 0),
(234, 'mod/assign:addinstance', 'write', 50, 'mod_assign', 4),
(235, 'mod/assign:editothersubmission', 'write', 70, 'mod_assign', 41),
(236, 'mod/assign:grantextension', 'write', 70, 'mod_assign', 0),
(237, 'mod/assign:revealidentities', 'write', 70, 'mod_assign', 0),
(238, 'mod/assign:reviewgrades', 'write', 70, 'mod_assign', 0),
(239, 'mod/assign:releasegrades', 'write', 70, 'mod_assign', 0),
(240, 'mod/assign:managegrades', 'write', 70, 'mod_assign', 0),
(241, 'mod/assign:manageallocations', 'write', 70, 'mod_assign', 0),
(242, 'mod/assign:viewgrades', 'read', 70, 'mod_assign', 0),
(243, 'mod/assign:viewblinddetails', 'write', 70, 'mod_assign', 8),
(244, 'mod/assign:receivegradernotifications', 'read', 70, 'mod_assign', 0),
(245, 'mod/assign:manageoverrides', 'write', 70, 'mod_assign', 0),
(246, 'mod/assign:showhiddengrader', 'read', 70, 'mod_assign', 0),
(247, 'mod/assignment:view', 'read', 70, 'mod_assignment', 0),
(248, 'mod/assignment:addinstance', 'write', 50, 'mod_assignment', 4),
(249, 'mod/assignment:submit', 'write', 70, 'mod_assignment', 0),
(250, 'mod/assignment:grade', 'write', 70, 'mod_assignment', 4),
(251, 'mod/assignment:exportownsubmission', 'read', 70, 'mod_assignment', 0),
(252, 'mod/book:addinstance', 'write', 50, 'mod_book', 4),
(253, 'mod/book:read', 'read', 70, 'mod_book', 0),
(254, 'mod/book:viewhiddenchapters', 'read', 70, 'mod_book', 0),
(255, 'mod/book:edit', 'write', 70, 'mod_book', 4),
(256, 'mod/chat:addinstance', 'write', 50, 'mod_chat', 4),
(257, 'mod/chat:chat', 'write', 70, 'mod_chat', 16),
(258, 'mod/chat:readlog', 'read', 70, 'mod_chat', 0),
(259, 'mod/chat:deletelog', 'write', 70, 'mod_chat', 0),
(260, 'mod/chat:exportparticipatedsession', 'read', 70, 'mod_chat', 8),
(261, 'mod/chat:exportsession', 'read', 70, 'mod_chat', 8),
(262, 'mod/chat:view', 'read', 70, 'mod_chat', 0),
(263, 'mod/choice:addinstance', 'write', 50, 'mod_choice', 4),
(264, 'mod/choice:choose', 'write', 70, 'mod_choice', 0),
(265, 'mod/choice:readresponses', 'read', 70, 'mod_choice', 0),
(266, 'mod/choice:deleteresponses', 'write', 70, 'mod_choice', 0),
(267, 'mod/choice:downloadresponses', 'read', 70, 'mod_choice', 0),
(268, 'mod/choice:view', 'read', 70, 'mod_choice', 0),
(269, 'mod/data:addinstance', 'write', 50, 'mod_data', 4),
(270, 'mod/data:viewentry', 'read', 70, 'mod_data', 0),
(271, 'mod/data:writeentry', 'write', 70, 'mod_data', 16),
(272, 'mod/data:comment', 'write', 70, 'mod_data', 16),
(273, 'mod/data:rate', 'write', 70, 'mod_data', 0),
(274, 'mod/data:viewrating', 'read', 70, 'mod_data', 0),
(275, 'mod/data:viewanyrating', 'read', 70, 'mod_data', 8),
(276, 'mod/data:viewallratings', 'read', 70, 'mod_data', 8),
(277, 'mod/data:approve', 'write', 70, 'mod_data', 16),
(278, 'mod/data:manageentries', 'write', 70, 'mod_data', 16),
(279, 'mod/data:managecomments', 'write', 70, 'mod_data', 16),
(280, 'mod/data:managetemplates', 'write', 70, 'mod_data', 20),
(281, 'mod/data:viewalluserpresets', 'read', 70, 'mod_data', 0),
(282, 'mod/data:manageuserpresets', 'write', 70, 'mod_data', 20),
(283, 'mod/data:exportentry', 'read', 70, 'mod_data', 8),
(284, 'mod/data:exportownentry', 'read', 70, 'mod_data', 0),
(285, 'mod/data:exportallentries', 'read', 70, 'mod_data', 8),
(286, 'mod/data:exportuserinfo', 'read', 70, 'mod_data', 8),
(287, 'mod/data:view', 'read', 70, 'mod_data', 0),
(288, 'mod/feedback:addinstance', 'write', 50, 'mod_feedback', 4),
(289, 'mod/feedback:view', 'read', 70, 'mod_feedback', 0),
(290, 'mod/feedback:complete', 'write', 70, 'mod_feedback', 16),
(291, 'mod/feedback:viewanalysepage', 'read', 70, 'mod_feedback', 8),
(292, 'mod/feedback:deletesubmissions', 'write', 70, 'mod_feedback', 0),
(293, 'mod/feedback:mapcourse', 'write', 70, 'mod_feedback', 0),
(294, 'mod/feedback:edititems', 'write', 70, 'mod_feedback', 20),
(295, 'mod/feedback:createprivatetemplate', 'write', 70, 'mod_feedback', 16),
(296, 'mod/feedback:createpublictemplate', 'write', 70, 'mod_feedback', 16),
(297, 'mod/feedback:deletetemplate', 'write', 70, 'mod_feedback', 0),
(298, 'mod/feedback:viewreports', 'read', 70, 'mod_feedback', 8),
(299, 'mod/feedback:receivemail', 'read', 70, 'mod_feedback', 8),
(300, 'mod/folder:addinstance', 'write', 50, 'mod_folder', 4),
(301, 'mod/folder:view', 'read', 70, 'mod_folder', 0),
(302, 'mod/folder:managefiles', 'write', 70, 'mod_folder', 16),
(303, 'mod/forum:addinstance', 'write', 50, 'mod_forum', 4),
(304, 'mod/forum:viewdiscussion', 'read', 70, 'mod_forum', 0),
(305, 'mod/forum:viewhiddentimedposts', 'read', 70, 'mod_forum', 0),
(306, 'mod/forum:startdiscussion', 'write', 70, 'mod_forum', 16),
(307, 'mod/forum:replypost', 'write', 70, 'mod_forum', 16),
(308, 'mod/forum:addnews', 'write', 70, 'mod_forum', 16),
(309, 'mod/forum:replynews', 'write', 70, 'mod_forum', 16),
(310, 'mod/forum:viewrating', 'read', 70, 'mod_forum', 0),
(311, 'mod/forum:viewanyrating', 'read', 70, 'mod_forum', 8),
(312, 'mod/forum:viewallratings', 'read', 70, 'mod_forum', 8),
(313, 'mod/forum:rate', 'write', 70, 'mod_forum', 0),
(314, 'mod/forum:postprivatereply', 'write', 70, 'mod_forum', 0),
(315, 'mod/forum:readprivatereplies', 'read', 70, 'mod_forum', 0),
(316, 'mod/forum:createattachment', 'write', 70, 'mod_forum', 16),
(317, 'mod/forum:deleteownpost', 'write', 70, 'mod_forum', 0),
(318, 'mod/forum:deleteanypost', 'write', 70, 'mod_forum', 0),
(319, 'mod/forum:splitdiscussions', 'write', 70, 'mod_forum', 0),
(320, 'mod/forum:movediscussions', 'write', 70, 'mod_forum', 0),
(321, 'mod/forum:pindiscussions', 'write', 70, 'mod_forum', 0),
(322, 'mod/forum:editanypost', 'write', 70, 'mod_forum', 16),
(323, 'mod/forum:viewqandawithoutposting', 'read', 70, 'mod_forum', 0),
(324, 'mod/forum:viewsubscribers', 'read', 70, 'mod_forum', 0),
(325, 'mod/forum:managesubscriptions', 'write', 70, 'mod_forum', 16),
(326, 'mod/forum:postwithoutthrottling', 'write', 70, 'mod_forum', 16),
(327, 'mod/forum:exportdiscussion', 'read', 70, 'mod_forum', 8),
(328, 'mod/forum:exportforum', 'read', 70, 'mod_forum', 8),
(329, 'mod/forum:exportpost', 'read', 70, 'mod_forum', 8),
(330, 'mod/forum:exportownpost', 'read', 70, 'mod_forum', 8),
(331, 'mod/forum:addquestion', 'write', 70, 'mod_forum', 16),
(332, 'mod/forum:allowforcesubscribe', 'read', 70, 'mod_forum', 0),
(333, 'mod/forum:canposttomygroups', 'write', 70, 'mod_forum', 0),
(334, 'mod/forum:canoverridediscussionlock', 'write', 70, 'mod_forum', 0),
(335, 'mod/forum:canoverridecutoff', 'write', 70, 'mod_forum', 0),
(336, 'mod/forum:cantogglefavourite', 'write', 70, 'mod_forum', 0),
(337, 'mod/forum:grade', 'write', 70, 'mod_forum', 0),
(338, 'mod/glossary:addinstance', 'write', 50, 'mod_glossary', 4),
(339, 'mod/glossary:view', 'read', 70, 'mod_glossary', 0),
(340, 'mod/glossary:write', 'write', 70, 'mod_glossary', 16),
(341, 'mod/glossary:manageentries', 'write', 70, 'mod_glossary', 16),
(342, 'mod/glossary:managecategories', 'write', 70, 'mod_glossary', 16),
(343, 'mod/glossary:comment', 'write', 70, 'mod_glossary', 16),
(344, 'mod/glossary:managecomments', 'write', 70, 'mod_glossary', 16),
(345, 'mod/glossary:import', 'write', 70, 'mod_glossary', 16),
(346, 'mod/glossary:export', 'read', 70, 'mod_glossary', 0),
(347, 'mod/glossary:approve', 'write', 70, 'mod_glossary', 16),
(348, 'mod/glossary:rate', 'write', 70, 'mod_glossary', 0),
(349, 'mod/glossary:viewrating', 'read', 70, 'mod_glossary', 0),
(350, 'mod/glossary:viewanyrating', 'read', 70, 'mod_glossary', 8),
(351, 'mod/glossary:viewallratings', 'read', 70, 'mod_glossary', 8),
(352, 'mod/glossary:exportentry', 'read', 70, 'mod_glossary', 8),
(353, 'mod/glossary:exportownentry', 'read', 70, 'mod_glossary', 0),
(354, 'mod/imscp:view', 'read', 70, 'mod_imscp', 0),
(355, 'mod/imscp:addinstance', 'write', 50, 'mod_imscp', 4),
(356, 'mod/label:addinstance', 'write', 50, 'mod_label', 4),
(357, 'mod/label:view', 'read', 70, 'mod_label', 0),
(358, 'mod/lesson:addinstance', 'write', 50, 'mod_lesson', 4),
(359, 'mod/lesson:edit', 'write', 70, 'mod_lesson', 4),
(360, 'mod/lesson:grade', 'write', 70, 'mod_lesson', 20),
(361, 'mod/lesson:viewreports', 'read', 70, 'mod_lesson', 8),
(362, 'mod/lesson:manage', 'write', 70, 'mod_lesson', 0),
(363, 'mod/lesson:manageoverrides', 'write', 70, 'mod_lesson', 0),
(364, 'mod/lesson:view', 'read', 70, 'mod_lesson', 0),
(365, 'mod/lti:view', 'read', 70, 'mod_lti', 0),
(366, 'mod/lti:addinstance', 'write', 50, 'mod_lti', 4),
(367, 'mod/lti:manage', 'write', 70, 'mod_lti', 8),
(368, 'mod/lti:admin', 'write', 70, 'mod_lti', 8),
(369, 'mod/lti:addcoursetool', 'write', 50, 'mod_lti', 0),
(370, 'mod/lti:requesttooladd', 'write', 50, 'mod_lti', 0),
(371, 'mod/page:view', 'read', 70, 'mod_page', 0),
(372, 'mod/page:addinstance', 'write', 50, 'mod_page', 4),
(373, 'mod/quiz:view', 'read', 70, 'mod_quiz', 0),
(374, 'mod/quiz:addinstance', 'write', 50, 'mod_quiz', 4),
(375, 'mod/quiz:attempt', 'write', 70, 'mod_quiz', 16),
(376, 'mod/quiz:reviewmyattempts', 'read', 70, 'mod_quiz', 0),
(377, 'mod/quiz:manage', 'write', 70, 'mod_quiz', 16),
(378, 'mod/quiz:manageoverrides', 'write', 70, 'mod_quiz', 0),
(379, 'mod/quiz:preview', 'write', 70, 'mod_quiz', 0),
(380, 'mod/quiz:grade', 'write', 70, 'mod_quiz', 20),
(381, 'mod/quiz:regrade', 'write', 70, 'mod_quiz', 16),
(382, 'mod/quiz:viewreports', 'read', 70, 'mod_quiz', 8),
(383, 'mod/quiz:deleteattempts', 'write', 70, 'mod_quiz', 32),
(384, 'mod/quiz:ignoretimelimits', 'read', 70, 'mod_quiz', 0),
(385, 'mod/quiz:emailconfirmsubmission', 'read', 70, 'mod_quiz', 0),
(386, 'mod/quiz:emailnotifysubmission', 'read', 70, 'mod_quiz', 0),
(387, 'mod/quiz:emailwarnoverdue', 'read', 70, 'mod_quiz', 0),
(388, 'mod/resource:view', 'read', 70, 'mod_resource', 0),
(389, 'mod/resource:addinstance', 'write', 50, 'mod_resource', 4),
(390, 'mod/scorm:addinstance', 'write', 50, 'mod_scorm', 4),
(391, 'mod/scorm:viewreport', 'read', 70, 'mod_scorm', 0),
(392, 'mod/scorm:skipview', 'read', 70, 'mod_scorm', 0),
(393, 'mod/scorm:savetrack', 'write', 70, 'mod_scorm', 0),
(394, 'mod/scorm:viewscores', 'read', 70, 'mod_scorm', 0),
(395, 'mod/scorm:deleteresponses', 'write', 70, 'mod_scorm', 0),
(396, 'mod/scorm:deleteownresponses', 'write', 70, 'mod_scorm', 0),
(397, 'mod/survey:addinstance', 'write', 50, 'mod_survey', 4),
(398, 'mod/survey:participate', 'read', 70, 'mod_survey', 0),
(399, 'mod/survey:readresponses', 'read', 70, 'mod_survey', 0),
(400, 'mod/survey:download', 'read', 70, 'mod_survey', 0),
(401, 'mod/url:view', 'read', 70, 'mod_url', 0),
(402, 'mod/url:addinstance', 'write', 50, 'mod_url', 4),
(403, 'mod/wiki:addinstance', 'write', 50, 'mod_wiki', 4),
(404, 'mod/wiki:viewpage', 'read', 70, 'mod_wiki', 0),
(405, 'mod/wiki:editpage', 'write', 70, 'mod_wiki', 16),
(406, 'mod/wiki:createpage', 'write', 70, 'mod_wiki', 16),
(407, 'mod/wiki:viewcomment', 'read', 70, 'mod_wiki', 0),
(408, 'mod/wiki:editcomment', 'write', 70, 'mod_wiki', 16),
(409, 'mod/wiki:managecomment', 'write', 70, 'mod_wiki', 0),
(410, 'mod/wiki:managefiles', 'write', 70, 'mod_wiki', 0),
(411, 'mod/wiki:overridelock', 'write', 70, 'mod_wiki', 0),
(412, 'mod/wiki:managewiki', 'write', 70, 'mod_wiki', 0),
(413, 'mod/workshop:view', 'read', 70, 'mod_workshop', 0),
(414, 'mod/workshop:addinstance', 'write', 50, 'mod_workshop', 4),
(415, 'mod/workshop:switchphase', 'write', 70, 'mod_workshop', 0),
(416, 'mod/workshop:editdimensions', 'write', 70, 'mod_workshop', 4),
(417, 'mod/workshop:submit', 'write', 70, 'mod_workshop', 0),
(418, 'mod/workshop:peerassess', 'write', 70, 'mod_workshop', 0),
(419, 'mod/workshop:manageexamples', 'write', 70, 'mod_workshop', 0),
(420, 'mod/workshop:allocate', 'write', 70, 'mod_workshop', 0),
(421, 'mod/workshop:publishsubmissions', 'write', 70, 'mod_workshop', 0),
(422, 'mod/workshop:viewauthornames', 'read', 70, 'mod_workshop', 0),
(423, 'mod/workshop:viewreviewernames', 'read', 70, 'mod_workshop', 0),
(424, 'mod/workshop:viewallsubmissions', 'read', 70, 'mod_workshop', 0),
(425, 'mod/workshop:viewpublishedsubmissions', 'read', 70, 'mod_workshop', 0),
(426, 'mod/workshop:viewauthorpublished', 'read', 70, 'mod_workshop', 0),
(427, 'mod/workshop:viewallassessments', 'read', 70, 'mod_workshop', 0),
(428, 'mod/workshop:overridegrades', 'write', 70, 'mod_workshop', 0),
(429, 'mod/workshop:ignoredeadlines', 'write', 70, 'mod_workshop', 0),
(430, 'mod/workshop:deletesubmissions', 'write', 70, 'mod_workshop', 0),
(431, 'mod/workshop:exportsubmissions', 'read', 70, 'mod_workshop', 0),
(432, 'auth/oauth2:managelinkedlogins', 'write', 30, 'auth_oauth2', 0),
(433, 'enrol/category:synchronised', 'write', 10, 'enrol_category', 0),
(434, 'enrol/category:config', 'write', 50, 'enrol_category', 0),
(435, 'enrol/cohort:config', 'write', 50, 'enrol_cohort', 0),
(436, 'enrol/cohort:unenrol', 'write', 50, 'enrol_cohort', 0),
(437, 'enrol/database:unenrol', 'write', 50, 'enrol_database', 0),
(438, 'enrol/database:config', 'write', 50, 'enrol_database', 0),
(439, 'enrol/flatfile:manage', 'write', 50, 'enrol_flatfile', 0),
(440, 'enrol/flatfile:unenrol', 'write', 50, 'enrol_flatfile', 0),
(441, 'enrol/guest:config', 'write', 50, 'enrol_guest', 0),
(442, 'enrol/imsenterprise:config', 'write', 50, 'enrol_imsenterprise', 0),
(443, 'enrol/ldap:manage', 'write', 50, 'enrol_ldap', 0),
(444, 'enrol/lti:config', 'write', 50, 'enrol_lti', 0),
(445, 'enrol/lti:unenrol', 'write', 50, 'enrol_lti', 0),
(446, 'enrol/manual:config', 'write', 50, 'enrol_manual', 0),
(447, 'enrol/manual:enrol', 'write', 50, 'enrol_manual', 0),
(448, 'enrol/manual:manage', 'write', 50, 'enrol_manual', 0),
(449, 'enrol/manual:unenrol', 'write', 50, 'enrol_manual', 0),
(450, 'enrol/manual:unenrolself', 'write', 50, 'enrol_manual', 0),
(451, 'enrol/meta:config', 'write', 50, 'enrol_meta', 0),
(452, 'enrol/meta:selectaslinked', 'read', 50, 'enrol_meta', 0),
(453, 'enrol/meta:unenrol', 'write', 50, 'enrol_meta', 0),
(454, 'enrol/mnet:config', 'write', 50, 'enrol_mnet', 0),
(455, 'enrol/paypal:config', 'write', 50, 'enrol_paypal', 0),
(456, 'enrol/paypal:manage', 'write', 50, 'enrol_paypal', 0),
(457, 'enrol/paypal:unenrol', 'write', 50, 'enrol_paypal', 0),
(458, 'enrol/paypal:unenrolself', 'write', 50, 'enrol_paypal', 0),
(459, 'enrol/self:config', 'write', 50, 'enrol_self', 0),
(460, 'enrol/self:manage', 'write', 50, 'enrol_self', 0),
(461, 'enrol/self:holdkey', 'write', 50, 'enrol_self', 0),
(462, 'enrol/self:unenrolself', 'write', 50, 'enrol_self', 0),
(463, 'enrol/self:unenrol', 'write', 50, 'enrol_self', 0),
(464, 'message/airnotifier:managedevice', 'write', 10, 'message_airnotifier', 0),
(465, 'block/activity_modules:addinstance', 'write', 80, 'block_activity_modules', 20),
(466, 'block/activity_results:addinstance', 'write', 80, 'block_activity_results', 20),
(467, 'block/admin_bookmarks:myaddinstance', 'write', 10, 'block_admin_bookmarks', 0),
(468, 'block/admin_bookmarks:addinstance', 'write', 80, 'block_admin_bookmarks', 20),
(469, 'block/badges:addinstance', 'read', 80, 'block_badges', 0),
(470, 'block/badges:myaddinstance', 'read', 10, 'block_badges', 8),
(471, 'block/blog_menu:addinstance', 'write', 80, 'block_blog_menu', 20),
(472, 'block/blog_recent:addinstance', 'write', 80, 'block_blog_recent', 20),
(473, 'block/blog_tags:addinstance', 'write', 80, 'block_blog_tags', 20),
(474, 'block/calendar_month:myaddinstance', 'write', 10, 'block_calendar_month', 0),
(475, 'block/calendar_month:addinstance', 'write', 80, 'block_calendar_month', 20),
(476, 'block/calendar_upcoming:myaddinstance', 'write', 10, 'block_calendar_upcoming', 0),
(477, 'block/calendar_upcoming:addinstance', 'write', 80, 'block_calendar_upcoming', 20),
(478, 'block/comments:myaddinstance', 'write', 10, 'block_comments', 0),
(479, 'block/comments:addinstance', 'write', 80, 'block_comments', 20),
(480, 'block/completionstatus:addinstance', 'write', 80, 'block_completionstatus', 20),
(481, 'block/course_list:myaddinstance', 'write', 10, 'block_course_list', 0),
(482, 'block/course_list:addinstance', 'write', 80, 'block_course_list', 20),
(483, 'block/course_summary:addinstance', 'write', 80, 'block_course_summary', 20),
(484, 'block/feedback:addinstance', 'write', 80, 'block_feedback', 20),
(485, 'block/globalsearch:myaddinstance', 'write', 10, 'block_globalsearch', 0),
(486, 'block/globalsearch:addinstance', 'write', 80, 'block_globalsearch', 0),
(487, 'block/glossary_random:myaddinstance', 'write', 10, 'block_glossary_random', 0),
(488, 'block/glossary_random:addinstance', 'write', 80, 'block_glossary_random', 20),
(489, 'block/html:myaddinstance', 'write', 10, 'block_html', 0),
(490, 'block/html:addinstance', 'write', 80, 'block_html', 20),
(491, 'block/login:addinstance', 'write', 80, 'block_login', 20),
(492, 'block/lp:addinstance', 'write', 10, 'block_lp', 0),
(493, 'block/lp:myaddinstance', 'write', 10, 'block_lp', 0),
(494, 'block/mentees:myaddinstance', 'write', 10, 'block_mentees', 0),
(495, 'block/mentees:addinstance', 'write', 80, 'block_mentees', 20),
(496, 'block/mnet_hosts:myaddinstance', 'write', 10, 'block_mnet_hosts', 0),
(497, 'block/mnet_hosts:addinstance', 'write', 80, 'block_mnet_hosts', 20),
(498, 'block/myoverview:myaddinstance', 'write', 10, 'block_myoverview', 0),
(499, 'block/myprofile:myaddinstance', 'write', 10, 'block_myprofile', 0),
(500, 'block/myprofile:addinstance', 'write', 80, 'block_myprofile', 20),
(501, 'block/navigation:myaddinstance', 'write', 10, 'block_navigation', 0),
(502, 'block/navigation:addinstance', 'write', 80, 'block_navigation', 20),
(503, 'block/news_items:myaddinstance', 'write', 10, 'block_news_items', 0),
(504, 'block/news_items:addinstance', 'write', 80, 'block_news_items', 20),
(505, 'block/online_users:myaddinstance', 'write', 10, 'block_online_users', 0),
(506, 'block/online_users:addinstance', 'write', 80, 'block_online_users', 20),
(507, 'block/online_users:viewlist', 'read', 80, 'block_online_users', 0),
(508, 'block/private_files:myaddinstance', 'write', 10, 'block_private_files', 0),
(509, 'block/private_files:addinstance', 'write', 80, 'block_private_files', 20),
(510, 'block/quiz_results:addinstance', 'write', 80, 'block_quiz_results', 20),
(511, 'block/recent_activity:addinstance', 'write', 80, 'block_recent_activity', 20),
(512, 'block/recent_activity:viewaddupdatemodule', 'read', 50, 'block_recent_activity', 0),
(513, 'block/recent_activity:viewdeletemodule', 'read', 50, 'block_recent_activity', 0),
(514, 'block/recentlyaccessedcourses:myaddinstance', 'write', 10, 'block_recentlyaccessedcourses', 0),
(515, 'block/recentlyaccesseditems:myaddinstance', 'write', 10, 'block_recentlyaccesseditems', 0),
(516, 'block/rss_client:myaddinstance', 'write', 10, 'block_rss_client', 0),
(517, 'block/rss_client:addinstance', 'write', 80, 'block_rss_client', 20),
(518, 'block/rss_client:manageownfeeds', 'write', 80, 'block_rss_client', 0),
(519, 'block/rss_client:manageanyfeeds', 'write', 80, 'block_rss_client', 16),
(520, 'block/search_forums:addinstance', 'write', 80, 'block_search_forums', 20),
(521, 'block/section_links:addinstance', 'write', 80, 'block_section_links', 20),
(522, 'block/selfcompletion:addinstance', 'write', 80, 'block_selfcompletion', 20),
(523, 'block/settings:myaddinstance', 'write', 10, 'block_settings', 0),
(524, 'block/settings:addinstance', 'write', 80, 'block_settings', 20),
(525, 'block/site_main_menu:addinstance', 'write', 80, 'block_site_main_menu', 20),
(526, 'block/social_activities:addinstance', 'write', 80, 'block_social_activities', 20),
(527, 'block/starredcourses:myaddinstance', 'write', 10, 'block_starredcourses', 0),
(528, 'block/tag_flickr:addinstance', 'write', 80, 'block_tag_flickr', 20),
(529, 'block/tag_youtube:addinstance', 'write', 80, 'block_tag_youtube', 20),
(530, 'block/tags:myaddinstance', 'write', 10, 'block_tags', 0),
(531, 'block/tags:addinstance', 'write', 80, 'block_tags', 20),
(532, 'block/timeline:myaddinstance', 'write', 10, 'block_timeline', 0),
(533, 'report/completion:view', 'read', 50, 'report_completion', 8),
(534, 'report/courseoverview:view', 'read', 10, 'report_courseoverview', 8),
(535, 'report/log:view', 'read', 50, 'report_log', 8),
(536, 'report/log:viewtoday', 'read', 50, 'report_log', 8),
(537, 'report/loglive:view', 'read', 50, 'report_loglive', 8),
(538, 'report/outline:view', 'read', 50, 'report_outline', 8),
(539, 'report/outline:viewuserreport', 'read', 50, 'report_outline', 8),
(540, 'report/participation:view', 'read', 50, 'report_participation', 8),
(541, 'report/performance:view', 'read', 10, 'report_performance', 2),
(542, 'report/progress:view', 'read', 50, 'report_progress', 8),
(543, 'report/questioninstances:view', 'read', 10, 'report_questioninstances', 0),
(544, 'report/security:view', 'read', 10, 'report_security', 2),
(545, 'report/stats:view', 'read', 50, 'report_stats', 8),
(546, 'report/usersessions:manageownsessions', 'write', 30, 'report_usersessions', 0),
(547, 'gradeexport/ods:view', 'read', 50, 'gradeexport_ods', 8),
(548, 'gradeexport/ods:publish', 'read', 50, 'gradeexport_ods', 8),
(549, 'gradeexport/txt:view', 'read', 50, 'gradeexport_txt', 8),
(550, 'gradeexport/txt:publish', 'read', 50, 'gradeexport_txt', 8),
(551, 'gradeexport/xls:view', 'read', 50, 'gradeexport_xls', 8),
(552, 'gradeexport/xls:publish', 'read', 50, 'gradeexport_xls', 8),
(553, 'gradeexport/xml:view', 'read', 50, 'gradeexport_xml', 8),
(554, 'gradeexport/xml:publish', 'read', 50, 'gradeexport_xml', 8),
(555, 'gradeimport/csv:view', 'write', 50, 'gradeimport_csv', 0),
(556, 'gradeimport/direct:view', 'write', 50, 'gradeimport_direct', 0),
(557, 'gradeimport/xml:view', 'write', 50, 'gradeimport_xml', 0),
(558, 'gradeimport/xml:publish', 'write', 50, 'gradeimport_xml', 0),
(559, 'gradereport/grader:view', 'read', 50, 'gradereport_grader', 8),
(560, 'gradereport/history:view', 'read', 50, 'gradereport_history', 8),
(561, 'gradereport/outcomes:view', 'read', 50, 'gradereport_outcomes', 8),
(562, 'gradereport/overview:view', 'read', 50, 'gradereport_overview', 8),
(563, 'gradereport/singleview:view', 'read', 50, 'gradereport_singleview', 8),
(564, 'gradereport/user:view', 'read', 50, 'gradereport_user', 8),
(565, 'webservice/rest:use', 'read', 50, 'webservice_rest', 0),
(566, 'webservice/soap:use', 'read', 50, 'webservice_soap', 0),
(567, 'webservice/xmlrpc:use', 'read', 50, 'webservice_xmlrpc', 0),
(568, 'repository/areafiles:view', 'read', 70, 'repository_areafiles', 0),
(569, 'repository/boxnet:view', 'read', 70, 'repository_boxnet', 0),
(570, 'repository/coursefiles:view', 'read', 70, 'repository_coursefiles', 0),
(571, 'repository/dropbox:view', 'read', 70, 'repository_dropbox', 0),
(572, 'repository/equella:view', 'read', 70, 'repository_equella', 0),
(573, 'repository/filesystem:view', 'read', 70, 'repository_filesystem', 0),
(574, 'repository/flickr:view', 'read', 70, 'repository_flickr', 0),
(575, 'repository/flickr_public:view', 'read', 70, 'repository_flickr_public', 0),
(576, 'repository/googledocs:view', 'read', 70, 'repository_googledocs', 0),
(577, 'repository/local:view', 'read', 70, 'repository_local', 0),
(578, 'repository/merlot:view', 'read', 70, 'repository_merlot', 0),
(579, 'repository/nextcloud:view', 'read', 70, 'repository_nextcloud', 0),
(580, 'repository/onedrive:view', 'read', 70, 'repository_onedrive', 0),
(581, 'repository/picasa:view', 'read', 70, 'repository_picasa', 0),
(582, 'repository/recent:view', 'read', 70, 'repository_recent', 0),
(583, 'repository/s3:view', 'read', 70, 'repository_s3', 0),
(584, 'repository/skydrive:view', 'read', 70, 'repository_skydrive', 0),
(585, 'repository/upload:view', 'read', 70, 'repository_upload', 0),
(586, 'repository/url:view', 'read', 70, 'repository_url', 0),
(587, 'repository/user:view', 'read', 70, 'repository_user', 0),
(588, 'repository/webdav:view', 'read', 70, 'repository_webdav', 0),
(589, 'repository/wikimedia:view', 'read', 70, 'repository_wikimedia', 0),
(590, 'repository/youtube:view', 'read', 70, 'repository_youtube', 0),
(591, 'tool/customlang:view', 'read', 10, 'tool_customlang', 2),
(592, 'tool/customlang:edit', 'write', 10, 'tool_customlang', 6),
(593, 'tool/dataprivacy:managedatarequests', 'write', 10, 'tool_dataprivacy', 60),
(594, 'tool/dataprivacy:requestdeleteforotheruser', 'write', 10, 'tool_dataprivacy', 60),
(595, 'tool/dataprivacy:managedataregistry', 'write', 10, 'tool_dataprivacy', 60),
(596, 'tool/dataprivacy:makedatarequestsforchildren', 'write', 30, 'tool_dataprivacy', 24),
(597, 'tool/dataprivacy:makedatadeletionrequestsforchildren', 'write', 30, 'tool_dataprivacy', 24),
(598, 'tool/dataprivacy:downloadownrequest', 'read', 30, 'tool_dataprivacy', 0),
(599, 'tool/dataprivacy:downloadallrequests', 'read', 30, 'tool_dataprivacy', 8),
(600, 'tool/dataprivacy:requestdelete', 'write', 30, 'tool_dataprivacy', 32),
(601, 'tool/lpmigrate:frameworksmigrate', 'write', 10, 'tool_lpmigrate', 0),
(602, 'tool/monitor:subscribe', 'read', 50, 'tool_monitor', 8),
(603, 'tool/monitor:managerules', 'write', 50, 'tool_monitor', 4),
(604, 'tool/monitor:managetool', 'write', 10, 'tool_monitor', 4),
(605, 'tool/policy:accept', 'write', 10, 'tool_policy', 0),
(606, 'tool/policy:acceptbehalf', 'write', 30, 'tool_policy', 8),
(607, 'tool/policy:managedocs', 'write', 10, 'tool_policy', 0),
(608, 'tool/policy:viewacceptances', 'read', 10, 'tool_policy', 0),
(609, 'tool/recyclebin:deleteitems', 'write', 50, 'tool_recyclebin', 32),
(610, 'tool/recyclebin:restoreitems', 'write', 50, 'tool_recyclebin', 0),
(611, 'tool/recyclebin:viewitems', 'read', 50, 'tool_recyclebin', 0),
(612, 'tool/uploaduser:uploaduserpictures', 'write', 10, 'tool_uploaduser', 16),
(613, 'tool/usertours:managetours', 'write', 10, 'tool_usertours', 4),
(614, 'booktool/exportimscp:export', 'read', 70, 'booktool_exportimscp', 0),
(615, 'booktool/importhtml:import', 'write', 70, 'booktool_importhtml', 4),
(616, 'booktool/print:print', 'read', 70, 'booktool_print', 0),
(617, 'forumreport/summary:view', 'read', 70, 'forumreport_summary', 0),
(618, 'forumreport/summary:viewall', 'read', 70, 'forumreport_summary', 8),
(619, 'quiz/grading:viewstudentnames', 'read', 70, 'quiz_grading', 0),
(620, 'quiz/grading:viewidnumber', 'read', 70, 'quiz_grading', 0),
(621, 'quiz/statistics:view', 'read', 70, 'quiz_statistics', 0),
(622, 'atto/h5p:addembed', 'write', 70, 'atto_h5p', 0),
(623, 'atto/recordrtc:recordaudio', 'write', 70, 'atto_recordrtc', 0),
(624, 'atto/recordrtc:recordvideo', 'write', 70, 'atto_recordrtc', 0),
(625, 'block/configurable_reports:addinstance', 'write', 80, 'block_configurable_reports', 20),
(626, 'block/configurable_reports:myaddinstance', 'write', 80, 'block_configurable_reports', 20),
(627, 'block/configurable_reports:managereports', 'write', 80, 'block_configurable_reports', 0),
(628, 'block/configurable_reports:managesqlreports', 'write', 80, 'block_configurable_reports', 0),
(629, 'block/configurable_reports:manageownreports', 'write', 80, 'block_configurable_reports', 0),
(630, 'block/configurable_reports:viewreports', 'read', 80, 'block_configurable_reports', 0),
(631, 'enrol/auto:config', 'write', 50, 'enrol_auto', 0),
(632, 'enrol/auto:manage', 'write', 50, 'enrol_auto', 0),
(633, 'enrol/auto:unenrolself', 'write', 50, 'enrol_auto', 0),
(634, 'enrol/auto:unenrol', 'write', 50, 'enrol_auto', 0),
(635, 'enrol/apply:config', 'write', 50, 'enrol_apply', 0),
(636, 'enrol/apply:manageapplications', 'write', 50, 'enrol_apply', 0),
(637, 'enrol/apply:manage', 'write', 50, 'enrol_apply', 0),
(638, 'enrol/apply:unenrol', 'write', 50, 'enrol_apply', 0),
(639, 'enrol/apply:unenrolself', 'write', 50, 'enrol_apply', 0),
(640, 'mod/attendance:view', 'read', 70, 'mod_attendance', 0),
(641, 'mod/attendance:addinstance', 'write', 50, 'mod_attendance', 4),
(642, 'mod/attendance:viewreports', 'read', 70, 'mod_attendance', 8),
(643, 'mod/attendance:takeattendances', 'write', 70, 'mod_attendance', 32),
(644, 'mod/attendance:changeattendances', 'write', 70, 'mod_attendance', 32),
(645, 'mod/attendance:manageattendances', 'write', 70, 'mod_attendance', 2),
(646, 'mod/attendance:changepreferences', 'write', 70, 'mod_attendance', 2),
(647, 'mod/attendance:export', 'read', 70, 'mod_attendance', 8),
(648, 'mod/attendance:canbelisted', 'read', 70, 'mod_attendance', 8),
(649, 'mod/attendance:managetemporaryusers', 'write', 70, 'mod_attendance', 32),
(650, 'mod/attendance:viewsummaryreports', 'read', 40, 'mod_attendance', 8),
(651, 'mod/attendance:warningemails', 'write', 70, 'mod_attendance', 32),
(652, 'mod/facetoface:view', 'read', 70, 'mod_facetoface', 0),
(653, 'mod/facetoface:signup', 'write', 50, 'mod_facetoface', 0),
(654, 'mod/facetoface:viewemptyactivities', 'read', 70, 'mod_facetoface', 0),
(655, 'mod/facetoface:viewattendees', 'read', 50, 'mod_facetoface', 0),
(656, 'mod/facetoface:takeattendance', 'write', 50, 'mod_facetoface', 0),
(657, 'mod/facetoface:addattendees', 'write', 50, 'mod_facetoface', 0),
(658, 'mod/facetoface:removeattendees', 'write', 50, 'mod_facetoface', 0),
(659, 'mod/facetoface:editsessions', 'write', 50, 'mod_facetoface', 0),
(660, 'mod/facetoface:viewcancellations', 'write', 50, 'mod_facetoface', 0),
(661, 'mod/facetoface:configurecancellation', 'write', 50, 'mod_facetoface', 0),
(662, 'mod/facetoface:overbook', 'write', 50, 'mod_facetoface', 0),
(663, 'mod/facetoface:addinstance', 'write', 50, 'mod_facetoface', 0),
(664, 'mod/hvp:view', 'read', 70, 'mod_hvp', 0),
(665, 'mod/hvp:addinstance', 'write', 50, 'mod_hvp', 20),
(666, 'mod/hvp:manage', 'write', 70, 'mod_hvp', 20),
(667, 'mod/hvp:getexport', 'read', 70, 'mod_hvp', 0),
(668, 'mod/hvp:getembedcode', 'read', 70, 'mod_hvp', 0),
(669, 'mod/hvp:saveresults', 'write', 70, 'mod_hvp', 16),
(670, 'mod/hvp:savecontentuserdata', 'write', 70, 'mod_hvp', 0),
(671, 'mod/hvp:viewresults', 'write', 70, 'mod_hvp', 0),
(672, 'mod/hvp:viewallresults', 'read', 70, 'mod_hvp', 0),
(673, 'mod/hvp:restrictlibraries', 'write', 10, 'mod_hvp', 0),
(674, 'mod/hvp:userestrictedlibraries', 'write', 50, 'mod_hvp', 0),
(675, 'mod/hvp:updatelibraries', 'write', 10, 'mod_hvp', 0),
(676, 'mod/hvp:getcachedassets', 'read', 10, 'mod_hvp', 0),
(677, 'mod/hvp:installrecommendedh5plibraries', 'write', 50, 'mod_hvp', 0),
(678, 'mod/jitsi:addinstance', 'write', 50, 'mod_jitsi', 4),
(679, 'mod/jitsi:view', 'read', 70, 'mod_jitsi', 0),
(680, 'mod/jitsi:submit', 'write', 70, 'mod_jitsi', 16),
(681, 'mod/treasurehunt:addinstance', 'write', 50, 'mod_treasurehunt', 4),
(682, 'mod/treasurehunt:view', 'read', 70, 'mod_treasurehunt', 0),
(683, 'mod/treasurehunt:play', 'write', 70, 'mod_treasurehunt', 16),
(684, 'mod/treasurehunt:managetreasurehunt', 'write', 70, 'mod_treasurehunt', 16),
(685, 'mod/treasurehunt:editroad', 'write', 70, 'mod_treasurehunt', 0),
(686, 'mod/treasurehunt:editstage', 'write', 70, 'mod_treasurehunt', 16),
(687, 'mod/treasurehunt:addstage', 'write', 70, 'mod_treasurehunt', 16),
(688, 'mod/treasurehunt:addroad', 'write', 70, 'mod_treasurehunt', 16),
(689, 'mod/treasurehunt:viewusershistoricalattempts', 'read', 70, 'mod_treasurehunt', 8),
(690, 'mod/hvp:emailconfirmsubmission', 'read', 70, 'mod_hvp', 0),
(691, 'mod/hvp:emailnotifysubmission', 'read', 70, 'mod_hvp', 0),
(692, 'mod/checklist:addinstance', 'write', 50, 'mod_checklist', 0),
(693, 'mod/checklist:updateown', 'write', 70, 'mod_checklist', 16),
(694, 'mod/checklist:updateother', 'write', 70, 'mod_checklist', 24),
(695, 'mod/checklist:preview', 'read', 70, 'mod_checklist', 0),
(696, 'mod/checklist:viewreports', 'read', 70, 'mod_checklist', 8),
(697, 'mod/checklist:viewmenteereports', 'read', 70, 'mod_checklist', 8),
(698, 'mod/checklist:edit', 'write', 70, 'mod_checklist', 16),
(699, 'mod/checklist:emailoncomplete', 'read', 70, 'mod_checklist', 8),
(700, 'mod/checklist:updatelocked', 'write', 70, 'mod_checklist', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_chat`
--

CREATE TABLE `mdl_chat` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `keepdays` bigint(11) NOT NULL DEFAULT '0',
  `studentlogs` smallint(4) NOT NULL DEFAULT '0',
  `chattime` bigint(10) NOT NULL DEFAULT '0',
  `schedule` smallint(4) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Each of these is a chat room' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_chat_messages`
--

CREATE TABLE `mdl_chat_messages` (
  `id` bigint(10) NOT NULL,
  `chatid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `groupid` bigint(10) NOT NULL DEFAULT '0',
  `issystem` tinyint(1) NOT NULL DEFAULT '0',
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores all the actual chat messages' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_chat_messages_current`
--

CREATE TABLE `mdl_chat_messages_current` (
  `id` bigint(10) NOT NULL,
  `chatid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `groupid` bigint(10) NOT NULL DEFAULT '0',
  `issystem` tinyint(1) NOT NULL DEFAULT '0',
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores current session' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_chat_users`
--

CREATE TABLE `mdl_chat_users` (
  `id` bigint(10) NOT NULL,
  `chatid` bigint(11) NOT NULL DEFAULT '0',
  `userid` bigint(11) NOT NULL DEFAULT '0',
  `groupid` bigint(11) NOT NULL DEFAULT '0',
  `version` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `firstping` bigint(10) NOT NULL DEFAULT '0',
  `lastping` bigint(10) NOT NULL DEFAULT '0',
  `lastmessageping` bigint(10) NOT NULL DEFAULT '0',
  `sid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `course` bigint(10) NOT NULL DEFAULT '0',
  `lang` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Keeps track of which users are in which chat rooms' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_checklist`
--

CREATE TABLE `mdl_checklist` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `useritemsallowed` smallint(4) DEFAULT '1',
  `teacheredit` smallint(4) DEFAULT '0',
  `theme` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `duedatesoncalendar` smallint(4) DEFAULT '0',
  `teachercomments` smallint(4) DEFAULT '1',
  `maxgrade` bigint(10) NOT NULL DEFAULT '100',
  `autopopulate` smallint(4) DEFAULT '0',
  `autoupdate` smallint(4) DEFAULT '1',
  `completionpercent` bigint(10) DEFAULT '0',
  `emailoncomplete` smallint(4) DEFAULT '0',
  `lockteachermarks` smallint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='main checklist table' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_checklist_check`
--

CREATE TABLE `mdl_checklist_check` (
  `id` bigint(10) NOT NULL,
  `item` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `usertimestamp` bigint(10) NOT NULL DEFAULT '0',
  `teachermark` smallint(4) NOT NULL DEFAULT '0',
  `teachertimestamp` bigint(10) NOT NULL DEFAULT '0',
  `teacherid` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Records when items where checked off' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_checklist_comment`
--

CREATE TABLE `mdl_checklist_comment` (
  `id` bigint(10) NOT NULL,
  `itemid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `commentby` bigint(10) DEFAULT '0',
  `text` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='A comment, added by a teacher, to an item on a user''s checkl' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_checklist_item`
--

CREATE TABLE `mdl_checklist_item` (
  `id` bigint(10) NOT NULL,
  `checklist` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `displaytext` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` bigint(10) NOT NULL DEFAULT '0',
  `indent` int(8) NOT NULL DEFAULT '0',
  `itemoptional` smallint(4) NOT NULL DEFAULT '0',
  `duetime` bigint(10) DEFAULT '0',
  `eventid` bigint(10) DEFAULT '0',
  `colour` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'black',
  `moduleid` bigint(10) DEFAULT '0',
  `hidden` smallint(4) NOT NULL DEFAULT '0',
  `groupingid` bigint(10) DEFAULT '0',
  `linkcourseid` bigint(10) DEFAULT NULL,
  `linkurl` longtext COLLATE utf8mb4_unicode_ci,
  `openlinkinnewwindow` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Records the items in the checklist' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_choice`
--

CREATE TABLE `mdl_choice` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `publish` tinyint(2) NOT NULL DEFAULT '0',
  `showresults` tinyint(2) NOT NULL DEFAULT '0',
  `display` smallint(4) NOT NULL DEFAULT '0',
  `allowupdate` tinyint(2) NOT NULL DEFAULT '0',
  `allowmultiple` tinyint(2) NOT NULL DEFAULT '0',
  `showunanswered` tinyint(2) NOT NULL DEFAULT '0',
  `includeinactive` tinyint(2) NOT NULL DEFAULT '1',
  `limitanswers` tinyint(2) NOT NULL DEFAULT '0',
  `timeopen` bigint(10) NOT NULL DEFAULT '0',
  `timeclose` bigint(10) NOT NULL DEFAULT '0',
  `showpreview` tinyint(2) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `completionsubmit` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Available choices are stored here' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_choice_answers`
--

CREATE TABLE `mdl_choice_answers` (
  `id` bigint(10) NOT NULL,
  `choiceid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `optionid` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='choices performed by users' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_choice_options`
--

CREATE TABLE `mdl_choice_options` (
  `id` bigint(10) NOT NULL,
  `choiceid` bigint(10) NOT NULL DEFAULT '0',
  `text` longtext COLLATE utf8mb4_unicode_ci,
  `maxanswers` bigint(10) DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='available options to choice' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_cohort`
--

CREATE TABLE `mdl_cohort` (
  `id` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `name` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `idnumber` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `component` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `theme` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Each record represents one cohort (aka site-wide group).' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_cohort_members`
--

CREATE TABLE `mdl_cohort_members` (
  `id` bigint(10) NOT NULL,
  `cohortid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `timeadded` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Link a user to a cohort.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_comments`
--

CREATE TABLE `mdl_comments` (
  `id` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `component` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentarea` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `itemid` bigint(10) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` tinyint(2) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='moodle comments module' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency`
--

CREATE TABLE `mdl_competency` (
  `id` bigint(10) NOT NULL,
  `shortname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` smallint(4) NOT NULL DEFAULT '0',
  `idnumber` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `competencyframeworkid` bigint(10) NOT NULL,
  `parentid` bigint(10) NOT NULL DEFAULT '0',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortorder` bigint(10) NOT NULL,
  `ruletype` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruleoutcome` tinyint(2) NOT NULL DEFAULT '0',
  `ruleconfig` longtext COLLATE utf8mb4_unicode_ci,
  `scaleid` bigint(10) DEFAULT NULL,
  `scaleconfiguration` longtext COLLATE utf8mb4_unicode_ci,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table contains the master record of each competency in ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_coursecomp`
--

CREATE TABLE `mdl_competency_coursecomp` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `competencyid` bigint(10) NOT NULL,
  `ruleoutcome` tinyint(2) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL,
  `sortorder` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Link a competency to a course.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_coursecompsetting`
--

CREATE TABLE `mdl_competency_coursecompsetting` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `pushratingstouserplans` tinyint(2) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table contains the course specific settings for compete' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_evidence`
--

CREATE TABLE `mdl_competency_evidence` (
  `id` bigint(10) NOT NULL,
  `usercompetencyid` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `action` tinyint(2) NOT NULL,
  `actionuserid` bigint(10) DEFAULT NULL,
  `descidentifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `desccomponent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `desca` longtext COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` bigint(10) DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='The evidence linked to a user competency' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_framework`
--

CREATE TABLE `mdl_competency_framework` (
  `id` bigint(10) NOT NULL,
  `shortname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contextid` bigint(10) NOT NULL,
  `idnumber` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` smallint(4) NOT NULL DEFAULT '0',
  `scaleid` bigint(11) DEFAULT NULL,
  `scaleconfiguration` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `visible` tinyint(2) NOT NULL DEFAULT '1',
  `taxonomies` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of competency frameworks.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_modulecomp`
--

CREATE TABLE `mdl_competency_modulecomp` (
  `id` bigint(10) NOT NULL,
  `cmid` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL,
  `sortorder` bigint(10) NOT NULL,
  `competencyid` bigint(10) NOT NULL,
  `ruleoutcome` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Link a competency to a module.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_plan`
--

CREATE TABLE `mdl_competency_plan` (
  `id` bigint(10) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` smallint(4) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL,
  `templateid` bigint(10) DEFAULT NULL,
  `origtemplateid` bigint(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `duedate` bigint(10) DEFAULT '0',
  `reviewerid` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Learning plans' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_plancomp`
--

CREATE TABLE `mdl_competency_plancomp` (
  `id` bigint(10) NOT NULL,
  `planid` bigint(10) NOT NULL,
  `competencyid` bigint(10) NOT NULL,
  `sortorder` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Plan competencies' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_relatedcomp`
--

CREATE TABLE `mdl_competency_relatedcomp` (
  `id` bigint(10) NOT NULL,
  `competencyid` bigint(10) NOT NULL,
  `relatedcompetencyid` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Related competencies' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_template`
--

CREATE TABLE `mdl_competency_template` (
  `id` bigint(10) NOT NULL,
  `shortname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contextid` bigint(10) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` smallint(4) NOT NULL DEFAULT '0',
  `visible` tinyint(2) NOT NULL DEFAULT '1',
  `duedate` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Learning plan templates.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_templatecohort`
--

CREATE TABLE `mdl_competency_templatecohort` (
  `id` bigint(10) NOT NULL,
  `templateid` bigint(10) NOT NULL,
  `cohortid` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Default comment for the table, please edit me' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_templatecomp`
--

CREATE TABLE `mdl_competency_templatecomp` (
  `id` bigint(10) NOT NULL,
  `templateid` bigint(10) NOT NULL,
  `competencyid` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL,
  `sortorder` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Link a competency to a learning plan template.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_usercomp`
--

CREATE TABLE `mdl_competency_usercomp` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `competencyid` bigint(10) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `reviewerid` bigint(10) DEFAULT NULL,
  `proficiency` tinyint(2) DEFAULT NULL,
  `grade` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User competencies' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_usercompcourse`
--

CREATE TABLE `mdl_competency_usercompcourse` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `competencyid` bigint(10) NOT NULL,
  `proficiency` tinyint(2) DEFAULT NULL,
  `grade` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User competencies in a course' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_usercompplan`
--

CREATE TABLE `mdl_competency_usercompplan` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `competencyid` bigint(10) NOT NULL,
  `planid` bigint(10) NOT NULL,
  `proficiency` tinyint(2) DEFAULT NULL,
  `grade` bigint(10) DEFAULT NULL,
  `sortorder` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User competencies plans' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_userevidence`
--

CREATE TABLE `mdl_competency_userevidence` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionformat` tinyint(1) NOT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='The evidence of prior learning' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_competency_userevidencecomp`
--

CREATE TABLE `mdl_competency_userevidencecomp` (
  `id` bigint(10) NOT NULL,
  `userevidenceid` bigint(10) NOT NULL,
  `competencyid` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Relationship between user evidence and competencies' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_config`
--

CREATE TABLE `mdl_config` (
  `id` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Moodle configuration variables' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_config`
--

INSERT INTO `mdl_config` (`id`, `name`, `value`) VALUES
(2, 'rolesactive', '1'),
(3, 'auth', 'email'),
(4, 'enrol_plugins_enabled', 'manual,guest,self,cohort'),
(5, 'theme', 'boost'),
(6, 'filter_multilang_converted', '1'),
(7, 'siteidentifier', 'xVqyyVpuw8VRbJfd7yTScdAWBoMfxXCQlearnuat.zinghr.com'),
(8, 'backup_version', '2008111700'),
(9, 'backup_release', '2.0 dev'),
(10, 'mnet_dispatcher_mode', 'off'),
(11, 'sessiontimeout', '7200'),
(12, 'stringfilters', ''),
(13, 'filterall', '0'),
(14, 'texteditors', 'atto,tinymce,textarea'),
(15, 'antiviruses', ''),
(16, 'media_plugins_sortorder', 'videojs,youtube,swf'),
(17, 'upgrade_extracreditweightsstepignored', '1'),
(18, 'upgrade_calculatedgradeitemsignored', '1'),
(19, 'upgrade_letterboundarycourses', '1'),
(20, 'mnet_localhost_id', '1'),
(21, 'mnet_all_hosts_id', '2'),
(22, 'siteguest', '1'),
(23, 'siteadmins', '2'),
(24, 'themerev', '1585568500'),
(25, 'jsrev', '1585568500'),
(26, 'templaterev', '1585568500'),
(27, 'gdversion', '2'),
(28, 'licenses', 'unknown,allrightsreserved,public,cc,cc-nd,cc-nc-nd,cc-nc,cc-nc-sa,cc-sa'),
(29, 'badges_site_backpack', '1'),
(30, 'version', '2019111801.09'),
(31, 'enableoutcomes', '0'),
(32, 'usecomments', '1'),
(33, 'usetags', '1'),
(34, 'enablenotes', '1'),
(35, 'enableportfolios', '0'),
(36, 'enablewebservices', '1'),
(37, 'enablestats', '0'),
(38, 'enablerssfeeds', '0'),
(39, 'enableblogs', '1'),
(40, 'enablecompletion', '1'),
(41, 'completiondefault', '1'),
(42, 'enableavailability', '1'),
(43, 'enableplagiarism', '0'),
(44, 'enablebadges', '1'),
(45, 'enableglobalsearch', '0'),
(46, 'allowstealth', '0'),
(47, 'enableanalytics', '1'),
(48, 'allowemojipicker', '1'),
(49, 'userfiltersdefault', 'realname'),
(50, 'defaultpreference_maildisplay', '2'),
(51, 'defaultpreference_mailformat', '1'),
(52, 'defaultpreference_maildigest', '0'),
(53, 'defaultpreference_autosubscribe', '1'),
(54, 'defaultpreference_trackforums', '0'),
(55, 'autologinguests', '0'),
(56, 'hiddenuserfields', ''),
(57, 'showuseridentity', 'email'),
(58, 'fullnamedisplay', 'language'),
(59, 'alternativefullnameformat', 'language'),
(60, 'maxusersperpage', '100'),
(61, 'enablegravatar', '0'),
(62, 'gravatardefaulturl', 'mm'),
(63, 'agedigitalconsentverification', '0'),
(64, 'agedigitalconsentmap', '*, 16\nAT, 14\nES, 14\nUS, 13'),
(65, 'sitepolicy', ''),
(66, 'sitepolicyguest', ''),
(67, 'enablecourserequests', '1'),
(68, 'defaultrequestcategory', '1'),
(69, 'lockrequestcategory', '0'),
(70, 'courserequestnotify', ''),
(71, 'enableasyncbackup', '0'),
(72, 'grade_profilereport', 'user'),
(73, 'grade_aggregationposition', '1'),
(74, 'grade_includescalesinaggregation', '1'),
(75, 'grade_hiddenasdate', '0'),
(76, 'gradepublishing', '0'),
(77, 'grade_export_exportfeedback', '0'),
(78, 'grade_export_displaytype', '1'),
(79, 'grade_export_decimalpoints', '2'),
(80, 'grade_navmethod', '1'),
(81, 'grade_export_userprofilefields', 'firstname,lastname,idnumber,institution,department,email'),
(82, 'grade_export_customprofilefields', ''),
(83, 'recovergradesdefault', '0'),
(84, 'gradeexport', ''),
(85, 'unlimitedgrades', '0'),
(86, 'grade_report_showmin', '1'),
(87, 'gradepointmax', '100'),
(88, 'gradepointdefault', '100'),
(89, 'grade_minmaxtouse', '1'),
(90, 'grade_mygrades_report', 'overview'),
(91, 'gradereport_mygradeurl', ''),
(92, 'grade_hideforcedsettings', '1'),
(93, 'grade_aggregation', '13'),
(94, 'grade_aggregation_flag', '0'),
(95, 'grade_aggregations_visible', '13'),
(96, 'grade_aggregateonlygraded', '1'),
(97, 'grade_aggregateonlygraded_flag', '2'),
(98, 'grade_aggregateoutcomes', '0'),
(99, 'grade_aggregateoutcomes_flag', '2'),
(100, 'grade_keephigh', '0'),
(101, 'grade_keephigh_flag', '3'),
(102, 'grade_droplow', '0'),
(103, 'grade_droplow_flag', '2'),
(104, 'grade_overridecat', '1'),
(105, 'grade_displaytype', '1'),
(106, 'grade_decimalpoints', '2'),
(107, 'grade_item_advanced', 'iteminfo,idnumber,gradepass,plusfactor,multfactor,display,decimals,hiddenuntil,locktime'),
(108, 'grade_report_studentsperpage', '100'),
(109, 'grade_report_showonlyactiveenrol', '1'),
(110, 'grade_report_quickgrading', '1'),
(111, 'grade_report_showquickfeedback', '0'),
(112, 'grade_report_meanselection', '1'),
(113, 'grade_report_enableajax', '0'),
(114, 'grade_report_showcalculations', '1'),
(115, 'grade_report_showeyecons', '0'),
(116, 'grade_report_showaverages', '1'),
(117, 'grade_report_showlocks', '0'),
(118, 'grade_report_showranges', '0'),
(119, 'grade_report_showanalysisicon', '1'),
(120, 'grade_report_showuserimage', '1'),
(121, 'grade_report_showactivityicons', '1'),
(122, 'grade_report_shownumberofgrades', '0'),
(123, 'grade_report_averagesdisplaytype', 'inherit'),
(124, 'grade_report_rangesdisplaytype', 'inherit'),
(125, 'grade_report_averagesdecimalpoints', 'inherit'),
(126, 'grade_report_rangesdecimalpoints', 'inherit'),
(127, 'grade_report_historyperpage', '50'),
(128, 'grade_report_overview_showrank', '0'),
(129, 'grade_report_overview_showtotalsifcontainhidden', '0'),
(130, 'grade_report_user_showrank', '0'),
(131, 'grade_report_user_showpercentage', '1'),
(132, 'grade_report_user_showgrade', '1'),
(133, 'grade_report_user_showfeedback', '1'),
(134, 'grade_report_user_showrange', '1'),
(135, 'grade_report_user_showweight', '1'),
(136, 'grade_report_user_showaverage', '0'),
(137, 'grade_report_user_showlettergrade', '0'),
(138, 'grade_report_user_rangedecimals', '0'),
(139, 'grade_report_user_showhiddenitems', '1'),
(140, 'grade_report_user_showtotalsifcontainhidden', '0'),
(141, 'grade_report_user_showcontributiontocoursetotal', '1'),
(142, 'badges_defaultissuername', ''),
(143, 'badges_defaultissuercontact', ''),
(144, 'badges_badgesalt', 'badges1583151879'),
(145, 'badges_allowcoursebadges', '1'),
(146, 'badges_allowexternalbackpack', '1'),
(147, 'forcetimezone', '99'),
(148, 'country', '0'),
(149, 'defaultcity', ''),
(150, 'geoip2file', '/var/www/moodledata_LMS_2_0/geoip/GeoLite2-City.mmdb'),
(151, 'googlemapkey3', ''),
(152, 'allcountrycodes', ''),
(153, 'autolang', '1'),
(154, 'lang', 'en'),
(155, 'langmenu', '1'),
(156, 'langlist', ''),
(157, 'langrev', '1585568500'),
(158, 'langcache', '1'),
(159, 'langstringcache', '1'),
(160, 'locale', ''),
(161, 'latinexcelexport', '0'),
(162, 'messaging', '1'),
(163, 'messagingallusers', '0'),
(164, 'messagingdefaultpressenter', '1'),
(165, 'messagingdeletereadnotificationsdelay', '604800'),
(166, 'messagingdeleteallnotificationsdelay', '2620800'),
(167, 'messagingallowemailoverride', '0'),
(168, 'requiremodintro', '0'),
(169, 'registerauth', ''),
(170, 'authloginviaemail', '0'),
(171, 'allowaccountssameemail', '0'),
(172, 'authpreventaccountcreation', '0'),
(173, 'loginpageautofocus', '0'),
(174, 'guestloginbutton', '1'),
(175, 'limitconcurrentlogins', '0'),
(176, 'alternateloginurl', ''),
(177, 'forgottenpasswordurl', ''),
(178, 'auth_instructions', ''),
(179, 'allowemailaddresses', ''),
(180, 'denyemailaddresses', ''),
(181, 'verifychangedemail', '1'),
(182, 'recaptchapublickey', ''),
(183, 'recaptchaprivatekey', ''),
(184, 'filteruploadedfiles', '0'),
(185, 'filtermatchoneperpage', '0'),
(186, 'filtermatchonepertext', '0'),
(187, 'sitedefaultlicense', 'allrightsreserved'),
(188, 'media_default_width', '400'),
(189, 'media_default_height', '300'),
(190, 'portfolio_moderate_filesize_threshold', '1048576'),
(191, 'portfolio_high_filesize_threshold', '5242880'),
(192, 'portfolio_moderate_db_threshold', '20'),
(193, 'portfolio_high_db_threshold', '50'),
(194, 'repositorycacheexpire', '120'),
(195, 'repositorygetfiletimeout', '30'),
(196, 'repositorysyncfiletimeout', '1'),
(197, 'repositorysyncimagetimeout', '3'),
(198, 'repositoryallowexternallinks', '1'),
(199, 'legacyfilesinnewcourses', '0'),
(200, 'legacyfilesaddallowed', '1'),
(201, 'searchengine', 'simpledb'),
(202, 'searchindexwhendisabled', '0'),
(203, 'searchindextime', '600'),
(204, 'searchallavailablecourses', '0'),
(205, 'searchincludeallcourses', '0'),
(206, 'searchenablecategories', '0'),
(207, 'searchdefaultcategory', 'core-all'),
(208, 'searchhideallcategory', '0'),
(209, 'enablewsdocumentation', '0'),
(210, 'allowbeforeblock', '0'),
(211, 'allowedip', ''),
(212, 'blockedip', ''),
(213, 'protectusernames', '1'),
(214, 'forcelogin', '0'),
(215, 'forceloginforprofiles', '1'),
(216, 'forceloginforprofileimage', '0'),
(217, 'opentowebcrawlers', '0'),
(218, 'allowindexing', '0'),
(219, 'maxbytes', '0'),
(220, 'userquota', '104857600'),
(221, 'allowobjectembed', '0'),
(222, 'enabletrusttext', '0'),
(223, 'maxeditingtime', '1800'),
(224, 'extendedusernamechars', '0'),
(225, 'keeptagnamecase', '1'),
(226, 'profilesforenrolledusersonly', '1'),
(227, 'cronclionly', '1'),
(228, 'cronremotepassword', ''),
(229, 'lockoutthreshold', '0'),
(230, 'lockoutwindow', '1800'),
(231, 'lockoutduration', '1800'),
(232, 'passwordpolicy', '1'),
(233, 'minpasswordlength', '8'),
(234, 'minpassworddigits', '1'),
(235, 'minpasswordlower', '1'),
(236, 'minpasswordupper', '1'),
(237, 'minpasswordnonalphanum', '1'),
(238, 'maxconsecutiveidentchars', '0'),
(239, 'passwordreuselimit', '0'),
(240, 'pwresettime', '1800'),
(241, 'passwordchangelogout', '0'),
(242, 'passwordchangetokendeletion', '0'),
(243, 'tokenduration', '7257600'),
(244, 'groupenrolmentkeypolicy', '1'),
(245, 'disableuserimages', '0'),
(246, 'emailchangeconfirmation', '1'),
(247, 'rememberusername', '2'),
(248, 'strictformsrequired', '0'),
(249, 'cookiesecure', '1'),
(250, 'cookiehttponly', '0'),
(251, 'allowframembedding', '0'),
(252, 'curlsecurityblockedhosts', ''),
(253, 'curlsecurityallowedport', ''),
(254, 'displayloginfailures', '0'),
(255, 'notifyloginfailures', ''),
(256, 'notifyloginthreshold', '10'),
(257, 'themelist', ''),
(258, 'themedesignermode', '0'),
(259, 'allowuserthemes', '0'),
(260, 'allowcoursethemes', '0'),
(261, 'allowcategorythemes', '0'),
(262, 'allowcohortthemes', '0'),
(263, 'allowthemechangeonurl', '0'),
(264, 'allowuserblockhiding', '1'),
(265, 'custommenuitems', ''),
(266, 'customusermenuitems', 'grades,grades|/grade/report/mygrades.php|t/grades\nmessages,message|/message/index.php|t/message\npreferences,moodle|/user/preferences.php|t/preferences'),
(267, 'enabledevicedetection', '1'),
(268, 'devicedetectregex', '[]'),
(269, 'calendartype', 'gregorian'),
(270, 'calendar_adminseesall', '0'),
(271, 'calendar_site_timeformat', '0'),
(272, 'calendar_startwday', '1'),
(273, 'calendar_weekend', '65'),
(274, 'calendar_lookahead', '21'),
(275, 'calendar_maxevents', '10'),
(276, 'enablecalendarexport', '1'),
(277, 'calendar_customexport', '1'),
(278, 'calendar_exportlookahead', '365'),
(279, 'calendar_exportlookback', '5'),
(280, 'calendar_exportsalt', 'AbLUBgX1cagiApy46oDxpYxiWBexdpEz3KL11UZuQjDKqB8UT7C9CNgm2DHb'),
(281, 'calendar_showicalsource', '1'),
(282, 'useblogassociations', '1'),
(283, 'bloglevel', '4'),
(284, 'useexternalblogs', '1'),
(285, 'externalblogcrontime', '86400'),
(286, 'maxexternalblogsperuser', '1'),
(287, 'blogusecomments', '1'),
(288, 'blogshowcommentscount', '1'),
(289, 'defaulthomepage', '1'),
(290, 'allowguestmymoodle', '1'),
(291, 'navshowfullcoursenames', '0'),
(292, 'navshowcategories', '1'),
(293, 'navshowmycoursecategories', '0'),
(294, 'navshowallcourses', '0'),
(295, 'navsortmycoursessort', 'sortorder'),
(296, 'navsortmycourseshiddenlast', '1'),
(297, 'navcourselimit', '10'),
(298, 'usesitenameforsitepages', '0'),
(299, 'linkadmincategories', '1'),
(300, 'linkcoursesections', '1'),
(301, 'navshowfrontpagemods', '1'),
(302, 'navadduserpostslinks', '1'),
(303, 'formatstringstriptags', '1'),
(304, 'emoticons', '[{\"text\":\":-)\",\"imagename\":\"s\\/smiley\",\"imagecomponent\":\"core\",\"altidentifier\":\"smiley\",\"altcomponent\":\"core_pix\"},{\"text\":\":)\",\"imagename\":\"s\\/smiley\",\"imagecomponent\":\"core\",\"altidentifier\":\"smiley\",\"altcomponent\":\"core_pix\"},{\"text\":\":-D\",\"imagename\":\"s\\/biggrin\",\"imagecomponent\":\"core\",\"altidentifier\":\"biggrin\",\"altcomponent\":\"core_pix\"},{\"text\":\";-)\",\"imagename\":\"s\\/wink\",\"imagecomponent\":\"core\",\"altidentifier\":\"wink\",\"altcomponent\":\"core_pix\"},{\"text\":\":-\\/\",\"imagename\":\"s\\/mixed\",\"imagecomponent\":\"core\",\"altidentifier\":\"mixed\",\"altcomponent\":\"core_pix\"},{\"text\":\"V-.\",\"imagename\":\"s\\/thoughtful\",\"imagecomponent\":\"core\",\"altidentifier\":\"thoughtful\",\"altcomponent\":\"core_pix\"},{\"text\":\":-P\",\"imagename\":\"s\\/tongueout\",\"imagecomponent\":\"core\",\"altidentifier\":\"tongueout\",\"altcomponent\":\"core_pix\"},{\"text\":\":-p\",\"imagename\":\"s\\/tongueout\",\"imagecomponent\":\"core\",\"altidentifier\":\"tongueout\",\"altcomponent\":\"core_pix\"},{\"text\":\"B-)\",\"imagename\":\"s\\/cool\",\"imagecomponent\":\"core\",\"altidentifier\":\"cool\",\"altcomponent\":\"core_pix\"},{\"text\":\"^-)\",\"imagename\":\"s\\/approve\",\"imagecomponent\":\"core\",\"altidentifier\":\"approve\",\"altcomponent\":\"core_pix\"},{\"text\":\"8-)\",\"imagename\":\"s\\/wideeyes\",\"imagecomponent\":\"core\",\"altidentifier\":\"wideeyes\",\"altcomponent\":\"core_pix\"},{\"text\":\":o)\",\"imagename\":\"s\\/clown\",\"imagecomponent\":\"core\",\"altidentifier\":\"clown\",\"altcomponent\":\"core_pix\"},{\"text\":\":-(\",\"imagename\":\"s\\/sad\",\"imagecomponent\":\"core\",\"altidentifier\":\"sad\",\"altcomponent\":\"core_pix\"},{\"text\":\":(\",\"imagename\":\"s\\/sad\",\"imagecomponent\":\"core\",\"altidentifier\":\"sad\",\"altcomponent\":\"core_pix\"},{\"text\":\"8-.\",\"imagename\":\"s\\/shy\",\"imagecomponent\":\"core\",\"altidentifier\":\"shy\",\"altcomponent\":\"core_pix\"},{\"text\":\":-I\",\"imagename\":\"s\\/blush\",\"imagecomponent\":\"core\",\"altidentifier\":\"blush\",\"altcomponent\":\"core_pix\"},{\"text\":\":-X\",\"imagename\":\"s\\/kiss\",\"imagecomponent\":\"core\",\"altidentifier\":\"kiss\",\"altcomponent\":\"core_pix\"},{\"text\":\"8-o\",\"imagename\":\"s\\/surprise\",\"imagecomponent\":\"core\",\"altidentifier\":\"surprise\",\"altcomponent\":\"core_pix\"},{\"text\":\"P-|\",\"imagename\":\"s\\/blackeye\",\"imagecomponent\":\"core\",\"altidentifier\":\"blackeye\",\"altcomponent\":\"core_pix\"},{\"text\":\"8-[\",\"imagename\":\"s\\/angry\",\"imagecomponent\":\"core\",\"altidentifier\":\"angry\",\"altcomponent\":\"core_pix\"},{\"text\":\"(grr)\",\"imagename\":\"s\\/angry\",\"imagecomponent\":\"core\",\"altidentifier\":\"angry\",\"altcomponent\":\"core_pix\"},{\"text\":\"xx-P\",\"imagename\":\"s\\/dead\",\"imagecomponent\":\"core\",\"altidentifier\":\"dead\",\"altcomponent\":\"core_pix\"},{\"text\":\"|-.\",\"imagename\":\"s\\/sleepy\",\"imagecomponent\":\"core\",\"altidentifier\":\"sleepy\",\"altcomponent\":\"core_pix\"},{\"text\":\"}-]\",\"imagename\":\"s\\/evil\",\"imagecomponent\":\"core\",\"altidentifier\":\"evil\",\"altcomponent\":\"core_pix\"},{\"text\":\"(h)\",\"imagename\":\"s\\/heart\",\"imagecomponent\":\"core\",\"altidentifier\":\"heart\",\"altcomponent\":\"core_pix\"},{\"text\":\"(heart)\",\"imagename\":\"s\\/heart\",\"imagecomponent\":\"core\",\"altidentifier\":\"heart\",\"altcomponent\":\"core_pix\"},{\"text\":\"(y)\",\"imagename\":\"s\\/yes\",\"imagecomponent\":\"core\",\"altidentifier\":\"yes\",\"altcomponent\":\"core\"},{\"text\":\"(n)\",\"imagename\":\"s\\/no\",\"imagecomponent\":\"core\",\"altidentifier\":\"no\",\"altcomponent\":\"core\"},{\"text\":\"(martin)\",\"imagename\":\"s\\/martin\",\"imagecomponent\":\"core\",\"altidentifier\":\"martin\",\"altcomponent\":\"core_pix\"},{\"text\":\"( )\",\"imagename\":\"s\\/egg\",\"imagecomponent\":\"core\",\"altidentifier\":\"egg\",\"altcomponent\":\"core_pix\"}]'),
(305, 'docroot', 'https://docs.moodle.org'),
(306, 'doclang', ''),
(307, 'doctonewwindow', '0'),
(308, 'coursecontactduplicates', '0'),
(309, 'courselistshortnames', '0'),
(310, 'coursesperpage', '20'),
(311, 'courseswithsummarieslimit', '10'),
(312, 'courseoverviewfileslimit', '1'),
(313, 'courseoverviewfilesext', '.jpg,.gif,.png'),
(314, 'coursegraceperiodbefore', '0'),
(315, 'coursegraceperiodafter', '0'),
(316, 'useexternalyui', '0'),
(317, 'yuicomboloading', '1'),
(318, 'cachejs', '1'),
(319, 'modchooserdefault', '1'),
(320, 'additionalhtmlhead', ''),
(321, 'additionalhtmltopofbody', ''),
(322, 'additionalhtmlfooter', ''),
(323, 'cachetemplates', '1'),
(324, 'pathtophp', ''),
(325, 'pathtodu', ''),
(326, 'aspellpath', ''),
(327, 'pathtodot', ''),
(328, 'pathtogs', '/usr/bin/gs'),
(329, 'pathtopython', ''),
(330, 'supportname', 'Admin User'),
(331, 'supportemail', ''),
(332, 'supportpage', ''),
(333, 'dbsessions', '0'),
(334, 'sessioncookie', ''),
(335, 'sessioncookiepath', ''),
(336, 'sessioncookiedomain', ''),
(337, 'statsfirstrun', 'none'),
(338, 'statsmaxruntime', '0'),
(339, 'statsruntimedays', '31'),
(340, 'statsuserthreshold', '0'),
(341, 'slasharguments', '1'),
(342, 'getremoteaddrconf', '0'),
(343, 'proxyhost', ''),
(344, 'proxyport', '0'),
(345, 'proxytype', 'HTTP'),
(346, 'proxyuser', ''),
(347, 'proxypassword', ''),
(348, 'proxybypass', 'localhost, 127.0.0.1'),
(349, 'maintenance_enabled', '0'),
(350, 'maintenance_message', ''),
(351, 'deleteunconfirmed', '168'),
(352, 'deleteincompleteusers', '0'),
(353, 'disablegradehistory', '0'),
(354, 'gradehistorylifetime', '0'),
(355, 'tempdatafoldercleanup', '168'),
(356, 'filescleanupperiod', '86400'),
(357, 'extramemorylimit', '512M'),
(358, 'maxtimelimit', '0'),
(359, 'curlcache', '120'),
(360, 'curltimeoutkbitrate', '56'),
(361, 'task_scheduled_concurrency_limit', '3'),
(362, 'task_scheduled_max_runtime', '1800'),
(363, 'task_adhoc_concurrency_limit', '3'),
(364, 'task_adhoc_max_runtime', '1800'),
(365, 'task_logmode', '1'),
(366, 'task_logtostdout', '1'),
(367, 'task_logretention', '2419200'),
(368, 'task_logretainruns', '20'),
(369, 'smtphosts', ''),
(370, 'smtpsecure', ''),
(371, 'smtpauthtype', 'LOGIN'),
(372, 'smtpuser', ''),
(373, 'smtppass', ''),
(374, 'smtpmaxbulk', '1'),
(375, 'noreplyaddress', 'noreply@learnuat.zinghr.com'),
(376, 'allowedemaildomains', ''),
(377, 'sitemailcharset', '0'),
(378, 'allowusermailcharset', '0'),
(379, 'allowattachments', '1'),
(380, 'mailnewline', 'LF'),
(381, 'emailfromvia', '1'),
(382, 'emailsubjectprefix', ''),
(383, 'updateautocheck', '1'),
(384, 'updateminmaturity', '200'),
(385, 'updatenotifybuilds', '0'),
(386, 'enablesafebrowserintegration', '0'),
(387, 'dndallowtextandlinks', '0'),
(388, 'pathtosassc', ''),
(389, 'contextlocking', '0'),
(390, 'contextlockappliestoadmin', '1'),
(391, 'forceclean', '0'),
(392, 'enablecourserelativedates', '0'),
(393, 'debug', '0'),
(394, 'debugdisplay', '0'),
(395, 'perfdebug', '7'),
(396, 'debugstringids', '0'),
(397, 'debugvalidators', '0'),
(398, 'debugpageinfo', '0'),
(399, 'profilingenabled', '0'),
(400, 'profilingincluded', ''),
(401, 'profilingexcluded', ''),
(402, 'profilingautofrec', '0'),
(403, 'profilingallowme', '0'),
(404, 'profilingallowall', '0'),
(405, 'profilingslow', '0'),
(406, 'profilinglifetime', '1440'),
(407, 'profilingimportprefix', '(I)'),
(408, 'release', '3.8.1+ (Build: 20200228)'),
(409, 'branch', '38'),
(410, 'localcachedirpurged', '1585568499'),
(411, 'scheduledtaskreset', '1585568500'),
(412, 'allversionshash', 'bbb3d099f5aef60a7cfe54e076df8c7f685f4561'),
(414, 'registrationpending', '0'),
(416, 'notloggedinroleid', '6'),
(417, 'guestroleid', '6'),
(418, 'defaultuserroleid', '7'),
(419, 'creatornewroleid', '3'),
(420, 'restorernewroleid', '3'),
(421, 'sitepolicyhandler', ''),
(422, 'gradebookroles', '5'),
(423, 'timezone', 'Africa/Abidjan'),
(424, 'jabberhost', ''),
(425, 'jabberserver', ''),
(426, 'jabberusername', ''),
(427, 'jabberpassword', ''),
(428, 'jabberport', '5222'),
(429, 'airnotifierurl', 'https://messages.moodle.net'),
(430, 'airnotifierport', '443'),
(431, 'airnotifiermobileappname', 'com.moodle.moodlemobile'),
(432, 'airnotifierappname', 'commoodlemoodlemobile'),
(433, 'airnotifieraccesskey', ''),
(434, 'chat_method', 'ajax'),
(435, 'chat_refresh_userlist', '10'),
(436, 'chat_old_ping', '35'),
(437, 'chat_refresh_room', '5'),
(438, 'chat_normal_updatemode', 'jsupdate'),
(439, 'chat_serverhost', 'learnuat.zinghr.com'),
(440, 'chat_serverip', '127.0.0.1'),
(441, 'chat_serverport', '9111'),
(442, 'chat_servermax', '100'),
(443, 'data_enablerssfeeds', '0'),
(444, 'feedback_allowfullanonymous', '0'),
(445, 'forum_displaymode', '3'),
(446, 'forum_shortpost', '300'),
(447, 'forum_longpost', '600'),
(448, 'forum_manydiscussions', '100'),
(449, 'forum_maxbytes', '512000'),
(450, 'forum_maxattachments', '9'),
(451, 'forum_subscription', '0'),
(452, 'forum_trackingtype', '1'),
(453, 'forum_trackreadposts', '1'),
(454, 'forum_allowforcedreadtracking', '0'),
(455, 'forum_oldpostdays', '14'),
(456, 'forum_usermarksread', '0'),
(457, 'forum_cleanreadtime', '2'),
(458, 'digestmailtime', '17'),
(459, 'forum_enablerssfeeds', '0'),
(460, 'forum_enabletimedposts', '1'),
(461, 'glossary_entbypage', '10'),
(462, 'glossary_dupentries', '0'),
(463, 'glossary_allowcomments', '0'),
(464, 'glossary_linkbydefault', '1'),
(465, 'glossary_defaultapproval', '1'),
(466, 'glossary_enablerssfeeds', '0'),
(467, 'glossary_linkentries', '0'),
(468, 'glossary_casesensitive', '0'),
(469, 'glossary_fullmatch', '0'),
(470, 'block_course_list_adminview', 'all'),
(471, 'block_course_list_hideallcourseslink', '0'),
(472, 'block_html_allowcssclasses', '0'),
(473, 'block_online_users_timetosee', '5'),
(474, 'block_online_users_onlinestatushiding', '1'),
(475, 'block_rss_client_num_entries', '5'),
(476, 'block_rss_client_timeout', '30'),
(477, 'pathtounoconv', '/usr/bin/unoconv'),
(478, 'filter_multilang_force_old', '0'),
(479, 'filter_censor_badwords', ''),
(480, 'logguests', '1'),
(481, 'loglifetime', '0'),
(482, 'profileroles', '3,4,5'),
(483, 'coursecontact', '3'),
(484, 'frontpage', '6'),
(485, 'frontpageloggedin', '6'),
(486, 'maxcategorydepth', '2'),
(487, 'frontpagecourselimit', '200'),
(488, 'commentsperpage', '15'),
(489, 'defaultfrontpageroleid', '8'),
(490, 'messageinbound_enabled', '0'),
(491, 'messageinbound_mailbox', ''),
(492, 'messageinbound_domain', ''),
(493, 'messageinbound_host', ''),
(494, 'messageinbound_hostssl', 'ssl'),
(495, 'messageinbound_hostuser', ''),
(496, 'messageinbound_hostpass', ''),
(497, 'webserviceprotocols', 'rest'),
(498, 'enablemobilewebservice', '1'),
(499, 'mobilecssurl', ''),
(500, 'facetoface_fromaddress', 'moodle@example.com'),
(501, 'facetoface_session_roles', '5'),
(502, 'facetoface_addchangemanageremail', '1'),
(503, 'facetoface_manageraddressformat', ''),
(504, 'facetoface_manageraddressformatreadable', 'firstname.lastname@company.com'),
(505, 'facetoface_hidecost', '0'),
(506, 'facetoface_hidediscount', '0'),
(507, 'facetoface_oneemailperday', '0'),
(508, 'facetoface_disableicalcancel', '0'),
(511, 'jitsi_domain', 'meet.jit.si'),
(512, 'fileslastcleanup', '1585078205'),
(513, 'scorm_updatetimelast', '1585164606'),
(514, 'updatecronoffset', '9830'),
(515, 'reposecretkey', '1584077814AUwyuRTE27IPD5CGzxI8vRikmTkKAEEZ'),
(518, 'jitsi_help', ''),
(519, 'jitsi_id', 'username'),
(520, 'jitsi_separator', '0'),
(521, 'jitsi_sesionname', '0,1,2'),
(522, 'jitsi_showinfo', '0'),
(523, 'jitsi_app_id', ''),
(524, 'jitsi_secret', '');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_config_log`
--

CREATE TABLE `mdl_config_log` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `plugin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `oldvalue` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Changes done in server configuration through admin UI' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_config_log`
--

INSERT INTO `mdl_config_log` (`id`, `userid`, `timemodified`, `plugin`, `name`, `value`, `oldvalue`) VALUES
(1, 0, 1583151917, NULL, 'enableoutcomes', '0', NULL),
(2, 0, 1583151917, NULL, 'usecomments', '1', NULL),
(3, 0, 1583151917, NULL, 'usetags', '1', NULL),
(4, 0, 1583151917, NULL, 'enablenotes', '1', NULL),
(5, 0, 1583151917, NULL, 'enableportfolios', '0', NULL),
(6, 0, 1583151917, NULL, 'enablewebservices', '0', NULL),
(7, 0, 1583151917, NULL, 'enablestats', '0', NULL),
(8, 0, 1583151917, NULL, 'enablerssfeeds', '0', NULL),
(9, 0, 1583151917, NULL, 'enableblogs', '1', NULL),
(10, 0, 1583151917, NULL, 'enablecompletion', '1', NULL),
(11, 0, 1583151917, NULL, 'completiondefault', '1', NULL),
(12, 0, 1583151917, NULL, 'enableavailability', '1', NULL),
(13, 0, 1583151918, NULL, 'enableplagiarism', '0', NULL),
(14, 0, 1583151918, NULL, 'enablebadges', '1', NULL),
(15, 0, 1583151918, NULL, 'enableglobalsearch', '0', NULL),
(16, 0, 1583151918, NULL, 'allowstealth', '0', NULL),
(17, 0, 1583151918, NULL, 'enableanalytics', '1', NULL),
(18, 0, 1583151918, NULL, 'allowemojipicker', '1', NULL),
(19, 0, 1583151918, NULL, 'userfiltersdefault', 'realname', NULL),
(20, 0, 1583151918, NULL, 'defaultpreference_maildisplay', '2', NULL),
(21, 0, 1583151918, NULL, 'defaultpreference_mailformat', '1', NULL),
(22, 0, 1583151918, NULL, 'defaultpreference_maildigest', '0', NULL),
(23, 0, 1583151918, NULL, 'defaultpreference_autosubscribe', '1', NULL),
(24, 0, 1583151918, NULL, 'defaultpreference_trackforums', '0', NULL),
(25, 0, 1583151918, NULL, 'autologinguests', '0', NULL),
(26, 0, 1583151918, NULL, 'hiddenuserfields', '', NULL),
(27, 0, 1583151918, NULL, 'showuseridentity', 'email', NULL),
(28, 0, 1583151918, NULL, 'fullnamedisplay', 'language', NULL),
(29, 0, 1583151918, NULL, 'alternativefullnameformat', 'language', NULL),
(30, 0, 1583151918, NULL, 'maxusersperpage', '100', NULL),
(31, 0, 1583151918, NULL, 'enablegravatar', '0', NULL),
(32, 0, 1583151919, NULL, 'gravatardefaulturl', 'mm', NULL),
(33, 0, 1583151919, NULL, 'agedigitalconsentverification', '0', NULL),
(34, 0, 1583151919, NULL, 'agedigitalconsentmap', '*, 16\nAT, 14\nES, 14\nUS, 13', NULL),
(35, 0, 1583151919, NULL, 'sitepolicy', '', NULL),
(36, 0, 1583151919, NULL, 'sitepolicyguest', '', NULL),
(37, 0, 1583151919, 'moodlecourse', 'visible', '1', NULL),
(38, 0, 1583151919, 'moodlecourse', 'format', 'topics', NULL),
(39, 0, 1583151919, 'moodlecourse', 'maxsections', '52', NULL),
(40, 0, 1583151919, 'moodlecourse', 'numsections', '4', NULL),
(41, 0, 1583151919, 'moodlecourse', 'hiddensections', '0', NULL),
(42, 0, 1583151919, 'moodlecourse', 'coursedisplay', '0', NULL),
(43, 0, 1583151919, 'moodlecourse', 'courseenddateenabled', '1', NULL),
(44, 0, 1583151919, 'moodlecourse', 'courseduration', '31536000', NULL),
(45, 0, 1583151919, 'moodlecourse', 'lang', '', NULL),
(46, 0, 1583151919, 'moodlecourse', 'newsitems', '5', NULL),
(47, 0, 1583151919, 'moodlecourse', 'showgrades', '1', NULL),
(48, 0, 1583151919, 'moodlecourse', 'showreports', '0', NULL),
(49, 0, 1583151920, 'moodlecourse', 'maxbytes', '0', NULL),
(50, 0, 1583151920, 'moodlecourse', 'enablecompletion', '1', NULL),
(51, 0, 1583151920, 'moodlecourse', 'groupmode', '0', NULL),
(52, 0, 1583151920, 'moodlecourse', 'groupmodeforce', '0', NULL),
(53, 0, 1583151920, NULL, 'enablecourserequests', '1', NULL),
(54, 0, 1583151920, NULL, 'defaultrequestcategory', '1', NULL),
(55, 0, 1583151920, NULL, 'lockrequestcategory', '0', NULL),
(56, 0, 1583151920, NULL, 'courserequestnotify', '', NULL),
(57, 0, 1583151920, 'backup', 'loglifetime', '30', NULL),
(58, 0, 1583151920, 'backup', 'backup_general_users', '1', NULL),
(59, 0, 1583151920, 'backup', 'backup_general_users_locked', '', NULL),
(60, 0, 1583151920, 'backup', 'backup_general_anonymize', '0', NULL),
(61, 0, 1583151920, 'backup', 'backup_general_anonymize_locked', '', NULL),
(62, 0, 1583151920, 'backup', 'backup_general_role_assignments', '1', NULL),
(63, 0, 1583151920, 'backup', 'backup_general_role_assignments_locked', '', NULL),
(64, 0, 1583151920, 'backup', 'backup_general_activities', '1', NULL),
(65, 0, 1583151920, 'backup', 'backup_general_activities_locked', '', NULL),
(66, 0, 1583151920, 'backup', 'backup_general_blocks', '1', NULL),
(67, 0, 1583151921, 'backup', 'backup_general_blocks_locked', '', NULL),
(68, 0, 1583151921, 'backup', 'backup_general_files', '1', NULL),
(69, 0, 1583151921, 'backup', 'backup_general_files_locked', '', NULL),
(70, 0, 1583151921, 'backup', 'backup_general_filters', '1', NULL),
(71, 0, 1583151921, 'backup', 'backup_general_filters_locked', '', NULL),
(72, 0, 1583151921, 'backup', 'backup_general_comments', '1', NULL),
(73, 0, 1583151921, 'backup', 'backup_general_comments_locked', '', NULL),
(74, 0, 1583151921, 'backup', 'backup_general_badges', '1', NULL),
(75, 0, 1583151921, 'backup', 'backup_general_badges_locked', '', NULL),
(76, 0, 1583151921, 'backup', 'backup_general_calendarevents', '1', NULL),
(77, 0, 1583151921, 'backup', 'backup_general_calendarevents_locked', '', NULL),
(78, 0, 1583151921, 'backup', 'backup_general_userscompletion', '1', NULL),
(79, 0, 1583151921, 'backup', 'backup_general_userscompletion_locked', '', NULL),
(80, 0, 1583151921, 'backup', 'backup_general_logs', '0', NULL),
(81, 0, 1583151921, 'backup', 'backup_general_logs_locked', '', NULL),
(82, 0, 1583151921, 'backup', 'backup_general_histories', '0', NULL),
(83, 0, 1583151921, 'backup', 'backup_general_histories_locked', '', NULL),
(84, 0, 1583151921, 'backup', 'backup_general_questionbank', '1', NULL),
(85, 0, 1583151922, 'backup', 'backup_general_questionbank_locked', '', NULL),
(86, 0, 1583151922, 'backup', 'backup_general_groups', '1', NULL),
(87, 0, 1583151922, 'backup', 'backup_general_groups_locked', '', NULL),
(88, 0, 1583151922, 'backup', 'backup_general_competencies', '1', NULL),
(89, 0, 1583151922, 'backup', 'backup_general_competencies_locked', '', NULL),
(90, 0, 1583151922, 'backup', 'import_general_maxresults', '10', NULL),
(91, 0, 1583151922, 'backup', 'import_general_duplicate_admin_allowed', '0', NULL),
(92, 0, 1583151922, 'backup', 'backup_import_activities', '1', NULL),
(93, 0, 1583151922, 'backup', 'backup_import_activities_locked', '', NULL),
(94, 0, 1583151922, 'backup', 'backup_import_blocks', '1', NULL),
(95, 0, 1583151922, 'backup', 'backup_import_blocks_locked', '', NULL),
(96, 0, 1583151922, 'backup', 'backup_import_filters', '1', NULL),
(97, 0, 1583151922, 'backup', 'backup_import_filters_locked', '', NULL),
(98, 0, 1583151922, 'backup', 'backup_import_calendarevents', '1', NULL),
(99, 0, 1583151922, 'backup', 'backup_import_calendarevents_locked', '', NULL),
(100, 0, 1583151922, 'backup', 'backup_import_questionbank', '1', NULL),
(101, 0, 1583151922, 'backup', 'backup_import_questionbank_locked', '', NULL),
(102, 0, 1583151923, 'backup', 'backup_import_groups', '1', NULL),
(103, 0, 1583151923, 'backup', 'backup_import_groups_locked', '', NULL),
(104, 0, 1583151923, 'backup', 'backup_import_competencies', '1', NULL),
(105, 0, 1583151923, 'backup', 'backup_import_competencies_locked', '', NULL),
(106, 0, 1583151923, 'backup', 'backup_auto_active', '0', NULL),
(107, 0, 1583151923, 'backup', 'backup_auto_weekdays', '0000000', NULL),
(108, 0, 1583151923, 'backup', 'backup_auto_hour', '0', NULL),
(109, 0, 1583151923, 'backup', 'backup_auto_minute', '0', NULL),
(110, 0, 1583151923, 'backup', 'backup_auto_storage', '0', NULL),
(111, 0, 1583151923, 'backup', 'backup_auto_destination', '', NULL),
(112, 0, 1583151923, 'backup', 'backup_auto_max_kept', '1', NULL),
(113, 0, 1583151923, 'backup', 'backup_auto_delete_days', '0', NULL),
(114, 0, 1583151923, 'backup', 'backup_auto_min_kept', '0', NULL),
(115, 0, 1583151923, 'backup', 'backup_shortname', '0', NULL),
(116, 0, 1583151923, 'backup', 'backup_auto_skip_hidden', '1', NULL),
(117, 0, 1583151923, 'backup', 'backup_auto_skip_modif_days', '30', NULL),
(118, 0, 1583151923, 'backup', 'backup_auto_skip_modif_prev', '0', NULL),
(119, 0, 1583151924, 'backup', 'backup_auto_users', '1', NULL),
(120, 0, 1583151924, 'backup', 'backup_auto_role_assignments', '1', NULL),
(121, 0, 1583151924, 'backup', 'backup_auto_activities', '1', NULL),
(122, 0, 1583151924, 'backup', 'backup_auto_blocks', '1', NULL),
(123, 0, 1583151924, 'backup', 'backup_auto_files', '1', NULL),
(124, 0, 1583151924, 'backup', 'backup_auto_filters', '1', NULL),
(125, 0, 1583151924, 'backup', 'backup_auto_comments', '1', NULL),
(126, 0, 1583151924, 'backup', 'backup_auto_badges', '1', NULL),
(127, 0, 1583151924, 'backup', 'backup_auto_calendarevents', '1', NULL),
(128, 0, 1583151924, 'backup', 'backup_auto_userscompletion', '1', NULL),
(129, 0, 1583151924, 'backup', 'backup_auto_logs', '0', NULL),
(130, 0, 1583151924, 'backup', 'backup_auto_histories', '0', NULL),
(131, 0, 1583151924, 'backup', 'backup_auto_questionbank', '1', NULL),
(132, 0, 1583151924, 'backup', 'backup_auto_groups', '1', NULL),
(133, 0, 1583151924, 'backup', 'backup_auto_competencies', '1', NULL),
(134, 0, 1583151924, 'restore', 'restore_general_users', '1', NULL),
(135, 0, 1583151924, 'restore', 'restore_general_users_locked', '', NULL),
(136, 0, 1583151924, 'restore', 'restore_general_enrolments', '1', NULL),
(137, 0, 1583151924, 'restore', 'restore_general_enrolments_locked', '', NULL),
(138, 0, 1583151925, 'restore', 'restore_general_role_assignments', '1', NULL),
(139, 0, 1583151925, 'restore', 'restore_general_role_assignments_locked', '', NULL),
(140, 0, 1583151925, 'restore', 'restore_general_activities', '1', NULL),
(141, 0, 1583151925, 'restore', 'restore_general_activities_locked', '', NULL),
(142, 0, 1583151925, 'restore', 'restore_general_blocks', '1', NULL),
(143, 0, 1583151925, 'restore', 'restore_general_blocks_locked', '', NULL),
(144, 0, 1583151925, 'restore', 'restore_general_filters', '1', NULL),
(145, 0, 1583151925, 'restore', 'restore_general_filters_locked', '', NULL),
(146, 0, 1583151925, 'restore', 'restore_general_comments', '1', NULL),
(147, 0, 1583151925, 'restore', 'restore_general_comments_locked', '', NULL),
(148, 0, 1583151925, 'restore', 'restore_general_badges', '1', NULL),
(149, 0, 1583151925, 'restore', 'restore_general_badges_locked', '', NULL),
(150, 0, 1583151925, 'restore', 'restore_general_calendarevents', '1', NULL),
(151, 0, 1583151925, 'restore', 'restore_general_calendarevents_locked', '', NULL),
(152, 0, 1583151925, 'restore', 'restore_general_userscompletion', '1', NULL),
(153, 0, 1583151925, 'restore', 'restore_general_userscompletion_locked', '', NULL),
(154, 0, 1583151925, 'restore', 'restore_general_logs', '1', NULL),
(155, 0, 1583151925, 'restore', 'restore_general_logs_locked', '', NULL),
(156, 0, 1583151925, 'restore', 'restore_general_histories', '1', NULL),
(157, 0, 1583151926, 'restore', 'restore_general_histories_locked', '', NULL),
(158, 0, 1583151926, 'restore', 'restore_general_groups', '1', NULL),
(159, 0, 1583151926, 'restore', 'restore_general_groups_locked', '', NULL),
(160, 0, 1583151926, 'restore', 'restore_general_competencies', '1', NULL),
(161, 0, 1583151926, 'restore', 'restore_general_competencies_locked', '', NULL),
(162, 0, 1583151926, 'restore', 'restore_merge_overwrite_conf', '0', NULL),
(163, 0, 1583151926, 'restore', 'restore_merge_overwrite_conf_locked', '', NULL),
(164, 0, 1583151926, 'restore', 'restore_merge_course_fullname', '1', NULL),
(165, 0, 1583151926, 'restore', 'restore_merge_course_fullname_locked', '', NULL),
(166, 0, 1583151926, 'restore', 'restore_merge_course_shortname', '1', NULL),
(167, 0, 1583151926, 'restore', 'restore_merge_course_shortname_locked', '', NULL),
(168, 0, 1583151926, 'restore', 'restore_merge_course_startdate', '1', NULL),
(169, 0, 1583151926, 'restore', 'restore_merge_course_startdate_locked', '', NULL),
(170, 0, 1583151926, 'restore', 'restore_replace_overwrite_conf', '0', NULL),
(171, 0, 1583151926, 'restore', 'restore_replace_overwrite_conf_locked', '', NULL),
(172, 0, 1583151926, 'restore', 'restore_replace_course_fullname', '1', NULL),
(173, 0, 1583151926, 'restore', 'restore_replace_course_fullname_locked', '', NULL),
(174, 0, 1583151926, 'restore', 'restore_replace_course_shortname', '1', NULL),
(175, 0, 1583151926, 'restore', 'restore_replace_course_shortname_locked', '', NULL),
(176, 0, 1583151926, 'restore', 'restore_replace_course_startdate', '1', NULL),
(177, 0, 1583151926, 'restore', 'restore_replace_course_startdate_locked', '', NULL),
(178, 0, 1583151927, 'restore', 'restore_replace_keep_roles_and_enrolments', '0', NULL),
(179, 0, 1583151927, 'restore', 'restore_replace_keep_roles_and_enrolments_locked', '', NULL),
(180, 0, 1583151927, 'restore', 'restore_replace_keep_groups_and_groupings', '0', NULL),
(181, 0, 1583151927, 'restore', 'restore_replace_keep_groups_and_groupings_locked', '', NULL),
(182, 0, 1583151927, NULL, 'enableasyncbackup', '0', NULL),
(183, 0, 1583151927, 'backup', 'backup_async_message_users', '0', NULL),
(184, 0, 1583151927, 'backup', 'backup_async_message_subject', 'Moodle {operation} completed successfully', NULL),
(185, 0, 1583151927, 'backup', 'backup_async_message', 'Hi {user_firstname},<br/> Your {operation} (ID: {backupid}) has completed successfully. <br/><br/>You can access it here: {link}.', NULL),
(186, 0, 1583151927, NULL, 'grade_profilereport', 'user', NULL),
(187, 0, 1583151927, NULL, 'grade_aggregationposition', '1', NULL),
(188, 0, 1583151927, NULL, 'grade_includescalesinaggregation', '1', NULL),
(189, 0, 1583151927, NULL, 'grade_hiddenasdate', '0', NULL),
(190, 0, 1583151927, NULL, 'gradepublishing', '0', NULL),
(191, 0, 1583151927, NULL, 'grade_export_exportfeedback', '0', NULL),
(192, 0, 1583151927, NULL, 'grade_export_displaytype', '1', NULL),
(193, 0, 1583151927, NULL, 'grade_export_decimalpoints', '2', NULL),
(194, 0, 1583151927, NULL, 'grade_navmethod', '1', NULL),
(195, 0, 1583151927, NULL, 'grade_export_userprofilefields', 'firstname,lastname,idnumber,institution,department,email', NULL),
(196, 0, 1583151927, NULL, 'grade_export_customprofilefields', '', NULL),
(197, 0, 1583151927, NULL, 'recovergradesdefault', '0', NULL),
(198, 0, 1583151928, NULL, 'gradeexport', '', NULL),
(199, 0, 1583151928, NULL, 'unlimitedgrades', '0', NULL),
(200, 0, 1583151928, NULL, 'grade_report_showmin', '1', NULL),
(201, 0, 1583151928, NULL, 'gradepointmax', '100', NULL),
(202, 0, 1583151928, NULL, 'gradepointdefault', '100', NULL),
(203, 0, 1583151928, NULL, 'grade_minmaxtouse', '1', NULL),
(204, 0, 1583151928, NULL, 'grade_mygrades_report', 'overview', NULL),
(205, 0, 1583151928, NULL, 'gradereport_mygradeurl', '', NULL),
(206, 0, 1583151928, NULL, 'grade_hideforcedsettings', '1', NULL),
(207, 0, 1583151928, NULL, 'grade_aggregation', '13', NULL),
(208, 0, 1583151928, NULL, 'grade_aggregation_flag', '0', NULL),
(209, 0, 1583151928, NULL, 'grade_aggregations_visible', '13', NULL),
(210, 0, 1583151928, NULL, 'grade_aggregateonlygraded', '1', NULL),
(211, 0, 1583151928, NULL, 'grade_aggregateonlygraded_flag', '2', NULL),
(212, 0, 1583151928, NULL, 'grade_aggregateoutcomes', '0', NULL),
(213, 0, 1583151928, NULL, 'grade_aggregateoutcomes_flag', '2', NULL),
(214, 0, 1583151928, NULL, 'grade_keephigh', '0', NULL),
(215, 0, 1583151928, NULL, 'grade_keephigh_flag', '3', NULL),
(216, 0, 1583151928, NULL, 'grade_droplow', '0', NULL),
(217, 0, 1583151928, NULL, 'grade_droplow_flag', '2', NULL),
(218, 0, 1583151928, NULL, 'grade_overridecat', '1', NULL),
(219, 0, 1583151929, NULL, 'grade_displaytype', '1', NULL),
(220, 0, 1583151929, NULL, 'grade_decimalpoints', '2', NULL),
(221, 0, 1583151929, NULL, 'grade_item_advanced', 'iteminfo,idnumber,gradepass,plusfactor,multfactor,display,decimals,hiddenuntil,locktime', NULL),
(222, 0, 1583151929, NULL, 'grade_report_studentsperpage', '100', NULL),
(223, 0, 1583151929, NULL, 'grade_report_showonlyactiveenrol', '1', NULL),
(224, 0, 1583151929, NULL, 'grade_report_quickgrading', '1', NULL),
(225, 0, 1583151929, NULL, 'grade_report_showquickfeedback', '0', NULL),
(226, 0, 1583151929, NULL, 'grade_report_meanselection', '1', NULL),
(227, 0, 1583151929, NULL, 'grade_report_enableajax', '0', NULL),
(228, 0, 1583151929, NULL, 'grade_report_showcalculations', '1', NULL),
(229, 0, 1583151929, NULL, 'grade_report_showeyecons', '0', NULL),
(230, 0, 1583151929, NULL, 'grade_report_showaverages', '1', NULL),
(231, 0, 1583151929, NULL, 'grade_report_showlocks', '0', NULL),
(232, 0, 1583151929, NULL, 'grade_report_showranges', '0', NULL),
(233, 0, 1583151929, NULL, 'grade_report_showanalysisicon', '1', NULL),
(234, 0, 1583151929, NULL, 'grade_report_showuserimage', '1', NULL),
(235, 0, 1583151929, NULL, 'grade_report_showactivityicons', '1', NULL),
(236, 0, 1583151929, NULL, 'grade_report_shownumberofgrades', '0', NULL),
(237, 0, 1583151929, NULL, 'grade_report_averagesdisplaytype', 'inherit', NULL),
(238, 0, 1583151930, NULL, 'grade_report_rangesdisplaytype', 'inherit', NULL),
(239, 0, 1583151930, NULL, 'grade_report_averagesdecimalpoints', 'inherit', NULL),
(240, 0, 1583151930, NULL, 'grade_report_rangesdecimalpoints', 'inherit', NULL),
(241, 0, 1583151930, NULL, 'grade_report_historyperpage', '50', NULL),
(242, 0, 1583151930, NULL, 'grade_report_overview_showrank', '0', NULL),
(243, 0, 1583151930, NULL, 'grade_report_overview_showtotalsifcontainhidden', '0', NULL),
(244, 0, 1583151930, NULL, 'grade_report_user_showrank', '0', NULL),
(245, 0, 1583151930, NULL, 'grade_report_user_showpercentage', '1', NULL),
(246, 0, 1583151930, NULL, 'grade_report_user_showgrade', '1', NULL),
(247, 0, 1583151930, NULL, 'grade_report_user_showfeedback', '1', NULL),
(248, 0, 1583151930, NULL, 'grade_report_user_showrange', '1', NULL),
(249, 0, 1583151930, NULL, 'grade_report_user_showweight', '1', NULL),
(250, 0, 1583151930, NULL, 'grade_report_user_showaverage', '0', NULL),
(251, 0, 1583151930, NULL, 'grade_report_user_showlettergrade', '0', NULL),
(252, 0, 1583151930, NULL, 'grade_report_user_rangedecimals', '0', NULL),
(253, 0, 1583151930, NULL, 'grade_report_user_showhiddenitems', '1', NULL),
(254, 0, 1583151930, NULL, 'grade_report_user_showtotalsifcontainhidden', '0', NULL),
(255, 0, 1583151930, NULL, 'grade_report_user_showcontributiontocoursetotal', '1', NULL),
(256, 0, 1583151930, 'analytics', 'modeinstruction', '', NULL),
(257, 0, 1583151930, 'analytics', 'percentonline', '0', NULL),
(258, 0, 1583151931, 'analytics', 'typeinstitution', '', NULL),
(259, 0, 1583151931, 'analytics', 'levelinstitution', '', NULL),
(260, 0, 1583151931, 'analytics', 'predictionsprocessor', '\\mlbackend_php\\processor', NULL),
(261, 0, 1583151931, 'analytics', 'defaulttimesplittingsevaluation', '\\core\\analytics\\time_splitting\\quarters_accum,\\core\\analytics\\time_splitting\\quarters,\\core\\analytics\\time_splitting\\single_range', NULL),
(262, 0, 1583151931, 'analytics', 'modeloutputdir', '/var/www/moodledata_LMS_2_0/models', NULL),
(263, 0, 1583151931, 'analytics', 'onlycli', '1', NULL),
(264, 0, 1583151931, 'analytics', 'modeltimelimit', '1200', NULL),
(265, 0, 1583151931, 'core_competency', 'enabled', '1', NULL),
(266, 0, 1583151931, 'core_competency', 'pushcourseratingstouserplans', '1', NULL),
(267, 0, 1583151931, NULL, 'badges_defaultissuername', '', NULL),
(268, 0, 1583151931, NULL, 'badges_defaultissuercontact', '', NULL),
(269, 0, 1583151931, NULL, 'badges_badgesalt', 'badges1583151879', NULL),
(270, 0, 1583151931, NULL, 'badges_allowcoursebadges', '1', NULL),
(271, 0, 1583151931, NULL, 'badges_allowexternalbackpack', '1', NULL),
(272, 0, 1583151932, NULL, 'forcetimezone', '99', NULL),
(273, 0, 1583151932, NULL, 'country', '0', NULL),
(274, 0, 1583151932, NULL, 'defaultcity', '', NULL),
(275, 0, 1583151932, NULL, 'geoip2file', '/var/www/moodledata_LMS_2_0/geoip/GeoLite2-City.mmdb', NULL),
(276, 0, 1583151932, NULL, 'googlemapkey3', '', NULL),
(277, 0, 1583151932, NULL, 'allcountrycodes', '', NULL),
(278, 0, 1583151932, NULL, 'autolang', '1', NULL),
(279, 0, 1583151932, NULL, 'lang', 'en', NULL),
(280, 0, 1583151932, NULL, 'langmenu', '1', NULL),
(281, 0, 1583151932, NULL, 'langlist', '', NULL),
(282, 0, 1583151933, NULL, 'langcache', '1', NULL),
(283, 0, 1583151933, NULL, 'langstringcache', '1', NULL),
(284, 0, 1583151933, NULL, 'locale', '', NULL),
(285, 0, 1583151933, NULL, 'latinexcelexport', '0', NULL),
(286, 0, 1583151933, NULL, 'messaging', '1', NULL),
(287, 0, 1583151933, NULL, 'messagingallusers', '0', NULL),
(288, 0, 1583151933, NULL, 'messagingdefaultpressenter', '1', NULL),
(289, 0, 1583151933, NULL, 'messagingdeletereadnotificationsdelay', '604800', NULL),
(290, 0, 1583151933, NULL, 'messagingdeleteallnotificationsdelay', '2620800', NULL),
(291, 0, 1583151933, NULL, 'messagingallowemailoverride', '0', NULL),
(292, 0, 1583151933, NULL, 'requiremodintro', '0', NULL),
(293, 0, 1583151933, NULL, 'registerauth', '', NULL),
(294, 0, 1583151933, NULL, 'authloginviaemail', '0', NULL),
(295, 0, 1583151933, NULL, 'allowaccountssameemail', '0', NULL),
(296, 0, 1583151933, NULL, 'authpreventaccountcreation', '0', NULL),
(297, 0, 1583151933, NULL, 'loginpageautofocus', '0', NULL),
(298, 0, 1583151933, NULL, 'guestloginbutton', '1', NULL),
(299, 0, 1583151933, NULL, 'limitconcurrentlogins', '0', NULL),
(300, 0, 1583151933, NULL, 'alternateloginurl', '', NULL),
(301, 0, 1583151933, NULL, 'forgottenpasswordurl', '', NULL),
(302, 0, 1583151933, NULL, 'auth_instructions', '', NULL),
(303, 0, 1583151934, NULL, 'allowemailaddresses', '', NULL),
(304, 0, 1583151934, NULL, 'denyemailaddresses', '', NULL),
(305, 0, 1583151934, NULL, 'verifychangedemail', '1', NULL),
(306, 0, 1583151934, NULL, 'recaptchapublickey', '', NULL),
(307, 0, 1583151934, NULL, 'recaptchaprivatekey', '', NULL),
(308, 0, 1583151934, 'cachestore_apcu', 'testperformance', '0', NULL),
(309, 0, 1583151934, 'cachestore_memcached', 'testservers', '', NULL),
(310, 0, 1583151934, 'cachestore_mongodb', 'testserver', '', NULL),
(311, 0, 1583151934, 'cachestore_redis', 'test_server', '', NULL),
(312, 0, 1583151934, 'cachestore_redis', 'test_password', '', NULL),
(313, 0, 1583151934, NULL, 'filteruploadedfiles', '0', NULL),
(314, 0, 1583151934, NULL, 'filtermatchoneperpage', '0', NULL),
(315, 0, 1583151934, NULL, 'filtermatchonepertext', '0', NULL),
(316, 0, 1583151934, NULL, 'sitedefaultlicense', 'allrightsreserved', NULL),
(317, 0, 1583151934, NULL, 'media_default_width', '400', NULL),
(318, 0, 1583151934, NULL, 'media_default_height', '300', NULL),
(319, 0, 1583151934, NULL, 'portfolio_moderate_filesize_threshold', '1048576', NULL),
(320, 0, 1583151934, NULL, 'portfolio_high_filesize_threshold', '5242880', NULL),
(321, 0, 1583151934, NULL, 'portfolio_moderate_db_threshold', '20', NULL),
(322, 0, 1583151935, NULL, 'portfolio_high_db_threshold', '50', NULL),
(323, 0, 1583151935, 'question_preview', 'behaviour', 'deferredfeedback', NULL),
(324, 0, 1583151935, 'question_preview', 'correctness', '1', NULL),
(325, 0, 1583151935, 'question_preview', 'marks', '2', NULL),
(326, 0, 1583151935, 'question_preview', 'markdp', '2', NULL),
(327, 0, 1583151935, 'question_preview', 'feedback', '1', NULL),
(328, 0, 1583151935, 'question_preview', 'generalfeedback', '1', NULL),
(329, 0, 1583151935, 'question_preview', 'rightanswer', '1', NULL),
(330, 0, 1583151935, 'question_preview', 'history', '0', NULL),
(331, 0, 1583151935, NULL, 'repositorycacheexpire', '120', NULL),
(332, 0, 1583151935, NULL, 'repositorygetfiletimeout', '30', NULL),
(333, 0, 1583151935, NULL, 'repositorysyncfiletimeout', '1', NULL),
(334, 0, 1583151935, NULL, 'repositorysyncimagetimeout', '3', NULL),
(335, 0, 1583151935, NULL, 'repositoryallowexternallinks', '1', NULL),
(336, 0, 1583151935, NULL, 'legacyfilesinnewcourses', '0', NULL),
(337, 0, 1583151935, NULL, 'legacyfilesaddallowed', '1', NULL),
(338, 0, 1583151935, NULL, 'searchengine', 'simpledb', NULL),
(339, 0, 1583151936, NULL, 'searchindexwhendisabled', '0', NULL),
(340, 0, 1583151936, NULL, 'searchindextime', '600', NULL),
(341, 0, 1583151936, NULL, 'searchallavailablecourses', '0', NULL),
(342, 0, 1583151936, NULL, 'searchincludeallcourses', '0', NULL),
(343, 0, 1583151936, NULL, 'searchenablecategories', '0', NULL),
(344, 0, 1583151936, NULL, 'searchdefaultcategory', 'core-all', NULL),
(345, 0, 1583151936, NULL, 'searchhideallcategory', '0', NULL),
(346, 0, 1583151936, NULL, 'enablewsdocumentation', '0', NULL),
(347, 0, 1583151936, NULL, 'allowbeforeblock', '0', NULL),
(348, 0, 1583151936, NULL, 'allowedip', '', NULL),
(349, 0, 1583151936, NULL, 'blockedip', '', NULL),
(350, 0, 1583151936, NULL, 'protectusernames', '1', NULL),
(351, 0, 1583151936, NULL, 'forcelogin', '0', NULL),
(352, 0, 1583151936, NULL, 'forceloginforprofiles', '1', NULL),
(353, 0, 1583151936, NULL, 'forceloginforprofileimage', '0', NULL),
(354, 0, 1583151936, NULL, 'opentowebcrawlers', '0', NULL),
(355, 0, 1583151936, NULL, 'allowindexing', '0', NULL),
(356, 0, 1583151936, NULL, 'maxbytes', '0', NULL),
(357, 0, 1583151937, NULL, 'userquota', '104857600', NULL),
(358, 0, 1583151937, NULL, 'allowobjectembed', '0', NULL),
(359, 0, 1583151937, NULL, 'enabletrusttext', '0', NULL),
(360, 0, 1583151937, NULL, 'maxeditingtime', '1800', NULL),
(361, 0, 1583151937, NULL, 'extendedusernamechars', '0', NULL),
(362, 0, 1583151937, NULL, 'keeptagnamecase', '1', NULL),
(363, 0, 1583151937, NULL, 'profilesforenrolledusersonly', '1', NULL),
(364, 0, 1583151937, NULL, 'cronclionly', '1', NULL),
(365, 0, 1583151937, NULL, 'cronremotepassword', '', NULL),
(366, 0, 1583151937, 'tool_task', 'enablerunnow', '1', NULL),
(367, 0, 1583151937, NULL, 'lockoutthreshold', '0', NULL),
(368, 0, 1583151937, NULL, 'lockoutwindow', '1800', NULL),
(369, 0, 1583151937, NULL, 'lockoutduration', '1800', NULL),
(370, 0, 1583151937, NULL, 'passwordpolicy', '1', NULL),
(371, 0, 1583151937, NULL, 'minpasswordlength', '8', NULL),
(372, 0, 1583151937, NULL, 'minpassworddigits', '1', NULL),
(373, 0, 1583151937, NULL, 'minpasswordlower', '1', NULL),
(374, 0, 1583151937, NULL, 'minpasswordupper', '1', NULL),
(375, 0, 1583151937, NULL, 'minpasswordnonalphanum', '1', NULL),
(376, 0, 1583151938, NULL, 'maxconsecutiveidentchars', '0', NULL),
(377, 0, 1583151938, NULL, 'passwordreuselimit', '0', NULL),
(378, 0, 1583151938, NULL, 'pwresettime', '1800', NULL),
(379, 0, 1583151938, NULL, 'passwordchangelogout', '0', NULL),
(380, 0, 1583151938, NULL, 'passwordchangetokendeletion', '0', NULL),
(381, 0, 1583151938, NULL, 'tokenduration', '7257600', NULL),
(382, 0, 1583151938, NULL, 'groupenrolmentkeypolicy', '1', NULL),
(383, 0, 1583151938, NULL, 'disableuserimages', '0', NULL),
(384, 0, 1583151938, NULL, 'emailchangeconfirmation', '1', NULL),
(385, 0, 1583151938, NULL, 'rememberusername', '2', NULL),
(386, 0, 1583151938, NULL, 'strictformsrequired', '0', NULL),
(387, 0, 1583151938, NULL, 'cookiesecure', '1', NULL),
(388, 0, 1583151938, NULL, 'cookiehttponly', '0', NULL),
(389, 0, 1583151938, NULL, 'allowframembedding', '0', NULL),
(390, 0, 1583151938, NULL, 'curlsecurityblockedhosts', '', NULL),
(391, 0, 1583151938, NULL, 'curlsecurityallowedport', '', NULL),
(392, 0, 1583151938, NULL, 'displayloginfailures', '0', NULL),
(393, 0, 1583151938, NULL, 'notifyloginfailures', '', NULL),
(394, 0, 1583151938, NULL, 'notifyloginthreshold', '10', NULL),
(395, 0, 1583151939, NULL, 'themelist', '', NULL),
(396, 0, 1583151939, NULL, 'themedesignermode', '0', NULL),
(397, 0, 1583151939, NULL, 'allowuserthemes', '0', NULL),
(398, 0, 1583151939, NULL, 'allowcoursethemes', '0', NULL),
(399, 0, 1583151939, NULL, 'allowcategorythemes', '0', NULL),
(400, 0, 1583151939, NULL, 'allowcohortthemes', '0', NULL),
(401, 0, 1583151939, NULL, 'allowthemechangeonurl', '0', NULL),
(402, 0, 1583151939, NULL, 'allowuserblockhiding', '1', NULL),
(403, 0, 1583151939, NULL, 'custommenuitems', '', NULL),
(404, 0, 1583151939, NULL, 'customusermenuitems', 'grades,grades|/grade/report/mygrades.php|t/grades\nmessages,message|/message/index.php|t/message\npreferences,moodle|/user/preferences.php|t/preferences', NULL),
(405, 0, 1583151939, NULL, 'enabledevicedetection', '1', NULL),
(406, 0, 1583151939, NULL, 'devicedetectregex', '[]', NULL),
(407, 0, 1583151939, 'theme_boost', 'preset', 'default.scss', NULL),
(408, 0, 1583151939, 'theme_boost', 'presetfiles', '', NULL),
(409, 0, 1583151939, 'theme_boost', 'backgroundimage', '', NULL),
(410, 0, 1583151939, 'theme_boost', 'brandcolor', '', NULL),
(411, 0, 1583151939, 'theme_boost', 'scsspre', '', NULL),
(412, 0, 1583151939, 'theme_boost', 'scss', '', NULL),
(413, 0, 1583151940, 'theme_classic', 'navbardark', '0', NULL),
(414, 0, 1583151940, 'theme_classic', 'preset', 'default.scss', NULL),
(415, 0, 1583151940, 'theme_classic', 'presetfiles', '', NULL),
(416, 0, 1583151940, 'theme_classic', 'backgroundimage', '', NULL),
(417, 0, 1583151940, 'theme_classic', 'brandcolor', '', NULL),
(418, 0, 1583151940, 'theme_classic', 'scsspre', '', NULL),
(419, 0, 1583151940, 'theme_classic', 'scss', '', NULL),
(420, 0, 1583151940, 'core_admin', 'logo', '', NULL),
(421, 0, 1583151940, 'core_admin', 'logocompact', '', NULL),
(422, 0, 1583151940, 'core_admin', 'coursecolor1', '#81ecec', NULL),
(423, 0, 1583151940, 'core_admin', 'coursecolor2', '#74b9ff', NULL),
(424, 0, 1583151940, 'core_admin', 'coursecolor3', '#a29bfe', NULL),
(425, 0, 1583151940, 'core_admin', 'coursecolor4', '#dfe6e9', NULL),
(426, 0, 1583151940, 'core_admin', 'coursecolor5', '#00b894', NULL),
(427, 0, 1583151940, 'core_admin', 'coursecolor6', '#0984e3', NULL),
(428, 0, 1583151940, 'core_admin', 'coursecolor7', '#b2bec3', NULL),
(429, 0, 1583151940, 'core_admin', 'coursecolor8', '#fdcb6e', NULL),
(430, 0, 1583151940, 'core_admin', 'coursecolor9', '#fd79a8', NULL),
(431, 0, 1583151940, 'core_admin', 'coursecolor10', '#6c5ce7', NULL),
(432, 0, 1583151940, NULL, 'calendartype', 'gregorian', NULL),
(433, 0, 1583151941, NULL, 'calendar_adminseesall', '0', NULL),
(434, 0, 1583151941, NULL, 'calendar_site_timeformat', '0', NULL),
(435, 0, 1583151941, NULL, 'calendar_startwday', '1', NULL),
(436, 0, 1583151941, NULL, 'calendar_weekend', '65', NULL),
(437, 0, 1583151941, NULL, 'calendar_lookahead', '21', NULL),
(438, 0, 1583151941, NULL, 'calendar_maxevents', '10', NULL),
(439, 0, 1583151941, NULL, 'enablecalendarexport', '1', NULL),
(440, 0, 1583151941, NULL, 'calendar_customexport', '1', NULL),
(441, 0, 1583151941, NULL, 'calendar_exportlookahead', '365', NULL),
(442, 0, 1583151941, NULL, 'calendar_exportlookback', '5', NULL),
(443, 0, 1583151941, NULL, 'calendar_exportsalt', 'luqenfRPQuAMS3BHELtH5lwszAQWrDGXoBcnLcDj1COwbx3S0EYA5BhVKWhm', NULL),
(444, 0, 1583151941, NULL, 'calendar_showicalsource', '1', NULL),
(445, 0, 1583151941, NULL, 'useblogassociations', '1', NULL),
(446, 0, 1583151941, NULL, 'bloglevel', '4', NULL),
(447, 0, 1583151941, NULL, 'useexternalblogs', '1', NULL),
(448, 0, 1583151941, NULL, 'externalblogcrontime', '86400', NULL),
(449, 0, 1583151941, NULL, 'maxexternalblogsperuser', '1', NULL),
(450, 0, 1583151942, NULL, 'blogusecomments', '1', NULL),
(451, 0, 1583151942, NULL, 'blogshowcommentscount', '1', NULL),
(452, 0, 1583151942, NULL, 'defaulthomepage', '1', NULL),
(453, 0, 1583151942, NULL, 'allowguestmymoodle', '1', NULL),
(454, 0, 1583151942, NULL, 'navshowfullcoursenames', '0', NULL),
(455, 0, 1583151942, NULL, 'navshowcategories', '1', NULL),
(456, 0, 1583151942, NULL, 'navshowmycoursecategories', '0', NULL),
(457, 0, 1583151942, NULL, 'navshowallcourses', '0', NULL),
(458, 0, 1583151942, NULL, 'navsortmycoursessort', 'sortorder', NULL),
(459, 0, 1583151942, NULL, 'navsortmycourseshiddenlast', '1', NULL),
(460, 0, 1583151942, NULL, 'navcourselimit', '10', NULL),
(461, 0, 1583151942, NULL, 'usesitenameforsitepages', '0', NULL),
(462, 0, 1583151942, NULL, 'linkadmincategories', '1', NULL),
(463, 0, 1583151942, NULL, 'linkcoursesections', '1', NULL),
(464, 0, 1583151942, NULL, 'navshowfrontpagemods', '1', NULL),
(465, 0, 1583151942, NULL, 'navadduserpostslinks', '1', NULL),
(466, 0, 1583151942, NULL, 'formatstringstriptags', '1', NULL),
(467, 0, 1583151942, NULL, 'emoticons', '[{\"text\":\":-)\",\"imagename\":\"s\\/smiley\",\"imagecomponent\":\"core\",\"altidentifier\":\"smiley\",\"altcomponent\":\"core_pix\"},{\"text\":\":)\",\"imagename\":\"s\\/smiley\",\"imagecomponent\":\"core\",\"altidentifier\":\"smiley\",\"altcomponent\":\"core_pix\"},{\"text\":\":-D\",\"imagename\":\"s\\/biggrin\",\"imagecomponent\":\"core\",\"altidentifier\":\"biggrin\",\"altcomponent\":\"core_pix\"},{\"text\":\";-)\",\"imagename\":\"s\\/wink\",\"imagecomponent\":\"core\",\"altidentifier\":\"wink\",\"altcomponent\":\"core_pix\"},{\"text\":\":-\\/\",\"imagename\":\"s\\/mixed\",\"imagecomponent\":\"core\",\"altidentifier\":\"mixed\",\"altcomponent\":\"core_pix\"},{\"text\":\"V-.\",\"imagename\":\"s\\/thoughtful\",\"imagecomponent\":\"core\",\"altidentifier\":\"thoughtful\",\"altcomponent\":\"core_pix\"},{\"text\":\":-P\",\"imagename\":\"s\\/tongueout\",\"imagecomponent\":\"core\",\"altidentifier\":\"tongueout\",\"altcomponent\":\"core_pix\"},{\"text\":\":-p\",\"imagename\":\"s\\/tongueout\",\"imagecomponent\":\"core\",\"altidentifier\":\"tongueout\",\"altcomponent\":\"core_pix\"},{\"text\":\"B-)\",\"imagename\":\"s\\/cool\",\"imagecomponent\":\"core\",\"altidentifier\":\"cool\",\"altcomponent\":\"core_pix\"},{\"text\":\"^-)\",\"imagename\":\"s\\/approve\",\"imagecomponent\":\"core\",\"altidentifier\":\"approve\",\"altcomponent\":\"core_pix\"},{\"text\":\"8-)\",\"imagename\":\"s\\/wideeyes\",\"imagecomponent\":\"core\",\"altidentifier\":\"wideeyes\",\"altcomponent\":\"core_pix\"},{\"text\":\":o)\",\"imagename\":\"s\\/clown\",\"imagecomponent\":\"core\",\"altidentifier\":\"clown\",\"altcomponent\":\"core_pix\"},{\"text\":\":-(\",\"imagename\":\"s\\/sad\",\"imagecomponent\":\"core\",\"altidentifier\":\"sad\",\"altcomponent\":\"core_pix\"},{\"text\":\":(\",\"imagename\":\"s\\/sad\",\"imagecomponent\":\"core\",\"altidentifier\":\"sad\",\"altcomponent\":\"core_pix\"},{\"text\":\"8-.\",\"imagename\":\"s\\/shy\",\"imagecomponent\":\"core\",\"altidentifier\":\"shy\",\"altcomponent\":\"core_pix\"},{\"text\":\":-I\",\"imagename\":\"s\\/blush\",\"imagecomponent\":\"core\",\"altidentifier\":\"blush\",\"altcomponent\":\"core_pix\"},{\"text\":\":-X\",\"imagename\":\"s\\/kiss\",\"imagecomponent\":\"core\",\"altidentifier\":\"kiss\",\"altcomponent\":\"core_pix\"},{\"text\":\"8-o\",\"imagename\":\"s\\/surprise\",\"imagecomponent\":\"core\",\"altidentifier\":\"surprise\",\"altcomponent\":\"core_pix\"},{\"text\":\"P-|\",\"imagename\":\"s\\/blackeye\",\"imagecomponent\":\"core\",\"altidentifier\":\"blackeye\",\"altcomponent\":\"core_pix\"},{\"text\":\"8-[\",\"imagename\":\"s\\/angry\",\"imagecomponent\":\"core\",\"altidentifier\":\"angry\",\"altcomponent\":\"core_pix\"},{\"text\":\"(grr)\",\"imagename\":\"s\\/angry\",\"imagecomponent\":\"core\",\"altidentifier\":\"angry\",\"altcomponent\":\"core_pix\"},{\"text\":\"xx-P\",\"imagename\":\"s\\/dead\",\"imagecomponent\":\"core\",\"altidentifier\":\"dead\",\"altcomponent\":\"core_pix\"},{\"text\":\"|-.\",\"imagename\":\"s\\/sleepy\",\"imagecomponent\":\"core\",\"altidentifier\":\"sleepy\",\"altcomponent\":\"core_pix\"},{\"text\":\"}-]\",\"imagename\":\"s\\/evil\",\"imagecomponent\":\"core\",\"altidentifier\":\"evil\",\"altcomponent\":\"core_pix\"},{\"text\":\"(h)\",\"imagename\":\"s\\/heart\",\"imagecomponent\":\"core\",\"altidentifier\":\"heart\",\"altcomponent\":\"core_pix\"},{\"text\":\"(heart)\",\"imagename\":\"s\\/heart\",\"imagecomponent\":\"core\",\"altidentifier\":\"heart\",\"altcomponent\":\"core_pix\"},{\"text\":\"(y)\",\"imagename\":\"s\\/yes\",\"imagecomponent\":\"core\",\"altidentifier\":\"yes\",\"altcomponent\":\"core\"},{\"text\":\"(n)\",\"imagename\":\"s\\/no\",\"imagecomponent\":\"core\",\"altidentifier\":\"no\",\"altcomponent\":\"core\"},{\"text\":\"(martin)\",\"imagename\":\"s\\/martin\",\"imagecomponent\":\"core\",\"altidentifier\":\"martin\",\"altcomponent\":\"core_pix\"},{\"text\":\"( )\",\"imagename\":\"s\\/egg\",\"imagecomponent\":\"core\",\"altidentifier\":\"egg\",\"altcomponent\":\"core_pix\"}]', NULL),
(468, 0, 1583151942, NULL, 'docroot', 'https://docs.moodle.org', NULL),
(469, 0, 1583151942, NULL, 'doclang', '', NULL),
(470, 0, 1583151943, NULL, 'doctonewwindow', '0', NULL),
(471, 0, 1583151943, NULL, 'coursecontactduplicates', '0', NULL),
(472, 0, 1583151943, NULL, 'courselistshortnames', '0', NULL),
(473, 0, 1583151943, NULL, 'coursesperpage', '20', NULL),
(474, 0, 1583151943, NULL, 'courseswithsummarieslimit', '10', NULL),
(475, 0, 1583151943, NULL, 'courseoverviewfileslimit', '1', NULL),
(476, 0, 1583151943, NULL, 'courseoverviewfilesext', '.jpg,.gif,.png', NULL),
(477, 0, 1583151943, NULL, 'coursegraceperiodbefore', '0', NULL),
(478, 0, 1583151943, NULL, 'coursegraceperiodafter', '0', NULL),
(479, 0, 1583151943, NULL, 'useexternalyui', '0', NULL),
(480, 0, 1583151943, NULL, 'yuicomboloading', '1', NULL),
(481, 0, 1583151943, NULL, 'cachejs', '1', NULL),
(482, 0, 1583151943, NULL, 'modchooserdefault', '1', NULL),
(483, 0, 1583151943, NULL, 'additionalhtmlhead', '', NULL),
(484, 0, 1583151943, NULL, 'additionalhtmltopofbody', '', NULL),
(485, 0, 1583151943, NULL, 'additionalhtmlfooter', '', NULL),
(486, 0, 1583151943, NULL, 'cachetemplates', '1', NULL),
(487, 0, 1583151943, NULL, 'pathtophp', '', NULL),
(488, 0, 1583151944, NULL, 'pathtodu', '', NULL),
(489, 0, 1583151944, NULL, 'aspellpath', '', NULL),
(490, 0, 1583151944, NULL, 'pathtodot', '', NULL),
(491, 0, 1583151944, NULL, 'pathtogs', '/usr/bin/gs', NULL),
(492, 0, 1583151944, NULL, 'pathtopython', '', NULL),
(493, 0, 1583151944, NULL, 'supportname', 'Admin User', NULL),
(494, 0, 1583151944, NULL, 'supportemail', '', NULL),
(495, 0, 1583151944, NULL, 'supportpage', '', NULL),
(496, 0, 1583151944, NULL, 'dbsessions', '0', NULL),
(497, 0, 1583151944, NULL, 'sessioncookie', '', NULL),
(498, 0, 1583151944, NULL, 'sessioncookiepath', '', NULL),
(499, 0, 1583151944, NULL, 'sessioncookiedomain', '', NULL),
(500, 0, 1583151944, NULL, 'statsfirstrun', 'none', NULL),
(501, 0, 1583151944, NULL, 'statsmaxruntime', '0', NULL),
(502, 0, 1583151944, NULL, 'statsruntimedays', '31', NULL),
(503, 0, 1583151944, NULL, 'statsuserthreshold', '0', NULL),
(504, 0, 1583151944, NULL, 'slasharguments', '1', NULL),
(505, 0, 1583151944, NULL, 'getremoteaddrconf', '0', NULL),
(506, 0, 1583151945, NULL, 'proxyhost', '', NULL),
(507, 0, 1583151945, NULL, 'proxyport', '0', NULL),
(508, 0, 1583151945, NULL, 'proxytype', 'HTTP', NULL),
(509, 0, 1583151945, NULL, 'proxyuser', '', NULL),
(510, 0, 1583151945, NULL, 'proxypassword', '', NULL),
(511, 0, 1583151945, NULL, 'proxybypass', 'localhost, 127.0.0.1', NULL),
(512, 0, 1583151945, NULL, 'maintenance_enabled', '0', NULL),
(513, 0, 1583151945, NULL, 'maintenance_message', '', NULL),
(514, 0, 1583151945, NULL, 'deleteunconfirmed', '168', NULL),
(515, 0, 1583151945, NULL, 'deleteincompleteusers', '0', NULL),
(516, 0, 1583151945, NULL, 'disablegradehistory', '0', NULL),
(517, 0, 1583151945, NULL, 'gradehistorylifetime', '0', NULL),
(518, 0, 1583151945, NULL, 'tempdatafoldercleanup', '168', NULL),
(519, 0, 1583151945, NULL, 'filescleanupperiod', '86400', NULL),
(520, 0, 1583151945, NULL, 'extramemorylimit', '512M', NULL),
(521, 0, 1583151945, NULL, 'maxtimelimit', '0', NULL),
(522, 0, 1583151945, NULL, 'curlcache', '120', NULL),
(523, 0, 1583151945, NULL, 'curltimeoutkbitrate', '56', NULL),
(524, 0, 1583151945, NULL, 'task_scheduled_concurrency_limit', '3', NULL),
(525, 0, 1583151946, NULL, 'task_scheduled_max_runtime', '1800', NULL),
(526, 0, 1583151946, NULL, 'task_adhoc_concurrency_limit', '3', NULL),
(527, 0, 1583151946, NULL, 'task_adhoc_max_runtime', '1800', NULL),
(528, 0, 1583151946, NULL, 'task_logmode', '1', NULL),
(529, 0, 1583151946, NULL, 'task_logtostdout', '1', NULL),
(530, 0, 1583151946, NULL, 'task_logretention', '2419200', NULL),
(531, 0, 1583151946, NULL, 'task_logretainruns', '20', NULL),
(532, 0, 1583151946, NULL, 'smtphosts', '', NULL),
(533, 0, 1583151946, NULL, 'smtpsecure', '', NULL),
(534, 0, 1583151946, NULL, 'smtpauthtype', 'LOGIN', NULL),
(535, 0, 1583151946, NULL, 'smtpuser', '', NULL),
(536, 0, 1583151946, NULL, 'smtppass', '', NULL),
(537, 0, 1583151946, NULL, 'smtpmaxbulk', '1', NULL),
(538, 0, 1583151946, NULL, 'noreplyaddress', 'noreply@learnuat.zinghr.com', NULL),
(539, 0, 1583151946, NULL, 'allowedemaildomains', '', NULL),
(540, 0, 1583151946, NULL, 'sitemailcharset', '0', NULL),
(541, 0, 1583151946, NULL, 'allowusermailcharset', '0', NULL),
(542, 0, 1583151946, NULL, 'allowattachments', '1', NULL),
(543, 0, 1583151946, NULL, 'mailnewline', 'LF', NULL),
(544, 0, 1583151946, NULL, 'emailfromvia', '1', NULL),
(545, 0, 1583151947, NULL, 'emailsubjectprefix', '', NULL),
(546, 0, 1583151947, NULL, 'updateautocheck', '1', NULL),
(547, 0, 1583151947, NULL, 'updateminmaturity', '200', NULL),
(548, 0, 1583151947, NULL, 'updatenotifybuilds', '0', NULL),
(549, 0, 1583151947, NULL, 'enablesafebrowserintegration', '0', NULL),
(550, 0, 1583151947, NULL, 'dndallowtextandlinks', '0', NULL),
(551, 0, 1583151947, NULL, 'pathtosassc', '', NULL),
(552, 0, 1583151947, NULL, 'contextlocking', '0', NULL),
(553, 0, 1583151947, NULL, 'contextlockappliestoadmin', '1', NULL),
(554, 0, 1583151947, NULL, 'forceclean', '0', NULL),
(555, 0, 1583151947, NULL, 'enablecourserelativedates', '0', NULL),
(556, 0, 1583151947, NULL, 'debug', '0', NULL),
(557, 0, 1583151947, NULL, 'debugdisplay', '0', NULL),
(558, 0, 1583151947, NULL, 'perfdebug', '7', NULL),
(559, 0, 1583151947, NULL, 'debugstringids', '0', NULL),
(560, 0, 1583151947, NULL, 'debugvalidators', '0', NULL),
(561, 0, 1583151947, NULL, 'debugpageinfo', '0', NULL),
(562, 0, 1583151947, NULL, 'profilingenabled', '0', NULL),
(563, 0, 1583151947, NULL, 'profilingincluded', '', NULL),
(564, 0, 1583151947, NULL, 'profilingexcluded', '', NULL),
(565, 0, 1583151948, NULL, 'profilingautofrec', '0', NULL),
(566, 0, 1583151948, NULL, 'profilingallowme', '0', NULL),
(567, 0, 1583151948, NULL, 'profilingallowall', '0', NULL),
(568, 0, 1583151948, NULL, 'profilingslow', '0', NULL),
(569, 0, 1583151948, NULL, 'profilinglifetime', '1440', NULL),
(570, 0, 1583151948, NULL, 'profilingimportprefix', '(I)', NULL),
(571, 0, 1583151950, NULL, 'calendar_exportsalt', 'AbLUBgX1cagiApy46oDxpYxiWBexdpEz3KL11UZuQjDKqB8UT7C9CNgm2DHb', 'luqenfRPQuAMS3BHELtH5lwszAQWrDGXoBcnLcDj1COwbx3S0EYA5BhVKWhm'),
(572, 0, 1583152051, 'activitynames', 'filter_active', '1', ''),
(573, 0, 1583152052, 'displayh5p', 'filter_active', '1', ''),
(574, 0, 1583152053, 'mathjaxloader', 'filter_active', '1', ''),
(575, 0, 1583152053, 'mediaplugin', 'filter_active', '1', ''),
(576, 2, 1583152915, NULL, 'notloggedinroleid', '6', NULL),
(577, 2, 1583152916, NULL, 'guestroleid', '6', NULL),
(578, 2, 1583152916, NULL, 'defaultuserroleid', '7', NULL),
(579, 2, 1583152916, NULL, 'creatornewroleid', '3', NULL),
(580, 2, 1583152916, NULL, 'restorernewroleid', '3', NULL),
(581, 2, 1583152916, 'tool_dataprivacy', 'contactdataprotectionofficer', '0', NULL),
(582, 2, 1583152916, 'tool_dataprivacy', 'automaticdeletionrequests', '1', NULL),
(583, 2, 1583152916, 'tool_dataprivacy', 'privacyrequestexpiry', '604800', NULL),
(584, 2, 1583152916, 'tool_dataprivacy', 'requireallenddatesforuserdeletion', '1', NULL),
(585, 2, 1583152916, 'tool_dataprivacy', 'showdataretentionsummary', '1', NULL),
(586, 2, 1583152916, 'tool_log', 'exportlog', '1', NULL),
(587, 2, 1583152916, NULL, 'sitepolicyhandler', '', NULL),
(588, 2, 1583152916, NULL, 'gradebookroles', '5', NULL),
(589, 2, 1583152916, 'analytics', 'logstore', 'logstore_standard', NULL),
(590, 2, 1583152916, NULL, 'timezone', 'Africa/Abidjan', NULL),
(591, 2, 1583152916, NULL, 'jabberhost', '', NULL),
(592, 2, 1583152916, NULL, 'jabberserver', '', NULL),
(593, 2, 1583152916, NULL, 'jabberusername', '', NULL),
(594, 2, 1583152916, NULL, 'jabberpassword', '', NULL),
(595, 2, 1583152916, NULL, 'jabberport', '5222', NULL),
(596, 2, 1583152916, NULL, 'airnotifierurl', 'https://messages.moodle.net', NULL),
(597, 2, 1583152916, NULL, 'airnotifierport', '443', NULL),
(598, 2, 1583152917, NULL, 'airnotifiermobileappname', 'com.moodle.moodlemobile', NULL),
(599, 2, 1583152917, NULL, 'airnotifierappname', 'commoodlemoodlemobile', NULL),
(600, 2, 1583152917, NULL, 'airnotifieraccesskey', '', NULL),
(601, 2, 1583152917, 'assign', 'feedback_plugin_for_gradebook', 'assignfeedback_comments', NULL),
(602, 2, 1583152917, 'assign', 'showrecentsubmissions', '0', NULL),
(603, 2, 1583152917, 'assign', 'submissionreceipts', '1', NULL),
(604, 2, 1583152917, 'assign', 'submissionstatement', 'This submission is my own work, except where I have acknowledged the use of the works of other people.', NULL),
(605, 2, 1583152917, 'assign', 'submissionstatementteamsubmission', 'This submission is the work of my group, except where we have acknowledged the use of the works of other people.', NULL),
(606, 2, 1583152917, 'assign', 'submissionstatementteamsubmissionallsubmit', 'This submission is my own work as a group member, except where I have acknowledged the use of the works of other people.', NULL),
(607, 2, 1583152917, 'assign', 'maxperpage', '-1', NULL),
(608, 2, 1583152917, 'assign', 'alwaysshowdescription', '1', NULL),
(609, 2, 1583152917, 'assign', 'alwaysshowdescription_adv', '', NULL),
(610, 2, 1583152917, 'assign', 'alwaysshowdescription_locked', '', NULL),
(611, 2, 1583152917, 'assign', 'allowsubmissionsfromdate', '0', NULL),
(612, 2, 1583152917, 'assign', 'allowsubmissionsfromdate_enabled', '1', NULL),
(613, 2, 1583152917, 'assign', 'allowsubmissionsfromdate_adv', '', NULL),
(614, 2, 1583152917, 'assign', 'duedate', '604800', NULL),
(615, 2, 1583152917, 'assign', 'duedate_enabled', '1', NULL),
(616, 2, 1583152917, 'assign', 'duedate_adv', '', NULL),
(617, 2, 1583152917, 'assign', 'cutoffdate', '1209600', NULL),
(618, 2, 1583152918, 'assign', 'cutoffdate_enabled', '', NULL),
(619, 2, 1583152918, 'assign', 'cutoffdate_adv', '', NULL),
(620, 2, 1583152918, 'assign', 'gradingduedate', '1209600', NULL),
(621, 2, 1583152918, 'assign', 'gradingduedate_enabled', '1', NULL),
(622, 2, 1583152918, 'assign', 'gradingduedate_adv', '', NULL),
(623, 2, 1583152918, 'assign', 'submissiondrafts', '0', NULL),
(624, 2, 1583152918, 'assign', 'submissiondrafts_adv', '', NULL),
(625, 2, 1583152918, 'assign', 'submissiondrafts_locked', '', NULL),
(626, 2, 1583152918, 'assign', 'requiresubmissionstatement', '0', NULL),
(627, 2, 1583152918, 'assign', 'requiresubmissionstatement_adv', '', NULL),
(628, 2, 1583152918, 'assign', 'requiresubmissionstatement_locked', '', NULL),
(629, 2, 1583152918, 'assign', 'attemptreopenmethod', 'none', NULL),
(630, 2, 1583152918, 'assign', 'attemptreopenmethod_adv', '', NULL),
(631, 2, 1583152918, 'assign', 'attemptreopenmethod_locked', '', NULL),
(632, 2, 1583152918, 'assign', 'maxattempts', '-1', NULL),
(633, 2, 1583152918, 'assign', 'maxattempts_adv', '', NULL),
(634, 2, 1583152918, 'assign', 'maxattempts_locked', '', NULL),
(635, 2, 1583152918, 'assign', 'teamsubmission', '0', NULL),
(636, 2, 1583152918, 'assign', 'teamsubmission_adv', '', NULL),
(637, 2, 1583152918, 'assign', 'teamsubmission_locked', '', NULL),
(638, 2, 1583152918, 'assign', 'preventsubmissionnotingroup', '0', NULL),
(639, 2, 1583152918, 'assign', 'preventsubmissionnotingroup_adv', '', NULL),
(640, 2, 1583152919, 'assign', 'preventsubmissionnotingroup_locked', '', NULL),
(641, 2, 1583152919, 'assign', 'requireallteammemberssubmit', '0', NULL),
(642, 2, 1583152919, 'assign', 'requireallteammemberssubmit_adv', '', NULL),
(643, 2, 1583152919, 'assign', 'requireallteammemberssubmit_locked', '', NULL),
(644, 2, 1583152919, 'assign', 'teamsubmissiongroupingid', '', NULL),
(645, 2, 1583152919, 'assign', 'teamsubmissiongroupingid_adv', '', NULL),
(646, 2, 1583152919, 'assign', 'sendnotifications', '0', NULL),
(647, 2, 1583152919, 'assign', 'sendnotifications_adv', '', NULL),
(648, 2, 1583152919, 'assign', 'sendnotifications_locked', '', NULL),
(649, 2, 1583152919, 'assign', 'sendlatenotifications', '0', NULL),
(650, 2, 1583152919, 'assign', 'sendlatenotifications_adv', '', NULL),
(651, 2, 1583152919, 'assign', 'sendlatenotifications_locked', '', NULL),
(652, 2, 1583152919, 'assign', 'sendstudentnotifications', '1', NULL),
(653, 2, 1583152919, 'assign', 'sendstudentnotifications_adv', '', NULL),
(654, 2, 1583152919, 'assign', 'sendstudentnotifications_locked', '', NULL),
(655, 2, 1583152919, 'assign', 'blindmarking', '0', NULL),
(656, 2, 1583152919, 'assign', 'blindmarking_adv', '', NULL),
(657, 2, 1583152919, 'assign', 'blindmarking_locked', '', NULL),
(658, 2, 1583152919, 'assign', 'hidegrader', '0', NULL),
(659, 2, 1583152919, 'assign', 'hidegrader_adv', '', NULL),
(660, 2, 1583152919, 'assign', 'hidegrader_locked', '', NULL),
(661, 2, 1583152919, 'assign', 'markingworkflow', '0', NULL),
(662, 2, 1583152919, 'assign', 'markingworkflow_adv', '', NULL),
(663, 2, 1583152919, 'assign', 'markingworkflow_locked', '', NULL),
(664, 2, 1583152920, 'assign', 'markingallocation', '0', NULL),
(665, 2, 1583152920, 'assign', 'markingallocation_adv', '', NULL),
(666, 2, 1583152920, 'assign', 'markingallocation_locked', '', NULL),
(667, 2, 1583152920, 'assignsubmission_file', 'default', '1', NULL),
(668, 2, 1583152920, 'assignsubmission_file', 'maxfiles', '20', NULL),
(669, 2, 1583152920, 'assignsubmission_file', 'filetypes', '', NULL),
(670, 2, 1583152920, 'assignsubmission_file', 'maxbytes', '0', NULL),
(671, 2, 1583152920, 'assignsubmission_onlinetext', 'default', '0', NULL),
(672, 2, 1583152920, 'assignfeedback_comments', 'default', '1', NULL),
(673, 2, 1583152920, 'assignfeedback_comments', 'inline', '0', NULL),
(674, 2, 1583152920, 'assignfeedback_comments', 'inline_adv', '', NULL),
(675, 2, 1583152920, 'assignfeedback_comments', 'inline_locked', '', NULL),
(676, 2, 1583152920, 'assignfeedback_editpdf', 'default', '1', NULL),
(677, 2, 1583152920, 'assignfeedback_editpdf', 'stamps', '/cross.png', NULL),
(678, 2, 1583152920, 'assignfeedback_file', 'default', '0', NULL),
(679, 2, 1583152920, 'assignfeedback_offline', 'default', '0', NULL),
(680, 2, 1583152920, 'book', 'numberingoptions', '0,1,2,3', NULL),
(681, 2, 1583152920, 'book', 'navoptions', '0,1,2', NULL),
(682, 2, 1583152920, 'book', 'numbering', '1', NULL),
(683, 2, 1583152920, 'book', 'navstyle', '1', NULL),
(684, 2, 1583152920, NULL, 'chat_method', 'ajax', NULL),
(685, 2, 1583152921, NULL, 'chat_refresh_userlist', '10', NULL),
(686, 2, 1583152921, NULL, 'chat_old_ping', '35', NULL),
(687, 2, 1583152921, NULL, 'chat_refresh_room', '5', NULL),
(688, 2, 1583152921, NULL, 'chat_normal_updatemode', 'jsupdate', NULL),
(689, 2, 1583152921, NULL, 'chat_serverhost', 'learnuat.zinghr.com', NULL),
(690, 2, 1583152921, NULL, 'chat_serverip', '127.0.0.1', NULL),
(691, 2, 1583152921, NULL, 'chat_serverport', '9111', NULL),
(692, 2, 1583152921, NULL, 'chat_servermax', '100', NULL),
(693, 2, 1583152921, NULL, 'data_enablerssfeeds', '0', NULL),
(694, 2, 1583152921, NULL, 'feedback_allowfullanonymous', '0', NULL),
(695, 2, 1583152921, 'resource', 'framesize', '130', NULL),
(696, 2, 1583152921, 'resource', 'displayoptions', '0,1,4,5,6', NULL),
(697, 2, 1583152921, 'resource', 'printintro', '1', NULL),
(698, 2, 1583152921, 'resource', 'display', '0', NULL);
INSERT INTO `mdl_config_log` (`id`, `userid`, `timemodified`, `plugin`, `name`, `value`, `oldvalue`) VALUES
(699, 2, 1583152921, 'resource', 'showsize', '0', NULL),
(700, 2, 1583152921, 'resource', 'showtype', '0', NULL),
(701, 2, 1583152921, 'resource', 'showdate', '0', NULL),
(702, 2, 1583152921, 'resource', 'popupwidth', '620', NULL),
(703, 2, 1583152921, 'resource', 'popupheight', '450', NULL),
(704, 2, 1583152921, 'resource', 'filterfiles', '0', NULL),
(705, 2, 1583152922, 'folder', 'showexpanded', '1', NULL),
(706, 2, 1583152922, 'folder', 'maxsizetodownload', '0', NULL),
(707, 2, 1583152922, NULL, 'forum_displaymode', '3', NULL),
(708, 2, 1583152922, NULL, 'forum_shortpost', '300', NULL),
(709, 2, 1583152922, NULL, 'forum_longpost', '600', NULL),
(710, 2, 1583152922, NULL, 'forum_manydiscussions', '100', NULL),
(711, 2, 1583152922, NULL, 'forum_maxbytes', '512000', NULL),
(712, 2, 1583152922, NULL, 'forum_maxattachments', '9', NULL),
(713, 2, 1583152922, NULL, 'forum_subscription', '0', NULL),
(714, 2, 1583152922, NULL, 'forum_trackingtype', '1', NULL),
(715, 2, 1583152922, NULL, 'forum_trackreadposts', '1', NULL),
(716, 2, 1583152922, NULL, 'forum_allowforcedreadtracking', '0', NULL),
(717, 2, 1583152922, NULL, 'forum_oldpostdays', '14', NULL),
(718, 2, 1583152922, NULL, 'forum_usermarksread', '0', NULL),
(719, 2, 1583152922, NULL, 'forum_cleanreadtime', '2', NULL),
(720, 2, 1583152922, NULL, 'digestmailtime', '17', NULL),
(721, 2, 1583152922, NULL, 'forum_enablerssfeeds', '0', NULL),
(722, 2, 1583152922, NULL, 'forum_enabletimedposts', '1', NULL),
(723, 2, 1583152922, NULL, 'glossary_entbypage', '10', NULL),
(724, 2, 1583152922, NULL, 'glossary_dupentries', '0', NULL),
(725, 2, 1583152922, NULL, 'glossary_allowcomments', '0', NULL),
(726, 2, 1583152923, NULL, 'glossary_linkbydefault', '1', NULL),
(727, 2, 1583152923, NULL, 'glossary_defaultapproval', '1', NULL),
(728, 2, 1583152923, NULL, 'glossary_enablerssfeeds', '0', NULL),
(729, 2, 1583152923, NULL, 'glossary_linkentries', '0', NULL),
(730, 2, 1583152923, NULL, 'glossary_casesensitive', '0', NULL),
(731, 2, 1583152923, NULL, 'glossary_fullmatch', '0', NULL),
(732, 2, 1583152923, 'imscp', 'keepold', '1', NULL),
(733, 2, 1583152923, 'imscp', 'keepold_adv', '', NULL),
(734, 2, 1583152923, 'label', 'dndmedia', '1', NULL),
(735, 2, 1583152923, 'label', 'dndresizewidth', '400', NULL),
(736, 2, 1583152923, 'label', 'dndresizeheight', '400', NULL),
(737, 2, 1583152923, 'mod_lesson', 'mediafile', '', NULL),
(738, 2, 1583152923, 'mod_lesson', 'mediafile_adv', '1', NULL),
(739, 2, 1583152923, 'mod_lesson', 'mediawidth', '640', NULL),
(740, 2, 1583152923, 'mod_lesson', 'mediaheight', '480', NULL),
(741, 2, 1583152923, 'mod_lesson', 'mediaclose', '0', NULL),
(742, 2, 1583152923, 'mod_lesson', 'progressbar', '0', NULL),
(743, 2, 1583152923, 'mod_lesson', 'progressbar_adv', '', NULL),
(744, 2, 1583152923, 'mod_lesson', 'ongoing', '0', NULL),
(745, 2, 1583152924, 'mod_lesson', 'ongoing_adv', '1', NULL),
(746, 2, 1583152924, 'mod_lesson', 'displayleftmenu', '0', NULL),
(747, 2, 1583152924, 'mod_lesson', 'displayleftmenu_adv', '', NULL),
(748, 2, 1583152924, 'mod_lesson', 'displayleftif', '0', NULL),
(749, 2, 1583152924, 'mod_lesson', 'displayleftif_adv', '1', NULL),
(750, 2, 1583152924, 'mod_lesson', 'slideshow', '0', NULL),
(751, 2, 1583152924, 'mod_lesson', 'slideshow_adv', '1', NULL),
(752, 2, 1583152924, 'mod_lesson', 'slideshowwidth', '640', NULL),
(753, 2, 1583152924, 'mod_lesson', 'slideshowheight', '480', NULL),
(754, 2, 1583152924, 'mod_lesson', 'slideshowbgcolor', '#FFFFFF', NULL),
(755, 2, 1583152924, 'mod_lesson', 'maxanswers', '5', NULL),
(756, 2, 1583152924, 'mod_lesson', 'maxanswers_adv', '1', NULL),
(757, 2, 1583152924, 'mod_lesson', 'defaultfeedback', '0', NULL),
(758, 2, 1583152924, 'mod_lesson', 'defaultfeedback_adv', '1', NULL),
(759, 2, 1583152924, 'mod_lesson', 'activitylink', '', NULL),
(760, 2, 1583152924, 'mod_lesson', 'activitylink_adv', '1', NULL),
(761, 2, 1583152924, 'mod_lesson', 'timelimit', '0', NULL),
(762, 2, 1583152924, 'mod_lesson', 'timelimit_adv', '', NULL),
(763, 2, 1583152924, 'mod_lesson', 'password', '0', NULL),
(764, 2, 1583152924, 'mod_lesson', 'password_adv', '1', NULL),
(765, 2, 1583152924, 'mod_lesson', 'modattempts', '0', NULL),
(766, 2, 1583152924, 'mod_lesson', 'modattempts_adv', '', NULL),
(767, 2, 1583152924, 'mod_lesson', 'displayreview', '0', NULL),
(768, 2, 1583152924, 'mod_lesson', 'displayreview_adv', '', NULL),
(769, 2, 1583152925, 'mod_lesson', 'maximumnumberofattempts', '1', NULL),
(770, 2, 1583152925, 'mod_lesson', 'maximumnumberofattempts_adv', '', NULL),
(771, 2, 1583152925, 'mod_lesson', 'defaultnextpage', '0', NULL),
(772, 2, 1583152925, 'mod_lesson', 'defaultnextpage_adv', '1', NULL),
(773, 2, 1583152925, 'mod_lesson', 'numberofpagestoshow', '1', NULL),
(774, 2, 1583152925, 'mod_lesson', 'numberofpagestoshow_adv', '1', NULL),
(775, 2, 1583152925, 'mod_lesson', 'practice', '0', NULL),
(776, 2, 1583152925, 'mod_lesson', 'practice_adv', '', NULL),
(777, 2, 1583152925, 'mod_lesson', 'customscoring', '1', NULL),
(778, 2, 1583152925, 'mod_lesson', 'customscoring_adv', '1', NULL),
(779, 2, 1583152925, 'mod_lesson', 'retakesallowed', '0', NULL),
(780, 2, 1583152925, 'mod_lesson', 'retakesallowed_adv', '', NULL),
(781, 2, 1583152925, 'mod_lesson', 'handlingofretakes', '0', NULL),
(782, 2, 1583152925, 'mod_lesson', 'handlingofretakes_adv', '1', NULL),
(783, 2, 1583152925, 'mod_lesson', 'minimumnumberofquestions', '0', NULL),
(784, 2, 1583152925, 'mod_lesson', 'minimumnumberofquestions_adv', '1', NULL),
(785, 2, 1583152925, 'page', 'displayoptions', '5', NULL),
(786, 2, 1583152925, 'page', 'printheading', '1', NULL),
(787, 2, 1583152925, 'page', 'printintro', '0', NULL),
(788, 2, 1583152925, 'page', 'printlastmodified', '1', NULL),
(789, 2, 1583152925, 'page', 'display', '5', NULL),
(790, 2, 1583152925, 'page', 'popupwidth', '620', NULL),
(791, 2, 1583152926, 'page', 'popupheight', '450', NULL),
(792, 2, 1583152926, 'quiz', 'timelimit', '0', NULL),
(793, 2, 1583152926, 'quiz', 'timelimit_adv', '', NULL),
(794, 2, 1583152926, 'quiz', 'overduehandling', 'autosubmit', NULL),
(795, 2, 1583152926, 'quiz', 'overduehandling_adv', '', NULL),
(796, 2, 1583152926, 'quiz', 'graceperiod', '86400', NULL),
(797, 2, 1583152926, 'quiz', 'graceperiod_adv', '', NULL),
(798, 2, 1583152926, 'quiz', 'graceperiodmin', '60', NULL),
(799, 2, 1583152926, 'quiz', 'attempts', '0', NULL),
(800, 2, 1583152926, 'quiz', 'attempts_adv', '', NULL),
(801, 2, 1583152926, 'quiz', 'grademethod', '1', NULL),
(802, 2, 1583152926, 'quiz', 'grademethod_adv', '', NULL),
(803, 2, 1583152926, 'quiz', 'maximumgrade', '10', NULL),
(804, 2, 1583152926, 'quiz', 'questionsperpage', '1', NULL),
(805, 2, 1583152926, 'quiz', 'questionsperpage_adv', '', NULL),
(806, 2, 1583152926, 'quiz', 'navmethod', 'free', NULL),
(807, 2, 1583152926, 'quiz', 'navmethod_adv', '1', NULL),
(808, 2, 1583152926, 'quiz', 'shuffleanswers', '1', NULL),
(809, 2, 1583152926, 'quiz', 'shuffleanswers_adv', '', NULL),
(810, 2, 1583152926, 'quiz', 'preferredbehaviour', 'deferredfeedback', NULL),
(811, 2, 1583152926, 'quiz', 'canredoquestions', '0', NULL),
(812, 2, 1583152926, 'quiz', 'canredoquestions_adv', '1', NULL),
(813, 2, 1583152926, 'quiz', 'attemptonlast', '0', NULL),
(814, 2, 1583152926, 'quiz', 'attemptonlast_adv', '1', NULL),
(815, 2, 1583152927, 'quiz', 'reviewattempt', '69904', NULL),
(816, 2, 1583152927, 'quiz', 'reviewcorrectness', '69904', NULL),
(817, 2, 1583152927, 'quiz', 'reviewmarks', '69904', NULL),
(818, 2, 1583152927, 'quiz', 'reviewspecificfeedback', '69904', NULL),
(819, 2, 1583152927, 'quiz', 'reviewgeneralfeedback', '69904', NULL),
(820, 2, 1583152927, 'quiz', 'reviewrightanswer', '69904', NULL),
(821, 2, 1583152927, 'quiz', 'reviewoverallfeedback', '4368', NULL),
(822, 2, 1583152927, 'quiz', 'showuserpicture', '0', NULL),
(823, 2, 1583152927, 'quiz', 'showuserpicture_adv', '', NULL),
(824, 2, 1583152927, 'quiz', 'decimalpoints', '2', NULL),
(825, 2, 1583152927, 'quiz', 'decimalpoints_adv', '', NULL),
(826, 2, 1583152927, 'quiz', 'questiondecimalpoints', '-1', NULL),
(827, 2, 1583152927, 'quiz', 'questiondecimalpoints_adv', '1', NULL),
(828, 2, 1583152927, 'quiz', 'showblocks', '0', NULL),
(829, 2, 1583152927, 'quiz', 'showblocks_adv', '1', NULL),
(830, 2, 1583152927, 'quiz', 'password', '', NULL),
(831, 2, 1583152927, 'quiz', 'password_adv', '', NULL),
(832, 2, 1583152927, 'quiz', 'subnet', '', NULL),
(833, 2, 1583152927, 'quiz', 'subnet_adv', '1', NULL),
(834, 2, 1583152928, 'quiz', 'delay1', '0', NULL),
(835, 2, 1583152928, 'quiz', 'delay1_adv', '1', NULL),
(836, 2, 1583152928, 'quiz', 'delay2', '0', NULL),
(837, 2, 1583152928, 'quiz', 'delay2_adv', '1', NULL),
(838, 2, 1583152928, 'quiz', 'browsersecurity', '-', NULL),
(839, 2, 1583152928, 'quiz', 'browsersecurity_adv', '1', NULL),
(840, 2, 1583152928, 'quiz', 'initialnumfeedbacks', '2', NULL),
(841, 2, 1583152928, 'quiz', 'autosaveperiod', '60', NULL),
(842, 2, 1583152928, 'scorm', 'displaycoursestructure', '0', NULL),
(843, 2, 1583152928, 'scorm', 'displaycoursestructure_adv', '', NULL),
(844, 2, 1583152928, 'scorm', 'popup', '0', NULL),
(845, 2, 1583152928, 'scorm', 'popup_adv', '', NULL),
(846, 2, 1583152928, 'scorm', 'displayactivityname', '1', NULL),
(847, 2, 1583152928, 'scorm', 'framewidth', '100', NULL),
(848, 2, 1583152928, 'scorm', 'framewidth_adv', '1', NULL),
(849, 2, 1583152928, 'scorm', 'frameheight', '500', NULL),
(850, 2, 1583152928, 'scorm', 'frameheight_adv', '1', NULL),
(851, 2, 1583152928, 'scorm', 'winoptgrp_adv', '1', NULL),
(852, 2, 1583152928, 'scorm', 'scrollbars', '0', NULL),
(853, 2, 1583152928, 'scorm', 'directories', '0', NULL),
(854, 2, 1583152928, 'scorm', 'location', '0', NULL),
(855, 2, 1583152928, 'scorm', 'menubar', '0', NULL),
(856, 2, 1583152928, 'scorm', 'toolbar', '0', NULL),
(857, 2, 1583152928, 'scorm', 'status', '0', NULL),
(858, 2, 1583152929, 'scorm', 'skipview', '0', NULL),
(859, 2, 1583152929, 'scorm', 'skipview_adv', '1', NULL),
(860, 2, 1583152929, 'scorm', 'hidebrowse', '0', NULL),
(861, 2, 1583152929, 'scorm', 'hidebrowse_adv', '1', NULL),
(862, 2, 1583152929, 'scorm', 'hidetoc', '0', NULL),
(863, 2, 1583152929, 'scorm', 'hidetoc_adv', '1', NULL),
(864, 2, 1583152929, 'scorm', 'nav', '1', NULL),
(865, 2, 1583152929, 'scorm', 'nav_adv', '1', NULL),
(866, 2, 1583152929, 'scorm', 'navpositionleft', '-100', NULL),
(867, 2, 1583152929, 'scorm', 'navpositionleft_adv', '1', NULL),
(868, 2, 1583152929, 'scorm', 'navpositiontop', '-100', NULL),
(869, 2, 1583152929, 'scorm', 'navpositiontop_adv', '1', NULL),
(870, 2, 1583152929, 'scorm', 'collapsetocwinsize', '767', NULL),
(871, 2, 1583152929, 'scorm', 'collapsetocwinsize_adv', '1', NULL),
(872, 2, 1583152929, 'scorm', 'displayattemptstatus', '1', NULL),
(873, 2, 1583152929, 'scorm', 'displayattemptstatus_adv', '', NULL),
(874, 2, 1583152929, 'scorm', 'grademethod', '1', NULL),
(875, 2, 1583152929, 'scorm', 'maxgrade', '100', NULL),
(876, 2, 1583152929, 'scorm', 'maxattempt', '0', NULL),
(877, 2, 1583152929, 'scorm', 'whatgrade', '0', NULL),
(878, 2, 1583152929, 'scorm', 'forcecompleted', '0', NULL),
(879, 2, 1583152929, 'scorm', 'forcenewattempt', '0', NULL),
(880, 2, 1583152929, 'scorm', 'autocommit', '0', NULL),
(881, 2, 1583152929, 'scorm', 'masteryoverride', '1', NULL),
(882, 2, 1583152929, 'scorm', 'lastattemptlock', '0', NULL),
(883, 2, 1583152930, 'scorm', 'auto', '0', NULL),
(884, 2, 1583152930, 'scorm', 'updatefreq', '0', NULL),
(885, 2, 1583152930, 'scorm', 'scormstandard', '0', NULL),
(886, 2, 1583152930, 'scorm', 'allowtypeexternal', '0', NULL),
(887, 2, 1583152930, 'scorm', 'allowtypelocalsync', '0', NULL),
(888, 2, 1583152930, 'scorm', 'allowtypeexternalaicc', '0', NULL),
(889, 2, 1583152930, 'scorm', 'allowaicchacp', '0', NULL),
(890, 2, 1583152930, 'scorm', 'aicchacptimeout', '30', NULL),
(891, 2, 1583152930, 'scorm', 'aicchacpkeepsessiondata', '1', NULL),
(892, 2, 1583152930, 'scorm', 'aiccuserid', '1', NULL),
(893, 2, 1583152930, 'scorm', 'forcejavascript', '1', NULL),
(894, 2, 1583152930, 'scorm', 'allowapidebug', '0', NULL),
(895, 2, 1583152930, 'scorm', 'apidebugmask', '.*', NULL),
(896, 2, 1583152930, 'scorm', 'protectpackagedownloads', '0', NULL),
(897, 2, 1583152930, 'url', 'framesize', '130', NULL),
(898, 2, 1583152930, 'url', 'secretphrase', '', NULL),
(899, 2, 1583152930, 'url', 'rolesinparams', '0', NULL),
(900, 2, 1583152930, 'url', 'displayoptions', '0,1,5,6', NULL),
(901, 2, 1583152930, 'url', 'printintro', '1', NULL),
(902, 2, 1583152930, 'url', 'display', '0', NULL),
(903, 2, 1583152931, 'url', 'popupwidth', '620', NULL),
(904, 2, 1583152931, 'url', 'popupheight', '450', NULL),
(905, 2, 1583152931, 'workshop', 'grade', '80', NULL),
(906, 2, 1583152931, 'workshop', 'gradinggrade', '20', NULL),
(907, 2, 1583152931, 'workshop', 'gradedecimals', '0', NULL),
(908, 2, 1583152931, 'workshop', 'maxbytes', '0', NULL),
(909, 2, 1583152931, 'workshop', 'strategy', 'accumulative', NULL),
(910, 2, 1583152931, 'workshop', 'examplesmode', '0', NULL),
(911, 2, 1583152931, 'workshopallocation_random', 'numofreviews', '5', NULL),
(912, 2, 1583152931, 'workshopform_numerrors', 'grade0', 'No', NULL),
(913, 2, 1583152931, 'workshopform_numerrors', 'grade1', 'Yes', NULL),
(914, 2, 1583152931, 'workshopeval_best', 'comparison', '5', NULL),
(915, 2, 1583152931, 'tool_recyclebin', 'coursebinenable', '1', NULL),
(916, 2, 1583152931, 'tool_recyclebin', 'coursebinexpiry', '604800', NULL),
(917, 2, 1583152931, 'tool_recyclebin', 'categorybinenable', '1', NULL),
(918, 2, 1583152931, 'tool_recyclebin', 'categorybinexpiry', '604800', NULL),
(919, 2, 1583152931, 'tool_recyclebin', 'autohide', '1', NULL),
(920, 2, 1583152931, 'antivirus_clamav', 'runningmethod', 'commandline', NULL),
(921, 2, 1583152931, 'antivirus_clamav', 'pathtoclam', '', NULL),
(922, 2, 1583152931, 'antivirus_clamav', 'pathtounixsocket', '', NULL),
(923, 2, 1583152931, 'antivirus_clamav', 'clamfailureonupload', 'donothing', NULL),
(924, 2, 1583152931, 'auth_cas', 'field_map_firstname', '', NULL),
(925, 2, 1583152931, 'auth_cas', 'field_updatelocal_firstname', 'oncreate', NULL),
(926, 2, 1583152932, 'auth_cas', 'field_updateremote_firstname', '0', NULL),
(927, 2, 1583152932, 'auth_cas', 'field_lock_firstname', 'unlocked', NULL),
(928, 2, 1583152932, 'auth_cas', 'field_map_lastname', '', NULL),
(929, 2, 1583152932, 'auth_cas', 'field_updatelocal_lastname', 'oncreate', NULL),
(930, 2, 1583152932, 'auth_cas', 'field_updateremote_lastname', '0', NULL),
(931, 2, 1583152932, 'auth_cas', 'field_lock_lastname', 'unlocked', NULL),
(932, 2, 1583152932, 'auth_cas', 'field_map_email', '', NULL),
(933, 2, 1583152932, 'auth_cas', 'field_updatelocal_email', 'oncreate', NULL),
(934, 2, 1583152932, 'auth_cas', 'field_updateremote_email', '0', NULL),
(935, 2, 1583152932, 'auth_cas', 'field_lock_email', 'unlocked', NULL),
(936, 2, 1583152932, 'auth_cas', 'field_map_city', '', NULL),
(937, 2, 1583152932, 'auth_cas', 'field_updatelocal_city', 'oncreate', NULL),
(938, 2, 1583152932, 'auth_cas', 'field_updateremote_city', '0', NULL),
(939, 2, 1583152932, 'auth_cas', 'field_lock_city', 'unlocked', NULL),
(940, 2, 1583152932, 'auth_cas', 'field_map_country', '', NULL),
(941, 2, 1583152932, 'auth_cas', 'field_updatelocal_country', 'oncreate', NULL),
(942, 2, 1583152932, 'auth_cas', 'field_updateremote_country', '0', NULL),
(943, 2, 1583152932, 'auth_cas', 'field_lock_country', 'unlocked', NULL),
(944, 2, 1583152932, 'auth_cas', 'field_map_lang', '', NULL),
(945, 2, 1583152932, 'auth_cas', 'field_updatelocal_lang', 'oncreate', NULL),
(946, 2, 1583152932, 'auth_cas', 'field_updateremote_lang', '0', NULL),
(947, 2, 1583152932, 'auth_cas', 'field_lock_lang', 'unlocked', NULL),
(948, 2, 1583152933, 'auth_cas', 'field_map_description', '', NULL),
(949, 2, 1583152933, 'auth_cas', 'field_updatelocal_description', 'oncreate', NULL),
(950, 2, 1583152933, 'auth_cas', 'field_updateremote_description', '0', NULL),
(951, 2, 1583152933, 'auth_cas', 'field_lock_description', 'unlocked', NULL),
(952, 2, 1583152933, 'auth_cas', 'field_map_url', '', NULL),
(953, 2, 1583152933, 'auth_cas', 'field_updatelocal_url', 'oncreate', NULL),
(954, 2, 1583152933, 'auth_cas', 'field_updateremote_url', '0', NULL),
(955, 2, 1583152933, 'auth_cas', 'field_lock_url', 'unlocked', NULL),
(956, 2, 1583152933, 'auth_cas', 'field_map_idnumber', '', NULL),
(957, 2, 1583152933, 'auth_cas', 'field_updatelocal_idnumber', 'oncreate', NULL),
(958, 2, 1583152933, 'auth_cas', 'field_updateremote_idnumber', '0', NULL),
(959, 2, 1583152933, 'auth_cas', 'field_lock_idnumber', 'unlocked', NULL),
(960, 2, 1583152933, 'auth_cas', 'field_map_institution', '', NULL),
(961, 2, 1583152933, 'auth_cas', 'field_updatelocal_institution', 'oncreate', NULL),
(962, 2, 1583152933, 'auth_cas', 'field_updateremote_institution', '0', NULL),
(963, 2, 1583152933, 'auth_cas', 'field_lock_institution', 'unlocked', NULL),
(964, 2, 1583152933, 'auth_cas', 'field_map_department', '', NULL),
(965, 2, 1583152933, 'auth_cas', 'field_updatelocal_department', 'oncreate', NULL),
(966, 2, 1583152933, 'auth_cas', 'field_updateremote_department', '0', NULL),
(967, 2, 1583152933, 'auth_cas', 'field_lock_department', 'unlocked', NULL),
(968, 2, 1583152933, 'auth_cas', 'field_map_phone1', '', NULL),
(969, 2, 1583152933, 'auth_cas', 'field_updatelocal_phone1', 'oncreate', NULL),
(970, 2, 1583152933, 'auth_cas', 'field_updateremote_phone1', '0', NULL),
(971, 2, 1583152933, 'auth_cas', 'field_lock_phone1', 'unlocked', NULL),
(972, 2, 1583152933, 'auth_cas', 'field_map_phone2', '', NULL),
(973, 2, 1583152934, 'auth_cas', 'field_updatelocal_phone2', 'oncreate', NULL),
(974, 2, 1583152934, 'auth_cas', 'field_updateremote_phone2', '0', NULL),
(975, 2, 1583152934, 'auth_cas', 'field_lock_phone2', 'unlocked', NULL),
(976, 2, 1583152934, 'auth_cas', 'field_map_address', '', NULL),
(977, 2, 1583152934, 'auth_cas', 'field_updatelocal_address', 'oncreate', NULL),
(978, 2, 1583152934, 'auth_cas', 'field_updateremote_address', '0', NULL),
(979, 2, 1583152934, 'auth_cas', 'field_lock_address', 'unlocked', NULL),
(980, 2, 1583152934, 'auth_cas', 'field_map_firstnamephonetic', '', NULL),
(981, 2, 1583152934, 'auth_cas', 'field_updatelocal_firstnamephonetic', 'oncreate', NULL),
(982, 2, 1583152934, 'auth_cas', 'field_updateremote_firstnamephonetic', '0', NULL),
(983, 2, 1583152934, 'auth_cas', 'field_lock_firstnamephonetic', 'unlocked', NULL),
(984, 2, 1583152934, 'auth_cas', 'field_map_lastnamephonetic', '', NULL),
(985, 2, 1583152934, 'auth_cas', 'field_updatelocal_lastnamephonetic', 'oncreate', NULL),
(986, 2, 1583152934, 'auth_cas', 'field_updateremote_lastnamephonetic', '0', NULL),
(987, 2, 1583152934, 'auth_cas', 'field_lock_lastnamephonetic', 'unlocked', NULL),
(988, 2, 1583152934, 'auth_cas', 'field_map_middlename', '', NULL),
(989, 2, 1583152934, 'auth_cas', 'field_updatelocal_middlename', 'oncreate', NULL),
(990, 2, 1583152934, 'auth_cas', 'field_updateremote_middlename', '0', NULL),
(991, 2, 1583152934, 'auth_cas', 'field_lock_middlename', 'unlocked', NULL),
(992, 2, 1583152934, 'auth_cas', 'field_map_alternatename', '', NULL),
(993, 2, 1583152935, 'auth_cas', 'field_updatelocal_alternatename', 'oncreate', NULL),
(994, 2, 1583152935, 'auth_cas', 'field_updateremote_alternatename', '0', NULL),
(995, 2, 1583152935, 'auth_cas', 'field_lock_alternatename', 'unlocked', NULL),
(996, 2, 1583152935, 'auth_email', 'recaptcha', '0', NULL),
(997, 2, 1583152935, 'auth_email', 'field_lock_firstname', 'unlocked', NULL),
(998, 2, 1583152935, 'auth_email', 'field_lock_lastname', 'unlocked', NULL),
(999, 2, 1583152935, 'auth_email', 'field_lock_email', 'unlocked', NULL),
(1000, 2, 1583152935, 'auth_email', 'field_lock_city', 'unlocked', NULL),
(1001, 2, 1583152935, 'auth_email', 'field_lock_country', 'unlocked', NULL),
(1002, 2, 1583152935, 'auth_email', 'field_lock_lang', 'unlocked', NULL),
(1003, 2, 1583152935, 'auth_email', 'field_lock_description', 'unlocked', NULL),
(1004, 2, 1583152935, 'auth_email', 'field_lock_url', 'unlocked', NULL),
(1005, 2, 1583152935, 'auth_email', 'field_lock_idnumber', 'unlocked', NULL),
(1006, 2, 1583152935, 'auth_email', 'field_lock_institution', 'unlocked', NULL),
(1007, 2, 1583152935, 'auth_email', 'field_lock_department', 'unlocked', NULL),
(1008, 2, 1583152935, 'auth_email', 'field_lock_phone1', 'unlocked', NULL),
(1009, 2, 1583152935, 'auth_email', 'field_lock_phone2', 'unlocked', NULL),
(1010, 2, 1583152935, 'auth_email', 'field_lock_address', 'unlocked', NULL),
(1011, 2, 1583152935, 'auth_email', 'field_lock_firstnamephonetic', 'unlocked', NULL),
(1012, 2, 1583152935, 'auth_email', 'field_lock_lastnamephonetic', 'unlocked', NULL),
(1013, 2, 1583152935, 'auth_email', 'field_lock_middlename', 'unlocked', NULL),
(1014, 2, 1583152935, 'auth_email', 'field_lock_alternatename', 'unlocked', NULL),
(1015, 2, 1583152935, 'auth_db', 'host', '127.0.0.1', NULL),
(1016, 2, 1583152935, 'auth_db', 'type', 'mysqli', NULL),
(1017, 2, 1583152935, 'auth_db', 'sybasequoting', '0', NULL),
(1018, 2, 1583152936, 'auth_db', 'name', '', NULL),
(1019, 2, 1583152936, 'auth_db', 'user', '', NULL),
(1020, 2, 1583152936, 'auth_db', 'pass', '', NULL),
(1021, 2, 1583152936, 'auth_db', 'table', '', NULL),
(1022, 2, 1583152936, 'auth_db', 'fielduser', '', NULL),
(1023, 2, 1583152936, 'auth_db', 'fieldpass', '', NULL),
(1024, 2, 1583152936, 'auth_db', 'passtype', 'plaintext', NULL),
(1025, 2, 1583152936, 'auth_db', 'extencoding', 'utf-8', NULL),
(1026, 2, 1583152936, 'auth_db', 'setupsql', '', NULL),
(1027, 2, 1583152936, 'auth_db', 'debugauthdb', '0', NULL),
(1028, 2, 1583152936, 'auth_db', 'changepasswordurl', '', NULL),
(1029, 2, 1583152936, 'auth_db', 'removeuser', '0', NULL),
(1030, 2, 1583152936, 'auth_db', 'updateusers', '0', NULL),
(1031, 2, 1583152936, 'auth_db', 'field_map_firstname', '', NULL),
(1032, 2, 1583152936, 'auth_db', 'field_updatelocal_firstname', 'oncreate', NULL),
(1033, 2, 1583152936, 'auth_db', 'field_updateremote_firstname', '0', NULL),
(1034, 2, 1583152936, 'auth_db', 'field_lock_firstname', 'unlocked', NULL),
(1035, 2, 1583152936, 'auth_db', 'field_map_lastname', '', NULL),
(1036, 2, 1583152936, 'auth_db', 'field_updatelocal_lastname', 'oncreate', NULL),
(1037, 2, 1583152936, 'auth_db', 'field_updateremote_lastname', '0', NULL),
(1038, 2, 1583152936, 'auth_db', 'field_lock_lastname', 'unlocked', NULL),
(1039, 2, 1583152936, 'auth_db', 'field_map_email', '', NULL),
(1040, 2, 1583152936, 'auth_db', 'field_updatelocal_email', 'oncreate', NULL),
(1041, 2, 1583152937, 'auth_db', 'field_updateremote_email', '0', NULL),
(1042, 2, 1583152937, 'auth_db', 'field_lock_email', 'unlocked', NULL),
(1043, 2, 1583152937, 'auth_db', 'field_map_city', '', NULL),
(1044, 2, 1583152937, 'auth_db', 'field_updatelocal_city', 'oncreate', NULL),
(1045, 2, 1583152937, 'auth_db', 'field_updateremote_city', '0', NULL),
(1046, 2, 1583152937, 'auth_db', 'field_lock_city', 'unlocked', NULL),
(1047, 2, 1583152937, 'auth_db', 'field_map_country', '', NULL),
(1048, 2, 1583152937, 'auth_db', 'field_updatelocal_country', 'oncreate', NULL),
(1049, 2, 1583152937, 'auth_db', 'field_updateremote_country', '0', NULL),
(1050, 2, 1583152937, 'auth_db', 'field_lock_country', 'unlocked', NULL),
(1051, 2, 1583152937, 'auth_db', 'field_map_lang', '', NULL),
(1052, 2, 1583152937, 'auth_db', 'field_updatelocal_lang', 'oncreate', NULL),
(1053, 2, 1583152937, 'auth_db', 'field_updateremote_lang', '0', NULL),
(1054, 2, 1583152937, 'auth_db', 'field_lock_lang', 'unlocked', NULL),
(1055, 2, 1583152937, 'auth_db', 'field_map_description', '', NULL),
(1056, 2, 1583152937, 'auth_db', 'field_updatelocal_description', 'oncreate', NULL),
(1057, 2, 1583152937, 'auth_db', 'field_updateremote_description', '0', NULL),
(1058, 2, 1583152937, 'auth_db', 'field_lock_description', 'unlocked', NULL),
(1059, 2, 1583152937, 'auth_db', 'field_map_url', '', NULL),
(1060, 2, 1583152937, 'auth_db', 'field_updatelocal_url', 'oncreate', NULL),
(1061, 2, 1583152937, 'auth_db', 'field_updateremote_url', '0', NULL),
(1062, 2, 1583152937, 'auth_db', 'field_lock_url', 'unlocked', NULL),
(1063, 2, 1583152937, 'auth_db', 'field_map_idnumber', '', NULL),
(1064, 2, 1583152938, 'auth_db', 'field_updatelocal_idnumber', 'oncreate', NULL),
(1065, 2, 1583152938, 'auth_db', 'field_updateremote_idnumber', '0', NULL),
(1066, 2, 1583152938, 'auth_db', 'field_lock_idnumber', 'unlocked', NULL),
(1067, 2, 1583152938, 'auth_db', 'field_map_institution', '', NULL),
(1068, 2, 1583152938, 'auth_db', 'field_updatelocal_institution', 'oncreate', NULL),
(1069, 2, 1583152938, 'auth_db', 'field_updateremote_institution', '0', NULL),
(1070, 2, 1583152938, 'auth_db', 'field_lock_institution', 'unlocked', NULL),
(1071, 2, 1583152938, 'auth_db', 'field_map_department', '', NULL),
(1072, 2, 1583152938, 'auth_db', 'field_updatelocal_department', 'oncreate', NULL),
(1073, 2, 1583152938, 'auth_db', 'field_updateremote_department', '0', NULL),
(1074, 2, 1583152938, 'auth_db', 'field_lock_department', 'unlocked', NULL),
(1075, 2, 1583152938, 'auth_db', 'field_map_phone1', '', NULL),
(1076, 2, 1583152938, 'auth_db', 'field_updatelocal_phone1', 'oncreate', NULL),
(1077, 2, 1583152938, 'auth_db', 'field_updateremote_phone1', '0', NULL),
(1078, 2, 1583152938, 'auth_db', 'field_lock_phone1', 'unlocked', NULL),
(1079, 2, 1583152938, 'auth_db', 'field_map_phone2', '', NULL),
(1080, 2, 1583152938, 'auth_db', 'field_updatelocal_phone2', 'oncreate', NULL),
(1081, 2, 1583152938, 'auth_db', 'field_updateremote_phone2', '0', NULL),
(1082, 2, 1583152938, 'auth_db', 'field_lock_phone2', 'unlocked', NULL),
(1083, 2, 1583152938, 'auth_db', 'field_map_address', '', NULL),
(1084, 2, 1583152939, 'auth_db', 'field_updatelocal_address', 'oncreate', NULL),
(1085, 2, 1583152939, 'auth_db', 'field_updateremote_address', '0', NULL),
(1086, 2, 1583152939, 'auth_db', 'field_lock_address', 'unlocked', NULL),
(1087, 2, 1583152939, 'auth_db', 'field_map_firstnamephonetic', '', NULL),
(1088, 2, 1583152939, 'auth_db', 'field_updatelocal_firstnamephonetic', 'oncreate', NULL),
(1089, 2, 1583152939, 'auth_db', 'field_updateremote_firstnamephonetic', '0', NULL),
(1090, 2, 1583152939, 'auth_db', 'field_lock_firstnamephonetic', 'unlocked', NULL),
(1091, 2, 1583152939, 'auth_db', 'field_map_lastnamephonetic', '', NULL),
(1092, 2, 1583152939, 'auth_db', 'field_updatelocal_lastnamephonetic', 'oncreate', NULL),
(1093, 2, 1583152939, 'auth_db', 'field_updateremote_lastnamephonetic', '0', NULL),
(1094, 2, 1583152939, 'auth_db', 'field_lock_lastnamephonetic', 'unlocked', NULL),
(1095, 2, 1583152939, 'auth_db', 'field_map_middlename', '', NULL),
(1096, 2, 1583152939, 'auth_db', 'field_updatelocal_middlename', 'oncreate', NULL),
(1097, 2, 1583152939, 'auth_db', 'field_updateremote_middlename', '0', NULL),
(1098, 2, 1583152939, 'auth_db', 'field_lock_middlename', 'unlocked', NULL),
(1099, 2, 1583152939, 'auth_db', 'field_map_alternatename', '', NULL),
(1100, 2, 1583152939, 'auth_db', 'field_updatelocal_alternatename', 'oncreate', NULL),
(1101, 2, 1583152939, 'auth_db', 'field_updateremote_alternatename', '0', NULL),
(1102, 2, 1583152939, 'auth_db', 'field_lock_alternatename', 'unlocked', NULL),
(1103, 2, 1583152939, 'auth_ldap', 'field_map_firstname', '', NULL),
(1104, 2, 1583152939, 'auth_ldap', 'field_updatelocal_firstname', 'oncreate', NULL),
(1105, 2, 1583152939, 'auth_ldap', 'field_updateremote_firstname', '0', NULL),
(1106, 2, 1583152940, 'auth_ldap', 'field_lock_firstname', 'unlocked', NULL),
(1107, 2, 1583152940, 'auth_ldap', 'field_map_lastname', '', NULL),
(1108, 2, 1583152940, 'auth_ldap', 'field_updatelocal_lastname', 'oncreate', NULL),
(1109, 2, 1583152940, 'auth_ldap', 'field_updateremote_lastname', '0', NULL),
(1110, 2, 1583152940, 'auth_ldap', 'field_lock_lastname', 'unlocked', NULL),
(1111, 2, 1583152940, 'auth_ldap', 'field_map_email', '', NULL),
(1112, 2, 1583152940, 'auth_ldap', 'field_updatelocal_email', 'oncreate', NULL),
(1113, 2, 1583152940, 'auth_ldap', 'field_updateremote_email', '0', NULL),
(1114, 2, 1583152940, 'auth_ldap', 'field_lock_email', 'unlocked', NULL),
(1115, 2, 1583152940, 'auth_ldap', 'field_map_city', '', NULL),
(1116, 2, 1583152940, 'auth_ldap', 'field_updatelocal_city', 'oncreate', NULL),
(1117, 2, 1583152940, 'auth_ldap', 'field_updateremote_city', '0', NULL),
(1118, 2, 1583152940, 'auth_ldap', 'field_lock_city', 'unlocked', NULL),
(1119, 2, 1583152940, 'auth_ldap', 'field_map_country', '', NULL),
(1120, 2, 1583152940, 'auth_ldap', 'field_updatelocal_country', 'oncreate', NULL),
(1121, 2, 1583152940, 'auth_ldap', 'field_updateremote_country', '0', NULL),
(1122, 2, 1583152940, 'auth_ldap', 'field_lock_country', 'unlocked', NULL),
(1123, 2, 1583152940, 'auth_ldap', 'field_map_lang', '', NULL),
(1124, 2, 1583152940, 'auth_ldap', 'field_updatelocal_lang', 'oncreate', NULL),
(1125, 2, 1583152940, 'auth_ldap', 'field_updateremote_lang', '0', NULL),
(1126, 2, 1583152940, 'auth_ldap', 'field_lock_lang', 'unlocked', NULL),
(1127, 2, 1583152940, 'auth_ldap', 'field_map_description', '', NULL),
(1128, 2, 1583152941, 'auth_ldap', 'field_updatelocal_description', 'oncreate', NULL),
(1129, 2, 1583152941, 'auth_ldap', 'field_updateremote_description', '0', NULL),
(1130, 2, 1583152941, 'auth_ldap', 'field_lock_description', 'unlocked', NULL),
(1131, 2, 1583152941, 'auth_ldap', 'field_map_url', '', NULL),
(1132, 2, 1583152941, 'auth_ldap', 'field_updatelocal_url', 'oncreate', NULL),
(1133, 2, 1583152941, 'auth_ldap', 'field_updateremote_url', '0', NULL),
(1134, 2, 1583152941, 'auth_ldap', 'field_lock_url', 'unlocked', NULL),
(1135, 2, 1583152941, 'auth_ldap', 'field_map_idnumber', '', NULL),
(1136, 2, 1583152941, 'auth_ldap', 'field_updatelocal_idnumber', 'oncreate', NULL),
(1137, 2, 1583152941, 'auth_ldap', 'field_updateremote_idnumber', '0', NULL),
(1138, 2, 1583152941, 'auth_ldap', 'field_lock_idnumber', 'unlocked', NULL),
(1139, 2, 1583152941, 'auth_ldap', 'field_map_institution', '', NULL),
(1140, 2, 1583152941, 'auth_ldap', 'field_updatelocal_institution', 'oncreate', NULL),
(1141, 2, 1583152941, 'auth_ldap', 'field_updateremote_institution', '0', NULL),
(1142, 2, 1583152941, 'auth_ldap', 'field_lock_institution', 'unlocked', NULL),
(1143, 2, 1583152941, 'auth_ldap', 'field_map_department', '', NULL),
(1144, 2, 1583152941, 'auth_ldap', 'field_updatelocal_department', 'oncreate', NULL),
(1145, 2, 1583152941, 'auth_ldap', 'field_updateremote_department', '0', NULL),
(1146, 2, 1583152941, 'auth_ldap', 'field_lock_department', 'unlocked', NULL),
(1147, 2, 1583152941, 'auth_ldap', 'field_map_phone1', '', NULL),
(1148, 2, 1583152941, 'auth_ldap', 'field_updatelocal_phone1', 'oncreate', NULL),
(1149, 2, 1583152941, 'auth_ldap', 'field_updateremote_phone1', '0', NULL),
(1150, 2, 1583152941, 'auth_ldap', 'field_lock_phone1', 'unlocked', NULL),
(1151, 2, 1583152942, 'auth_ldap', 'field_map_phone2', '', NULL),
(1152, 2, 1583152942, 'auth_ldap', 'field_updatelocal_phone2', 'oncreate', NULL),
(1153, 2, 1583152942, 'auth_ldap', 'field_updateremote_phone2', '0', NULL),
(1154, 2, 1583152942, 'auth_ldap', 'field_lock_phone2', 'unlocked', NULL),
(1155, 2, 1583152942, 'auth_ldap', 'field_map_address', '', NULL),
(1156, 2, 1583152942, 'auth_ldap', 'field_updatelocal_address', 'oncreate', NULL),
(1157, 2, 1583152942, 'auth_ldap', 'field_updateremote_address', '0', NULL),
(1158, 2, 1583152942, 'auth_ldap', 'field_lock_address', 'unlocked', NULL),
(1159, 2, 1583152942, 'auth_ldap', 'field_map_firstnamephonetic', '', NULL),
(1160, 2, 1583152942, 'auth_ldap', 'field_updatelocal_firstnamephonetic', 'oncreate', NULL),
(1161, 2, 1583152942, 'auth_ldap', 'field_updateremote_firstnamephonetic', '0', NULL),
(1162, 2, 1583152942, 'auth_ldap', 'field_lock_firstnamephonetic', 'unlocked', NULL),
(1163, 2, 1583152942, 'auth_ldap', 'field_map_lastnamephonetic', '', NULL),
(1164, 2, 1583152942, 'auth_ldap', 'field_updatelocal_lastnamephonetic', 'oncreate', NULL),
(1165, 2, 1583152942, 'auth_ldap', 'field_updateremote_lastnamephonetic', '0', NULL),
(1166, 2, 1583152942, 'auth_ldap', 'field_lock_lastnamephonetic', 'unlocked', NULL),
(1167, 2, 1583152942, 'auth_ldap', 'field_map_middlename', '', NULL),
(1168, 2, 1583152942, 'auth_ldap', 'field_updatelocal_middlename', 'oncreate', NULL),
(1169, 2, 1583152942, 'auth_ldap', 'field_updateremote_middlename', '0', NULL),
(1170, 2, 1583152942, 'auth_ldap', 'field_lock_middlename', 'unlocked', NULL),
(1171, 2, 1583152942, 'auth_ldap', 'field_map_alternatename', '', NULL),
(1172, 2, 1583152942, 'auth_ldap', 'field_updatelocal_alternatename', 'oncreate', NULL),
(1173, 2, 1583152943, 'auth_ldap', 'field_updateremote_alternatename', '0', NULL),
(1174, 2, 1583152943, 'auth_ldap', 'field_lock_alternatename', 'unlocked', NULL),
(1175, 2, 1583152943, 'auth_manual', 'expiration', '0', NULL),
(1176, 2, 1583152943, 'auth_manual', 'expirationtime', '30', NULL),
(1177, 2, 1583152943, 'auth_manual', 'expiration_warning', '0', NULL),
(1178, 2, 1583152943, 'auth_manual', 'field_lock_firstname', 'unlocked', NULL),
(1179, 2, 1583152943, 'auth_manual', 'field_lock_lastname', 'unlocked', NULL),
(1180, 2, 1583152943, 'auth_manual', 'field_lock_email', 'unlocked', NULL),
(1181, 2, 1583152943, 'auth_manual', 'field_lock_city', 'unlocked', NULL),
(1182, 2, 1583152943, 'auth_manual', 'field_lock_country', 'unlocked', NULL),
(1183, 2, 1583152943, 'auth_manual', 'field_lock_lang', 'unlocked', NULL),
(1184, 2, 1583152943, 'auth_manual', 'field_lock_description', 'unlocked', NULL),
(1185, 2, 1583152943, 'auth_manual', 'field_lock_url', 'unlocked', NULL),
(1186, 2, 1583152943, 'auth_manual', 'field_lock_idnumber', 'unlocked', NULL),
(1187, 2, 1583152943, 'auth_manual', 'field_lock_institution', 'unlocked', NULL),
(1188, 2, 1583152943, 'auth_manual', 'field_lock_department', 'unlocked', NULL),
(1189, 2, 1583152943, 'auth_manual', 'field_lock_phone1', 'unlocked', NULL),
(1190, 2, 1583152943, 'auth_manual', 'field_lock_phone2', 'unlocked', NULL),
(1191, 2, 1583152943, 'auth_manual', 'field_lock_address', 'unlocked', NULL),
(1192, 2, 1583152943, 'auth_manual', 'field_lock_firstnamephonetic', 'unlocked', NULL),
(1193, 2, 1583152943, 'auth_manual', 'field_lock_lastnamephonetic', 'unlocked', NULL),
(1194, 2, 1583152943, 'auth_manual', 'field_lock_middlename', 'unlocked', NULL),
(1195, 2, 1583152943, 'auth_manual', 'field_lock_alternatename', 'unlocked', NULL),
(1196, 2, 1583152943, 'auth_mnet', 'rpc_negotiation_timeout', '30', NULL),
(1197, 2, 1583152943, 'auth_none', 'field_lock_firstname', 'unlocked', NULL),
(1198, 2, 1583152944, 'auth_none', 'field_lock_lastname', 'unlocked', NULL),
(1199, 2, 1583152944, 'auth_none', 'field_lock_email', 'unlocked', NULL),
(1200, 2, 1583152944, 'auth_none', 'field_lock_city', 'unlocked', NULL),
(1201, 2, 1583152944, 'auth_none', 'field_lock_country', 'unlocked', NULL),
(1202, 2, 1583152944, 'auth_none', 'field_lock_lang', 'unlocked', NULL),
(1203, 2, 1583152944, 'auth_none', 'field_lock_description', 'unlocked', NULL),
(1204, 2, 1583152944, 'auth_none', 'field_lock_url', 'unlocked', NULL),
(1205, 2, 1583152944, 'auth_none', 'field_lock_idnumber', 'unlocked', NULL),
(1206, 2, 1583152944, 'auth_none', 'field_lock_institution', 'unlocked', NULL),
(1207, 2, 1583152944, 'auth_none', 'field_lock_department', 'unlocked', NULL),
(1208, 2, 1583152944, 'auth_none', 'field_lock_phone1', 'unlocked', NULL),
(1209, 2, 1583152944, 'auth_none', 'field_lock_phone2', 'unlocked', NULL),
(1210, 2, 1583152944, 'auth_none', 'field_lock_address', 'unlocked', NULL),
(1211, 2, 1583152944, 'auth_none', 'field_lock_firstnamephonetic', 'unlocked', NULL),
(1212, 2, 1583152944, 'auth_none', 'field_lock_lastnamephonetic', 'unlocked', NULL),
(1213, 2, 1583152944, 'auth_none', 'field_lock_middlename', 'unlocked', NULL),
(1214, 2, 1583152944, 'auth_none', 'field_lock_alternatename', 'unlocked', NULL),
(1215, 2, 1583152944, 'auth_oauth2', 'field_lock_firstname', 'unlocked', NULL),
(1216, 2, 1583152944, 'auth_oauth2', 'field_lock_lastname', 'unlocked', NULL),
(1217, 2, 1583152944, 'auth_oauth2', 'field_lock_email', 'unlocked', NULL),
(1218, 2, 1583152944, 'auth_oauth2', 'field_lock_city', 'unlocked', NULL),
(1219, 2, 1583152944, 'auth_oauth2', 'field_lock_country', 'unlocked', NULL),
(1220, 2, 1583152944, 'auth_oauth2', 'field_lock_lang', 'unlocked', NULL),
(1221, 2, 1583152944, 'auth_oauth2', 'field_lock_description', 'unlocked', NULL),
(1222, 2, 1583152945, 'auth_oauth2', 'field_lock_url', 'unlocked', NULL),
(1223, 2, 1583152945, 'auth_oauth2', 'field_lock_idnumber', 'unlocked', NULL),
(1224, 2, 1583152945, 'auth_oauth2', 'field_lock_institution', 'unlocked', NULL),
(1225, 2, 1583152945, 'auth_oauth2', 'field_lock_department', 'unlocked', NULL),
(1226, 2, 1583152945, 'auth_oauth2', 'field_lock_phone1', 'unlocked', NULL),
(1227, 2, 1583152945, 'auth_oauth2', 'field_lock_phone2', 'unlocked', NULL),
(1228, 2, 1583152945, 'auth_oauth2', 'field_lock_address', 'unlocked', NULL),
(1229, 2, 1583152945, 'auth_oauth2', 'field_lock_firstnamephonetic', 'unlocked', NULL),
(1230, 2, 1583152945, 'auth_oauth2', 'field_lock_lastnamephonetic', 'unlocked', NULL),
(1231, 2, 1583152945, 'auth_oauth2', 'field_lock_middlename', 'unlocked', NULL),
(1232, 2, 1583152945, 'auth_oauth2', 'field_lock_alternatename', 'unlocked', NULL),
(1233, 2, 1583152945, 'auth_shibboleth', 'user_attribute', '', NULL),
(1234, 2, 1583152945, 'auth_shibboleth', 'convert_data', '', NULL),
(1235, 2, 1583152945, 'auth_shibboleth', 'alt_login', 'off', NULL),
(1236, 2, 1583152945, 'auth_shibboleth', 'organization_selection', 'urn:mace:organization1:providerID, Example Organization 1\r\n        https://another.idp-id.com/shibboleth, Other Example Organization, /Shibboleth.sso/DS/SWITCHaai\r\n        urn:mace:organization2:providerID, Example Organization 2, /Shibboleth.sso/WAYF/SWITCHaai', NULL),
(1237, 2, 1583152945, 'auth_shibboleth', 'logout_handler', '', NULL),
(1238, 2, 1583152945, 'auth_shibboleth', 'logout_return_url', '', NULL),
(1239, 2, 1583152945, 'auth_shibboleth', 'login_name', 'Shibboleth Login', NULL),
(1240, 2, 1583152945, 'auth_shibboleth', 'auth_logo', '', NULL),
(1241, 2, 1583152945, 'auth_shibboleth', 'auth_instructions', 'Use the <a href=\"https://learnuat.zinghr.com/LMS_2_0/auth/shibboleth/index.php\">Shibboleth login</a> to get access via Shibboleth, if your institution supports it. Otherwise, use the normal login form shown here.', NULL),
(1242, 2, 1583152945, 'auth_shibboleth', 'changepasswordurl', '', NULL),
(1243, 2, 1583152945, 'auth_shibboleth', 'field_map_firstname', '', NULL),
(1244, 2, 1583152945, 'auth_shibboleth', 'field_updatelocal_firstname', 'oncreate', NULL),
(1245, 2, 1583152945, 'auth_shibboleth', 'field_lock_firstname', 'unlocked', NULL),
(1246, 2, 1583152945, 'auth_shibboleth', 'field_map_lastname', '', NULL),
(1247, 2, 1583152946, 'auth_shibboleth', 'field_updatelocal_lastname', 'oncreate', NULL),
(1248, 2, 1583152946, 'auth_shibboleth', 'field_lock_lastname', 'unlocked', NULL),
(1249, 2, 1583152946, 'auth_shibboleth', 'field_map_email', '', NULL),
(1250, 2, 1583152946, 'auth_shibboleth', 'field_updatelocal_email', 'oncreate', NULL),
(1251, 2, 1583152946, 'auth_shibboleth', 'field_lock_email', 'unlocked', NULL),
(1252, 2, 1583152946, 'auth_shibboleth', 'field_map_city', '', NULL),
(1253, 2, 1583152946, 'auth_shibboleth', 'field_updatelocal_city', 'oncreate', NULL),
(1254, 2, 1583152946, 'auth_shibboleth', 'field_lock_city', 'unlocked', NULL),
(1255, 2, 1583152946, 'auth_shibboleth', 'field_map_country', '', NULL),
(1256, 2, 1583152946, 'auth_shibboleth', 'field_updatelocal_country', 'oncreate', NULL),
(1257, 2, 1583152946, 'auth_shibboleth', 'field_lock_country', 'unlocked', NULL),
(1258, 2, 1583152946, 'auth_shibboleth', 'field_map_lang', '', NULL),
(1259, 2, 1583152946, 'auth_shibboleth', 'field_updatelocal_lang', 'oncreate', NULL),
(1260, 2, 1583152946, 'auth_shibboleth', 'field_lock_lang', 'unlocked', NULL),
(1261, 2, 1583152946, 'auth_shibboleth', 'field_map_description', '', NULL),
(1262, 2, 1583152946, 'auth_shibboleth', 'field_updatelocal_description', 'oncreate', NULL),
(1263, 2, 1583152946, 'auth_shibboleth', 'field_lock_description', 'unlocked', NULL),
(1264, 2, 1583152946, 'auth_shibboleth', 'field_map_url', '', NULL),
(1265, 2, 1583152946, 'auth_shibboleth', 'field_updatelocal_url', 'oncreate', NULL),
(1266, 2, 1583152946, 'auth_shibboleth', 'field_lock_url', 'unlocked', NULL),
(1267, 2, 1583152946, 'auth_shibboleth', 'field_map_idnumber', '', NULL),
(1268, 2, 1583152946, 'auth_shibboleth', 'field_updatelocal_idnumber', 'oncreate', NULL),
(1269, 2, 1583152946, 'auth_shibboleth', 'field_lock_idnumber', 'unlocked', NULL),
(1270, 2, 1583152946, 'auth_shibboleth', 'field_map_institution', '', NULL),
(1271, 2, 1583152947, 'auth_shibboleth', 'field_updatelocal_institution', 'oncreate', NULL),
(1272, 2, 1583152947, 'auth_shibboleth', 'field_lock_institution', 'unlocked', NULL),
(1273, 2, 1583152947, 'auth_shibboleth', 'field_map_department', '', NULL),
(1274, 2, 1583152947, 'auth_shibboleth', 'field_updatelocal_department', 'oncreate', NULL),
(1275, 2, 1583152947, 'auth_shibboleth', 'field_lock_department', 'unlocked', NULL),
(1276, 2, 1583152947, 'auth_shibboleth', 'field_map_phone1', '', NULL),
(1277, 2, 1583152947, 'auth_shibboleth', 'field_updatelocal_phone1', 'oncreate', NULL),
(1278, 2, 1583152947, 'auth_shibboleth', 'field_lock_phone1', 'unlocked', NULL),
(1279, 2, 1583152947, 'auth_shibboleth', 'field_map_phone2', '', NULL),
(1280, 2, 1583152947, 'auth_shibboleth', 'field_updatelocal_phone2', 'oncreate', NULL),
(1281, 2, 1583152947, 'auth_shibboleth', 'field_lock_phone2', 'unlocked', NULL),
(1282, 2, 1583152947, 'auth_shibboleth', 'field_map_address', '', NULL),
(1283, 2, 1583152947, 'auth_shibboleth', 'field_updatelocal_address', 'oncreate', NULL),
(1284, 2, 1583152947, 'auth_shibboleth', 'field_lock_address', 'unlocked', NULL),
(1285, 2, 1583152947, 'auth_shibboleth', 'field_map_firstnamephonetic', '', NULL),
(1286, 2, 1583152947, 'auth_shibboleth', 'field_updatelocal_firstnamephonetic', 'oncreate', NULL),
(1287, 2, 1583152947, 'auth_shibboleth', 'field_lock_firstnamephonetic', 'unlocked', NULL),
(1288, 2, 1583152947, 'auth_shibboleth', 'field_map_lastnamephonetic', '', NULL),
(1289, 2, 1583152947, 'auth_shibboleth', 'field_updatelocal_lastnamephonetic', 'oncreate', NULL),
(1290, 2, 1583152947, 'auth_shibboleth', 'field_lock_lastnamephonetic', 'unlocked', NULL),
(1291, 2, 1583152948, 'auth_shibboleth', 'field_map_middlename', '', NULL),
(1292, 2, 1583152948, 'auth_shibboleth', 'field_updatelocal_middlename', 'oncreate', NULL),
(1293, 2, 1583152948, 'auth_shibboleth', 'field_lock_middlename', 'unlocked', NULL),
(1294, 2, 1583152948, 'auth_shibboleth', 'field_map_alternatename', '', NULL),
(1295, 2, 1583152948, 'auth_shibboleth', 'field_updatelocal_alternatename', 'oncreate', NULL),
(1296, 2, 1583152948, 'auth_shibboleth', 'field_lock_alternatename', 'unlocked', NULL),
(1297, 2, 1583152948, 'block_activity_results', 'config_showbest', '3', NULL),
(1298, 2, 1583152948, 'block_activity_results', 'config_showbest_locked', '', NULL),
(1299, 2, 1583152948, 'block_activity_results', 'config_showworst', '0', NULL),
(1300, 2, 1583152948, 'block_activity_results', 'config_showworst_locked', '', NULL),
(1301, 2, 1583152948, 'block_activity_results', 'config_usegroups', '0', NULL),
(1302, 2, 1583152948, 'block_activity_results', 'config_usegroups_locked', '', NULL),
(1303, 2, 1583152948, 'block_activity_results', 'config_nameformat', '1', NULL),
(1304, 2, 1583152948, 'block_activity_results', 'config_nameformat_locked', '', NULL),
(1305, 2, 1583152948, 'block_activity_results', 'config_gradeformat', '1', NULL),
(1306, 2, 1583152948, 'block_activity_results', 'config_gradeformat_locked', '', NULL),
(1307, 2, 1583152948, 'block_activity_results', 'config_decimalpoints', '2', NULL),
(1308, 2, 1583152948, 'block_activity_results', 'config_decimalpoints_locked', '', NULL),
(1309, 2, 1583152948, 'block_configurable_reports', 'dbhost', '', NULL),
(1310, 2, 1583152948, 'block_configurable_reports', 'dbname', '', NULL),
(1311, 2, 1583152948, 'block_configurable_reports', 'dbuser', '', NULL),
(1312, 2, 1583152948, 'block_configurable_reports', 'dbpass', '', NULL),
(1313, 2, 1583152948, 'block_configurable_reports', 'cron_hour', '0', NULL),
(1314, 2, 1583152949, 'block_configurable_reports', 'cron_minute', '0', NULL),
(1315, 2, 1583152949, 'block_configurable_reports', 'sqlsecurity', '1', NULL),
(1316, 2, 1583152949, 'block_configurable_reports', 'crrepository', 'jleyva/moodle-configurable_reports_repository', NULL),
(1317, 2, 1583152949, 'block_configurable_reports', 'sharedsqlrepository', 'jleyva/moodle-custom_sql_report_queries', NULL),
(1318, 2, 1583152949, 'block_configurable_reports', 'sqlsyntaxhighlight', '1', NULL),
(1319, 2, 1583152949, 'block_configurable_reports', 'reporttableui', 'datatables', NULL),
(1320, 2, 1583152949, 'block_configurable_reports', 'reportlimit', '5000', NULL),
(1321, 2, 1583152949, 'block_myoverview', 'displaycategories', '1', NULL),
(1322, 2, 1583152949, 'block_myoverview', 'layouts', 'card,list,summary', NULL),
(1323, 2, 1583152949, 'block_myoverview', 'displaygroupingallincludinghidden', '0', NULL),
(1324, 2, 1583152949, 'block_myoverview', 'displaygroupingall', '1', NULL),
(1325, 2, 1583152949, 'block_myoverview', 'displaygroupinginprogress', '1', NULL),
(1326, 2, 1583152949, 'block_myoverview', 'displaygroupingpast', '1', NULL),
(1327, 2, 1583152949, 'block_myoverview', 'displaygroupingfuture', '1', NULL),
(1328, 2, 1583152949, 'block_myoverview', 'displaygroupingcustomfield', '0', NULL),
(1329, 2, 1583152949, 'block_myoverview', 'customfiltergrouping', '', NULL),
(1330, 2, 1583152949, 'block_myoverview', 'displaygroupingstarred', '1', NULL),
(1331, 2, 1583152949, 'block_myoverview', 'displaygroupinghidden', '1', NULL),
(1332, 2, 1583152949, NULL, 'block_course_list_adminview', 'all', NULL),
(1333, 2, 1583152949, NULL, 'block_course_list_hideallcourseslink', '0', NULL),
(1334, 2, 1583152949, NULL, 'block_html_allowcssclasses', '0', NULL),
(1335, 2, 1583152949, NULL, 'block_online_users_timetosee', '5', NULL),
(1336, 2, 1583152950, NULL, 'block_online_users_onlinestatushiding', '1', NULL),
(1337, 2, 1583152950, 'block_recentlyaccessedcourses', 'displaycategories', '1', NULL),
(1338, 2, 1583152950, NULL, 'block_rss_client_num_entries', '5', NULL),
(1339, 2, 1583152950, NULL, 'block_rss_client_timeout', '30', NULL),
(1340, 2, 1583152950, 'block_section_links', 'numsections1', '22', NULL),
(1341, 2, 1583152950, 'block_section_links', 'incby1', '2', NULL),
(1342, 2, 1583152950, 'block_section_links', 'numsections2', '40', NULL),
(1343, 2, 1583152950, 'block_section_links', 'incby2', '5', NULL),
(1344, 2, 1583152950, 'block_starredcourses', 'displaycategories', '1', NULL),
(1345, 2, 1583152950, 'block_tag_youtube', 'apikey', '', NULL),
(1346, 2, 1583152950, 'format_singleactivity', 'activitytype', 'forum', NULL),
(1347, 2, 1583152950, 'fileconverter_googledrive', 'issuerid', '', NULL),
(1348, 2, 1583152950, NULL, 'pathtounoconv', '/usr/bin/unoconv', NULL),
(1349, 2, 1583152950, 'enrol_cohort', 'roleid', '5', NULL),
(1350, 2, 1583152950, 'enrol_cohort', 'unenrolaction', '0', NULL),
(1351, 2, 1583152950, 'enrol_meta', 'nosyncroleids', '', NULL),
(1352, 2, 1583152950, 'enrol_meta', 'syncall', '1', NULL),
(1353, 2, 1583152950, 'enrol_meta', 'unenrolaction', '3', NULL),
(1354, 2, 1583152950, 'enrol_meta', 'coursesort', 'sortorder', NULL),
(1355, 2, 1583152950, 'enrol_database', 'dbtype', '', NULL),
(1356, 2, 1583152950, 'enrol_database', 'dbhost', 'localhost', NULL),
(1357, 2, 1583152951, 'enrol_database', 'dbuser', '', NULL),
(1358, 2, 1583152951, 'enrol_database', 'dbpass', '', NULL),
(1359, 2, 1583152951, 'enrol_database', 'dbname', '', NULL),
(1360, 2, 1583152951, 'enrol_database', 'dbencoding', 'utf-8', NULL),
(1361, 2, 1583152951, 'enrol_database', 'dbsetupsql', '', NULL),
(1362, 2, 1583152951, 'enrol_database', 'dbsybasequoting', '0', NULL),
(1363, 2, 1583152951, 'enrol_database', 'debugdb', '0', NULL),
(1364, 2, 1583152951, 'enrol_database', 'localcoursefield', 'idnumber', NULL),
(1365, 2, 1583152951, 'enrol_database', 'localuserfield', 'idnumber', NULL),
(1366, 2, 1583152951, 'enrol_database', 'localrolefield', 'shortname', NULL),
(1367, 2, 1583152951, 'enrol_database', 'localcategoryfield', 'id', NULL),
(1368, 2, 1583152951, 'enrol_database', 'remoteenroltable', '', NULL),
(1369, 2, 1583152951, 'enrol_database', 'remotecoursefield', '', NULL),
(1370, 2, 1583152951, 'enrol_database', 'remoteuserfield', '', NULL),
(1371, 2, 1583152951, 'enrol_database', 'remoterolefield', '', NULL),
(1372, 2, 1583152951, 'enrol_database', 'remoteotheruserfield', '', NULL),
(1373, 2, 1583152951, 'enrol_database', 'defaultrole', '5', NULL),
(1374, 2, 1583152951, 'enrol_database', 'ignorehiddencourses', '0', NULL),
(1375, 2, 1583152951, 'enrol_database', 'unenrolaction', '0', NULL),
(1376, 2, 1583152951, 'enrol_database', 'newcoursetable', '', NULL),
(1377, 2, 1583152951, 'enrol_database', 'newcoursefullname', 'fullname', NULL),
(1378, 2, 1583152951, 'enrol_database', 'newcourseshortname', 'shortname', NULL),
(1379, 2, 1583152952, 'enrol_database', 'newcourseidnumber', 'idnumber', NULL),
(1380, 2, 1583152952, 'enrol_database', 'newcoursecategory', '', NULL),
(1381, 2, 1583152952, 'enrol_database', 'defaultcategory', '1', NULL),
(1382, 2, 1583152952, 'enrol_database', 'templatecourse', '', NULL),
(1383, 2, 1583152952, 'enrol_flatfile', 'location', '', NULL),
(1384, 2, 1583152952, 'enrol_flatfile', 'encoding', 'UTF-8', NULL),
(1385, 2, 1583152952, 'enrol_flatfile', 'mailstudents', '0', NULL),
(1386, 2, 1583152952, 'enrol_flatfile', 'mailteachers', '0', NULL),
(1387, 2, 1583152952, 'enrol_flatfile', 'mailadmins', '0', NULL),
(1388, 2, 1583152952, 'enrol_flatfile', 'unenrolaction', '3', NULL),
(1389, 2, 1583152952, 'enrol_flatfile', 'expiredaction', '3', NULL),
(1390, 2, 1583152952, 'enrol_guest', 'requirepassword', '0', NULL),
(1391, 2, 1583152952, 'enrol_guest', 'usepasswordpolicy', '0', NULL),
(1392, 2, 1583152952, 'enrol_guest', 'showhint', '0', NULL),
(1393, 2, 1583152952, 'enrol_guest', 'defaultenrol', '1', NULL),
(1394, 2, 1583152952, 'enrol_guest', 'status', '1', NULL),
(1395, 2, 1583152952, 'enrol_guest', 'status_adv', '', NULL),
(1396, 2, 1583152952, 'enrol_imsenterprise', 'imsfilelocation', '', NULL),
(1397, 2, 1583152952, 'enrol_imsenterprise', 'logtolocation', '', NULL),
(1398, 2, 1583152952, 'enrol_imsenterprise', 'mailadmins', '0', NULL),
(1399, 2, 1583152952, 'enrol_imsenterprise', 'createnewusers', '0', NULL),
(1400, 2, 1583152952, 'enrol_imsenterprise', 'imsupdateusers', '0', NULL),
(1401, 2, 1583152952, 'enrol_imsenterprise', 'imsdeleteusers', '0', NULL),
(1402, 2, 1583152953, 'enrol_imsenterprise', 'fixcaseusernames', '0', NULL),
(1403, 2, 1583152953, 'enrol_imsenterprise', 'fixcasepersonalnames', '0', NULL),
(1404, 2, 1583152953, 'enrol_imsenterprise', 'imssourcedidfallback', '0', NULL),
(1405, 2, 1583152953, 'enrol_imsenterprise', 'imsrolemap01', '5', NULL),
(1406, 2, 1583152953, 'enrol_imsenterprise', 'imsrolemap02', '3', NULL),
(1407, 2, 1583152953, 'enrol_imsenterprise', 'imsrolemap03', '3', NULL);
INSERT INTO `mdl_config_log` (`id`, `userid`, `timemodified`, `plugin`, `name`, `value`, `oldvalue`) VALUES
(1408, 2, 1583152953, 'enrol_imsenterprise', 'imsrolemap04', '5', NULL),
(1409, 2, 1583152953, 'enrol_imsenterprise', 'imsrolemap05', '0', NULL),
(1410, 2, 1583152953, 'enrol_imsenterprise', 'imsrolemap06', '4', NULL),
(1411, 2, 1583152953, 'enrol_imsenterprise', 'imsrolemap07', '0', NULL),
(1412, 2, 1583152953, 'enrol_imsenterprise', 'imsrolemap08', '4', NULL),
(1413, 2, 1583152953, 'enrol_imsenterprise', 'truncatecoursecodes', '0', NULL),
(1414, 2, 1583152953, 'enrol_imsenterprise', 'createnewcourses', '0', NULL),
(1415, 2, 1583152953, 'enrol_imsenterprise', 'updatecourses', '0', NULL),
(1416, 2, 1583152953, 'enrol_imsenterprise', 'createnewcategories', '0', NULL),
(1417, 2, 1583152953, 'enrol_imsenterprise', 'nestedcategories', '0', NULL),
(1418, 2, 1583152953, 'enrol_imsenterprise', 'categoryidnumber', '0', NULL),
(1419, 2, 1583152953, 'enrol_imsenterprise', 'categoryseparator', '', NULL),
(1420, 2, 1583152953, 'enrol_imsenterprise', 'imsunenrol', '0', NULL),
(1421, 2, 1583152953, 'enrol_imsenterprise', 'imscoursemapshortname', 'coursecode', NULL),
(1422, 2, 1583152953, 'enrol_imsenterprise', 'imscoursemapfullname', 'short', NULL),
(1423, 2, 1583152953, 'enrol_imsenterprise', 'imscoursemapsummary', 'ignore', NULL),
(1424, 2, 1583152954, 'enrol_imsenterprise', 'imsrestricttarget', '', NULL),
(1425, 2, 1583152954, 'enrol_imsenterprise', 'imscapitafix', '0', NULL),
(1426, 2, 1583152954, 'enrol_manual', 'expiredaction', '1', NULL),
(1427, 2, 1583152954, 'enrol_manual', 'expirynotifyhour', '6', NULL),
(1428, 2, 1583152954, 'enrol_manual', 'defaultenrol', '1', NULL),
(1429, 2, 1583152954, 'enrol_manual', 'status', '0', NULL),
(1430, 2, 1583152954, 'enrol_manual', 'roleid', '5', NULL),
(1431, 2, 1583152954, 'enrol_manual', 'enrolstart', '4', NULL),
(1432, 2, 1583152954, 'enrol_manual', 'enrolperiod', '0', NULL),
(1433, 2, 1583152954, 'enrol_manual', 'expirynotify', '0', NULL),
(1434, 2, 1583152954, 'enrol_manual', 'expirythreshold', '86400', NULL),
(1435, 2, 1583152954, 'enrol_mnet', 'roleid', '5', NULL),
(1436, 2, 1583152954, 'enrol_mnet', 'roleid_adv', '1', NULL),
(1437, 2, 1583152954, 'enrol_paypal', 'paypalbusiness', '', NULL),
(1438, 2, 1583152954, 'enrol_paypal', 'mailstudents', '0', NULL),
(1439, 2, 1583152954, 'enrol_paypal', 'mailteachers', '0', NULL),
(1440, 2, 1583152954, 'enrol_paypal', 'mailadmins', '0', NULL),
(1441, 2, 1583152954, 'enrol_paypal', 'expiredaction', '3', NULL),
(1442, 2, 1583152954, 'enrol_paypal', 'status', '1', NULL),
(1443, 2, 1583152954, 'enrol_paypal', 'cost', '0', NULL),
(1444, 2, 1583152954, 'enrol_paypal', 'currency', 'USD', NULL),
(1445, 2, 1583152955, 'enrol_paypal', 'roleid', '5', NULL),
(1446, 2, 1583152955, 'enrol_paypal', 'enrolperiod', '0', NULL),
(1447, 2, 1583152955, 'enrol_lti', 'emaildisplay', '2', NULL),
(1448, 2, 1583152955, 'enrol_lti', 'city', '', NULL),
(1449, 2, 1583152955, 'enrol_lti', 'country', '', NULL),
(1450, 2, 1583152955, 'enrol_lti', 'timezone', '99', NULL),
(1451, 2, 1583152955, 'enrol_lti', 'lang', 'en', NULL),
(1452, 2, 1583152955, 'enrol_lti', 'institution', '', NULL),
(1453, 2, 1583152955, 'enrol_self', 'requirepassword', '0', NULL),
(1454, 2, 1583152955, 'enrol_self', 'usepasswordpolicy', '0', NULL),
(1455, 2, 1583152955, 'enrol_self', 'showhint', '0', NULL),
(1456, 2, 1583152955, 'enrol_self', 'expiredaction', '1', NULL),
(1457, 2, 1583152955, 'enrol_self', 'expirynotifyhour', '6', NULL),
(1458, 2, 1583152955, 'enrol_self', 'defaultenrol', '1', NULL),
(1459, 2, 1583152955, 'enrol_self', 'status', '1', NULL),
(1460, 2, 1583152955, 'enrol_self', 'newenrols', '1', NULL),
(1461, 2, 1583152955, 'enrol_self', 'groupkey', '0', NULL),
(1462, 2, 1583152955, 'enrol_self', 'roleid', '5', NULL),
(1463, 2, 1583152955, 'enrol_self', 'enrolperiod', '0', NULL),
(1464, 2, 1583152955, 'enrol_self', 'expirynotify', '0', NULL),
(1465, 2, 1583152955, 'enrol_self', 'expirythreshold', '86400', NULL),
(1466, 2, 1583152955, 'enrol_self', 'longtimenosee', '0', NULL),
(1467, 2, 1583152955, 'enrol_self', 'maxenrolled', '0', NULL),
(1468, 2, 1583152955, 'enrol_self', 'sendcoursewelcomemessage', '1', NULL),
(1469, 2, 1583152956, 'filter_urltolink', 'formats', '0', NULL),
(1470, 2, 1583152956, 'filter_urltolink', 'embedimages', '1', NULL),
(1471, 2, 1583152956, 'filter_emoticon', 'formats', '0,1,4', NULL),
(1472, 2, 1583152956, 'filter_displayh5p', 'allowedsources', 'https://h5p.org/h5p/embed/[id]', NULL),
(1473, 2, 1583152956, 'filter_mathjaxloader', 'httpsurl', 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js', NULL),
(1474, 2, 1583152956, 'filter_mathjaxloader', 'texfiltercompatibility', '0', NULL),
(1475, 2, 1583152956, 'filter_mathjaxloader', 'mathjaxconfig', 'MathJax.Hub.Config({\r\n    config: [\"Accessible.js\", \"Safe.js\"],\r\n    errorSettings: { message: [\"!\"] },\r\n    skipStartupTypeset: true,\r\n    messageStyle: \"none\"\r\n});\r\n', NULL),
(1476, 2, 1583152956, 'filter_mathjaxloader', 'additionaldelimiters', '', NULL),
(1477, 2, 1583152956, NULL, 'filter_multilang_force_old', '0', NULL),
(1478, 2, 1583152956, 'filter_tex', 'latexpreamble', '\\usepackage[latin1]{inputenc}\r\n\\usepackage{amsmath}\r\n\\usepackage{amsfonts}\r\n\\RequirePackage{amsmath,amssymb,latexsym}\r\n', NULL),
(1479, 2, 1583152956, 'filter_tex', 'latexbackground', '#FFFFFF', NULL),
(1480, 2, 1583152956, 'filter_tex', 'density', '120', NULL),
(1481, 2, 1583152956, 'filter_tex', 'pathlatex', '/usr/bin/latex', NULL),
(1482, 2, 1583152956, 'filter_tex', 'pathdvips', '/usr/bin/dvips', NULL),
(1483, 2, 1583152956, 'filter_tex', 'pathconvert', '/usr/bin/convert', NULL),
(1484, 2, 1583152956, 'filter_tex', 'pathdvisvgm', '/usr/bin/dvisvgm', NULL),
(1485, 2, 1583152956, 'filter_tex', 'pathmimetex', '', NULL),
(1486, 2, 1583152957, NULL, 'filter_censor_badwords', '', NULL),
(1487, 2, 1583152957, 'logstore_database', 'dbdriver', '', NULL),
(1488, 2, 1583152957, 'logstore_database', 'dbhost', '', NULL),
(1489, 2, 1583152957, 'logstore_database', 'dbuser', '', NULL),
(1490, 2, 1583152957, 'logstore_database', 'dbpass', '', NULL),
(1491, 2, 1583152957, 'logstore_database', 'dbname', '', NULL),
(1492, 2, 1583152957, 'logstore_database', 'dbtable', '', NULL),
(1493, 2, 1583152957, 'logstore_database', 'dbpersist', '0', NULL),
(1494, 2, 1583152957, 'logstore_database', 'dbsocket', '', NULL),
(1495, 2, 1583152957, 'logstore_database', 'dbport', '', NULL),
(1496, 2, 1583152957, 'logstore_database', 'dbschema', '', NULL),
(1497, 2, 1583152957, 'logstore_database', 'dbcollation', '', NULL),
(1498, 2, 1583152957, 'logstore_database', 'dbhandlesoptions', '0', NULL),
(1499, 2, 1583152957, 'logstore_database', 'buffersize', '50', NULL),
(1500, 2, 1583152957, 'logstore_database', 'jsonformat', '1', NULL),
(1501, 2, 1583152957, 'logstore_database', 'logguests', '0', NULL),
(1502, 2, 1583152957, 'logstore_database', 'includelevels', '1,2,0', NULL),
(1503, 2, 1583152957, 'logstore_database', 'includeactions', 'c,r,u,d', NULL),
(1504, 2, 1583152957, 'logstore_legacy', 'loglegacy', '0', NULL),
(1505, 2, 1583152957, NULL, 'logguests', '1', NULL),
(1506, 2, 1583152957, NULL, 'loglifetime', '0', NULL),
(1507, 2, 1583152958, 'logstore_standard', 'logguests', '1', NULL),
(1508, 2, 1583152958, 'logstore_standard', 'jsonformat', '1', NULL),
(1509, 2, 1583152958, 'logstore_standard', 'loglifetime', '0', NULL),
(1510, 2, 1583152958, 'logstore_standard', 'buffersize', '50', NULL),
(1511, 2, 1583152958, 'mlbackend_python', 'useserver', '0', NULL),
(1512, 2, 1583152958, 'mlbackend_python', 'host', '', NULL),
(1513, 2, 1583152958, 'mlbackend_python', 'port', '0', NULL),
(1514, 2, 1583152958, 'mlbackend_python', 'secure', '0', NULL),
(1515, 2, 1583152958, 'mlbackend_python', 'username', 'default', NULL),
(1516, 2, 1583152958, 'mlbackend_python', 'password', '', NULL),
(1517, 2, 1583152958, 'media_videojs', 'videoextensions', 'html_video,media_source,.f4v,.flv', NULL),
(1518, 2, 1583152958, 'media_videojs', 'audioextensions', 'html_audio', NULL),
(1519, 2, 1583152958, 'media_videojs', 'rtmp', '0', NULL),
(1520, 2, 1583152958, 'media_videojs', 'useflash', '0', NULL),
(1521, 2, 1583152958, 'media_videojs', 'youtube', '1', NULL),
(1522, 2, 1583152958, 'media_videojs', 'videocssclass', 'video-js', NULL),
(1523, 2, 1583152958, 'media_videojs', 'audiocssclass', 'video-js', NULL),
(1524, 2, 1583152958, 'media_videojs', 'limitsize', '1', NULL),
(1525, 2, 1583152958, 'qtype_multichoice', 'answerhowmany', '1', NULL),
(1526, 2, 1583152958, 'qtype_multichoice', 'shuffleanswers', '1', NULL),
(1527, 2, 1583152958, 'qtype_multichoice', 'answernumbering', 'abc', NULL),
(1528, 2, 1583152959, 'editor_atto', 'toolbar', 'collapse = collapse\r\nstyle1 = title, bold, italic\r\nlist = unorderedlist, orderedlist\r\nlinks = link\r\nfiles = image, media, recordrtc, managefiles, h5p\r\nstyle2 = underline, strike, subscript, superscript\r\nalign = align\r\nindent = indent\r\ninsert = equation, charmap, table, clear\r\nundo = undo\r\naccessibility = accessibilitychecker, accessibilityhelper\r\nother = html', NULL),
(1529, 2, 1583152959, 'editor_atto', 'autosavefrequency', '60', NULL),
(1530, 2, 1583152959, 'atto_collapse', 'showgroups', '5', NULL),
(1531, 2, 1583152959, 'atto_equation', 'librarygroup1', '\\cdot\r\n\\times\r\n\\ast\r\n\\div\r\n\\diamond\r\n\\pm\r\n\\mp\r\n\\oplus\r\n\\ominus\r\n\\otimes\r\n\\oslash\r\n\\odot\r\n\\circ\r\n\\bullet\r\n\\asymp\r\n\\equiv\r\n\\subseteq\r\n\\supseteq\r\n\\leq\r\n\\geq\r\n\\preceq\r\n\\succeq\r\n\\sim\r\n\\simeq\r\n\\approx\r\n\\subset\r\n\\supset\r\n\\ll\r\n\\gg\r\n\\prec\r\n\\succ\r\n\\infty\r\n\\in\r\n\\ni\r\n\\forall\r\n\\exists\r\n\\neq\r\n', NULL),
(1532, 2, 1583152959, 'atto_equation', 'librarygroup2', '\\leftarrow\r\n\\rightarrow\r\n\\uparrow\r\n\\downarrow\r\n\\leftrightarrow\r\n\\nearrow\r\n\\searrow\r\n\\swarrow\r\n\\nwarrow\r\n\\Leftarrow\r\n\\Rightarrow\r\n\\Uparrow\r\n\\Downarrow\r\n\\Leftrightarrow\r\n', NULL),
(1533, 2, 1583152959, 'atto_equation', 'librarygroup3', '\\alpha\r\n\\beta\r\n\\gamma\r\n\\delta\r\n\\epsilon\r\n\\zeta\r\n\\eta\r\n\\theta\r\n\\iota\r\n\\kappa\r\n\\lambda\r\n\\mu\r\n\\nu\r\n\\xi\r\n\\pi\r\n\\rho\r\n\\sigma\r\n\\tau\r\n\\upsilon\r\n\\phi\r\n\\chi\r\n\\psi\r\n\\omega\r\n\\Gamma\r\n\\Delta\r\n\\Theta\r\n\\Lambda\r\n\\Xi\r\n\\Pi\r\n\\Sigma\r\n\\Upsilon\r\n\\Phi\r\n\\Psi\r\n\\Omega\r\n', NULL),
(1534, 2, 1583152959, 'atto_equation', 'librarygroup4', '\\sum{a,b}\r\n\\sqrt[a]{b+c}\r\n\\int_{a}^{b}{c}\r\n\\iint_{a}^{b}{c}\r\n\\iiint_{a}^{b}{c}\r\n\\oint{a}\r\n(a)\r\n[a]\r\n\\lbrace{a}\\rbrace\r\n\\left| \\begin{matrix} a_1 & a_2 \\ a_3 & a_4 \\end{matrix} \\right|\r\n\\frac{a}{b+c}\r\n\\vec{a}\r\n\\binom {a} {b}\r\n{a \\brack b}\r\n{a \\brace b}\r\n', NULL),
(1535, 2, 1583152959, 'atto_recordrtc', 'allowedtypes', 'both', NULL),
(1536, 2, 1583152959, 'atto_recordrtc', 'audiobitrate', '128000', NULL),
(1537, 2, 1583152959, 'atto_recordrtc', 'videobitrate', '2500000', NULL),
(1538, 2, 1583152959, 'atto_recordrtc', 'timelimit', '120', NULL),
(1539, 2, 1583152959, 'atto_table', 'allowborders', '0', NULL),
(1540, 2, 1583152959, 'atto_table', 'allowbackgroundcolour', '0', NULL),
(1541, 2, 1583152959, 'atto_table', 'allowwidth', '0', NULL),
(1542, 2, 1583152959, 'editor_tinymce', 'customtoolbar', 'wrap,formatselect,wrap,bold,italic,wrap,bullist,numlist,wrap,link,unlink,wrap,image\r\n\r\nundo,redo,wrap,underline,strikethrough,sub,sup,wrap,justifyleft,justifycenter,justifyright,wrap,outdent,indent,wrap,forecolor,backcolor,wrap,ltr,rtl\r\n\r\nfontselect,fontsizeselect,wrap,code,search,replace,wrap,nonbreaking,charmap,table,wrap,cleanup,removeformat,pastetext,pasteword,wrap,fullscreen', NULL),
(1543, 2, 1583152959, 'editor_tinymce', 'fontselectlist', 'Trebuchet=Trebuchet MS,Verdana,Arial,Helvetica,sans-serif;Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;Georgia=georgia,times new roman,times,serif;Tahoma=tahoma,arial,helvetica,sans-serif;Times New Roman=times new roman,times,serif;Verdana=verdana,arial,helvetica,sans-serif;Impact=impact;Wingdings=wingdings', NULL),
(1544, 2, 1583152959, 'editor_tinymce', 'customconfig', '', NULL),
(1545, 2, 1583152959, 'tinymce_moodleemoticon', 'requireemoticon', '1', NULL),
(1546, 2, 1583152959, 'tinymce_spellchecker', 'spellengine', '', NULL),
(1547, 2, 1583152959, 'tinymce_spellchecker', 'spelllanguagelist', '+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv', NULL),
(1548, 2, 1583152959, NULL, 'profileroles', '3,4,5', NULL),
(1549, 2, 1583152959, NULL, 'coursecontact', '3', NULL),
(1550, 2, 1583152960, NULL, 'frontpage', '6', NULL),
(1551, 2, 1583152960, NULL, 'frontpageloggedin', '6', NULL),
(1552, 2, 1583152960, NULL, 'maxcategorydepth', '2', NULL),
(1553, 2, 1583152960, NULL, 'frontpagecourselimit', '200', NULL),
(1554, 2, 1583152960, NULL, 'commentsperpage', '15', NULL),
(1555, 2, 1583152960, NULL, 'defaultfrontpageroleid', '8', NULL),
(1556, 2, 1583152960, NULL, 'messageinbound_enabled', '0', NULL),
(1557, 2, 1583152960, NULL, 'messageinbound_mailbox', '', NULL),
(1558, 2, 1583152960, NULL, 'messageinbound_domain', '', NULL),
(1559, 2, 1583152960, NULL, 'messageinbound_host', '', NULL),
(1560, 2, 1583152960, NULL, 'messageinbound_hostssl', 'ssl', NULL),
(1561, 2, 1583152960, NULL, 'messageinbound_hostuser', '', NULL),
(1562, 2, 1583152960, NULL, 'messageinbound_hostpass', '', NULL),
(1563, 2, 1583152960, NULL, 'enablemobilewebservice', '1', NULL),
(1564, 2, 1583152960, 'tool_mobile', 'apppolicy', '', NULL),
(1565, 2, 1583152974, 'tool_mobile', 'typeoflogin', '1', NULL),
(1566, 2, 1583152974, 'tool_mobile', 'forcedurlscheme', 'moodlemobile', NULL),
(1567, 2, 1583152974, 'tool_mobile', 'minimumversion', '', NULL),
(1568, 2, 1583152974, NULL, 'mobilecssurl', '', NULL),
(1569, 2, 1583152975, 'tool_mobile', 'enablesmartappbanners', '0', NULL),
(1570, 2, 1583152975, 'tool_mobile', 'iosappid', '633359593', NULL),
(1571, 2, 1583152975, 'tool_mobile', 'androidappid', 'com.moodle.moodlemobile', NULL),
(1572, 2, 1583152975, 'tool_mobile', 'setuplink', 'https://download.moodle.org/mobile', NULL),
(1573, 2, 1583152975, 'tool_mobile', 'forcelogout', '0', NULL),
(1574, 2, 1583152975, 'tool_mobile', 'disabledfeatures', '', NULL),
(1575, 2, 1583152975, 'tool_mobile', 'custommenuitems', '', NULL),
(1576, 2, 1583152975, 'tool_mobile', 'customlangstrings', '', NULL),
(1577, 2, 1583153063, 'enrol_auto', 'defaultenrol', '1', NULL),
(1578, 2, 1583153063, 'enrol_auto', 'status', '1', NULL),
(1579, 2, 1583153063, 'enrol_auto', 'enrolon', '1', NULL),
(1580, 2, 1583153063, 'enrol_auto', 'modviewmods', '', NULL),
(1581, 2, 1583153063, 'enrol_auto', 'roleid', '5', NULL),
(1582, 2, 1583153063, 'enrol_auto', 'sendcoursewelcomemessage', '1', NULL),
(1583, 2, 1583153361, 'enrol_apply', 'confirmmailsubject', 'Course Confirmation', NULL),
(1584, 2, 1583153361, 'enrol_apply', 'confirmmailcontent', '<p><p>Hi&nbsp;<b>{firstname}</b>,</p><p>Your&nbsp;<b>{content}</b>&nbsp;course enrolment request has been confirmed.</p><p>Thanks &amp; regards,</p><p>Learning &amp; Development Team</p><br></p>', NULL),
(1585, 2, 1583153361, 'enrol_apply', 'waitmailsubject', 'Course Waiting list', NULL),
(1586, 2, 1583153361, 'enrol_apply', 'waitmailcontent', '<p><p>Hi&nbsp;<b>{firstname}</b>,</p><p>Your&nbsp;<b>{content}</b>&nbsp;course&nbsp;enrolment request has been in waiting list.</p><p>Thanks &amp; regards,</p><p>Learning &amp; Development Team</p><br><br></p>', NULL),
(1587, 2, 1583153361, 'enrol_apply', 'cancelmailsubject', 'Course Cancelation', NULL),
(1588, 2, 1583153361, 'enrol_apply', 'cancelmailcontent', '<p><p>Hi&nbsp;<b>{firstname}</b>,</p><p>Your&nbsp;<b>{content}</b>&nbsp;course&nbsp;enrolment request has been cancled.</p><p>Thanks &amp; regards,</p><p>Learning &amp; Development Team</p><br><br></p>', NULL),
(1589, 2, 1583153361, 'enrol_apply', 'notifyglobal', '$@ALL@$', NULL),
(1590, 2, 1583153361, 'enrol_apply', 'expiredaction', '1', NULL),
(1591, 2, 1583153361, 'enrol_apply', 'defaultenrol', '0', NULL),
(1592, 2, 1583153361, 'enrol_apply', 'status', '0', NULL),
(1593, 2, 1583153361, 'enrol_apply', 'newenrols', '1', NULL),
(1594, 2, 1583153361, 'enrol_apply', 'show_standard_user_profile', '1', NULL),
(1595, 2, 1583153361, 'enrol_apply', 'show_extra_user_profile', '1', NULL),
(1596, 2, 1583153361, 'enrol_apply', 'roleid', '5', NULL),
(1597, 2, 1583153361, 'enrol_apply', 'notifycoursebased', '0', NULL),
(1598, 2, 1583153362, 'enrol_apply', 'enrolperiod', '0', NULL),
(1599, 2, 1583153564, 'attendance', 'resultsperpage', '25', NULL),
(1600, 2, 1583153564, 'attendance', 'studentscanmark', '1', NULL),
(1601, 2, 1583153564, 'attendance', 'studentscanmarksessiontime', '1', NULL),
(1602, 2, 1583153564, 'attendance', 'studentscanmarksessiontimeend', '60', NULL),
(1603, 2, 1583153564, 'attendance', 'subnetactivitylevel', '1', NULL),
(1604, 2, 1583153564, 'attendance', 'defaultview', '2', NULL),
(1605, 2, 1583153564, 'attendance', 'multisessionexpanded', '0', NULL),
(1606, 2, 1583153564, 'attendance', 'showsessiondescriptiononreport', '0', NULL),
(1607, 2, 1583153564, 'attendance', 'studentrecordingexpanded', '1', NULL),
(1608, 2, 1583153564, 'attendance', 'enablecalendar', '1', NULL),
(1609, 2, 1583153564, 'attendance', 'enablewarnings', '0', NULL),
(1610, 2, 1583153564, 'attendance', 'subnet', '', NULL),
(1611, 2, 1583153564, 'attendance', 'calendarevent_default', '1', NULL),
(1612, 2, 1583153564, 'attendance', 'absenteereport_default', '1', NULL),
(1613, 2, 1583153564, 'attendance', 'studentscanmark_default', '0', NULL),
(1614, 2, 1583153564, 'attendance', 'automark_default', '0', NULL),
(1615, 2, 1583153565, 'attendance', 'randompassword_default', '0', NULL),
(1616, 2, 1583153565, 'attendance', 'includeqrcode_default', '0', NULL),
(1617, 2, 1583153565, 'attendance', 'autoassignstatus', '0', NULL),
(1618, 2, 1583153565, 'attendance', 'preventsharedip', '0', NULL),
(1619, 2, 1583153565, 'attendance', 'preventsharediptime', '', NULL),
(1620, 2, 1583153565, 'attendance', 'warningpercent', '70', NULL),
(1621, 2, 1583153565, 'attendance', 'warnafter', '5', NULL),
(1622, 2, 1583153565, 'attendance', 'maxwarn', '1', NULL),
(1623, 2, 1583153565, 'attendance', 'emailuser', '1', NULL),
(1624, 2, 1583153565, 'attendance', 'emailsubject', 'Attendance warning', NULL),
(1625, 2, 1583153565, 'attendance', 'emailcontent', 'Hi %userfirstname%,\r\nYour attendance in %coursename% %attendancename% has dropped below %warningpercent% and is currently %percent% - we hope you are ok!\r\n\r\nTo get the most out of this course you should improve your attendance, please get in touch if you require any further support.', NULL),
(1626, 2, 1583153792, NULL, 'facetoface_fromaddress', 'moodle@example.com', NULL),
(1627, 2, 1583153793, NULL, 'facetoface_session_roles', '5', NULL),
(1628, 2, 1583153793, NULL, 'facetoface_addchangemanageremail', '1', NULL),
(1629, 2, 1583153793, NULL, 'facetoface_manageraddressformat', '', NULL),
(1630, 2, 1583153793, NULL, 'facetoface_manageraddressformatreadable', 'firstname.lastname@company.com', NULL),
(1631, 2, 1583153793, NULL, 'facetoface_hidecost', '0', NULL),
(1632, 2, 1583153793, NULL, 'facetoface_hidediscount', '0', NULL),
(1633, 2, 1583153793, NULL, 'facetoface_oneemailperday', '0', NULL),
(1634, 2, 1583153793, NULL, 'facetoface_disableicalcancel', '0', NULL),
(1635, 2, 1583153905, 'mod_hvp', 'enable_save_content_state', '0', NULL),
(1636, 2, 1583153905, 'mod_hvp', 'content_state_frequency', '30', NULL),
(1637, 2, 1583153905, 'mod_hvp', 'send_usage_statistics', '1', NULL),
(1638, 2, 1583153905, 'mod_hvp', 'frame', '1', NULL),
(1639, 2, 1583153905, 'mod_hvp', 'export', '3', NULL),
(1640, 2, 1583153905, 'mod_hvp', 'embed', '3', NULL),
(1641, 2, 1583153905, 'mod_hvp', 'copyright', '1', NULL),
(1642, 2, 1583153905, 'mod_hvp', 'icon', '1', NULL),
(1643, 2, 1583153905, 'mod_hvp', 'enable_lrs_content_types', '0', NULL),
(1644, 2, 1583153970, NULL, 'jitsi_domain', 'meet.jit.si', NULL),
(1645, 2, 1584080075, 'mod_treasurehunt', 'maximumgrade', '10', NULL),
(1646, 2, 1584080075, 'mod_treasurehunt', 'grademethod', '1', NULL),
(1647, 2, 1584080075, 'mod_treasurehunt', 'penaltylocation', '0', NULL),
(1648, 2, 1584080075, 'mod_treasurehunt', 'penaltyanswer', '0', NULL),
(1649, 2, 1584080075, 'mod_treasurehunt', 'locktimeediting', '120', NULL),
(1650, 2, 1584080075, 'mod_treasurehunt', 'gameupdatetime', '20', NULL),
(1651, 2, 1584080200, 'attendance', 'rotateqrcodeinterval', '15', NULL),
(1652, 2, 1584080200, 'attendance', 'rotateqrcodeexpirymargin', '2', NULL),
(1653, 2, 1584080201, 'attendance', 'mobilesessionfrom', '21600', NULL),
(1654, 2, 1584080201, 'attendance', 'mobilesessionto', '86400', NULL),
(1655, 2, 1585568118, 'theme_boost', 'scss', '#page-footer\r\n{\r\n   display : none !important;\r\n}', ''),
(1656, 2, 1585568463, 'checklist', 'showmymoodle', '1', NULL),
(1657, 2, 1585568463, 'checklist', 'showcompletemymoodle', '1', NULL),
(1658, 2, 1585568463, 'checklist', 'showupdateablemymoodle', '1', NULL),
(1659, 2, 1585568463, 'mod_checklist', 'linkcourses', '0', NULL),
(1660, 2, 1585568463, 'mod_checklist', 'onlyenrolled', '1', NULL),
(1661, 2, 1585568523, NULL, 'jitsi_help', '', NULL),
(1662, 2, 1585568524, NULL, 'jitsi_id', 'username', NULL),
(1663, 2, 1585568524, NULL, 'jitsi_separator', '0', NULL),
(1664, 2, 1585568524, NULL, 'jitsi_sesionname', '0,1,2', NULL),
(1665, 2, 1585568524, NULL, 'jitsi_showinfo', '0', NULL),
(1666, 2, 1585568524, NULL, 'jitsi_app_id', '', NULL),
(1667, 2, 1585568524, NULL, 'jitsi_secret', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_config_plugins`
--

CREATE TABLE `mdl_config_plugins` (
  `id` bigint(10) NOT NULL,
  `plugin` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Moodle modules and plugins configuration variables' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_config_plugins`
--

INSERT INTO `mdl_config_plugins` (`id`, `plugin`, `name`, `value`) VALUES
(1, 'question', 'multichoice_sortorder', '1'),
(2, 'question', 'truefalse_sortorder', '2'),
(3, 'question', 'match_sortorder', '3'),
(4, 'question', 'shortanswer_sortorder', '4'),
(5, 'question', 'numerical_sortorder', '5'),
(6, 'question', 'essay_sortorder', '6'),
(7, 'moodlecourse', 'visible', '1'),
(8, 'moodlecourse', 'format', 'topics'),
(9, 'moodlecourse', 'maxsections', '52'),
(10, 'moodlecourse', 'numsections', '4'),
(11, 'moodlecourse', 'hiddensections', '0'),
(12, 'moodlecourse', 'coursedisplay', '0'),
(13, 'moodlecourse', 'courseenddateenabled', '1'),
(14, 'moodlecourse', 'courseduration', '31536000'),
(15, 'moodlecourse', 'lang', ''),
(16, 'moodlecourse', 'newsitems', '5'),
(17, 'moodlecourse', 'showgrades', '1'),
(18, 'moodlecourse', 'showreports', '0'),
(19, 'moodlecourse', 'maxbytes', '0'),
(20, 'moodlecourse', 'enablecompletion', '1'),
(21, 'moodlecourse', 'groupmode', '0'),
(22, 'moodlecourse', 'groupmodeforce', '0'),
(23, 'backup', 'loglifetime', '30'),
(24, 'backup', 'backup_general_users', '1'),
(25, 'backup', 'backup_general_users_locked', ''),
(26, 'backup', 'backup_general_anonymize', '0'),
(27, 'backup', 'backup_general_anonymize_locked', ''),
(28, 'backup', 'backup_general_role_assignments', '1'),
(29, 'backup', 'backup_general_role_assignments_locked', ''),
(30, 'backup', 'backup_general_activities', '1'),
(31, 'backup', 'backup_general_activities_locked', ''),
(32, 'backup', 'backup_general_blocks', '1'),
(33, 'backup', 'backup_general_blocks_locked', ''),
(34, 'backup', 'backup_general_files', '1'),
(35, 'backup', 'backup_general_files_locked', ''),
(36, 'backup', 'backup_general_filters', '1'),
(37, 'backup', 'backup_general_filters_locked', ''),
(38, 'backup', 'backup_general_comments', '1'),
(39, 'backup', 'backup_general_comments_locked', ''),
(40, 'backup', 'backup_general_badges', '1'),
(41, 'backup', 'backup_general_badges_locked', ''),
(42, 'backup', 'backup_general_calendarevents', '1'),
(43, 'backup', 'backup_general_calendarevents_locked', ''),
(44, 'backup', 'backup_general_userscompletion', '1'),
(45, 'backup', 'backup_general_userscompletion_locked', ''),
(46, 'backup', 'backup_general_logs', '0'),
(47, 'backup', 'backup_general_logs_locked', ''),
(48, 'backup', 'backup_general_histories', '0'),
(49, 'backup', 'backup_general_histories_locked', ''),
(50, 'backup', 'backup_general_questionbank', '1'),
(51, 'backup', 'backup_general_questionbank_locked', ''),
(52, 'backup', 'backup_general_groups', '1'),
(53, 'backup', 'backup_general_groups_locked', ''),
(54, 'backup', 'backup_general_competencies', '1'),
(55, 'backup', 'backup_general_competencies_locked', ''),
(56, 'backup', 'import_general_maxresults', '10'),
(57, 'backup', 'import_general_duplicate_admin_allowed', '0'),
(58, 'backup', 'backup_import_activities', '1'),
(59, 'backup', 'backup_import_activities_locked', ''),
(60, 'backup', 'backup_import_blocks', '1'),
(61, 'backup', 'backup_import_blocks_locked', ''),
(62, 'backup', 'backup_import_filters', '1'),
(63, 'backup', 'backup_import_filters_locked', ''),
(64, 'backup', 'backup_import_calendarevents', '1'),
(65, 'backup', 'backup_import_calendarevents_locked', ''),
(66, 'backup', 'backup_import_questionbank', '1'),
(67, 'backup', 'backup_import_questionbank_locked', ''),
(68, 'backup', 'backup_import_groups', '1'),
(69, 'backup', 'backup_import_groups_locked', ''),
(70, 'backup', 'backup_import_competencies', '1'),
(71, 'backup', 'backup_import_competencies_locked', ''),
(72, 'backup', 'backup_auto_active', '0'),
(73, 'backup', 'backup_auto_weekdays', '0000000'),
(74, 'backup', 'backup_auto_hour', '0'),
(75, 'backup', 'backup_auto_minute', '0'),
(76, 'backup', 'backup_auto_storage', '0'),
(77, 'backup', 'backup_auto_destination', ''),
(78, 'backup', 'backup_auto_max_kept', '1'),
(79, 'backup', 'backup_auto_delete_days', '0'),
(80, 'backup', 'backup_auto_min_kept', '0'),
(81, 'backup', 'backup_shortname', '0'),
(82, 'backup', 'backup_auto_skip_hidden', '1'),
(83, 'backup', 'backup_auto_skip_modif_days', '30'),
(84, 'backup', 'backup_auto_skip_modif_prev', '0'),
(85, 'backup', 'backup_auto_users', '1'),
(86, 'backup', 'backup_auto_role_assignments', '1'),
(87, 'backup', 'backup_auto_activities', '1'),
(88, 'backup', 'backup_auto_blocks', '1'),
(89, 'backup', 'backup_auto_files', '1'),
(90, 'backup', 'backup_auto_filters', '1'),
(91, 'backup', 'backup_auto_comments', '1'),
(92, 'backup', 'backup_auto_badges', '1'),
(93, 'backup', 'backup_auto_calendarevents', '1'),
(94, 'backup', 'backup_auto_userscompletion', '1'),
(95, 'backup', 'backup_auto_logs', '0'),
(96, 'backup', 'backup_auto_histories', '0'),
(97, 'backup', 'backup_auto_questionbank', '1'),
(98, 'backup', 'backup_auto_groups', '1'),
(99, 'backup', 'backup_auto_competencies', '1'),
(100, 'restore', 'restore_general_users', '1'),
(101, 'restore', 'restore_general_users_locked', ''),
(102, 'restore', 'restore_general_enrolments', '1'),
(103, 'restore', 'restore_general_enrolments_locked', ''),
(104, 'restore', 'restore_general_role_assignments', '1'),
(105, 'restore', 'restore_general_role_assignments_locked', ''),
(106, 'restore', 'restore_general_activities', '1'),
(107, 'restore', 'restore_general_activities_locked', ''),
(108, 'restore', 'restore_general_blocks', '1'),
(109, 'restore', 'restore_general_blocks_locked', ''),
(110, 'restore', 'restore_general_filters', '1'),
(111, 'restore', 'restore_general_filters_locked', ''),
(112, 'restore', 'restore_general_comments', '1'),
(113, 'restore', 'restore_general_comments_locked', ''),
(114, 'restore', 'restore_general_badges', '1'),
(115, 'restore', 'restore_general_badges_locked', ''),
(116, 'restore', 'restore_general_calendarevents', '1'),
(117, 'restore', 'restore_general_calendarevents_locked', ''),
(118, 'restore', 'restore_general_userscompletion', '1'),
(119, 'restore', 'restore_general_userscompletion_locked', ''),
(120, 'restore', 'restore_general_logs', '1'),
(121, 'restore', 'restore_general_logs_locked', ''),
(122, 'restore', 'restore_general_histories', '1'),
(123, 'restore', 'restore_general_histories_locked', ''),
(124, 'restore', 'restore_general_groups', '1'),
(125, 'restore', 'restore_general_groups_locked', ''),
(126, 'restore', 'restore_general_competencies', '1'),
(127, 'restore', 'restore_general_competencies_locked', ''),
(128, 'restore', 'restore_merge_overwrite_conf', '0'),
(129, 'restore', 'restore_merge_overwrite_conf_locked', ''),
(130, 'restore', 'restore_merge_course_fullname', '1'),
(131, 'restore', 'restore_merge_course_fullname_locked', ''),
(132, 'restore', 'restore_merge_course_shortname', '1'),
(133, 'restore', 'restore_merge_course_shortname_locked', ''),
(134, 'restore', 'restore_merge_course_startdate', '1'),
(135, 'restore', 'restore_merge_course_startdate_locked', ''),
(136, 'restore', 'restore_replace_overwrite_conf', '0'),
(137, 'restore', 'restore_replace_overwrite_conf_locked', ''),
(138, 'restore', 'restore_replace_course_fullname', '1'),
(139, 'restore', 'restore_replace_course_fullname_locked', ''),
(140, 'restore', 'restore_replace_course_shortname', '1'),
(141, 'restore', 'restore_replace_course_shortname_locked', ''),
(142, 'restore', 'restore_replace_course_startdate', '1'),
(143, 'restore', 'restore_replace_course_startdate_locked', ''),
(144, 'restore', 'restore_replace_keep_roles_and_enrolments', '0'),
(145, 'restore', 'restore_replace_keep_roles_and_enrolments_locked', ''),
(146, 'restore', 'restore_replace_keep_groups_and_groupings', '0'),
(147, 'restore', 'restore_replace_keep_groups_and_groupings_locked', ''),
(148, 'backup', 'backup_async_message_users', '0'),
(149, 'backup', 'backup_async_message_subject', 'Moodle {operation} completed successfully'),
(150, 'backup', 'backup_async_message', 'Hi {user_firstname},<br/> Your {operation} (ID: {backupid}) has completed successfully. <br/><br/>You can access it here: {link}.'),
(151, 'analytics', 'modeinstruction', ''),
(152, 'analytics', 'percentonline', '0'),
(153, 'analytics', 'typeinstitution', ''),
(154, 'analytics', 'levelinstitution', ''),
(155, 'analytics', 'predictionsprocessor', '\\mlbackend_php\\processor'),
(156, 'analytics', 'defaulttimesplittingsevaluation', '\\core\\analytics\\time_splitting\\quarters_accum,\\core\\analytics\\time_splitting\\quarters,\\core\\analytics\\time_splitting\\single_range'),
(157, 'analytics', 'modeloutputdir', '/var/www/moodledata_LMS_2_0/models'),
(158, 'analytics', 'onlycli', '1'),
(159, 'analytics', 'modeltimelimit', '1200'),
(160, 'core_competency', 'enabled', '1'),
(161, 'core_competency', 'pushcourseratingstouserplans', '1'),
(162, 'cachestore_apcu', 'testperformance', '0'),
(163, 'cachestore_memcached', 'testservers', ''),
(164, 'cachestore_mongodb', 'testserver', ''),
(165, 'cachestore_redis', 'test_server', ''),
(166, 'cachestore_redis', 'test_password', ''),
(167, 'question_preview', 'behaviour', 'deferredfeedback'),
(168, 'question_preview', 'correctness', '1'),
(169, 'question_preview', 'marks', '2'),
(170, 'question_preview', 'markdp', '2'),
(171, 'question_preview', 'feedback', '1'),
(172, 'question_preview', 'generalfeedback', '1'),
(173, 'question_preview', 'rightanswer', '1'),
(174, 'question_preview', 'history', '0'),
(175, 'tool_task', 'enablerunnow', '1'),
(176, 'theme_boost', 'preset', 'default.scss'),
(177, 'theme_boost', 'presetfiles', ''),
(178, 'theme_boost', 'backgroundimage', ''),
(179, 'theme_boost', 'brandcolor', ''),
(180, 'theme_boost', 'scsspre', ''),
(181, 'theme_boost', 'scss', '#page-footer\r\n{\r\n   display : none !important;\r\n}'),
(182, 'theme_classic', 'navbardark', '0'),
(183, 'theme_classic', 'preset', 'default.scss'),
(184, 'theme_classic', 'presetfiles', ''),
(185, 'theme_classic', 'backgroundimage', ''),
(186, 'theme_classic', 'brandcolor', ''),
(187, 'theme_classic', 'scsspre', ''),
(188, 'theme_classic', 'scss', ''),
(189, 'core_admin', 'logo', ''),
(190, 'core_admin', 'logocompact', ''),
(191, 'core_admin', 'coursecolor1', '#81ecec'),
(192, 'core_admin', 'coursecolor2', '#74b9ff'),
(193, 'core_admin', 'coursecolor3', '#a29bfe'),
(194, 'core_admin', 'coursecolor4', '#dfe6e9'),
(195, 'core_admin', 'coursecolor5', '#00b894'),
(196, 'core_admin', 'coursecolor6', '#0984e3'),
(197, 'core_admin', 'coursecolor7', '#b2bec3'),
(198, 'core_admin', 'coursecolor8', '#fdcb6e'),
(199, 'core_admin', 'coursecolor9', '#fd79a8'),
(200, 'core_admin', 'coursecolor10', '#6c5ce7'),
(201, 'antivirus_clamav', 'version', '2019111800'),
(202, 'availability_completion', 'version', '2019111800'),
(203, 'availability_date', 'version', '2019111800'),
(204, 'availability_grade', 'version', '2019111800'),
(205, 'availability_group', 'version', '2019111800'),
(206, 'availability_grouping', 'version', '2019111800'),
(207, 'availability_profile', 'version', '2019111800'),
(208, 'qtype_calculated', 'version', '2019111800'),
(209, 'qtype_calculatedmulti', 'version', '2019111800'),
(210, 'qtype_calculatedsimple', 'version', '2019111800'),
(211, 'qtype_ddimageortext', 'version', '2019111800'),
(212, 'qtype_ddmarker', 'version', '2019111800'),
(213, 'qtype_ddwtos', 'version', '2019111800'),
(214, 'qtype_description', 'version', '2019111800'),
(215, 'qtype_essay', 'version', '2019111800'),
(216, 'qtype_gapselect', 'version', '2019111800'),
(217, 'qtype_match', 'version', '2019111800'),
(218, 'qtype_missingtype', 'version', '2019111800'),
(219, 'qtype_multianswer', 'version', '2019111800'),
(220, 'qtype_multichoice', 'version', '2019111800'),
(221, 'qtype_numerical', 'version', '2019111800'),
(222, 'qtype_random', 'version', '2019111800'),
(223, 'qtype_randomsamatch', 'version', '2019111800'),
(224, 'qtype_shortanswer', 'version', '2019111800'),
(225, 'qtype_truefalse', 'version', '2019111800'),
(226, 'mod_assign', 'version', '2019111800'),
(227, 'mod_assignment', 'version', '2019111800'),
(229, 'mod_book', 'version', '2019111800'),
(230, 'mod_chat', 'version', '2019111800'),
(231, 'mod_choice', 'version', '2019111800'),
(232, 'mod_data', 'version', '2019111800'),
(233, 'mod_feedback', 'version', '2019111800'),
(235, 'mod_folder', 'version', '2019111800'),
(237, 'mod_forum', 'version', '2019111801'),
(238, 'mod_glossary', 'version', '2019111800'),
(239, 'mod_imscp', 'version', '2019111800'),
(241, 'mod_label', 'version', '2019111800'),
(242, 'mod_lesson', 'version', '2019111800'),
(243, 'mod_lti', 'version', '2019111800'),
(245, 'mod_lti', 'kid', '3e10608de6965730f3fa'),
(246, 'mod_lti', 'privatekey', '-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC7qvdy2avXUDih\nOviqmb3ta1G5pVnpGKKmjh/mdQ09ODwZCZ7VFnwhZH7V29iWlo+CGXqOWY5iXdwD\n6GYegFK0jaL9/LHx/Nb4nRJiasuvYVOsCc3j3RNnMb9klXofutDclfvIxYHZCEMv\n/Zp11ybuskKnPSL/yhfrcuqR2ltH9fiPsrT1eSHQMG6QtrR0JGnxhHTtYKNFTrpl\n/yCQ5x30jKrR9VvDTkhIN6C80zbuYwrCeSNC7jU6NQvlPsXhgt9PvbFkVrB0KRy0\nGUEX1LgAU2AaEwWH2egEr9ZxpRjmStEvPpsMyZP0Ds8sL/zDnJRjStS4lpWkqD6v\neMJBdkdJAgMBAAECggEAbmdfGb76vDmihx+lSOAXfwQi2R9wrJPkpC16kN6NwlVB\n7czeFygaMJ7pizDB052RoY0Rr4r6G95x4A6pfQorHbMxj1BI8z62zR3Cwgln+K4+\nRjiiWoolrxDyMt9JMD98PjkyHeQrxp14wVPluauwaL6QPcjWvTqMJeS+IL4f8028\nXi9lF4MsjRxh83Bucr1Ce9GcaiCvicygUe3VdkorMvfJ9mRaZHEF8xbf1HyQqEeL\nSIzKEnjsYD3rA5Ll/uRykTSo2fSLwfWR/gkJX4jVNwNUgKfXnX45UX0kRINYGGl/\nhOU+u6UgL+Hz5rOgom8WYUfRnrukeDhdHcFpAwjanQKBgQDbxXHKFRsbgtAsq3XP\n/7aRBUWsz7hAOlMrUfOFP5dcRx10lQepYMqqN2sBdnIrsX9Cs6a3mLVyQkuAjZvq\n6CZCufAyHJonZTvArZIBAraQrXHx8Xh1ow7DZ/pouhLksMBOGkWhYhQ58UOT8o+d\n8suUou/yxDBXFKY+ZL177qZKHwKBgQDamroc9HUvHZiR1zbailRNZGZM9hws0Yv2\nPq3LzRTCEzDASUbMcOZjtQSCrLQTD4ZePNy/gTh4b1ClfKJSBYeaC13eDbb1ta9q\nn18F93MSj9nRTh+TounyVJH1xSwQxGTRZzV3hrU/GXfUVgc9VJfPpKOOfps/w+f2\nyGhMP/uRlwKBgQCFWdrfucrG+KsET82ethS7Di3m2+t63WkVwhY3Zgybq3MOCFer\nyNVwT0wYiRxhssP7XzLr+Dcw61UQ3dwbv11n45cBcSWAfgaxtSAAiPrp8rRPECv9\nhUEyBGeHIFDSfwVQ3tQdRnvrZJ+Sp/3I40fwGqXp8m06iYcOGOZ4yqgQFQKBgDnu\nt1PlFQkfdsdvmYHhFuZLrTDIKD9YaRchFT3lY5LrMwhCYxja8rOJzWA0FKTYgGuJ\nBZdaz3RbS6wPk5TZEk6opH+scsg7FfnTsoMKSNyqcrcdVRDzI7ys3OGdF0h6Q52b\nFHhQosfOIAuNoO2H9ZN5tj6VHt+PM3IbOki6zBiRAoGAPf85odmpFOe/mE+RAVNx\nhEDvq3vbyp5H/EDoNxAacA7AOvaRmzLja+xjU82bWwOQtEQkcXi8zhT79nXOcDhw\nG8lQpTjtdMzIlYihece36PE6G4kAVIIhLjPngrU5An2Y8g5lEnRTMVngSelUtGMB\n+OSzbVXhsoeVKcs1B24yYnA=\n-----END PRIVATE KEY-----\n'),
(247, 'mod_page', 'version', '2019111800'),
(249, 'mod_quiz', 'version', '2019111800'),
(250, 'mod_resource', 'version', '2019111800'),
(251, 'mod_scorm', 'version', '2019111800'),
(252, 'mod_survey', 'version', '2019111800'),
(254, 'mod_url', 'version', '2019111800'),
(256, 'mod_wiki', 'version', '2019111800'),
(258, 'mod_workshop', 'version', '2019111800'),
(259, 'auth_cas', 'version', '2019111800'),
(261, 'auth_db', 'version', '2019111800'),
(263, 'auth_email', 'version', '2019111800'),
(264, 'auth_ldap', 'version', '2019111800'),
(266, 'auth_lti', 'version', '2019111800'),
(267, 'auth_manual', 'version', '2019111800'),
(268, 'auth_mnet', 'version', '2019111800'),
(270, 'auth_nologin', 'version', '2019111800'),
(271, 'auth_none', 'version', '2019111800'),
(272, 'auth_oauth2', 'version', '2019111800'),
(273, 'auth_shibboleth', 'version', '2019111800'),
(275, 'auth_webservice', 'version', '2019111800'),
(276, 'calendartype_gregorian', 'version', '2019111800'),
(277, 'customfield_checkbox', 'version', '2019111800'),
(278, 'customfield_date', 'version', '2019111800'),
(279, 'customfield_select', 'version', '2019111800'),
(280, 'customfield_text', 'version', '2019111800'),
(281, 'customfield_textarea', 'version', '2019111800'),
(282, 'enrol_category', 'version', '2019111800'),
(284, 'enrol_cohort', 'version', '2019111800'),
(285, 'enrol_database', 'version', '2019111800'),
(287, 'enrol_flatfile', 'version', '2019111800'),
(289, 'enrol_flatfile', 'map_1', 'manager'),
(290, 'enrol_flatfile', 'map_2', 'coursecreator'),
(291, 'enrol_flatfile', 'map_3', 'editingteacher'),
(292, 'enrol_flatfile', 'map_4', 'teacher'),
(293, 'enrol_flatfile', 'map_5', 'student'),
(294, 'enrol_flatfile', 'map_6', 'guest'),
(295, 'enrol_flatfile', 'map_7', 'user'),
(296, 'enrol_flatfile', 'map_8', 'frontpage'),
(297, 'enrol_guest', 'version', '2019111800'),
(298, 'enrol_imsenterprise', 'version', '2019111800'),
(300, 'enrol_ldap', 'version', '2019111800'),
(302, 'enrol_lti', 'version', '2019111800'),
(303, 'enrol_manual', 'version', '2019111800'),
(305, 'enrol_meta', 'version', '2019111800'),
(307, 'enrol_mnet', 'version', '2019111800'),
(308, 'enrol_paypal', 'version', '2019111800'),
(309, 'enrol_self', 'version', '2019111800'),
(311, 'message_airnotifier', 'version', '2019111800'),
(313, 'message', 'airnotifier_provider_enrol_flatfile_flatfile_enrolment_permitted', 'permitted'),
(314, 'message', 'airnotifier_provider_enrol_imsenterprise_imsenterprise_enrolment_permitted', 'permitted'),
(315, 'message', 'airnotifier_provider_enrol_manual_expiry_notification_permitted', 'permitted'),
(316, 'message', 'airnotifier_provider_enrol_paypal_paypal_enrolment_permitted', 'permitted'),
(317, 'message', 'airnotifier_provider_enrol_self_expiry_notification_permitted', 'permitted'),
(318, 'message', 'airnotifier_provider_mod_assign_assign_notification_permitted', 'permitted'),
(319, 'message', 'airnotifier_provider_mod_assignment_assignment_updates_permitted', 'permitted'),
(320, 'message', 'airnotifier_provider_mod_feedback_submission_permitted', 'permitted'),
(321, 'message', 'airnotifier_provider_mod_feedback_message_permitted', 'permitted'),
(322, 'message', 'airnotifier_provider_mod_forum_posts_permitted', 'permitted'),
(323, 'message', 'message_provider_mod_forum_posts_loggedin', 'email,airnotifier'),
(324, 'message', 'message_provider_mod_forum_posts_loggedoff', 'email,airnotifier'),
(325, 'message', 'airnotifier_provider_mod_forum_digests_permitted', 'permitted'),
(326, 'message', 'airnotifier_provider_mod_lesson_graded_essay_permitted', 'permitted'),
(327, 'message', 'message_provider_mod_lesson_graded_essay_loggedin', 'email,airnotifier'),
(328, 'message', 'message_provider_mod_lesson_graded_essay_loggedoff', 'email,airnotifier'),
(329, 'message', 'airnotifier_provider_mod_quiz_submission_permitted', 'permitted'),
(330, 'message', 'airnotifier_provider_mod_quiz_confirmation_permitted', 'permitted'),
(331, 'message', 'message_provider_mod_quiz_confirmation_loggedin', 'email,airnotifier'),
(332, 'message', 'message_provider_mod_quiz_confirmation_loggedoff', 'email,airnotifier'),
(333, 'message', 'airnotifier_provider_mod_quiz_attempt_overdue_permitted', 'permitted'),
(334, 'message', 'message_provider_mod_quiz_attempt_overdue_loggedin', 'email,airnotifier'),
(335, 'message', 'message_provider_mod_quiz_attempt_overdue_loggedoff', 'email,airnotifier'),
(336, 'message', 'airnotifier_provider_moodle_notices_permitted', 'permitted'),
(337, 'message', 'airnotifier_provider_moodle_errors_permitted', 'permitted'),
(338, 'message', 'airnotifier_provider_moodle_availableupdate_permitted', 'permitted'),
(339, 'message', 'airnotifier_provider_moodle_instantmessage_permitted', 'permitted'),
(340, 'message', 'airnotifier_provider_moodle_backup_permitted', 'permitted'),
(341, 'message', 'airnotifier_provider_moodle_courserequested_permitted', 'permitted'),
(342, 'message', 'airnotifier_provider_moodle_courserequestapproved_permitted', 'permitted'),
(343, 'message', 'message_provider_moodle_courserequestapproved_loggedin', 'email,airnotifier'),
(344, 'message', 'message_provider_moodle_courserequestapproved_loggedoff', 'email,airnotifier'),
(345, 'message', 'airnotifier_provider_moodle_courserequestrejected_permitted', 'permitted'),
(346, 'message', 'message_provider_moodle_courserequestrejected_loggedin', 'email,airnotifier'),
(347, 'message', 'message_provider_moodle_courserequestrejected_loggedoff', 'email,airnotifier'),
(348, 'message', 'airnotifier_provider_moodle_badgerecipientnotice_permitted', 'permitted'),
(349, 'message', 'message_provider_moodle_badgerecipientnotice_loggedin', 'popup,airnotifier'),
(350, 'message', 'message_provider_moodle_badgerecipientnotice_loggedoff', 'popup,email,airnotifier'),
(351, 'message', 'airnotifier_provider_moodle_badgecreatornotice_permitted', 'permitted'),
(352, 'message', 'airnotifier_provider_moodle_competencyplancomment_permitted', 'permitted'),
(353, 'message', 'airnotifier_provider_moodle_competencyusercompcomment_permitted', 'permitted'),
(354, 'message', 'airnotifier_provider_moodle_insights_permitted', 'permitted'),
(355, 'message', 'message_provider_moodle_insights_loggedin', 'popup,airnotifier'),
(356, 'message', 'message_provider_moodle_insights_loggedoff', 'popup,email,airnotifier'),
(357, 'message', 'airnotifier_provider_moodle_messagecontactrequests_permitted', 'permitted'),
(358, 'message', 'message_provider_moodle_messagecontactrequests_loggedin', 'airnotifier'),
(359, 'message', 'message_provider_moodle_messagecontactrequests_loggedoff', 'email,airnotifier'),
(360, 'message', 'airnotifier_provider_moodle_asyncbackupnotification_permitted', 'permitted'),
(361, 'message', 'airnotifier_provider_moodle_gradenotifications_permitted', 'permitted'),
(362, 'message_email', 'version', '2019111800'),
(364, 'message', 'email_provider_enrol_flatfile_flatfile_enrolment_permitted', 'permitted'),
(365, 'message', 'message_provider_enrol_flatfile_flatfile_enrolment_loggedin', 'email'),
(366, 'message', 'message_provider_enrol_flatfile_flatfile_enrolment_loggedoff', 'email'),
(367, 'message', 'email_provider_enrol_imsenterprise_imsenterprise_enrolment_permitted', 'permitted'),
(368, 'message', 'message_provider_enrol_imsenterprise_imsenterprise_enrolment_loggedin', 'email'),
(369, 'message', 'message_provider_enrol_imsenterprise_imsenterprise_enrolment_loggedoff', 'email'),
(370, 'message', 'email_provider_enrol_manual_expiry_notification_permitted', 'permitted'),
(371, 'message', 'message_provider_enrol_manual_expiry_notification_loggedin', 'email'),
(372, 'message', 'message_provider_enrol_manual_expiry_notification_loggedoff', 'email'),
(373, 'message', 'email_provider_enrol_paypal_paypal_enrolment_permitted', 'permitted'),
(374, 'message', 'message_provider_enrol_paypal_paypal_enrolment_loggedin', 'email'),
(375, 'message', 'message_provider_enrol_paypal_paypal_enrolment_loggedoff', 'email'),
(376, 'message', 'email_provider_enrol_self_expiry_notification_permitted', 'permitted'),
(377, 'message', 'message_provider_enrol_self_expiry_notification_loggedin', 'email'),
(378, 'message', 'message_provider_enrol_self_expiry_notification_loggedoff', 'email'),
(379, 'message', 'email_provider_mod_assign_assign_notification_permitted', 'permitted'),
(380, 'message', 'message_provider_mod_assign_assign_notification_loggedin', 'email'),
(381, 'message', 'message_provider_mod_assign_assign_notification_loggedoff', 'email'),
(382, 'message', 'email_provider_mod_assignment_assignment_updates_permitted', 'permitted'),
(383, 'message', 'message_provider_mod_assignment_assignment_updates_loggedin', 'email'),
(384, 'message', 'message_provider_mod_assignment_assignment_updates_loggedoff', 'email'),
(385, 'message', 'email_provider_mod_feedback_submission_permitted', 'permitted'),
(386, 'message', 'message_provider_mod_feedback_submission_loggedin', 'email'),
(387, 'message', 'message_provider_mod_feedback_submission_loggedoff', 'email'),
(388, 'message', 'email_provider_mod_feedback_message_permitted', 'permitted'),
(389, 'message', 'message_provider_mod_feedback_message_loggedin', 'email'),
(390, 'message', 'message_provider_mod_feedback_message_loggedoff', 'email'),
(391, 'message', 'email_provider_mod_forum_posts_permitted', 'permitted'),
(392, 'message', 'email_provider_mod_forum_digests_permitted', 'permitted'),
(393, 'message', 'message_provider_mod_forum_digests_loggedin', 'email'),
(394, 'message', 'message_provider_mod_forum_digests_loggedoff', 'email'),
(395, 'message', 'email_provider_mod_lesson_graded_essay_permitted', 'permitted'),
(396, 'message', 'email_provider_mod_quiz_submission_permitted', 'permitted'),
(397, 'message', 'message_provider_mod_quiz_submission_loggedin', 'email'),
(398, 'message', 'message_provider_mod_quiz_submission_loggedoff', 'email'),
(399, 'message', 'email_provider_mod_quiz_confirmation_permitted', 'permitted'),
(400, 'message', 'email_provider_mod_quiz_attempt_overdue_permitted', 'permitted'),
(401, 'message', 'email_provider_moodle_notices_permitted', 'permitted'),
(402, 'message', 'message_provider_moodle_notices_loggedin', 'email'),
(403, 'message', 'message_provider_moodle_notices_loggedoff', 'email'),
(404, 'message', 'email_provider_moodle_errors_permitted', 'permitted'),
(405, 'message', 'message_provider_moodle_errors_loggedin', 'email'),
(406, 'message', 'message_provider_moodle_errors_loggedoff', 'email'),
(407, 'message', 'email_provider_moodle_availableupdate_permitted', 'permitted'),
(408, 'message', 'message_provider_moodle_availableupdate_loggedin', 'email'),
(409, 'message', 'message_provider_moodle_availableupdate_loggedoff', 'email'),
(410, 'message', 'email_provider_moodle_instantmessage_permitted', 'permitted'),
(411, 'message', 'message_provider_moodle_instantmessage_loggedoff', 'popup,email'),
(412, 'message', 'email_provider_moodle_backup_permitted', 'permitted'),
(413, 'message', 'message_provider_moodle_backup_loggedin', 'email'),
(414, 'message', 'message_provider_moodle_backup_loggedoff', 'email'),
(415, 'message', 'email_provider_moodle_courserequested_permitted', 'permitted'),
(416, 'message', 'message_provider_moodle_courserequested_loggedin', 'email'),
(417, 'message', 'message_provider_moodle_courserequested_loggedoff', 'email'),
(418, 'message', 'email_provider_moodle_courserequestapproved_permitted', 'permitted'),
(419, 'message', 'email_provider_moodle_courserequestrejected_permitted', 'permitted'),
(420, 'message', 'email_provider_moodle_badgerecipientnotice_permitted', 'permitted'),
(421, 'message', 'email_provider_moodle_badgecreatornotice_permitted', 'permitted'),
(422, 'message', 'message_provider_moodle_badgecreatornotice_loggedoff', 'email'),
(423, 'message', 'email_provider_moodle_competencyplancomment_permitted', 'permitted'),
(424, 'message', 'message_provider_moodle_competencyplancomment_loggedin', 'email'),
(425, 'message', 'message_provider_moodle_competencyplancomment_loggedoff', 'email'),
(426, 'message', 'email_provider_moodle_competencyusercompcomment_permitted', 'permitted'),
(427, 'message', 'message_provider_moodle_competencyusercompcomment_loggedin', 'email'),
(428, 'message', 'message_provider_moodle_competencyusercompcomment_loggedoff', 'email'),
(429, 'message', 'email_provider_moodle_insights_permitted', 'permitted'),
(430, 'message', 'email_provider_moodle_messagecontactrequests_permitted', 'permitted'),
(431, 'message', 'email_provider_moodle_asyncbackupnotification_permitted', 'permitted'),
(432, 'message', 'message_provider_moodle_asyncbackupnotification_loggedoff', 'popup,email'),
(433, 'message', 'email_provider_moodle_gradenotifications_permitted', 'permitted'),
(434, 'message', 'message_provider_moodle_gradenotifications_loggedoff', 'popup,email'),
(435, 'message_jabber', 'version', '2019111800'),
(437, 'message', 'jabber_provider_enrol_flatfile_flatfile_enrolment_permitted', 'permitted'),
(438, 'message', 'jabber_provider_enrol_imsenterprise_imsenterprise_enrolment_permitted', 'permitted'),
(439, 'message', 'jabber_provider_enrol_manual_expiry_notification_permitted', 'permitted'),
(440, 'message', 'jabber_provider_enrol_paypal_paypal_enrolment_permitted', 'permitted'),
(441, 'message', 'jabber_provider_enrol_self_expiry_notification_permitted', 'permitted'),
(442, 'message', 'jabber_provider_mod_assign_assign_notification_permitted', 'permitted'),
(443, 'message', 'jabber_provider_mod_assignment_assignment_updates_permitted', 'permitted'),
(444, 'message', 'jabber_provider_mod_feedback_submission_permitted', 'permitted'),
(445, 'message', 'jabber_provider_mod_feedback_message_permitted', 'permitted'),
(446, 'message', 'jabber_provider_mod_forum_posts_permitted', 'permitted'),
(447, 'message', 'jabber_provider_mod_forum_digests_permitted', 'permitted'),
(448, 'message', 'jabber_provider_mod_lesson_graded_essay_permitted', 'permitted'),
(449, 'message', 'jabber_provider_mod_quiz_submission_permitted', 'permitted'),
(450, 'message', 'jabber_provider_mod_quiz_confirmation_permitted', 'permitted'),
(451, 'message', 'jabber_provider_mod_quiz_attempt_overdue_permitted', 'permitted'),
(452, 'message', 'jabber_provider_moodle_notices_permitted', 'permitted'),
(453, 'message', 'jabber_provider_moodle_errors_permitted', 'permitted'),
(454, 'message', 'jabber_provider_moodle_availableupdate_permitted', 'permitted'),
(455, 'message', 'jabber_provider_moodle_instantmessage_permitted', 'permitted'),
(456, 'message', 'jabber_provider_moodle_backup_permitted', 'permitted'),
(457, 'message', 'jabber_provider_moodle_courserequested_permitted', 'permitted'),
(458, 'message', 'jabber_provider_moodle_courserequestapproved_permitted', 'permitted'),
(459, 'message', 'jabber_provider_moodle_courserequestrejected_permitted', 'permitted'),
(460, 'message', 'jabber_provider_moodle_badgerecipientnotice_permitted', 'permitted'),
(461, 'message', 'jabber_provider_moodle_badgecreatornotice_permitted', 'permitted'),
(462, 'message', 'jabber_provider_moodle_competencyplancomment_permitted', 'permitted'),
(463, 'message', 'jabber_provider_moodle_competencyusercompcomment_permitted', 'permitted'),
(464, 'message', 'jabber_provider_moodle_insights_permitted', 'permitted'),
(465, 'message', 'jabber_provider_moodle_messagecontactrequests_permitted', 'permitted'),
(466, 'message', 'jabber_provider_moodle_asyncbackupnotification_permitted', 'permitted'),
(467, 'message', 'jabber_provider_moodle_gradenotifications_permitted', 'permitted'),
(468, 'message_popup', 'version', '2019111800'),
(470, 'message', 'popup_provider_enrol_flatfile_flatfile_enrolment_permitted', 'permitted'),
(471, 'message', 'popup_provider_enrol_imsenterprise_imsenterprise_enrolment_permitted', 'permitted'),
(472, 'message', 'popup_provider_enrol_manual_expiry_notification_permitted', 'permitted'),
(473, 'message', 'popup_provider_enrol_paypal_paypal_enrolment_permitted', 'permitted'),
(474, 'message', 'popup_provider_enrol_self_expiry_notification_permitted', 'permitted'),
(475, 'message', 'popup_provider_mod_assign_assign_notification_permitted', 'permitted'),
(476, 'message', 'popup_provider_mod_assignment_assignment_updates_permitted', 'permitted'),
(477, 'message', 'popup_provider_mod_feedback_submission_permitted', 'permitted'),
(478, 'message', 'popup_provider_mod_feedback_message_permitted', 'permitted'),
(479, 'message', 'popup_provider_mod_forum_posts_permitted', 'permitted'),
(480, 'message', 'popup_provider_mod_forum_digests_permitted', 'permitted'),
(481, 'message', 'popup_provider_mod_lesson_graded_essay_permitted', 'permitted'),
(482, 'message', 'popup_provider_mod_quiz_submission_permitted', 'permitted'),
(483, 'message', 'popup_provider_mod_quiz_confirmation_permitted', 'permitted'),
(484, 'message', 'popup_provider_mod_quiz_attempt_overdue_permitted', 'permitted'),
(485, 'message', 'popup_provider_moodle_notices_permitted', 'permitted'),
(486, 'message', 'popup_provider_moodle_errors_permitted', 'permitted'),
(487, 'message', 'popup_provider_moodle_availableupdate_permitted', 'permitted'),
(488, 'message', 'popup_provider_moodle_instantmessage_permitted', 'permitted'),
(489, 'message', 'message_provider_moodle_instantmessage_loggedin', 'popup'),
(490, 'message', 'popup_provider_moodle_backup_permitted', 'permitted'),
(491, 'message', 'popup_provider_moodle_courserequested_permitted', 'permitted'),
(492, 'message', 'popup_provider_moodle_courserequestapproved_permitted', 'permitted'),
(493, 'message', 'popup_provider_moodle_courserequestrejected_permitted', 'permitted'),
(494, 'message', 'popup_provider_moodle_badgerecipientnotice_permitted', 'permitted'),
(495, 'message', 'popup_provider_moodle_badgecreatornotice_permitted', 'permitted'),
(496, 'message', 'popup_provider_moodle_competencyplancomment_permitted', 'permitted'),
(497, 'message', 'popup_provider_moodle_competencyusercompcomment_permitted', 'permitted'),
(498, 'message', 'popup_provider_moodle_insights_permitted', 'permitted'),
(499, 'message', 'popup_provider_moodle_messagecontactrequests_permitted', 'permitted'),
(500, 'message', 'popup_provider_moodle_asyncbackupnotification_permitted', 'permitted'),
(501, 'message', 'message_provider_moodle_asyncbackupnotification_loggedin', 'popup'),
(502, 'message', 'popup_provider_moodle_gradenotifications_permitted', 'permitted'),
(503, 'message', 'message_provider_moodle_gradenotifications_loggedin', 'popup'),
(504, 'block_activity_modules', 'version', '2019111800'),
(505, 'block_activity_results', 'version', '2019111800'),
(506, 'block_admin_bookmarks', 'version', '2019111800'),
(507, 'block_badges', 'version', '2019111800'),
(508, 'block_blog_menu', 'version', '2019111800'),
(509, 'block_blog_recent', 'version', '2019111800'),
(510, 'block_blog_tags', 'version', '2019111800'),
(511, 'block_calendar_month', 'version', '2019111800'),
(512, 'block_calendar_upcoming', 'version', '2019111800'),
(513, 'block_comments', 'version', '2019111800'),
(514, 'block_completionstatus', 'version', '2019111800'),
(515, 'block_course_list', 'version', '2019111800'),
(516, 'block_course_summary', 'version', '2019111800'),
(517, 'block_feedback', 'version', '2019111800'),
(519, 'block_globalsearch', 'version', '2019111800'),
(520, 'block_glossary_random', 'version', '2019111800'),
(521, 'block_html', 'version', '2019111800'),
(522, 'block_login', 'version', '2019111800'),
(523, 'block_lp', 'version', '2019111800'),
(524, 'block_mentees', 'version', '2019111800'),
(525, 'block_mnet_hosts', 'version', '2019111800'),
(526, 'block_myoverview', 'version', '2019111800'),
(527, 'block_myprofile', 'version', '2019111800'),
(528, 'block_navigation', 'version', '2019111800'),
(529, 'block_news_items', 'version', '2019111800'),
(530, 'block_online_users', 'version', '2019111800'),
(531, 'block_private_files', 'version', '2019111800'),
(532, 'block_quiz_results', 'version', '2019111800'),
(534, 'block_recent_activity', 'version', '2019111800'),
(535, 'block_recentlyaccessedcourses', 'version', '2019111800'),
(537, 'block_recentlyaccesseditems', 'version', '2019111800'),
(538, 'block_rss_client', 'version', '2019111800'),
(539, 'block_search_forums', 'version', '2019111800'),
(540, 'block_section_links', 'version', '2019111800'),
(541, 'block_selfcompletion', 'version', '2019111800'),
(542, 'block_settings', 'version', '2019111800'),
(543, 'block_site_main_menu', 'version', '2019111800'),
(544, 'block_social_activities', 'version', '2019111800'),
(545, 'block_starredcourses', 'version', '2019111800'),
(546, 'block_tag_flickr', 'version', '2019111800'),
(547, 'block_tag_youtube', 'version', '2019111800'),
(549, 'block_tags', 'version', '2019111800'),
(550, 'block_timeline', 'version', '2019111800'),
(552, 'media_html5audio', 'version', '2019111800'),
(553, 'media_html5video', 'version', '2019111800'),
(554, 'media_swf', 'version', '2019111800'),
(555, 'media_videojs', 'version', '2019111800'),
(556, 'media_vimeo', 'version', '2019111800'),
(557, 'media_youtube', 'version', '2019111800'),
(558, 'filter_activitynames', 'version', '2019111800'),
(560, 'filter_algebra', 'version', '2019111800'),
(561, 'filter_censor', 'version', '2019111800'),
(562, 'filter_data', 'version', '2019111800'),
(564, 'filter_displayh5p', 'version', '2019111800'),
(566, 'filter_emailprotect', 'version', '2019111800'),
(567, 'filter_emoticon', 'version', '2019111800'),
(568, 'filter_glossary', 'version', '2019111800'),
(570, 'filter_mathjaxloader', 'version', '2019111800'),
(572, 'filter_mediaplugin', 'version', '2019111800'),
(574, 'filter_multilang', 'version', '2019111800'),
(575, 'filter_tex', 'version', '2019111800'),
(577, 'filter_tidy', 'version', '2019111800'),
(578, 'filter_urltolink', 'version', '2019111800'),
(579, 'editor_atto', 'version', '2019111800'),
(581, 'editor_textarea', 'version', '2019111800'),
(582, 'editor_tinymce', 'version', '2019111800'),
(583, 'format_singleactivity', 'version', '2019111800'),
(584, 'format_social', 'version', '2019111800'),
(585, 'format_topics', 'version', '2019111800'),
(586, 'format_weeks', 'version', '2019111800'),
(587, 'dataformat_csv', 'version', '2019111800'),
(588, 'dataformat_excel', 'version', '2019111800'),
(589, 'dataformat_html', 'version', '2019111800'),
(590, 'dataformat_json', 'version', '2019111800'),
(591, 'dataformat_ods', 'version', '2019111800'),
(592, 'dataformat_pdf', 'version', '2019111800'),
(593, 'profilefield_checkbox', 'version', '2019111800'),
(594, 'profilefield_datetime', 'version', '2019111800'),
(595, 'profilefield_menu', 'version', '2019111800'),
(596, 'profilefield_text', 'version', '2019111800'),
(597, 'profilefield_textarea', 'version', '2019111800'),
(598, 'report_backups', 'version', '2019111800'),
(599, 'report_competency', 'version', '2019111800'),
(600, 'report_completion', 'version', '2019111800'),
(602, 'report_configlog', 'version', '2019111800'),
(603, 'report_courseoverview', 'version', '2019111800'),
(604, 'report_eventlist', 'version', '2019111800'),
(605, 'report_insights', 'version', '2019111800'),
(606, 'report_log', 'version', '2019111800'),
(608, 'report_loglive', 'version', '2019111800'),
(609, 'report_outline', 'version', '2019111800'),
(611, 'report_participation', 'version', '2019111800'),
(613, 'report_performance', 'version', '2019111800'),
(614, 'report_progress', 'version', '2019111800'),
(616, 'report_questioninstances', 'version', '2019111800'),
(617, 'report_security', 'version', '2019111800'),
(618, 'report_stats', 'version', '2019111800'),
(620, 'report_usersessions', 'version', '2019111800'),
(621, 'gradeexport_ods', 'version', '2019111800'),
(622, 'gradeexport_txt', 'version', '2019111800'),
(623, 'gradeexport_xls', 'version', '2019111800'),
(624, 'gradeexport_xml', 'version', '2019111800'),
(625, 'gradeimport_csv', 'version', '2019111800'),
(626, 'gradeimport_direct', 'version', '2019111800'),
(627, 'gradeimport_xml', 'version', '2019111800'),
(628, 'gradereport_grader', 'version', '2019111800'),
(629, 'gradereport_history', 'version', '2019111800'),
(630, 'gradereport_outcomes', 'version', '2019111800'),
(631, 'gradereport_overview', 'version', '2019111800'),
(632, 'gradereport_singleview', 'version', '2019111800'),
(633, 'gradereport_user', 'version', '2019111800'),
(634, 'gradingform_guide', 'version', '2019111800'),
(635, 'gradingform_rubric', 'version', '2019111800'),
(636, 'mlbackend_php', 'version', '2019111800'),
(637, 'mlbackend_python', 'version', '2019111800'),
(638, 'mnetservice_enrol', 'version', '2019111800'),
(639, 'webservice_rest', 'version', '2019111800'),
(640, 'webservice_soap', 'version', '2019111800'),
(641, 'webservice_xmlrpc', 'version', '2019111800'),
(642, 'repository_areafiles', 'version', '2019111800'),
(644, 'areafiles', 'enablecourseinstances', '0'),
(645, 'areafiles', 'enableuserinstances', '0'),
(646, 'repository_boxnet', 'version', '2019111800'),
(647, 'repository_coursefiles', 'version', '2019111800'),
(648, 'repository_dropbox', 'version', '2019111800'),
(649, 'repository_equella', 'version', '2019111800'),
(650, 'repository_filesystem', 'version', '2019111800'),
(651, 'repository_flickr', 'version', '2019111800'),
(652, 'repository_flickr_public', 'version', '2019111800'),
(653, 'repository_googledocs', 'version', '2019111800'),
(654, 'repository_local', 'version', '2019111800'),
(656, 'local', 'enablecourseinstances', '0'),
(657, 'local', 'enableuserinstances', '0'),
(658, 'repository_merlot', 'version', '2019111800'),
(659, 'repository_nextcloud', 'version', '2019111800'),
(660, 'repository_onedrive', 'version', '2019111800'),
(661, 'repository_picasa', 'version', '2019111800'),
(662, 'repository_recent', 'version', '2019111800'),
(664, 'recent', 'enablecourseinstances', '0'),
(665, 'recent', 'enableuserinstances', '0'),
(666, 'repository_s3', 'version', '2019111800'),
(667, 'repository_skydrive', 'version', '2019111800'),
(668, 'repository_upload', 'version', '2019111800'),
(670, 'upload', 'enablecourseinstances', '0'),
(671, 'upload', 'enableuserinstances', '0'),
(672, 'repository_url', 'version', '2019111800'),
(674, 'url', 'enablecourseinstances', '0'),
(675, 'url', 'enableuserinstances', '0'),
(676, 'repository_user', 'version', '2019111800'),
(678, 'user', 'enablecourseinstances', '0'),
(679, 'user', 'enableuserinstances', '0'),
(680, 'repository_webdav', 'version', '2019111800'),
(681, 'repository_wikimedia', 'version', '2019111800'),
(683, 'wikimedia', 'enablecourseinstances', '0'),
(684, 'wikimedia', 'enableuserinstances', '0'),
(685, 'repository_youtube', 'version', '2019111800'),
(687, 'portfolio_boxnet', 'version', '2019111800'),
(688, 'portfolio_download', 'version', '2019111800'),
(689, 'portfolio_flickr', 'version', '2019111800'),
(690, 'portfolio_googledocs', 'version', '2019111800'),
(691, 'portfolio_mahara', 'version', '2019111800'),
(692, 'portfolio_picasa', 'version', '2019111800'),
(693, 'search_simpledb', 'version', '2019111800'),
(695, 'search_solr', 'version', '2019111800'),
(696, 'qbehaviour_adaptive', 'version', '2019111800'),
(697, 'qbehaviour_adaptivenopenalty', 'version', '2019111800'),
(698, 'qbehaviour_deferredcbm', 'version', '2019111800'),
(699, 'qbehaviour_deferredfeedback', 'version', '2019111800'),
(700, 'qbehaviour_immediatecbm', 'version', '2019111800'),
(701, 'qbehaviour_immediatefeedback', 'version', '2019111800'),
(702, 'qbehaviour_informationitem', 'version', '2019111800'),
(703, 'qbehaviour_interactive', 'version', '2019111800'),
(704, 'qbehaviour_interactivecountback', 'version', '2019111800'),
(705, 'qbehaviour_manualgraded', 'version', '2019111800'),
(707, 'question', 'disabledbehaviours', 'manualgraded'),
(708, 'qbehaviour_missing', 'version', '2019111800'),
(709, 'qformat_aiken', 'version', '2019111800'),
(710, 'qformat_blackboard_six', 'version', '2019111800'),
(711, 'qformat_examview', 'version', '2019111800'),
(712, 'qformat_gift', 'version', '2019111800'),
(713, 'qformat_missingword', 'version', '2019111800'),
(714, 'qformat_multianswer', 'version', '2019111800'),
(715, 'qformat_webct', 'version', '2019111800'),
(716, 'qformat_xhtml', 'version', '2019111800'),
(717, 'qformat_xml', 'version', '2019111800'),
(718, 'tool_analytics', 'version', '2019111800'),
(719, 'tool_availabilityconditions', 'version', '2019111800'),
(720, 'tool_behat', 'version', '2019111800'),
(721, 'tool_capability', 'version', '2019111800'),
(722, 'tool_cohortroles', 'version', '2019111800'),
(723, 'tool_customlang', 'version', '2019111800'),
(725, 'tool_dataprivacy', 'version', '2019111800'),
(726, 'message', 'airnotifier_provider_tool_dataprivacy_contactdataprotectionofficer_permitted', 'permitted'),
(727, 'message', 'email_provider_tool_dataprivacy_contactdataprotectionofficer_permitted', 'permitted'),
(728, 'message', 'jabber_provider_tool_dataprivacy_contactdataprotectionofficer_permitted', 'permitted'),
(729, 'message', 'popup_provider_tool_dataprivacy_contactdataprotectionofficer_permitted', 'permitted'),
(730, 'message', 'message_provider_tool_dataprivacy_contactdataprotectionofficer_loggedin', 'email,popup'),
(731, 'message', 'message_provider_tool_dataprivacy_contactdataprotectionofficer_loggedoff', 'email,popup'),
(732, 'message', 'airnotifier_provider_tool_dataprivacy_datarequestprocessingresults_permitted', 'permitted'),
(733, 'message', 'email_provider_tool_dataprivacy_datarequestprocessingresults_permitted', 'permitted'),
(734, 'message', 'jabber_provider_tool_dataprivacy_datarequestprocessingresults_permitted', 'permitted'),
(735, 'message', 'popup_provider_tool_dataprivacy_datarequestprocessingresults_permitted', 'permitted'),
(736, 'message', 'message_provider_tool_dataprivacy_datarequestprocessingresults_loggedin', 'email,popup'),
(737, 'message', 'message_provider_tool_dataprivacy_datarequestprocessingresults_loggedoff', 'email,popup'),
(738, 'message', 'airnotifier_provider_tool_dataprivacy_notifyexceptions_permitted', 'permitted'),
(739, 'message', 'email_provider_tool_dataprivacy_notifyexceptions_permitted', 'permitted'),
(740, 'message', 'jabber_provider_tool_dataprivacy_notifyexceptions_permitted', 'permitted'),
(741, 'message', 'popup_provider_tool_dataprivacy_notifyexceptions_permitted', 'permitted'),
(742, 'message', 'message_provider_tool_dataprivacy_notifyexceptions_loggedin', 'email'),
(743, 'message', 'message_provider_tool_dataprivacy_notifyexceptions_loggedoff', 'email'),
(744, 'tool_dbtransfer', 'version', '2019111800'),
(745, 'tool_filetypes', 'version', '2019111800'),
(746, 'tool_generator', 'version', '2019111800'),
(747, 'tool_health', 'version', '2019111800'),
(748, 'tool_httpsreplace', 'version', '2019111800'),
(749, 'tool_innodb', 'version', '2019111800'),
(750, 'tool_installaddon', 'version', '2019111800'),
(751, 'tool_langimport', 'version', '2019111800'),
(752, 'tool_log', 'version', '2019111800'),
(754, 'tool_log', 'enabled_stores', 'logstore_standard'),
(755, 'tool_lp', 'version', '2019111800'),
(756, 'tool_lpimportcsv', 'version', '2019111800'),
(757, 'tool_lpmigrate', 'version', '2019111800'),
(758, 'tool_messageinbound', 'version', '2019111800'),
(759, 'message', 'airnotifier_provider_tool_messageinbound_invalidrecipienthandler_permitted', 'permitted'),
(760, 'message', 'email_provider_tool_messageinbound_invalidrecipienthandler_permitted', 'permitted'),
(761, 'message', 'jabber_provider_tool_messageinbound_invalidrecipienthandler_permitted', 'permitted'),
(762, 'message', 'popup_provider_tool_messageinbound_invalidrecipienthandler_permitted', 'permitted'),
(763, 'message', 'message_provider_tool_messageinbound_invalidrecipienthandler_loggedin', 'email'),
(764, 'message', 'message_provider_tool_messageinbound_invalidrecipienthandler_loggedoff', 'email'),
(765, 'message', 'airnotifier_provider_tool_messageinbound_messageprocessingerror_permitted', 'permitted'),
(766, 'message', 'email_provider_tool_messageinbound_messageprocessingerror_permitted', 'permitted'),
(767, 'message', 'jabber_provider_tool_messageinbound_messageprocessingerror_permitted', 'permitted'),
(768, 'message', 'popup_provider_tool_messageinbound_messageprocessingerror_permitted', 'permitted'),
(769, 'message', 'message_provider_tool_messageinbound_messageprocessingerror_loggedin', 'email'),
(770, 'message', 'message_provider_tool_messageinbound_messageprocessingerror_loggedoff', 'email'),
(771, 'message', 'airnotifier_provider_tool_messageinbound_messageprocessingsuccess_permitted', 'permitted'),
(772, 'message', 'email_provider_tool_messageinbound_messageprocessingsuccess_permitted', 'permitted'),
(773, 'message', 'jabber_provider_tool_messageinbound_messageprocessingsuccess_permitted', 'permitted'),
(774, 'message', 'popup_provider_tool_messageinbound_messageprocessingsuccess_permitted', 'permitted'),
(775, 'message', 'message_provider_tool_messageinbound_messageprocessingsuccess_loggedin', 'email'),
(776, 'message', 'message_provider_tool_messageinbound_messageprocessingsuccess_loggedoff', 'email'),
(777, 'tool_mobile', 'version', '2019111800'),
(778, 'tool_monitor', 'version', '2019111800'),
(779, 'message', 'airnotifier_provider_tool_monitor_notification_permitted', 'permitted'),
(780, 'message', 'email_provider_tool_monitor_notification_permitted', 'permitted'),
(781, 'message', 'jabber_provider_tool_monitor_notification_permitted', 'permitted'),
(782, 'message', 'popup_provider_tool_monitor_notification_permitted', 'permitted'),
(783, 'message', 'message_provider_tool_monitor_notification_loggedin', 'email'),
(784, 'message', 'message_provider_tool_monitor_notification_loggedoff', 'email'),
(785, 'tool_multilangupgrade', 'version', '2019111800'),
(786, 'tool_oauth2', 'version', '2019111800'),
(787, 'tool_phpunit', 'version', '2019111800'),
(788, 'tool_policy', 'version', '2019111800'),
(789, 'tool_profiling', 'version', '2019111800'),
(790, 'tool_recyclebin', 'version', '2019111800'),
(791, 'tool_replace', 'version', '2019111800'),
(792, 'tool_spamcleaner', 'version', '2019111800'),
(793, 'tool_task', 'version', '2019111800'),
(794, 'tool_templatelibrary', 'version', '2019111800'),
(795, 'tool_unsuproles', 'version', '2019111800'),
(797, 'tool_uploadcourse', 'version', '2019111800'),
(798, 'tool_uploaduser', 'version', '2019111800'),
(799, 'tool_usertours', 'version', '2019111800'),
(801, 'tool_xmldb', 'version', '2019111800'),
(802, 'cachestore_apcu', 'version', '2019111800'),
(803, 'cachestore_file', 'version', '2019111800'),
(804, 'cachestore_memcached', 'version', '2019111800'),
(805, 'cachestore_mongodb', 'version', '2019111800'),
(806, 'cachestore_redis', 'version', '2019111800'),
(807, 'cachestore_session', 'version', '2019111800'),
(808, 'cachestore_static', 'version', '2019111800'),
(809, 'cachelock_file', 'version', '2019111800'),
(810, 'fileconverter_googledrive', 'version', '2019111800'),
(811, 'fileconverter_unoconv', 'version', '2019111800'),
(813, 'theme_boost', 'version', '2019111800'),
(814, 'theme_classic', 'version', '2019111800'),
(815, 'assignsubmission_comments', 'version', '2019111800'),
(817, 'assignsubmission_file', 'sortorder', '1'),
(818, 'assignsubmission_comments', 'sortorder', '2'),
(819, 'assignsubmission_onlinetext', 'sortorder', '0'),
(820, 'assignsubmission_file', 'version', '2019111800'),
(821, 'assignsubmission_onlinetext', 'version', '2019111800'),
(823, 'assignfeedback_comments', 'version', '2019111800'),
(825, 'assignfeedback_comments', 'sortorder', '0'),
(826, 'assignfeedback_editpdf', 'sortorder', '1'),
(827, 'assignfeedback_file', 'sortorder', '3'),
(828, 'assignfeedback_offline', 'sortorder', '2'),
(829, 'assignfeedback_editpdf', 'version', '2019111800'),
(831, 'assignfeedback_file', 'version', '2019111800'),
(833, 'assignfeedback_offline', 'version', '2019111800'),
(834, 'assignment_offline', 'version', '2019111800'),
(835, 'assignment_online', 'version', '2019111800'),
(836, 'assignment_upload', 'version', '2019111800'),
(837, 'assignment_uploadsingle', 'version', '2019111800'),
(838, 'booktool_exportimscp', 'version', '2019111800'),
(839, 'booktool_importhtml', 'version', '2019111800'),
(840, 'booktool_print', 'version', '2019111800'),
(841, 'datafield_checkbox', 'version', '2019111800'),
(842, 'datafield_date', 'version', '2019111800'),
(843, 'datafield_file', 'version', '2019111800'),
(844, 'datafield_latlong', 'version', '2019111800'),
(845, 'datafield_menu', 'version', '2019111800'),
(846, 'datafield_multimenu', 'version', '2019111800'),
(847, 'datafield_number', 'version', '2019111800'),
(848, 'datafield_picture', 'version', '2019111800'),
(849, 'datafield_radiobutton', 'version', '2019111800'),
(850, 'datafield_text', 'version', '2019111800'),
(851, 'datafield_textarea', 'version', '2019111800'),
(852, 'datafield_url', 'version', '2019111800'),
(853, 'datapreset_imagegallery', 'version', '2019111800'),
(854, 'forumreport_summary', 'version', '2019111800'),
(855, 'ltiservice_basicoutcomes', 'version', '2019111800'),
(856, 'ltiservice_gradebookservices', 'version', '2019111800'),
(857, 'ltiservice_memberships', 'version', '2019111800'),
(858, 'ltiservice_profile', 'version', '2019111800'),
(859, 'ltiservice_toolproxy', 'version', '2019111800'),
(860, 'ltiservice_toolsettings', 'version', '2019111800'),
(861, 'quiz_grading', 'version', '2019111800'),
(863, 'quiz_overview', 'version', '2019111800'),
(865, 'quiz_responses', 'version', '2019111800');
INSERT INTO `mdl_config_plugins` (`id`, `plugin`, `name`, `value`) VALUES
(867, 'quiz_statistics', 'version', '2019111800'),
(869, 'quizaccess_delaybetweenattempts', 'version', '2019111800'),
(870, 'quizaccess_ipaddress', 'version', '2019111800'),
(871, 'quizaccess_numattempts', 'version', '2019111800'),
(872, 'quizaccess_offlineattempts', 'version', '2019111800'),
(873, 'quizaccess_openclosedate', 'version', '2019111800'),
(874, 'quizaccess_password', 'version', '2019111800'),
(875, 'quizaccess_safebrowser', 'version', '2019111800'),
(876, 'quizaccess_securewindow', 'version', '2019111800'),
(877, 'quizaccess_timelimit', 'version', '2019111800'),
(878, 'scormreport_basic', 'version', '2019111800'),
(879, 'scormreport_graphs', 'version', '2019111800'),
(880, 'scormreport_interactions', 'version', '2019111800'),
(881, 'scormreport_objectives', 'version', '2019111800'),
(882, 'workshopform_accumulative', 'version', '2019111800'),
(884, 'workshopform_comments', 'version', '2019111800'),
(886, 'workshopform_numerrors', 'version', '2019111800'),
(888, 'workshopform_rubric', 'version', '2019111800'),
(890, 'workshopallocation_manual', 'version', '2019111800'),
(891, 'workshopallocation_random', 'version', '2019111800'),
(892, 'workshopallocation_scheduled', 'version', '2019111800'),
(893, 'workshopeval_best', 'version', '2019111800'),
(894, 'atto_accessibilitychecker', 'version', '2019111800'),
(895, 'atto_accessibilityhelper', 'version', '2019111800'),
(896, 'atto_align', 'version', '2019111800'),
(897, 'atto_backcolor', 'version', '2019111800'),
(898, 'atto_bold', 'version', '2019111800'),
(899, 'atto_charmap', 'version', '2019111800'),
(900, 'atto_clear', 'version', '2019111800'),
(901, 'atto_collapse', 'version', '2019111800'),
(902, 'atto_emojipicker', 'version', '2019111800'),
(903, 'atto_emoticon', 'version', '2019111800'),
(904, 'atto_equation', 'version', '2019111800'),
(905, 'atto_fontcolor', 'version', '2019111800'),
(906, 'atto_h5p', 'version', '2019111800'),
(907, 'atto_html', 'version', '2019111800'),
(908, 'atto_image', 'version', '2019111800'),
(909, 'atto_indent', 'version', '2019111800'),
(910, 'atto_italic', 'version', '2019111800'),
(911, 'atto_link', 'version', '2019111800'),
(912, 'atto_managefiles', 'version', '2019111800'),
(913, 'atto_media', 'version', '2019111800'),
(914, 'atto_noautolink', 'version', '2019111800'),
(915, 'atto_orderedlist', 'version', '2019111800'),
(916, 'atto_recordrtc', 'version', '2019111800'),
(917, 'atto_rtl', 'version', '2019111800'),
(918, 'atto_strike', 'version', '2019111800'),
(919, 'atto_subscript', 'version', '2019111800'),
(920, 'atto_superscript', 'version', '2019111800'),
(921, 'atto_table', 'version', '2019111800'),
(922, 'atto_title', 'version', '2019111800'),
(923, 'atto_underline', 'version', '2019111800'),
(924, 'atto_undo', 'version', '2019111800'),
(925, 'atto_unorderedlist', 'version', '2019111800'),
(926, 'tinymce_ctrlhelp', 'version', '2019111800'),
(927, 'tinymce_managefiles', 'version', '2019111800'),
(928, 'tinymce_moodleemoticon', 'version', '2019111800'),
(929, 'tinymce_moodleimage', 'version', '2019111800'),
(930, 'tinymce_moodlemedia', 'version', '2019111800'),
(931, 'tinymce_moodlenolink', 'version', '2019111800'),
(932, 'tinymce_pdw', 'version', '2019111800'),
(933, 'tinymce_spellchecker', 'version', '2019111800'),
(935, 'tinymce_wrap', 'version', '2019111800'),
(936, 'logstore_database', 'version', '2019111800'),
(937, 'logstore_legacy', 'version', '2019111800'),
(938, 'logstore_standard', 'version', '2019111800'),
(939, 'block_configurable_reports', 'version', '2019122000'),
(940, 'tool_dataprivacy', 'contactdataprotectionofficer', '0'),
(941, 'tool_dataprivacy', 'automaticdeletionrequests', '1'),
(942, 'tool_dataprivacy', 'privacyrequestexpiry', '604800'),
(943, 'tool_dataprivacy', 'requireallenddatesforuserdeletion', '1'),
(944, 'tool_dataprivacy', 'showdataretentionsummary', '1'),
(945, 'tool_log', 'exportlog', '1'),
(946, 'analytics', 'logstore', 'logstore_standard'),
(947, 'assign', 'feedback_plugin_for_gradebook', 'assignfeedback_comments'),
(948, 'assign', 'showrecentsubmissions', '0'),
(949, 'assign', 'submissionreceipts', '1'),
(950, 'assign', 'submissionstatement', 'This submission is my own work, except where I have acknowledged the use of the works of other people.'),
(951, 'assign', 'submissionstatementteamsubmission', 'This submission is the work of my group, except where we have acknowledged the use of the works of other people.'),
(952, 'assign', 'submissionstatementteamsubmissionallsubmit', 'This submission is my own work as a group member, except where I have acknowledged the use of the works of other people.'),
(953, 'assign', 'maxperpage', '-1'),
(954, 'assign', 'alwaysshowdescription', '1'),
(955, 'assign', 'alwaysshowdescription_adv', ''),
(956, 'assign', 'alwaysshowdescription_locked', ''),
(957, 'assign', 'allowsubmissionsfromdate', '0'),
(958, 'assign', 'allowsubmissionsfromdate_enabled', '1'),
(959, 'assign', 'allowsubmissionsfromdate_adv', ''),
(960, 'assign', 'duedate', '604800'),
(961, 'assign', 'duedate_enabled', '1'),
(962, 'assign', 'duedate_adv', ''),
(963, 'assign', 'cutoffdate', '1209600'),
(964, 'assign', 'cutoffdate_enabled', ''),
(965, 'assign', 'cutoffdate_adv', ''),
(966, 'assign', 'gradingduedate', '1209600'),
(967, 'assign', 'gradingduedate_enabled', '1'),
(968, 'assign', 'gradingduedate_adv', ''),
(969, 'assign', 'submissiondrafts', '0'),
(970, 'assign', 'submissiondrafts_adv', ''),
(971, 'assign', 'submissiondrafts_locked', ''),
(972, 'assign', 'requiresubmissionstatement', '0'),
(973, 'assign', 'requiresubmissionstatement_adv', ''),
(974, 'assign', 'requiresubmissionstatement_locked', ''),
(975, 'assign', 'attemptreopenmethod', 'none'),
(976, 'assign', 'attemptreopenmethod_adv', ''),
(977, 'assign', 'attemptreopenmethod_locked', ''),
(978, 'assign', 'maxattempts', '-1'),
(979, 'assign', 'maxattempts_adv', ''),
(980, 'assign', 'maxattempts_locked', ''),
(981, 'assign', 'teamsubmission', '0'),
(982, 'assign', 'teamsubmission_adv', ''),
(983, 'assign', 'teamsubmission_locked', ''),
(984, 'assign', 'preventsubmissionnotingroup', '0'),
(985, 'assign', 'preventsubmissionnotingroup_adv', ''),
(986, 'assign', 'preventsubmissionnotingroup_locked', ''),
(987, 'assign', 'requireallteammemberssubmit', '0'),
(988, 'assign', 'requireallteammemberssubmit_adv', ''),
(989, 'assign', 'requireallteammemberssubmit_locked', ''),
(990, 'assign', 'teamsubmissiongroupingid', ''),
(991, 'assign', 'teamsubmissiongroupingid_adv', ''),
(992, 'assign', 'sendnotifications', '0'),
(993, 'assign', 'sendnotifications_adv', ''),
(994, 'assign', 'sendnotifications_locked', ''),
(995, 'assign', 'sendlatenotifications', '0'),
(996, 'assign', 'sendlatenotifications_adv', ''),
(997, 'assign', 'sendlatenotifications_locked', ''),
(998, 'assign', 'sendstudentnotifications', '1'),
(999, 'assign', 'sendstudentnotifications_adv', ''),
(1000, 'assign', 'sendstudentnotifications_locked', ''),
(1001, 'assign', 'blindmarking', '0'),
(1002, 'assign', 'blindmarking_adv', ''),
(1003, 'assign', 'blindmarking_locked', ''),
(1004, 'assign', 'hidegrader', '0'),
(1005, 'assign', 'hidegrader_adv', ''),
(1006, 'assign', 'hidegrader_locked', ''),
(1007, 'assign', 'markingworkflow', '0'),
(1008, 'assign', 'markingworkflow_adv', ''),
(1009, 'assign', 'markingworkflow_locked', ''),
(1010, 'assign', 'markingallocation', '0'),
(1011, 'assign', 'markingallocation_adv', ''),
(1012, 'assign', 'markingallocation_locked', ''),
(1013, 'assignsubmission_file', 'default', '1'),
(1014, 'assignsubmission_file', 'maxfiles', '20'),
(1015, 'assignsubmission_file', 'filetypes', ''),
(1016, 'assignsubmission_file', 'maxbytes', '0'),
(1017, 'assignsubmission_onlinetext', 'default', '0'),
(1018, 'assignfeedback_comments', 'default', '1'),
(1019, 'assignfeedback_comments', 'inline', '0'),
(1020, 'assignfeedback_comments', 'inline_adv', ''),
(1021, 'assignfeedback_comments', 'inline_locked', ''),
(1022, 'assignfeedback_editpdf', 'default', '1'),
(1023, 'assignfeedback_editpdf', 'stamps', '/cross.png'),
(1024, 'assignfeedback_file', 'default', '0'),
(1025, 'assignfeedback_offline', 'default', '0'),
(1026, 'book', 'numberingoptions', '0,1,2,3'),
(1027, 'book', 'navoptions', '0,1,2'),
(1028, 'book', 'numbering', '1'),
(1029, 'book', 'navstyle', '1'),
(1030, 'resource', 'framesize', '130'),
(1031, 'resource', 'displayoptions', '0,1,4,5,6'),
(1032, 'resource', 'printintro', '1'),
(1033, 'resource', 'display', '0'),
(1034, 'resource', 'showsize', '0'),
(1035, 'resource', 'showtype', '0'),
(1036, 'resource', 'showdate', '0'),
(1037, 'resource', 'popupwidth', '620'),
(1038, 'resource', 'popupheight', '450'),
(1039, 'resource', 'filterfiles', '0'),
(1040, 'folder', 'showexpanded', '1'),
(1041, 'folder', 'maxsizetodownload', '0'),
(1042, 'imscp', 'keepold', '1'),
(1043, 'imscp', 'keepold_adv', ''),
(1044, 'label', 'dndmedia', '1'),
(1045, 'label', 'dndresizewidth', '400'),
(1046, 'label', 'dndresizeheight', '400'),
(1047, 'mod_lesson', 'mediafile', ''),
(1048, 'mod_lesson', 'mediafile_adv', '1'),
(1049, 'mod_lesson', 'mediawidth', '640'),
(1050, 'mod_lesson', 'mediaheight', '480'),
(1051, 'mod_lesson', 'mediaclose', '0'),
(1052, 'mod_lesson', 'progressbar', '0'),
(1053, 'mod_lesson', 'progressbar_adv', ''),
(1054, 'mod_lesson', 'ongoing', '0'),
(1055, 'mod_lesson', 'ongoing_adv', '1'),
(1056, 'mod_lesson', 'displayleftmenu', '0'),
(1057, 'mod_lesson', 'displayleftmenu_adv', ''),
(1058, 'mod_lesson', 'displayleftif', '0'),
(1059, 'mod_lesson', 'displayleftif_adv', '1'),
(1060, 'mod_lesson', 'slideshow', '0'),
(1061, 'mod_lesson', 'slideshow_adv', '1'),
(1062, 'mod_lesson', 'slideshowwidth', '640'),
(1063, 'mod_lesson', 'slideshowheight', '480'),
(1064, 'mod_lesson', 'slideshowbgcolor', '#FFFFFF'),
(1065, 'mod_lesson', 'maxanswers', '5'),
(1066, 'mod_lesson', 'maxanswers_adv', '1'),
(1067, 'mod_lesson', 'defaultfeedback', '0'),
(1068, 'mod_lesson', 'defaultfeedback_adv', '1'),
(1069, 'mod_lesson', 'activitylink', ''),
(1070, 'mod_lesson', 'activitylink_adv', '1'),
(1071, 'mod_lesson', 'timelimit', '0'),
(1072, 'mod_lesson', 'timelimit_adv', ''),
(1073, 'mod_lesson', 'password', '0'),
(1074, 'mod_lesson', 'password_adv', '1'),
(1075, 'mod_lesson', 'modattempts', '0'),
(1076, 'mod_lesson', 'modattempts_adv', ''),
(1077, 'mod_lesson', 'displayreview', '0'),
(1078, 'mod_lesson', 'displayreview_adv', ''),
(1079, 'mod_lesson', 'maximumnumberofattempts', '1'),
(1080, 'mod_lesson', 'maximumnumberofattempts_adv', ''),
(1081, 'mod_lesson', 'defaultnextpage', '0'),
(1082, 'mod_lesson', 'defaultnextpage_adv', '1'),
(1083, 'mod_lesson', 'numberofpagestoshow', '1'),
(1084, 'mod_lesson', 'numberofpagestoshow_adv', '1'),
(1085, 'mod_lesson', 'practice', '0'),
(1086, 'mod_lesson', 'practice_adv', ''),
(1087, 'mod_lesson', 'customscoring', '1'),
(1088, 'mod_lesson', 'customscoring_adv', '1'),
(1089, 'mod_lesson', 'retakesallowed', '0'),
(1090, 'mod_lesson', 'retakesallowed_adv', ''),
(1091, 'mod_lesson', 'handlingofretakes', '0'),
(1092, 'mod_lesson', 'handlingofretakes_adv', '1'),
(1093, 'mod_lesson', 'minimumnumberofquestions', '0'),
(1094, 'mod_lesson', 'minimumnumberofquestions_adv', '1'),
(1095, 'page', 'displayoptions', '5'),
(1096, 'page', 'printheading', '1'),
(1097, 'page', 'printintro', '0'),
(1098, 'page', 'printlastmodified', '1'),
(1099, 'page', 'display', '5'),
(1100, 'page', 'popupwidth', '620'),
(1101, 'page', 'popupheight', '450'),
(1102, 'quiz', 'timelimit', '0'),
(1103, 'quiz', 'timelimit_adv', ''),
(1104, 'quiz', 'overduehandling', 'autosubmit'),
(1105, 'quiz', 'overduehandling_adv', ''),
(1106, 'quiz', 'graceperiod', '86400'),
(1107, 'quiz', 'graceperiod_adv', ''),
(1108, 'quiz', 'graceperiodmin', '60'),
(1109, 'quiz', 'attempts', '0'),
(1110, 'quiz', 'attempts_adv', ''),
(1111, 'quiz', 'grademethod', '1'),
(1112, 'quiz', 'grademethod_adv', ''),
(1113, 'quiz', 'maximumgrade', '10'),
(1114, 'quiz', 'questionsperpage', '1'),
(1115, 'quiz', 'questionsperpage_adv', ''),
(1116, 'quiz', 'navmethod', 'free'),
(1117, 'quiz', 'navmethod_adv', '1'),
(1118, 'quiz', 'shuffleanswers', '1'),
(1119, 'quiz', 'shuffleanswers_adv', ''),
(1120, 'quiz', 'preferredbehaviour', 'deferredfeedback'),
(1121, 'quiz', 'canredoquestions', '0'),
(1122, 'quiz', 'canredoquestions_adv', '1'),
(1123, 'quiz', 'attemptonlast', '0'),
(1124, 'quiz', 'attemptonlast_adv', '1'),
(1125, 'quiz', 'reviewattempt', '69904'),
(1126, 'quiz', 'reviewcorrectness', '69904'),
(1127, 'quiz', 'reviewmarks', '69904'),
(1128, 'quiz', 'reviewspecificfeedback', '69904'),
(1129, 'quiz', 'reviewgeneralfeedback', '69904'),
(1130, 'quiz', 'reviewrightanswer', '69904'),
(1131, 'quiz', 'reviewoverallfeedback', '4368'),
(1132, 'quiz', 'showuserpicture', '0'),
(1133, 'quiz', 'showuserpicture_adv', ''),
(1134, 'quiz', 'decimalpoints', '2'),
(1135, 'quiz', 'decimalpoints_adv', ''),
(1136, 'quiz', 'questiondecimalpoints', '-1'),
(1137, 'quiz', 'questiondecimalpoints_adv', '1'),
(1138, 'quiz', 'showblocks', '0'),
(1139, 'quiz', 'showblocks_adv', '1'),
(1140, 'quiz', 'password', ''),
(1141, 'quiz', 'password_adv', ''),
(1142, 'quiz', 'subnet', ''),
(1143, 'quiz', 'subnet_adv', '1'),
(1144, 'quiz', 'delay1', '0'),
(1145, 'quiz', 'delay1_adv', '1'),
(1146, 'quiz', 'delay2', '0'),
(1147, 'quiz', 'delay2_adv', '1'),
(1148, 'quiz', 'browsersecurity', '-'),
(1149, 'quiz', 'browsersecurity_adv', '1'),
(1150, 'quiz', 'initialnumfeedbacks', '2'),
(1151, 'quiz', 'autosaveperiod', '60'),
(1152, 'scorm', 'displaycoursestructure', '0'),
(1153, 'scorm', 'displaycoursestructure_adv', ''),
(1154, 'scorm', 'popup', '0'),
(1155, 'scorm', 'popup_adv', ''),
(1156, 'scorm', 'displayactivityname', '1'),
(1157, 'scorm', 'framewidth', '100'),
(1158, 'scorm', 'framewidth_adv', '1'),
(1159, 'scorm', 'frameheight', '500'),
(1160, 'scorm', 'frameheight_adv', '1'),
(1161, 'scorm', 'winoptgrp_adv', '1'),
(1162, 'scorm', 'scrollbars', '0'),
(1163, 'scorm', 'directories', '0'),
(1164, 'scorm', 'location', '0'),
(1165, 'scorm', 'menubar', '0'),
(1166, 'scorm', 'toolbar', '0'),
(1167, 'scorm', 'status', '0'),
(1168, 'scorm', 'skipview', '0'),
(1169, 'scorm', 'skipview_adv', '1'),
(1170, 'scorm', 'hidebrowse', '0'),
(1171, 'scorm', 'hidebrowse_adv', '1'),
(1172, 'scorm', 'hidetoc', '0'),
(1173, 'scorm', 'hidetoc_adv', '1'),
(1174, 'scorm', 'nav', '1'),
(1175, 'scorm', 'nav_adv', '1'),
(1176, 'scorm', 'navpositionleft', '-100'),
(1177, 'scorm', 'navpositionleft_adv', '1'),
(1178, 'scorm', 'navpositiontop', '-100'),
(1179, 'scorm', 'navpositiontop_adv', '1'),
(1180, 'scorm', 'collapsetocwinsize', '767'),
(1181, 'scorm', 'collapsetocwinsize_adv', '1'),
(1182, 'scorm', 'displayattemptstatus', '1'),
(1183, 'scorm', 'displayattemptstatus_adv', ''),
(1184, 'scorm', 'grademethod', '1'),
(1185, 'scorm', 'maxgrade', '100'),
(1186, 'scorm', 'maxattempt', '0'),
(1187, 'scorm', 'whatgrade', '0'),
(1188, 'scorm', 'forcecompleted', '0'),
(1189, 'scorm', 'forcenewattempt', '0'),
(1190, 'scorm', 'autocommit', '0'),
(1191, 'scorm', 'masteryoverride', '1'),
(1192, 'scorm', 'lastattemptlock', '0'),
(1193, 'scorm', 'auto', '0'),
(1194, 'scorm', 'updatefreq', '0'),
(1195, 'scorm', 'scormstandard', '0'),
(1196, 'scorm', 'allowtypeexternal', '0'),
(1197, 'scorm', 'allowtypelocalsync', '0'),
(1198, 'scorm', 'allowtypeexternalaicc', '0'),
(1199, 'scorm', 'allowaicchacp', '0'),
(1200, 'scorm', 'aicchacptimeout', '30'),
(1201, 'scorm', 'aicchacpkeepsessiondata', '1'),
(1202, 'scorm', 'aiccuserid', '1'),
(1203, 'scorm', 'forcejavascript', '1'),
(1204, 'scorm', 'allowapidebug', '0'),
(1205, 'scorm', 'apidebugmask', '.*'),
(1206, 'scorm', 'protectpackagedownloads', '0'),
(1207, 'url', 'framesize', '130'),
(1208, 'url', 'secretphrase', ''),
(1209, 'url', 'rolesinparams', '0'),
(1210, 'url', 'displayoptions', '0,1,5,6'),
(1211, 'url', 'printintro', '1'),
(1212, 'url', 'display', '0'),
(1213, 'url', 'popupwidth', '620'),
(1214, 'url', 'popupheight', '450'),
(1215, 'workshop', 'grade', '80'),
(1216, 'workshop', 'gradinggrade', '20'),
(1217, 'workshop', 'gradedecimals', '0'),
(1218, 'workshop', 'maxbytes', '0'),
(1219, 'workshop', 'strategy', 'accumulative'),
(1220, 'workshop', 'examplesmode', '0'),
(1221, 'workshopallocation_random', 'numofreviews', '5'),
(1222, 'workshopform_numerrors', 'grade0', 'No'),
(1223, 'workshopform_numerrors', 'grade1', 'Yes'),
(1224, 'workshopeval_best', 'comparison', '5'),
(1225, 'tool_recyclebin', 'coursebinenable', '1'),
(1226, 'tool_recyclebin', 'coursebinexpiry', '604800'),
(1227, 'tool_recyclebin', 'categorybinenable', '1'),
(1228, 'tool_recyclebin', 'categorybinexpiry', '604800'),
(1229, 'tool_recyclebin', 'autohide', '1'),
(1230, 'antivirus_clamav', 'runningmethod', 'commandline'),
(1231, 'antivirus_clamav', 'pathtoclam', ''),
(1232, 'antivirus_clamav', 'pathtounixsocket', ''),
(1233, 'antivirus_clamav', 'clamfailureonupload', 'donothing'),
(1234, 'auth_cas', 'field_map_firstname', ''),
(1235, 'auth_cas', 'field_updatelocal_firstname', 'oncreate'),
(1236, 'auth_cas', 'field_updateremote_firstname', '0'),
(1237, 'auth_cas', 'field_lock_firstname', 'unlocked'),
(1238, 'auth_cas', 'field_map_lastname', ''),
(1239, 'auth_cas', 'field_updatelocal_lastname', 'oncreate'),
(1240, 'auth_cas', 'field_updateremote_lastname', '0'),
(1241, 'auth_cas', 'field_lock_lastname', 'unlocked'),
(1242, 'auth_cas', 'field_map_email', ''),
(1243, 'auth_cas', 'field_updatelocal_email', 'oncreate'),
(1244, 'auth_cas', 'field_updateremote_email', '0'),
(1245, 'auth_cas', 'field_lock_email', 'unlocked'),
(1246, 'auth_cas', 'field_map_city', ''),
(1247, 'auth_cas', 'field_updatelocal_city', 'oncreate'),
(1248, 'auth_cas', 'field_updateremote_city', '0'),
(1249, 'auth_cas', 'field_lock_city', 'unlocked'),
(1250, 'auth_cas', 'field_map_country', ''),
(1251, 'auth_cas', 'field_updatelocal_country', 'oncreate'),
(1252, 'auth_cas', 'field_updateremote_country', '0'),
(1253, 'auth_cas', 'field_lock_country', 'unlocked'),
(1254, 'auth_cas', 'field_map_lang', ''),
(1255, 'auth_cas', 'field_updatelocal_lang', 'oncreate'),
(1256, 'auth_cas', 'field_updateremote_lang', '0'),
(1257, 'auth_cas', 'field_lock_lang', 'unlocked'),
(1258, 'auth_cas', 'field_map_description', ''),
(1259, 'auth_cas', 'field_updatelocal_description', 'oncreate'),
(1260, 'auth_cas', 'field_updateremote_description', '0'),
(1261, 'auth_cas', 'field_lock_description', 'unlocked'),
(1262, 'auth_cas', 'field_map_url', ''),
(1263, 'auth_cas', 'field_updatelocal_url', 'oncreate'),
(1264, 'auth_cas', 'field_updateremote_url', '0'),
(1265, 'auth_cas', 'field_lock_url', 'unlocked'),
(1266, 'auth_cas', 'field_map_idnumber', ''),
(1267, 'auth_cas', 'field_updatelocal_idnumber', 'oncreate'),
(1268, 'auth_cas', 'field_updateremote_idnumber', '0'),
(1269, 'auth_cas', 'field_lock_idnumber', 'unlocked'),
(1270, 'auth_cas', 'field_map_institution', ''),
(1271, 'auth_cas', 'field_updatelocal_institution', 'oncreate'),
(1272, 'auth_cas', 'field_updateremote_institution', '0'),
(1273, 'auth_cas', 'field_lock_institution', 'unlocked'),
(1274, 'auth_cas', 'field_map_department', ''),
(1275, 'auth_cas', 'field_updatelocal_department', 'oncreate'),
(1276, 'auth_cas', 'field_updateremote_department', '0'),
(1277, 'auth_cas', 'field_lock_department', 'unlocked'),
(1278, 'auth_cas', 'field_map_phone1', ''),
(1279, 'auth_cas', 'field_updatelocal_phone1', 'oncreate'),
(1280, 'auth_cas', 'field_updateremote_phone1', '0'),
(1281, 'auth_cas', 'field_lock_phone1', 'unlocked'),
(1282, 'auth_cas', 'field_map_phone2', ''),
(1283, 'auth_cas', 'field_updatelocal_phone2', 'oncreate'),
(1284, 'auth_cas', 'field_updateremote_phone2', '0'),
(1285, 'auth_cas', 'field_lock_phone2', 'unlocked'),
(1286, 'auth_cas', 'field_map_address', ''),
(1287, 'auth_cas', 'field_updatelocal_address', 'oncreate'),
(1288, 'auth_cas', 'field_updateremote_address', '0'),
(1289, 'auth_cas', 'field_lock_address', 'unlocked'),
(1290, 'auth_cas', 'field_map_firstnamephonetic', ''),
(1291, 'auth_cas', 'field_updatelocal_firstnamephonetic', 'oncreate'),
(1292, 'auth_cas', 'field_updateremote_firstnamephonetic', '0'),
(1293, 'auth_cas', 'field_lock_firstnamephonetic', 'unlocked'),
(1294, 'auth_cas', 'field_map_lastnamephonetic', ''),
(1295, 'auth_cas', 'field_updatelocal_lastnamephonetic', 'oncreate'),
(1296, 'auth_cas', 'field_updateremote_lastnamephonetic', '0'),
(1297, 'auth_cas', 'field_lock_lastnamephonetic', 'unlocked'),
(1298, 'auth_cas', 'field_map_middlename', ''),
(1299, 'auth_cas', 'field_updatelocal_middlename', 'oncreate'),
(1300, 'auth_cas', 'field_updateremote_middlename', '0'),
(1301, 'auth_cas', 'field_lock_middlename', 'unlocked'),
(1302, 'auth_cas', 'field_map_alternatename', ''),
(1303, 'auth_cas', 'field_updatelocal_alternatename', 'oncreate'),
(1304, 'auth_cas', 'field_updateremote_alternatename', '0'),
(1305, 'auth_cas', 'field_lock_alternatename', 'unlocked'),
(1306, 'auth_email', 'recaptcha', '0'),
(1307, 'auth_email', 'field_lock_firstname', 'unlocked'),
(1308, 'auth_email', 'field_lock_lastname', 'unlocked'),
(1309, 'auth_email', 'field_lock_email', 'unlocked'),
(1310, 'auth_email', 'field_lock_city', 'unlocked'),
(1311, 'auth_email', 'field_lock_country', 'unlocked'),
(1312, 'auth_email', 'field_lock_lang', 'unlocked'),
(1313, 'auth_email', 'field_lock_description', 'unlocked'),
(1314, 'auth_email', 'field_lock_url', 'unlocked'),
(1315, 'auth_email', 'field_lock_idnumber', 'unlocked'),
(1316, 'auth_email', 'field_lock_institution', 'unlocked'),
(1317, 'auth_email', 'field_lock_department', 'unlocked'),
(1318, 'auth_email', 'field_lock_phone1', 'unlocked'),
(1319, 'auth_email', 'field_lock_phone2', 'unlocked'),
(1320, 'auth_email', 'field_lock_address', 'unlocked'),
(1321, 'auth_email', 'field_lock_firstnamephonetic', 'unlocked'),
(1322, 'auth_email', 'field_lock_lastnamephonetic', 'unlocked'),
(1323, 'auth_email', 'field_lock_middlename', 'unlocked'),
(1324, 'auth_email', 'field_lock_alternatename', 'unlocked'),
(1325, 'auth_db', 'host', '127.0.0.1'),
(1326, 'auth_db', 'type', 'mysqli'),
(1327, 'auth_db', 'sybasequoting', '0'),
(1328, 'auth_db', 'name', ''),
(1329, 'auth_db', 'user', ''),
(1330, 'auth_db', 'pass', ''),
(1331, 'auth_db', 'table', ''),
(1332, 'auth_db', 'fielduser', ''),
(1333, 'auth_db', 'fieldpass', ''),
(1334, 'auth_db', 'passtype', 'plaintext'),
(1335, 'auth_db', 'extencoding', 'utf-8'),
(1336, 'auth_db', 'setupsql', ''),
(1337, 'auth_db', 'debugauthdb', '0'),
(1338, 'auth_db', 'changepasswordurl', ''),
(1339, 'auth_db', 'removeuser', '0'),
(1340, 'auth_db', 'updateusers', '0'),
(1341, 'auth_db', 'field_map_firstname', ''),
(1342, 'auth_db', 'field_updatelocal_firstname', 'oncreate'),
(1343, 'auth_db', 'field_updateremote_firstname', '0'),
(1344, 'auth_db', 'field_lock_firstname', 'unlocked'),
(1345, 'auth_db', 'field_map_lastname', ''),
(1346, 'auth_db', 'field_updatelocal_lastname', 'oncreate'),
(1347, 'auth_db', 'field_updateremote_lastname', '0'),
(1348, 'auth_db', 'field_lock_lastname', 'unlocked'),
(1349, 'auth_db', 'field_map_email', ''),
(1350, 'auth_db', 'field_updatelocal_email', 'oncreate'),
(1351, 'auth_db', 'field_updateremote_email', '0'),
(1352, 'auth_db', 'field_lock_email', 'unlocked'),
(1353, 'auth_db', 'field_map_city', ''),
(1354, 'auth_db', 'field_updatelocal_city', 'oncreate'),
(1355, 'auth_db', 'field_updateremote_city', '0'),
(1356, 'auth_db', 'field_lock_city', 'unlocked'),
(1357, 'auth_db', 'field_map_country', ''),
(1358, 'auth_db', 'field_updatelocal_country', 'oncreate'),
(1359, 'auth_db', 'field_updateremote_country', '0'),
(1360, 'auth_db', 'field_lock_country', 'unlocked'),
(1361, 'auth_db', 'field_map_lang', ''),
(1362, 'auth_db', 'field_updatelocal_lang', 'oncreate'),
(1363, 'auth_db', 'field_updateremote_lang', '0'),
(1364, 'auth_db', 'field_lock_lang', 'unlocked'),
(1365, 'auth_db', 'field_map_description', ''),
(1366, 'auth_db', 'field_updatelocal_description', 'oncreate'),
(1367, 'auth_db', 'field_updateremote_description', '0'),
(1368, 'auth_db', 'field_lock_description', 'unlocked'),
(1369, 'auth_db', 'field_map_url', ''),
(1370, 'auth_db', 'field_updatelocal_url', 'oncreate'),
(1371, 'auth_db', 'field_updateremote_url', '0'),
(1372, 'auth_db', 'field_lock_url', 'unlocked'),
(1373, 'auth_db', 'field_map_idnumber', ''),
(1374, 'auth_db', 'field_updatelocal_idnumber', 'oncreate'),
(1375, 'auth_db', 'field_updateremote_idnumber', '0'),
(1376, 'auth_db', 'field_lock_idnumber', 'unlocked'),
(1377, 'auth_db', 'field_map_institution', ''),
(1378, 'auth_db', 'field_updatelocal_institution', 'oncreate'),
(1379, 'auth_db', 'field_updateremote_institution', '0'),
(1380, 'auth_db', 'field_lock_institution', 'unlocked'),
(1381, 'auth_db', 'field_map_department', ''),
(1382, 'auth_db', 'field_updatelocal_department', 'oncreate'),
(1383, 'auth_db', 'field_updateremote_department', '0'),
(1384, 'auth_db', 'field_lock_department', 'unlocked'),
(1385, 'auth_db', 'field_map_phone1', ''),
(1386, 'auth_db', 'field_updatelocal_phone1', 'oncreate'),
(1387, 'auth_db', 'field_updateremote_phone1', '0'),
(1388, 'auth_db', 'field_lock_phone1', 'unlocked'),
(1389, 'auth_db', 'field_map_phone2', ''),
(1390, 'auth_db', 'field_updatelocal_phone2', 'oncreate'),
(1391, 'auth_db', 'field_updateremote_phone2', '0'),
(1392, 'auth_db', 'field_lock_phone2', 'unlocked'),
(1393, 'auth_db', 'field_map_address', ''),
(1394, 'auth_db', 'field_updatelocal_address', 'oncreate'),
(1395, 'auth_db', 'field_updateremote_address', '0'),
(1396, 'auth_db', 'field_lock_address', 'unlocked'),
(1397, 'auth_db', 'field_map_firstnamephonetic', ''),
(1398, 'auth_db', 'field_updatelocal_firstnamephonetic', 'oncreate'),
(1399, 'auth_db', 'field_updateremote_firstnamephonetic', '0'),
(1400, 'auth_db', 'field_lock_firstnamephonetic', 'unlocked'),
(1401, 'auth_db', 'field_map_lastnamephonetic', ''),
(1402, 'auth_db', 'field_updatelocal_lastnamephonetic', 'oncreate'),
(1403, 'auth_db', 'field_updateremote_lastnamephonetic', '0'),
(1404, 'auth_db', 'field_lock_lastnamephonetic', 'unlocked'),
(1405, 'auth_db', 'field_map_middlename', ''),
(1406, 'auth_db', 'field_updatelocal_middlename', 'oncreate'),
(1407, 'auth_db', 'field_updateremote_middlename', '0'),
(1408, 'auth_db', 'field_lock_middlename', 'unlocked'),
(1409, 'auth_db', 'field_map_alternatename', ''),
(1410, 'auth_db', 'field_updatelocal_alternatename', 'oncreate'),
(1411, 'auth_db', 'field_updateremote_alternatename', '0'),
(1412, 'auth_db', 'field_lock_alternatename', 'unlocked'),
(1413, 'auth_ldap', 'field_map_firstname', ''),
(1414, 'auth_ldap', 'field_updatelocal_firstname', 'oncreate'),
(1415, 'auth_ldap', 'field_updateremote_firstname', '0'),
(1416, 'auth_ldap', 'field_lock_firstname', 'unlocked'),
(1417, 'auth_ldap', 'field_map_lastname', ''),
(1418, 'auth_ldap', 'field_updatelocal_lastname', 'oncreate'),
(1419, 'auth_ldap', 'field_updateremote_lastname', '0'),
(1420, 'auth_ldap', 'field_lock_lastname', 'unlocked'),
(1421, 'auth_ldap', 'field_map_email', ''),
(1422, 'auth_ldap', 'field_updatelocal_email', 'oncreate'),
(1423, 'auth_ldap', 'field_updateremote_email', '0'),
(1424, 'auth_ldap', 'field_lock_email', 'unlocked'),
(1425, 'auth_ldap', 'field_map_city', ''),
(1426, 'auth_ldap', 'field_updatelocal_city', 'oncreate'),
(1427, 'auth_ldap', 'field_updateremote_city', '0'),
(1428, 'auth_ldap', 'field_lock_city', 'unlocked'),
(1429, 'auth_ldap', 'field_map_country', ''),
(1430, 'auth_ldap', 'field_updatelocal_country', 'oncreate'),
(1431, 'auth_ldap', 'field_updateremote_country', '0'),
(1432, 'auth_ldap', 'field_lock_country', 'unlocked'),
(1433, 'auth_ldap', 'field_map_lang', ''),
(1434, 'auth_ldap', 'field_updatelocal_lang', 'oncreate'),
(1435, 'auth_ldap', 'field_updateremote_lang', '0'),
(1436, 'auth_ldap', 'field_lock_lang', 'unlocked'),
(1437, 'auth_ldap', 'field_map_description', ''),
(1438, 'auth_ldap', 'field_updatelocal_description', 'oncreate'),
(1439, 'auth_ldap', 'field_updateremote_description', '0'),
(1440, 'auth_ldap', 'field_lock_description', 'unlocked'),
(1441, 'auth_ldap', 'field_map_url', ''),
(1442, 'auth_ldap', 'field_updatelocal_url', 'oncreate'),
(1443, 'auth_ldap', 'field_updateremote_url', '0'),
(1444, 'auth_ldap', 'field_lock_url', 'unlocked'),
(1445, 'auth_ldap', 'field_map_idnumber', ''),
(1446, 'auth_ldap', 'field_updatelocal_idnumber', 'oncreate'),
(1447, 'auth_ldap', 'field_updateremote_idnumber', '0'),
(1448, 'auth_ldap', 'field_lock_idnumber', 'unlocked'),
(1449, 'auth_ldap', 'field_map_institution', ''),
(1450, 'auth_ldap', 'field_updatelocal_institution', 'oncreate'),
(1451, 'auth_ldap', 'field_updateremote_institution', '0'),
(1452, 'auth_ldap', 'field_lock_institution', 'unlocked'),
(1453, 'auth_ldap', 'field_map_department', ''),
(1454, 'auth_ldap', 'field_updatelocal_department', 'oncreate'),
(1455, 'auth_ldap', 'field_updateremote_department', '0'),
(1456, 'auth_ldap', 'field_lock_department', 'unlocked'),
(1457, 'auth_ldap', 'field_map_phone1', ''),
(1458, 'auth_ldap', 'field_updatelocal_phone1', 'oncreate'),
(1459, 'auth_ldap', 'field_updateremote_phone1', '0'),
(1460, 'auth_ldap', 'field_lock_phone1', 'unlocked'),
(1461, 'auth_ldap', 'field_map_phone2', ''),
(1462, 'auth_ldap', 'field_updatelocal_phone2', 'oncreate'),
(1463, 'auth_ldap', 'field_updateremote_phone2', '0'),
(1464, 'auth_ldap', 'field_lock_phone2', 'unlocked'),
(1465, 'auth_ldap', 'field_map_address', ''),
(1466, 'auth_ldap', 'field_updatelocal_address', 'oncreate'),
(1467, 'auth_ldap', 'field_updateremote_address', '0'),
(1468, 'auth_ldap', 'field_lock_address', 'unlocked'),
(1469, 'auth_ldap', 'field_map_firstnamephonetic', ''),
(1470, 'auth_ldap', 'field_updatelocal_firstnamephonetic', 'oncreate'),
(1471, 'auth_ldap', 'field_updateremote_firstnamephonetic', '0'),
(1472, 'auth_ldap', 'field_lock_firstnamephonetic', 'unlocked'),
(1473, 'auth_ldap', 'field_map_lastnamephonetic', ''),
(1474, 'auth_ldap', 'field_updatelocal_lastnamephonetic', 'oncreate'),
(1475, 'auth_ldap', 'field_updateremote_lastnamephonetic', '0'),
(1476, 'auth_ldap', 'field_lock_lastnamephonetic', 'unlocked'),
(1477, 'auth_ldap', 'field_map_middlename', ''),
(1478, 'auth_ldap', 'field_updatelocal_middlename', 'oncreate'),
(1479, 'auth_ldap', 'field_updateremote_middlename', '0'),
(1480, 'auth_ldap', 'field_lock_middlename', 'unlocked'),
(1481, 'auth_ldap', 'field_map_alternatename', ''),
(1482, 'auth_ldap', 'field_updatelocal_alternatename', 'oncreate'),
(1483, 'auth_ldap', 'field_updateremote_alternatename', '0'),
(1484, 'auth_ldap', 'field_lock_alternatename', 'unlocked'),
(1485, 'auth_manual', 'expiration', '0'),
(1486, 'auth_manual', 'expirationtime', '30'),
(1487, 'auth_manual', 'expiration_warning', '0'),
(1488, 'auth_manual', 'field_lock_firstname', 'unlocked'),
(1489, 'auth_manual', 'field_lock_lastname', 'unlocked'),
(1490, 'auth_manual', 'field_lock_email', 'unlocked'),
(1491, 'auth_manual', 'field_lock_city', 'unlocked'),
(1492, 'auth_manual', 'field_lock_country', 'unlocked'),
(1493, 'auth_manual', 'field_lock_lang', 'unlocked'),
(1494, 'auth_manual', 'field_lock_description', 'unlocked'),
(1495, 'auth_manual', 'field_lock_url', 'unlocked'),
(1496, 'auth_manual', 'field_lock_idnumber', 'unlocked'),
(1497, 'auth_manual', 'field_lock_institution', 'unlocked'),
(1498, 'auth_manual', 'field_lock_department', 'unlocked'),
(1499, 'auth_manual', 'field_lock_phone1', 'unlocked'),
(1500, 'auth_manual', 'field_lock_phone2', 'unlocked'),
(1501, 'auth_manual', 'field_lock_address', 'unlocked'),
(1502, 'auth_manual', 'field_lock_firstnamephonetic', 'unlocked'),
(1503, 'auth_manual', 'field_lock_lastnamephonetic', 'unlocked'),
(1504, 'auth_manual', 'field_lock_middlename', 'unlocked'),
(1505, 'auth_manual', 'field_lock_alternatename', 'unlocked'),
(1506, 'auth_mnet', 'rpc_negotiation_timeout', '30'),
(1507, 'auth_none', 'field_lock_firstname', 'unlocked'),
(1508, 'auth_none', 'field_lock_lastname', 'unlocked'),
(1509, 'auth_none', 'field_lock_email', 'unlocked'),
(1510, 'auth_none', 'field_lock_city', 'unlocked'),
(1511, 'auth_none', 'field_lock_country', 'unlocked'),
(1512, 'auth_none', 'field_lock_lang', 'unlocked'),
(1513, 'auth_none', 'field_lock_description', 'unlocked'),
(1514, 'auth_none', 'field_lock_url', 'unlocked'),
(1515, 'auth_none', 'field_lock_idnumber', 'unlocked'),
(1516, 'auth_none', 'field_lock_institution', 'unlocked'),
(1517, 'auth_none', 'field_lock_department', 'unlocked'),
(1518, 'auth_none', 'field_lock_phone1', 'unlocked'),
(1519, 'auth_none', 'field_lock_phone2', 'unlocked'),
(1520, 'auth_none', 'field_lock_address', 'unlocked'),
(1521, 'auth_none', 'field_lock_firstnamephonetic', 'unlocked'),
(1522, 'auth_none', 'field_lock_lastnamephonetic', 'unlocked'),
(1523, 'auth_none', 'field_lock_middlename', 'unlocked'),
(1524, 'auth_none', 'field_lock_alternatename', 'unlocked'),
(1525, 'auth_oauth2', 'field_lock_firstname', 'unlocked'),
(1526, 'auth_oauth2', 'field_lock_lastname', 'unlocked'),
(1527, 'auth_oauth2', 'field_lock_email', 'unlocked'),
(1528, 'auth_oauth2', 'field_lock_city', 'unlocked'),
(1529, 'auth_oauth2', 'field_lock_country', 'unlocked'),
(1530, 'auth_oauth2', 'field_lock_lang', 'unlocked'),
(1531, 'auth_oauth2', 'field_lock_description', 'unlocked'),
(1532, 'auth_oauth2', 'field_lock_url', 'unlocked'),
(1533, 'auth_oauth2', 'field_lock_idnumber', 'unlocked'),
(1534, 'auth_oauth2', 'field_lock_institution', 'unlocked'),
(1535, 'auth_oauth2', 'field_lock_department', 'unlocked'),
(1536, 'auth_oauth2', 'field_lock_phone1', 'unlocked'),
(1537, 'auth_oauth2', 'field_lock_phone2', 'unlocked'),
(1538, 'auth_oauth2', 'field_lock_address', 'unlocked'),
(1539, 'auth_oauth2', 'field_lock_firstnamephonetic', 'unlocked'),
(1540, 'auth_oauth2', 'field_lock_lastnamephonetic', 'unlocked'),
(1541, 'auth_oauth2', 'field_lock_middlename', 'unlocked'),
(1542, 'auth_oauth2', 'field_lock_alternatename', 'unlocked'),
(1543, 'auth_shibboleth', 'user_attribute', ''),
(1544, 'auth_shibboleth', 'convert_data', ''),
(1545, 'auth_shibboleth', 'alt_login', 'off'),
(1546, 'auth_shibboleth', 'organization_selection', 'urn:mace:organization1:providerID, Example Organization 1\r\n        https://another.idp-id.com/shibboleth, Other Example Organization, /Shibboleth.sso/DS/SWITCHaai\r\n        urn:mace:organization2:providerID, Example Organization 2, /Shibboleth.sso/WAYF/SWITCHaai'),
(1547, 'auth_shibboleth', 'logout_handler', ''),
(1548, 'auth_shibboleth', 'logout_return_url', ''),
(1549, 'auth_shibboleth', 'login_name', 'Shibboleth Login'),
(1550, 'auth_shibboleth', 'auth_logo', ''),
(1551, 'auth_shibboleth', 'auth_instructions', 'Use the <a href=\"https://learnuat.zinghr.com/LMS_2_0/auth/shibboleth/index.php\">Shibboleth login</a> to get access via Shibboleth, if your institution supports it. Otherwise, use the normal login form shown here.'),
(1552, 'auth_shibboleth', 'changepasswordurl', ''),
(1553, 'auth_shibboleth', 'field_map_firstname', ''),
(1554, 'auth_shibboleth', 'field_updatelocal_firstname', 'oncreate'),
(1555, 'auth_shibboleth', 'field_lock_firstname', 'unlocked'),
(1556, 'auth_shibboleth', 'field_map_lastname', ''),
(1557, 'auth_shibboleth', 'field_updatelocal_lastname', 'oncreate'),
(1558, 'auth_shibboleth', 'field_lock_lastname', 'unlocked'),
(1559, 'auth_shibboleth', 'field_map_email', ''),
(1560, 'auth_shibboleth', 'field_updatelocal_email', 'oncreate'),
(1561, 'auth_shibboleth', 'field_lock_email', 'unlocked'),
(1562, 'auth_shibboleth', 'field_map_city', ''),
(1563, 'auth_shibboleth', 'field_updatelocal_city', 'oncreate'),
(1564, 'auth_shibboleth', 'field_lock_city', 'unlocked'),
(1565, 'auth_shibboleth', 'field_map_country', ''),
(1566, 'auth_shibboleth', 'field_updatelocal_country', 'oncreate'),
(1567, 'auth_shibboleth', 'field_lock_country', 'unlocked'),
(1568, 'auth_shibboleth', 'field_map_lang', ''),
(1569, 'auth_shibboleth', 'field_updatelocal_lang', 'oncreate'),
(1570, 'auth_shibboleth', 'field_lock_lang', 'unlocked'),
(1571, 'auth_shibboleth', 'field_map_description', ''),
(1572, 'auth_shibboleth', 'field_updatelocal_description', 'oncreate'),
(1573, 'auth_shibboleth', 'field_lock_description', 'unlocked'),
(1574, 'auth_shibboleth', 'field_map_url', ''),
(1575, 'auth_shibboleth', 'field_updatelocal_url', 'oncreate'),
(1576, 'auth_shibboleth', 'field_lock_url', 'unlocked'),
(1577, 'auth_shibboleth', 'field_map_idnumber', ''),
(1578, 'auth_shibboleth', 'field_updatelocal_idnumber', 'oncreate'),
(1579, 'auth_shibboleth', 'field_lock_idnumber', 'unlocked'),
(1580, 'auth_shibboleth', 'field_map_institution', ''),
(1581, 'auth_shibboleth', 'field_updatelocal_institution', 'oncreate'),
(1582, 'auth_shibboleth', 'field_lock_institution', 'unlocked'),
(1583, 'auth_shibboleth', 'field_map_department', ''),
(1584, 'auth_shibboleth', 'field_updatelocal_department', 'oncreate'),
(1585, 'auth_shibboleth', 'field_lock_department', 'unlocked'),
(1586, 'auth_shibboleth', 'field_map_phone1', ''),
(1587, 'auth_shibboleth', 'field_updatelocal_phone1', 'oncreate'),
(1588, 'auth_shibboleth', 'field_lock_phone1', 'unlocked'),
(1589, 'auth_shibboleth', 'field_map_phone2', ''),
(1590, 'auth_shibboleth', 'field_updatelocal_phone2', 'oncreate'),
(1591, 'auth_shibboleth', 'field_lock_phone2', 'unlocked'),
(1592, 'auth_shibboleth', 'field_map_address', ''),
(1593, 'auth_shibboleth', 'field_updatelocal_address', 'oncreate'),
(1594, 'auth_shibboleth', 'field_lock_address', 'unlocked'),
(1595, 'auth_shibboleth', 'field_map_firstnamephonetic', ''),
(1596, 'auth_shibboleth', 'field_updatelocal_firstnamephonetic', 'oncreate'),
(1597, 'auth_shibboleth', 'field_lock_firstnamephonetic', 'unlocked'),
(1598, 'auth_shibboleth', 'field_map_lastnamephonetic', ''),
(1599, 'auth_shibboleth', 'field_updatelocal_lastnamephonetic', 'oncreate'),
(1600, 'auth_shibboleth', 'field_lock_lastnamephonetic', 'unlocked'),
(1601, 'auth_shibboleth', 'field_map_middlename', ''),
(1602, 'auth_shibboleth', 'field_updatelocal_middlename', 'oncreate'),
(1603, 'auth_shibboleth', 'field_lock_middlename', 'unlocked'),
(1604, 'auth_shibboleth', 'field_map_alternatename', ''),
(1605, 'auth_shibboleth', 'field_updatelocal_alternatename', 'oncreate'),
(1606, 'auth_shibboleth', 'field_lock_alternatename', 'unlocked'),
(1607, 'block_activity_results', 'config_showbest', '3'),
(1608, 'block_activity_results', 'config_showbest_locked', ''),
(1609, 'block_activity_results', 'config_showworst', '0'),
(1610, 'block_activity_results', 'config_showworst_locked', ''),
(1611, 'block_activity_results', 'config_usegroups', '0'),
(1612, 'block_activity_results', 'config_usegroups_locked', ''),
(1613, 'block_activity_results', 'config_nameformat', '1'),
(1614, 'block_activity_results', 'config_nameformat_locked', ''),
(1615, 'block_activity_results', 'config_gradeformat', '1'),
(1616, 'block_activity_results', 'config_gradeformat_locked', ''),
(1617, 'block_activity_results', 'config_decimalpoints', '2'),
(1618, 'block_activity_results', 'config_decimalpoints_locked', ''),
(1619, 'block_configurable_reports', 'dbhost', ''),
(1620, 'block_configurable_reports', 'dbname', ''),
(1621, 'block_configurable_reports', 'dbuser', ''),
(1622, 'block_configurable_reports', 'dbpass', ''),
(1623, 'block_configurable_reports', 'cron_hour', '0'),
(1624, 'block_configurable_reports', 'cron_minute', '0'),
(1625, 'block_configurable_reports', 'sqlsecurity', '1'),
(1626, 'block_configurable_reports', 'crrepository', 'jleyva/moodle-configurable_reports_repository'),
(1627, 'block_configurable_reports', 'sharedsqlrepository', 'jleyva/moodle-custom_sql_report_queries'),
(1628, 'block_configurable_reports', 'sqlsyntaxhighlight', '1'),
(1629, 'block_configurable_reports', 'reporttableui', 'datatables'),
(1630, 'block_configurable_reports', 'reportlimit', '5000'),
(1631, 'block_myoverview', 'displaycategories', '1'),
(1632, 'block_myoverview', 'layouts', 'card,list,summary'),
(1633, 'block_myoverview', 'displaygroupingallincludinghidden', '0'),
(1634, 'block_myoverview', 'displaygroupingall', '1'),
(1635, 'block_myoverview', 'displaygroupinginprogress', '1'),
(1636, 'block_myoverview', 'displaygroupingpast', '1'),
(1637, 'block_myoverview', 'displaygroupingfuture', '1'),
(1638, 'block_myoverview', 'displaygroupingcustomfield', '0'),
(1639, 'block_myoverview', 'customfiltergrouping', ''),
(1640, 'block_myoverview', 'displaygroupingstarred', '1'),
(1641, 'block_myoverview', 'displaygroupinghidden', '1'),
(1642, 'block_recentlyaccessedcourses', 'displaycategories', '1'),
(1643, 'block_section_links', 'numsections1', '22'),
(1644, 'block_section_links', 'incby1', '2'),
(1645, 'block_section_links', 'numsections2', '40'),
(1646, 'block_section_links', 'incby2', '5'),
(1647, 'block_starredcourses', 'displaycategories', '1'),
(1648, 'block_tag_youtube', 'apikey', ''),
(1649, 'format_singleactivity', 'activitytype', 'forum'),
(1650, 'fileconverter_googledrive', 'issuerid', ''),
(1651, 'enrol_cohort', 'roleid', '5'),
(1652, 'enrol_cohort', 'unenrolaction', '0'),
(1653, 'enrol_meta', 'nosyncroleids', ''),
(1654, 'enrol_meta', 'syncall', '1'),
(1655, 'enrol_meta', 'unenrolaction', '3'),
(1656, 'enrol_meta', 'coursesort', 'sortorder'),
(1657, 'enrol_database', 'dbtype', ''),
(1658, 'enrol_database', 'dbhost', 'localhost'),
(1659, 'enrol_database', 'dbuser', ''),
(1660, 'enrol_database', 'dbpass', ''),
(1661, 'enrol_database', 'dbname', ''),
(1662, 'enrol_database', 'dbencoding', 'utf-8'),
(1663, 'enrol_database', 'dbsetupsql', ''),
(1664, 'enrol_database', 'dbsybasequoting', '0'),
(1665, 'enrol_database', 'debugdb', '0'),
(1666, 'enrol_database', 'localcoursefield', 'idnumber'),
(1667, 'enrol_database', 'localuserfield', 'idnumber'),
(1668, 'enrol_database', 'localrolefield', 'shortname'),
(1669, 'enrol_database', 'localcategoryfield', 'id'),
(1670, 'enrol_database', 'remoteenroltable', ''),
(1671, 'enrol_database', 'remotecoursefield', ''),
(1672, 'enrol_database', 'remoteuserfield', ''),
(1673, 'enrol_database', 'remoterolefield', ''),
(1674, 'enrol_database', 'remoteotheruserfield', ''),
(1675, 'enrol_database', 'defaultrole', '5'),
(1676, 'enrol_database', 'ignorehiddencourses', '0'),
(1677, 'enrol_database', 'unenrolaction', '0'),
(1678, 'enrol_database', 'newcoursetable', ''),
(1679, 'enrol_database', 'newcoursefullname', 'fullname'),
(1680, 'enrol_database', 'newcourseshortname', 'shortname'),
(1681, 'enrol_database', 'newcourseidnumber', 'idnumber'),
(1682, 'enrol_database', 'newcoursecategory', ''),
(1683, 'enrol_database', 'defaultcategory', '1'),
(1684, 'enrol_database', 'templatecourse', ''),
(1685, 'enrol_flatfile', 'location', ''),
(1686, 'enrol_flatfile', 'encoding', 'UTF-8'),
(1687, 'enrol_flatfile', 'mailstudents', '0'),
(1688, 'enrol_flatfile', 'mailteachers', '0'),
(1689, 'enrol_flatfile', 'mailadmins', '0'),
(1690, 'enrol_flatfile', 'unenrolaction', '3'),
(1691, 'enrol_flatfile', 'expiredaction', '3'),
(1692, 'enrol_guest', 'requirepassword', '0'),
(1693, 'enrol_guest', 'usepasswordpolicy', '0'),
(1694, 'enrol_guest', 'showhint', '0'),
(1695, 'enrol_guest', 'defaultenrol', '1'),
(1696, 'enrol_guest', 'status', '1'),
(1697, 'enrol_guest', 'status_adv', ''),
(1698, 'enrol_imsenterprise', 'imsfilelocation', ''),
(1699, 'enrol_imsenterprise', 'logtolocation', ''),
(1700, 'enrol_imsenterprise', 'mailadmins', '0'),
(1701, 'enrol_imsenterprise', 'createnewusers', '0'),
(1702, 'enrol_imsenterprise', 'imsupdateusers', '0'),
(1703, 'enrol_imsenterprise', 'imsdeleteusers', '0'),
(1704, 'enrol_imsenterprise', 'fixcaseusernames', '0'),
(1705, 'enrol_imsenterprise', 'fixcasepersonalnames', '0'),
(1706, 'enrol_imsenterprise', 'imssourcedidfallback', '0'),
(1707, 'enrol_imsenterprise', 'imsrolemap01', '5'),
(1708, 'enrol_imsenterprise', 'imsrolemap02', '3'),
(1709, 'enrol_imsenterprise', 'imsrolemap03', '3'),
(1710, 'enrol_imsenterprise', 'imsrolemap04', '5'),
(1711, 'enrol_imsenterprise', 'imsrolemap05', '0'),
(1712, 'enrol_imsenterprise', 'imsrolemap06', '4'),
(1713, 'enrol_imsenterprise', 'imsrolemap07', '0'),
(1714, 'enrol_imsenterprise', 'imsrolemap08', '4'),
(1715, 'enrol_imsenterprise', 'truncatecoursecodes', '0'),
(1716, 'enrol_imsenterprise', 'createnewcourses', '0'),
(1717, 'enrol_imsenterprise', 'updatecourses', '0'),
(1718, 'enrol_imsenterprise', 'createnewcategories', '0'),
(1719, 'enrol_imsenterprise', 'nestedcategories', '0'),
(1720, 'enrol_imsenterprise', 'categoryidnumber', '0'),
(1721, 'enrol_imsenterprise', 'categoryseparator', ''),
(1722, 'enrol_imsenterprise', 'imsunenrol', '0'),
(1723, 'enrol_imsenterprise', 'imscoursemapshortname', 'coursecode'),
(1724, 'enrol_imsenterprise', 'imscoursemapfullname', 'short'),
(1725, 'enrol_imsenterprise', 'imscoursemapsummary', 'ignore'),
(1726, 'enrol_imsenterprise', 'imsrestricttarget', ''),
(1727, 'enrol_imsenterprise', 'imscapitafix', '0'),
(1728, 'enrol_manual', 'expiredaction', '1'),
(1729, 'enrol_manual', 'expirynotifyhour', '6'),
(1730, 'enrol_manual', 'defaultenrol', '1'),
(1731, 'enrol_manual', 'status', '0'),
(1732, 'enrol_manual', 'roleid', '5'),
(1733, 'enrol_manual', 'enrolstart', '4'),
(1734, 'enrol_manual', 'enrolperiod', '0'),
(1735, 'enrol_manual', 'expirynotify', '0'),
(1736, 'enrol_manual', 'expirythreshold', '86400'),
(1737, 'enrol_mnet', 'roleid', '5'),
(1738, 'enrol_mnet', 'roleid_adv', '1'),
(1739, 'enrol_paypal', 'paypalbusiness', ''),
(1740, 'enrol_paypal', 'mailstudents', '0'),
(1741, 'enrol_paypal', 'mailteachers', '0'),
(1742, 'enrol_paypal', 'mailadmins', '0'),
(1743, 'enrol_paypal', 'expiredaction', '3'),
(1744, 'enrol_paypal', 'status', '1'),
(1745, 'enrol_paypal', 'cost', '0'),
(1746, 'enrol_paypal', 'currency', 'USD'),
(1747, 'enrol_paypal', 'roleid', '5'),
(1748, 'enrol_paypal', 'enrolperiod', '0'),
(1749, 'enrol_lti', 'emaildisplay', '2'),
(1750, 'enrol_lti', 'city', ''),
(1751, 'enrol_lti', 'country', ''),
(1752, 'enrol_lti', 'timezone', '99'),
(1753, 'enrol_lti', 'lang', 'en'),
(1754, 'enrol_lti', 'institution', ''),
(1755, 'enrol_self', 'requirepassword', '0'),
(1756, 'enrol_self', 'usepasswordpolicy', '0'),
(1757, 'enrol_self', 'showhint', '0'),
(1758, 'enrol_self', 'expiredaction', '1'),
(1759, 'enrol_self', 'expirynotifyhour', '6'),
(1760, 'enrol_self', 'defaultenrol', '1'),
(1761, 'enrol_self', 'status', '1'),
(1762, 'enrol_self', 'newenrols', '1'),
(1763, 'enrol_self', 'groupkey', '0'),
(1764, 'enrol_self', 'roleid', '5'),
(1765, 'enrol_self', 'enrolperiod', '0'),
(1766, 'enrol_self', 'expirynotify', '0'),
(1767, 'enrol_self', 'expirythreshold', '86400'),
(1768, 'enrol_self', 'longtimenosee', '0'),
(1769, 'enrol_self', 'maxenrolled', '0'),
(1770, 'enrol_self', 'sendcoursewelcomemessage', '1'),
(1771, 'filter_urltolink', 'formats', '0'),
(1772, 'filter_urltolink', 'embedimages', '1'),
(1773, 'filter_emoticon', 'formats', '0,1,4'),
(1774, 'filter_displayh5p', 'allowedsources', 'https://h5p.org/h5p/embed/[id]'),
(1775, 'filter_mathjaxloader', 'httpsurl', 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js'),
(1776, 'filter_mathjaxloader', 'texfiltercompatibility', '0'),
(1777, 'filter_mathjaxloader', 'mathjaxconfig', 'MathJax.Hub.Config({\r\n    config: [\"Accessible.js\", \"Safe.js\"],\r\n    errorSettings: { message: [\"!\"] },\r\n    skipStartupTypeset: true,\r\n    messageStyle: \"none\"\r\n});\r\n'),
(1778, 'filter_mathjaxloader', 'additionaldelimiters', ''),
(1779, 'filter_tex', 'latexpreamble', '\\usepackage[latin1]{inputenc}\r\n\\usepackage{amsmath}\r\n\\usepackage{amsfonts}\r\n\\RequirePackage{amsmath,amssymb,latexsym}\r\n'),
(1780, 'filter_tex', 'latexbackground', '#FFFFFF'),
(1781, 'filter_tex', 'density', '120'),
(1782, 'filter_tex', 'pathlatex', '/usr/bin/latex'),
(1783, 'filter_tex', 'convertformat', 'gif'),
(1784, 'filter_tex', 'pathdvips', '/usr/bin/dvips'),
(1785, 'filter_tex', 'pathconvert', '/usr/bin/convert'),
(1786, 'filter_tex', 'pathdvisvgm', '/usr/bin/dvisvgm'),
(1787, 'filter_tex', 'pathmimetex', ''),
(1788, 'logstore_database', 'dbdriver', ''),
(1789, 'logstore_database', 'dbhost', ''),
(1790, 'logstore_database', 'dbuser', ''),
(1791, 'logstore_database', 'dbpass', ''),
(1792, 'logstore_database', 'dbname', ''),
(1793, 'logstore_database', 'dbtable', ''),
(1794, 'logstore_database', 'dbpersist', '0'),
(1795, 'logstore_database', 'dbsocket', ''),
(1796, 'logstore_database', 'dbport', ''),
(1797, 'logstore_database', 'dbschema', ''),
(1798, 'logstore_database', 'dbcollation', ''),
(1799, 'logstore_database', 'dbhandlesoptions', '0'),
(1800, 'logstore_database', 'buffersize', '50'),
(1801, 'logstore_database', 'jsonformat', '1'),
(1802, 'logstore_database', 'logguests', '0'),
(1803, 'logstore_database', 'includelevels', '1,2,0'),
(1804, 'logstore_database', 'includeactions', 'c,r,u,d'),
(1805, 'logstore_legacy', 'loglegacy', '0'),
(1806, 'logstore_standard', 'logguests', '1'),
(1807, 'logstore_standard', 'jsonformat', '1'),
(1808, 'logstore_standard', 'loglifetime', '0'),
(1809, 'logstore_standard', 'buffersize', '50'),
(1810, 'mlbackend_python', 'useserver', '0'),
(1811, 'mlbackend_python', 'host', ''),
(1812, 'mlbackend_python', 'port', '0'),
(1813, 'mlbackend_python', 'secure', '0'),
(1814, 'mlbackend_python', 'username', 'default'),
(1815, 'mlbackend_python', 'password', ''),
(1816, 'media_videojs', 'videoextensions', 'html_video,media_source,.f4v,.flv'),
(1817, 'media_videojs', 'audioextensions', 'html_audio'),
(1818, 'media_videojs', 'rtmp', '0'),
(1819, 'media_videojs', 'useflash', '0'),
(1820, 'media_videojs', 'youtube', '1'),
(1821, 'media_videojs', 'videocssclass', 'video-js'),
(1822, 'media_videojs', 'audiocssclass', 'video-js'),
(1823, 'media_videojs', 'limitsize', '1'),
(1824, 'qtype_multichoice', 'answerhowmany', '1'),
(1825, 'qtype_multichoice', 'shuffleanswers', '1'),
(1826, 'qtype_multichoice', 'answernumbering', 'abc'),
(1827, 'editor_atto', 'toolbar', 'collapse = collapse\r\nstyle1 = title, bold, italic\r\nlist = unorderedlist, orderedlist\r\nlinks = link\r\nfiles = image, media, recordrtc, managefiles, h5p\r\nstyle2 = underline, strike, subscript, superscript\r\nalign = align\r\nindent = indent\r\ninsert = equation, charmap, table, clear\r\nundo = undo\r\naccessibility = accessibilitychecker, accessibilityhelper\r\nother = html'),
(1828, 'editor_atto', 'autosavefrequency', '60'),
(1829, 'atto_collapse', 'showgroups', '5'),
(1830, 'atto_equation', 'librarygroup1', '\\cdot\r\n\\times\r\n\\ast\r\n\\div\r\n\\diamond\r\n\\pm\r\n\\mp\r\n\\oplus\r\n\\ominus\r\n\\otimes\r\n\\oslash\r\n\\odot\r\n\\circ\r\n\\bullet\r\n\\asymp\r\n\\equiv\r\n\\subseteq\r\n\\supseteq\r\n\\leq\r\n\\geq\r\n\\preceq\r\n\\succeq\r\n\\sim\r\n\\simeq\r\n\\approx\r\n\\subset\r\n\\supset\r\n\\ll\r\n\\gg\r\n\\prec\r\n\\succ\r\n\\infty\r\n\\in\r\n\\ni\r\n\\forall\r\n\\exists\r\n\\neq\r\n'),
(1831, 'atto_equation', 'librarygroup2', '\\leftarrow\r\n\\rightarrow\r\n\\uparrow\r\n\\downarrow\r\n\\leftrightarrow\r\n\\nearrow\r\n\\searrow\r\n\\swarrow\r\n\\nwarrow\r\n\\Leftarrow\r\n\\Rightarrow\r\n\\Uparrow\r\n\\Downarrow\r\n\\Leftrightarrow\r\n'),
(1832, 'atto_equation', 'librarygroup3', '\\alpha\r\n\\beta\r\n\\gamma\r\n\\delta\r\n\\epsilon\r\n\\zeta\r\n\\eta\r\n\\theta\r\n\\iota\r\n\\kappa\r\n\\lambda\r\n\\mu\r\n\\nu\r\n\\xi\r\n\\pi\r\n\\rho\r\n\\sigma\r\n\\tau\r\n\\upsilon\r\n\\phi\r\n\\chi\r\n\\psi\r\n\\omega\r\n\\Gamma\r\n\\Delta\r\n\\Theta\r\n\\Lambda\r\n\\Xi\r\n\\Pi\r\n\\Sigma\r\n\\Upsilon\r\n\\Phi\r\n\\Psi\r\n\\Omega\r\n'),
(1833, 'atto_equation', 'librarygroup4', '\\sum{a,b}\r\n\\sqrt[a]{b+c}\r\n\\int_{a}^{b}{c}\r\n\\iint_{a}^{b}{c}\r\n\\iiint_{a}^{b}{c}\r\n\\oint{a}\r\n(a)\r\n[a]\r\n\\lbrace{a}\\rbrace\r\n\\left| \\begin{matrix} a_1 & a_2 \\ a_3 & a_4 \\end{matrix} \\right|\r\n\\frac{a}{b+c}\r\n\\vec{a}\r\n\\binom {a} {b}\r\n{a \\brack b}\r\n{a \\brace b}\r\n'),
(1834, 'atto_recordrtc', 'allowedtypes', 'both'),
(1835, 'atto_recordrtc', 'audiobitrate', '128000'),
(1836, 'atto_recordrtc', 'videobitrate', '2500000'),
(1837, 'atto_recordrtc', 'timelimit', '120'),
(1838, 'atto_table', 'allowborders', '0');
INSERT INTO `mdl_config_plugins` (`id`, `plugin`, `name`, `value`) VALUES
(1839, 'atto_table', 'allowbackgroundcolour', '0'),
(1840, 'atto_table', 'allowwidth', '0'),
(1841, 'editor_tinymce', 'customtoolbar', 'wrap,formatselect,wrap,bold,italic,wrap,bullist,numlist,wrap,link,unlink,wrap,image\r\n\r\nundo,redo,wrap,underline,strikethrough,sub,sup,wrap,justifyleft,justifycenter,justifyright,wrap,outdent,indent,wrap,forecolor,backcolor,wrap,ltr,rtl\r\n\r\nfontselect,fontsizeselect,wrap,code,search,replace,wrap,nonbreaking,charmap,table,wrap,cleanup,removeformat,pastetext,pasteword,wrap,fullscreen'),
(1842, 'editor_tinymce', 'fontselectlist', 'Trebuchet=Trebuchet MS,Verdana,Arial,Helvetica,sans-serif;Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;Georgia=georgia,times new roman,times,serif;Tahoma=tahoma,arial,helvetica,sans-serif;Times New Roman=times new roman,times,serif;Verdana=verdana,arial,helvetica,sans-serif;Impact=impact;Wingdings=wingdings'),
(1843, 'editor_tinymce', 'customconfig', ''),
(1844, 'tinymce_moodleemoticon', 'requireemoticon', '1'),
(1845, 'tinymce_spellchecker', 'spellengine', ''),
(1846, 'tinymce_spellchecker', 'spelllanguagelist', '+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv'),
(1847, 'tool_mobile', 'apppolicy', ''),
(1848, 'tool_mobile', 'typeoflogin', '1'),
(1849, 'tool_mobile', 'forcedurlscheme', 'moodlemobile'),
(1850, 'tool_mobile', 'minimumversion', ''),
(1851, 'tool_mobile', 'enablesmartappbanners', '0'),
(1852, 'tool_mobile', 'iosappid', '633359593'),
(1853, 'tool_mobile', 'androidappid', 'com.moodle.moodlemobile'),
(1854, 'tool_mobile', 'setuplink', 'https://download.moodle.org/mobile'),
(1855, 'tool_mobile', 'forcelogout', '0'),
(1856, 'tool_mobile', 'disabledfeatures', ''),
(1857, 'tool_mobile', 'custommenuitems', ''),
(1858, 'tool_mobile', 'customlangstrings', ''),
(1859, 'enrol_auto', 'version', '2019022000'),
(1861, 'enrol_auto', 'defaultenrol', '1'),
(1862, 'enrol_auto', 'status', '1'),
(1863, 'enrol_auto', 'enrolon', '1'),
(1864, 'enrol_auto', 'modviewmods', ''),
(1865, 'enrol_auto', 'roleid', '5'),
(1866, 'enrol_auto', 'sendcoursewelcomemessage', '1'),
(1867, 'enrol_apply', 'version', '2019040400'),
(1868, 'message', 'airnotifier_provider_enrol_apply_application_permitted', 'permitted'),
(1869, 'message', 'email_provider_enrol_apply_application_permitted', 'permitted'),
(1870, 'message', 'jabber_provider_enrol_apply_application_permitted', 'permitted'),
(1871, 'message', 'popup_provider_enrol_apply_application_permitted', 'permitted'),
(1872, 'message', 'message_provider_enrol_apply_application_loggedin', 'email'),
(1873, 'message', 'message_provider_enrol_apply_application_loggedoff', 'email'),
(1874, 'message', 'airnotifier_provider_enrol_apply_confirmation_permitted', 'permitted'),
(1875, 'message', 'email_provider_enrol_apply_confirmation_permitted', 'permitted'),
(1876, 'message', 'jabber_provider_enrol_apply_confirmation_permitted', 'permitted'),
(1877, 'message', 'popup_provider_enrol_apply_confirmation_permitted', 'permitted'),
(1878, 'message', 'message_provider_enrol_apply_confirmation_loggedin', 'email'),
(1879, 'message', 'message_provider_enrol_apply_confirmation_loggedoff', 'email'),
(1880, 'message', 'airnotifier_provider_enrol_apply_cancelation_permitted', 'permitted'),
(1881, 'message', 'email_provider_enrol_apply_cancelation_permitted', 'permitted'),
(1882, 'message', 'jabber_provider_enrol_apply_cancelation_permitted', 'permitted'),
(1883, 'message', 'popup_provider_enrol_apply_cancelation_permitted', 'permitted'),
(1884, 'message', 'message_provider_enrol_apply_cancelation_loggedin', 'email'),
(1885, 'message', 'message_provider_enrol_apply_cancelation_loggedoff', 'email'),
(1886, 'message', 'airnotifier_provider_enrol_apply_waitinglist_permitted', 'permitted'),
(1887, 'message', 'email_provider_enrol_apply_waitinglist_permitted', 'permitted'),
(1888, 'message', 'jabber_provider_enrol_apply_waitinglist_permitted', 'permitted'),
(1889, 'message', 'popup_provider_enrol_apply_waitinglist_permitted', 'permitted'),
(1890, 'message', 'message_provider_enrol_apply_waitinglist_loggedin', 'email'),
(1891, 'message', 'message_provider_enrol_apply_waitinglist_loggedoff', 'email'),
(1892, 'enrol_apply', 'confirmmailsubject', 'Course Confirmation'),
(1893, 'enrol_apply', 'confirmmailcontent', '<p><p>Hi&nbsp;<b>{firstname}</b>,</p><p>Your&nbsp;<b>{content}</b>&nbsp;course enrolment request has been confirmed.</p><p>Thanks &amp; regards,</p><p>Learning &amp; Development Team</p><br></p>'),
(1894, 'enrol_apply', 'waitmailsubject', 'Course Waiting list'),
(1895, 'enrol_apply', 'waitmailcontent', '<p><p>Hi&nbsp;<b>{firstname}</b>,</p><p>Your&nbsp;<b>{content}</b>&nbsp;course&nbsp;enrolment request has been in waiting list.</p><p>Thanks &amp; regards,</p><p>Learning &amp; Development Team</p><br><br></p>'),
(1896, 'enrol_apply', 'cancelmailsubject', 'Course Cancelation'),
(1897, 'enrol_apply', 'cancelmailcontent', '<p><p>Hi&nbsp;<b>{firstname}</b>,</p><p>Your&nbsp;<b>{content}</b>&nbsp;course&nbsp;enrolment request has been cancled.</p><p>Thanks &amp; regards,</p><p>Learning &amp; Development Team</p><br><br></p>'),
(1898, 'enrol_apply', 'notifyglobal', '$@ALL@$'),
(1899, 'enrol_apply', 'expiredaction', '1'),
(1900, 'enrol_apply', 'defaultenrol', '0'),
(1901, 'enrol_apply', 'status', '0'),
(1902, 'enrol_apply', 'newenrols', '1'),
(1903, 'enrol_apply', 'show_standard_user_profile', '1'),
(1904, 'enrol_apply', 'show_extra_user_profile', '1'),
(1905, 'enrol_apply', 'roleid', '5'),
(1906, 'enrol_apply', 'notifycoursebased', '0'),
(1907, 'enrol_apply', 'enrolperiod', '0'),
(1908, 'mod_attendance', 'version', '2019112500'),
(1910, 'attendance', 'resultsperpage', '25'),
(1911, 'attendance', 'studentscanmark', '1'),
(1912, 'attendance', 'studentscanmarksessiontime', '1'),
(1913, 'attendance', 'studentscanmarksessiontimeend', '60'),
(1914, 'attendance', 'subnetactivitylevel', '1'),
(1915, 'attendance', 'defaultview', '2'),
(1916, 'attendance', 'multisessionexpanded', '0'),
(1917, 'attendance', 'showsessiondescriptiononreport', '0'),
(1918, 'attendance', 'studentrecordingexpanded', '1'),
(1919, 'attendance', 'enablecalendar', '1'),
(1920, 'attendance', 'enablewarnings', '0'),
(1921, 'attendance', 'subnet', ''),
(1922, 'attendance', 'calendarevent_default', '1'),
(1923, 'attendance', 'absenteereport_default', '1'),
(1924, 'attendance', 'studentscanmark_default', '0'),
(1925, 'attendance', 'automark_default', '0'),
(1926, 'attendance', 'randompassword_default', '0'),
(1927, 'attendance', 'includeqrcode_default', '0'),
(1928, 'attendance', 'autoassignstatus', '0'),
(1929, 'attendance', 'preventsharedip', '0'),
(1930, 'attendance', 'preventsharediptime', ''),
(1931, 'attendance', 'warningpercent', '70'),
(1932, 'attendance', 'warnafter', '5'),
(1933, 'attendance', 'maxwarn', '1'),
(1934, 'attendance', 'emailuser', '1'),
(1935, 'attendance', 'emailsubject', 'Attendance warning'),
(1936, 'attendance', 'emailcontent', 'Hi %userfirstname%,\r\nYour attendance in %coursename% %attendancename% has dropped below %warningpercent% and is currently %percent% - we hope you are ok!\r\n\r\nTo get the most out of this course you should improve your attendance, please get in touch if you require any further support.'),
(1937, 'mod_facetoface', 'version', '2018110900'),
(1938, 'mod_hvp', 'version', '2020020500'),
(1940, 'mod_hvp', 'site_type', 'network'),
(1941, 'mod_hvp', 'site_uuid', '26aef045-8033-4e12-baf1-5d279455d873'),
(1942, 'mod_hvp', 'content_type_cache_updated_at', '1585164620'),
(1943, 'mod_hvp', 'hub_is_enabled', '1'),
(1944, 'mod_hvp', 'enable_save_content_state', '0'),
(1945, 'mod_hvp', 'content_state_frequency', '30'),
(1946, 'mod_hvp', 'send_usage_statistics', '1'),
(1947, 'mod_hvp', 'frame', '1'),
(1948, 'mod_hvp', 'export', '3'),
(1949, 'mod_hvp', 'embed', '3'),
(1950, 'mod_hvp', 'copyright', '1'),
(1951, 'mod_hvp', 'icon', '1'),
(1952, 'mod_hvp', 'enable_lrs_content_types', '0'),
(1953, 'core_plugin', 'recentfetch', '1585078204'),
(1954, 'core_plugin', 'recentresponse', '{\"status\":\"OK\",\"provider\":\"https:\\/\\/download.moodle.org\\/api\\/1.3\\/updates.php\",\"apiver\":\"1.3\",\"timegenerated\":1585078292,\"ticket\":\"JUM5JTkxZyVGOSUzQiU4MCUyOSUyQiVCMCU5MiVERiVEMiVFNmElMTglRTRJJUNFJUM4JUEyUmMlQzglMjMlN0YlRUYlRjhPJTNEJUZEJTJGWiVEOCUxMiUxQiU4NSU3QiU4RiVGRkwlODc=\",\"forbranch\":\"3.8\",\"forversion\":\"2019111801.09\",\"updates\":{\"core\":[{\"version\":2019111802.02,\"release\":\"3.8.2+ (Build: 20200320)\",\"branch\":\"3.8\",\"maturity\":200,\"url\":\"https:\\/\\/download.moodle.org\",\"download\":\"https:\\/\\/download.moodle.org\\/download.php\\/direct\\/stable38\\/moodle-latest-38.zip\"},{\"version\":2020032000,\"release\":\"3.9dev (Build: 20200320)\",\"branch\":\"3.9\",\"maturity\":50,\"url\":\"https:\\/\\/download.moodle.org\",\"download\":\"https:\\/\\/download.moodle.org\\/download.php\\/direct\\/moodle\\/moodle-latest.zip\"}],\"mod_attendance\":[{\"version\":\"2019112500\",\"release\":\"3.8.1\",\"maturity\":200,\"url\":\"https:\\/\\/moodle.org\\/plugins\\/pluginversion.php?id=21114\",\"download\":\"https:\\/\\/moodle.org\\/plugins\\/download.php\\/21114\\/mod_attendance_moodle38_2019112500.zip\",\"downloadmd5\":\"05dd04f5ef73b421536a17e8ea7ddc35\"}],\"mod_hvp\":[{\"version\":\"2020020500\",\"release\":\"1.20.2\",\"maturity\":200,\"url\":\"https:\\/\\/moodle.org\\/plugins\\/pluginversion.php?id=21001\",\"download\":\"https:\\/\\/moodle.org\\/plugins\\/download.php\\/21001\\/mod_hvp_moodle38_2020020500.zip\",\"downloadmd5\":\"2e025e44fbb15f1fed4479c09e6e26f1\"}],\"mod_jitsi\":[{\"version\":\"2020032200\",\"release\":\"v2.1\",\"maturity\":200,\"url\":\"https:\\/\\/moodle.org\\/plugins\\/pluginversion.php?id=21228\",\"download\":\"https:\\/\\/moodle.org\\/plugins\\/download.php\\/21228\\/mod_jitsi_moodle38_2020032200.zip\",\"downloadmd5\":\"6d0b8e09210dc5db692f8513d7dd2814\"}],\"mod_treasurehunt\":[{\"version\":\"2020032302\",\"release\":\"v1.3.1d\",\"maturity\":200,\"url\":\"https:\\/\\/moodle.org\\/plugins\\/pluginversion.php?id=21241\",\"download\":\"https:\\/\\/moodle.org\\/plugins\\/download.php\\/21241\\/mod_treasurehunt_moodle38_2020032302.zip\",\"downloadmd5\":\"8122775ed1327878957e9c6288c9c21c\"}],\"block_configurable_reports\":[{\"version\":\"2019122000\",\"release\":\"3.8.0\",\"maturity\":200,\"url\":\"https:\\/\\/moodle.org\\/plugins\\/pluginversion.php?id=20829\",\"download\":\"https:\\/\\/moodle.org\\/plugins\\/download.php\\/20829\\/block_configurable_reports_moodle38_2019122000.zip\",\"downloadmd5\":\"611aa52b27a2128e3fe084488852553d\"}]}}'),
(1955, 'mod_jitsi', 'version', '2020032200'),
(1956, 'tool_task', 'lastcronstart', '1585164601'),
(1957, 'enrol_manual', 'expirynotifylast', '1585164606'),
(1958, 'enrol_self', 'expirynotifylast', '1585164607'),
(1959, 'tool_task', 'lastcroninterval', '86400'),
(1960, 'mod_treasurehunt', 'version', '2020031200'),
(1962, 'mod_treasurehunt', 'maximumgrade', '10'),
(1963, 'mod_treasurehunt', 'grademethod', '1'),
(1964, 'mod_treasurehunt', 'penaltylocation', '0'),
(1965, 'mod_treasurehunt', 'penaltyanswer', '0'),
(1966, 'mod_treasurehunt', 'locktimeediting', '120'),
(1967, 'mod_treasurehunt', 'gameupdatetime', '20'),
(1968, 'message', 'airnotifier_provider_mod_hvp_submission_permitted', 'permitted'),
(1969, 'message', 'email_provider_mod_hvp_submission_permitted', 'permitted'),
(1970, 'message', 'jabber_provider_mod_hvp_submission_permitted', 'permitted'),
(1971, 'message', 'popup_provider_mod_hvp_submission_permitted', 'permitted'),
(1972, 'message', 'message_provider_mod_hvp_submission_loggedin', 'email'),
(1973, 'message', 'message_provider_mod_hvp_submission_loggedoff', 'email'),
(1974, 'message', 'airnotifier_provider_mod_hvp_confirmation_permitted', 'permitted'),
(1975, 'message', 'email_provider_mod_hvp_confirmation_permitted', 'permitted'),
(1976, 'message', 'jabber_provider_mod_hvp_confirmation_permitted', 'permitted'),
(1977, 'message', 'popup_provider_mod_hvp_confirmation_permitted', 'permitted'),
(1978, 'message', 'message_provider_mod_hvp_confirmation_loggedin', 'airnotifier,email'),
(1979, 'message', 'message_provider_mod_hvp_confirmation_loggedoff', 'airnotifier,email'),
(1980, 'attendance', 'rotateqrcodeinterval', '15'),
(1981, 'attendance', 'rotateqrcodeexpirymargin', '2'),
(1982, 'attendance', 'mobilesessionfrom', '21600'),
(1983, 'attendance', 'mobilesessionto', '86400'),
(1984, 'enrol_ldap', 'objectclass', '(objectClass=*)'),
(1985, 'mod_checklist', 'version', '2020012900'),
(1987, 'checklist', 'showmymoodle', '1'),
(1988, 'checklist', 'showcompletemymoodle', '1'),
(1989, 'checklist', 'showupdateablemymoodle', '1'),
(1990, 'mod_checklist', 'linkcourses', '0'),
(1991, 'mod_checklist', 'onlyenrolled', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_context`
--

CREATE TABLE `mdl_context` (
  `id` bigint(10) NOT NULL,
  `contextlevel` bigint(10) NOT NULL DEFAULT '0',
  `instanceid` bigint(10) NOT NULL DEFAULT '0',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depth` tinyint(2) NOT NULL DEFAULT '0',
  `locked` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='one of these must be set' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_context`
--

INSERT INTO `mdl_context` (`id`, `contextlevel`, `instanceid`, `path`, `depth`, `locked`) VALUES
(1, 10, 0, '/1', 1, 0),
(2, 50, 1, '/1/2', 2, 0),
(3, 40, 1, '/1/3', 2, 0),
(4, 30, 1, '/1/4', 2, 0),
(5, 30, 2, '/1/5', 2, 0),
(6, 80, 1, '/1/6', 2, 0),
(7, 80, 2, '/1/7', 2, 0),
(8, 80, 3, '/1/8', 2, 0),
(9, 80, 4, '/1/9', 2, 0),
(10, 80, 5, '/1/10', 2, 0),
(11, 80, 6, '/1/11', 2, 0),
(12, 80, 7, '/1/12', 2, 0),
(13, 80, 8, '/1/13', 2, 0),
(14, 80, 9, '/1/14', 2, 0),
(15, 80, 10, '/1/15', 2, 0),
(16, 80, 11, '/1/5/16', 3, 0),
(17, 80, 12, '/1/5/17', 3, 0),
(18, 80, 13, '/1/5/18', 3, 0),
(19, 80, 14, '/1/5/19', 3, 0),
(20, 80, 15, '/1/5/20', 3, 0),
(21, 80, 16, '/1/5/21', 3, 0),
(22, 80, 17, '/1/5/22', 3, 0),
(23, 80, 18, '/1/5/23', 3, 0),
(24, 80, 19, '/1/5/24', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_context_temp`
--

CREATE TABLE `mdl_context_temp` (
  `id` bigint(10) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `depth` tinyint(2) NOT NULL,
  `locked` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used by build_context_path() in upgrade and cron to keep con' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course`
--

CREATE TABLE `mdl_course` (
  `id` bigint(10) NOT NULL,
  `category` bigint(10) NOT NULL DEFAULT '0',
  `sortorder` bigint(10) NOT NULL DEFAULT '0',
  `fullname` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shortname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `idnumber` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `summary` longtext COLLATE utf8mb4_unicode_ci,
  `summaryformat` tinyint(2) NOT NULL DEFAULT '0',
  `format` varchar(21) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'topics',
  `showgrades` tinyint(2) NOT NULL DEFAULT '1',
  `newsitems` mediumint(5) NOT NULL DEFAULT '1',
  `startdate` bigint(10) NOT NULL DEFAULT '0',
  `enddate` bigint(10) NOT NULL DEFAULT '0',
  `relativedatesmode` tinyint(1) NOT NULL DEFAULT '0',
  `marker` bigint(10) NOT NULL DEFAULT '0',
  `maxbytes` bigint(10) NOT NULL DEFAULT '0',
  `legacyfiles` smallint(4) NOT NULL DEFAULT '0',
  `showreports` smallint(4) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `visibleold` tinyint(1) NOT NULL DEFAULT '1',
  `groupmode` smallint(4) NOT NULL DEFAULT '0',
  `groupmodeforce` smallint(4) NOT NULL DEFAULT '0',
  `defaultgroupingid` bigint(10) NOT NULL DEFAULT '0',
  `lang` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `calendartype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `theme` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `requested` tinyint(1) NOT NULL DEFAULT '0',
  `enablecompletion` tinyint(1) NOT NULL DEFAULT '0',
  `completionnotify` tinyint(1) NOT NULL DEFAULT '0',
  `cacherev` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Central course table' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_course`
--

INSERT INTO `mdl_course` (`id`, `category`, `sortorder`, `fullname`, `shortname`, `idnumber`, `summary`, `summaryformat`, `format`, `showgrades`, `newsitems`, `startdate`, `enddate`, `relativedatesmode`, `marker`, `maxbytes`, `legacyfiles`, `showreports`, `visible`, `visibleold`, `groupmode`, `groupmodeforce`, `defaultgroupingid`, `lang`, `calendartype`, `theme`, `timecreated`, `timemodified`, `requested`, `enablecompletion`, `completionnotify`, `cacherev`) VALUES
(1, 0, 0, 'Abilitic', 'Abilitic', '', '', 0, 'site', 1, 3, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, '', '', '', 1583151879, 1585567895, 0, 0, 0, 1585568500);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_categories`
--

CREATE TABLE `mdl_course_categories` (
  `id` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `idnumber` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) NOT NULL DEFAULT '0',
  `parent` bigint(10) NOT NULL DEFAULT '0',
  `sortorder` bigint(10) NOT NULL DEFAULT '0',
  `coursecount` bigint(10) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `visibleold` tinyint(1) NOT NULL DEFAULT '1',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `depth` bigint(10) NOT NULL DEFAULT '0',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `theme` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Course categories' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_course_categories`
--

INSERT INTO `mdl_course_categories` (`id`, `name`, `idnumber`, `description`, `descriptionformat`, `parent`, `sortorder`, `coursecount`, `visible`, `visibleold`, `timemodified`, `depth`, `path`, `theme`) VALUES
(1, 'Miscellaneous', NULL, NULL, 0, 0, 10000, 0, 1, 1, 1583151879, 1, '/1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_completions`
--

CREATE TABLE `mdl_course_completions` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `course` bigint(10) NOT NULL DEFAULT '0',
  `timeenrolled` bigint(10) NOT NULL DEFAULT '0',
  `timestarted` bigint(10) NOT NULL DEFAULT '0',
  `timecompleted` bigint(10) DEFAULT NULL,
  `reaggregate` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Course completion records' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_completion_aggr_methd`
--

CREATE TABLE `mdl_course_completion_aggr_methd` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `criteriatype` bigint(10) DEFAULT NULL,
  `method` tinyint(1) NOT NULL DEFAULT '0',
  `value` decimal(10,5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Course completion aggregation methods for criteria' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_completion_criteria`
--

CREATE TABLE `mdl_course_completion_criteria` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `criteriatype` bigint(10) NOT NULL DEFAULT '0',
  `module` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moduleinstance` bigint(10) DEFAULT NULL,
  `courseinstance` bigint(10) DEFAULT NULL,
  `enrolperiod` bigint(10) DEFAULT NULL,
  `timeend` bigint(10) DEFAULT NULL,
  `gradepass` decimal(10,5) DEFAULT NULL,
  `role` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Course completion criteria' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_completion_crit_compl`
--

CREATE TABLE `mdl_course_completion_crit_compl` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `course` bigint(10) NOT NULL DEFAULT '0',
  `criteriaid` bigint(10) NOT NULL DEFAULT '0',
  `gradefinal` decimal(10,5) DEFAULT NULL,
  `unenroled` bigint(10) DEFAULT NULL,
  `timecompleted` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Course completion user records' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_completion_defaults`
--

CREATE TABLE `mdl_course_completion_defaults` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL,
  `module` bigint(10) NOT NULL,
  `completion` tinyint(1) NOT NULL DEFAULT '0',
  `completionview` tinyint(1) NOT NULL DEFAULT '0',
  `completionusegrade` tinyint(1) NOT NULL DEFAULT '0',
  `completionexpected` bigint(10) NOT NULL DEFAULT '0',
  `customrules` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Default settings for activities completion' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_format_options`
--

CREATE TABLE `mdl_course_format_options` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `format` varchar(21) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sectionid` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores format-specific options for the course or course sect' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_course_format_options`
--

INSERT INTO `mdl_course_format_options` (`id`, `courseid`, `format`, `sectionid`, `name`, `value`) VALUES
(1, 1, 'site', 0, 'numsections', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_modules`
--

CREATE TABLE `mdl_course_modules` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `module` bigint(10) NOT NULL DEFAULT '0',
  `instance` bigint(10) NOT NULL DEFAULT '0',
  `section` bigint(10) NOT NULL DEFAULT '0',
  `idnumber` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added` bigint(10) NOT NULL DEFAULT '0',
  `score` smallint(4) NOT NULL DEFAULT '0',
  `indent` mediumint(5) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `visibleoncoursepage` tinyint(1) NOT NULL DEFAULT '1',
  `visibleold` tinyint(1) NOT NULL DEFAULT '1',
  `groupmode` smallint(4) NOT NULL DEFAULT '0',
  `groupingid` bigint(10) NOT NULL DEFAULT '0',
  `completion` tinyint(1) NOT NULL DEFAULT '0',
  `completiongradeitemnumber` bigint(10) DEFAULT NULL,
  `completionview` tinyint(1) NOT NULL DEFAULT '0',
  `completionexpected` bigint(10) NOT NULL DEFAULT '0',
  `showdescription` tinyint(1) NOT NULL DEFAULT '0',
  `availability` longtext COLLATE utf8mb4_unicode_ci,
  `deletioninprogress` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='course_modules table retrofitted from MySQL' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_modules_completion`
--

CREATE TABLE `mdl_course_modules_completion` (
  `id` bigint(10) NOT NULL,
  `coursemoduleid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `completionstate` tinyint(1) NOT NULL,
  `viewed` tinyint(1) DEFAULT NULL,
  `overrideby` bigint(10) DEFAULT NULL,
  `timemodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores the completion state (completed or not completed, etc' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_published`
--

CREATE TABLE `mdl_course_published` (
  `id` bigint(10) NOT NULL,
  `huburl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courseid` bigint(10) NOT NULL,
  `timepublished` bigint(10) NOT NULL,
  `enrollable` tinyint(1) NOT NULL DEFAULT '1',
  `hubcourseid` bigint(10) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `timechecked` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Information about how and when an local courses were publish' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_request`
--

CREATE TABLE `mdl_course_request` (
  `id` bigint(10) NOT NULL,
  `fullname` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shortname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `summary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `summaryformat` tinyint(2) NOT NULL DEFAULT '0',
  `category` bigint(10) NOT NULL DEFAULT '0',
  `reason` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `requester` bigint(10) NOT NULL DEFAULT '0',
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='course requests' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_sections`
--

CREATE TABLE `mdl_course_sections` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `section` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci,
  `summaryformat` tinyint(2) NOT NULL DEFAULT '0',
  `sequence` longtext COLLATE utf8mb4_unicode_ci,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `availability` longtext COLLATE utf8mb4_unicode_ci,
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='to define the sections for each course' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_customfield_category`
--

CREATE TABLE `mdl_customfield_category` (
  `id` bigint(10) NOT NULL,
  `name` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` bigint(10) DEFAULT NULL,
  `sortorder` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `component` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `area` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `itemid` bigint(10) NOT NULL DEFAULT '0',
  `contextid` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='core_customfield category table' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_customfield_data`
--

CREATE TABLE `mdl_customfield_data` (
  `id` bigint(10) NOT NULL,
  `fieldid` bigint(10) NOT NULL,
  `instanceid` bigint(10) NOT NULL,
  `intvalue` bigint(10) DEFAULT NULL,
  `decvalue` decimal(10,5) DEFAULT NULL,
  `shortcharvalue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charvalue` varchar(1333) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `valueformat` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `contextid` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='core_customfield data table' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_customfield_field`
--

CREATE TABLE `mdl_customfield_field` (
  `id` bigint(10) NOT NULL,
  `shortname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` bigint(10) DEFAULT NULL,
  `sortorder` bigint(10) DEFAULT NULL,
  `categoryid` bigint(10) DEFAULT NULL,
  `configdata` longtext COLLATE utf8mb4_unicode_ci,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='core_customfield field table' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_data`
--

CREATE TABLE `mdl_data` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `comments` smallint(4) NOT NULL DEFAULT '0',
  `timeavailablefrom` bigint(10) NOT NULL DEFAULT '0',
  `timeavailableto` bigint(10) NOT NULL DEFAULT '0',
  `timeviewfrom` bigint(10) NOT NULL DEFAULT '0',
  `timeviewto` bigint(10) NOT NULL DEFAULT '0',
  `requiredentries` int(8) NOT NULL DEFAULT '0',
  `requiredentriestoview` int(8) NOT NULL DEFAULT '0',
  `maxentries` int(8) NOT NULL DEFAULT '0',
  `rssarticles` smallint(4) NOT NULL DEFAULT '0',
  `singletemplate` longtext COLLATE utf8mb4_unicode_ci,
  `listtemplate` longtext COLLATE utf8mb4_unicode_ci,
  `listtemplateheader` longtext COLLATE utf8mb4_unicode_ci,
  `listtemplatefooter` longtext COLLATE utf8mb4_unicode_ci,
  `addtemplate` longtext COLLATE utf8mb4_unicode_ci,
  `rsstemplate` longtext COLLATE utf8mb4_unicode_ci,
  `rsstitletemplate` longtext COLLATE utf8mb4_unicode_ci,
  `csstemplate` longtext COLLATE utf8mb4_unicode_ci,
  `jstemplate` longtext COLLATE utf8mb4_unicode_ci,
  `asearchtemplate` longtext COLLATE utf8mb4_unicode_ci,
  `approval` smallint(4) NOT NULL DEFAULT '0',
  `manageapproved` smallint(4) NOT NULL DEFAULT '1',
  `scale` bigint(10) NOT NULL DEFAULT '0',
  `assessed` bigint(10) NOT NULL DEFAULT '0',
  `assesstimestart` bigint(10) NOT NULL DEFAULT '0',
  `assesstimefinish` bigint(10) NOT NULL DEFAULT '0',
  `defaultsort` bigint(10) NOT NULL DEFAULT '0',
  `defaultsortdir` smallint(4) NOT NULL DEFAULT '0',
  `editany` smallint(4) NOT NULL DEFAULT '0',
  `notification` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `config` longtext COLLATE utf8mb4_unicode_ci,
  `completionentries` bigint(10) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='all database activities' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_data_content`
--

CREATE TABLE `mdl_data_content` (
  `id` bigint(10) NOT NULL,
  `fieldid` bigint(10) NOT NULL DEFAULT '0',
  `recordid` bigint(10) NOT NULL DEFAULT '0',
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `content1` longtext COLLATE utf8mb4_unicode_ci,
  `content2` longtext COLLATE utf8mb4_unicode_ci,
  `content3` longtext COLLATE utf8mb4_unicode_ci,
  `content4` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='the content introduced in each record/fields' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_data_fields`
--

CREATE TABLE `mdl_data_fields` (
  `id` bigint(10) NOT NULL,
  `dataid` bigint(10) NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `param1` longtext COLLATE utf8mb4_unicode_ci,
  `param2` longtext COLLATE utf8mb4_unicode_ci,
  `param3` longtext COLLATE utf8mb4_unicode_ci,
  `param4` longtext COLLATE utf8mb4_unicode_ci,
  `param5` longtext COLLATE utf8mb4_unicode_ci,
  `param6` longtext COLLATE utf8mb4_unicode_ci,
  `param7` longtext COLLATE utf8mb4_unicode_ci,
  `param8` longtext COLLATE utf8mb4_unicode_ci,
  `param9` longtext COLLATE utf8mb4_unicode_ci,
  `param10` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='every field available' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_data_records`
--

CREATE TABLE `mdl_data_records` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `groupid` bigint(10) NOT NULL DEFAULT '0',
  `dataid` bigint(10) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `approved` smallint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='every record introduced' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_editor_atto_autosave`
--

CREATE TABLE `mdl_editor_atto_autosave` (
  `id` bigint(10) NOT NULL,
  `elementid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contextid` bigint(10) NOT NULL,
  `pagehash` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `userid` bigint(10) NOT NULL,
  `drafttext` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `draftid` bigint(10) DEFAULT NULL,
  `pageinstance` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Draft text that is auto-saved every 5 seconds while an edito' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_editor_atto_autosave`
--

INSERT INTO `mdl_editor_atto_autosave` (`id`, `elementid`, `contextid`, `pagehash`, `userid`, `drafttext`, `draftid`, `pageinstance`, `timemodified`) VALUES
(1, 'id_s__summary', 1, 'f8c64703d63f106703dfaa75d6f1302fe715def5', 2, '', -1, 'yui_3_17_2_1_1585567846605_67', 1585567846),
(2, 'id_s__summary', 1, 'ee2806d1ae426c149ba7302dc8af8235d724c7a7', 2, '', -1, 'yui_3_17_2_1_1585567852685_67', 1585567851),
(4, 'id_s__summary', 1, 'b5d4fe563b0daf2bcd65008e3fca64546661c025', 2, '', -1, 'yui_3_17_2_1_1585567897183_45', 1585567896);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol`
--

CREATE TABLE `mdl_enrol` (
  `id` bigint(10) NOT NULL,
  `enrol` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` bigint(10) NOT NULL DEFAULT '0',
  `courseid` bigint(10) NOT NULL,
  `sortorder` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enrolperiod` bigint(10) DEFAULT '0',
  `enrolstartdate` bigint(10) DEFAULT '0',
  `enrolenddate` bigint(10) DEFAULT '0',
  `expirynotify` tinyint(1) DEFAULT '0',
  `expirythreshold` bigint(10) DEFAULT '0',
  `notifyall` tinyint(1) DEFAULT '0',
  `password` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roleid` bigint(10) DEFAULT '0',
  `customint1` bigint(10) DEFAULT NULL,
  `customint2` bigint(10) DEFAULT NULL,
  `customint3` bigint(10) DEFAULT NULL,
  `customint4` bigint(10) DEFAULT NULL,
  `customint5` bigint(10) DEFAULT NULL,
  `customint6` bigint(10) DEFAULT NULL,
  `customint7` bigint(10) DEFAULT NULL,
  `customint8` bigint(10) DEFAULT NULL,
  `customchar1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customchar2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customchar3` varchar(1333) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customdec1` decimal(12,7) DEFAULT NULL,
  `customdec2` decimal(12,7) DEFAULT NULL,
  `customtext1` longtext COLLATE utf8mb4_unicode_ci,
  `customtext2` longtext COLLATE utf8mb4_unicode_ci,
  `customtext3` longtext COLLATE utf8mb4_unicode_ci,
  `customtext4` longtext COLLATE utf8mb4_unicode_ci,
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Instances of enrolment plugins used in courses, fields marke' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_apply_applicationinfo`
--

CREATE TABLE `mdl_enrol_apply_applicationinfo` (
  `id` bigint(10) NOT NULL,
  `userenrolmentid` bigint(10) NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table containing additional information for each enrolment a' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_flatfile`
--

CREATE TABLE `mdl_enrol_flatfile` (
  `id` bigint(10) NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `roleid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `timestart` bigint(10) NOT NULL DEFAULT '0',
  `timeend` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='enrol_flatfile table retrofitted from MySQL' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_lti_lti2_consumer`
--

CREATE TABLE `mdl_enrol_lti_lti2_consumer` (
  `id` bigint(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `consumerkey256` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `consumerkey` longtext COLLATE utf8mb4_unicode_ci,
  `secret` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ltiversion` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consumername` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consumerversion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consumerguid` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` longtext COLLATE utf8mb4_unicode_ci,
  `toolproxy` longtext COLLATE utf8mb4_unicode_ci,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `protected` tinyint(1) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `enablefrom` bigint(10) DEFAULT NULL,
  `enableuntil` bigint(10) DEFAULT NULL,
  `lastaccess` bigint(10) DEFAULT NULL,
  `created` bigint(10) NOT NULL,
  `updated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='LTI consumers interacting with moodle' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_lti_lti2_context`
--

CREATE TABLE `mdl_enrol_lti_lti2_context` (
  `id` bigint(11) NOT NULL,
  `consumerid` bigint(11) NOT NULL,
  `lticontextkey` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `created` bigint(10) NOT NULL,
  `updated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Information about a specific LTI contexts from the consumers' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_lti_lti2_nonce`
--

CREATE TABLE `mdl_enrol_lti_lti2_nonce` (
  `id` bigint(11) NOT NULL,
  `consumerid` bigint(11) NOT NULL,
  `value` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Nonce used for authentication between moodle and a consumer' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_lti_lti2_resource_link`
--

CREATE TABLE `mdl_enrol_lti_lti2_resource_link` (
  `id` bigint(11) NOT NULL,
  `contextid` bigint(11) DEFAULT NULL,
  `consumerid` bigint(11) DEFAULT NULL,
  `ltiresourcelinkkey` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `primaryresourcelinkid` bigint(11) DEFAULT NULL,
  `shareapproved` tinyint(1) DEFAULT NULL,
  `created` bigint(10) NOT NULL,
  `updated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Link from the consumer to the tool' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_lti_lti2_share_key`
--

CREATE TABLE `mdl_enrol_lti_lti2_share_key` (
  `id` bigint(11) NOT NULL,
  `sharekey` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `resourcelinkid` bigint(11) NOT NULL,
  `autoapprove` tinyint(1) NOT NULL,
  `expires` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Resource link share key' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_lti_lti2_tool_proxy`
--

CREATE TABLE `mdl_enrol_lti_lti2_tool_proxy` (
  `id` bigint(11) NOT NULL,
  `toolproxykey` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `consumerid` bigint(11) NOT NULL,
  `toolproxy` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` bigint(10) NOT NULL,
  `updated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='A tool proxy between moodle and a consumer' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_lti_lti2_user_result`
--

CREATE TABLE `mdl_enrol_lti_lti2_user_result` (
  `id` bigint(11) NOT NULL,
  `resourcelinkid` bigint(11) NOT NULL,
  `ltiuserkey` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ltiresultsourcedid` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created` bigint(10) NOT NULL,
  `updated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Results for each user for each resource link' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_lti_tools`
--

CREATE TABLE `mdl_enrol_lti_tools` (
  `id` bigint(10) NOT NULL,
  `enrolid` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `institution` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lang` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `timezone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '99',
  `maxenrolled` bigint(10) NOT NULL DEFAULT '0',
  `maildisplay` tinyint(2) NOT NULL DEFAULT '2',
  `city` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `gradesync` tinyint(1) NOT NULL DEFAULT '0',
  `gradesynccompletion` tinyint(1) NOT NULL DEFAULT '0',
  `membersync` tinyint(1) NOT NULL DEFAULT '0',
  `membersyncmode` tinyint(1) NOT NULL DEFAULT '0',
  `roleinstructor` bigint(10) NOT NULL,
  `rolelearner` bigint(10) NOT NULL,
  `secret` longtext COLLATE utf8mb4_unicode_ci,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of tools provided to the remote system' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_lti_tool_consumer_map`
--

CREATE TABLE `mdl_enrol_lti_tool_consumer_map` (
  `id` bigint(10) NOT NULL,
  `toolid` bigint(11) NOT NULL,
  `consumerid` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table that maps the published tool to tool consumers.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_lti_users`
--

CREATE TABLE `mdl_enrol_lti_users` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `toolid` bigint(10) NOT NULL,
  `serviceurl` longtext COLLATE utf8mb4_unicode_ci,
  `sourceid` longtext COLLATE utf8mb4_unicode_ci,
  `consumerkey` longtext COLLATE utf8mb4_unicode_ci,
  `consumersecret` longtext COLLATE utf8mb4_unicode_ci,
  `membershipsurl` longtext COLLATE utf8mb4_unicode_ci,
  `membershipsid` longtext COLLATE utf8mb4_unicode_ci,
  `lastgrade` decimal(10,5) DEFAULT NULL,
  `lastaccess` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User access log and gradeback data' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_enrol_paypal`
--

CREATE TABLE `mdl_enrol_paypal` (
  `id` bigint(10) NOT NULL,
  `business` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `receiver_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `receiver_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `courseid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `instanceid` bigint(10) NOT NULL DEFAULT '0',
  `memo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tax` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_name1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_selection1_x` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_name2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_selection2_x` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pending_reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `reason_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `txn_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `parent_txn_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `payment_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timeupdated` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Holds all known information about PayPal transactions' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_event`
--

CREATE TABLE `mdl_event` (
  `id` bigint(10) NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` smallint(4) NOT NULL DEFAULT '0',
  `categoryid` bigint(10) NOT NULL DEFAULT '0',
  `courseid` bigint(10) NOT NULL DEFAULT '0',
  `groupid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `repeatid` bigint(10) NOT NULL DEFAULT '0',
  `modulename` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `instance` bigint(10) NOT NULL DEFAULT '0',
  `type` smallint(4) NOT NULL DEFAULT '0',
  `eventtype` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timestart` bigint(10) NOT NULL DEFAULT '0',
  `timeduration` bigint(10) NOT NULL DEFAULT '0',
  `timesort` bigint(10) DEFAULT NULL,
  `visible` smallint(4) NOT NULL DEFAULT '1',
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sequence` bigint(10) NOT NULL DEFAULT '1',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `subscriptionid` bigint(10) DEFAULT NULL,
  `priority` bigint(10) DEFAULT NULL,
  `location` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='For everything with a time associated to it' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_event`
--

INSERT INTO `mdl_event` (`id`, `name`, `description`, `format`, `categoryid`, `courseid`, `groupid`, `userid`, `repeatid`, `modulename`, `instance`, `type`, `eventtype`, `timestart`, `timeduration`, `timesort`, `visible`, `uuid`, `sequence`, `timemodified`, `subscriptionid`, `priority`, `location`) VALUES
(1, 'Test Event', '', 1, 0, 0, 0, 2, 0, '0', 0, 0, 'user', 1584077520, 0, NULL, 1, '', 1, 1584077601, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_events_handlers`
--

CREATE TABLE `mdl_events_handlers` (
  `id` bigint(10) NOT NULL,
  `eventname` varchar(166) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `component` varchar(166) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `handlerfile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `handlerfunction` longtext COLLATE utf8mb4_unicode_ci,
  `schedule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` bigint(10) NOT NULL DEFAULT '0',
  `internal` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table is for storing which components requests what typ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_events_queue`
--

CREATE TABLE `mdl_events_queue` (
  `id` bigint(10) NOT NULL,
  `eventdata` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `stackdump` longtext COLLATE utf8mb4_unicode_ci,
  `userid` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table is for storing queued events. It stores only one ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_events_queue_handlers`
--

CREATE TABLE `mdl_events_queue_handlers` (
  `id` bigint(10) NOT NULL,
  `queuedeventid` bigint(10) NOT NULL,
  `handlerid` bigint(10) NOT NULL,
  `status` bigint(10) DEFAULT NULL,
  `errormessage` longtext COLLATE utf8mb4_unicode_ci,
  `timemodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This is the list of queued handlers for processing. The even' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_event_subscriptions`
--

CREATE TABLE `mdl_event_subscriptions` (
  `id` bigint(10) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `categoryid` bigint(10) NOT NULL DEFAULT '0',
  `courseid` bigint(10) NOT NULL DEFAULT '0',
  `groupid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `eventtype` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pollinterval` bigint(10) NOT NULL DEFAULT '0',
  `lastupdated` bigint(10) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tracks subscriptions to remote calendars.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_external_functions`
--

CREATE TABLE `mdl_external_functions` (
  `id` bigint(10) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `classname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `methodname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `classpath` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `component` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `capabilities` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `services` varchar(1333) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='list of all external functions' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_external_functions`
--

INSERT INTO `mdl_external_functions` (`id`, `name`, `classname`, `methodname`, `classpath`, `component`, `capabilities`, `services`) VALUES
(1, 'core_auth_confirm_user', 'core_auth_external', 'confirm_user', NULL, 'moodle', '', NULL),
(2, 'core_auth_request_password_reset', 'core_auth_external', 'request_password_reset', NULL, 'moodle', '', NULL),
(3, 'core_auth_is_minor', 'core_auth_external', 'is_minor', NULL, 'moodle', '', NULL),
(4, 'core_auth_is_age_digital_consent_verification_enabled', 'core_auth_external', 'is_age_digital_consent_verification_enabled', NULL, 'moodle', '', NULL),
(5, 'core_auth_resend_confirmation_email', 'core_auth_external', 'resend_confirmation_email', NULL, 'moodle', '', NULL),
(6, 'core_backup_get_async_backup_progress', 'core_backup_external', 'get_async_backup_progress', 'backup/externallib.php', 'moodle', '', NULL),
(7, 'core_backup_get_async_backup_links_backup', 'core_backup_external', 'get_async_backup_links_backup', 'backup/externallib.php', 'moodle', '', NULL),
(8, 'core_backup_get_async_backup_links_restore', 'core_backup_external', 'get_async_backup_links_restore', 'backup/externallib.php', 'moodle', '', NULL),
(9, 'core_badges_get_user_badges', 'core_badges_external', 'get_user_badges', NULL, 'moodle', 'moodle/badges:viewotherbadges', 'moodle_mobile_app'),
(10, 'core_blog_get_entries', 'core_blog\\external', 'get_entries', NULL, 'moodle', '', 'moodle_mobile_app'),
(11, 'core_blog_view_entries', 'core_blog\\external', 'view_entries', NULL, 'moodle', '', 'moodle_mobile_app'),
(12, 'core_calendar_get_calendar_monthly_view', 'core_calendar_external', 'get_calendar_monthly_view', 'calendar/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(13, 'core_calendar_get_calendar_day_view', 'core_calendar_external', 'get_calendar_day_view', 'calendar/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(14, 'core_calendar_get_calendar_upcoming_view', 'core_calendar_external', 'get_calendar_upcoming_view', 'calendar/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(15, 'core_calendar_update_event_start_day', 'core_calendar_external', 'update_event_start_day', 'calendar/externallib.php', 'moodle', 'moodle/calendar:manageentries, moodle/calendar:manageownentries, moodle/calendar:managegroupentries', 'moodle_mobile_app'),
(16, 'core_calendar_create_calendar_events', 'core_calendar_external', 'create_calendar_events', 'calendar/externallib.php', 'moodle', 'moodle/calendar:manageentries, moodle/calendar:manageownentries, moodle/calendar:managegroupentries', 'moodle_mobile_app'),
(17, 'core_calendar_delete_calendar_events', 'core_calendar_external', 'delete_calendar_events', 'calendar/externallib.php', 'moodle', 'moodle/calendar:manageentries, moodle/calendar:manageownentries, moodle/calendar:managegroupentries', 'moodle_mobile_app'),
(18, 'core_calendar_get_calendar_events', 'core_calendar_external', 'get_calendar_events', 'calendar/externallib.php', 'moodle', 'moodle/calendar:manageentries, moodle/calendar:manageownentries, moodle/calendar:managegroupentries', 'moodle_mobile_app'),
(19, 'core_calendar_get_action_events_by_timesort', 'core_calendar_external', 'get_calendar_action_events_by_timesort', 'calendar/externallib.php', 'moodle', 'moodle/calendar:manageentries, moodle/calendar:manageownentries, moodle/calendar:managegroupentries', 'moodle_mobile_app'),
(20, 'core_calendar_get_action_events_by_course', 'core_calendar_external', 'get_calendar_action_events_by_course', 'calendar/externallib.php', 'moodle', 'moodle/calendar:manageentries, moodle/calendar:manageownentries, moodle/calendar:managegroupentries', 'moodle_mobile_app'),
(21, 'core_calendar_get_action_events_by_courses', 'core_calendar_external', 'get_calendar_action_events_by_courses', 'calendar/externallib.php', 'moodle', 'moodle/calendar:manageentries, moodle/calendar:manageownentries, moodle/calendar:managegroupentries', 'moodle_mobile_app'),
(22, 'core_calendar_get_calendar_event_by_id', 'core_calendar_external', 'get_calendar_event_by_id', 'calendar/externallib.php', 'moodle', 'moodle/calendar:manageentries, moodle/calendar:manageownentries, moodle/calendar:managegroupentries', 'moodle_mobile_app'),
(23, 'core_calendar_submit_create_update_form', 'core_calendar_external', 'submit_create_update_form', 'calendar/externallib.php', 'moodle', 'moodle/calendar:manageentries, moodle/calendar:manageownentries, moodle/calendar:managegroupentries', 'moodle_mobile_app'),
(24, 'core_calendar_get_calendar_access_information', 'core_calendar_external', 'get_calendar_access_information', 'calendar/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(25, 'core_calendar_get_allowed_event_types', 'core_calendar_external', 'get_allowed_event_types', 'calendar/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(26, 'core_calendar_get_timestamps', 'core_calendar_external', 'get_timestamps', 'calendar/externallib.php', 'moodle', '', NULL),
(27, 'core_cohort_add_cohort_members', 'core_cohort_external', 'add_cohort_members', 'cohort/externallib.php', 'moodle', 'moodle/cohort:assign', NULL),
(28, 'core_cohort_create_cohorts', 'core_cohort_external', 'create_cohorts', 'cohort/externallib.php', 'moodle', 'moodle/cohort:manage', NULL),
(29, 'core_cohort_delete_cohort_members', 'core_cohort_external', 'delete_cohort_members', 'cohort/externallib.php', 'moodle', 'moodle/cohort:assign', NULL),
(30, 'core_cohort_delete_cohorts', 'core_cohort_external', 'delete_cohorts', 'cohort/externallib.php', 'moodle', 'moodle/cohort:manage', NULL),
(31, 'core_cohort_get_cohort_members', 'core_cohort_external', 'get_cohort_members', 'cohort/externallib.php', 'moodle', 'moodle/cohort:view', NULL),
(32, 'core_cohort_search_cohorts', 'core_cohort_external', 'search_cohorts', 'cohort/externallib.php', 'moodle', 'moodle/cohort:view', NULL),
(33, 'core_cohort_get_cohorts', 'core_cohort_external', 'get_cohorts', 'cohort/externallib.php', 'moodle', 'moodle/cohort:view', NULL),
(34, 'core_cohort_update_cohorts', 'core_cohort_external', 'update_cohorts', 'cohort/externallib.php', 'moodle', 'moodle/cohort:manage', NULL),
(35, 'core_comment_get_comments', 'core_comment_external', 'get_comments', NULL, 'moodle', 'moodle/comment:view', 'moodle_mobile_app'),
(36, 'core_comment_add_comments', 'core_comment_external', 'add_comments', NULL, 'moodle', '', 'moodle_mobile_app'),
(37, 'core_comment_delete_comments', 'core_comment_external', 'delete_comments', NULL, 'moodle', '', 'moodle_mobile_app'),
(38, 'core_completion_get_activities_completion_status', 'core_completion_external', 'get_activities_completion_status', NULL, 'moodle', '', 'moodle_mobile_app'),
(39, 'core_completion_get_course_completion_status', 'core_completion_external', 'get_course_completion_status', NULL, 'moodle', 'report/completion:view', 'moodle_mobile_app'),
(40, 'core_completion_mark_course_self_completed', 'core_completion_external', 'mark_course_self_completed', NULL, 'moodle', '', 'moodle_mobile_app'),
(41, 'core_completion_update_activity_completion_status_manually', 'core_completion_external', 'update_activity_completion_status_manually', NULL, 'moodle', '', 'moodle_mobile_app'),
(42, 'core_completion_override_activity_completion_status', 'core_completion_external', 'override_activity_completion_status', NULL, 'moodle', 'moodle/course:overridecompletion', NULL),
(43, 'core_course_create_categories', 'core_course_external', 'create_categories', 'course/externallib.php', 'moodle', 'moodle/category:manage', NULL),
(44, 'core_course_create_courses', 'core_course_external', 'create_courses', 'course/externallib.php', 'moodle', 'moodle/course:create, moodle/course:visibility', NULL),
(45, 'core_course_delete_categories', 'core_course_external', 'delete_categories', 'course/externallib.php', 'moodle', 'moodle/category:manage', NULL),
(46, 'core_course_delete_courses', 'core_course_external', 'delete_courses', 'course/externallib.php', 'moodle', 'moodle/course:delete', NULL),
(47, 'core_course_delete_modules', 'core_course_external', 'delete_modules', 'course/externallib.php', 'moodle', 'moodle/course:manageactivities', NULL),
(48, 'core_course_duplicate_course', 'core_course_external', 'duplicate_course', 'course/externallib.php', 'moodle', 'moodle/backup:backupcourse, moodle/restore:restorecourse, moodle/course:create', NULL),
(49, 'core_course_get_categories', 'core_course_external', 'get_categories', 'course/externallib.php', 'moodle', 'moodle/category:viewhiddencategories', 'moodle_mobile_app'),
(50, 'core_course_get_contents', 'core_course_external', 'get_course_contents', 'course/externallib.php', 'moodle', 'moodle/course:update, moodle/course:viewhiddencourses', 'moodle_mobile_app'),
(51, 'core_course_get_course_module', 'core_course_external', 'get_course_module', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(52, 'core_course_get_course_module_by_instance', 'core_course_external', 'get_course_module_by_instance', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(53, 'core_course_get_module', 'core_course_external', 'get_module', 'course/externallib.php', 'moodle', '', NULL),
(54, 'core_course_edit_module', 'core_course_external', 'edit_module', 'course/externallib.php', 'moodle', '', NULL),
(55, 'core_course_edit_section', 'core_course_external', 'edit_section', 'course/externallib.php', 'moodle', '', NULL),
(56, 'core_course_get_courses', 'core_course_external', 'get_courses', 'course/externallib.php', 'moodle', 'moodle/course:view, moodle/course:update, moodle/course:viewhiddencourses', 'moodle_mobile_app'),
(57, 'core_course_import_course', 'core_course_external', 'import_course', 'course/externallib.php', 'moodle', 'moodle/backup:backuptargetimport, moodle/restore:restoretargetimport', NULL),
(58, 'core_course_search_courses', 'core_course_external', 'search_courses', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(59, 'core_course_update_categories', 'core_course_external', 'update_categories', 'course/externallib.php', 'moodle', 'moodle/category:manage', NULL),
(60, 'core_course_update_courses', 'core_course_external', 'update_courses', 'course/externallib.php', 'moodle', 'moodle/course:update, moodle/course:changecategory, moodle/course:changefullname, moodle/course:changeshortname, moodle/course:changeidnumber, moodle/course:changesummary, moodle/course:visibility', NULL),
(61, 'core_course_view_course', 'core_course_external', 'view_course', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(62, 'core_course_get_user_navigation_options', 'core_course_external', 'get_user_navigation_options', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(63, 'core_course_get_user_administration_options', 'core_course_external', 'get_user_administration_options', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(64, 'core_course_get_courses_by_field', 'core_course_external', 'get_courses_by_field', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(65, 'core_course_check_updates', 'core_course_external', 'check_updates', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(66, 'core_course_get_updates_since', 'core_course_external', 'get_updates_since', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(67, 'core_course_get_enrolled_courses_by_timeline_classification', 'core_course_external', 'get_enrolled_courses_by_timeline_classification', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(68, 'core_course_get_recent_courses', 'core_course_external', 'get_recent_courses', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(69, 'core_course_set_favourite_courses', 'core_course_external', 'set_favourite_courses', 'course/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(70, 'core_course_get_enrolled_users_by_cmid', 'core_course_external', 'get_enrolled_users_by_cmid', 'course/externallib.php', 'moodle', '', NULL),
(71, 'core_enrol_get_course_enrolment_methods', 'core_enrol_external', 'get_course_enrolment_methods', 'enrol/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(72, 'core_enrol_get_enrolled_users', 'core_enrol_external', 'get_enrolled_users', 'enrol/externallib.php', 'moodle', 'moodle/user:viewdetails, moodle/user:viewhiddendetails, moodle/course:useremail, moodle/user:update, moodle/site:accessallgroups', 'moodle_mobile_app'),
(73, 'core_enrol_get_enrolled_users_with_capability', 'core_enrol_external', 'get_enrolled_users_with_capability', 'enrol/externallib.php', 'moodle', '', NULL),
(74, 'core_enrol_get_potential_users', 'core_enrol_external', 'get_potential_users', 'enrol/externallib.php', 'moodle', 'moodle/course:enrolreview', NULL),
(75, 'core_enrol_search_users', 'core_enrol_external', 'search_users', 'enrol/externallib.php', 'moodle', 'moodle/course:viewparticipants', 'moodle_mobile_app'),
(76, 'core_enrol_get_users_courses', 'core_enrol_external', 'get_users_courses', 'enrol/externallib.php', 'moodle', 'moodle/course:viewparticipants', 'moodle_mobile_app'),
(77, 'core_enrol_edit_user_enrolment', 'core_enrol_external', 'edit_user_enrolment', 'enrol/externallib.php', 'moodle', '', NULL),
(78, 'core_enrol_submit_user_enrolment_form', 'core_enrol_external', 'submit_user_enrolment_form', 'enrol/externallib.php', 'moodle', '', NULL),
(79, 'core_enrol_unenrol_user_enrolment', 'core_enrol_external', 'unenrol_user_enrolment', 'enrol/externallib.php', 'moodle', '', NULL),
(80, 'core_fetch_notifications', 'core_external', 'fetch_notifications', 'lib/external/externallib.php', 'moodle', '', NULL),
(81, 'core_session_touch', 'core\\session\\external', 'touch_session', NULL, 'moodle', '', NULL),
(82, 'core_session_time_remaining', 'core\\session\\external', 'time_remaining', NULL, 'moodle', '', NULL),
(83, 'core_files_get_files', 'core_files_external', 'get_files', 'files/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(84, 'core_files_upload', 'core_files_external', 'upload', 'files/externallib.php', 'moodle', '', NULL),
(85, 'core_form_get_filetypes_browser_data', 'core_form\\external', 'get_filetypes_browser_data', NULL, 'moodle', '', NULL),
(86, 'core_get_component_strings', 'core_external', 'get_component_strings', 'lib/external/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(87, 'core_get_fragment', 'core_external', 'get_fragment', 'lib/external/externallib.php', 'moodle', '', NULL),
(88, 'core_get_string', 'core_external', 'get_string', 'lib/external/externallib.php', 'moodle', '', NULL),
(89, 'core_get_strings', 'core_external', 'get_strings', 'lib/external/externallib.php', 'moodle', '', NULL),
(90, 'core_get_user_dates', 'core_external', 'get_user_dates', 'lib/external/externallib.php', 'moodle', '', NULL),
(91, 'core_grades_get_grades', 'core_grades_external', 'get_grades', NULL, 'moodle', 'moodle/grade:view, moodle/grade:viewall, moodle/grade:viewhidden', NULL),
(92, 'core_grades_update_grades', 'core_grades_external', 'update_grades', NULL, 'moodle', '', NULL),
(93, 'core_grades_grader_gradingpanel_point_fetch', 'core_grades\\grades\\grader\\gradingpanel\\point\\external\\fetch', 'execute', NULL, 'moodle', '', 'moodle_mobile_app'),
(94, 'core_grades_grader_gradingpanel_point_store', 'core_grades\\grades\\grader\\gradingpanel\\point\\external\\store', 'execute', NULL, 'moodle', '', 'moodle_mobile_app'),
(95, 'core_grades_grader_gradingpanel_scale_fetch', 'core_grades\\grades\\grader\\gradingpanel\\scale\\external\\fetch', 'execute', NULL, 'moodle', '', 'moodle_mobile_app'),
(96, 'core_grades_grader_gradingpanel_scale_store', 'core_grades\\grades\\grader\\gradingpanel\\scale\\external\\store', 'execute', NULL, 'moodle', '', 'moodle_mobile_app'),
(97, 'core_grading_get_definitions', 'core_grading_external', 'get_definitions', NULL, 'moodle', '', NULL),
(98, 'core_grading_get_gradingform_instances', 'core_grading_external', 'get_gradingform_instances', NULL, 'moodle', '', NULL),
(99, 'core_grading_save_definitions', 'core_grading_external', 'save_definitions', NULL, 'moodle', '', NULL),
(100, 'core_group_add_group_members', 'core_group_external', 'add_group_members', 'group/externallib.php', 'moodle', 'moodle/course:managegroups', NULL),
(101, 'core_group_assign_grouping', 'core_group_external', 'assign_grouping', 'group/externallib.php', 'moodle', '', NULL),
(102, 'core_group_create_groupings', 'core_group_external', 'create_groupings', 'group/externallib.php', 'moodle', '', NULL),
(103, 'core_group_create_groups', 'core_group_external', 'create_groups', 'group/externallib.php', 'moodle', 'moodle/course:managegroups', NULL),
(104, 'core_group_delete_group_members', 'core_group_external', 'delete_group_members', 'group/externallib.php', 'moodle', 'moodle/course:managegroups', NULL),
(105, 'core_group_delete_groupings', 'core_group_external', 'delete_groupings', 'group/externallib.php', 'moodle', '', NULL),
(106, 'core_group_delete_groups', 'core_group_external', 'delete_groups', 'group/externallib.php', 'moodle', 'moodle/course:managegroups', NULL),
(107, 'core_group_get_activity_allowed_groups', 'core_group_external', 'get_activity_allowed_groups', 'group/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(108, 'core_group_get_activity_groupmode', 'core_group_external', 'get_activity_groupmode', 'group/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(109, 'core_group_get_course_groupings', 'core_group_external', 'get_course_groupings', 'group/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(110, 'core_group_get_course_groups', 'core_group_external', 'get_course_groups', 'group/externallib.php', 'moodle', 'moodle/course:managegroups', 'moodle_mobile_app'),
(111, 'core_group_get_course_user_groups', 'core_group_external', 'get_course_user_groups', 'group/externallib.php', 'moodle', 'moodle/course:managegroups', 'moodle_mobile_app'),
(112, 'core_group_get_group_members', 'core_group_external', 'get_group_members', 'group/externallib.php', 'moodle', 'moodle/course:managegroups', NULL),
(113, 'core_group_get_groupings', 'core_group_external', 'get_groupings', 'group/externallib.php', 'moodle', '', NULL),
(114, 'core_group_get_groups', 'core_group_external', 'get_groups', 'group/externallib.php', 'moodle', 'moodle/course:managegroups', NULL),
(115, 'core_group_unassign_grouping', 'core_group_external', 'unassign_grouping', 'group/externallib.php', 'moodle', '', NULL),
(116, 'core_group_update_groupings', 'core_group_external', 'update_groupings', 'group/externallib.php', 'moodle', '', NULL),
(117, 'core_group_update_groups', 'core_group_external', 'update_groups', 'group/externallib.php', 'moodle', 'moodle/course:managegroups', NULL),
(118, 'core_message_mute_conversations', 'core_message_external', 'mute_conversations', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(119, 'core_message_unmute_conversations', 'core_message_external', 'unmute_conversations', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(120, 'core_message_block_user', 'core_message_external', 'block_user', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(121, 'core_message_block_contacts', 'core_message_external', 'block_contacts', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(122, 'core_message_create_contacts', 'core_message_external', 'create_contacts', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(123, 'core_message_get_contact_requests', 'core_message_external', 'get_contact_requests', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(124, 'core_message_create_contact_request', 'core_message_external', 'create_contact_request', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(125, 'core_message_confirm_contact_request', 'core_message_external', 'confirm_contact_request', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(126, 'core_message_decline_contact_request', 'core_message_external', 'decline_contact_request', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(127, 'core_message_get_received_contact_requests_count', 'core_message_external', 'get_received_contact_requests_count', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(128, 'core_message_delete_contacts', 'core_message_external', 'delete_contacts', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(129, 'core_message_delete_conversation', 'core_message_external', 'delete_conversation', 'message/externallib.php', 'moodle', 'moodle/site:deleteownmessage', 'moodle_mobile_app'),
(130, 'core_message_delete_conversations_by_id', 'core_message_external', 'delete_conversations_by_id', 'message/externallib.php', 'moodle', 'moodle/site:deleteownmessage', 'moodle_mobile_app'),
(131, 'core_message_delete_message', 'core_message_external', 'delete_message', 'message/externallib.php', 'moodle', 'moodle/site:deleteownmessage', 'moodle_mobile_app'),
(132, 'core_message_get_blocked_users', 'core_message_external', 'get_blocked_users', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(133, 'core_message_data_for_messagearea_search_messages', 'core_message_external', 'data_for_messagearea_search_messages', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(134, 'core_message_data_for_messagearea_search_users', 'core_message_external', 'data_for_messagearea_search_users', 'message/externallib.php', 'moodle', '', NULL),
(135, 'core_message_data_for_messagearea_search_users_in_course', 'core_message_external', 'data_for_messagearea_search_users_in_course', 'message/externallib.php', 'moodle', '', NULL),
(136, 'core_message_message_search_users', 'core_message_external', 'message_search_users', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(137, 'core_message_data_for_messagearea_conversations', 'core_message_external', 'data_for_messagearea_conversations', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(138, 'core_message_data_for_messagearea_contacts', 'core_message_external', 'data_for_messagearea_contacts', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(139, 'core_message_data_for_messagearea_messages', 'core_message_external', 'data_for_messagearea_messages', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(140, 'core_message_data_for_messagearea_get_most_recent_message', 'core_message_external', 'data_for_messagearea_get_most_recent_message', 'message/externallib.php', 'moodle', '', NULL),
(141, 'core_message_data_for_messagearea_get_profile', 'core_message_external', 'data_for_messagearea_get_profile', 'message/externallib.php', 'moodle', '', NULL),
(142, 'core_message_get_contacts', 'core_message_external', 'get_contacts', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(143, 'core_message_get_user_contacts', 'core_message_external', 'get_user_contacts', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(144, 'core_message_get_conversations', 'core_message_external', 'get_conversations', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(145, 'core_message_get_conversation', 'core_message_external', 'get_conversation', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(146, 'core_message_get_conversation_between_users', 'core_message_external', 'get_conversation_between_users', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(147, 'core_message_get_self_conversation', 'core_message_external', 'get_self_conversation', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(148, 'core_message_get_messages', 'core_message_external', 'get_messages', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(149, 'core_message_get_conversation_counts', 'core_message_external', 'get_conversation_counts', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(150, 'core_message_get_unread_conversation_counts', 'core_message_external', 'get_unread_conversation_counts', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(151, 'core_message_get_conversation_members', 'core_message_external', 'get_conversation_members', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(152, 'core_message_get_member_info', 'core_message_external', 'get_member_info', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(153, 'core_message_get_unread_conversations_count', 'core_message_external', 'get_unread_conversations_count', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(154, 'core_message_mark_all_notifications_as_read', 'core_message_external', 'mark_all_notifications_as_read', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(155, 'core_message_mark_all_messages_as_read', 'core_message_external', 'mark_all_messages_as_read', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(156, 'core_message_mark_all_conversation_messages_as_read', 'core_message_external', 'mark_all_conversation_messages_as_read', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(157, 'core_message_mark_message_read', 'core_message_external', 'mark_message_read', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(158, 'core_message_mark_notification_read', 'core_message_external', 'mark_notification_read', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(159, 'core_message_message_processor_config_form', 'core_message_external', 'message_processor_config_form', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(160, 'core_message_get_message_processor', 'core_message_external', 'get_message_processor', 'message/externallib.php', 'moodle', '', NULL),
(161, 'core_message_search_contacts', 'core_message_external', 'search_contacts', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(162, 'core_message_send_instant_messages', 'core_message_external', 'send_instant_messages', 'message/externallib.php', 'moodle', 'moodle/site:sendmessage', 'moodle_mobile_app'),
(163, 'core_message_send_messages_to_conversation', 'core_message_external', 'send_messages_to_conversation', 'message/externallib.php', 'moodle', 'moodle/site:sendmessage', 'moodle_mobile_app'),
(164, 'core_message_get_conversation_messages', 'core_message_external', 'get_conversation_messages', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(165, 'core_message_unblock_user', 'core_message_external', 'unblock_user', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(166, 'core_message_unblock_contacts', 'core_message_external', 'unblock_contacts', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(167, 'core_message_get_user_notification_preferences', 'core_message_external', 'get_user_notification_preferences', 'message/externallib.php', 'moodle', 'moodle/user:editownmessageprofile', 'moodle_mobile_app'),
(168, 'core_message_get_user_message_preferences', 'core_message_external', 'get_user_message_preferences', 'message/externallib.php', 'moodle', 'moodle/user:editownmessageprofile', 'moodle_mobile_app'),
(169, 'core_message_set_favourite_conversations', 'core_message_external', 'set_favourite_conversations', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(170, 'core_message_unset_favourite_conversations', 'core_message_external', 'unset_favourite_conversations', 'message/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(171, 'core_message_delete_message_for_all_users', 'core_message_external', 'delete_message_for_all_users', 'message/externallib.php', 'moodle', 'moodle/site:deleteanymessage', 'moodle_mobile_app'),
(172, 'core_notes_create_notes', 'core_notes_external', 'create_notes', 'notes/externallib.php', 'moodle', 'moodle/notes:manage', 'moodle_mobile_app'),
(173, 'core_notes_delete_notes', 'core_notes_external', 'delete_notes', 'notes/externallib.php', 'moodle', 'moodle/notes:manage', 'moodle_mobile_app'),
(174, 'core_notes_get_course_notes', 'core_notes_external', 'get_course_notes', 'notes/externallib.php', 'moodle', 'moodle/notes:view', 'moodle_mobile_app'),
(175, 'core_notes_get_notes', 'core_notes_external', 'get_notes', 'notes/externallib.php', 'moodle', 'moodle/notes:view', NULL),
(176, 'core_notes_update_notes', 'core_notes_external', 'update_notes', 'notes/externallib.php', 'moodle', 'moodle/notes:manage', NULL),
(177, 'core_notes_view_notes', 'core_notes_external', 'view_notes', 'notes/externallib.php', 'moodle', 'moodle/notes:view', 'moodle_mobile_app'),
(178, 'core_output_load_template', 'core\\output\\external', 'load_template', NULL, 'moodle', '', NULL),
(179, 'core_output_load_template_with_dependencies', 'core\\output\\external', 'load_template_with_dependencies', NULL, 'moodle', '', NULL),
(180, 'core_output_load_fontawesome_icon_map', 'core\\output\\external', 'load_fontawesome_icon_map', NULL, 'moodle', '', NULL),
(181, 'core_question_update_flag', 'core_question_external', 'update_flag', NULL, 'moodle', 'moodle/question:flag', 'moodle_mobile_app'),
(182, 'core_question_submit_tags_form', 'core_question_external', 'submit_tags_form', NULL, 'moodle', '', NULL),
(183, 'core_question_get_random_question_summaries', 'core_question_external', 'get_random_question_summaries', NULL, 'moodle', '', NULL),
(184, 'core_rating_get_item_ratings', 'core_rating_external', 'get_item_ratings', NULL, 'moodle', 'moodle/rating:view', 'moodle_mobile_app'),
(185, 'core_rating_add_rating', 'core_rating_external', 'add_rating', NULL, 'moodle', 'moodle/rating:rate', 'moodle_mobile_app'),
(186, 'core_role_assign_roles', 'core_role_external', 'assign_roles', 'enrol/externallib.php', 'moodle', 'moodle/role:assign', NULL),
(187, 'core_role_unassign_roles', 'core_role_external', 'unassign_roles', 'enrol/externallib.php', 'moodle', 'moodle/role:assign', NULL),
(188, 'core_search_get_relevant_users', '\\core_search\\external', 'get_relevant_users', NULL, 'moodle', '', NULL),
(189, 'core_tag_get_tagindex', 'core_tag_external', 'get_tagindex', NULL, 'moodle', '', 'moodle_mobile_app'),
(190, 'core_tag_get_tags', 'core_tag_external', 'get_tags', NULL, 'moodle', '', NULL),
(191, 'core_tag_update_tags', 'core_tag_external', 'update_tags', NULL, 'moodle', '', NULL),
(192, 'core_tag_get_tagindex_per_area', 'core_tag_external', 'get_tagindex_per_area', NULL, 'moodle', '', 'moodle_mobile_app'),
(193, 'core_tag_get_tag_areas', 'core_tag_external', 'get_tag_areas', NULL, 'moodle', '', 'moodle_mobile_app'),
(194, 'core_tag_get_tag_collections', 'core_tag_external', 'get_tag_collections', NULL, 'moodle', '', 'moodle_mobile_app'),
(195, 'core_tag_get_tag_cloud', 'core_tag_external', 'get_tag_cloud', NULL, 'moodle', '', 'moodle_mobile_app'),
(196, 'core_update_inplace_editable', 'core_external', 'update_inplace_editable', 'lib/external/externallib.php', 'moodle', '', NULL),
(197, 'core_user_add_user_device', 'core_user_external', 'add_user_device', 'user/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(198, 'core_user_add_user_private_files', 'core_user_external', 'add_user_private_files', 'user/externallib.php', 'moodle', 'moodle/user:manageownfiles', 'moodle_mobile_app'),
(199, 'core_user_create_users', 'core_user_external', 'create_users', 'user/externallib.php', 'moodle', 'moodle/user:create', NULL),
(200, 'core_user_delete_users', 'core_user_external', 'delete_users', 'user/externallib.php', 'moodle', 'moodle/user:delete', NULL),
(201, 'core_user_get_course_user_profiles', 'core_user_external', 'get_course_user_profiles', 'user/externallib.php', 'moodle', 'moodle/user:viewdetails, moodle/user:viewhiddendetails, moodle/course:useremail, moodle/user:update, moodle/site:accessallgroups', 'moodle_mobile_app'),
(202, 'core_user_get_users', 'core_user_external', 'get_users', 'user/externallib.php', 'moodle', 'moodle/user:viewdetails, moodle/user:viewhiddendetails, moodle/course:useremail, moodle/user:update', NULL),
(203, 'core_user_get_users_by_field', 'core_user_external', 'get_users_by_field', 'user/externallib.php', 'moodle', 'moodle/user:viewdetails, moodle/user:viewhiddendetails, moodle/course:useremail, moodle/user:update', 'moodle_mobile_app'),
(204, 'core_user_remove_user_device', 'core_user_external', 'remove_user_device', 'user/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(205, 'core_user_update_users', 'core_user_external', 'update_users', 'user/externallib.php', 'moodle', 'moodle/user:update', NULL),
(206, 'core_user_update_user_preferences', 'core_user_external', 'update_user_preferences', 'user/externallib.php', 'moodle', 'moodle/user:editownmessageprofile, moodle/user:editmessageprofile', 'moodle_mobile_app'),
(207, 'core_user_view_user_list', 'core_user_external', 'view_user_list', 'user/externallib.php', 'moodle', 'moodle/course:viewparticipants', 'moodle_mobile_app'),
(208, 'core_user_view_user_profile', 'core_user_external', 'view_user_profile', 'user/externallib.php', 'moodle', 'moodle/user:viewdetails', 'moodle_mobile_app'),
(209, 'core_user_get_user_preferences', 'core_user_external', 'get_user_preferences', 'user/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(210, 'core_user_update_picture', 'core_user_external', 'update_picture', 'user/externallib.php', 'moodle', 'moodle/user:editownprofile, moodle/user:editprofile', 'moodle_mobile_app'),
(211, 'core_user_set_user_preferences', 'core_user_external', 'set_user_preferences', 'user/externallib.php', 'moodle', 'moodle/site:config', 'moodle_mobile_app'),
(212, 'core_user_agree_site_policy', 'core_user_external', 'agree_site_policy', 'user/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(213, 'core_user_get_private_files_info', 'core_user_external', 'get_private_files_info', 'user/externallib.php', 'moodle', 'moodle/user:manageownfiles', 'moodle_mobile_app'),
(214, 'core_competency_create_competency_framework', 'core_competency\\external', 'create_competency_framework', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(215, 'core_competency_read_competency_framework', 'core_competency\\external', 'read_competency_framework', NULL, 'moodle', 'moodle/competency:competencyview', NULL),
(216, 'core_competency_duplicate_competency_framework', 'core_competency\\external', 'duplicate_competency_framework', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(217, 'core_competency_delete_competency_framework', 'core_competency\\external', 'delete_competency_framework', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(218, 'core_competency_update_competency_framework', 'core_competency\\external', 'update_competency_framework', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(219, 'core_competency_list_competency_frameworks', 'core_competency\\external', 'list_competency_frameworks', NULL, 'moodle', 'moodle/competency:competencyview', NULL),
(220, 'core_competency_count_competency_frameworks', 'core_competency\\external', 'count_competency_frameworks', NULL, 'moodle', 'moodle/competency:competencyview', NULL),
(221, 'core_competency_competency_framework_viewed', 'core_competency\\external', 'competency_framework_viewed', NULL, 'moodle', 'moodle/competency:competencyview', NULL),
(222, 'core_competency_create_competency', 'core_competency\\external', 'create_competency', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(223, 'core_competency_read_competency', 'core_competency\\external', 'read_competency', NULL, 'moodle', 'moodle/competency:competencyview', NULL),
(224, 'core_competency_competency_viewed', 'core_competency\\external', 'competency_viewed', NULL, 'moodle', 'moodle/competency:competencyview', 'moodle_mobile_app'),
(225, 'core_competency_delete_competency', 'core_competency\\external', 'delete_competency', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(226, 'core_competency_update_competency', 'core_competency\\external', 'update_competency', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(227, 'core_competency_list_competencies', 'core_competency\\external', 'list_competencies', NULL, 'moodle', 'moodle/competency:competencyview', NULL),
(228, 'core_competency_list_competencies_in_template', 'core_competency\\external', 'list_competencies_in_template', NULL, 'moodle', 'moodle/competency:competencyview', NULL),
(229, 'core_competency_count_competencies', 'core_competency\\external', 'count_competencies', NULL, 'moodle', 'moodle/competency:competencyview', NULL),
(230, 'core_competency_count_competencies_in_template', 'core_competency\\external', 'count_competencies_in_template', NULL, 'moodle', 'moodle/competency:competencyview', NULL),
(231, 'core_competency_search_competencies', 'core_competency\\external', 'search_competencies', NULL, 'moodle', 'moodle/competency:competencyview', NULL),
(232, 'core_competency_set_parent_competency', 'core_competency\\external', 'set_parent_competency', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(233, 'core_competency_move_up_competency', 'core_competency\\external', 'move_up_competency', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(234, 'core_competency_move_down_competency', 'core_competency\\external', 'move_down_competency', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(235, 'core_competency_list_course_module_competencies', 'core_competency\\external', 'list_course_module_competencies', NULL, 'moodle', 'moodle/competency:coursecompetencyview', NULL),
(236, 'core_competency_count_course_module_competencies', 'core_competency\\external', 'count_course_module_competencies', NULL, 'moodle', 'moodle/competency:coursecompetencyview', NULL),
(237, 'core_competency_list_course_competencies', 'core_competency\\external', 'list_course_competencies', NULL, 'moodle', 'moodle/competency:coursecompetencyview', 'moodle_mobile_app'),
(238, 'core_competency_count_competencies_in_course', 'core_competency\\external', 'count_competencies_in_course', NULL, 'moodle', 'moodle/competency:coursecompetencyview', NULL),
(239, 'core_competency_count_courses_using_competency', 'core_competency\\external', 'count_courses_using_competency', NULL, 'moodle', 'moodle/competency:coursecompetencyview', NULL),
(240, 'core_competency_add_competency_to_course', 'core_competency\\external', 'add_competency_to_course', NULL, 'moodle', 'moodle/competency:coursecompetencymanage', NULL),
(241, 'core_competency_add_competency_to_template', 'core_competency\\external', 'add_competency_to_template', NULL, 'moodle', 'moodle/competency:templatemanage', NULL),
(242, 'core_competency_remove_competency_from_course', 'core_competency\\external', 'remove_competency_from_course', NULL, 'moodle', 'moodle/competency:coursecompetencymanage', NULL),
(243, 'core_competency_set_course_competency_ruleoutcome', 'core_competency\\external', 'set_course_competency_ruleoutcome', NULL, 'moodle', 'moodle/competency:coursecompetencymanage', NULL),
(244, 'core_competency_remove_competency_from_template', 'core_competency\\external', 'remove_competency_from_template', NULL, 'moodle', 'moodle/competency:templatemanage', NULL),
(245, 'core_competency_reorder_course_competency', 'core_competency\\external', 'reorder_course_competency', NULL, 'moodle', 'moodle/competency:coursecompetencymanage', NULL),
(246, 'core_competency_reorder_template_competency', 'core_competency\\external', 'reorder_template_competency', NULL, 'moodle', 'moodle/competency:templatemanage', NULL),
(247, 'core_competency_create_template', 'core_competency\\external', 'create_template', NULL, 'moodle', 'moodle/competency:templatemanage', NULL),
(248, 'core_competency_duplicate_template', 'core_competency\\external', 'duplicate_template', NULL, 'moodle', 'moodle/competency:templatemanage', NULL),
(249, 'core_competency_read_template', 'core_competency\\external', 'read_template', NULL, 'moodle', 'moodle/competency:templateview', NULL),
(250, 'core_competency_delete_template', 'core_competency\\external', 'delete_template', NULL, 'moodle', 'moodle/competency:templatemanage', NULL),
(251, 'core_competency_update_template', 'core_competency\\external', 'update_template', NULL, 'moodle', 'moodle/competency:templatemanage', NULL),
(252, 'core_competency_list_templates', 'core_competency\\external', 'list_templates', NULL, 'moodle', 'moodle/competency:templateview', NULL),
(253, 'core_competency_list_templates_using_competency', 'core_competency\\external', 'list_templates_using_competency', NULL, 'moodle', 'moodle/competency:templateview', NULL),
(254, 'core_competency_count_templates', 'core_competency\\external', 'count_templates', NULL, 'moodle', 'moodle/competency:templateview', NULL),
(255, 'core_competency_count_templates_using_competency', 'core_competency\\external', 'count_templates_using_competency', NULL, 'moodle', 'moodle/competency:templateview', NULL),
(256, 'core_competency_create_plan', 'core_competency\\external', 'create_plan', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(257, 'core_competency_update_plan', 'core_competency\\external', 'update_plan', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(258, 'core_competency_complete_plan', 'core_competency\\external', 'complete_plan', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(259, 'core_competency_reopen_plan', 'core_competency\\external', 'reopen_plan', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(260, 'core_competency_read_plan', 'core_competency\\external', 'read_plan', NULL, 'moodle', 'moodle/competency:planviewown', NULL),
(261, 'core_competency_delete_plan', 'core_competency\\external', 'delete_plan', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(262, 'core_competency_list_user_plans', 'core_competency\\external', 'list_user_plans', NULL, 'moodle', 'moodle/competency:planviewown', NULL),
(263, 'core_competency_list_plan_competencies', 'core_competency\\external', 'list_plan_competencies', NULL, 'moodle', 'moodle/competency:planviewown', NULL),
(264, 'core_competency_add_competency_to_plan', 'core_competency\\external', 'add_competency_to_plan', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(265, 'core_competency_remove_competency_from_plan', 'core_competency\\external', 'remove_competency_from_plan', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(266, 'core_competency_reorder_plan_competency', 'core_competency\\external', 'reorder_plan_competency', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(267, 'core_competency_plan_request_review', 'core_competency\\external', 'plan_request_review', NULL, 'moodle', 'moodle/competency:planmanagedraft', NULL),
(268, 'core_competency_plan_start_review', 'core_competency\\external', 'plan_start_review', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(269, 'core_competency_plan_stop_review', 'core_competency\\external', 'plan_stop_review', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(270, 'core_competency_plan_cancel_review_request', 'core_competency\\external', 'plan_cancel_review_request', NULL, 'moodle', 'moodle/competency:planmanagedraft', NULL),
(271, 'core_competency_approve_plan', 'core_competency\\external', 'approve_plan', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(272, 'core_competency_unapprove_plan', 'core_competency\\external', 'unapprove_plan', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(273, 'core_competency_template_has_related_data', 'core_competency\\external', 'template_has_related_data', NULL, 'moodle', 'moodle/competency:templateview', NULL),
(274, 'core_competency_get_scale_values', 'core_competency\\external', 'get_scale_values', NULL, 'moodle', 'moodle/competency:competencymanage', 'moodle_mobile_app'),
(275, 'core_competency_add_related_competency', 'core_competency\\external', 'add_related_competency', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(276, 'core_competency_remove_related_competency', 'core_competency\\external', 'remove_related_competency', NULL, 'moodle', 'moodle/competency:competencymanage', NULL),
(277, 'core_competency_read_user_evidence', 'core_competency\\external', 'read_user_evidence', NULL, 'moodle', 'moodle/competency:userevidenceview', NULL),
(278, 'core_competency_delete_user_evidence', 'core_competency\\external', 'delete_user_evidence', NULL, 'moodle', 'moodle/competency:userevidencemanageown', NULL),
(279, 'core_competency_create_user_evidence_competency', 'core_competency\\external', 'create_user_evidence_competency', NULL, 'moodle', 'moodle/competency:userevidencemanageown, moodle/competency:competencyview', NULL),
(280, 'core_competency_delete_user_evidence_competency', 'core_competency\\external', 'delete_user_evidence_competency', NULL, 'moodle', 'moodle/competency:userevidencemanageown', NULL),
(281, 'core_competency_user_competency_cancel_review_request', 'core_competency\\external', 'user_competency_cancel_review_request', NULL, 'moodle', 'moodle/competency:userevidencemanageown', NULL),
(282, 'core_competency_user_competency_request_review', 'core_competency\\external', 'user_competency_request_review', NULL, 'moodle', 'moodle/competency:userevidencemanageown', NULL),
(283, 'core_competency_user_competency_start_review', 'core_competency\\external', 'user_competency_start_review', NULL, 'moodle', 'moodle/competency:competencygrade', NULL),
(284, 'core_competency_user_competency_stop_review', 'core_competency\\external', 'user_competency_stop_review', NULL, 'moodle', 'moodle/competency:competencygrade', NULL),
(285, 'core_competency_user_competency_viewed', 'core_competency\\external', 'user_competency_viewed', NULL, 'moodle', 'moodle/competency:usercompetencyview', 'moodle_mobile_app'),
(286, 'core_competency_user_competency_viewed_in_plan', 'core_competency\\external', 'user_competency_viewed_in_plan', NULL, 'moodle', 'moodle/competency:usercompetencyview', 'moodle_mobile_app'),
(287, 'core_competency_user_competency_viewed_in_course', 'core_competency\\external', 'user_competency_viewed_in_course', NULL, 'moodle', 'moodle/competency:usercompetencyview', 'moodle_mobile_app'),
(288, 'core_competency_user_competency_plan_viewed', 'core_competency\\external', 'user_competency_plan_viewed', NULL, 'moodle', 'moodle/competency:usercompetencyview', 'moodle_mobile_app'),
(289, 'core_competency_grade_competency', 'core_competency\\external', 'grade_competency', NULL, 'moodle', 'moodle/competency:competencygrade', NULL),
(290, 'core_competency_grade_competency_in_plan', 'core_competency\\external', 'grade_competency_in_plan', NULL, 'moodle', 'moodle/competency:competencygrade', NULL),
(291, 'core_competency_grade_competency_in_course', 'core_competency\\external', 'grade_competency_in_course', NULL, 'moodle', 'moodle/competency:competencygrade', 'moodle_mobile_app'),
(292, 'core_competency_unlink_plan_from_template', 'core_competency\\external', 'unlink_plan_from_template', NULL, 'moodle', 'moodle/competency:planmanage', NULL),
(293, 'core_competency_template_viewed', 'core_competency\\external', 'template_viewed', NULL, 'moodle', 'moodle/competency:templateview', NULL),
(294, 'core_competency_request_review_of_user_evidence_linked_competencies', 'core_competency\\external', 'request_review_of_user_evidence_linked_competencies', NULL, 'moodle', 'moodle/competency:userevidencemanageown', NULL),
(295, 'core_competency_update_course_competency_settings', 'core_competency\\external', 'update_course_competency_settings', NULL, 'moodle', 'moodle/competency:coursecompetencyconfigure', NULL),
(296, 'core_competency_delete_evidence', 'core_competency\\external', 'delete_evidence', NULL, 'moodle', 'moodle/competency:evidencedelete', 'moodle_mobile_app'),
(297, 'core_webservice_get_site_info', 'core_webservice_external', 'get_site_info', 'webservice/externallib.php', 'moodle', '', 'moodle_mobile_app'),
(298, 'core_block_get_course_blocks', 'core_block_external', 'get_course_blocks', NULL, 'moodle', '', 'moodle_mobile_app'),
(299, 'core_block_get_dashboard_blocks', 'core_block_external', 'get_dashboard_blocks', NULL, 'moodle', '', 'moodle_mobile_app'),
(300, 'core_filters_get_available_in_context', 'core_filters\\external', 'get_available_in_context', NULL, 'moodle', '', 'moodle_mobile_app'),
(301, 'core_customfield_delete_field', 'core_customfield_external', 'delete_field', 'customfield/externallib.php', 'moodle', '', NULL),
(302, 'core_customfield_reload_template', 'core_customfield_external', 'reload_template', 'customfield/externallib.php', 'moodle', '', NULL),
(303, 'core_customfield_create_category', 'core_customfield_external', 'create_category', 'customfield/externallib.php', 'moodle', '', NULL),
(304, 'core_customfield_delete_category', 'core_customfield_external', 'delete_category', 'customfield/externallib.php', 'moodle', '', NULL),
(305, 'core_customfield_move_field', 'core_customfield_external', 'move_field', 'customfield/externallib.php', 'moodle', '', NULL),
(306, 'core_customfield_move_category', 'core_customfield_external', 'move_category', 'customfield/externallib.php', 'moodle', '', NULL),
(307, 'core_h5p_get_trusted_h5p_file', 'core_h5p\\external', 'get_trusted_h5p_file', NULL, 'moodle', '', 'moodle_mobile_app'),
(308, 'mod_assign_copy_previous_attempt', 'mod_assign_external', 'copy_previous_attempt', 'mod/assign/externallib.php', 'mod_assign', 'mod/assign:view, mod/assign:submit', NULL),
(309, 'mod_assign_get_grades', 'mod_assign_external', 'get_grades', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(310, 'mod_assign_get_assignments', 'mod_assign_external', 'get_assignments', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(311, 'mod_assign_get_submissions', 'mod_assign_external', 'get_submissions', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(312, 'mod_assign_get_user_flags', 'mod_assign_external', 'get_user_flags', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(313, 'mod_assign_set_user_flags', 'mod_assign_external', 'set_user_flags', 'mod/assign/externallib.php', 'mod_assign', 'mod/assign:grade', 'moodle_mobile_app'),
(314, 'mod_assign_get_user_mappings', 'mod_assign_external', 'get_user_mappings', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(315, 'mod_assign_revert_submissions_to_draft', 'mod_assign_external', 'revert_submissions_to_draft', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(316, 'mod_assign_lock_submissions', 'mod_assign_external', 'lock_submissions', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(317, 'mod_assign_unlock_submissions', 'mod_assign_external', 'unlock_submissions', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app');
INSERT INTO `mdl_external_functions` (`id`, `name`, `classname`, `methodname`, `classpath`, `component`, `capabilities`, `services`) VALUES
(318, 'mod_assign_save_submission', 'mod_assign_external', 'save_submission', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(319, 'mod_assign_submit_for_grading', 'mod_assign_external', 'submit_for_grading', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(320, 'mod_assign_save_grade', 'mod_assign_external', 'save_grade', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(321, 'mod_assign_save_grades', 'mod_assign_external', 'save_grades', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(322, 'mod_assign_save_user_extensions', 'mod_assign_external', 'save_user_extensions', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(323, 'mod_assign_reveal_identities', 'mod_assign_external', 'reveal_identities', 'mod/assign/externallib.php', 'mod_assign', '', 'moodle_mobile_app'),
(324, 'mod_assign_view_grading_table', 'mod_assign_external', 'view_grading_table', 'mod/assign/externallib.php', 'mod_assign', 'mod/assign:view, mod/assign:viewgrades', 'moodle_mobile_app'),
(325, 'mod_assign_view_submission_status', 'mod_assign_external', 'view_submission_status', 'mod/assign/externallib.php', 'mod_assign', 'mod/assign:view', 'moodle_mobile_app'),
(326, 'mod_assign_get_submission_status', 'mod_assign_external', 'get_submission_status', 'mod/assign/externallib.php', 'mod_assign', 'mod/assign:view', 'moodle_mobile_app'),
(327, 'mod_assign_list_participants', 'mod_assign_external', 'list_participants', 'mod/assign/externallib.php', 'mod_assign', 'mod/assign:view, mod/assign:viewgrades', 'moodle_mobile_app'),
(328, 'mod_assign_submit_grading_form', 'mod_assign_external', 'submit_grading_form', 'mod/assign/externallib.php', 'mod_assign', 'mod/assign:grade', 'moodle_mobile_app'),
(329, 'mod_assign_get_participant', 'mod_assign_external', 'get_participant', 'mod/assign/externallib.php', 'mod_assign', 'mod/assign:view, mod/assign:viewgrades', 'moodle_mobile_app'),
(330, 'mod_assign_view_assign', 'mod_assign_external', 'view_assign', 'mod/assign/externallib.php', 'mod_assign', 'mod/assign:view', 'moodle_mobile_app'),
(331, 'mod_book_view_book', 'mod_book_external', 'view_book', NULL, 'mod_book', 'mod/book:read', 'moodle_mobile_app'),
(332, 'mod_book_get_books_by_courses', 'mod_book_external', 'get_books_by_courses', NULL, 'mod_book', '', 'moodle_mobile_app'),
(333, 'mod_chat_login_user', 'mod_chat_external', 'login_user', NULL, 'mod_chat', 'mod/chat:chat', 'moodle_mobile_app'),
(334, 'mod_chat_get_chat_users', 'mod_chat_external', 'get_chat_users', NULL, 'mod_chat', 'mod/chat:chat', 'moodle_mobile_app'),
(335, 'mod_chat_send_chat_message', 'mod_chat_external', 'send_chat_message', NULL, 'mod_chat', 'mod/chat:chat', 'moodle_mobile_app'),
(336, 'mod_chat_get_chat_latest_messages', 'mod_chat_external', 'get_chat_latest_messages', NULL, 'mod_chat', 'mod/chat:chat', 'moodle_mobile_app'),
(337, 'mod_chat_view_chat', 'mod_chat_external', 'view_chat', NULL, 'mod_chat', 'mod/chat:chat', 'moodle_mobile_app'),
(338, 'mod_chat_get_chats_by_courses', 'mod_chat_external', 'get_chats_by_courses', NULL, 'mod_chat', '', 'moodle_mobile_app'),
(339, 'mod_chat_get_sessions', 'mod_chat_external', 'get_sessions', NULL, 'mod_chat', '', 'moodle_mobile_app'),
(340, 'mod_chat_get_session_messages', 'mod_chat_external', 'get_session_messages', NULL, 'mod_chat', '', 'moodle_mobile_app'),
(341, 'mod_choice_get_choice_results', 'mod_choice_external', 'get_choice_results', NULL, 'mod_choice', '', 'moodle_mobile_app'),
(342, 'mod_choice_get_choice_options', 'mod_choice_external', 'get_choice_options', NULL, 'mod_choice', 'mod/choice:choose', 'moodle_mobile_app'),
(343, 'mod_choice_submit_choice_response', 'mod_choice_external', 'submit_choice_response', NULL, 'mod_choice', 'mod/choice:choose', 'moodle_mobile_app'),
(344, 'mod_choice_view_choice', 'mod_choice_external', 'view_choice', NULL, 'mod_choice', '', 'moodle_mobile_app'),
(345, 'mod_choice_get_choices_by_courses', 'mod_choice_external', 'get_choices_by_courses', NULL, 'mod_choice', '', 'moodle_mobile_app'),
(346, 'mod_choice_delete_choice_responses', 'mod_choice_external', 'delete_choice_responses', NULL, 'mod_choice', 'mod/choice:choose', 'moodle_mobile_app'),
(347, 'mod_data_get_databases_by_courses', 'mod_data_external', 'get_databases_by_courses', NULL, 'mod_data', 'mod/data:viewentry', 'moodle_mobile_app'),
(348, 'mod_data_view_database', 'mod_data_external', 'view_database', NULL, 'mod_data', 'mod/data:viewentry', 'moodle_mobile_app'),
(349, 'mod_data_get_data_access_information', 'mod_data_external', 'get_data_access_information', NULL, 'mod_data', 'mod/data:viewentry', 'moodle_mobile_app'),
(350, 'mod_data_get_entries', 'mod_data_external', 'get_entries', NULL, 'mod_data', 'mod/data:viewentry', 'moodle_mobile_app'),
(351, 'mod_data_get_entry', 'mod_data_external', 'get_entry', NULL, 'mod_data', 'mod/data:viewentry', 'moodle_mobile_app'),
(352, 'mod_data_get_fields', 'mod_data_external', 'get_fields', NULL, 'mod_data', 'mod/data:viewentry', 'moodle_mobile_app'),
(353, 'mod_data_search_entries', 'mod_data_external', 'search_entries', NULL, 'mod_data', 'mod/data:viewentry', 'moodle_mobile_app'),
(354, 'mod_data_approve_entry', 'mod_data_external', 'approve_entry', NULL, 'mod_data', 'mod/data:approve', 'moodle_mobile_app'),
(355, 'mod_data_delete_entry', 'mod_data_external', 'delete_entry', NULL, 'mod_data', 'mod/data:manageentries', 'moodle_mobile_app'),
(356, 'mod_data_add_entry', 'mod_data_external', 'add_entry', NULL, 'mod_data', 'mod/data:writeentry', 'moodle_mobile_app'),
(357, 'mod_data_update_entry', 'mod_data_external', 'update_entry', NULL, 'mod_data', 'mod/data:writeentry', 'moodle_mobile_app'),
(358, 'mod_feedback_get_feedbacks_by_courses', 'mod_feedback_external', 'get_feedbacks_by_courses', NULL, 'mod_feedback', 'mod/feedback:view', 'moodle_mobile_app'),
(359, 'mod_feedback_get_feedback_access_information', 'mod_feedback_external', 'get_feedback_access_information', NULL, 'mod_feedback', 'mod/feedback:view', 'moodle_mobile_app'),
(360, 'mod_feedback_view_feedback', 'mod_feedback_external', 'view_feedback', NULL, 'mod_feedback', 'mod/feedback:view', 'moodle_mobile_app'),
(361, 'mod_feedback_get_current_completed_tmp', 'mod_feedback_external', 'get_current_completed_tmp', NULL, 'mod_feedback', 'mod/feedback:view', 'moodle_mobile_app'),
(362, 'mod_feedback_get_items', 'mod_feedback_external', 'get_items', NULL, 'mod_feedback', 'mod/feedback:view', 'moodle_mobile_app'),
(363, 'mod_feedback_launch_feedback', 'mod_feedback_external', 'launch_feedback', NULL, 'mod_feedback', 'mod/feedback:complete', 'moodle_mobile_app'),
(364, 'mod_feedback_get_page_items', 'mod_feedback_external', 'get_page_items', NULL, 'mod_feedback', 'mod/feedback:complete', 'moodle_mobile_app'),
(365, 'mod_feedback_process_page', 'mod_feedback_external', 'process_page', NULL, 'mod_feedback', 'mod/feedback:complete', 'moodle_mobile_app'),
(366, 'mod_feedback_get_analysis', 'mod_feedback_external', 'get_analysis', NULL, 'mod_feedback', 'mod/feedback:viewanalysepage', 'moodle_mobile_app'),
(367, 'mod_feedback_get_unfinished_responses', 'mod_feedback_external', 'get_unfinished_responses', NULL, 'mod_feedback', 'mod/feedback:view', 'moodle_mobile_app'),
(368, 'mod_feedback_get_finished_responses', 'mod_feedback_external', 'get_finished_responses', NULL, 'mod_feedback', 'mod/feedback:view', 'moodle_mobile_app'),
(369, 'mod_feedback_get_non_respondents', 'mod_feedback_external', 'get_non_respondents', NULL, 'mod_feedback', 'mod/feedback:viewreports', 'moodle_mobile_app'),
(370, 'mod_feedback_get_responses_analysis', 'mod_feedback_external', 'get_responses_analysis', NULL, 'mod_feedback', 'mod/feedback:viewreports', 'moodle_mobile_app'),
(371, 'mod_feedback_get_last_completed', 'mod_feedback_external', 'get_last_completed', NULL, 'mod_feedback', 'mod/feedback:view', 'moodle_mobile_app'),
(372, 'mod_folder_view_folder', 'mod_folder_external', 'view_folder', NULL, 'mod_folder', 'mod/folder:view', 'moodle_mobile_app'),
(373, 'mod_folder_get_folders_by_courses', 'mod_folder_external', 'get_folders_by_courses', NULL, 'mod_folder', 'mod/folder:view', 'moodle_mobile_app'),
(374, 'mod_forum_get_forums_by_courses', 'mod_forum_external', 'get_forums_by_courses', 'mod/forum/externallib.php', 'mod_forum', 'mod/forum:viewdiscussion', 'moodle_mobile_app'),
(375, 'mod_forum_get_discussion_posts', 'mod_forum_external', 'get_discussion_posts', 'mod/forum/externallib.php', 'mod_forum', 'mod/forum:viewdiscussion, mod/forum:viewqandawithoutposting', 'moodle_mobile_app'),
(376, 'mod_forum_get_forum_discussion_posts', 'mod_forum_external', 'get_forum_discussion_posts', 'mod/forum/externallib.php', 'mod_forum', 'mod/forum:viewdiscussion, mod/forum:viewqandawithoutposting', 'moodle_mobile_app'),
(377, 'mod_forum_get_forum_discussions_paginated', 'mod_forum_external', 'get_forum_discussions_paginated', 'mod/forum/externallib.php', 'mod_forum', 'mod/forum:viewdiscussion, mod/forum:viewqandawithoutposting', 'moodle_mobile_app'),
(378, 'mod_forum_get_forum_discussions', 'mod_forum_external', 'get_forum_discussions', 'mod/forum/externallib.php', 'mod_forum', 'mod/forum:viewdiscussion, mod/forum:viewqandawithoutposting', 'moodle_mobile_app'),
(379, 'mod_forum_view_forum', 'mod_forum_external', 'view_forum', 'mod/forum/externallib.php', 'mod_forum', 'mod/forum:viewdiscussion', 'moodle_mobile_app'),
(380, 'mod_forum_view_forum_discussion', 'mod_forum_external', 'view_forum_discussion', 'mod/forum/externallib.php', 'mod_forum', 'mod/forum:viewdiscussion', 'moodle_mobile_app'),
(381, 'mod_forum_add_discussion_post', 'mod_forum_external', 'add_discussion_post', 'mod/forum/externallib.php', 'mod_forum', 'mod/forum:replypost', 'moodle_mobile_app'),
(382, 'mod_forum_add_discussion', 'mod_forum_external', 'add_discussion', 'mod/forum/externallib.php', 'mod_forum', 'mod/forum:startdiscussion', 'moodle_mobile_app'),
(383, 'mod_forum_can_add_discussion', 'mod_forum_external', 'can_add_discussion', 'mod/forum/externallib.php', 'mod_forum', '', 'moodle_mobile_app'),
(384, 'mod_forum_get_forum_access_information', 'mod_forum_external', 'get_forum_access_information', NULL, 'mod_forum', '', 'moodle_mobile_app'),
(385, 'mod_forum_set_subscription_state', 'mod_forum_external', 'set_subscription_state', 'mod/forum/externallib.php', 'mod_forum', '', 'moodle_mobile_app'),
(386, 'mod_forum_set_lock_state', 'mod_forum_external', 'set_lock_state', 'mod/forum/externallib.php', 'mod_forum', 'moodle/course:manageactivities', 'moodle_mobile_app'),
(387, 'mod_forum_toggle_favourite_state', 'mod_forum_external', 'toggle_favourite_state', 'mod/forum/externallib.php', 'mod_forum', '', 'moodle_mobile_app'),
(388, 'mod_forum_set_pin_state', 'mod_forum_external', 'set_pin_state', 'mod/forum/externallib.php', 'mod_forum', '', 'moodle_mobile_app'),
(389, 'mod_forum_delete_post', 'mod_forum_external', 'delete_post', 'mod/forum/externallib.php', 'mod_forum', '', 'moodle_mobile_app'),
(390, 'mod_forum_get_discussion_posts_by_userid', 'mod_forum_external', 'get_discussion_posts_by_userid', 'mod/forum/externallib.php', 'mod_forum', 'mod/forum:viewdiscussion, mod/forum:viewqandawithoutposting', NULL),
(391, 'mod_forum_get_discussion_post', 'mod_forum_external', 'get_discussion_post', 'mod/forum/externallib.php', 'mod_forum', '', 'moodle_mobile_app'),
(392, 'mod_forum_prepare_draft_area_for_post', 'mod_forum_external', 'prepare_draft_area_for_post', 'mod/forum/externallib.php', 'mod_forum', '', 'moodle_mobile_app'),
(393, 'mod_forum_update_discussion_post', 'mod_forum_external', 'update_discussion_post', 'mod/forum/externallib.php', 'mod_forum', '', 'moodle_mobile_app'),
(394, 'mod_glossary_get_glossaries_by_courses', 'mod_glossary_external', 'get_glossaries_by_courses', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(395, 'mod_glossary_view_glossary', 'mod_glossary_external', 'view_glossary', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(396, 'mod_glossary_view_entry', 'mod_glossary_external', 'view_entry', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(397, 'mod_glossary_get_entries_by_letter', 'mod_glossary_external', 'get_entries_by_letter', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(398, 'mod_glossary_get_entries_by_date', 'mod_glossary_external', 'get_entries_by_date', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(399, 'mod_glossary_get_categories', 'mod_glossary_external', 'get_categories', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(400, 'mod_glossary_get_entries_by_category', 'mod_glossary_external', 'get_entries_by_category', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(401, 'mod_glossary_get_authors', 'mod_glossary_external', 'get_authors', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(402, 'mod_glossary_get_entries_by_author', 'mod_glossary_external', 'get_entries_by_author', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(403, 'mod_glossary_get_entries_by_author_id', 'mod_glossary_external', 'get_entries_by_author_id', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(404, 'mod_glossary_get_entries_by_search', 'mod_glossary_external', 'get_entries_by_search', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(405, 'mod_glossary_get_entries_by_term', 'mod_glossary_external', 'get_entries_by_term', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(406, 'mod_glossary_get_entries_to_approve', 'mod_glossary_external', 'get_entries_to_approve', NULL, 'mod_glossary', 'mod/glossary:approve', 'moodle_mobile_app'),
(407, 'mod_glossary_get_entry_by_id', 'mod_glossary_external', 'get_entry_by_id', NULL, 'mod_glossary', 'mod/glossary:view', 'moodle_mobile_app'),
(408, 'mod_glossary_add_entry', 'mod_glossary_external', 'add_entry', NULL, 'mod_glossary', 'mod/glossary:write', 'moodle_mobile_app'),
(409, 'mod_imscp_view_imscp', 'mod_imscp_external', 'view_imscp', NULL, 'mod_imscp', 'mod/imscp:view', 'moodle_mobile_app'),
(410, 'mod_imscp_get_imscps_by_courses', 'mod_imscp_external', 'get_imscps_by_courses', NULL, 'mod_imscp', 'mod/imscp:view', 'moodle_mobile_app'),
(411, 'mod_label_get_labels_by_courses', 'mod_label_external', 'get_labels_by_courses', NULL, 'mod_label', 'mod/label:view', 'moodle_mobile_app'),
(412, 'mod_lesson_get_lessons_by_courses', 'mod_lesson_external', 'get_lessons_by_courses', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(413, 'mod_lesson_get_lesson_access_information', 'mod_lesson_external', 'get_lesson_access_information', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(414, 'mod_lesson_view_lesson', 'mod_lesson_external', 'view_lesson', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(415, 'mod_lesson_get_questions_attempts', 'mod_lesson_external', 'get_questions_attempts', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(416, 'mod_lesson_get_user_grade', 'mod_lesson_external', 'get_user_grade', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(417, 'mod_lesson_get_user_attempt_grade', 'mod_lesson_external', 'get_user_attempt_grade', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(418, 'mod_lesson_get_content_pages_viewed', 'mod_lesson_external', 'get_content_pages_viewed', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(419, 'mod_lesson_get_user_timers', 'mod_lesson_external', 'get_user_timers', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(420, 'mod_lesson_get_pages', 'mod_lesson_external', 'get_pages', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(421, 'mod_lesson_launch_attempt', 'mod_lesson_external', 'launch_attempt', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(422, 'mod_lesson_get_page_data', 'mod_lesson_external', 'get_page_data', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(423, 'mod_lesson_process_page', 'mod_lesson_external', 'process_page', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(424, 'mod_lesson_finish_attempt', 'mod_lesson_external', 'finish_attempt', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(425, 'mod_lesson_get_attempts_overview', 'mod_lesson_external', 'get_attempts_overview', NULL, 'mod_lesson', 'mod/lesson:viewreports', 'moodle_mobile_app'),
(426, 'mod_lesson_get_user_attempt', 'mod_lesson_external', 'get_user_attempt', NULL, 'mod_lesson', 'mod/lesson:viewreports', 'moodle_mobile_app'),
(427, 'mod_lesson_get_pages_possible_jumps', 'mod_lesson_external', 'get_pages_possible_jumps', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(428, 'mod_lesson_get_lesson', 'mod_lesson_external', 'get_lesson', NULL, 'mod_lesson', 'mod/lesson:view', 'moodle_mobile_app'),
(429, 'mod_lti_get_tool_launch_data', 'mod_lti_external', 'get_tool_launch_data', NULL, 'mod_lti', 'mod/lti:view', 'moodle_mobile_app'),
(430, 'mod_lti_get_ltis_by_courses', 'mod_lti_external', 'get_ltis_by_courses', NULL, 'mod_lti', 'mod/lti:view', 'moodle_mobile_app'),
(431, 'mod_lti_view_lti', 'mod_lti_external', 'view_lti', NULL, 'mod_lti', 'mod/lti:view', 'moodle_mobile_app'),
(432, 'mod_lti_get_tool_proxies', 'mod_lti_external', 'get_tool_proxies', NULL, 'mod_lti', 'moodle/site:config', NULL),
(433, 'mod_lti_create_tool_proxy', 'mod_lti_external', 'create_tool_proxy', NULL, 'mod_lti', 'moodle/site:config', NULL),
(434, 'mod_lti_delete_tool_proxy', 'mod_lti_external', 'delete_tool_proxy', NULL, 'mod_lti', 'moodle/site:config', NULL),
(435, 'mod_lti_get_tool_proxy_registration_request', 'mod_lti_external', 'get_tool_proxy_registration_request', NULL, 'mod_lti', 'moodle/site:config', NULL),
(436, 'mod_lti_get_tool_types', 'mod_lti_external', 'get_tool_types', NULL, 'mod_lti', 'moodle/site:config', NULL),
(437, 'mod_lti_create_tool_type', 'mod_lti_external', 'create_tool_type', NULL, 'mod_lti', 'moodle/site:config', NULL),
(438, 'mod_lti_update_tool_type', 'mod_lti_external', 'update_tool_type', NULL, 'mod_lti', 'moodle/site:config', NULL),
(439, 'mod_lti_delete_tool_type', 'mod_lti_external', 'delete_tool_type', NULL, 'mod_lti', 'moodle/site:config', NULL),
(440, 'mod_lti_is_cartridge', 'mod_lti_external', 'is_cartridge', NULL, 'mod_lti', 'moodle/site:config', NULL),
(441, 'mod_page_view_page', 'mod_page_external', 'view_page', NULL, 'mod_page', 'mod/page:view', 'moodle_mobile_app'),
(442, 'mod_page_get_pages_by_courses', 'mod_page_external', 'get_pages_by_courses', NULL, 'mod_page', 'mod/page:view', 'moodle_mobile_app'),
(443, 'mod_quiz_get_quizzes_by_courses', 'mod_quiz_external', 'get_quizzes_by_courses', NULL, 'mod_quiz', 'mod/quiz:view', 'moodle_mobile_app'),
(444, 'mod_quiz_view_quiz', 'mod_quiz_external', 'view_quiz', NULL, 'mod_quiz', 'mod/quiz:view', 'moodle_mobile_app'),
(445, 'mod_quiz_get_user_attempts', 'mod_quiz_external', 'get_user_attempts', NULL, 'mod_quiz', 'mod/quiz:view', 'moodle_mobile_app'),
(446, 'mod_quiz_get_user_best_grade', 'mod_quiz_external', 'get_user_best_grade', NULL, 'mod_quiz', 'mod/quiz:view', 'moodle_mobile_app'),
(447, 'mod_quiz_get_combined_review_options', 'mod_quiz_external', 'get_combined_review_options', NULL, 'mod_quiz', 'mod/quiz:view', 'moodle_mobile_app'),
(448, 'mod_quiz_start_attempt', 'mod_quiz_external', 'start_attempt', NULL, 'mod_quiz', 'mod/quiz:attempt', 'moodle_mobile_app'),
(449, 'mod_quiz_get_attempt_data', 'mod_quiz_external', 'get_attempt_data', NULL, 'mod_quiz', 'mod/quiz:attempt', 'moodle_mobile_app'),
(450, 'mod_quiz_get_attempt_summary', 'mod_quiz_external', 'get_attempt_summary', NULL, 'mod_quiz', 'mod/quiz:attempt', 'moodle_mobile_app'),
(451, 'mod_quiz_save_attempt', 'mod_quiz_external', 'save_attempt', NULL, 'mod_quiz', 'mod/quiz:attempt', 'moodle_mobile_app'),
(452, 'mod_quiz_process_attempt', 'mod_quiz_external', 'process_attempt', NULL, 'mod_quiz', 'mod/quiz:attempt', 'moodle_mobile_app'),
(453, 'mod_quiz_get_attempt_review', 'mod_quiz_external', 'get_attempt_review', NULL, 'mod_quiz', 'mod/quiz:reviewmyattempts', 'moodle_mobile_app'),
(454, 'mod_quiz_view_attempt', 'mod_quiz_external', 'view_attempt', NULL, 'mod_quiz', 'mod/quiz:attempt', 'moodle_mobile_app'),
(455, 'mod_quiz_view_attempt_summary', 'mod_quiz_external', 'view_attempt_summary', NULL, 'mod_quiz', 'mod/quiz:attempt', 'moodle_mobile_app'),
(456, 'mod_quiz_view_attempt_review', 'mod_quiz_external', 'view_attempt_review', NULL, 'mod_quiz', 'mod/quiz:reviewmyattempts', 'moodle_mobile_app'),
(457, 'mod_quiz_get_quiz_feedback_for_grade', 'mod_quiz_external', 'get_quiz_feedback_for_grade', NULL, 'mod_quiz', 'mod/quiz:view', 'moodle_mobile_app'),
(458, 'mod_quiz_get_quiz_access_information', 'mod_quiz_external', 'get_quiz_access_information', NULL, 'mod_quiz', 'mod/quiz:view', 'moodle_mobile_app'),
(459, 'mod_quiz_get_attempt_access_information', 'mod_quiz_external', 'get_attempt_access_information', NULL, 'mod_quiz', 'mod/quiz:view', 'moodle_mobile_app'),
(460, 'mod_quiz_get_quiz_required_qtypes', 'mod_quiz_external', 'get_quiz_required_qtypes', NULL, 'mod_quiz', 'mod/quiz:view', 'moodle_mobile_app'),
(461, 'mod_resource_view_resource', 'mod_resource_external', 'view_resource', NULL, 'mod_resource', 'mod/resource:view', 'moodle_mobile_app'),
(462, 'mod_resource_get_resources_by_courses', 'mod_resource_external', 'get_resources_by_courses', NULL, 'mod_resource', 'mod/resource:view', 'moodle_mobile_app'),
(463, 'mod_scorm_view_scorm', 'mod_scorm_external', 'view_scorm', NULL, 'mod_scorm', '', 'moodle_mobile_app'),
(464, 'mod_scorm_get_scorm_attempt_count', 'mod_scorm_external', 'get_scorm_attempt_count', NULL, 'mod_scorm', '', 'moodle_mobile_app'),
(465, 'mod_scorm_get_scorm_scoes', 'mod_scorm_external', 'get_scorm_scoes', NULL, 'mod_scorm', '', 'moodle_mobile_app'),
(466, 'mod_scorm_get_scorm_user_data', 'mod_scorm_external', 'get_scorm_user_data', NULL, 'mod_scorm', '', 'moodle_mobile_app'),
(467, 'mod_scorm_insert_scorm_tracks', 'mod_scorm_external', 'insert_scorm_tracks', NULL, 'mod_scorm', 'mod/scorm:savetrack', 'moodle_mobile_app'),
(468, 'mod_scorm_get_scorm_sco_tracks', 'mod_scorm_external', 'get_scorm_sco_tracks', NULL, 'mod_scorm', '', 'moodle_mobile_app'),
(469, 'mod_scorm_get_scorms_by_courses', 'mod_scorm_external', 'get_scorms_by_courses', NULL, 'mod_scorm', '', 'moodle_mobile_app'),
(470, 'mod_scorm_launch_sco', 'mod_scorm_external', 'launch_sco', NULL, 'mod_scorm', '', 'moodle_mobile_app'),
(471, 'mod_scorm_get_scorm_access_information', 'mod_scorm_external', 'get_scorm_access_information', NULL, 'mod_scorm', '', 'moodle_mobile_app'),
(472, 'mod_survey_get_surveys_by_courses', 'mod_survey_external', 'get_surveys_by_courses', NULL, 'mod_survey', '', 'moodle_mobile_app'),
(473, 'mod_survey_view_survey', 'mod_survey_external', 'view_survey', NULL, 'mod_survey', 'mod/survey:participate', 'moodle_mobile_app'),
(474, 'mod_survey_get_questions', 'mod_survey_external', 'get_questions', NULL, 'mod_survey', 'mod/survey:participate', 'moodle_mobile_app'),
(475, 'mod_survey_submit_answers', 'mod_survey_external', 'submit_answers', NULL, 'mod_survey', 'mod/survey:participate', 'moodle_mobile_app'),
(476, 'mod_url_view_url', 'mod_url_external', 'view_url', NULL, 'mod_url', 'mod/url:view', 'moodle_mobile_app'),
(477, 'mod_url_get_urls_by_courses', 'mod_url_external', 'get_urls_by_courses', NULL, 'mod_url', 'mod/url:view', 'moodle_mobile_app'),
(478, 'mod_wiki_get_wikis_by_courses', 'mod_wiki_external', 'get_wikis_by_courses', NULL, 'mod_wiki', 'mod/wiki:viewpage', 'moodle_mobile_app'),
(479, 'mod_wiki_view_wiki', 'mod_wiki_external', 'view_wiki', NULL, 'mod_wiki', 'mod/wiki:viewpage', 'moodle_mobile_app'),
(480, 'mod_wiki_view_page', 'mod_wiki_external', 'view_page', NULL, 'mod_wiki', 'mod/wiki:viewpage', 'moodle_mobile_app'),
(481, 'mod_wiki_get_subwikis', 'mod_wiki_external', 'get_subwikis', NULL, 'mod_wiki', 'mod/wiki:viewpage', 'moodle_mobile_app'),
(482, 'mod_wiki_get_subwiki_pages', 'mod_wiki_external', 'get_subwiki_pages', NULL, 'mod_wiki', 'mod/wiki:viewpage', 'moodle_mobile_app'),
(483, 'mod_wiki_get_subwiki_files', 'mod_wiki_external', 'get_subwiki_files', NULL, 'mod_wiki', 'mod/wiki:viewpage', 'moodle_mobile_app'),
(484, 'mod_wiki_get_page_contents', 'mod_wiki_external', 'get_page_contents', NULL, 'mod_wiki', 'mod/wiki:viewpage', 'moodle_mobile_app'),
(485, 'mod_wiki_get_page_for_editing', 'mod_wiki_external', 'get_page_for_editing', NULL, 'mod_wiki', 'mod/wiki:editpage', 'moodle_mobile_app'),
(486, 'mod_wiki_new_page', 'mod_wiki_external', 'new_page', NULL, 'mod_wiki', 'mod/wiki:editpage', 'moodle_mobile_app'),
(487, 'mod_wiki_edit_page', 'mod_wiki_external', 'edit_page', NULL, 'mod_wiki', 'mod/wiki:editpage', 'moodle_mobile_app'),
(488, 'mod_workshop_get_workshops_by_courses', 'mod_workshop_external', 'get_workshops_by_courses', NULL, 'mod_workshop', 'mod/workshop:view', 'moodle_mobile_app'),
(489, 'mod_workshop_get_workshop_access_information', 'mod_workshop_external', 'get_workshop_access_information', NULL, 'mod_workshop', 'mod/workshop:view', 'moodle_mobile_app'),
(490, 'mod_workshop_get_user_plan', 'mod_workshop_external', 'get_user_plan', NULL, 'mod_workshop', 'mod/workshop:view', 'moodle_mobile_app'),
(491, 'mod_workshop_view_workshop', 'mod_workshop_external', 'view_workshop', NULL, 'mod_workshop', 'mod/workshop:view', 'moodle_mobile_app'),
(492, 'mod_workshop_add_submission', 'mod_workshop_external', 'add_submission', NULL, 'mod_workshop', 'mod/workshop:submit', 'moodle_mobile_app'),
(493, 'mod_workshop_update_submission', 'mod_workshop_external', 'update_submission', NULL, 'mod_workshop', 'mod/workshop:submit', 'moodle_mobile_app'),
(494, 'mod_workshop_delete_submission', 'mod_workshop_external', 'delete_submission', NULL, 'mod_workshop', 'mod/workshop:submit', 'moodle_mobile_app'),
(495, 'mod_workshop_get_submissions', 'mod_workshop_external', 'get_submissions', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(496, 'mod_workshop_get_submission', 'mod_workshop_external', 'get_submission', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(497, 'mod_workshop_get_submission_assessments', 'mod_workshop_external', 'get_submission_assessments', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(498, 'mod_workshop_get_assessment', 'mod_workshop_external', 'get_assessment', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(499, 'mod_workshop_get_assessment_form_definition', 'mod_workshop_external', 'get_assessment_form_definition', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(500, 'mod_workshop_get_reviewer_assessments', 'mod_workshop_external', 'get_reviewer_assessments', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(501, 'mod_workshop_update_assessment', 'mod_workshop_external', 'update_assessment', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(502, 'mod_workshop_get_grades', 'mod_workshop_external', 'get_grades', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(503, 'mod_workshop_evaluate_assessment', 'mod_workshop_external', 'evaluate_assessment', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(504, 'mod_workshop_get_grades_report', 'mod_workshop_external', 'get_grades_report', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(505, 'mod_workshop_view_submission', 'mod_workshop_external', 'view_submission', NULL, 'mod_workshop', 'mod/workshop:view', 'moodle_mobile_app'),
(506, 'mod_workshop_evaluate_submission', 'mod_workshop_external', 'evaluate_submission', NULL, 'mod_workshop', '', 'moodle_mobile_app'),
(507, 'auth_email_get_signup_settings', 'auth_email_external', 'get_signup_settings', NULL, 'auth_email', '', NULL),
(508, 'auth_email_signup_user', 'auth_email_external', 'signup_user', NULL, 'auth_email', '', NULL),
(509, 'enrol_guest_get_instance_info', 'enrol_guest_external', 'get_instance_info', NULL, 'enrol_guest', '', 'moodle_mobile_app'),
(510, 'enrol_manual_enrol_users', 'enrol_manual_external', 'enrol_users', 'enrol/manual/externallib.php', 'enrol_manual', 'enrol/manual:enrol', NULL),
(511, 'enrol_manual_unenrol_users', 'enrol_manual_external', 'unenrol_users', 'enrol/manual/externallib.php', 'enrol_manual', 'enrol/manual:unenrol', NULL),
(512, 'enrol_self_get_instance_info', 'enrol_self_external', 'get_instance_info', 'enrol/self/externallib.php', 'enrol_self', '', 'moodle_mobile_app'),
(513, 'enrol_self_enrol_user', 'enrol_self_external', 'enrol_user', 'enrol/self/externallib.php', 'enrol_self', '', 'moodle_mobile_app'),
(514, 'message_airnotifier_is_system_configured', 'message_airnotifier_external', 'is_system_configured', 'message/output/airnotifier/externallib.php', 'message_airnotifier', '', 'moodle_mobile_app'),
(515, 'message_airnotifier_are_notification_preferences_configured', 'message_airnotifier_external', 'are_notification_preferences_configured', 'message/output/airnotifier/externallib.php', 'message_airnotifier', '', 'moodle_mobile_app'),
(516, 'message_airnotifier_get_user_devices', 'message_airnotifier_external', 'get_user_devices', 'message/output/airnotifier/externallib.php', 'message_airnotifier', '', 'moodle_mobile_app'),
(517, 'message_airnotifier_enable_device', 'message_airnotifier_external', 'enable_device', 'message/output/airnotifier/externallib.php', 'message_airnotifier', 'message/airnotifier:managedevice', 'moodle_mobile_app'),
(518, 'message_popup_get_popup_notifications', 'message_popup_external', 'get_popup_notifications', 'message/output/popup/externallib.php', 'message_popup', '', 'moodle_mobile_app'),
(519, 'message_popup_get_unread_popup_notification_count', 'message_popup_external', 'get_unread_popup_notification_count', 'message/output/popup/externallib.php', 'message_popup', '', 'moodle_mobile_app'),
(520, 'block_recentlyaccesseditems_get_recent_items', 'block_recentlyaccesseditems\\external', 'get_recent_items', NULL, 'block_recentlyaccesseditems', '', 'moodle_mobile_app'),
(521, 'block_starredcourses_get_starred_courses', 'block_starredcourses_external', 'get_starred_courses', 'block/starredcourses/classes/external.php', 'block_starredcourses', '', 'moodle_mobile_app'),
(522, 'report_competency_data_for_report', 'report_competency\\external', 'data_for_report', NULL, 'report_competency', 'moodle/competency:coursecompetencyview', NULL),
(523, 'report_insights_set_notuseful_prediction', 'report_insights\\external', 'set_notuseful_prediction', NULL, 'report_insights', '', 'moodle_mobile_app'),
(524, 'report_insights_set_fixed_prediction', 'report_insights\\external', 'set_fixed_prediction', NULL, 'report_insights', '', 'moodle_mobile_app'),
(525, 'report_insights_action_executed', 'report_insights\\external', 'action_executed', NULL, 'report_insights', '', 'moodle_mobile_app'),
(526, 'gradereport_overview_get_course_grades', 'gradereport_overview_external', 'get_course_grades', NULL, 'gradereport_overview', '', 'moodle_mobile_app'),
(527, 'gradereport_overview_view_grade_report', 'gradereport_overview_external', 'view_grade_report', NULL, 'gradereport_overview', 'gradereport/overview:view', 'moodle_mobile_app'),
(528, 'gradereport_user_get_grades_table', 'gradereport_user_external', 'get_grades_table', 'grade/report/user/externallib.php', 'gradereport_user', 'gradereport/user:view', 'moodle_mobile_app'),
(529, 'gradereport_user_view_grade_report', 'gradereport_user_external', 'view_grade_report', 'grade/report/user/externallib.php', 'gradereport_user', 'gradereport/user:view', 'moodle_mobile_app'),
(530, 'gradereport_user_get_grade_items', 'gradereport_user_external', 'get_grade_items', 'grade/report/user/externallib.php', 'gradereport_user', 'gradereport/user:view', 'moodle_mobile_app'),
(531, 'gradingform_guide_grader_gradingpanel_fetch', 'gradingform_guide\\grades\\grader\\gradingpanel\\external\\fetch', 'execute', NULL, 'gradingform_guide', '', NULL),
(532, 'gradingform_guide_grader_gradingpanel_store', 'gradingform_guide\\grades\\grader\\gradingpanel\\external\\store', 'execute', NULL, 'gradingform_guide', '', NULL),
(533, 'gradingform_rubric_grader_gradingpanel_fetch', 'gradingform_rubric\\grades\\grader\\gradingpanel\\external\\fetch', 'execute', NULL, 'gradingform_rubric', '', NULL),
(534, 'gradingform_rubric_grader_gradingpanel_store', 'gradingform_rubric\\grades\\grader\\gradingpanel\\external\\store', 'execute', NULL, 'gradingform_rubric', '', NULL),
(535, 'tool_analytics_potential_contexts', 'tool_analytics\\external', 'potential_contexts', NULL, 'tool_analytics', '', 'moodle_mobile_app'),
(536, 'tool_dataprivacy_cancel_data_request', 'tool_dataprivacy\\external', 'cancel_data_request', NULL, 'tool_dataprivacy', '', NULL),
(537, 'tool_dataprivacy_contact_dpo', 'tool_dataprivacy\\external', 'contact_dpo', NULL, 'tool_dataprivacy', '', NULL),
(538, 'tool_dataprivacy_mark_complete', 'tool_dataprivacy\\external', 'mark_complete', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedatarequests', NULL),
(539, 'tool_dataprivacy_get_data_request', 'tool_dataprivacy\\external', 'get_data_request', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedatarequests', NULL),
(540, 'tool_dataprivacy_approve_data_request', 'tool_dataprivacy\\external', 'approve_data_request', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedatarequests', NULL),
(541, 'tool_dataprivacy_bulk_approve_data_requests', 'tool_dataprivacy\\external', 'bulk_approve_data_requests', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedatarequests', NULL),
(542, 'tool_dataprivacy_deny_data_request', 'tool_dataprivacy\\external', 'deny_data_request', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedatarequests', NULL),
(543, 'tool_dataprivacy_bulk_deny_data_requests', 'tool_dataprivacy\\external', 'bulk_deny_data_requests', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedatarequests', NULL),
(544, 'tool_dataprivacy_get_users', 'tool_dataprivacy\\external', 'get_users', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedatarequests', NULL),
(545, 'tool_dataprivacy_create_purpose_form', 'tool_dataprivacy\\external', 'create_purpose_form', NULL, 'tool_dataprivacy', '', NULL),
(546, 'tool_dataprivacy_create_category_form', 'tool_dataprivacy\\external', 'create_category_form', NULL, 'tool_dataprivacy', '', NULL),
(547, 'tool_dataprivacy_delete_purpose', 'tool_dataprivacy\\external', 'delete_purpose', NULL, 'tool_dataprivacy', '', NULL),
(548, 'tool_dataprivacy_delete_category', 'tool_dataprivacy\\external', 'delete_category', NULL, 'tool_dataprivacy', '', NULL),
(549, 'tool_dataprivacy_set_contextlevel_form', 'tool_dataprivacy\\external', 'set_contextlevel_form', NULL, 'tool_dataprivacy', '', NULL),
(550, 'tool_dataprivacy_set_context_form', 'tool_dataprivacy\\external', 'set_context_form', NULL, 'tool_dataprivacy', '', NULL),
(551, 'tool_dataprivacy_tree_extra_branches', 'tool_dataprivacy\\external', 'tree_extra_branches', NULL, 'tool_dataprivacy', '', NULL),
(552, 'tool_dataprivacy_confirm_contexts_for_deletion', 'tool_dataprivacy\\external', 'confirm_contexts_for_deletion', NULL, 'tool_dataprivacy', '', NULL),
(553, 'tool_dataprivacy_set_context_defaults', 'tool_dataprivacy\\external', 'set_context_defaults', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedataregistry', NULL),
(554, 'tool_dataprivacy_get_category_options', 'tool_dataprivacy\\external', 'get_category_options', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedataregistry', NULL),
(555, 'tool_dataprivacy_get_purpose_options', 'tool_dataprivacy\\external', 'get_purpose_options', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedataregistry', NULL),
(556, 'tool_dataprivacy_get_activity_options', 'tool_dataprivacy\\external', 'get_activity_options', NULL, 'tool_dataprivacy', 'tool/dataprivacy:managedataregistry', NULL),
(557, 'tool_lp_data_for_competency_frameworks_manage_page', 'tool_lp\\external', 'data_for_competency_frameworks_manage_page', NULL, 'tool_lp', 'moodle/competency:competencyview', NULL),
(558, 'tool_lp_data_for_competency_summary', 'tool_lp\\external', 'data_for_competency_summary', NULL, 'tool_lp', 'moodle/competency:competencyview', NULL),
(559, 'tool_lp_data_for_competencies_manage_page', 'tool_lp\\external', 'data_for_competencies_manage_page', NULL, 'tool_lp', 'moodle/competency:competencyview', NULL),
(560, 'tool_lp_list_courses_using_competency', 'tool_lp\\external', 'list_courses_using_competency', NULL, 'tool_lp', 'moodle/competency:coursecompetencyview', NULL),
(561, 'tool_lp_data_for_course_competencies_page', 'tool_lp\\external', 'data_for_course_competencies_page', NULL, 'tool_lp', 'moodle/competency:coursecompetencyview', 'moodle_mobile_app'),
(562, 'tool_lp_data_for_template_competencies_page', 'tool_lp\\external', 'data_for_template_competencies_page', NULL, 'tool_lp', 'moodle/competency:templateview', NULL),
(563, 'tool_lp_data_for_templates_manage_page', 'tool_lp\\external', 'data_for_templates_manage_page', NULL, 'tool_lp', 'moodle/competency:templateview', NULL),
(564, 'tool_lp_data_for_plans_page', 'tool_lp\\external', 'data_for_plans_page', NULL, 'tool_lp', 'moodle/competency:planviewown', 'moodle_mobile_app'),
(565, 'tool_lp_data_for_plan_page', 'tool_lp\\external', 'data_for_plan_page', NULL, 'tool_lp', 'moodle/competency:planview', 'moodle_mobile_app'),
(566, 'tool_lp_data_for_related_competencies_section', 'tool_lp\\external', 'data_for_related_competencies_section', NULL, 'tool_lp', 'moodle/competency:competencyview', NULL),
(567, 'tool_lp_search_users', 'tool_lp\\external', 'search_users', NULL, 'tool_lp', '', NULL),
(568, 'tool_lp_search_cohorts', 'core_cohort_external', 'search_cohorts', 'cohort/externallib.php', 'tool_lp', 'moodle/cohort:view', NULL),
(569, 'tool_lp_data_for_user_evidence_list_page', 'tool_lp\\external', 'data_for_user_evidence_list_page', NULL, 'tool_lp', 'moodle/competency:userevidenceview', 'moodle_mobile_app'),
(570, 'tool_lp_data_for_user_evidence_page', 'tool_lp\\external', 'data_for_user_evidence_page', NULL, 'tool_lp', 'moodle/competency:userevidenceview', 'moodle_mobile_app'),
(571, 'tool_lp_data_for_user_competency_summary', 'tool_lp\\external', 'data_for_user_competency_summary', NULL, 'tool_lp', 'moodle/competency:planview', 'moodle_mobile_app'),
(572, 'tool_lp_data_for_user_competency_summary_in_plan', 'tool_lp\\external', 'data_for_user_competency_summary_in_plan', NULL, 'tool_lp', 'moodle/competency:planview', 'moodle_mobile_app'),
(573, 'tool_lp_data_for_user_competency_summary_in_course', 'tool_lp\\external', 'data_for_user_competency_summary_in_course', NULL, 'tool_lp', 'moodle/competency:coursecompetencyview', 'moodle_mobile_app'),
(574, 'tool_mobile_get_plugins_supporting_mobile', 'tool_mobile\\external', 'get_plugins_supporting_mobile', NULL, 'tool_mobile', '', 'moodle_mobile_app'),
(575, 'tool_mobile_get_public_config', 'tool_mobile\\external', 'get_public_config', NULL, 'tool_mobile', '', 'moodle_mobile_app'),
(576, 'tool_mobile_get_config', 'tool_mobile\\external', 'get_config', NULL, 'tool_mobile', '', 'moodle_mobile_app'),
(577, 'tool_mobile_get_autologin_key', 'tool_mobile\\external', 'get_autologin_key', NULL, 'tool_mobile', '', 'moodle_mobile_app'),
(578, 'tool_mobile_get_content', 'tool_mobile\\external', 'get_content', NULL, 'tool_mobile', '', 'moodle_mobile_app'),
(579, 'tool_mobile_call_external_functions', 'tool_mobile\\external', 'call_external_functions', NULL, 'tool_mobile', '', 'moodle_mobile_app'),
(580, 'tool_policy_get_policy_version', 'tool_policy\\external', 'get_policy_version', NULL, 'tool_policy', '', NULL),
(581, 'tool_policy_submit_accept_on_behalf', 'tool_policy\\external', 'submit_accept_on_behalf', NULL, 'tool_policy', '', NULL),
(582, 'tool_templatelibrary_list_templates', 'tool_templatelibrary\\external', 'list_templates', NULL, 'tool_templatelibrary', '', NULL),
(583, 'tool_templatelibrary_load_canonical_template', 'tool_templatelibrary\\external', 'load_canonical_template', NULL, 'tool_templatelibrary', '', NULL),
(584, 'tool_usertours_fetch_and_start_tour', 'tool_usertours\\external\\tour', 'fetch_and_start_tour', NULL, 'tool_usertours', '', NULL),
(585, 'tool_usertours_step_shown', 'tool_usertours\\external\\tour', 'step_shown', NULL, 'tool_usertours', '', NULL),
(586, 'tool_usertours_complete_tour', 'tool_usertours\\external\\tour', 'complete_tour', NULL, 'tool_usertours', '', NULL),
(587, 'tool_usertours_reset_tour', 'tool_usertours\\external\\tour', 'reset_tour', NULL, 'tool_usertours', '', NULL),
(588, 'tool_xmldb_invoke_move_action', 'tool_xmldb_external', 'invoke_move_action', NULL, 'tool_xmldb', '', NULL),
(592, 'mod_treasurehunt_fetch_treasurehunt', 'mod_treasurehunt_external', 'fetch_treasurehunt', 'mod/treasurehunt/externallib.php', 'mod_treasurehunt', 'mod/treasurehunt:managetreasurehunt', NULL),
(593, 'mod_treasurehunt_update_stages', 'mod_treasurehunt_external', 'update_stages', 'mod/treasurehunt/externallib.php', 'mod_treasurehunt', 'mod/treasurehunt:managetreasurehunt, mod/treasurehunt:editstage', NULL),
(594, 'mod_treasurehunt_delete_stage', 'mod_treasurehunt_external', 'delete_stage', 'mod/treasurehunt/externallib.php', 'mod_treasurehunt', 'mod/treasurehunt:managetreasurehunt, mod/treasurehunt:editstage', NULL),
(595, 'mod_treasurehunt_delete_road', 'mod_treasurehunt_external', 'delete_road', 'mod/treasurehunt/externallib.php', 'mod_treasurehunt', 'mod/treasurehunt:managetreasurehunt, mod/treasurehunt:editroad', NULL),
(596, 'mod_treasurehunt_renew_lock', 'mod_treasurehunt_external', 'renew_lock', 'mod/treasurehunt/externallib.php', 'mod_treasurehunt', 'mod/treasurehunt:managetreasurehunt', NULL),
(597, 'mod_treasurehunt_user_progress', 'mod_treasurehunt_external', 'user_progress', 'mod/treasurehunt/externallib.php', 'mod_treasurehunt', 'mod/treasurehunt:play', NULL),
(598, 'mod_attendance_add_attendance', 'mod_attendance_external', 'add_attendance', 'mod/attendance/externallib.php', 'mod_attendance', '', NULL),
(599, 'mod_attendance_remove_attendance', 'mod_attendance_external', 'remove_attendance', 'mod/attendance/externallib.php', 'mod_attendance', '', NULL),
(600, 'mod_attendance_add_session', 'mod_attendance_external', 'add_session', 'mod/attendance/externallib.php', 'mod_attendance', '', NULL),
(601, 'mod_attendance_remove_session', 'mod_attendance_external', 'remove_session', 'mod/attendance/externallib.php', 'mod_attendance', '', NULL),
(602, 'mod_attendance_get_courses_with_today_sessions', 'mod_attendance_external', 'get_courses_with_today_sessions', 'mod/attendance/externallib.php', 'mod_attendance', '', NULL),
(603, 'mod_attendance_get_session', 'mod_attendance_external', 'get_session', 'mod/attendance/externallib.php', 'mod_attendance', '', NULL),
(604, 'mod_attendance_update_user_status', 'mod_attendance_external', 'update_user_status', 'mod/attendance/externallib.php', 'mod_attendance', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_external_services`
--

CREATE TABLE `mdl_external_services` (
  `id` bigint(10) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL,
  `requiredcapability` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restrictedusers` tinyint(1) NOT NULL,
  `component` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `shortname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `downloadfiles` tinyint(1) NOT NULL DEFAULT '0',
  `uploadfiles` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='built in and custom external services' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_external_services`
--

INSERT INTO `mdl_external_services` (`id`, `name`, `enabled`, `requiredcapability`, `restrictedusers`, `component`, `timecreated`, `timemodified`, `shortname`, `downloadfiles`, `uploadfiles`) VALUES
(1, 'Moodle mobile web service', 1, NULL, 0, 'moodle', 1583151913, 1583152960, 'moodle_mobile_app', 1, 1),
(2, 'Attendance', 1, NULL, 0, 'mod_attendance', 1583153486, NULL, 'mod_attendance', 0, 0),
(3, 'treasurehuntservices', 1, NULL, 0, 'mod_treasurehunt', 1584080053, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_external_services_functions`
--

CREATE TABLE `mdl_external_services_functions` (
  `id` bigint(10) NOT NULL,
  `externalserviceid` bigint(10) NOT NULL,
  `functionname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='lists functions available in each service group' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_external_services_functions`
--

INSERT INTO `mdl_external_services_functions` (`id`, `externalserviceid`, `functionname`) VALUES
(1, 1, 'core_badges_get_user_badges'),
(2, 1, 'core_blog_get_entries'),
(3, 1, 'core_blog_view_entries'),
(4, 1, 'core_calendar_get_calendar_monthly_view'),
(5, 1, 'core_calendar_get_calendar_day_view'),
(6, 1, 'core_calendar_get_calendar_upcoming_view'),
(7, 1, 'core_calendar_update_event_start_day'),
(8, 1, 'core_calendar_create_calendar_events'),
(9, 1, 'core_calendar_delete_calendar_events'),
(10, 1, 'core_calendar_get_calendar_events'),
(11, 1, 'core_calendar_get_action_events_by_timesort'),
(12, 1, 'core_calendar_get_action_events_by_course'),
(13, 1, 'core_calendar_get_action_events_by_courses'),
(14, 1, 'core_calendar_get_calendar_event_by_id'),
(15, 1, 'core_calendar_submit_create_update_form'),
(16, 1, 'core_calendar_get_calendar_access_information'),
(17, 1, 'core_calendar_get_allowed_event_types'),
(18, 1, 'core_comment_get_comments'),
(19, 1, 'core_comment_add_comments'),
(20, 1, 'core_comment_delete_comments'),
(21, 1, 'core_completion_get_activities_completion_status'),
(22, 1, 'core_completion_get_course_completion_status'),
(23, 1, 'core_completion_mark_course_self_completed'),
(24, 1, 'core_completion_update_activity_completion_status_manually'),
(25, 1, 'core_course_get_categories'),
(26, 1, 'core_course_get_contents'),
(27, 1, 'core_course_get_course_module'),
(28, 1, 'core_course_get_course_module_by_instance'),
(29, 1, 'core_course_get_courses'),
(30, 1, 'core_course_search_courses'),
(31, 1, 'core_course_view_course'),
(32, 1, 'core_course_get_user_navigation_options'),
(33, 1, 'core_course_get_user_administration_options'),
(34, 1, 'core_course_get_courses_by_field'),
(35, 1, 'core_course_check_updates'),
(36, 1, 'core_course_get_updates_since'),
(37, 1, 'core_course_get_enrolled_courses_by_timeline_classification'),
(38, 1, 'core_course_get_recent_courses'),
(39, 1, 'core_course_set_favourite_courses'),
(40, 1, 'core_enrol_get_course_enrolment_methods'),
(41, 1, 'core_enrol_get_enrolled_users'),
(42, 1, 'core_enrol_search_users'),
(43, 1, 'core_enrol_get_users_courses'),
(44, 1, 'core_files_get_files'),
(45, 1, 'core_get_component_strings'),
(46, 1, 'core_grades_grader_gradingpanel_point_fetch'),
(47, 1, 'core_grades_grader_gradingpanel_point_store'),
(48, 1, 'core_grades_grader_gradingpanel_scale_fetch'),
(49, 1, 'core_grades_grader_gradingpanel_scale_store'),
(50, 1, 'core_group_get_activity_allowed_groups'),
(51, 1, 'core_group_get_activity_groupmode'),
(52, 1, 'core_group_get_course_groupings'),
(53, 1, 'core_group_get_course_groups'),
(54, 1, 'core_group_get_course_user_groups'),
(55, 1, 'core_message_mute_conversations'),
(56, 1, 'core_message_unmute_conversations'),
(57, 1, 'core_message_block_user'),
(58, 1, 'core_message_block_contacts'),
(59, 1, 'core_message_create_contacts'),
(60, 1, 'core_message_get_contact_requests'),
(61, 1, 'core_message_create_contact_request'),
(62, 1, 'core_message_confirm_contact_request'),
(63, 1, 'core_message_decline_contact_request'),
(64, 1, 'core_message_get_received_contact_requests_count'),
(65, 1, 'core_message_delete_contacts'),
(66, 1, 'core_message_delete_conversation'),
(67, 1, 'core_message_delete_conversations_by_id'),
(68, 1, 'core_message_delete_message'),
(69, 1, 'core_message_get_blocked_users'),
(70, 1, 'core_message_data_for_messagearea_search_messages'),
(71, 1, 'core_message_message_search_users'),
(72, 1, 'core_message_data_for_messagearea_conversations'),
(73, 1, 'core_message_data_for_messagearea_contacts'),
(74, 1, 'core_message_data_for_messagearea_messages'),
(75, 1, 'core_message_get_contacts'),
(76, 1, 'core_message_get_user_contacts'),
(77, 1, 'core_message_get_conversations'),
(78, 1, 'core_message_get_conversation'),
(79, 1, 'core_message_get_conversation_between_users'),
(80, 1, 'core_message_get_self_conversation'),
(81, 1, 'core_message_get_messages'),
(82, 1, 'core_message_get_conversation_counts'),
(83, 1, 'core_message_get_unread_conversation_counts'),
(84, 1, 'core_message_get_conversation_members'),
(85, 1, 'core_message_get_member_info'),
(86, 1, 'core_message_get_unread_conversations_count'),
(87, 1, 'core_message_mark_all_notifications_as_read'),
(88, 1, 'core_message_mark_all_messages_as_read'),
(89, 1, 'core_message_mark_all_conversation_messages_as_read'),
(90, 1, 'core_message_mark_message_read'),
(91, 1, 'core_message_mark_notification_read'),
(92, 1, 'core_message_message_processor_config_form'),
(93, 1, 'core_message_search_contacts'),
(94, 1, 'core_message_send_instant_messages'),
(95, 1, 'core_message_send_messages_to_conversation'),
(96, 1, 'core_message_get_conversation_messages'),
(97, 1, 'core_message_unblock_user'),
(98, 1, 'core_message_unblock_contacts'),
(99, 1, 'core_message_get_user_notification_preferences'),
(100, 1, 'core_message_get_user_message_preferences'),
(101, 1, 'core_message_set_favourite_conversations'),
(102, 1, 'core_message_unset_favourite_conversations'),
(103, 1, 'core_message_delete_message_for_all_users'),
(104, 1, 'core_notes_create_notes'),
(105, 1, 'core_notes_delete_notes'),
(106, 1, 'core_notes_get_course_notes'),
(107, 1, 'core_notes_view_notes'),
(108, 1, 'core_question_update_flag'),
(109, 1, 'core_rating_get_item_ratings'),
(110, 1, 'core_rating_add_rating'),
(111, 1, 'core_tag_get_tagindex'),
(112, 1, 'core_tag_get_tagindex_per_area'),
(113, 1, 'core_tag_get_tag_areas'),
(114, 1, 'core_tag_get_tag_collections'),
(115, 1, 'core_tag_get_tag_cloud'),
(116, 1, 'core_user_add_user_device'),
(117, 1, 'core_user_add_user_private_files'),
(118, 1, 'core_user_get_course_user_profiles'),
(119, 1, 'core_user_get_users_by_field'),
(120, 1, 'core_user_remove_user_device'),
(121, 1, 'core_user_update_user_preferences'),
(122, 1, 'core_user_view_user_list'),
(123, 1, 'core_user_view_user_profile'),
(124, 1, 'core_user_get_user_preferences'),
(125, 1, 'core_user_update_picture'),
(126, 1, 'core_user_set_user_preferences'),
(127, 1, 'core_user_agree_site_policy'),
(128, 1, 'core_user_get_private_files_info'),
(129, 1, 'core_competency_competency_viewed'),
(130, 1, 'core_competency_list_course_competencies'),
(131, 1, 'core_competency_get_scale_values'),
(132, 1, 'core_competency_user_competency_viewed'),
(133, 1, 'core_competency_user_competency_viewed_in_plan'),
(134, 1, 'core_competency_user_competency_viewed_in_course'),
(135, 1, 'core_competency_user_competency_plan_viewed'),
(136, 1, 'core_competency_grade_competency_in_course'),
(137, 1, 'core_competency_delete_evidence'),
(138, 1, 'core_webservice_get_site_info'),
(139, 1, 'core_block_get_course_blocks'),
(140, 1, 'core_block_get_dashboard_blocks'),
(141, 1, 'core_filters_get_available_in_context'),
(142, 1, 'core_h5p_get_trusted_h5p_file'),
(143, 1, 'mod_assign_get_grades'),
(144, 1, 'mod_assign_get_assignments'),
(145, 1, 'mod_assign_get_submissions'),
(146, 1, 'mod_assign_get_user_flags'),
(147, 1, 'mod_assign_set_user_flags'),
(148, 1, 'mod_assign_get_user_mappings'),
(149, 1, 'mod_assign_revert_submissions_to_draft'),
(150, 1, 'mod_assign_lock_submissions'),
(151, 1, 'mod_assign_unlock_submissions'),
(152, 1, 'mod_assign_save_submission'),
(153, 1, 'mod_assign_submit_for_grading'),
(154, 1, 'mod_assign_save_grade'),
(155, 1, 'mod_assign_save_grades'),
(156, 1, 'mod_assign_save_user_extensions'),
(157, 1, 'mod_assign_reveal_identities'),
(158, 1, 'mod_assign_view_grading_table'),
(159, 1, 'mod_assign_view_submission_status'),
(160, 1, 'mod_assign_get_submission_status'),
(161, 1, 'mod_assign_list_participants'),
(162, 1, 'mod_assign_submit_grading_form'),
(163, 1, 'mod_assign_get_participant'),
(164, 1, 'mod_assign_view_assign'),
(165, 1, 'mod_book_view_book'),
(166, 1, 'mod_book_get_books_by_courses'),
(167, 1, 'mod_chat_login_user'),
(168, 1, 'mod_chat_get_chat_users'),
(169, 1, 'mod_chat_send_chat_message'),
(170, 1, 'mod_chat_get_chat_latest_messages'),
(171, 1, 'mod_chat_view_chat'),
(172, 1, 'mod_chat_get_chats_by_courses'),
(173, 1, 'mod_chat_get_sessions'),
(174, 1, 'mod_chat_get_session_messages'),
(175, 1, 'mod_choice_get_choice_results'),
(176, 1, 'mod_choice_get_choice_options'),
(177, 1, 'mod_choice_submit_choice_response'),
(178, 1, 'mod_choice_view_choice'),
(179, 1, 'mod_choice_get_choices_by_courses'),
(180, 1, 'mod_choice_delete_choice_responses'),
(181, 1, 'mod_data_get_databases_by_courses'),
(182, 1, 'mod_data_view_database'),
(183, 1, 'mod_data_get_data_access_information'),
(184, 1, 'mod_data_get_entries'),
(185, 1, 'mod_data_get_entry'),
(186, 1, 'mod_data_get_fields'),
(187, 1, 'mod_data_search_entries'),
(188, 1, 'mod_data_approve_entry'),
(189, 1, 'mod_data_delete_entry'),
(190, 1, 'mod_data_add_entry'),
(191, 1, 'mod_data_update_entry'),
(192, 1, 'mod_feedback_get_feedbacks_by_courses'),
(193, 1, 'mod_feedback_get_feedback_access_information'),
(194, 1, 'mod_feedback_view_feedback'),
(195, 1, 'mod_feedback_get_current_completed_tmp'),
(196, 1, 'mod_feedback_get_items'),
(197, 1, 'mod_feedback_launch_feedback'),
(198, 1, 'mod_feedback_get_page_items'),
(199, 1, 'mod_feedback_process_page'),
(200, 1, 'mod_feedback_get_analysis'),
(201, 1, 'mod_feedback_get_unfinished_responses'),
(202, 1, 'mod_feedback_get_finished_responses'),
(203, 1, 'mod_feedback_get_non_respondents'),
(204, 1, 'mod_feedback_get_responses_analysis'),
(205, 1, 'mod_feedback_get_last_completed'),
(206, 1, 'mod_folder_view_folder'),
(207, 1, 'mod_folder_get_folders_by_courses'),
(208, 1, 'mod_forum_get_forums_by_courses'),
(209, 1, 'mod_forum_get_discussion_posts'),
(210, 1, 'mod_forum_get_forum_discussion_posts'),
(211, 1, 'mod_forum_get_forum_discussions_paginated'),
(212, 1, 'mod_forum_get_forum_discussions'),
(213, 1, 'mod_forum_view_forum'),
(214, 1, 'mod_forum_view_forum_discussion'),
(215, 1, 'mod_forum_add_discussion_post'),
(216, 1, 'mod_forum_add_discussion'),
(217, 1, 'mod_forum_can_add_discussion'),
(218, 1, 'mod_forum_get_forum_access_information'),
(219, 1, 'mod_forum_set_subscription_state'),
(220, 1, 'mod_forum_set_lock_state'),
(221, 1, 'mod_forum_toggle_favourite_state'),
(222, 1, 'mod_forum_set_pin_state'),
(223, 1, 'mod_forum_delete_post'),
(224, 1, 'mod_forum_get_discussion_post'),
(225, 1, 'mod_forum_prepare_draft_area_for_post'),
(226, 1, 'mod_forum_update_discussion_post'),
(227, 1, 'mod_glossary_get_glossaries_by_courses'),
(228, 1, 'mod_glossary_view_glossary'),
(229, 1, 'mod_glossary_view_entry'),
(230, 1, 'mod_glossary_get_entries_by_letter'),
(231, 1, 'mod_glossary_get_entries_by_date'),
(232, 1, 'mod_glossary_get_categories'),
(233, 1, 'mod_glossary_get_entries_by_category'),
(234, 1, 'mod_glossary_get_authors'),
(235, 1, 'mod_glossary_get_entries_by_author'),
(236, 1, 'mod_glossary_get_entries_by_author_id'),
(237, 1, 'mod_glossary_get_entries_by_search'),
(238, 1, 'mod_glossary_get_entries_by_term'),
(239, 1, 'mod_glossary_get_entries_to_approve'),
(240, 1, 'mod_glossary_get_entry_by_id'),
(241, 1, 'mod_glossary_add_entry'),
(242, 1, 'mod_imscp_view_imscp'),
(243, 1, 'mod_imscp_get_imscps_by_courses'),
(244, 1, 'mod_label_get_labels_by_courses'),
(245, 1, 'mod_lesson_get_lessons_by_courses'),
(246, 1, 'mod_lesson_get_lesson_access_information'),
(247, 1, 'mod_lesson_view_lesson'),
(248, 1, 'mod_lesson_get_questions_attempts'),
(249, 1, 'mod_lesson_get_user_grade'),
(250, 1, 'mod_lesson_get_user_attempt_grade'),
(251, 1, 'mod_lesson_get_content_pages_viewed'),
(252, 1, 'mod_lesson_get_user_timers'),
(253, 1, 'mod_lesson_get_pages'),
(254, 1, 'mod_lesson_launch_attempt'),
(255, 1, 'mod_lesson_get_page_data'),
(256, 1, 'mod_lesson_process_page'),
(257, 1, 'mod_lesson_finish_attempt'),
(258, 1, 'mod_lesson_get_attempts_overview'),
(259, 1, 'mod_lesson_get_user_attempt'),
(260, 1, 'mod_lesson_get_pages_possible_jumps'),
(261, 1, 'mod_lesson_get_lesson'),
(262, 1, 'mod_lti_get_tool_launch_data'),
(263, 1, 'mod_lti_get_ltis_by_courses'),
(264, 1, 'mod_lti_view_lti'),
(265, 1, 'mod_page_view_page'),
(266, 1, 'mod_page_get_pages_by_courses'),
(267, 1, 'mod_quiz_get_quizzes_by_courses'),
(268, 1, 'mod_quiz_view_quiz'),
(269, 1, 'mod_quiz_get_user_attempts'),
(270, 1, 'mod_quiz_get_user_best_grade'),
(271, 1, 'mod_quiz_get_combined_review_options'),
(272, 1, 'mod_quiz_start_attempt'),
(273, 1, 'mod_quiz_get_attempt_data'),
(274, 1, 'mod_quiz_get_attempt_summary'),
(275, 1, 'mod_quiz_save_attempt'),
(276, 1, 'mod_quiz_process_attempt'),
(277, 1, 'mod_quiz_get_attempt_review'),
(278, 1, 'mod_quiz_view_attempt'),
(279, 1, 'mod_quiz_view_attempt_summary'),
(280, 1, 'mod_quiz_view_attempt_review'),
(281, 1, 'mod_quiz_get_quiz_feedback_for_grade'),
(282, 1, 'mod_quiz_get_quiz_access_information'),
(283, 1, 'mod_quiz_get_attempt_access_information'),
(284, 1, 'mod_quiz_get_quiz_required_qtypes'),
(285, 1, 'mod_resource_view_resource'),
(286, 1, 'mod_resource_get_resources_by_courses'),
(287, 1, 'mod_scorm_view_scorm'),
(288, 1, 'mod_scorm_get_scorm_attempt_count'),
(289, 1, 'mod_scorm_get_scorm_scoes'),
(290, 1, 'mod_scorm_get_scorm_user_data'),
(291, 1, 'mod_scorm_insert_scorm_tracks'),
(292, 1, 'mod_scorm_get_scorm_sco_tracks'),
(293, 1, 'mod_scorm_get_scorms_by_courses'),
(294, 1, 'mod_scorm_launch_sco'),
(295, 1, 'mod_scorm_get_scorm_access_information'),
(296, 1, 'mod_survey_get_surveys_by_courses'),
(297, 1, 'mod_survey_view_survey'),
(298, 1, 'mod_survey_get_questions'),
(299, 1, 'mod_survey_submit_answers'),
(300, 1, 'mod_url_view_url'),
(301, 1, 'mod_url_get_urls_by_courses'),
(302, 1, 'mod_wiki_get_wikis_by_courses'),
(303, 1, 'mod_wiki_view_wiki'),
(304, 1, 'mod_wiki_view_page'),
(305, 1, 'mod_wiki_get_subwikis'),
(306, 1, 'mod_wiki_get_subwiki_pages'),
(307, 1, 'mod_wiki_get_subwiki_files'),
(308, 1, 'mod_wiki_get_page_contents'),
(309, 1, 'mod_wiki_get_page_for_editing'),
(310, 1, 'mod_wiki_new_page'),
(311, 1, 'mod_wiki_edit_page'),
(312, 1, 'mod_workshop_get_workshops_by_courses'),
(313, 1, 'mod_workshop_get_workshop_access_information'),
(314, 1, 'mod_workshop_get_user_plan'),
(315, 1, 'mod_workshop_view_workshop'),
(316, 1, 'mod_workshop_add_submission'),
(317, 1, 'mod_workshop_update_submission'),
(318, 1, 'mod_workshop_delete_submission'),
(319, 1, 'mod_workshop_get_submissions'),
(320, 1, 'mod_workshop_get_submission'),
(321, 1, 'mod_workshop_get_submission_assessments'),
(322, 1, 'mod_workshop_get_assessment'),
(323, 1, 'mod_workshop_get_assessment_form_definition'),
(324, 1, 'mod_workshop_get_reviewer_assessments'),
(325, 1, 'mod_workshop_update_assessment'),
(326, 1, 'mod_workshop_get_grades'),
(327, 1, 'mod_workshop_evaluate_assessment'),
(328, 1, 'mod_workshop_get_grades_report'),
(329, 1, 'mod_workshop_view_submission'),
(330, 1, 'mod_workshop_evaluate_submission'),
(331, 1, 'enrol_guest_get_instance_info'),
(332, 1, 'enrol_self_get_instance_info'),
(333, 1, 'enrol_self_enrol_user'),
(334, 1, 'message_airnotifier_is_system_configured'),
(335, 1, 'message_airnotifier_are_notification_preferences_configured'),
(336, 1, 'message_airnotifier_get_user_devices'),
(337, 1, 'message_airnotifier_enable_device'),
(338, 1, 'message_popup_get_popup_notifications'),
(339, 1, 'message_popup_get_unread_popup_notification_count'),
(340, 1, 'block_recentlyaccesseditems_get_recent_items'),
(341, 1, 'block_starredcourses_get_starred_courses'),
(342, 1, 'report_insights_set_notuseful_prediction'),
(343, 1, 'report_insights_set_fixed_prediction'),
(344, 1, 'report_insights_action_executed'),
(345, 1, 'gradereport_overview_get_course_grades'),
(346, 1, 'gradereport_overview_view_grade_report'),
(347, 1, 'gradereport_user_get_grades_table'),
(348, 1, 'gradereport_user_view_grade_report'),
(349, 1, 'gradereport_user_get_grade_items'),
(350, 1, 'tool_analytics_potential_contexts'),
(351, 1, 'tool_lp_data_for_course_competencies_page'),
(352, 1, 'tool_lp_data_for_plans_page'),
(353, 1, 'tool_lp_data_for_plan_page'),
(354, 1, 'tool_lp_data_for_user_evidence_list_page'),
(355, 1, 'tool_lp_data_for_user_evidence_page'),
(356, 1, 'tool_lp_data_for_user_competency_summary'),
(357, 1, 'tool_lp_data_for_user_competency_summary_in_plan'),
(358, 1, 'tool_lp_data_for_user_competency_summary_in_course'),
(359, 1, 'tool_mobile_get_plugins_supporting_mobile'),
(360, 1, 'tool_mobile_get_public_config'),
(361, 1, 'tool_mobile_get_config'),
(362, 1, 'tool_mobile_get_autologin_key'),
(363, 1, 'tool_mobile_get_content'),
(364, 1, 'tool_mobile_call_external_functions'),
(368, 3, 'mod_treasurehunt_fetch_treasurehunt'),
(369, 3, 'mod_treasurehunt_update_stages'),
(370, 3, 'mod_treasurehunt_delete_stage'),
(371, 3, 'mod_treasurehunt_delete_road'),
(372, 3, 'mod_treasurehunt_renew_lock'),
(373, 3, 'mod_treasurehunt_user_progress'),
(374, 2, 'mod_attendance_add_attendance'),
(375, 2, 'mod_attendance_remove_attendance'),
(376, 2, 'mod_attendance_add_session'),
(377, 2, 'mod_attendance_remove_session'),
(378, 2, 'mod_attendance_get_courses_with_today_sessions'),
(379, 2, 'mod_attendance_get_session'),
(380, 2, 'mod_attendance_update_user_status');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_external_services_users`
--

CREATE TABLE `mdl_external_services_users` (
  `id` bigint(10) NOT NULL,
  `externalserviceid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `iprestriction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validuntil` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='users allowed to use services with restricted users flag' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_external_tokens`
--

CREATE TABLE `mdl_external_tokens` (
  `id` bigint(10) NOT NULL,
  `token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `privatetoken` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tokentype` smallint(4) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `externalserviceid` bigint(10) NOT NULL,
  `sid` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contextid` bigint(10) NOT NULL,
  `creatorid` bigint(10) NOT NULL DEFAULT '1',
  `iprestriction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validuntil` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `lastaccess` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Security tokens for accessing of external services' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_facetoface`
--

CREATE TABLE `mdl_facetoface` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro` longtext COLLATE utf8mb4_unicode_ci,
  `introformat` tinyint(2) NOT NULL DEFAULT '0',
  `thirdparty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thirdpartywaitlist` tinyint(1) NOT NULL DEFAULT '0',
  `display` bigint(10) NOT NULL DEFAULT '0',
  `confirmationsubject` longtext COLLATE utf8mb4_unicode_ci,
  `confirmationinstrmngr` longtext COLLATE utf8mb4_unicode_ci,
  `confirmationmessage` longtext COLLATE utf8mb4_unicode_ci,
  `waitlistedsubject` longtext COLLATE utf8mb4_unicode_ci,
  `waitlistedmessage` longtext COLLATE utf8mb4_unicode_ci,
  `cancellationsubject` longtext COLLATE utf8mb4_unicode_ci,
  `cancellationinstrmngr` longtext COLLATE utf8mb4_unicode_ci,
  `cancellationmessage` longtext COLLATE utf8mb4_unicode_ci,
  `remindersubject` longtext COLLATE utf8mb4_unicode_ci,
  `reminderinstrmngr` longtext COLLATE utf8mb4_unicode_ci,
  `remindermessage` longtext COLLATE utf8mb4_unicode_ci,
  `reminderperiod` bigint(10) NOT NULL DEFAULT '0',
  `requestsubject` longtext COLLATE utf8mb4_unicode_ci,
  `requestinstrmngr` longtext COLLATE utf8mb4_unicode_ci,
  `requestmessage` longtext COLLATE utf8mb4_unicode_ci,
  `timecreated` bigint(20) NOT NULL DEFAULT '0',
  `timemodified` bigint(20) NOT NULL DEFAULT '0',
  `shortname` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `showoncalendar` tinyint(1) NOT NULL DEFAULT '1',
  `approvalreqd` tinyint(1) NOT NULL DEFAULT '0',
  `usercalentry` tinyint(1) NOT NULL DEFAULT '1',
  `allowcancellationsdefault` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Each facetoface activity has an entry here' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_facetoface_notice`
--

CREATE TABLE `mdl_facetoface_notice` (
  `id` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Site-wide notices shown on the Training Calendar' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_facetoface_notice_data`
--

CREATE TABLE `mdl_facetoface_notice_data` (
  `id` bigint(10) NOT NULL,
  `fieldid` bigint(10) NOT NULL DEFAULT '0',
  `noticeid` bigint(10) NOT NULL DEFAULT '0',
  `data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Custom field filters for site notices' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_facetoface_sessions`
--

CREATE TABLE `mdl_facetoface_sessions` (
  `id` bigint(10) NOT NULL,
  `facetoface` bigint(10) NOT NULL DEFAULT '0',
  `capacity` bigint(10) NOT NULL DEFAULT '0',
  `allowoverbook` tinyint(1) NOT NULL DEFAULT '0',
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `datetimeknown` tinyint(1) NOT NULL DEFAULT '0',
  `duration` bigint(10) DEFAULT NULL,
  `normalcost` bigint(10) NOT NULL DEFAULT '0',
  `discountcost` bigint(10) NOT NULL DEFAULT '0',
  `allowcancellations` tinyint(1) NOT NULL DEFAULT '1',
  `timecreated` bigint(20) NOT NULL DEFAULT '0',
  `timemodified` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='A given facetoface activity may be given at different times ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_facetoface_sessions_dates`
--

CREATE TABLE `mdl_facetoface_sessions_dates` (
  `id` bigint(10) NOT NULL,
  `sessionid` bigint(10) NOT NULL DEFAULT '0',
  `timestart` bigint(20) NOT NULL DEFAULT '0',
  `timefinish` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='The dates and times for each session.  Sessions can be set o' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_facetoface_session_data`
--

CREATE TABLE `mdl_facetoface_session_data` (
  `id` bigint(10) NOT NULL,
  `fieldid` bigint(10) NOT NULL DEFAULT '0',
  `sessionid` bigint(10) NOT NULL DEFAULT '0',
  `data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Contents of custom info fields for Face-to-face session' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_facetoface_session_field`
--

CREATE TABLE `mdl_facetoface_session_field` (
  `id` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` bigint(10) NOT NULL DEFAULT '0',
  `possiblevalues` longtext COLLATE utf8mb4_unicode_ci,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `defaultvalue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isfilter` tinyint(1) NOT NULL DEFAULT '1',
  `showinsummary` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Definitions of custom info fields for Face-to-face session' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_facetoface_session_roles`
--

CREATE TABLE `mdl_facetoface_session_roles` (
  `id` bigint(10) NOT NULL,
  `sessionid` bigint(10) NOT NULL,
  `roleid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Users with a trainer role in a facetoface session' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_facetoface_signups`
--

CREATE TABLE `mdl_facetoface_signups` (
  `id` bigint(10) NOT NULL,
  `sessionid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `mailedreminder` bigint(10) NOT NULL,
  `discountcode` longtext COLLATE utf8mb4_unicode_ci,
  `notificationtype` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User/session signups' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_facetoface_signups_status`
--

CREATE TABLE `mdl_facetoface_signups_status` (
  `id` bigint(10) NOT NULL,
  `signupid` bigint(10) NOT NULL,
  `statuscode` bigint(10) NOT NULL,
  `superceded` tinyint(1) NOT NULL,
  `grade` decimal(10,5) DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `advice` longtext COLLATE utf8mb4_unicode_ci,
  `createdby` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User/session signup status' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_favourite`
--

CREATE TABLE `mdl_favourite` (
  `id` bigint(10) NOT NULL,
  `component` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `itemtype` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `itemid` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `ordering` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores the relationship between an arbitrary item (itemtype,' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_feedback`
--

CREATE TABLE `mdl_feedback` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `anonymous` tinyint(1) NOT NULL DEFAULT '1',
  `email_notification` tinyint(1) NOT NULL DEFAULT '1',
  `multiple_submit` tinyint(1) NOT NULL DEFAULT '1',
  `autonumbering` tinyint(1) NOT NULL DEFAULT '1',
  `site_after_submit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `page_after_submit` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_after_submitformat` tinyint(2) NOT NULL DEFAULT '0',
  `publish_stats` tinyint(1) NOT NULL DEFAULT '0',
  `timeopen` bigint(10) NOT NULL DEFAULT '0',
  `timeclose` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `completionsubmit` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='all feedbacks' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_feedback_completed`
--

CREATE TABLE `mdl_feedback_completed` (
  `id` bigint(10) NOT NULL,
  `feedback` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `random_response` bigint(10) NOT NULL DEFAULT '0',
  `anonymous_response` tinyint(1) NOT NULL DEFAULT '0',
  `courseid` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='filled out feedback' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_feedback_completedtmp`
--

CREATE TABLE `mdl_feedback_completedtmp` (
  `id` bigint(10) NOT NULL,
  `feedback` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `guestid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `random_response` bigint(10) NOT NULL DEFAULT '0',
  `anonymous_response` tinyint(1) NOT NULL DEFAULT '0',
  `courseid` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='filled out feedback' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_feedback_item`
--

CREATE TABLE `mdl_feedback_item` (
  `id` bigint(10) NOT NULL,
  `feedback` bigint(10) NOT NULL DEFAULT '0',
  `template` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `presentation` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `typ` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hasvalue` tinyint(1) NOT NULL DEFAULT '0',
  `position` smallint(3) NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `dependitem` bigint(10) NOT NULL DEFAULT '0',
  `dependvalue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `options` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='feedback_items' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_feedback_sitecourse_map`
--

CREATE TABLE `mdl_feedback_sitecourse_map` (
  `id` bigint(10) NOT NULL,
  `feedbackid` bigint(10) NOT NULL DEFAULT '0',
  `courseid` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='feedback sitecourse map' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_feedback_template`
--

CREATE TABLE `mdl_feedback_template` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `ispublic` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='templates of feedbackstructures' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_feedback_value`
--

CREATE TABLE `mdl_feedback_value` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL DEFAULT '0',
  `item` bigint(10) NOT NULL DEFAULT '0',
  `completed` bigint(10) NOT NULL DEFAULT '0',
  `tmp_completed` bigint(10) NOT NULL DEFAULT '0',
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='values of the completeds' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_feedback_valuetmp`
--

CREATE TABLE `mdl_feedback_valuetmp` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL DEFAULT '0',
  `item` bigint(10) NOT NULL DEFAULT '0',
  `completed` bigint(10) NOT NULL DEFAULT '0',
  `tmp_completed` bigint(10) NOT NULL DEFAULT '0',
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='values of the completedstmp' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_files`
--

CREATE TABLE `mdl_files` (
  `id` bigint(10) NOT NULL,
  `contenthash` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pathnamehash` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contextid` bigint(10) NOT NULL,
  `component` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `filearea` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `itemid` bigint(10) NOT NULL,
  `filepath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `userid` bigint(10) DEFAULT NULL,
  `filesize` bigint(10) NOT NULL,
  `mimetype` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` bigint(10) NOT NULL DEFAULT '0',
  `source` longtext COLLATE utf8mb4_unicode_ci,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `sortorder` bigint(10) NOT NULL DEFAULT '0',
  `referencefileid` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='description of files, content is stored in sha1 file pool' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_files`
--

INSERT INTO `mdl_files` (`id`, `contenthash`, `pathnamehash`, `contextid`, `component`, `filearea`, `itemid`, `filepath`, `filename`, `userid`, `filesize`, `mimetype`, `status`, `source`, `author`, `license`, `timecreated`, `timemodified`, `sortorder`, `referencefileid`) VALUES
(1, '5f8e911d0da441e36f47c5c46f4393269211ca56', '508e674d49c30d4fde325fe6c7f6fd3d56b247e1', 1, 'assignfeedback_editpdf', 'stamps', 0, '/', 'smile.png', 2, 1085, 'image/png', 0, NULL, NULL, NULL, 1583152106, 1583152106, 0, NULL),
(2, 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '70b7cdade7b4e27d4e83f0cdaad10d6a3c0cccb5', 1, 'assignfeedback_editpdf', 'stamps', 0, '/', '.', 2, 0, NULL, 0, NULL, NULL, NULL, 1583152106, 1583152844, 0, NULL),
(3, '75c101cb8cb34ea573cd25ac38f8157b1de901b8', '68317eab56c67d32aeaee5acf509a0c4aa828b6b', 1, 'assignfeedback_editpdf', 'stamps', 0, '/', 'sad.png', 2, 966, 'image/png', 0, NULL, NULL, NULL, 1583152106, 1583152106, 0, NULL),
(4, '0c5190a24c3943966541401c883eacaa20ca20cb', '695a55ff780e61c9e59428aa425430b0d6bde53b', 1, 'assignfeedback_editpdf', 'stamps', 0, '/', 'tick.png', 2, 1039, 'image/png', 0, NULL, NULL, NULL, 1583152106, 1583152106, 0, NULL),
(5, '8c96a486d5801e0f4ab8c411f561f1c687e1f865', '373e63af262a9b8466ba8632551520be793c37ff', 1, 'assignfeedback_editpdf', 'stamps', 0, '/', 'cross.png', 2, 861, 'image/png', 0, NULL, NULL, NULL, 1583152106, 1583152106, 0, NULL),
(8, '428882fea6b279d535ae406d9ee598de17ee2f5e', 'c43a0566e744b7165226569c517c44999b31479c', 1, 'core', 'preview', 0, '/thumb/', '5bc07fa39620832d3c10fdb70ccf3de30ac26e03', NULL, 9108, 'image/png', 0, NULL, NULL, NULL, 1584077855, 1584077855, 0, NULL),
(9, 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '74c104d54c05b5f8c633a36da516d37e6c5279e4', 1, 'core', 'preview', 0, '/thumb/', '.', NULL, 0, NULL, 0, NULL, NULL, NULL, 1584077855, 1584077855, 0, NULL),
(10, 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '884555719c50529b9df662a38619d04b5b11e25c', 1, 'core', 'preview', 0, '/', '.', NULL, 0, NULL, 0, NULL, NULL, NULL, 1584077855, 1584077855, 0, NULL),
(11, '5bc07fa39620832d3c10fdb70ccf3de30ac26e03', 'f1b909613ea40f8e187560c8540fa94907f922b1', 5, 'user', 'private', 0, '/', 'shutterstock_739534918-1024x835.jpg', 2, 71763, 'image/jpeg', 0, 'https://2e8ram2s1li74atce18qz5y1-wpengine.netdna-ssl.com/wp-content/uploads/2019/07/shutterstock_739534918-1024x835.jpg', 'Admin User', 'allrightsreserved', 1584077854, 1584077860, 0, NULL),
(12, 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'a30b51d1b7fe96885f4b6a30bfa3d174132fbf74', 5, 'user', 'private', 0, '/', '.', 2, 0, NULL, 0, NULL, NULL, NULL, 1584077854, 1584078062, 0, NULL),
(28, 'abcb9cdf9e9c6b497755cd6c9871a9e5944476d3', 'a982a5a6f27a2fccf3845554fb76a055c2e50a75', 1, 'core', 'preview', 0, '/thumb/', '65f5b4cc71c08da04be63308dcb64d26caa484c6', NULL, 11067, 'image/png', 0, NULL, NULL, NULL, 1584078338, 1584078338, 0, NULL),
(29, 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '309106b3da1ed80c8ef812b39eb78c9ac95a26a5', 5, 'user', 'private', 0, '/img/', '.', NULL, 0, NULL, 0, NULL, NULL, NULL, 1584078100, 1584078339, 0, NULL),
(30, '65f5b4cc71c08da04be63308dcb64d26caa484c6', '9589cc627f7157d6f4467e5eb951071cb1d1ddee', 5, 'user', 'private', 0, '/img/', 'financing-logo-v2.png', 2, 32444, 'image/png', 0, 'https://www.cedefop.europa.eu/files/images/financing-logo-v2.png', 'Admin User', 'allrightsreserved', 1584078336, 1584078339, 0, NULL),
(44, '6c3470e849d6082590f2060fff062affe0ec52a1', '53876b00f10e36282dc1fe896cc2f704fcb06a21', 5, 'user', 'draft', 736614197, '/', 'mod_checklist_moodle38_2020012900.zip', 2, 156801, 'application/zip', 0, 'O:8:\"stdClass\":1:{s:6:\"source\";s:37:\"mod_checklist_moodle38_2020012900.zip\";}', 'Admin User', 'allrightsreserved', 1585568423, 1585568423, 0, NULL),
(45, 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'ce435361bb205bc79fb257608ff31e4d22d04a3d', 5, 'user', 'draft', 736614197, '/', '.', 2, 0, NULL, 0, NULL, NULL, NULL, 1585568423, 1585568423, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_files_reference`
--

CREATE TABLE `mdl_files_reference` (
  `id` bigint(10) NOT NULL,
  `repositoryid` bigint(10) NOT NULL,
  `lastsync` bigint(10) DEFAULT NULL,
  `reference` longtext COLLATE utf8mb4_unicode_ci,
  `referencehash` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Store files references' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_file_conversion`
--

CREATE TABLE `mdl_file_conversion` (
  `id` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `sourcefileid` bigint(10) NOT NULL,
  `targetformat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` bigint(10) DEFAULT '0',
  `statusmessage` longtext COLLATE utf8mb4_unicode_ci,
  `converter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destfileid` bigint(10) DEFAULT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table to track file conversions.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_filter_active`
--

CREATE TABLE `mdl_filter_active` (
  `id` bigint(10) NOT NULL,
  `filter` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contextid` bigint(10) NOT NULL,
  `active` smallint(4) NOT NULL,
  `sortorder` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores information about which filters are active in which c' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_filter_active`
--

INSERT INTO `mdl_filter_active` (`id`, `filter`, `contextid`, `active`, `sortorder`) VALUES
(1, 'activitynames', 1, 1, 3),
(2, 'displayh5p', 1, 1, 1),
(3, 'mathjaxloader', 1, 1, 2),
(4, 'mediaplugin', 1, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_filter_config`
--

CREATE TABLE `mdl_filter_config` (
  `id` bigint(10) NOT NULL,
  `filter` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contextid` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores per-context configuration settings for filters which ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_folder`
--

CREATE TABLE `mdl_folder` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `revision` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `display` smallint(4) NOT NULL DEFAULT '0',
  `showexpanded` tinyint(1) NOT NULL DEFAULT '1',
  `showdownloadfolder` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='each record is one folder resource' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum`
--

CREATE TABLE `mdl_forum` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `duedate` bigint(10) NOT NULL DEFAULT '0',
  `cutoffdate` bigint(10) NOT NULL DEFAULT '0',
  `assessed` bigint(10) NOT NULL DEFAULT '0',
  `assesstimestart` bigint(10) NOT NULL DEFAULT '0',
  `assesstimefinish` bigint(10) NOT NULL DEFAULT '0',
  `scale` bigint(10) NOT NULL DEFAULT '0',
  `grade_forum` bigint(10) NOT NULL DEFAULT '0',
  `grade_forum_notify` smallint(4) NOT NULL DEFAULT '0',
  `maxbytes` bigint(10) NOT NULL DEFAULT '0',
  `maxattachments` bigint(10) NOT NULL DEFAULT '1',
  `forcesubscribe` tinyint(1) NOT NULL DEFAULT '0',
  `trackingtype` tinyint(2) NOT NULL DEFAULT '1',
  `rsstype` tinyint(2) NOT NULL DEFAULT '0',
  `rssarticles` tinyint(2) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `warnafter` bigint(10) NOT NULL DEFAULT '0',
  `blockafter` bigint(10) NOT NULL DEFAULT '0',
  `blockperiod` bigint(10) NOT NULL DEFAULT '0',
  `completiondiscussions` int(9) NOT NULL DEFAULT '0',
  `completionreplies` int(9) NOT NULL DEFAULT '0',
  `completionposts` int(9) NOT NULL DEFAULT '0',
  `displaywordcount` tinyint(1) NOT NULL DEFAULT '0',
  `lockdiscussionafter` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Forums contain and structure discussion' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum_digests`
--

CREATE TABLE `mdl_forum_digests` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `forum` bigint(10) NOT NULL,
  `maildigest` tinyint(1) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Keeps track of user mail delivery preferences for each forum' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum_discussions`
--

CREATE TABLE `mdl_forum_discussions` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `forum` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `firstpost` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `groupid` bigint(10) NOT NULL DEFAULT '-1',
  `assessed` tinyint(1) NOT NULL DEFAULT '1',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `usermodified` bigint(10) NOT NULL DEFAULT '0',
  `timestart` bigint(10) NOT NULL DEFAULT '0',
  `timeend` bigint(10) NOT NULL DEFAULT '0',
  `pinned` tinyint(1) NOT NULL DEFAULT '0',
  `timelocked` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Forums are composed of discussions' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum_discussion_subs`
--

CREATE TABLE `mdl_forum_discussion_subs` (
  `id` bigint(10) NOT NULL,
  `forum` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `discussion` bigint(10) NOT NULL,
  `preference` bigint(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Users may choose to subscribe and unsubscribe from specific ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum_grades`
--

CREATE TABLE `mdl_forum_grades` (
  `id` bigint(10) NOT NULL,
  `forum` bigint(10) NOT NULL,
  `itemnumber` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `grade` decimal(10,5) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Grading data for forum instances' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum_posts`
--

CREATE TABLE `mdl_forum_posts` (
  `id` bigint(10) NOT NULL,
  `discussion` bigint(10) NOT NULL DEFAULT '0',
  `parent` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `created` bigint(10) NOT NULL DEFAULT '0',
  `modified` bigint(10) NOT NULL DEFAULT '0',
  `mailed` tinyint(2) NOT NULL DEFAULT '0',
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `messageformat` tinyint(2) NOT NULL DEFAULT '0',
  `messagetrust` tinyint(2) NOT NULL DEFAULT '0',
  `attachment` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `totalscore` smallint(4) NOT NULL DEFAULT '0',
  `mailnow` bigint(10) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `privatereplyto` bigint(10) NOT NULL DEFAULT '0',
  `wordcount` bigint(20) DEFAULT NULL,
  `charcount` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='All posts are stored in this table' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum_queue`
--

CREATE TABLE `mdl_forum_queue` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `discussionid` bigint(10) NOT NULL DEFAULT '0',
  `postid` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='For keeping track of posts that will be mailed in digest for' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum_read`
--

CREATE TABLE `mdl_forum_read` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `forumid` bigint(10) NOT NULL DEFAULT '0',
  `discussionid` bigint(10) NOT NULL DEFAULT '0',
  `postid` bigint(10) NOT NULL DEFAULT '0',
  `firstread` bigint(10) NOT NULL DEFAULT '0',
  `lastread` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tracks each users read posts' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum_subscriptions`
--

CREATE TABLE `mdl_forum_subscriptions` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `forum` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Keeps track of who is subscribed to what forum' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum_track_prefs`
--

CREATE TABLE `mdl_forum_track_prefs` (
  `id` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `forumid` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tracks each users untracked forums' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_glossary`
--

CREATE TABLE `mdl_glossary` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `allowduplicatedentries` tinyint(2) NOT NULL DEFAULT '0',
  `displayformat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dictionary',
  `mainglossary` tinyint(2) NOT NULL DEFAULT '0',
  `showspecial` tinyint(2) NOT NULL DEFAULT '1',
  `showalphabet` tinyint(2) NOT NULL DEFAULT '1',
  `showall` tinyint(2) NOT NULL DEFAULT '1',
  `allowcomments` tinyint(2) NOT NULL DEFAULT '0',
  `allowprintview` tinyint(2) NOT NULL DEFAULT '1',
  `usedynalink` tinyint(2) NOT NULL DEFAULT '1',
  `defaultapproval` tinyint(2) NOT NULL DEFAULT '1',
  `approvaldisplayformat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `globalglossary` tinyint(2) NOT NULL DEFAULT '0',
  `entbypage` smallint(3) NOT NULL DEFAULT '10',
  `editalways` tinyint(2) NOT NULL DEFAULT '0',
  `rsstype` tinyint(2) NOT NULL DEFAULT '0',
  `rssarticles` tinyint(2) NOT NULL DEFAULT '0',
  `assessed` bigint(10) NOT NULL DEFAULT '0',
  `assesstimestart` bigint(10) NOT NULL DEFAULT '0',
  `assesstimefinish` bigint(10) NOT NULL DEFAULT '0',
  `scale` bigint(10) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `completionentries` int(9) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='all glossaries' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_glossary_alias`
--

CREATE TABLE `mdl_glossary_alias` (
  `id` bigint(10) NOT NULL,
  `entryid` bigint(10) NOT NULL DEFAULT '0',
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='entries alias' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_glossary_categories`
--

CREATE TABLE `mdl_glossary_categories` (
  `id` bigint(10) NOT NULL,
  `glossaryid` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `usedynalink` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='all categories for glossary entries' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_glossary_entries`
--

CREATE TABLE `mdl_glossary_entries` (
  `id` bigint(10) NOT NULL,
  `glossaryid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `concept` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `definition` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `definitionformat` tinyint(2) NOT NULL DEFAULT '0',
  `definitiontrust` tinyint(2) NOT NULL DEFAULT '0',
  `attachment` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  `teacherentry` tinyint(2) NOT NULL DEFAULT '0',
  `sourceglossaryid` bigint(10) NOT NULL DEFAULT '0',
  `usedynalink` tinyint(2) NOT NULL DEFAULT '1',
  `casesensitive` tinyint(2) NOT NULL DEFAULT '0',
  `fullmatch` tinyint(2) NOT NULL DEFAULT '1',
  `approved` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='all glossary entries' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_glossary_entries_categories`
--

CREATE TABLE `mdl_glossary_entries_categories` (
  `id` bigint(10) NOT NULL,
  `categoryid` bigint(10) NOT NULL DEFAULT '0',
  `entryid` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='categories of each glossary entry' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_glossary_formats`
--

CREATE TABLE `mdl_glossary_formats` (
  `id` bigint(10) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `popupformatname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `visible` tinyint(2) NOT NULL DEFAULT '1',
  `showgroup` tinyint(2) NOT NULL DEFAULT '1',
  `showtabs` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `defaultmode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `defaulthook` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortkey` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortorder` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Setting of the display formats' ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `mdl_glossary_formats`
--

INSERT INTO `mdl_glossary_formats` (`id`, `name`, `popupformatname`, `visible`, `showgroup`, `showtabs`, `defaultmode`, `defaulthook`, `sortkey`, `sortorder`) VALUES
(1, 'continuous', 'continuous', 1, 1, 'standard,category,date', '', '', '', ''),
(2, 'dictionary', 'dictionary', 1, 1, 'standard', '', '', '', ''),
(3, 'encyclopedia', 'encyclopedia', 1, 1, 'standard,category,date,author', '', '', '', ''),
(4, 'entrylist', 'entrylist', 1, 1, 'standard,category,date,author', '', '', '', ''),
(5, 'faq', 'faq', 1, 1, 'standard,category,date,author', '', '', '', ''),
(6, 'fullwithauthor', 'fullwithauthor', 1, 1, 'standard,category,date,author', '', '', '', ''),
(7, 'fullwithoutauthor', 'fullwithoutauthor', 1, 1, 'standard,category,date', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_categories`
--

CREATE TABLE `mdl_grade_categories` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `parent` bigint(10) DEFAULT NULL,
  `depth` bigint(10) NOT NULL DEFAULT '0',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `aggregation` bigint(10) NOT NULL DEFAULT '0',
  `keephigh` bigint(10) NOT NULL DEFAULT '0',
  `droplow` bigint(10) NOT NULL DEFAULT '0',
  `aggregateonlygraded` tinyint(1) NOT NULL DEFAULT '0',
  `aggregateoutcomes` tinyint(1) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table keeps information about categories, used for grou' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_categories_history`
--

CREATE TABLE `mdl_grade_categories_history` (
  `id` bigint(10) NOT NULL,
  `action` bigint(10) NOT NULL DEFAULT '0',
  `oldid` bigint(10) NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `loggeduser` bigint(10) DEFAULT NULL,
  `courseid` bigint(10) NOT NULL,
  `parent` bigint(10) DEFAULT NULL,
  `depth` bigint(10) NOT NULL DEFAULT '0',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `aggregation` bigint(10) NOT NULL DEFAULT '0',
  `keephigh` bigint(10) NOT NULL DEFAULT '0',
  `droplow` bigint(10) NOT NULL DEFAULT '0',
  `aggregateonlygraded` tinyint(1) NOT NULL DEFAULT '0',
  `aggregateoutcomes` tinyint(1) NOT NULL DEFAULT '0',
  `aggregatesubcats` tinyint(1) NOT NULL DEFAULT '0',
  `hidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='History of grade_categories' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_grades`
--

CREATE TABLE `mdl_grade_grades` (
  `id` bigint(10) NOT NULL,
  `itemid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `rawgrade` decimal(10,5) DEFAULT NULL,
  `rawgrademax` decimal(10,5) NOT NULL DEFAULT '100.00000',
  `rawgrademin` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `rawscaleid` bigint(10) DEFAULT NULL,
  `usermodified` bigint(10) DEFAULT NULL,
  `finalgrade` decimal(10,5) DEFAULT NULL,
  `hidden` bigint(10) NOT NULL DEFAULT '0',
  `locked` bigint(10) NOT NULL DEFAULT '0',
  `locktime` bigint(10) NOT NULL DEFAULT '0',
  `exported` bigint(10) NOT NULL DEFAULT '0',
  `overridden` bigint(10) NOT NULL DEFAULT '0',
  `excluded` bigint(10) NOT NULL DEFAULT '0',
  `feedback` longtext COLLATE utf8mb4_unicode_ci,
  `feedbackformat` bigint(10) NOT NULL DEFAULT '0',
  `information` longtext COLLATE utf8mb4_unicode_ci,
  `informationformat` bigint(10) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) DEFAULT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `aggregationstatus` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unknown',
  `aggregationweight` decimal(10,5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='grade_grades  This table keeps individual grades for each us' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_grades_history`
--

CREATE TABLE `mdl_grade_grades_history` (
  `id` bigint(10) NOT NULL,
  `action` bigint(10) NOT NULL DEFAULT '0',
  `oldid` bigint(10) NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `loggeduser` bigint(10) DEFAULT NULL,
  `itemid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `rawgrade` decimal(10,5) DEFAULT NULL,
  `rawgrademax` decimal(10,5) NOT NULL DEFAULT '100.00000',
  `rawgrademin` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `rawscaleid` bigint(10) DEFAULT NULL,
  `usermodified` bigint(10) DEFAULT NULL,
  `finalgrade` decimal(10,5) DEFAULT NULL,
  `hidden` bigint(10) NOT NULL DEFAULT '0',
  `locked` bigint(10) NOT NULL DEFAULT '0',
  `locktime` bigint(10) NOT NULL DEFAULT '0',
  `exported` bigint(10) NOT NULL DEFAULT '0',
  `overridden` bigint(10) NOT NULL DEFAULT '0',
  `excluded` bigint(10) NOT NULL DEFAULT '0',
  `feedback` longtext COLLATE utf8mb4_unicode_ci,
  `feedbackformat` bigint(10) NOT NULL DEFAULT '0',
  `information` longtext COLLATE utf8mb4_unicode_ci,
  `informationformat` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='History table' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_import_newitem`
--

CREATE TABLE `mdl_grade_import_newitem` (
  `id` bigint(10) NOT NULL,
  `itemname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `importcode` bigint(10) NOT NULL,
  `importer` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='temporary table for storing new grade_item names from grade ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_import_values`
--

CREATE TABLE `mdl_grade_import_values` (
  `id` bigint(10) NOT NULL,
  `itemid` bigint(10) DEFAULT NULL,
  `newgradeitem` bigint(10) DEFAULT NULL,
  `userid` bigint(10) NOT NULL,
  `finalgrade` decimal(10,5) DEFAULT NULL,
  `feedback` longtext COLLATE utf8mb4_unicode_ci,
  `importcode` bigint(10) NOT NULL,
  `importer` bigint(10) DEFAULT NULL,
  `importonlyfeedback` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Temporary table for importing grades' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_items`
--

CREATE TABLE `mdl_grade_items` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) DEFAULT NULL,
  `categoryid` bigint(10) DEFAULT NULL,
  `itemname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `itemtype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `itemmodule` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iteminstance` bigint(10) DEFAULT NULL,
  `itemnumber` bigint(10) DEFAULT NULL,
  `iteminfo` longtext COLLATE utf8mb4_unicode_ci,
  `idnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calculation` longtext COLLATE utf8mb4_unicode_ci,
  `gradetype` smallint(4) NOT NULL DEFAULT '1',
  `grademax` decimal(10,5) NOT NULL DEFAULT '100.00000',
  `grademin` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `scaleid` bigint(10) DEFAULT NULL,
  `outcomeid` bigint(10) DEFAULT NULL,
  `gradepass` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `multfactor` decimal(10,5) NOT NULL DEFAULT '1.00000',
  `plusfactor` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `aggregationcoef` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `aggregationcoef2` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `sortorder` bigint(10) NOT NULL DEFAULT '0',
  `display` bigint(10) NOT NULL DEFAULT '0',
  `decimals` tinyint(1) DEFAULT NULL,
  `hidden` bigint(10) NOT NULL DEFAULT '0',
  `locked` bigint(10) NOT NULL DEFAULT '0',
  `locktime` bigint(10) NOT NULL DEFAULT '0',
  `needsupdate` bigint(10) NOT NULL DEFAULT '0',
  `weightoverride` tinyint(1) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) DEFAULT NULL,
  `timemodified` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table keeps information about gradeable items (ie colum' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_items_history`
--

CREATE TABLE `mdl_grade_items_history` (
  `id` bigint(10) NOT NULL,
  `action` bigint(10) NOT NULL DEFAULT '0',
  `oldid` bigint(10) NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `loggeduser` bigint(10) DEFAULT NULL,
  `courseid` bigint(10) DEFAULT NULL,
  `categoryid` bigint(10) DEFAULT NULL,
  `itemname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `itemtype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `itemmodule` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iteminstance` bigint(10) DEFAULT NULL,
  `itemnumber` bigint(10) DEFAULT NULL,
  `iteminfo` longtext COLLATE utf8mb4_unicode_ci,
  `idnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calculation` longtext COLLATE utf8mb4_unicode_ci,
  `gradetype` smallint(4) NOT NULL DEFAULT '1',
  `grademax` decimal(10,5) NOT NULL DEFAULT '100.00000',
  `grademin` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `scaleid` bigint(10) DEFAULT NULL,
  `outcomeid` bigint(10) DEFAULT NULL,
  `gradepass` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `multfactor` decimal(10,5) NOT NULL DEFAULT '1.00000',
  `plusfactor` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `aggregationcoef` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `aggregationcoef2` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `sortorder` bigint(10) NOT NULL DEFAULT '0',
  `hidden` bigint(10) NOT NULL DEFAULT '0',
  `locked` bigint(10) NOT NULL DEFAULT '0',
  `locktime` bigint(10) NOT NULL DEFAULT '0',
  `needsupdate` bigint(10) NOT NULL DEFAULT '0',
  `display` bigint(10) NOT NULL DEFAULT '0',
  `decimals` tinyint(1) DEFAULT NULL,
  `weightoverride` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='History of grade_items' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_letters`
--

CREATE TABLE `mdl_grade_letters` (
  `id` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `lowerboundary` decimal(10,5) NOT NULL,
  `letter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Repository for grade letters, for courses and other moodle e' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_outcomes`
--

CREATE TABLE `mdl_grade_outcomes` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) DEFAULT NULL,
  `shortname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fullname` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `scaleid` bigint(10) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) DEFAULT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `usermodified` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table describes the outcomes used in the system. An out' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_outcomes_courses`
--

CREATE TABLE `mdl_grade_outcomes_courses` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `outcomeid` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='stores what outcomes are used in what courses.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_outcomes_history`
--

CREATE TABLE `mdl_grade_outcomes_history` (
  `id` bigint(10) NOT NULL,
  `action` bigint(10) NOT NULL DEFAULT '0',
  `oldid` bigint(10) NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  `loggeduser` bigint(10) DEFAULT NULL,
  `courseid` bigint(10) DEFAULT NULL,
  `shortname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fullname` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `scaleid` bigint(10) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='History table' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grade_settings`
--

CREATE TABLE `mdl_grade_settings` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='gradebook settings' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_gradingform_guide_comments`
--

CREATE TABLE `mdl_gradingform_guide_comments` (
  `id` bigint(10) NOT NULL,
  `definitionid` bigint(10) NOT NULL,
  `sortorder` bigint(10) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='frequently used comments used in marking guide' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_gradingform_guide_criteria`
--

CREATE TABLE `mdl_gradingform_guide_criteria` (
  `id` bigint(10) NOT NULL,
  `definitionid` bigint(10) NOT NULL,
  `sortorder` bigint(10) NOT NULL,
  `shortname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) DEFAULT NULL,
  `descriptionmarkers` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionmarkersformat` tinyint(2) DEFAULT NULL,
  `maxscore` decimal(10,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores the rows of the criteria grid.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_gradingform_guide_fillings`
--

CREATE TABLE `mdl_gradingform_guide_fillings` (
  `id` bigint(10) NOT NULL,
  `instanceid` bigint(10) NOT NULL,
  `criterionid` bigint(10) NOT NULL,
  `remark` longtext COLLATE utf8mb4_unicode_ci,
  `remarkformat` tinyint(2) DEFAULT NULL,
  `score` decimal(10,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores the data of how the guide is filled by a particular r' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_gradingform_rubric_criteria`
--

CREATE TABLE `mdl_gradingform_rubric_criteria` (
  `id` bigint(10) NOT NULL,
  `definitionid` bigint(10) NOT NULL,
  `sortorder` bigint(10) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores the rows of the rubric grid.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_gradingform_rubric_fillings`
--

CREATE TABLE `mdl_gradingform_rubric_fillings` (
  `id` bigint(10) NOT NULL,
  `instanceid` bigint(10) NOT NULL,
  `criterionid` bigint(10) NOT NULL,
  `levelid` bigint(10) DEFAULT NULL,
  `remark` longtext COLLATE utf8mb4_unicode_ci,
  `remarkformat` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores the data of how the rubric is filled by a particular ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_gradingform_rubric_levels`
--

CREATE TABLE `mdl_gradingform_rubric_levels` (
  `id` bigint(10) NOT NULL,
  `criterionid` bigint(10) NOT NULL,
  `score` decimal(10,5) NOT NULL,
  `definition` longtext COLLATE utf8mb4_unicode_ci,
  `definitionformat` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores the columns of the rubric grid.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grading_areas`
--

CREATE TABLE `mdl_grading_areas` (
  `id` bigint(10) NOT NULL,
  `contextid` bigint(10) NOT NULL,
  `component` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `areaname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `activemethod` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Identifies gradable areas where advanced grading can happen.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grading_definitions`
--

CREATE TABLE `mdl_grading_definitions` (
  `id` bigint(10) NOT NULL,
  `areaid` bigint(10) NOT NULL,
  `method` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) DEFAULT NULL,
  `status` bigint(10) NOT NULL DEFAULT '0',
  `copiedfromid` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `usercreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL,
  `timecopied` bigint(10) DEFAULT '0',
  `options` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Contains the basic information about an advanced grading for' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_grading_instances`
--

CREATE TABLE `mdl_grading_instances` (
  `id` bigint(10) NOT NULL,
  `definitionid` bigint(10) NOT NULL,
  `raterid` bigint(10) NOT NULL,
  `itemid` bigint(10) DEFAULT NULL,
  `rawgrade` decimal(10,5) DEFAULT NULL,
  `status` bigint(10) NOT NULL DEFAULT '0',
  `feedback` longtext COLLATE utf8mb4_unicode_ci,
  `feedbackformat` tinyint(2) DEFAULT NULL,
  `timemodified` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Grading form instance is an assessment record for one gradab' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_groupings`
--

CREATE TABLE `mdl_groupings` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `idnumber` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) NOT NULL DEFAULT '0',
  `configdata` longtext COLLATE utf8mb4_unicode_ci,
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='A grouping is a collection of groups. WAS: groups_groupings' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_groupings_groups`
--

CREATE TABLE `mdl_groupings_groups` (
  `id` bigint(10) NOT NULL,
  `groupingid` bigint(10) NOT NULL DEFAULT '0',
  `groupid` bigint(10) NOT NULL DEFAULT '0',
  `timeadded` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Link a grouping to a group (note, groups can be in multiple ' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_groups`
--

CREATE TABLE `mdl_groups` (
  `id` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `idnumber` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `descriptionformat` tinyint(2) NOT NULL DEFAULT '0',
  `enrolmentkey` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` bigint(10) NOT NULL DEFAULT '0',
  `hidepicture` tinyint(1) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL DEFAULT '0',
  `timemodified` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Each record represents a group.' ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_groups_members`
--

CREATE TABLE `mdl_groups_members` (
  `id` bigint(10) NOT NULL,
  `groupid` bigint(10) NOT NULL DEFAULT '0',
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `timeadded` bigint(10) NOT NULL DEFAULT '0',
  `component` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `itemid` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Link a user to a group.' ROW_FORMAT=COMPRESSED;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdl_analytics_indicator_calc`
--
ALTER TABLE `mdl_analytics_indicator_calc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_analindicalc_staendcon_ix` (`starttime`,`endtime`,`contextid`),
  ADD KEY `mdl_analindicalc_con_ix` (`contextid`);

--
-- Indexes for table `mdl_analytics_models`
--
ALTER TABLE `mdl_analytics_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_analmode_enatra_ix` (`enabled`,`trained`);

--
-- Indexes for table `mdl_analytics_models_log`
--
ALTER TABLE `mdl_analytics_models_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_analmodelog_mod_ix` (`modelid`);

--
-- Indexes for table `mdl_analytics_predictions`
--
ALTER TABLE `mdl_analytics_predictions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_analpred_modcon_ix` (`modelid`,`contextid`),
  ADD KEY `mdl_analpred_mod_ix` (`modelid`),
  ADD KEY `mdl_analpred_con_ix` (`contextid`);

--
-- Indexes for table `mdl_analytics_prediction_actions`
--
ALTER TABLE `mdl_analytics_prediction_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_analpredacti_preuseact_ix` (`predictionid`,`userid`,`actionname`),
  ADD KEY `mdl_analpredacti_pre_ix` (`predictionid`),
  ADD KEY `mdl_analpredacti_use_ix` (`userid`);

--
-- Indexes for table `mdl_analytics_predict_samples`
--
ALTER TABLE `mdl_analytics_predict_samples`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_analpredsamp_modanatimr_ix` (`modelid`,`analysableid`,`timesplitting`,`rangeindex`),
  ADD KEY `mdl_analpredsamp_mod_ix` (`modelid`);

--
-- Indexes for table `mdl_analytics_train_samples`
--
ALTER TABLE `mdl_analytics_train_samples`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_analtraisamp_modanatim_ix` (`modelid`,`analysableid`,`timesplitting`),
  ADD KEY `mdl_analtraisamp_mod_ix` (`modelid`);

--
-- Indexes for table `mdl_analytics_used_analysables`
--
ALTER TABLE `mdl_analytics_used_analysables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_analusedanal_modact_ix` (`modelid`,`action`),
  ADD KEY `mdl_analusedanal_ana_ix` (`analysableid`),
  ADD KEY `mdl_analusedanal_mod_ix` (`modelid`);

--
-- Indexes for table `mdl_analytics_used_files`
--
ALTER TABLE `mdl_analytics_used_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_analusedfile_modactfil_ix` (`modelid`,`action`,`fileid`),
  ADD KEY `mdl_analusedfile_mod_ix` (`modelid`),
  ADD KEY `mdl_analusedfile_fil_ix` (`fileid`);

--
-- Indexes for table `mdl_assign`
--
ALTER TABLE `mdl_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assi_cou_ix` (`course`),
  ADD KEY `mdl_assi_tea_ix` (`teamsubmissiongroupingid`);

--
-- Indexes for table `mdl_assignfeedback_comments`
--
ALTER TABLE `mdl_assignfeedback_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assicomm_ass_ix` (`assignment`),
  ADD KEY `mdl_assicomm_gra_ix` (`grade`);

--
-- Indexes for table `mdl_assignfeedback_editpdf_annot`
--
ALTER TABLE `mdl_assignfeedback_editpdf_annot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assieditanno_grapag_ix` (`gradeid`,`pageno`),
  ADD KEY `mdl_assieditanno_gra_ix` (`gradeid`);

--
-- Indexes for table `mdl_assignfeedback_editpdf_cmnt`
--
ALTER TABLE `mdl_assignfeedback_editpdf_cmnt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assieditcmnt_grapag_ix` (`gradeid`,`pageno`),
  ADD KEY `mdl_assieditcmnt_gra_ix` (`gradeid`);

--
-- Indexes for table `mdl_assignfeedback_editpdf_queue`
--
ALTER TABLE `mdl_assignfeedback_editpdf_queue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_assieditqueu_subsub_uix` (`submissionid`,`submissionattempt`);

--
-- Indexes for table `mdl_assignfeedback_editpdf_quick`
--
ALTER TABLE `mdl_assignfeedback_editpdf_quick`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assieditquic_use_ix` (`userid`);

--
-- Indexes for table `mdl_assignfeedback_editpdf_rot`
--
ALTER TABLE `mdl_assignfeedback_editpdf_rot`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_assieditrot_grapag_uix` (`gradeid`,`pageno`),
  ADD KEY `mdl_assieditrot_gra_ix` (`gradeid`);

--
-- Indexes for table `mdl_assignfeedback_file`
--
ALTER TABLE `mdl_assignfeedback_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assifile_ass2_ix` (`assignment`),
  ADD KEY `mdl_assifile_gra_ix` (`grade`);

--
-- Indexes for table `mdl_assignment`
--
ALTER TABLE `mdl_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assi_cou2_ix` (`course`);

--
-- Indexes for table `mdl_assignment_submissions`
--
ALTER TABLE `mdl_assignment_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assisubm_use2_ix` (`userid`),
  ADD KEY `mdl_assisubm_mai_ix` (`mailed`),
  ADD KEY `mdl_assisubm_tim_ix` (`timemarked`),
  ADD KEY `mdl_assisubm_ass2_ix` (`assignment`);

--
-- Indexes for table `mdl_assignment_upgrade`
--
ALTER TABLE `mdl_assignment_upgrade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assiupgr_old_ix` (`oldcmid`),
  ADD KEY `mdl_assiupgr_old2_ix` (`oldinstance`);

--
-- Indexes for table `mdl_assignsubmission_file`
--
ALTER TABLE `mdl_assignsubmission_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assifile_ass_ix` (`assignment`),
  ADD KEY `mdl_assifile_sub_ix` (`submission`);

--
-- Indexes for table `mdl_assignsubmission_onlinetext`
--
ALTER TABLE `mdl_assignsubmission_onlinetext`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assionli_ass_ix` (`assignment`),
  ADD KEY `mdl_assionli_sub_ix` (`submission`);

--
-- Indexes for table `mdl_assign_grades`
--
ALTER TABLE `mdl_assign_grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_assigrad_assuseatt_uix` (`assignment`,`userid`,`attemptnumber`),
  ADD KEY `mdl_assigrad_use_ix` (`userid`),
  ADD KEY `mdl_assigrad_att_ix` (`attemptnumber`),
  ADD KEY `mdl_assigrad_ass_ix` (`assignment`);

--
-- Indexes for table `mdl_assign_overrides`
--
ALTER TABLE `mdl_assign_overrides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assiover_ass_ix` (`assignid`),
  ADD KEY `mdl_assiover_gro_ix` (`groupid`),
  ADD KEY `mdl_assiover_use_ix` (`userid`);

--
-- Indexes for table `mdl_assign_plugin_config`
--
ALTER TABLE `mdl_assign_plugin_config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assiplugconf_plu_ix` (`plugin`),
  ADD KEY `mdl_assiplugconf_sub_ix` (`subtype`),
  ADD KEY `mdl_assiplugconf_nam_ix` (`name`),
  ADD KEY `mdl_assiplugconf_ass_ix` (`assignment`);

--
-- Indexes for table `mdl_assign_submission`
--
ALTER TABLE `mdl_assign_submission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_assisubm_assusegroatt_uix` (`assignment`,`userid`,`groupid`,`attemptnumber`),
  ADD KEY `mdl_assisubm_use_ix` (`userid`),
  ADD KEY `mdl_assisubm_att_ix` (`attemptnumber`),
  ADD KEY `mdl_assisubm_assusegrolat_ix` (`assignment`,`userid`,`groupid`,`latest`),
  ADD KEY `mdl_assisubm_ass_ix` (`assignment`);

--
-- Indexes for table `mdl_assign_user_flags`
--
ALTER TABLE `mdl_assign_user_flags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assiuserflag_mai_ix` (`mailed`),
  ADD KEY `mdl_assiuserflag_use_ix` (`userid`),
  ADD KEY `mdl_assiuserflag_ass_ix` (`assignment`);

--
-- Indexes for table `mdl_assign_user_mapping`
--
ALTER TABLE `mdl_assign_user_mapping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_assiusermapp_ass_ix` (`assignment`),
  ADD KEY `mdl_assiusermapp_use_ix` (`userid`);

--
-- Indexes for table `mdl_attendance`
--
ALTER TABLE `mdl_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_atte_cou_ix` (`course`);

--
-- Indexes for table `mdl_attendance_log`
--
ALTER TABLE `mdl_attendance_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_attelog_ses_ix` (`sessionid`),
  ADD KEY `mdl_attelog_stu_ix` (`studentid`),
  ADD KEY `mdl_attelog_sta_ix` (`statusid`);

--
-- Indexes for table `mdl_attendance_rotate_passwords`
--
ALTER TABLE `mdl_attendance_rotate_passwords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_attendance_sessions`
--
ALTER TABLE `mdl_attendance_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_attesess_att_ix` (`attendanceid`),
  ADD KEY `mdl_attesess_gro_ix` (`groupid`),
  ADD KEY `mdl_attesess_ses_ix` (`sessdate`),
  ADD KEY `mdl_attesess_cal_ix` (`caleventid`);

--
-- Indexes for table `mdl_attendance_statuses`
--
ALTER TABLE `mdl_attendance_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_attestat_att_ix` (`attendanceid`),
  ADD KEY `mdl_attestat_vis_ix` (`visible`),
  ADD KEY `mdl_attestat_del_ix` (`deleted`);

--
-- Indexes for table `mdl_attendance_tempusers`
--
ALTER TABLE `mdl_attendance_tempusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_attetemp_stu_uix` (`studentid`),
  ADD KEY `mdl_attetemp_cou_ix` (`courseid`);

--
-- Indexes for table `mdl_attendance_warning`
--
ALTER TABLE `mdl_attendance_warning`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_attewarn_idnwarwar_uix` (`idnumber`,`warningpercent`,`warnafter`);

--
-- Indexes for table `mdl_attendance_warning_done`
--
ALTER TABLE `mdl_attendance_warning_done`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_attewarndone_notuse_ix` (`notifyid`,`userid`);

--
-- Indexes for table `mdl_auth_oauth2_linked_login`
--
ALTER TABLE `mdl_auth_oauth2_linked_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_authoautlinklogi_useis_uix` (`userid`,`issuerid`,`username`),
  ADD KEY `mdl_authoautlinklogi_issuse_ix` (`issuerid`,`username`),
  ADD KEY `mdl_authoautlinklogi_use_ix` (`usermodified`),
  ADD KEY `mdl_authoautlinklogi_use2_ix` (`userid`),
  ADD KEY `mdl_authoautlinklogi_iss_ix` (`issuerid`);

--
-- Indexes for table `mdl_backup_controllers`
--
ALTER TABLE `mdl_backup_controllers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_backcont_bac_uix` (`backupid`),
  ADD KEY `mdl_backcont_typite_ix` (`type`,`itemid`),
  ADD KEY `mdl_backcont_useite_ix` (`userid`,`itemid`),
  ADD KEY `mdl_backcont_use_ix` (`userid`);

--
-- Indexes for table `mdl_backup_courses`
--
ALTER TABLE `mdl_backup_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_backcour_cou_uix` (`courseid`);

--
-- Indexes for table `mdl_backup_logs`
--
ALTER TABLE `mdl_backup_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_backlogs_bacid_uix` (`backupid`,`id`),
  ADD KEY `mdl_backlogs_bac_ix` (`backupid`);

--
-- Indexes for table `mdl_badge`
--
ALTER TABLE `mdl_badge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_badg_typ_ix` (`type`),
  ADD KEY `mdl_badg_cou_ix` (`courseid`),
  ADD KEY `mdl_badg_use_ix` (`usermodified`),
  ADD KEY `mdl_badg_use2_ix` (`usercreated`);

--
-- Indexes for table `mdl_badge_alignment`
--
ALTER TABLE `mdl_badge_alignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_badgalig_bad_ix` (`badgeid`);

--
-- Indexes for table `mdl_badge_backpack`
--
ALTER TABLE `mdl_badge_backpack`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_badgback_use_ix` (`userid`),
  ADD KEY `mdl_badgback_ext_ix` (`externalbackpackid`);

--
-- Indexes for table `mdl_badge_criteria`
--
ALTER TABLE `mdl_badge_criteria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_badgcrit_badcri_uix` (`badgeid`,`criteriatype`),
  ADD KEY `mdl_badgcrit_cri_ix` (`criteriatype`),
  ADD KEY `mdl_badgcrit_bad_ix` (`badgeid`);

--
-- Indexes for table `mdl_badge_criteria_met`
--
ALTER TABLE `mdl_badge_criteria_met`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_badgcritmet_cri_ix` (`critid`),
  ADD KEY `mdl_badgcritmet_use_ix` (`userid`),
  ADD KEY `mdl_badgcritmet_iss_ix` (`issuedid`);

--
-- Indexes for table `mdl_badge_criteria_param`
--
ALTER TABLE `mdl_badge_criteria_param`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_badgcritpara_cri_ix` (`critid`);

--
-- Indexes for table `mdl_badge_endorsement`
--
ALTER TABLE `mdl_badge_endorsement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_badgendo_bad_ix` (`badgeid`);

--
-- Indexes for table `mdl_badge_external`
--
ALTER TABLE `mdl_badge_external`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_badgexte_bac_ix` (`backpackid`);

--
-- Indexes for table `mdl_badge_external_backpack`
--
ALTER TABLE `mdl_badge_external_backpack`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_badgexteback_bac_uix` (`backpackapiurl`),
  ADD UNIQUE KEY `mdl_badgexteback_bac2_uix` (`backpackweburl`);

--
-- Indexes for table `mdl_badge_external_identifier`
--
ALTER TABLE `mdl_badge_external_identifier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_badgexteiden_sitintext_uix` (`sitebackpackid`,`internalid`,`externalid`,`type`),
  ADD KEY `mdl_badgexteiden_sit_ix` (`sitebackpackid`);

--
-- Indexes for table `mdl_badge_issued`
--
ALTER TABLE `mdl_badge_issued`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_badgissu_baduse_uix` (`badgeid`,`userid`),
  ADD KEY `mdl_badgissu_bad_ix` (`badgeid`),
  ADD KEY `mdl_badgissu_use_ix` (`userid`);

--
-- Indexes for table `mdl_badge_manual_award`
--
ALTER TABLE `mdl_badge_manual_award`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_badgmanuawar_bad_ix` (`badgeid`),
  ADD KEY `mdl_badgmanuawar_rec_ix` (`recipientid`),
  ADD KEY `mdl_badgmanuawar_iss_ix` (`issuerid`),
  ADD KEY `mdl_badgmanuawar_iss2_ix` (`issuerrole`);

--
-- Indexes for table `mdl_badge_related`
--
ALTER TABLE `mdl_badge_related`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_badgrela_badrel_uix` (`badgeid`,`relatedbadgeid`),
  ADD KEY `mdl_badgrela_bad_ix` (`badgeid`),
  ADD KEY `mdl_badgrela_rel_ix` (`relatedbadgeid`);

--
-- Indexes for table `mdl_block`
--
ALTER TABLE `mdl_block`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_bloc_nam_uix` (`name`);

--
-- Indexes for table `mdl_block_configurable_reports`
--
ALTER TABLE `mdl_block_configurable_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_block_instances`
--
ALTER TABLE `mdl_block_instances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_blocinst_parshopagsub_ix` (`parentcontextid`,`showinsubcontexts`,`pagetypepattern`,`subpagepattern`),
  ADD KEY `mdl_blocinst_tim_ix` (`timemodified`),
  ADD KEY `mdl_blocinst_par_ix` (`parentcontextid`);

--
-- Indexes for table `mdl_block_positions`
--
ALTER TABLE `mdl_block_positions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_blocposi_bloconpagsub_uix` (`blockinstanceid`,`contextid`,`pagetype`,`subpage`),
  ADD KEY `mdl_blocposi_blo_ix` (`blockinstanceid`),
  ADD KEY `mdl_blocposi_con_ix` (`contextid`);

--
-- Indexes for table `mdl_block_recentlyaccesseditems`
--
ALTER TABLE `mdl_block_recentlyaccesseditems`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_blocrece_usecoucmi_uix` (`userid`,`courseid`,`cmid`),
  ADD KEY `mdl_blocrece_use_ix` (`userid`),
  ADD KEY `mdl_blocrece_cou_ix` (`courseid`),
  ADD KEY `mdl_blocrece_cmi_ix` (`cmid`);

--
-- Indexes for table `mdl_block_recent_activity`
--
ALTER TABLE `mdl_block_recent_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_blocreceacti_coutim_ix` (`courseid`,`timecreated`);

--
-- Indexes for table `mdl_block_rss_client`
--
ALTER TABLE `mdl_block_rss_client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_blog_association`
--
ALTER TABLE `mdl_blog_association`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_blogasso_con_ix` (`contextid`),
  ADD KEY `mdl_blogasso_blo_ix` (`blogid`);

--
-- Indexes for table `mdl_blog_external`
--
ALTER TABLE `mdl_blog_external`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_blogexte_use_ix` (`userid`);

--
-- Indexes for table `mdl_book`
--
ALTER TABLE `mdl_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_book_chapters`
--
ALTER TABLE `mdl_book_chapters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_cache_filters`
--
ALTER TABLE `mdl_cache_filters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_cachfilt_filmd5_ix` (`filter`,`md5key`);

--
-- Indexes for table `mdl_cache_flags`
--
ALTER TABLE `mdl_cache_flags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_cachflag_fla_ix` (`flagtype`),
  ADD KEY `mdl_cachflag_nam_ix` (`name`);

--
-- Indexes for table `mdl_capabilities`
--
ALTER TABLE `mdl_capabilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_capa_nam_uix` (`name`);

--
-- Indexes for table `mdl_chat`
--
ALTER TABLE `mdl_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_chat_cou_ix` (`course`);

--
-- Indexes for table `mdl_chat_messages`
--
ALTER TABLE `mdl_chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_chatmess_use_ix` (`userid`),
  ADD KEY `mdl_chatmess_gro_ix` (`groupid`),
  ADD KEY `mdl_chatmess_timcha_ix` (`timestamp`,`chatid`),
  ADD KEY `mdl_chatmess_cha_ix` (`chatid`);

--
-- Indexes for table `mdl_chat_messages_current`
--
ALTER TABLE `mdl_chat_messages_current`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_chatmesscurr_use_ix` (`userid`),
  ADD KEY `mdl_chatmesscurr_gro_ix` (`groupid`),
  ADD KEY `mdl_chatmesscurr_timcha_ix` (`timestamp`,`chatid`),
  ADD KEY `mdl_chatmesscurr_cha_ix` (`chatid`);

--
-- Indexes for table `mdl_chat_users`
--
ALTER TABLE `mdl_chat_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_chatuser_use_ix` (`userid`),
  ADD KEY `mdl_chatuser_las_ix` (`lastping`),
  ADD KEY `mdl_chatuser_gro_ix` (`groupid`),
  ADD KEY `mdl_chatuser_cha_ix` (`chatid`);

--
-- Indexes for table `mdl_checklist`
--
ALTER TABLE `mdl_checklist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_chec_cou_ix` (`course`);

--
-- Indexes for table `mdl_checklist_check`
--
ALTER TABLE `mdl_checklist_check`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_checchec_ite_ix` (`item`),
  ADD KEY `mdl_checchec_use_ix` (`userid`);

--
-- Indexes for table `mdl_checklist_comment`
--
ALTER TABLE `mdl_checklist_comment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_checcomm_iteuse_uix` (`itemid`,`userid`);

--
-- Indexes for table `mdl_checklist_item`
--
ALTER TABLE `mdl_checklist_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_checitem_use_ix` (`userid`),
  ADD KEY `mdl_checitem_che_ix` (`checklist`),
  ADD KEY `mdl_checitem_mod_ix` (`moduleid`),
  ADD KEY `mdl_checitem_lin_ix` (`linkcourseid`);

--
-- Indexes for table `mdl_choice`
--
ALTER TABLE `mdl_choice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_choi_cou_ix` (`course`);

--
-- Indexes for table `mdl_choice_answers`
--
ALTER TABLE `mdl_choice_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_choiansw_use_ix` (`userid`),
  ADD KEY `mdl_choiansw_cho_ix` (`choiceid`),
  ADD KEY `mdl_choiansw_opt_ix` (`optionid`);

--
-- Indexes for table `mdl_choice_options`
--
ALTER TABLE `mdl_choice_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_choiopti_cho_ix` (`choiceid`);

--
-- Indexes for table `mdl_cohort`
--
ALTER TABLE `mdl_cohort`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_coho_con_ix` (`contextid`);

--
-- Indexes for table `mdl_cohort_members`
--
ALTER TABLE `mdl_cohort_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_cohomemb_cohuse_uix` (`cohortid`,`userid`),
  ADD KEY `mdl_cohomemb_coh_ix` (`cohortid`),
  ADD KEY `mdl_cohomemb_use_ix` (`userid`);

--
-- Indexes for table `mdl_comments`
--
ALTER TABLE `mdl_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_comm_concomite_ix` (`contextid`,`commentarea`,`itemid`),
  ADD KEY `mdl_comm_use_ix` (`userid`);

--
-- Indexes for table `mdl_competency`
--
ALTER TABLE `mdl_competency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_comp_comidn_uix` (`competencyframeworkid`,`idnumber`),
  ADD KEY `mdl_comp_rul_ix` (`ruleoutcome`);

--
-- Indexes for table `mdl_competency_coursecomp`
--
ALTER TABLE `mdl_competency_coursecomp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_compcour_coucom_uix` (`courseid`,`competencyid`),
  ADD KEY `mdl_compcour_courul_ix` (`courseid`,`ruleoutcome`),
  ADD KEY `mdl_compcour_cou2_ix` (`courseid`),
  ADD KEY `mdl_compcour_com_ix` (`competencyid`);

--
-- Indexes for table `mdl_competency_coursecompsetting`
--
ALTER TABLE `mdl_competency_coursecompsetting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_compcour_cou_uix` (`courseid`);

--
-- Indexes for table `mdl_competency_evidence`
--
ALTER TABLE `mdl_competency_evidence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_compevid_use_ix` (`usercompetencyid`);

--
-- Indexes for table `mdl_competency_framework`
--
ALTER TABLE `mdl_competency_framework`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_compfram_idn_uix` (`idnumber`);

--
-- Indexes for table `mdl_competency_modulecomp`
--
ALTER TABLE `mdl_competency_modulecomp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_compmodu_cmicom_uix` (`cmid`,`competencyid`),
  ADD KEY `mdl_compmodu_cmirul_ix` (`cmid`,`ruleoutcome`),
  ADD KEY `mdl_compmodu_cmi_ix` (`cmid`),
  ADD KEY `mdl_compmodu_com_ix` (`competencyid`);

--
-- Indexes for table `mdl_competency_plan`
--
ALTER TABLE `mdl_competency_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_compplan_usesta_ix` (`userid`,`status`),
  ADD KEY `mdl_compplan_tem_ix` (`templateid`),
  ADD KEY `mdl_compplan_stadue_ix` (`status`,`duedate`);

--
-- Indexes for table `mdl_competency_plancomp`
--
ALTER TABLE `mdl_competency_plancomp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_compplan_placom_uix` (`planid`,`competencyid`);

--
-- Indexes for table `mdl_competency_relatedcomp`
--
ALTER TABLE `mdl_competency_relatedcomp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_competency_template`
--
ALTER TABLE `mdl_competency_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_competency_templatecohort`
--
ALTER TABLE `mdl_competency_templatecohort`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_comptemp_temcoh_uix` (`templateid`,`cohortid`),
  ADD KEY `mdl_comptemp_tem2_ix` (`templateid`);

--
-- Indexes for table `mdl_competency_templatecomp`
--
ALTER TABLE `mdl_competency_templatecomp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_comptemp_tem_ix` (`templateid`),
  ADD KEY `mdl_comptemp_com_ix` (`competencyid`);

--
-- Indexes for table `mdl_competency_usercomp`
--
ALTER TABLE `mdl_competency_usercomp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_compuser_usecom_uix` (`userid`,`competencyid`);

--
-- Indexes for table `mdl_competency_usercompcourse`
--
ALTER TABLE `mdl_competency_usercompcourse`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_compuser_usecoucom_uix` (`userid`,`courseid`,`competencyid`);

--
-- Indexes for table `mdl_competency_usercompplan`
--
ALTER TABLE `mdl_competency_usercompplan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_compuser_usecompla_uix` (`userid`,`competencyid`,`planid`);

--
-- Indexes for table `mdl_competency_userevidence`
--
ALTER TABLE `mdl_competency_userevidence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_compuser_use_ix` (`userid`);

--
-- Indexes for table `mdl_competency_userevidencecomp`
--
ALTER TABLE `mdl_competency_userevidencecomp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_compuser_usecom2_uix` (`userevidenceid`,`competencyid`),
  ADD KEY `mdl_compuser_use2_ix` (`userevidenceid`);

--
-- Indexes for table `mdl_config`
--
ALTER TABLE `mdl_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_conf_nam_uix` (`name`);

--
-- Indexes for table `mdl_config_log`
--
ALTER TABLE `mdl_config_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_conflog_tim_ix` (`timemodified`),
  ADD KEY `mdl_conflog_use_ix` (`userid`);

--
-- Indexes for table `mdl_config_plugins`
--
ALTER TABLE `mdl_config_plugins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_confplug_plunam_uix` (`plugin`,`name`);

--
-- Indexes for table `mdl_context`
--
ALTER TABLE `mdl_context`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_cont_conins_uix` (`contextlevel`,`instanceid`),
  ADD KEY `mdl_cont_ins_ix` (`instanceid`),
  ADD KEY `mdl_cont_pat_ix` (`path`);

--
-- Indexes for table `mdl_context_temp`
--
ALTER TABLE `mdl_context_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_course`
--
ALTER TABLE `mdl_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_cour_cat_ix` (`category`),
  ADD KEY `mdl_cour_idn_ix` (`idnumber`),
  ADD KEY `mdl_cour_sho_ix` (`shortname`),
  ADD KEY `mdl_cour_sor_ix` (`sortorder`);

--
-- Indexes for table `mdl_course_categories`
--
ALTER TABLE `mdl_course_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_courcate_par_ix` (`parent`);

--
-- Indexes for table `mdl_course_completions`
--
ALTER TABLE `mdl_course_completions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_courcomp_usecou_uix` (`userid`,`course`),
  ADD KEY `mdl_courcomp_use_ix` (`userid`),
  ADD KEY `mdl_courcomp_cou_ix` (`course`),
  ADD KEY `mdl_courcomp_tim_ix` (`timecompleted`);

--
-- Indexes for table `mdl_course_completion_aggr_methd`
--
ALTER TABLE `mdl_course_completion_aggr_methd`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_courcompaggrmeth_coucr_uix` (`course`,`criteriatype`),
  ADD KEY `mdl_courcompaggrmeth_cou_ix` (`course`),
  ADD KEY `mdl_courcompaggrmeth_cri_ix` (`criteriatype`);

--
-- Indexes for table `mdl_course_completion_criteria`
--
ALTER TABLE `mdl_course_completion_criteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_courcompcrit_cou_ix` (`course`);

--
-- Indexes for table `mdl_course_completion_crit_compl`
--
ALTER TABLE `mdl_course_completion_crit_compl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_courcompcritcomp_useco_uix` (`userid`,`course`,`criteriaid`),
  ADD KEY `mdl_courcompcritcomp_use_ix` (`userid`),
  ADD KEY `mdl_courcompcritcomp_cou_ix` (`course`),
  ADD KEY `mdl_courcompcritcomp_cri_ix` (`criteriaid`),
  ADD KEY `mdl_courcompcritcomp_tim_ix` (`timecompleted`);

--
-- Indexes for table `mdl_course_completion_defaults`
--
ALTER TABLE `mdl_course_completion_defaults`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_courcompdefa_coumod_uix` (`course`,`module`),
  ADD KEY `mdl_courcompdefa_mod_ix` (`module`),
  ADD KEY `mdl_courcompdefa_cou_ix` (`course`);

--
-- Indexes for table `mdl_course_format_options`
--
ALTER TABLE `mdl_course_format_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_courformopti_couforsec_uix` (`courseid`,`format`,`sectionid`,`name`),
  ADD KEY `mdl_courformopti_cou_ix` (`courseid`);

--
-- Indexes for table `mdl_course_modules`
--
ALTER TABLE `mdl_course_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_courmodu_vis_ix` (`visible`),
  ADD KEY `mdl_courmodu_cou_ix` (`course`),
  ADD KEY `mdl_courmodu_mod_ix` (`module`),
  ADD KEY `mdl_courmodu_ins_ix` (`instance`),
  ADD KEY `mdl_courmodu_idncou_ix` (`idnumber`,`course`),
  ADD KEY `mdl_courmodu_gro_ix` (`groupingid`);

--
-- Indexes for table `mdl_course_modules_completion`
--
ALTER TABLE `mdl_course_modules_completion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_courmoducomp_usecou_uix` (`userid`,`coursemoduleid`),
  ADD KEY `mdl_courmoducomp_cou_ix` (`coursemoduleid`);

--
-- Indexes for table `mdl_course_published`
--
ALTER TABLE `mdl_course_published`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_course_request`
--
ALTER TABLE `mdl_course_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_courrequ_sho_ix` (`shortname`);

--
-- Indexes for table `mdl_course_sections`
--
ALTER TABLE `mdl_course_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_coursect_cousec_uix` (`course`,`section`);

--
-- Indexes for table `mdl_customfield_category`
--
ALTER TABLE `mdl_customfield_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_custcate_comareitesor_ix` (`component`,`area`,`itemid`,`sortorder`),
  ADD KEY `mdl_custcate_con_ix` (`contextid`);

--
-- Indexes for table `mdl_customfield_data`
--
ALTER TABLE `mdl_customfield_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_custdata_insfie_uix` (`instanceid`,`fieldid`),
  ADD KEY `mdl_custdata_fieint_ix` (`fieldid`,`intvalue`),
  ADD KEY `mdl_custdata_fiesho_ix` (`fieldid`,`shortcharvalue`),
  ADD KEY `mdl_custdata_fiedec_ix` (`fieldid`,`decvalue`),
  ADD KEY `mdl_custdata_fie_ix` (`fieldid`),
  ADD KEY `mdl_custdata_con_ix` (`contextid`);

--
-- Indexes for table `mdl_customfield_field`
--
ALTER TABLE `mdl_customfield_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_custfiel_catsor_ix` (`categoryid`,`sortorder`),
  ADD KEY `mdl_custfiel_cat_ix` (`categoryid`);

--
-- Indexes for table `mdl_data`
--
ALTER TABLE `mdl_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_data_cou_ix` (`course`);

--
-- Indexes for table `mdl_data_content`
--
ALTER TABLE `mdl_data_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_datacont_rec_ix` (`recordid`),
  ADD KEY `mdl_datacont_fie_ix` (`fieldid`);

--
-- Indexes for table `mdl_data_fields`
--
ALTER TABLE `mdl_data_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_datafiel_typdat_ix` (`type`,`dataid`),
  ADD KEY `mdl_datafiel_dat_ix` (`dataid`);

--
-- Indexes for table `mdl_data_records`
--
ALTER TABLE `mdl_data_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_datareco_dat_ix` (`dataid`);

--
-- Indexes for table `mdl_editor_atto_autosave`
--
ALTER TABLE `mdl_editor_atto_autosave`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_editattoauto_eleconuse_uix` (`elementid`,`contextid`,`userid`,`pagehash`);

--
-- Indexes for table `mdl_enrol`
--
ALTER TABLE `mdl_enrol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_enro_enr_ix` (`enrol`),
  ADD KEY `mdl_enro_cou_ix` (`courseid`);

--
-- Indexes for table `mdl_enrol_apply_applicationinfo`
--
ALTER TABLE `mdl_enrol_apply_applicationinfo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_enroapplappl_use_uix` (`userenrolmentid`);

--
-- Indexes for table `mdl_enrol_flatfile`
--
ALTER TABLE `mdl_enrol_flatfile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_enroflat_cou_ix` (`courseid`),
  ADD KEY `mdl_enroflat_use_ix` (`userid`),
  ADD KEY `mdl_enroflat_rol_ix` (`roleid`);

--
-- Indexes for table `mdl_enrol_lti_lti2_consumer`
--
ALTER TABLE `mdl_enrol_lti_lti2_consumer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_enroltilti2cons_con_uix` (`consumerkey256`);

--
-- Indexes for table `mdl_enrol_lti_lti2_context`
--
ALTER TABLE `mdl_enrol_lti_lti2_context`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_enroltilti2cont_con_ix` (`consumerid`);

--
-- Indexes for table `mdl_enrol_lti_lti2_nonce`
--
ALTER TABLE `mdl_enrol_lti_lti2_nonce`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_enroltilti2nonc_con_ix` (`consumerid`);

--
-- Indexes for table `mdl_enrol_lti_lti2_resource_link`
--
ALTER TABLE `mdl_enrol_lti_lti2_resource_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_enroltilti2resolink_con_ix` (`contextid`),
  ADD KEY `mdl_enroltilti2resolink_pri_ix` (`primaryresourcelinkid`),
  ADD KEY `mdl_enroltilti2resolink_co2_ix` (`consumerid`);

--
-- Indexes for table `mdl_enrol_lti_lti2_share_key`
--
ALTER TABLE `mdl_enrol_lti_lti2_share_key`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_enroltilti2sharkey_sha_uix` (`sharekey`),
  ADD UNIQUE KEY `mdl_enroltilti2sharkey_res_uix` (`resourcelinkid`);

--
-- Indexes for table `mdl_enrol_lti_lti2_tool_proxy`
--
ALTER TABLE `mdl_enrol_lti_lti2_tool_proxy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_enroltilti2toolprox_to_uix` (`toolproxykey`),
  ADD KEY `mdl_enroltilti2toolprox_con_ix` (`consumerid`);

--
-- Indexes for table `mdl_enrol_lti_lti2_user_result`
--
ALTER TABLE `mdl_enrol_lti_lti2_user_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_enroltilti2userresu_res_ix` (`resourcelinkid`);

--
-- Indexes for table `mdl_enrol_lti_tools`
--
ALTER TABLE `mdl_enrol_lti_tools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_enroltitool_enr_ix` (`enrolid`),
  ADD KEY `mdl_enroltitool_con_ix` (`contextid`);

--
-- Indexes for table `mdl_enrol_lti_tool_consumer_map`
--
ALTER TABLE `mdl_enrol_lti_tool_consumer_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_enroltitoolconsmap_too_ix` (`toolid`),
  ADD KEY `mdl_enroltitoolconsmap_con_ix` (`consumerid`);

--
-- Indexes for table `mdl_enrol_lti_users`
--
ALTER TABLE `mdl_enrol_lti_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_enroltiuser_use_ix` (`userid`),
  ADD KEY `mdl_enroltiuser_too_ix` (`toolid`);

--
-- Indexes for table `mdl_enrol_paypal`
--
ALTER TABLE `mdl_enrol_paypal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_enropayp_bus_ix` (`business`),
  ADD KEY `mdl_enropayp_rec_ix` (`receiver_email`),
  ADD KEY `mdl_enropayp_cou_ix` (`courseid`),
  ADD KEY `mdl_enropayp_use_ix` (`userid`),
  ADD KEY `mdl_enropayp_ins_ix` (`instanceid`);

--
-- Indexes for table `mdl_event`
--
ALTER TABLE `mdl_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_even_cou_ix` (`courseid`),
  ADD KEY `mdl_even_use_ix` (`userid`),
  ADD KEY `mdl_even_tim_ix` (`timestart`),
  ADD KEY `mdl_even_tim2_ix` (`timeduration`),
  ADD KEY `mdl_even_uui_ix` (`uuid`),
  ADD KEY `mdl_even_typtim_ix` (`type`,`timesort`),
  ADD KEY `mdl_even_grocoucatvisuse_ix` (`groupid`,`courseid`,`categoryid`,`visible`,`userid`),
  ADD KEY `mdl_even_cat_ix` (`categoryid`),
  ADD KEY `mdl_even_sub_ix` (`subscriptionid`);

--
-- Indexes for table `mdl_events_handlers`
--
ALTER TABLE `mdl_events_handlers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_evenhand_evecom_uix` (`eventname`,`component`);

--
-- Indexes for table `mdl_events_queue`
--
ALTER TABLE `mdl_events_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_evenqueu_use_ix` (`userid`);

--
-- Indexes for table `mdl_events_queue_handlers`
--
ALTER TABLE `mdl_events_queue_handlers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_evenqueuhand_que_ix` (`queuedeventid`),
  ADD KEY `mdl_evenqueuhand_han_ix` (`handlerid`);

--
-- Indexes for table `mdl_event_subscriptions`
--
ALTER TABLE `mdl_event_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_external_functions`
--
ALTER TABLE `mdl_external_functions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_extefunc_nam_uix` (`name`);

--
-- Indexes for table `mdl_external_services`
--
ALTER TABLE `mdl_external_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_exteserv_nam_uix` (`name`);

--
-- Indexes for table `mdl_external_services_functions`
--
ALTER TABLE `mdl_external_services_functions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_exteservfunc_ext_ix` (`externalserviceid`);

--
-- Indexes for table `mdl_external_services_users`
--
ALTER TABLE `mdl_external_services_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_exteservuser_ext_ix` (`externalserviceid`),
  ADD KEY `mdl_exteservuser_use_ix` (`userid`);

--
-- Indexes for table `mdl_external_tokens`
--
ALTER TABLE `mdl_external_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_extetoke_use_ix` (`userid`),
  ADD KEY `mdl_extetoke_ext_ix` (`externalserviceid`),
  ADD KEY `mdl_extetoke_con_ix` (`contextid`),
  ADD KEY `mdl_extetoke_cre_ix` (`creatorid`);

--
-- Indexes for table `mdl_facetoface`
--
ALTER TABLE `mdl_facetoface`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_face_cou_ix` (`course`);

--
-- Indexes for table `mdl_facetoface_notice`
--
ALTER TABLE `mdl_facetoface_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_facetoface_notice_data`
--
ALTER TABLE `mdl_facetoface_notice_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_facenotidata_fie_ix` (`fieldid`);

--
-- Indexes for table `mdl_facetoface_sessions`
--
ALTER TABLE `mdl_facetoface_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_facesess_fac_ix` (`facetoface`);

--
-- Indexes for table `mdl_facetoface_sessions_dates`
--
ALTER TABLE `mdl_facetoface_sessions_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_facesessdate_ses_ix` (`sessionid`);

--
-- Indexes for table `mdl_facetoface_session_data`
--
ALTER TABLE `mdl_facetoface_session_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_facetoface_session_field`
--
ALTER TABLE `mdl_facetoface_session_field`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_facesessfiel_sho_uix` (`shortname`);

--
-- Indexes for table `mdl_facetoface_session_roles`
--
ALTER TABLE `mdl_facetoface_session_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_facesessrole_ses_ix` (`sessionid`);

--
-- Indexes for table `mdl_facetoface_signups`
--
ALTER TABLE `mdl_facetoface_signups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_facesign_ses_ix` (`sessionid`);

--
-- Indexes for table `mdl_facetoface_signups_status`
--
ALTER TABLE `mdl_facetoface_signups_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_facesignstat_sig_ix` (`signupid`);

--
-- Indexes for table `mdl_favourite`
--
ALTER TABLE `mdl_favourite`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_favo_comiteiteconuse_uix` (`component`,`itemtype`,`itemid`,`contextid`,`userid`),
  ADD KEY `mdl_favo_con_ix` (`contextid`),
  ADD KEY `mdl_favo_use_ix` (`userid`);

--
-- Indexes for table `mdl_feedback`
--
ALTER TABLE `mdl_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_feed_cou_ix` (`course`);

--
-- Indexes for table `mdl_feedback_completed`
--
ALTER TABLE `mdl_feedback_completed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_feedcomp_use_ix` (`userid`),
  ADD KEY `mdl_feedcomp_fee_ix` (`feedback`);

--
-- Indexes for table `mdl_feedback_completedtmp`
--
ALTER TABLE `mdl_feedback_completedtmp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_feedcomp_use2_ix` (`userid`),
  ADD KEY `mdl_feedcomp_fee2_ix` (`feedback`);

--
-- Indexes for table `mdl_feedback_item`
--
ALTER TABLE `mdl_feedback_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_feeditem_fee_ix` (`feedback`),
  ADD KEY `mdl_feeditem_tem_ix` (`template`);

--
-- Indexes for table `mdl_feedback_sitecourse_map`
--
ALTER TABLE `mdl_feedback_sitecourse_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_feedsitemap_cou_ix` (`courseid`),
  ADD KEY `mdl_feedsitemap_fee_ix` (`feedbackid`);

--
-- Indexes for table `mdl_feedback_template`
--
ALTER TABLE `mdl_feedback_template`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_feedtemp_cou_ix` (`course`);

--
-- Indexes for table `mdl_feedback_value`
--
ALTER TABLE `mdl_feedback_value`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_feedvalu_comitecou_uix` (`completed`,`item`,`course_id`),
  ADD KEY `mdl_feedvalu_cou_ix` (`course_id`),
  ADD KEY `mdl_feedvalu_ite_ix` (`item`);

--
-- Indexes for table `mdl_feedback_valuetmp`
--
ALTER TABLE `mdl_feedback_valuetmp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_feedvalu_comitecou2_uix` (`completed`,`item`,`course_id`),
  ADD KEY `mdl_feedvalu_cou2_ix` (`course_id`),
  ADD KEY `mdl_feedvalu_ite2_ix` (`item`);

--
-- Indexes for table `mdl_files`
--
ALTER TABLE `mdl_files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_file_pat_uix` (`pathnamehash`),
  ADD KEY `mdl_file_comfilconite_ix` (`component`,`filearea`,`contextid`,`itemid`),
  ADD KEY `mdl_file_con_ix` (`contenthash`),
  ADD KEY `mdl_file_con2_ix` (`contextid`),
  ADD KEY `mdl_file_use_ix` (`userid`),
  ADD KEY `mdl_file_ref_ix` (`referencefileid`);

--
-- Indexes for table `mdl_files_reference`
--
ALTER TABLE `mdl_files_reference`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_filerefe_refrep_uix` (`referencehash`,`repositoryid`),
  ADD KEY `mdl_filerefe_rep_ix` (`repositoryid`);

--
-- Indexes for table `mdl_file_conversion`
--
ALTER TABLE `mdl_file_conversion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_fileconv_sou_ix` (`sourcefileid`),
  ADD KEY `mdl_fileconv_des_ix` (`destfileid`);

--
-- Indexes for table `mdl_filter_active`
--
ALTER TABLE `mdl_filter_active`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_filtacti_confil_uix` (`contextid`,`filter`),
  ADD KEY `mdl_filtacti_con_ix` (`contextid`);

--
-- Indexes for table `mdl_filter_config`
--
ALTER TABLE `mdl_filter_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_filtconf_confilnam_uix` (`contextid`,`filter`,`name`),
  ADD KEY `mdl_filtconf_con_ix` (`contextid`);

--
-- Indexes for table `mdl_folder`
--
ALTER TABLE `mdl_folder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_fold_cou_ix` (`course`);

--
-- Indexes for table `mdl_forum`
--
ALTER TABLE `mdl_forum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_foru_cou_ix` (`course`);

--
-- Indexes for table `mdl_forum_digests`
--
ALTER TABLE `mdl_forum_digests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_forudige_forusemai_uix` (`forum`,`userid`,`maildigest`),
  ADD KEY `mdl_forudige_use_ix` (`userid`),
  ADD KEY `mdl_forudige_for_ix` (`forum`);

--
-- Indexes for table `mdl_forum_discussions`
--
ALTER TABLE `mdl_forum_discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_forudisc_use_ix` (`userid`),
  ADD KEY `mdl_forudisc_cou_ix` (`course`),
  ADD KEY `mdl_forudisc_for_ix` (`forum`);

--
-- Indexes for table `mdl_forum_discussion_subs`
--
ALTER TABLE `mdl_forum_discussion_subs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_forudiscsubs_usedis_uix` (`userid`,`discussion`),
  ADD KEY `mdl_forudiscsubs_for_ix` (`forum`),
  ADD KEY `mdl_forudiscsubs_use_ix` (`userid`),
  ADD KEY `mdl_forudiscsubs_dis_ix` (`discussion`);

--
-- Indexes for table `mdl_forum_grades`
--
ALTER TABLE `mdl_forum_grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_forugrad_foriteuse_uix` (`forum`,`itemnumber`,`userid`),
  ADD KEY `mdl_forugrad_use_ix` (`userid`),
  ADD KEY `mdl_forugrad_for_ix` (`forum`);

--
-- Indexes for table `mdl_forum_posts`
--
ALTER TABLE `mdl_forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_forupost_use_ix` (`userid`),
  ADD KEY `mdl_forupost_cre_ix` (`created`),
  ADD KEY `mdl_forupost_mai_ix` (`mailed`),
  ADD KEY `mdl_forupost_dis_ix` (`discussion`),
  ADD KEY `mdl_forupost_par_ix` (`parent`);

--
-- Indexes for table `mdl_forum_queue`
--
ALTER TABLE `mdl_forum_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_foruqueu_use_ix` (`userid`),
  ADD KEY `mdl_foruqueu_dis_ix` (`discussionid`),
  ADD KEY `mdl_foruqueu_pos_ix` (`postid`);

--
-- Indexes for table `mdl_forum_read`
--
ALTER TABLE `mdl_forum_read`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_foruread_usefor_ix` (`userid`,`forumid`),
  ADD KEY `mdl_foruread_usedis_ix` (`userid`,`discussionid`),
  ADD KEY `mdl_foruread_posuse_ix` (`postid`,`userid`);

--
-- Indexes for table `mdl_forum_subscriptions`
--
ALTER TABLE `mdl_forum_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_forusubs_usefor_uix` (`userid`,`forum`),
  ADD KEY `mdl_forusubs_use_ix` (`userid`),
  ADD KEY `mdl_forusubs_for_ix` (`forum`);

--
-- Indexes for table `mdl_forum_track_prefs`
--
ALTER TABLE `mdl_forum_track_prefs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_forutracpref_usefor_ix` (`userid`,`forumid`);

--
-- Indexes for table `mdl_glossary`
--
ALTER TABLE `mdl_glossary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_glos_cou_ix` (`course`);

--
-- Indexes for table `mdl_glossary_alias`
--
ALTER TABLE `mdl_glossary_alias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_glosalia_ent_ix` (`entryid`);

--
-- Indexes for table `mdl_glossary_categories`
--
ALTER TABLE `mdl_glossary_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gloscate_glo_ix` (`glossaryid`);

--
-- Indexes for table `mdl_glossary_entries`
--
ALTER TABLE `mdl_glossary_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_glosentr_use_ix` (`userid`),
  ADD KEY `mdl_glosentr_con_ix` (`concept`),
  ADD KEY `mdl_glosentr_glo_ix` (`glossaryid`);

--
-- Indexes for table `mdl_glossary_entries_categories`
--
ALTER TABLE `mdl_glossary_entries_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_glosentrcate_cat_ix` (`categoryid`),
  ADD KEY `mdl_glosentrcate_ent_ix` (`entryid`);

--
-- Indexes for table `mdl_glossary_formats`
--
ALTER TABLE `mdl_glossary_formats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_grade_categories`
--
ALTER TABLE `mdl_grade_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradcate_cou_ix` (`courseid`),
  ADD KEY `mdl_gradcate_par_ix` (`parent`);

--
-- Indexes for table `mdl_grade_categories_history`
--
ALTER TABLE `mdl_grade_categories_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradcatehist_act_ix` (`action`),
  ADD KEY `mdl_gradcatehist_tim_ix` (`timemodified`),
  ADD KEY `mdl_gradcatehist_old_ix` (`oldid`),
  ADD KEY `mdl_gradcatehist_cou_ix` (`courseid`),
  ADD KEY `mdl_gradcatehist_par_ix` (`parent`),
  ADD KEY `mdl_gradcatehist_log_ix` (`loggeduser`);

--
-- Indexes for table `mdl_grade_grades`
--
ALTER TABLE `mdl_grade_grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_gradgrad_useite_uix` (`userid`,`itemid`),
  ADD KEY `mdl_gradgrad_locloc_ix` (`locked`,`locktime`),
  ADD KEY `mdl_gradgrad_ite_ix` (`itemid`),
  ADD KEY `mdl_gradgrad_use_ix` (`userid`),
  ADD KEY `mdl_gradgrad_raw_ix` (`rawscaleid`),
  ADD KEY `mdl_gradgrad_use2_ix` (`usermodified`);

--
-- Indexes for table `mdl_grade_grades_history`
--
ALTER TABLE `mdl_grade_grades_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradgradhist_act_ix` (`action`),
  ADD KEY `mdl_gradgradhist_tim_ix` (`timemodified`),
  ADD KEY `mdl_gradgradhist_useitetim_ix` (`userid`,`itemid`,`timemodified`),
  ADD KEY `mdl_gradgradhist_old_ix` (`oldid`),
  ADD KEY `mdl_gradgradhist_ite_ix` (`itemid`),
  ADD KEY `mdl_gradgradhist_use_ix` (`userid`),
  ADD KEY `mdl_gradgradhist_raw_ix` (`rawscaleid`),
  ADD KEY `mdl_gradgradhist_use2_ix` (`usermodified`),
  ADD KEY `mdl_gradgradhist_log_ix` (`loggeduser`);

--
-- Indexes for table `mdl_grade_import_newitem`
--
ALTER TABLE `mdl_grade_import_newitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradimponewi_imp_ix` (`importer`);

--
-- Indexes for table `mdl_grade_import_values`
--
ALTER TABLE `mdl_grade_import_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradimpovalu_ite_ix` (`itemid`),
  ADD KEY `mdl_gradimpovalu_new_ix` (`newgradeitem`),
  ADD KEY `mdl_gradimpovalu_imp_ix` (`importer`);

--
-- Indexes for table `mdl_grade_items`
--
ALTER TABLE `mdl_grade_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_graditem_locloc_ix` (`locked`,`locktime`),
  ADD KEY `mdl_graditem_itenee_ix` (`itemtype`,`needsupdate`),
  ADD KEY `mdl_graditem_gra_ix` (`gradetype`),
  ADD KEY `mdl_graditem_idncou_ix` (`idnumber`,`courseid`),
  ADD KEY `mdl_graditem_cou_ix` (`courseid`),
  ADD KEY `mdl_graditem_cat_ix` (`categoryid`),
  ADD KEY `mdl_graditem_sca_ix` (`scaleid`),
  ADD KEY `mdl_graditem_out_ix` (`outcomeid`);

--
-- Indexes for table `mdl_grade_items_history`
--
ALTER TABLE `mdl_grade_items_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_graditemhist_act_ix` (`action`),
  ADD KEY `mdl_graditemhist_tim_ix` (`timemodified`),
  ADD KEY `mdl_graditemhist_old_ix` (`oldid`),
  ADD KEY `mdl_graditemhist_cou_ix` (`courseid`),
  ADD KEY `mdl_graditemhist_cat_ix` (`categoryid`),
  ADD KEY `mdl_graditemhist_sca_ix` (`scaleid`),
  ADD KEY `mdl_graditemhist_out_ix` (`outcomeid`),
  ADD KEY `mdl_graditemhist_log_ix` (`loggeduser`);

--
-- Indexes for table `mdl_grade_letters`
--
ALTER TABLE `mdl_grade_letters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_gradlett_conlowlet_uix` (`contextid`,`lowerboundary`,`letter`);

--
-- Indexes for table `mdl_grade_outcomes`
--
ALTER TABLE `mdl_grade_outcomes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_gradoutc_cousho_uix` (`courseid`,`shortname`),
  ADD KEY `mdl_gradoutc_cou_ix` (`courseid`),
  ADD KEY `mdl_gradoutc_sca_ix` (`scaleid`),
  ADD KEY `mdl_gradoutc_use_ix` (`usermodified`);

--
-- Indexes for table `mdl_grade_outcomes_courses`
--
ALTER TABLE `mdl_grade_outcomes_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_gradoutccour_couout_uix` (`courseid`,`outcomeid`),
  ADD KEY `mdl_gradoutccour_cou_ix` (`courseid`),
  ADD KEY `mdl_gradoutccour_out_ix` (`outcomeid`);

--
-- Indexes for table `mdl_grade_outcomes_history`
--
ALTER TABLE `mdl_grade_outcomes_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradoutchist_act_ix` (`action`),
  ADD KEY `mdl_gradoutchist_tim_ix` (`timemodified`),
  ADD KEY `mdl_gradoutchist_old_ix` (`oldid`),
  ADD KEY `mdl_gradoutchist_cou_ix` (`courseid`),
  ADD KEY `mdl_gradoutchist_sca_ix` (`scaleid`),
  ADD KEY `mdl_gradoutchist_log_ix` (`loggeduser`);

--
-- Indexes for table `mdl_grade_settings`
--
ALTER TABLE `mdl_grade_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_gradsett_counam_uix` (`courseid`,`name`),
  ADD KEY `mdl_gradsett_cou_ix` (`courseid`);

--
-- Indexes for table `mdl_gradingform_guide_comments`
--
ALTER TABLE `mdl_gradingform_guide_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradguidcomm_def_ix` (`definitionid`);

--
-- Indexes for table `mdl_gradingform_guide_criteria`
--
ALTER TABLE `mdl_gradingform_guide_criteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradguidcrit_def_ix` (`definitionid`);

--
-- Indexes for table `mdl_gradingform_guide_fillings`
--
ALTER TABLE `mdl_gradingform_guide_fillings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_gradguidfill_inscri_uix` (`instanceid`,`criterionid`),
  ADD KEY `mdl_gradguidfill_ins_ix` (`instanceid`),
  ADD KEY `mdl_gradguidfill_cri_ix` (`criterionid`);

--
-- Indexes for table `mdl_gradingform_rubric_criteria`
--
ALTER TABLE `mdl_gradingform_rubric_criteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradrubrcrit_def_ix` (`definitionid`);

--
-- Indexes for table `mdl_gradingform_rubric_fillings`
--
ALTER TABLE `mdl_gradingform_rubric_fillings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_gradrubrfill_inscri_uix` (`instanceid`,`criterionid`),
  ADD KEY `mdl_gradrubrfill_lev_ix` (`levelid`),
  ADD KEY `mdl_gradrubrfill_ins_ix` (`instanceid`),
  ADD KEY `mdl_gradrubrfill_cri_ix` (`criterionid`);

--
-- Indexes for table `mdl_gradingform_rubric_levels`
--
ALTER TABLE `mdl_gradingform_rubric_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradrubrleve_cri_ix` (`criterionid`);

--
-- Indexes for table `mdl_grading_areas`
--
ALTER TABLE `mdl_grading_areas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_gradarea_concomare_uix` (`contextid`,`component`,`areaname`),
  ADD KEY `mdl_gradarea_con_ix` (`contextid`);

--
-- Indexes for table `mdl_grading_definitions`
--
ALTER TABLE `mdl_grading_definitions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_graddefi_aremet_uix` (`areaid`,`method`),
  ADD KEY `mdl_graddefi_are_ix` (`areaid`),
  ADD KEY `mdl_graddefi_use_ix` (`usermodified`),
  ADD KEY `mdl_graddefi_use2_ix` (`usercreated`);

--
-- Indexes for table `mdl_grading_instances`
--
ALTER TABLE `mdl_grading_instances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_gradinst_def_ix` (`definitionid`),
  ADD KEY `mdl_gradinst_rat_ix` (`raterid`);

--
-- Indexes for table `mdl_groupings`
--
ALTER TABLE `mdl_groupings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_grou_idn2_ix` (`idnumber`),
  ADD KEY `mdl_grou_cou2_ix` (`courseid`);

--
-- Indexes for table `mdl_groupings_groups`
--
ALTER TABLE `mdl_groupings_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_grougrou_gro_ix` (`groupingid`),
  ADD KEY `mdl_grougrou_gro2_ix` (`groupid`);

--
-- Indexes for table `mdl_groups`
--
ALTER TABLE `mdl_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_grou_idn_ix` (`idnumber`),
  ADD KEY `mdl_grou_cou_ix` (`courseid`);

--
-- Indexes for table `mdl_groups_members`
--
ALTER TABLE `mdl_groups_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mdl_groumemb_usegro_uix` (`userid`,`groupid`),
  ADD KEY `mdl_groumemb_gro_ix` (`groupid`),
  ADD KEY `mdl_groumemb_use_ix` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdl_analytics_indicator_calc`
--
ALTER TABLE `mdl_analytics_indicator_calc`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_analytics_models`
--
ALTER TABLE `mdl_analytics_models`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mdl_analytics_models_log`
--
ALTER TABLE `mdl_analytics_models_log`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_analytics_predictions`
--
ALTER TABLE `mdl_analytics_predictions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_analytics_prediction_actions`
--
ALTER TABLE `mdl_analytics_prediction_actions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_analytics_predict_samples`
--
ALTER TABLE `mdl_analytics_predict_samples`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_analytics_train_samples`
--
ALTER TABLE `mdl_analytics_train_samples`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_analytics_used_analysables`
--
ALTER TABLE `mdl_analytics_used_analysables`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mdl_analytics_used_files`
--
ALTER TABLE `mdl_analytics_used_files`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assign`
--
ALTER TABLE `mdl_assign`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignfeedback_comments`
--
ALTER TABLE `mdl_assignfeedback_comments`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignfeedback_editpdf_annot`
--
ALTER TABLE `mdl_assignfeedback_editpdf_annot`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignfeedback_editpdf_cmnt`
--
ALTER TABLE `mdl_assignfeedback_editpdf_cmnt`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignfeedback_editpdf_queue`
--
ALTER TABLE `mdl_assignfeedback_editpdf_queue`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignfeedback_editpdf_quick`
--
ALTER TABLE `mdl_assignfeedback_editpdf_quick`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignfeedback_editpdf_rot`
--
ALTER TABLE `mdl_assignfeedback_editpdf_rot`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignfeedback_file`
--
ALTER TABLE `mdl_assignfeedback_file`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignment`
--
ALTER TABLE `mdl_assignment`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignment_submissions`
--
ALTER TABLE `mdl_assignment_submissions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignment_upgrade`
--
ALTER TABLE `mdl_assignment_upgrade`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignsubmission_file`
--
ALTER TABLE `mdl_assignsubmission_file`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assignsubmission_onlinetext`
--
ALTER TABLE `mdl_assignsubmission_onlinetext`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assign_grades`
--
ALTER TABLE `mdl_assign_grades`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assign_overrides`
--
ALTER TABLE `mdl_assign_overrides`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assign_plugin_config`
--
ALTER TABLE `mdl_assign_plugin_config`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assign_submission`
--
ALTER TABLE `mdl_assign_submission`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assign_user_flags`
--
ALTER TABLE `mdl_assign_user_flags`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assign_user_mapping`
--
ALTER TABLE `mdl_assign_user_mapping`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_attendance`
--
ALTER TABLE `mdl_attendance`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_attendance_log`
--
ALTER TABLE `mdl_attendance_log`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_attendance_rotate_passwords`
--
ALTER TABLE `mdl_attendance_rotate_passwords`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_attendance_sessions`
--
ALTER TABLE `mdl_attendance_sessions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_attendance_statuses`
--
ALTER TABLE `mdl_attendance_statuses`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mdl_attendance_tempusers`
--
ALTER TABLE `mdl_attendance_tempusers`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_attendance_warning`
--
ALTER TABLE `mdl_attendance_warning`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_attendance_warning_done`
--
ALTER TABLE `mdl_attendance_warning_done`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_auth_oauth2_linked_login`
--
ALTER TABLE `mdl_auth_oauth2_linked_login`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_backup_controllers`
--
ALTER TABLE `mdl_backup_controllers`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_backup_courses`
--
ALTER TABLE `mdl_backup_courses`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_backup_logs`
--
ALTER TABLE `mdl_backup_logs`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge`
--
ALTER TABLE `mdl_badge`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_alignment`
--
ALTER TABLE `mdl_badge_alignment`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_backpack`
--
ALTER TABLE `mdl_badge_backpack`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_criteria`
--
ALTER TABLE `mdl_badge_criteria`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_criteria_met`
--
ALTER TABLE `mdl_badge_criteria_met`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_criteria_param`
--
ALTER TABLE `mdl_badge_criteria_param`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_endorsement`
--
ALTER TABLE `mdl_badge_endorsement`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_external`
--
ALTER TABLE `mdl_badge_external`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_external_backpack`
--
ALTER TABLE `mdl_badge_external_backpack`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mdl_badge_external_identifier`
--
ALTER TABLE `mdl_badge_external_identifier`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_issued`
--
ALTER TABLE `mdl_badge_issued`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_manual_award`
--
ALTER TABLE `mdl_badge_manual_award`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_badge_related`
--
ALTER TABLE `mdl_badge_related`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_block`
--
ALTER TABLE `mdl_block`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `mdl_block_configurable_reports`
--
ALTER TABLE `mdl_block_configurable_reports`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_block_instances`
--
ALTER TABLE `mdl_block_instances`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `mdl_block_positions`
--
ALTER TABLE `mdl_block_positions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_block_recentlyaccesseditems`
--
ALTER TABLE `mdl_block_recentlyaccesseditems`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_block_recent_activity`
--
ALTER TABLE `mdl_block_recent_activity`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_block_rss_client`
--
ALTER TABLE `mdl_block_rss_client`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_blog_association`
--
ALTER TABLE `mdl_blog_association`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_blog_external`
--
ALTER TABLE `mdl_blog_external`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_book`
--
ALTER TABLE `mdl_book`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_book_chapters`
--
ALTER TABLE `mdl_book_chapters`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_cache_filters`
--
ALTER TABLE `mdl_cache_filters`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_cache_flags`
--
ALTER TABLE `mdl_cache_flags`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mdl_capabilities`
--
ALTER TABLE `mdl_capabilities`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=701;

--
-- AUTO_INCREMENT for table `mdl_chat`
--
ALTER TABLE `mdl_chat`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_chat_messages`
--
ALTER TABLE `mdl_chat_messages`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_chat_messages_current`
--
ALTER TABLE `mdl_chat_messages_current`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_chat_users`
--
ALTER TABLE `mdl_chat_users`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_checklist`
--
ALTER TABLE `mdl_checklist`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_checklist_check`
--
ALTER TABLE `mdl_checklist_check`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_checklist_comment`
--
ALTER TABLE `mdl_checklist_comment`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_checklist_item`
--
ALTER TABLE `mdl_checklist_item`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_choice`
--
ALTER TABLE `mdl_choice`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_choice_answers`
--
ALTER TABLE `mdl_choice_answers`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_choice_options`
--
ALTER TABLE `mdl_choice_options`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_cohort`
--
ALTER TABLE `mdl_cohort`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_cohort_members`
--
ALTER TABLE `mdl_cohort_members`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_comments`
--
ALTER TABLE `mdl_comments`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency`
--
ALTER TABLE `mdl_competency`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_coursecomp`
--
ALTER TABLE `mdl_competency_coursecomp`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_coursecompsetting`
--
ALTER TABLE `mdl_competency_coursecompsetting`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_evidence`
--
ALTER TABLE `mdl_competency_evidence`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_framework`
--
ALTER TABLE `mdl_competency_framework`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_modulecomp`
--
ALTER TABLE `mdl_competency_modulecomp`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_plan`
--
ALTER TABLE `mdl_competency_plan`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_plancomp`
--
ALTER TABLE `mdl_competency_plancomp`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_relatedcomp`
--
ALTER TABLE `mdl_competency_relatedcomp`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_template`
--
ALTER TABLE `mdl_competency_template`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_templatecohort`
--
ALTER TABLE `mdl_competency_templatecohort`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_templatecomp`
--
ALTER TABLE `mdl_competency_templatecomp`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_usercomp`
--
ALTER TABLE `mdl_competency_usercomp`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_usercompcourse`
--
ALTER TABLE `mdl_competency_usercompcourse`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_usercompplan`
--
ALTER TABLE `mdl_competency_usercompplan`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_userevidence`
--
ALTER TABLE `mdl_competency_userevidence`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_competency_userevidencecomp`
--
ALTER TABLE `mdl_competency_userevidencecomp`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_config`
--
ALTER TABLE `mdl_config`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=525;

--
-- AUTO_INCREMENT for table `mdl_config_log`
--
ALTER TABLE `mdl_config_log`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1668;

--
-- AUTO_INCREMENT for table `mdl_config_plugins`
--
ALTER TABLE `mdl_config_plugins`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1992;

--
-- AUTO_INCREMENT for table `mdl_context`
--
ALTER TABLE `mdl_context`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `mdl_course`
--
ALTER TABLE `mdl_course`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mdl_course_categories`
--
ALTER TABLE `mdl_course_categories`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mdl_course_completions`
--
ALTER TABLE `mdl_course_completions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_course_completion_aggr_methd`
--
ALTER TABLE `mdl_course_completion_aggr_methd`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_course_completion_criteria`
--
ALTER TABLE `mdl_course_completion_criteria`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_course_completion_crit_compl`
--
ALTER TABLE `mdl_course_completion_crit_compl`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_course_completion_defaults`
--
ALTER TABLE `mdl_course_completion_defaults`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_course_format_options`
--
ALTER TABLE `mdl_course_format_options`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mdl_course_modules`
--
ALTER TABLE `mdl_course_modules`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_course_modules_completion`
--
ALTER TABLE `mdl_course_modules_completion`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_course_published`
--
ALTER TABLE `mdl_course_published`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_course_request`
--
ALTER TABLE `mdl_course_request`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_course_sections`
--
ALTER TABLE `mdl_course_sections`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_customfield_category`
--
ALTER TABLE `mdl_customfield_category`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_customfield_data`
--
ALTER TABLE `mdl_customfield_data`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_customfield_field`
--
ALTER TABLE `mdl_customfield_field`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_data`
--
ALTER TABLE `mdl_data`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_data_content`
--
ALTER TABLE `mdl_data_content`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_data_fields`
--
ALTER TABLE `mdl_data_fields`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_data_records`
--
ALTER TABLE `mdl_data_records`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_editor_atto_autosave`
--
ALTER TABLE `mdl_editor_atto_autosave`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mdl_enrol`
--
ALTER TABLE `mdl_enrol`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_apply_applicationinfo`
--
ALTER TABLE `mdl_enrol_apply_applicationinfo`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_flatfile`
--
ALTER TABLE `mdl_enrol_flatfile`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_lti_lti2_consumer`
--
ALTER TABLE `mdl_enrol_lti_lti2_consumer`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_lti_lti2_context`
--
ALTER TABLE `mdl_enrol_lti_lti2_context`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_lti_lti2_nonce`
--
ALTER TABLE `mdl_enrol_lti_lti2_nonce`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_lti_lti2_resource_link`
--
ALTER TABLE `mdl_enrol_lti_lti2_resource_link`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_lti_lti2_share_key`
--
ALTER TABLE `mdl_enrol_lti_lti2_share_key`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_lti_lti2_tool_proxy`
--
ALTER TABLE `mdl_enrol_lti_lti2_tool_proxy`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_lti_lti2_user_result`
--
ALTER TABLE `mdl_enrol_lti_lti2_user_result`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_lti_tools`
--
ALTER TABLE `mdl_enrol_lti_tools`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_lti_tool_consumer_map`
--
ALTER TABLE `mdl_enrol_lti_tool_consumer_map`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_lti_users`
--
ALTER TABLE `mdl_enrol_lti_users`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_enrol_paypal`
--
ALTER TABLE `mdl_enrol_paypal`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_event`
--
ALTER TABLE `mdl_event`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mdl_events_handlers`
--
ALTER TABLE `mdl_events_handlers`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_events_queue`
--
ALTER TABLE `mdl_events_queue`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_events_queue_handlers`
--
ALTER TABLE `mdl_events_queue_handlers`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_event_subscriptions`
--
ALTER TABLE `mdl_event_subscriptions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_external_functions`
--
ALTER TABLE `mdl_external_functions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=605;

--
-- AUTO_INCREMENT for table `mdl_external_services`
--
ALTER TABLE `mdl_external_services`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mdl_external_services_functions`
--
ALTER TABLE `mdl_external_services_functions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=381;

--
-- AUTO_INCREMENT for table `mdl_external_services_users`
--
ALTER TABLE `mdl_external_services_users`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_external_tokens`
--
ALTER TABLE `mdl_external_tokens`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_facetoface`
--
ALTER TABLE `mdl_facetoface`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_facetoface_notice`
--
ALTER TABLE `mdl_facetoface_notice`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_facetoface_notice_data`
--
ALTER TABLE `mdl_facetoface_notice_data`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_facetoface_sessions`
--
ALTER TABLE `mdl_facetoface_sessions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_facetoface_sessions_dates`
--
ALTER TABLE `mdl_facetoface_sessions_dates`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_facetoface_session_data`
--
ALTER TABLE `mdl_facetoface_session_data`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_facetoface_session_field`
--
ALTER TABLE `mdl_facetoface_session_field`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_facetoface_session_roles`
--
ALTER TABLE `mdl_facetoface_session_roles`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_facetoface_signups`
--
ALTER TABLE `mdl_facetoface_signups`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_facetoface_signups_status`
--
ALTER TABLE `mdl_facetoface_signups_status`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_favourite`
--
ALTER TABLE `mdl_favourite`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_feedback`
--
ALTER TABLE `mdl_feedback`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_feedback_completed`
--
ALTER TABLE `mdl_feedback_completed`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_feedback_completedtmp`
--
ALTER TABLE `mdl_feedback_completedtmp`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_feedback_item`
--
ALTER TABLE `mdl_feedback_item`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_feedback_sitecourse_map`
--
ALTER TABLE `mdl_feedback_sitecourse_map`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_feedback_template`
--
ALTER TABLE `mdl_feedback_template`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_feedback_value`
--
ALTER TABLE `mdl_feedback_value`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_feedback_valuetmp`
--
ALTER TABLE `mdl_feedback_valuetmp`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_files`
--
ALTER TABLE `mdl_files`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `mdl_files_reference`
--
ALTER TABLE `mdl_files_reference`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_file_conversion`
--
ALTER TABLE `mdl_file_conversion`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_filter_active`
--
ALTER TABLE `mdl_filter_active`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mdl_filter_config`
--
ALTER TABLE `mdl_filter_config`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_folder`
--
ALTER TABLE `mdl_folder`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_forum`
--
ALTER TABLE `mdl_forum`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_forum_digests`
--
ALTER TABLE `mdl_forum_digests`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_forum_discussions`
--
ALTER TABLE `mdl_forum_discussions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_forum_discussion_subs`
--
ALTER TABLE `mdl_forum_discussion_subs`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_forum_grades`
--
ALTER TABLE `mdl_forum_grades`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_forum_posts`
--
ALTER TABLE `mdl_forum_posts`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_forum_queue`
--
ALTER TABLE `mdl_forum_queue`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_forum_read`
--
ALTER TABLE `mdl_forum_read`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_forum_subscriptions`
--
ALTER TABLE `mdl_forum_subscriptions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_forum_track_prefs`
--
ALTER TABLE `mdl_forum_track_prefs`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_glossary`
--
ALTER TABLE `mdl_glossary`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_glossary_alias`
--
ALTER TABLE `mdl_glossary_alias`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_glossary_categories`
--
ALTER TABLE `mdl_glossary_categories`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_glossary_entries`
--
ALTER TABLE `mdl_glossary_entries`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_glossary_entries_categories`
--
ALTER TABLE `mdl_glossary_entries_categories`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_glossary_formats`
--
ALTER TABLE `mdl_glossary_formats`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mdl_grade_categories`
--
ALTER TABLE `mdl_grade_categories`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_categories_history`
--
ALTER TABLE `mdl_grade_categories_history`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_grades`
--
ALTER TABLE `mdl_grade_grades`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_grades_history`
--
ALTER TABLE `mdl_grade_grades_history`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_import_newitem`
--
ALTER TABLE `mdl_grade_import_newitem`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_import_values`
--
ALTER TABLE `mdl_grade_import_values`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_items`
--
ALTER TABLE `mdl_grade_items`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_items_history`
--
ALTER TABLE `mdl_grade_items_history`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_letters`
--
ALTER TABLE `mdl_grade_letters`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_outcomes`
--
ALTER TABLE `mdl_grade_outcomes`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_outcomes_courses`
--
ALTER TABLE `mdl_grade_outcomes_courses`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_outcomes_history`
--
ALTER TABLE `mdl_grade_outcomes_history`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grade_settings`
--
ALTER TABLE `mdl_grade_settings`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_gradingform_guide_comments`
--
ALTER TABLE `mdl_gradingform_guide_comments`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_gradingform_guide_criteria`
--
ALTER TABLE `mdl_gradingform_guide_criteria`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_gradingform_guide_fillings`
--
ALTER TABLE `mdl_gradingform_guide_fillings`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_gradingform_rubric_criteria`
--
ALTER TABLE `mdl_gradingform_rubric_criteria`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_gradingform_rubric_fillings`
--
ALTER TABLE `mdl_gradingform_rubric_fillings`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_gradingform_rubric_levels`
--
ALTER TABLE `mdl_gradingform_rubric_levels`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grading_areas`
--
ALTER TABLE `mdl_grading_areas`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grading_definitions`
--
ALTER TABLE `mdl_grading_definitions`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_grading_instances`
--
ALTER TABLE `mdl_grading_instances`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_groupings`
--
ALTER TABLE `mdl_groupings`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_groupings_groups`
--
ALTER TABLE `mdl_groupings_groups`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_groups`
--
ALTER TABLE `mdl_groups`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_groups_members`
--
ALTER TABLE `mdl_groups_members`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
