-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 31, 2026 at 06:39 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `modernerp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `phone`, `status`, `type`, `password`, `date`, `company_id`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'owner@app.com', '2026-05-02 13:00:42', '726.712.6600', 'active', 'owner', '$2y$12$uWR/6g/qDlA8BdUrJmi8ee7T/uyACEG0hsHuPnGhOmbjEFREayUGG', '2011-03-13', NULL, 'B2aYgFQ3TgdcttMZ4d0fzrn1iANsW6vIXzP2ACZ3t3M2sA3f1t9amp1w61Qe', NULL, '2026-05-02 13:00:42', '2026-05-02 13:00:42'),
(2, 'Mariane Baumbach', 'jeanette.littel@example.net', '2026-05-02 13:00:43', '239.349.1557', 'active', 'branch_admin', '$2y$12$wfGKXcH.KBv.V8bCe6dhVOae5ukSLbqQEcbpGBTWDp3cgt7fhR5b6', '1982-01-04', 1, 'FOGlLJ8YMOtWEsGFIcD9gi6wAtzPwSxcZcl2Hf38x6ACOEuiZYsUijMWL20y', NULL, '2026-05-02 13:00:49', '2026-05-02 13:00:49'),
(3, 'Albertha Fritsch IV', 'marielle.rempel@example.org', '2026-05-02 13:00:43', '618.600.5597', 'blocked', 'branch_admin', '$2y$12$.QjRx1O044DnOCKF/9HRpexKrbwYCCzjnUkZWJb4/A.aYUV75w1na', '2011-08-26', NULL, 'tHk7o15cGA', NULL, '2026-05-02 13:00:50', '2026-05-02 13:00:50'),
(4, 'Ansley Trantow', 'reilly.laila@example.net', '2026-05-02 13:00:44', '+1-253-696-8936', 'inactive', 'company_admin', '$2y$12$9A5d78alauyUYO9sGOz9WOyKvSGf1/QBEbMMpLKdJjePaTT13uVea', '1989-05-15', NULL, 'u3hVatsM4s', NULL, '2026-05-02 13:00:52', '2026-05-02 13:00:52'),
(5, 'Berry Waelchi IV', 'bayer.tina@example.net', '2026-05-02 13:00:44', '620-376-0471', 'blocked', 'branch_admin', '$2y$12$spAmiaBhZM6nT3PR3tC5Z.cAQlNQNMoJX900tqFtKOh0pydRY1woC', '2004-12-28', NULL, 'mkxUnYbPj5', NULL, '2026-05-02 13:00:53', '2026-05-02 13:00:53'),
(6, 'Prof. Willis Medhurst', 'rudy76@example.com', '2026-05-02 13:00:44', '(330) 545-8029', 'active', 'branch_admin', '$2y$12$u3KO11peJ/nZXXLP7QLjvuL13kJQ4ribaHdAIlMkpUeNZ..hL44G.', '2021-09-11', NULL, '6xXqvgeZVW', NULL, '2026-05-02 13:00:54', '2026-05-02 13:00:54'),
(7, 'Tyrel Spinka', 'grant.creola@example.com', '2026-05-02 13:00:45', '+12249294015', 'inactive', 'company_admin', '$2y$12$GPZxijp1LLZ/yfEDZDHkK.8IhmgHiPsHHpiKAdkH5M9aDq6SKXTz6', '1978-09-10', NULL, 'D0dcsPbXxF', NULL, '2026-05-02 13:01:04', '2026-05-02 13:01:04'),
(8, 'Jalon Collins', 'hackett.angelica@example.com', '2026-05-02 13:00:45', '1-828-339-3327', 'inactive', 'branch_admin', '$2y$12$69wXRzLZyoEcWbfhRFMPs.pJI3oN9Xhtab82Gs4vvffXUyfbHpYiG', '2010-08-25', NULL, '44p7s6liGc', NULL, '2026-05-02 13:01:19', '2026-05-02 13:01:19'),
(9, 'Ransom Rempel', 'toy.rebecca@example.com', '2026-05-02 13:00:45', '380-472-1925', 'inactive', 'company_admin', '$2y$12$QNAakr7NDzDLnT9Al6lugOgiNif/eSGZNsNZIsIPw6KxB2lvXlHcK', '1999-06-27', NULL, 'jvp4sdmf50', NULL, '2026-05-02 13:01:19', '2026-05-02 13:01:19'),
(10, 'Marlee Miller Sr.', 'ova55@example.com', '2026-05-02 13:00:45', '640-329-8053', 'active', 'branch_admin', '$2y$12$Lqq8nP7uC4qCPzVM/yxAAe4v5daL74zKj0tdjDoyAkj5rbFh9GrCW', '1975-05-19', NULL, '71sa3kflnf', NULL, '2026-05-02 13:01:19', '2026-05-02 13:01:19'),
(11, 'Erin Borer', 'corbin.bogan@example.com', '2026-05-02 13:00:46', '234.436.4537', 'inactive', 'company_admin', '$2y$12$WkKgd1TGSVimJywuDwJq8OZRu5ONsMBVhLH.Gh0JbdvRJK5emjWXq', '2000-07-02', NULL, 'b4bi5LVfQm', NULL, '2026-05-02 13:01:20', '2026-05-02 13:01:20'),
(12, 'Jany Langosh', 'rpurdy@example.com', '2026-05-02 13:00:46', '+1 (956) 671-1698', 'inactive', 'company_admin', '$2y$12$5xMfjC6HYzTo6FN.QARgfOLO9za8BvneEyTPo8aadHQ.uU.MELgfG', '2003-03-17', NULL, 'v5fuZOCYnp', NULL, '2026-05-02 13:01:20', '2026-05-02 13:01:20'),
(13, 'Francis Lubowitz', 'theresa.cummings@example.net', '2026-05-02 13:00:46', '+18586449317', 'blocked', 'company_admin', '$2y$12$PxOMRWpKPsmvAkDLXE4p0O6WZZQ5LjPHWR14AXSxNLEf1OkXGOASW', '2026-03-09', NULL, 'D12wUamJLG', NULL, '2026-05-02 13:01:20', '2026-05-02 13:01:20'),
(14, 'Leone Schulist', 'ruthe73@example.net', '2026-05-02 13:00:47', '+1.319.806.3219', 'active', 'company_admin', '$2y$12$o1RCpW062FNm1vEXjff01uPp86GbCym/Fhv0FjqrpmnfbGpu4Ux/e', '2012-08-23', NULL, 'lW6NoVdOxd', NULL, '2026-05-02 13:01:20', '2026-05-02 13:01:20'),
(15, 'Adonis Walker', 'wyman.ruecker@example.net', '2026-05-02 13:00:47', '+1-551-619-9142', 'inactive', 'branch_admin', '$2y$12$6.5tv5Tx0iVy8DTnwQ5ff.PYv2N/3UUMKb8Sq27BVvgWIZ5TfD7Tu', '2023-07-09', NULL, 'kc1VcDKDrd', NULL, '2026-05-02 13:01:21', '2026-05-02 13:01:21'),
(16, 'Dr. Dianna Gislason Jr.', 'lea17@example.net', '2026-05-02 13:00:47', '314.432.6919', 'blocked', 'branch_admin', '$2y$12$TbFv4xmallqXkPdUkV9.g.ldnZSCeSYKOtV0p3G100cNyAs568bLW', '2008-10-13', NULL, 'f4hguYSJQE', NULL, '2026-05-02 13:01:22', '2026-05-02 13:01:22'),
(17, 'Prof. Lindsey Kshlerin I', 'darlene.labadie@example.org', '2026-05-02 13:00:47', '504.864.6286', 'active', 'branch_admin', '$2y$12$cNjv3Dw/Alwjrf0FR592IOwK6PMSF2nCBPL3dLCo68GaMGTfX/ERK', '1997-09-08', NULL, 'EbfCSK5hVG', NULL, '2026-05-02 13:01:37', '2026-05-02 13:01:37'),
(18, 'Colton Jacobs', 'norval.kutch@example.net', '2026-05-02 13:00:48', '301-752-4368', 'active', 'branch_admin', '$2y$12$AQDeS2o2lr0cJczZuBvA3eA6aic3a.m4bJTTJo6zTxfFDsm.wI.PG', '1988-06-14', NULL, 'uuVFKIsQur', NULL, '2026-05-02 13:01:53', '2026-05-02 13:01:53'),
(19, 'Henri Fahey', 'maggio.tanner@example.net', '2026-05-02 13:00:48', '763-416-1956', 'active', 'company_admin', '$2y$12$Mb5f8MVSRlI5JzXLlhMBuuGcU8x8j5p6CuchT2mXr7.dLMsIyVMCO', '1994-12-03', NULL, 'DzquF0FLsO', NULL, '2026-05-02 13:01:54', '2026-05-02 13:01:54'),
(20, 'Celestino Cormier', 'bosco.maye@example.org', '2026-05-02 13:00:48', '+1.731.965.4001', 'blocked', 'company_admin', '$2y$12$KHT8w9LcfqFoNaSYnHSaFOYV0rL/H7bIUZFgsOErg70E43JAdSsVe', '1995-12-01', NULL, 'afXjxH4Vho', NULL, '2026-05-02 13:01:55', '2026-05-02 13:01:55'),
(21, 'Janet Rowe Sr.', 'hallie.schaefer@example.net', '2026-05-02 13:00:49', '1-838-859-0291', 'blocked', 'branch_admin', '$2y$12$Jp4W7Ra2H1nLOk53w8G7yO67uMJxFtObZi5SEV2JEDemlCrjUrI5a', '2010-08-07', NULL, 'XsQkAsfOgE', NULL, '2026-05-02 13:01:55', '2026-05-02 13:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `admin_panel_settings`
--

CREATE TABLE `admin_panel_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by_id` bigint UNSIGNED DEFAULT NULL,
  `updated_by_id` bigint UNSIGNED DEFAULT NULL,
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_panel_settings`
--

