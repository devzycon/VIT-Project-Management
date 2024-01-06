-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2021 at 10:05 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admission`
--

-- --------------------------------------------------------

--
-- Table structure for table `student_data`
--

CREATE TABLE `student_data` (
  `id` int(10) NOT NULL,
  `u_card` varchar(12) NOT NULL,
  `u_f_name` text NOT NULL,
  `u_l_name` text NOT NULL,
  `u_email` text NOT NULL,
  `u_phone` varchar(10) NOT NULL,
  `u_project_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_data`
INSERT INTO student_data (id, u_card, u_f_name, u_l_name, u_email, u_phone, u_project_type) VALUES
(104, '231313', 'surajj', 'kumaran', 'surajj@gmail.com', '23234242', 'PAT');

--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(5, 'kushkush', '$2y$10$pkgNOc0r6DaiDnCTIVT/VubRm0LqncpPgipzdARaH/9wZto.zmYLu', '2021-05-22 00:30:03'),
(6, '123123', '$2y$10$AwA0obkWAdzF6Z6zCqZ3Xu5QinFNWhL89iAUde8YYfYorruaxOjCm', '2021-07-17 16:49:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_data`
--
ALTER TABLE `student_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_data`
--
ALTER TABLE `student_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- CREATE A NEW COLUMN REVIEW 0

ALTER TABLE `student_data`
  ADD `review_0` varchar(10) NOT NULL DEFAULT 0;


ALTER TABLE`users`
  ADD `faculty_id` int(10) NOT NULL;


ALTER TABLE `student_data`
ADD `faculty_id` INT(10) NOT NULL;


ALTER TABLE `student_data`
ADD `project_name` varchar(50) ;

ALTER TABLE `student_data`
ADD `attendance` varchar(20) NOT NULL DEFAULT 0;

ALTER TABLE `student_data`
ADD `no_of_present` int(20) NOT NULL DEFAULT 0;

ALTER TABLE `student_data`
ADD `no_of_absent` int(20) NOT NULL DEFAULT 0;


--
-- Table structure for table `student_data`
--

CREATE TABLE `review1` (
  `s_no` int(10) NOT NULL,
  `s_pgm` varchar(12) NOT NULL,
  `s_regno` varchar(15) NOT NULL,
  `s_name` text NOT NULL,
  `s_erp` varchar(12) NOT NULL,
  `s_guide` text NOT NULL,
  `s_panelno` varchar(50) NOT NULL,
  `s_facultyrev` text NOT NULL,
  `s_m1` int(10) NOT NULL,
  `s_m2` int(10) NOT NULL,
  `s_m3` int(10) NOT NULL,
  `s_m4` int(10) NOT NULL,
  `s_tot` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
