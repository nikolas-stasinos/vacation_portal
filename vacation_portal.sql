-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2020 at 10:37 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vacation_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `application_id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `date_submitted` datetime DEFAULT NULL,
  `date_requested_start` datetime DEFAULT NULL,
  `date_requested_end` datetime DEFAULT NULL,
  `days_requested` int(11) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`application_id`, `user_id`, `date_submitted`, `date_requested_start`, `date_requested_end`, `days_requested`, `reason`, `status`) VALUES
(1, 'email_user@test.com', '2020-04-20 20:37:46', '2020-04-24 00:00:00', '2020-04-27 00:00:00', 2, 'trip to Istanbul', 'pending'),
(2, 'email_user@test.com', '2020-04-20 20:39:40', '2020-05-01 00:00:00', '2020-05-01 00:00:00', 1, 'official public holiday', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `admin_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `first_name`, `last_name`, `type`, `admin_email`) VALUES
('betty_cave@gmks.gru', '755f85c2723bb39381c7379a604160d8', 'Betty', 'Cave', 'employee', 'email_admin@test.com'),
('george_bus12@geobus.com', '5d41402abc4b2a76b9719d911017c592', 'George', 'Bush', 'employee', 'email_admin@test.com'),
('email_admin@test.com', '63a9f0ea7bb98050796b649e85481845', 'Nikolaos', 'Admin', 'admin', 'email_admin@test.com'),
('email_user@test.com', '63a9f0ea7bb98050796b649e85481845', 'Nikos', 'Stas', 'employee', 'email_admin@test.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`),
  ADD KEY `admin_email` (`admin_email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`email`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`admin_email`) REFERENCES `users` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