INSERT INTO `admin_panel_settings` (`id`, `uuid`, `system_status`, `company_name`, `address`, `phone`, `email`, `added_by_id`, `updated_by_id`, `company_id`, `created_at`, `updated_at`) VALUES
(1, '1c977e91-a5d2-405f-89b9-3c25df260388', 'active', 'tag-soft', NULL, '01015558628', 'info@tag-soft.com', NULL, NULL, NULL, '2026-05-06 15:01:42', '2026-05-06 15:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `admin_profiles`
--

CREATE TABLE `admin_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `admin_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_profiles`
--

INSERT INTO `admin_profiles` (`id`, `uuid`, `address`, `bio`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, '998d4610-dc1a-4a63-b8fd-364725a8c533', NULL, NULL, 1, '2026-05-02 13:00:42', '2026-05-02 13:00:42'),
(2, '339aaa99-a4a3-41ba-91c4-671a87344e64', NULL, NULL, 2, '2026-05-02 13:00:49', '2026-05-02 13:00:49'),
(3, 'b471a875-72bb-4597-abbc-6e781d51115d', NULL, NULL, 3, '2026-05-02 13:00:51', '2026-05-02 13:00:51'),
(4, 'd7bdeea0-1ca5-411c-8df1-614d49e0eaaf', NULL, NULL, 4, '2026-05-02 13:00:52', '2026-05-02 13:00:52'),
(5, '7aec0ee2-e15e-41d9-920b-462eb6548e9c', NULL, NULL, 5, '2026-05-02 13:00:53', '2026-05-02 13:00:53'),
(6, '2fe222fb-d086-4c19-adbb-7fce8df6ed08', NULL, NULL, 6, '2026-05-02 13:00:57', '2026-05-02 13:00:57'),
(7, '3506bf51-3cf9-4f60-9180-536b56b1c776', NULL, NULL, 7, '2026-05-02 13:01:19', '2026-05-02 13:01:19'),
(8, 'de7879f6-5bab-42e0-9148-20c9376cb009', NULL, NULL, 8, '2026-05-02 13:01:19', '2026-05-02 13:01:19'),
(9, '75b62bb7-8b5e-4461-a83e-59d60486b071', NULL, NULL, 9, '2026-05-02 13:01:19', '2026-05-02 13:01:19'),
(10, '164ae59a-0535-4cc6-b73a-470ff46097da', NULL, NULL, 10, '2026-05-02 13:01:20', '2026-05-02 13:01:20'),
(11, 'ee5a3a3c-afdc-4583-877b-bd5f8812153d', NULL, NULL, 11, '2026-05-02 13:01:20', '2026-05-02 13:01:20'),
(12, 'ebc10bd4-0cf3-4033-9470-6905f1b37a0c', NULL, NULL, 12, '2026-05-02 13:01:20', '2026-05-02 13:01:20'),
(13, 'a74ebab7-e7b3-4a28-ace2-a2c30f9ff465', NULL, NULL, 13, '2026-05-02 13:01:20', '2026-05-02 13:01:20'),
(14, '4bbc73de-7fab-43bf-b65d-24bec37b09cc', NULL, NULL, 14, '2026-05-02 13:01:21', '2026-05-02 13:01:21'),
(15, 'adf147a6-e068-4b77-9736-ae86ee19e7f2', NULL, NULL, 15, '2026-05-02 13:01:21', '2026-05-02 13:01:21'),
(16, '9ed46b51-bc34-4e9c-856d-05853acd4cbd', NULL, NULL, 16, '2026-05-02 13:01:27', '2026-05-02 13:01:27'),
(17, '0d9e321e-de12-47ca-b1ce-ad5c6c56566a', NULL, NULL, 17, '2026-05-02 13:01:46', '2026-05-02 13:01:46'),
(18, 'd4fbd432-1519-4e17-830d-e93386cf659f', NULL, NULL, 18, '2026-05-02 13:01:54', '2026-05-02 13:01:54'),
(19, 'e35e1255-2824-47d2-abd0-d999196da594', NULL, NULL, 19, '2026-05-02 13:01:54', '2026-05-02 13:01:54'),
(20, '2e1fca24-5811-4b1e-9c2e-29e7d376a157', NULL, NULL, 20, '2026-05-02 13:01:55', '2026-05-02 13:01:55'),
(21, 'fd140091-a612-4112-9062-06430577893e', NULL, NULL, 21, '2026-05-02 13:01:56', '2026-05-02 13:01:56');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Shea Kreiger', 'meta.cormier@example.net', NULL, '$2y$12$aewxZ/DgWdDI5E2DnD4LVuSKfQwIp8SCiiabNWJrHwvphxNTluj0O', '848-454-8530', 'blocked', NULL, '2026-05-02 13:00:27', '2026-05-02 13:00:27'),
(2, 'Mr. Jocelyn Rau MD', 'gmraz@example.com', NULL, '$2y$12$7DaOhKLVlv7pj3SO.lvOQu/GGmCjiNHLLthWyRnS8eXdFj32ulJ9C', '+1 (570) 572-0035', 'blocked', NULL, '2026-05-02 13:00:27', '2026-05-02 13:00:27'),
(3, 'Malcolm Senger', 'bashirian.nikki@example.net', NULL, '$2y$12$Gmzx7zNexoa/BMv3aMz.UeFLpPl4WAwq7xpsze8J8nEjV8aIga4Ei', '(531) 845-0131', 'active', NULL, '2026-05-02 13:00:27', '2026-05-02 13:00:27'),
(4, 'Consuelo Jast', 'molly94@example.com', NULL, '$2y$12$TKHgpyTW88apPFegeT/A8evcis6GhHV4F0hg2c98syok0fc5VV0h.', '+1-551-527-4347', 'blocked', NULL, '2026-05-02 13:00:27', '2026-05-02 13:00:27'),
(5, 'Mrs. Gail Ruecker', 'berneice.rath@example.net', NULL, '$2y$12$a0zrUal4bUhH7UHFTTKRcOGAGER4SR1woNaBOV.JfMnv7FTlhO80q', '1-225-555-1160', 'inactive', NULL, '2026-05-02 13:00:27', '2026-05-02 13:00:27'),
(6, 'Kelvin Roberts', 'hazle15@example.com', NULL, '$2y$12$Rs5IG1d5/d9l/RRFJILIW.CrvzXC6RjrqO2c9IzJBc0uCXi.pX9HS', '856-208-8505', 'inactive', NULL, '2026-05-02 13:00:27', '2026-05-02 13:00:27'),
(7, 'Braden Stehr', 'predovic.abel@example.org', NULL, '$2y$12$IFwNrl.3hpUQA2ouA91yqOydU4pZ3rplQlMnOzJzg5gt5BmSA9aAq', '(740) 969-5827', 'active', NULL, '2026-05-02 13:00:28', '2026-05-15 04:49:52'),
(8, 'Conner Reichert', 'jacobs.lina@example.org', NULL, '$2y$12$5RoUjBLiiWknHULcLw5kEeQDceysKUFv/LO/zLusPZhOt9eNTpxz.', '870-797-8309', 'active', NULL, '2026-05-02 13:00:28', '2026-05-02 13:00:28'),
(9, 'Prof. Austyn Herman V', 'terry.oleta@example.com', NULL, '$2y$12$6y80OrX6X7Zxr4lLGW7XZ.TwnUVzC2dND.NHNzn8Jft8eEft3wP5y', '505.802.3607', 'blocked', NULL, '2026-05-02 13:00:28', '2026-05-02 13:00:28'),
(10, 'Mrs. Germaine Weber IV', 'maverick.oconner@example.com', NULL, '$2y$12$CuNjk5wcjJpCF6/KpDRkSex/u80bTnvVenzpQLw61JXfThMKZXxB6', '(610) 724-4962', 'inactive', NULL, '2026-05-02 13:00:28', '2026-05-02 13:00:28'),
(11, 'Test Client', 'test@client.com', NULL, '$2y$12$ZeJ.ZpwCms6IpWJsLYn9auftkNSFw0cQNYzMFs5sEk2xcBWyCOcyO', '1-815-378-5344', 'active', NULL, '2026-05-02 13:00:28', '2026-05-02 13:00:28');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `client_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `email`, `email_verified_at`, `phone`, `status`, `password`, `date`, `remember_token`, `deleted_at`, `created_at`, `updated_at`, `client_id`) VALUES
(1, 'Mayert, Russel and Hoppe', 'alexa42@example.org', '2026-05-02 13:00:29', '+1 (804) 369-9719', 'active', '$2y$12$jn5307o7SZEf4Ptztiv3feRXYyxORHJp610VB/lYhygQ3AdiArska', '2005-02-19', 'tHihV2eIYK', NULL, '2026-05-02 13:00:31', '2026-05-02 13:00:31', NULL),
(2, 'Schumm, Kihn and Feest', 'joan80@example.net', '2026-05-02 13:00:29', '719-473-2587', 'active', '$2y$12$QGKyZMXh3RP3voTaYB8Bu.QRUmKX2RlPsHjzUsa/3/tkpFRJv.VZK', '1977-09-24', 'NWKSpp5n53', NULL, '2026-05-02 13:00:32', '2026-05-02 13:00:32', NULL),
(3, 'McKenzie, Dietrich and Thompson', 'laurine37@example.net', '2026-05-02 13:00:29', '+1 (443) 437-2233', 'active', '$2y$12$aFUhoeKyOFmo2myCACYfD.aLJ5NbwE8P.bmWlNMfyzrqnibVEKKmO', '1972-07-20', 'e3v4LGPL7F', NULL, '2026-05-02 13:00:33', '2026-05-02 13:00:33', NULL),
(4, 'Larson Group', 'mohr.danyka@example.net', '2026-05-02 13:00:30', '+16608786940', 'blocked', '$2y$12$K20Ab5DAVxttWabO8W3jV.ueWAjg9xafIOgkzVE1P4uuUQ8QhXqWa', '1999-09-02', 'Ly0M6DaX9V', NULL, '2026-05-02 13:00:34', '2026-05-02 13:00:34', NULL),
(5, 'Mann-Swift', 'mcarter@example.com', '2026-05-02 13:00:30', '(352) 316-9950', 'blocked', '$2y$12$h8YDMbVPoVo31FrslbfS/Ov52lHhkZmJAa/U00BJrbloAliTzPSC6', '2007-06-22', 'EUVg6awMSN', NULL, '2026-05-02 13:00:35', '2026-05-02 13:00:35', NULL),
(6, 'Schuster-Macejkovic', 'feil.grace@example.com', '2026-05-02 13:00:30', '774.957.1872', 'inactive', '$2y$12$SW4xxy4iANBhSZKZ39pcYuXQuCYly6.kAguA9HhYG8r9OZHI66T/K', '2012-09-08', 'nXGjiWlupI', NULL, '2026-05-02 13:00:37', '2026-05-02 13:00:37', NULL),
(7, 'Waelchi, Kub and Pouros', 'kovacek.janice@example.org', '2026-05-02 13:00:30', '+19039139534', 'blocked', '$2y$12$CZw1qhbaS0qWUE9WFAYuYuAN/Q.WXOO9wmXk11kYAidmiJca8QDd6', '1986-07-04', 'danUiT1Rxy', NULL, '2026-05-02 13:00:40', '2026-05-02 13:00:40', NULL),
(8, 'Bahringer, Torphy and Fritsch', 'braxton40@example.net', '2026-05-02 13:00:31', '+19205405758', 'blocked', '$2y$12$eApL8F6SBk03hdrmFUTsVOR6bUcGDeJKkwHoch4xtY86jvbxr2/oq', '2003-10-03', 'KgbaOVeJ3A', NULL, '2026-05-02 13:00:40', '2026-05-02 13:00:40', NULL),
(9, 'Purdy, Hirthe and Rohan', 'marty03@example.net', '2026-05-02 13:00:31', '1-747-986-8169', 'active', '$2y$12$93/2mSLfbj1imj0vFhHTlO8X12ghnMGVA8EKdtgi/rlSqV59Fm4eG', '2011-05-23', 'FcrNwfWrpz', NULL, '2026-05-02 13:00:40', '2026-05-02 13:00:40', NULL),
(10, 'Moen Group', 'dante36@example.org', '2026-05-02 13:00:31', '606.930.1771', 'blocked', '$2y$12$xIgvnUjP.fUjrY.rvO3uy.ypu3clSZeOKjCs8gWqynvduw3mTN/ju', '2011-02-26', 'dMMNBwEvk0', NULL, '2026-05-02 13:00:41', '2026-05-02 13:00:41', NULL),
(11, 'Test Company', 'test@company.com', '2026-05-02 13:00:41', '740.593.0676', 'active', '$2y$12$IBwcN2lKj84h.viXmztht.zU2FWW7PtqL6tFvomtEcVXeKkdasN5C', '2011-02-12', 'f64fMWSs1u', NULL, '2026-05-02 13:00:41', '2026-05-02 13:00:41', NULL),
(12, 'xyz', 'xyz@test.com', NULL, '123456789789', 'active', '$2y$12$uWR/6g/qDlA8BdUrJmi8ee7T/uyACEG0hsHuPnGhOmb...', NULL, NULL, NULL, '2026-05-15 04:46:51', '2026-05-15 04:49:26', 7);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_uoms`
--

CREATE TABLE `inv_uoms` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'الحالة',
  `is_master` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'نوع الوحدة: رئيسية أو فرعية',
  `date` date DEFAULT NULL,
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول وحدات القياس';

--
-- Dumping data for table `inv_uoms`
--

INSERT INTO `inv_uoms` (`id`, `uuid`, `is_active`, `is_master`, `date`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '00030e4a-3fe6-40a0-8d44-43bfa64fa8da', 0, 1, '2026-05-27', 1, 1, NULL, '2026-05-15 04:05:20', '2026-05-15 04:05:20'),
(2, '50ea753b-3c84-497c-8884-d36567f7481b', 1, 1, NULL, 1, 2, NULL, '2026-05-15 04:11:30', '2026-05-15 04:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `inv_uom_translations`
--

CREATE TABLE `inv_uom_translations` (
  `id` bigint UNSIGNED NOT NULL,
  `inv_uom_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'اسم الوحدة'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول ترجمات وحدات القياس';

