-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 12:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serial_no` varchar(255) NOT NULL,
  `registration_no` varchar(255) NOT NULL,
  `admission_no` varchar(255) NOT NULL,
  `session` varchar(255) NOT NULL,
  `imageUpload` varchar(255) NOT NULL,
  `child_relation` varchar(255) NOT NULL,
  `student_name_consent` varchar(255) NOT NULL,
  `class_name_consent` varchar(255) NOT NULL,
  `student_type` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `only_child` varchar(255) NOT NULL,
  `aadhaar_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `father_qualification` varchar(255) NOT NULL,
  `father_occupation` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `mother_qualification` varchar(255) NOT NULL,
  `mother_occupation` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `whatsapp_no` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `guardian_name` varchar(255) NOT NULL,
  `guardian_relation` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `religion` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `blood_group` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `last_exam_class` varchar(255) NOT NULL,
  `last_exam_school` varchar(255) NOT NULL,
  `last_exam_year` varchar(255) NOT NULL,
  `last_exam_marks` varchar(255) NOT NULL,
  `applying_for_class` varchar(255) NOT NULL,
  `admitted_to_class` varchar(255) NOT NULL,
  `admission_date` date NOT NULL,
  `language_subject` varchar(255) NOT NULL,
  `subjects_offered` varchar(255) NOT NULL,
  `aadhaar_card` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('Pending','Approved') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_name` varchar(255) NOT NULL,
  `school_classes_id` bigint(20) UNSIGNED NOT NULL,
  `subjects_id` bigint(20) UNSIGNED NOT NULL,
  `term` varchar(255) NOT NULL,
  `exam_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `max_marks` int(11) NOT NULL,
  `pass_marks` int(11) NOT NULL,
  `session` varchar(255) DEFAULT NULL,
  `field2` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `exam_name`, `school_classes_id`, `subjects_id`, `term`, `exam_date`, `start_time`, `end_time`, `max_marks`, `pass_marks`, `session`, `field2`, `created_at`, `updated_at`) VALUES
(24, 'Hindi', 1, 8, 'Term 1', '2025-05-27', '10:14:00', '10:20:00', 100, 35, '2024-2025', NULL, '2025-05-26 23:14:30', '2025-05-26 23:14:30'),
(25, 'English', 1, 9, 'Term 1', '2025-05-22', '10:16:00', '10:20:00', 100, 35, '2024-2025', NULL, '2025-05-26 23:16:41', '2025-05-26 23:16:41'),
(26, 'Maths', 1, 10, 'Term 1', '2025-05-27', '10:18:00', '10:22:00', 100, 33, '2024-2025', NULL, '2025-05-26 23:18:28', '2025-05-26 23:18:28'),
(27, 'Science', 2, 11, 'Term 1', '2025-05-27', '10:19:00', '10:22:00', 100, 33, '2024-2025', NULL, '2025-05-26 23:19:43', '2025-05-26 23:19:43'),
(28, 'Social Science', 2, 12, 'Term 1', '2025-05-27', '10:21:00', '10:28:00', 100, 33, '2024-2025', NULL, '2025-05-26 23:22:18', '2025-05-26 23:22:18'),
(29, 'Computer', 2, 13, 'Term 1', '2025-05-27', '10:23:00', '10:28:00', 100, 35, '2024-2025', NULL, '2025-05-26 23:23:16', '2025-05-26 23:23:16'),
(30, 'Geography', 3, 14, 'Term 1', '2025-05-27', '10:24:00', '10:29:00', 100, 33, '2024-2025', NULL, '2025-05-26 23:24:17', '2025-05-26 23:24:17'),
(31, 'Sanskrit', 3, 15, 'Term 1', '2025-05-27', '10:24:00', '10:32:00', 100, 33, '2024-2025', NULL, '2025-05-26 23:25:08', '2025-05-26 23:25:08'),
(32, 'Drawing', 3, 16, 'Term 1', '2025-05-27', '10:25:00', '10:32:00', 50, 20, '2024-2025', NULL, '2025-05-26 23:25:54', '2025-05-26 23:25:54'),
(33, 'Chemistry', 4, 17, 'Term 1', '2025-05-29', '10:26:00', '10:35:00', 100, 33, '2024-2025', NULL, '2025-05-26 23:28:06', '2025-05-26 23:28:06'),
(34, 'History', 4, 18, 'Term 1', '2025-05-27', '10:30:00', '10:35:00', 100, 33, '2024-2025', NULL, '2025-05-26 23:30:40', '2025-05-26 23:30:40'),
(35, 'Maths', 4, 19, 'Term 1', '2025-05-27', '10:33:00', '10:39:00', 100, 33, '2024-2025', NULL, '2025-05-26 23:33:22', '2025-05-26 23:33:22'),
(36, 'Hindi', 1, 8, 'Term 1', '2025-05-30', '15:48:00', '15:53:00', 80, 40, '2024-2025', NULL, '2025-05-27 04:48:21', '2025-05-27 04:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `mark_from` varchar(255) NOT NULL,
  `mark_to` varchar(255) NOT NULL,
  `field1` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `grade_name`, `description`, `mark_from`, `mark_to`, `field1`, `created_at`, `updated_at`) VALUES
