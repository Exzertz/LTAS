-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2026 at 03:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ltaw_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts_tbl`
--

CREATE TABLE `admin_accounts_tbl` (
  `admin_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `role` varchar(100) DEFAULT 'Administrator',
  `reset_password_token` varchar(255) DEFAULT NULL,
  `password_token_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_accounts_tbl`
--

INSERT INTO `admin_accounts_tbl` (`admin_id`, `first_name`, `middle_name`, `last_name`, `email_address`, `admin_password`, `role`, `reset_password_token`, `password_token_expiry`, `created_at`, `updated_at`) VALUES
(1002, 'Julian Jacob', '', 'Casemero', 'jikobcsmro@gmail.com', '$2y$10$lqjSieO3xb5rKLYA1mlLIOSy8gVtGFM9G9tfxP8cjFRhK9aVdlNGi', 'Administrator', NULL, NULL, '2025-07-28 05:27:24', '2025-11-06 05:07:05');

-- --------------------------------------------------------

--
-- Table structure for table `admin_info_tbl`
--

CREATE TABLE `admin_info_tbl` (
  `tbl_row_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female','Others') DEFAULT 'Others',
  `civil_status` enum('Single','Married','Divorced','Widowed') DEFAULT 'Single',
  `cellphone_number` varchar(100) NOT NULL,
  `telephone_number` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_info_tbl`
--

INSERT INTO `admin_info_tbl` (`tbl_row_id`, `admin_id`, `profile_picture`, `gender`, `civil_status`, `cellphone_number`, `telephone_number`, `address`, `updated_at`) VALUES
(2, 1002, 'admin_1002_6891c01c4a248.jfif', 'Male', 'Single', '09123456789', '', 'Passi, Iloilo', '2025-08-05 08:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries_tbl`
--

CREATE TABLE `inquiries_tbl` (
  `inquiry_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email_address` varchar(150) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `service_type` enum('Order and Install','Maintenance','Repair') NOT NULL,
  `full_address` varchar(255) NOT NULL,
  `inquire_status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `inquired_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laser_tripwire_owners_tbl`
--

CREATE TABLE `laser_tripwire_owners_tbl` (
  `device_id` varchar(150) NOT NULL,
  `device_location` varchar(255) NOT NULL,
  `owner` varchar(150) NOT NULL,
  `tripwire_status` enum('Safe','Detected') DEFAULT 'Safe',
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laser_tripwire_owners_tbl`
--

INSERT INTO `laser_tripwire_owners_tbl` (`device_id`, `device_location`, `owner`, `tripwire_status`, `registered_at`) VALUES
('BC42A61F8A3C', 'device_location_BC42A61F8A3C_690c3fdd6e126.', 'user@482140552122', 'Detected', '2025-11-06 06:27:41');

-- --------------------------------------------------------

--
-- Table structure for table `laser_tripwire_products_tbl`
--

CREATE TABLE `laser_tripwire_products_tbl` (
  `device_id` varchar(150) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_name` varchar(150) NOT NULL,
  `model_name` varchar(150) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laser_tripwire_products_tbl`
--

INSERT INTO `laser_tripwire_products_tbl` (`device_id`, `product_image`, `product_name`, `model_name`, `version`, `description`, `created_at`) VALUES
('BC42A61F8A3C', NULL, 'ESP32 DevKit Tripwire', 'ESP32-CAM', 'v1.0', 'Laser tripwire alarm system prototype using ESP32 DevKit', '2025-10-28 08:41:16'),
('laser_tripwire_0956', 'laser_tripwire__68984dddb9b38.jpg', 'Laser Tripwire', 'Model Casemero', 'Version 1.5', NULL, '2025-08-10 07:44:29'),
('tripwire_12345', NULL, 'Tripwire Classic', 'Laser Tripwire', 'Version 1.2', NULL, '2025-08-10 03:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `tripwire_events_tbl`
--

CREATE TABLE `tripwire_events_tbl` (
  `event_id` int(11) NOT NULL,
  `device_id` varchar(150) NOT NULL,
  `event_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `captured_image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tripwire_events_tbl`
--

INSERT INTO `tripwire_events_tbl` (`event_id`, `device_id`, `event_time`, `captured_image`) VALUES
(105, 'BC42A61F8A3C', '2025-11-05 22:24:40', 'uploads/laser_tripwire_BC42A61F8A3C_2025-11-06_14-24-41.jpeg'),
(106, 'BC42A61F8A3C', '2025-11-05 22:24:50', 'uploads/laser_tripwire_BC42A61F8A3C_2025-11-06_14-24-47.jpeg'),
(107, 'BC42A61F8A3C', '2025-11-05 22:25:05', 'uploads/laser_tripwire_BC42A61F8A3C_2025-11-06_14-24-59.jpeg'),
(108, 'BC42A61F8A3C', '2025-11-06 21:02:28', 'uploads/captured-images/laser_tripwire_BC42A61F8A3C_2025-11-07_13-02-35.jpeg'),
(109, 'BC42A61F8A3C', '2025-11-06 21:02:41', 'uploads/captured-images/laser_tripwire_BC42A61F8A3C_2025-11-07_13-02-41.jpeg'),
(110, 'BC42A61F8A3C', '2025-11-06 21:02:49', 'uploads/captured-images/laser_tripwire_BC42A61F8A3C_2025-11-07_13-02-50.jpeg'),
(111, 'BC42A61F8A3C', '2025-11-06 21:02:58', 'uploads/captured-images/laser_tripwire_BC42A61F8A3C_2025-11-07_13-03-00.jpeg'),
(112, 'BC42A61F8A3C', '2025-11-06 21:03:06', 'uploads/captured-images/laser_tripwire_BC42A61F8A3C_2025-11-07_13-03-07.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts_tbl`
--

CREATE TABLE `user_accounts_tbl` (
  `user_id` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `verified_account` enum('Yes','No') DEFAULT 'No',
  `reset_password_token` varchar(255) DEFAULT NULL,
  `password_token_expiry` datetime DEFAULT NULL,
  `locked_account` enum('Yes','No') DEFAULT 'No',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts_tbl`
--

INSERT INTO `user_accounts_tbl` (`user_id`, `first_name`, `middle_name`, `last_name`, `email_address`, `user_password`, `verification_token`, `verified_account`, `reset_password_token`, `password_token_expiry`, `locked_account`, `last_login`, `created_at`, `updated_at`) VALUES
('user@482140552122', 'Julian Jacob', '', 'Casimiro', 'ulpa.casimiro.ui@phinmaed.com', '$2y$10$OuikYpX5faQ7E9WgJEUvTe0vJpthbk6eWMRlpxRmC7DrqsDox2Yq6', NULL, 'Yes', NULL, NULL, 'No', '2025-11-14 07:57:50', '2025-10-26 15:27:23', '2025-11-14 07:57:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_info_tbl`
--

CREATE TABLE `user_info_tbl` (
  `tbl_row_id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female','Others') DEFAULT 'Others',
  `civil_status` enum('Single','Married','Divorced','Widowed') DEFAULT 'Single',
  `occupation` enum('Employed','Self-Employed','Student','Unemployed','Others') DEFAULT 'Others',
  `cellphone_number` varchar(100) NOT NULL,
  `telephone_number` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info_tbl`
--

INSERT INTO `user_info_tbl` (`tbl_row_id`, `user_id`, `profile_picture`, `gender`, `civil_status`, `occupation`, `cellphone_number`, `telephone_number`, `address`, `updated_at`) VALUES
(19, 'user@482140552122', NULL, 'Male', 'Single', 'Student', '09695731090', '', 'Passi City, Iloilo', '2025-10-26 15:27:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts_tbl`
--
ALTER TABLE `admin_accounts_tbl`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `admin_info_tbl`
--
ALTER TABLE `admin_info_tbl`
  ADD PRIMARY KEY (`tbl_row_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `inquiries_tbl`
--
ALTER TABLE `inquiries_tbl`
  ADD PRIMARY KEY (`inquiry_id`);

--
-- Indexes for table `laser_tripwire_owners_tbl`
--
ALTER TABLE `laser_tripwire_owners_tbl`
  ADD PRIMARY KEY (`device_id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `laser_tripwire_products_tbl`
--
ALTER TABLE `laser_tripwire_products_tbl`
  ADD PRIMARY KEY (`device_id`);

--
-- Indexes for table `tripwire_events_tbl`
--
ALTER TABLE `tripwire_events_tbl`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `user_accounts_tbl`
--
ALTER TABLE `user_accounts_tbl`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `user_info_tbl`
--
ALTER TABLE `user_info_tbl`
  ADD PRIMARY KEY (`tbl_row_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts_tbl`
--
ALTER TABLE `admin_accounts_tbl`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT for table `admin_info_tbl`
--
ALTER TABLE `admin_info_tbl`
  MODIFY `tbl_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inquiries_tbl`
--
ALTER TABLE `inquiries_tbl`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- AUTO_INCREMENT for table `tripwire_events_tbl`
--
ALTER TABLE `tripwire_events_tbl`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `user_info_tbl`
--
ALTER TABLE `user_info_tbl`
  MODIFY `tbl_row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_info_tbl`
--
ALTER TABLE `admin_info_tbl`
  ADD CONSTRAINT `admin_info_tbl_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_accounts_tbl` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `laser_tripwire_owners_tbl`
--
ALTER TABLE `laser_tripwire_owners_tbl`
  ADD CONSTRAINT `laser_tripwire_owners_tbl_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `laser_tripwire_products_tbl` (`device_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laser_tripwire_owners_tbl_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `user_accounts_tbl` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tripwire_events_tbl`
--
ALTER TABLE `tripwire_events_tbl`
  ADD CONSTRAINT `tripwire_events_tbl_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `laser_tripwire_products_tbl` (`device_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_info_tbl`
--
ALTER TABLE `user_info_tbl`
  ADD CONSTRAINT `user_info_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_accounts_tbl` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