--
-- Dumping data for table `inv_uom_translations`
--

INSERT INTO `inv_uom_translations` (`id`, `inv_uom_id`, `locale`, `name`) VALUES
(1, 1, 'ar', 'شش'),
(2, 1, 'en', 'aaa'),
(3, 2, 'ar', 'سسسسسسسسس'),
(4, 2, 'en', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `mediable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mediable_id` bigint UNSIGNED NOT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('main','gallery') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'main',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `mediable_type`, `mediable_id`, `collection_name`, `file_name`, `disk`, `type`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\AdminPanelSetting', 1, 'logo', '69fb57f9f33d6.png', 'direct_public', 'main', '2026-05-06 15:02:18', '2026-05-06 15:02:18'),
(2, 'App\\Models\\AdminPanelSetting', 1, 'favicon', '69fb58109a1d2.png', 'direct_public', 'main', '2026-05-06 15:02:41', '2026-05-06 15:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_09_03_131454_create_companies_table', 1),
(6, '2025_09_04_024702_create_admins_table', 1),
(7, '2025_09_04_030037_create_admin_profiles_table', 1),
(8, '2025_09_06_023916_create_admin_panel_settings_table', 1),
(9, '2025_09_06_031726_create_media_table', 1),
(10, '2026_03_06_232253_create_clients_table', 1),
(11, '2026_03_08_010430_add_client_id_to_companies_table', 1),
(12, '2026_03_24_073631_create_treasuries_table', 1),
(13, '2026_03_25_091128_create_treasury_delivery_details_table', 1),
(15, '2026_03_26_080954_create_sales_matrial_types_table', 2),
(16, '2026_05_15_033635_create_stores_table', 3),
(17, '2026_05_15_060910_create_inv_uoms_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_matrial_types`
--

CREATE TABLE `sales_matrial_types` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'الحالة',
  `date` date DEFAULT NULL,
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_matrial_types`
--

INSERT INTO `sales_matrial_types` (`id`, `uuid`, `is_active`, `date`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(9, '85d923fb-3ac5-4c64-839f-3387617bbd9b', 1, NULL, NULL, 1, 1, '2026-05-14 22:09:09', '2026-05-14 22:11:19'),
(11, 'b604cb7d-2b87-45eb-bf3f-1034f705adac', 1, NULL, 1, 2, NULL, '2026-05-15 02:10:30', '2026-05-15 02:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `sales_matrial_type_translations`
--

CREATE TABLE `sales_matrial_type_translations` (
  `id` bigint UNSIGNED NOT NULL,
  `sales_matrial_type_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_matrial_type_translations`
--

INSERT INTO `sales_matrial_type_translations` (`id`, `sales_matrial_type_id`, `locale`, `name`) VALUES
(15, 9, 'ar', 'لحوم'),
(17, 9, 'en', 'meat'),
(18, 11, 'ar', 'سسسسسسسسس'),
(19, 11, 'en', 'zzzzzzz');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'الحالة',
  `date` date DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'رقم الهاتف',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'العنوان',
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `uuid`, `is_active`, `date`, `phone`, `address`, `company_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, '81e7efca-7b7a-4910-b265-0c7bf284c626', 1, '2026-05-15', '4444444', 'cccccccccc', NULL, 1, 1, '2026-05-15 02:04:25', '2026-05-15 02:49:54'),
(5, '895c89c0-4a6c-45d3-97ad-0b334c1163a9', 1, NULL, '111111111111', NULL, NULL, 1, NULL, '2026-05-15 02:52:48', '2026-05-15 02:52:48'),
(6, 'e36a368c-b560-4e94-8887-f7308cd03441', 1, NULL, '1234567891', 'cccccccc', 1, 2, 2, '2026-05-15 02:54:52', '2026-05-15 02:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `store_translations`
--

CREATE TABLE `store_translations` (
  `id` bigint UNSIGNED NOT NULL,
  `store_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'اسم المخزن'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_translations`
--

INSERT INTO `store_translations` (`id`, `store_id`, `locale`, `name`) VALUES
(3, 2, 'ar', 'مخزن'),
(4, 2, 'en', 'store'),
(9, 5, 'ar', 'ششششش'),
(10, 5, 'en', 'zzzzzzz'),
(11, 6, 'ar', 'ششششششششش'),
(12, 6, 'en', 'aaaaaaaaaa');

-- --------------------------------------------------------

--
-- Table structure for table `treasuries`
--

CREATE TABLE `treasuries` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_master` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'خزينة رئيسية أم فرعية',
  `last_exchange_receipt` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'رقم آخر إيصال صرف',
  `last_collect_receipt` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'رقم آخر إيصال تحصيل',
  `date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'الحالة',
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treasuries`
--

INSERT INTO `treasuries` (`id`, `uuid`, `is_master`, `last_exchange_receipt`, `last_collect_receipt`, `date`, `is_active`, `company_id`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '377b21ee-2399-4e7c-8359-f0f045d2daf7', 1, 2, 1, '2026-05-15', 1, 1, 2, NULL, NULL, '2026-05-15 02:28:30', '2026-05-15 02:28:30'),
(2, '54cdef93-db64-4a16-84f3-33e206484a0c', 0, 7, 3, '2026-05-15', 1, 1, 2, 2, NULL, '2026-05-15 02:29:19', '2026-05-15 02:36:21'),
(3, '4a316a0d-6bb2-4905-aad8-9932ae183150', 1, 0, 0, '2026-05-15', 1, NULL, 1, NULL, NULL, '2026-05-15 02:37:33', '2026-05-15 02:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `treasury_delivery_details`
--

CREATE TABLE `treasury_delivery_details` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `treasury_id` bigint UNSIGNED DEFAULT NULL,
  `treasury_can_delivery_id` bigint UNSIGNED DEFAULT NULL,
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treasury_translations`
--

CREATE TABLE `treasury_translations` (
  `id` bigint UNSIGNED NOT NULL,
  `treasury_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treasury_translations`
--

INSERT INTO `treasury_translations` (`id`, `treasury_id`, `locale`, `name`) VALUES
(1, 1, 'ar', 'ششششششششششش'),
(2, 1, 'en', 'aaaaaaa'),
(3, 2, 'ar', 'شششششششششسسسسسسسسييييي'),
(4, 3, 'ar', 'zzaشششششششش');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_company_id_foreign` (`company_id`);

--
-- Indexes for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_panel_settings_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `admin_panel_settings_email_unique` (`email`),
  ADD KEY `admin_panel_settings_added_by_id_foreign` (`added_by_id`),
  ADD KEY `admin_panel_settings_updated_by_id_foreign` (`updated_by_id`),
  ADD KEY `admin_panel_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_profiles_uuid_unique` (`uuid`),
  ADD KEY `admin_profiles_admin_id_index` (`admin_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_email_unique` (`email`),
  ADD KEY `companies_client_id_foreign` (`client_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inv_uoms`
--
ALTER TABLE `inv_uoms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_uoms_uuid_unique` (`uuid`),
  ADD KEY `inv_uoms_company_id_foreign` (`company_id`),
  ADD KEY `inv_uoms_created_by_foreign` (`created_by`),
  ADD KEY `inv_uoms_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `inv_uom_translations`
--
ALTER TABLE `inv_uom_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inv_uom_locale_unique` (`inv_uom_id`,`locale`),
  ADD KEY `inv_uom_translations_locale_index` (`locale`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_mediable_type_mediable_id_index` (`mediable_type`,`mediable_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sales_matrial_types`
--
ALTER TABLE `sales_matrial_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_matrial_types_uuid_unique` (`uuid`),
  ADD KEY `sales_matrial_types_company_id_foreign` (`company_id`),
  ADD KEY `sales_matrial_types_created_by_foreign` (`created_by`),
  ADD KEY `sales_matrial_types_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `sales_matrial_type_translations`
--
ALTER TABLE `sales_matrial_type_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `smt_type_locale_unique` (`sales_matrial_type_id`,`locale`),
  ADD KEY `sales_matrial_type_translations_locale_index` (`locale`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stores_uuid_unique` (`uuid`),
  ADD KEY `stores_company_id_foreign` (`company_id`),
  ADD KEY `stores_created_by_foreign` (`created_by`),
  ADD KEY `stores_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `store_translations`
--
ALTER TABLE `store_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_locale_unique` (`store_id`,`locale`),
  ADD KEY `store_translations_locale_index` (`locale`);

--
-- Indexes for table `treasuries`
--
ALTER TABLE `treasuries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `treasuries_uuid_unique` (`uuid`),
  ADD KEY `treasuries_company_id_foreign` (`company_id`),
  ADD KEY `treasuries_created_by_foreign` (`created_by`),
  ADD KEY `treasuries_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `treasury_delivery_details`
--
ALTER TABLE `treasury_delivery_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `treasury_delivery_details_uuid_unique` (`uuid`),
  ADD KEY `treasury_delivery_details_treasury_id_foreign` (`treasury_id`),
  ADD KEY `treasury_delivery_details_treasury_can_delivery_id_foreign` (`treasury_can_delivery_id`),
  ADD KEY `treasury_delivery_details_company_id_foreign` (`company_id`),
  ADD KEY `treasury_delivery_details_created_by_foreign` (`created_by`),
  ADD KEY `treasury_delivery_details_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `treasury_translations`
--
ALTER TABLE `treasury_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `treasury_translations_treasury_id_locale_unique` (`treasury_id`,`locale`),
  ADD KEY `treasury_translations_locale_index` (`locale`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_uoms`
--
ALTER TABLE `inv_uoms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inv_uom_translations`
--
ALTER TABLE `inv_uom_translations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_matrial_types`
--
ALTER TABLE `sales_matrial_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sales_matrial_type_translations`
--
ALTER TABLE `sales_matrial_type_translations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `store_translations`
--
ALTER TABLE `store_translations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `treasuries`
--
ALTER TABLE `treasuries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `treasury_delivery_details`
--
ALTER TABLE `treasury_delivery_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treasury_translations`
--
ALTER TABLE `treasury_translations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  ADD CONSTRAINT `admin_panel_settings_added_by_id_foreign` FOREIGN KEY (`added_by_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `admin_panel_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_panel_settings_updated_by_id_foreign` FOREIGN KEY (`updated_by_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD CONSTRAINT `admin_profiles_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inv_uoms`
--
ALTER TABLE `inv_uoms`
  ADD CONSTRAINT `inv_uoms_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_uoms_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inv_uoms_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inv_uom_translations`
--
ALTER TABLE `inv_uom_translations`
  ADD CONSTRAINT `inv_uom_translations_inv_uom_id_foreign` FOREIGN KEY (`inv_uom_id`) REFERENCES `inv_uoms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_matrial_types`
--
ALTER TABLE `sales_matrial_types`
  ADD CONSTRAINT `sales_matrial_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_matrial_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_matrial_types_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sales_matrial_type_translations`
--
ALTER TABLE `sales_matrial_type_translations`
  ADD CONSTRAINT `sales_matrial_type_translations_sales_matrial_type_id_foreign` FOREIGN KEY (`sales_matrial_type_id`) REFERENCES `sales_matrial_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stores_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stores_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `store_translations`
--
ALTER TABLE `store_translations`
  ADD CONSTRAINT `store_translations_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `treasuries`
--
ALTER TABLE `treasuries`
  ADD CONSTRAINT `treasuries_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treasuries_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treasuries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `treasury_delivery_details`
--
ALTER TABLE `treasury_delivery_details`
  ADD CONSTRAINT `treasury_delivery_details_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treasury_delivery_details_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treasury_delivery_details_treasury_can_delivery_id_foreign` FOREIGN KEY (`treasury_can_delivery_id`) REFERENCES `treasuries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treasury_delivery_details_treasury_id_foreign` FOREIGN KEY (`treasury_id`) REFERENCES `treasuries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treasury_delivery_details_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `treasury_translations`
--
ALTER TABLE `treasury_translations`
  ADD CONSTRAINT `treasury_translations_treasury_id_foreign` FOREIGN KEY (`treasury_id`) REFERENCES `treasuries` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