(1, 'A+', 'Excellent', '80', '100', NULL, '2025-05-26 04:31:15', '2025-05-26 04:31:15'),
(2, 'A', 'Very Good', '71', '79', NULL, '2025-05-26 04:31:37', '2025-05-26 04:31:37'),
(3, 'B', 'Good', '61', '70', NULL, '2025-05-26 04:32:06', '2025-05-28 06:37:43'),
(4, 'C', 'Average', '51', '60', NULL, '2025-05-26 04:32:49', '2025-05-28 06:37:55'),
(5, 'D', 'Poor', '41', '50', NULL, '2025-05-26 04:33:47', '2025-05-28 06:38:05'),
(6, 'E', 'Pass', '31', '40', NULL, '2025-05-26 04:35:00', '2025-05-28 06:38:13'),
(7, 'F', 'Fail', '1', '30', NULL, '2025-05-26 04:35:36', '2025-05-26 04:35:36');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `marks_obtained` int(11) NOT NULL,
  `sheet_image` varchar(255) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `student_id`, `exam_id`, `class_id`, `subject_id`, `marks_obtained`, `sheet_image`, `grade`, `term`, `description`, `created_at`, `updated_at`) VALUES
(16, 51, 26, 1, NULL, 61, NULL, 'B', 'Term 1', 'Good', '2025-05-28 23:12:14', '2025-05-29 00:17:13'),
(17, 54, 28, 2, NULL, 82, NULL, 'A+', 'Term 1', 'Excellent', '2025-05-28 23:12:14', '2025-05-28 23:12:14'),
(18, 55, 29, 2, NULL, 75, NULL, 'A', 'Term 1', 'Very Good', '2025-05-28 23:12:14', '2025-05-28 23:12:14'),
(19, 57, 30, 3, NULL, 83, NULL, 'A+', 'Term 1', 'Excellent', '2025-05-28 23:12:14', '2025-05-29 04:49:04'),
(20, 57, 31, 3, NULL, 44, NULL, 'D', 'Term 1', 'Poor', '2025-05-29 04:49:51', '2025-05-29 04:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2025_03_20_050439_create_sessions_table', 1),
(7, '2025_03_20_052755_create_permission_tables', 1),
(8, '2025_03_21_084931_create_teachers_table', 1),
(9, '2025_03_22_065853_create_school_classes_table', 1),
(10, '2025_03_22_075829_create_students_table', 1),
(11, '2025_04_23_042954_create_admissions_table', 1),
(12, '2025_05_15_093806_add_status_to_admissions_table', 1),
(13, '2025_05_19_043814_create_subjects_table', 1),
(14, '2025_05_21_062434_create_exams_table', 1),
(15, '2025_05_23_080114_create_grades_table', 1),
(16, '2025_05_24_060928_create_marks_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-05-26 04:09:46', '2025-05-26 04:09:46'),
(2, 'teacher', 'web', '2025-05-26 04:09:46', '2025-05-26 04:09:46'),
(3, 'student', 'web', '2025-05-26 04:09:46', '2025-05-26 04:09:46');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_classes`
--

CREATE TABLE `school_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_classes`
--

INSERT INTO `school_classes` (`id`, `name`, `capacity`, `created_at`, `updated_at`) VALUES
(1, 'Nursery-A', 39, '2025-05-26 04:09:47', '2025-05-26 04:09:47'),
(2, 'Nursery-B', 22, '2025-05-26 04:09:47', '2025-05-26 04:09:47'),
(3, 'KG-A', 39, '2025-05-26 04:09:47', '2025-05-26 04:09:47'),
(4, 'KG-B', 26, '2025-05-26 04:09:47', '2025-05-26 04:09:47'),
(5, '1st-A', 35, '2025-05-26 04:09:47', '2025-05-26 04:09:47'),
(6, '1st-B', 30, '2025-05-26 04:09:47', '2025-05-26 04:09:47'),
(7, '2nd-A', 32, '2025-05-26 05:54:32', '2025-05-26 05:54:41'),
(8, '2nd-B', 30, '2025-05-26 05:55:11', '2025-05-26 05:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('UkYAl5lXeSAHr8iBU04F2dVij4gMelEUfg3YU35S', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZk1rWkYzd05LRlNDbWVBUFc1a0RobGY2cHBISDExTFk2S2JMNHdHMSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vbWFya3MvYnktc3R1ZGVudCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1748515083);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `email`, `phone`, `dob`, `gender`, `address`, `class_id`, `created_at`, `updated_at`) VALUES
(51, 'Ankita', 'Kumari', 'ankita@a.com', '6565252535', '2016-11-26', 'Male', 'zzzz', 1, '2025-05-26 06:47:33', '2025-05-26 06:47:33'),
(52, 'Kirti Singh', NULL, 'kirti@k.com', '8877559996', '2020-05-13', 'Female', 'cccc', 1, '2025-05-26 06:49:16', '2025-05-26 06:49:16'),
(53, 'Aradhya', NULL, 'aradhya@a.com', '2525656535', '2019-10-21', 'Male', 'vvvv', 1, '2025-05-26 06:50:23', '2025-05-26 06:50:23'),
(54, 'Aniket', NULL, 'aniket@a.com', '7788444444', '2020-09-22', 'Male', 'bbbb', 2, '2025-05-26 06:51:45', '2025-05-26 06:51:45'),
(55, 'Riyansh', NULL, 'riyansh@r.com', '2020131333', '2021-11-25', 'Male', 'nnnn', 2, '2025-05-26 06:53:36', '2025-05-26 06:53:36'),
(56, 'kridha', NULL, 'kridha@k.com', '2233222222', '2018-07-23', 'Male', 'mmmm', 2, '2025-05-26 06:55:22', '2025-05-26 06:55:22'),
(57, 'Ishant', NULL, 'ishant@i.com', '6895243179', '2020-10-28', 'Male', 'qqqq', 3, '2025-05-26 06:57:25', '2025-05-26 06:57:25'),
(58, 'Ujjwal', NULL, 'ujjwal@u.com', '7874499667', '2021-08-30', 'Male', 'szdf', 3, '2025-05-26 06:58:46', '2025-05-26 06:58:46'),
(59, 'abhishek', NULL, 'abhishek@a.com', '3396452211', '2017-03-28', 'Male', 'hkjlo', 3, '2025-05-26 06:59:56', '2025-05-26 06:59:56'),
(60, 'Himan', NULL, 'himan@h.com', '8668997710', '2019-10-28', 'Male', 'ntyh', 4, '2025-05-26 22:18:45', '2025-05-26 22:18:45'),
(61, 'Atul', NULL, 'atul@a.com', '1441102367', '2020-09-28', 'Male', 'jhkhy', 4, '2025-05-26 22:19:58', '2025-05-26 22:19:58'),
(62, 'Lavanya', NULL, 'lavanya@l.com', '6566332211', '2021-05-24', 'Female', 'hukui', 4, '2025-05-26 22:22:32', '2025-05-26 22:22:32'),
(63, 'Rahul', NULL, 'rahul@r.com', '4512451211', '2021-11-15', 'Male', 'yijyuji', 5, '2025-05-26 22:24:32', '2025-05-26 22:24:32'),
(64, 'Ashi', NULL, 'ashi@a.com', '6546541230', '2019-10-21', 'Female', 'fgetr', 5, '2025-05-26 22:34:27', '2025-05-26 22:34:27'),
(65, 'Kanak', NULL, 'kanak@k.com', '5522114477', '2014-12-30', 'Female', 'asdfe', 5, '2025-05-26 22:37:03', '2025-05-26 22:37:03'),
(66, 'Kunal', NULL, 'kunal@k.com', '8520145899', '2021-02-09', 'Male', 'dhy', 6, '2025-05-26 22:42:00', '2025-05-26 22:42:00'),
(67, 'Himanshu', NULL, 'himanshu@h.com', '7532159860', '2019-08-27', 'Male', 'sdfdruy', 6, '2025-05-26 22:44:40', '2025-05-26 22:44:40'),
(68, 'Vaibhav', NULL, 'vaibhav@v.com', '9884562103', '2018-10-22', 'Male', 'dnmrb', 6, '2025-05-26 22:46:50', '2025-05-26 22:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `short_name`, `class_id`, `teacher_id`, `created_at`, `updated_at`) VALUES
(8, 'Hindi', 'Hindi', 1, 26, '2025-05-26 22:53:29', '2025-05-26 22:54:56'),
(9, 'English', 'Eng', 1, 40, '2025-05-26 22:54:18', '2025-05-26 22:54:18'),
(10, 'Maths', 'Maths', 1, 30, '2025-05-26 22:54:46', '2025-05-26 22:54:46'),
(11, 'Science', 'Science', 2, 32, '2025-05-26 22:55:43', '2025-05-26 22:55:43'),
(12, 'Social Science', 'SS', 2, 38, '2025-05-26 22:56:27', '2025-05-26 22:56:27'),
(13, 'Computer', 'Comp', 2, 31, '2025-05-26 22:58:05', '2025-05-26 22:58:05'),
(14, 'Geography', 'Geo', 3, 38, '2025-05-26 22:59:02', '2025-05-26 22:59:02'),
(15, 'Sanskrit', 'Sans', 3, 28, '2025-05-26 23:00:28', '2025-05-26 23:00:28'),
(16, 'Drawing', 'Drawing', 3, 33, '2025-05-26 23:01:05', '2025-05-26 23:01:05'),
(17, 'Chemistry', 'Chem', 4, 32, '2025-05-26 23:02:23', '2025-05-26 23:02:23'),
(18, 'History', 'Hist', 4, 27, '2025-05-26 23:03:44', '2025-05-26 23:03:44'),
(19, 'Maths', 'Maths', 4, 30, '2025-05-26 23:04:47', '2025-05-26 23:04:47'),
(20, 'Business', 'Buss', 5, 34, '2025-05-26 23:05:24', '2025-05-26 23:05:24'),
(21, 'Biography', 'Bio', 5, 35, '2025-05-26 23:07:54', '2025-05-26 23:07:54'),
(22, 'English', 'Eng', 5, 41, '2025-05-26 23:09:04', '2025-05-26 23:09:04'),
(23, 'Accounts', 'Acc', 6, 39, '2025-05-26 23:10:00', '2025-05-26 23:10:00'),
(24, 'Maths', 'Maths', 6, 30, '2025-05-26 23:12:15', '2025-05-26 23:12:15'),
(25, 'Business', 'Busi', 6, 34, '2025-05-26 23:13:04', '2025-05-26 23:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `phone`, `qualification`, `subject`, `address`, `created_at`, `updated_at`) VALUES
(26, 'Anita Rawat', 'anita@a.com', '4545656522', 'M.Ed', 'Hindi', NULL, '2025-05-26 06:09:53', '2025-05-26 06:09:53'),
(27, 'Meena Badola', 'meena@b.com', '7878989855', 'B.Ed', 'History', NULL, '2025-05-26 06:10:51', '2025-05-26 06:10:51'),
(28, 'Astha kashyap', 'astha@as.com', '6363232321', 'BA', 'Sanskrit', NULL, '2025-05-26 06:12:28', '2025-05-26 06:12:28'),
(29, 'Anurag Singh', 'anurag@anu.com', '5555888899', 'BSc', 'Physics', NULL, '2025-05-26 06:13:22', '2025-05-26 06:13:22'),
(30, 'Mayank Kumar', 'mayank@m.com', '7474141477', 'Hons. in Mathematics', 'Maths', NULL, '2025-05-26 06:15:23', '2025-05-26 06:15:23'),
(31, 'Suraj Raj', 'suraj@s.com', '6363969611', 'BIT', 'Computer', NULL, '2025-05-26 06:18:52', '2025-05-26 06:18:52'),
(32, 'Nikita Rani', 'nikita@n.com', '1515252544', 'BES', 'Chemistry', NULL, '2025-05-26 06:20:24', '2025-05-26 06:20:24'),
(33, 'Disha Prakash', 'disha@d.com', '7777711111', 'BA', 'Drawing', NULL, '2025-05-26 06:21:19', '2025-05-26 06:21:19'),
(34, 'Aditi Singh', 'aditi@a.com', '0000000000', 'BBA', 'Business', NULL, '2025-05-26 06:22:34', '2025-05-26 06:34:30'),
(35, 'Asha Kumari', 'asha@a.com', '3131311100', 'BPharma', 'Bio', NULL, '2025-05-26 06:35:54', '2025-05-26 06:35:54'),
(36, 'Anuj Singh', 'anuj@a.com', '1199119911', 'BMath', 'Maths', NULL, '2025-05-26 06:36:59', '2025-05-26 06:36:59'),
(37, 'Kajal Sharma', 'kajal@k.com', '8822882288', 'BA', 'Hindi', NULL, '2025-05-26 06:39:06', '2025-05-26 06:39:06'),
(38, 'Ajay Rana', 'ajay@gmail.com', '0011001100', 'BES', 'Geography', NULL, '2025-05-26 06:40:15', '2025-05-26 06:40:15'),
(39, 'Vandana Diwedi', 'vandana@v.com', '6666555522', 'BFA', 'Accounts', NULL, '2025-05-26 06:41:17', '2025-05-26 06:41:17'),
(40, 'Kritika Singh', 'kritika@k.com', '5544554545', 'BA', 'English', NULL, '2025-05-26 06:42:13', '2025-05-26 06:42:13'),
(41, 'Meenakshi Yadav', 'mee@m.com', '8877575756', 'MBA', 'English', NULL, '2025-05-26 06:44:44', '2025-05-26 06:44:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'niharikawebbrain@gmail.com', '2025-05-26 04:09:47', '$2y$10$AAQdDNkndy7eok33EBYcCO27moEORjHFQ3qXF.RItOqaJzTN5fk4m', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-26 04:09:47', '2025-05-26 04:09:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admissions_serial_no_unique` (`serial_no`),
  ADD UNIQUE KEY `admissions_registration_no_unique` (`registration_no`),
  ADD UNIQUE KEY `admissions_admission_no_unique` (`admission_no`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_school_classes_id_foreign` (`school_classes_id`),
  ADD KEY `exams_subjects_id_foreign` (`subjects_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marks_student_id_exam_id_subject_id_class_id_unique` (`student_id`,`exam_id`,`subject_id`,`class_id`),
  ADD KEY `marks_exam_id_foreign` (`exam_id`),
  ADD KEY `marks_class_id_foreign` (`class_id`),
  ADD KEY `marks_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `school_classes`
--
ALTER TABLE `school_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school_classes_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_email_unique` (`email`),
  ADD UNIQUE KEY `students_phone_unique` (`phone`),
  ADD KEY `students_class_id_foreign` (`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_class_id_foreign` (`class_id`),
  ADD KEY `subjects_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `school_classes`
--
ALTER TABLE `school_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_school_classes_id_foreign` FOREIGN KEY (`school_classes_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_subjects_id_foreign` FOREIGN KEY (`subjects_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subjects_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
