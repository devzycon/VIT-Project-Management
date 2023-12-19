SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `db_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `Name` varchar(50) NOT NULL,
  `Prix` int(11) NOT NULL,
  `Categorie` varchar(50) NOT NULL,
  `etat` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` int(11) NOT NULL COMMENT 'role_id',
  `role` varchar(255) DEFAULT NULL COMMENT 'role_text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Editor'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `roleid` tinyint(4) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `email`, `password`, `mobile`, `roleid`, `isActive`, `created_at`, `updated_at`) VALUES
(23, 'Sarah', 'Sarah', 'Sarah@gmail.com', '3ea543d29ad3c1c09fcfbdda3f2f0617c50ab138', '9754852852', 1, 1, '2020-12-19 14:35:56', '2020-12-19 14:35:56'),
(24, 'Meer', 'Meer', 'meer@gmail.com', '7f0c9d56d40c3cc1e23e0113d5377779a4de86ff', '95427752867', 1, 0, '2020-12-19 15:13:39', '2020-12-19 15:13:39'),
(25, 'Prady', 'Prady', 'prady@gmail.com', '0a859b9a4ebbde4f63383bca7e34890985782348', '2346789123', 1, 0, '2020-12-19 15:15:52', '2020-12-19 15:15:52'),
(26, 'Vishnu', 'Vishnu', 'vishnu@gmail.com', 'adef7009a84a71c226ddf68671e929d68a707762', '234567810', 1, 0, '2020-12-19 15:16:59', '2020-12-19 15:16:59'),
(27, 'Suraj', 'Suraj', 'Suraj@gmail.com', '03ee5fda2eae80be34c0142fe28ac6401e63324c', '123456789', 1, 0, '2020-12-19 15:17:34', '2020-12-19 15:17:34'),
(29, 'VISHAL P', 'Admin', 'vishalp@gmail.com', '554e4b735ac18077b74aacfb3698f0def62f7122', '08667857575', 1, 0, '2023-11-04 13:23:58', '2023-11-04 13:23:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'role_id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

 --------------------------------------------------------

--
-- Table structure for table `spotlight`
--

CREATE TABLE `spotlight` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `spotlight`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `spotlight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Dumping data for table `spotlight`
--

INSERT INTO `spotlight` (`id`, `title`, `description`) VALUES
(1, 'Testing', 'testing purpose');

 --------------------------------------------------------