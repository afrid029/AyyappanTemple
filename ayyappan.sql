-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2025 at 01:56 AM
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
-- Database: `ayyappan`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `ID` varchar(20) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`ID`, `title`, `description`, `date`, `time`) VALUES
('event0342', 'Sivrathr Speciel night event 2025', 'fsdfsfsd', '2025-06-07', '23:59:00'),
('event1778', 'Hellp everyon', 'zfsfsdf,  fjsf lskf lskd flskdfj sfjslk df jsf sdfjsd fsjkdf ksdfh ksdfksd fksh fsmfjk shd', '2025-05-07', '23:59:00'),
('event2745', 'Hellp everyon', 'sf;dlf sdf sdfjksd fksldf jks fjsdfj sfj dfjskdf sd jfksf hsu f ksf sf hksfhsfs fsd fsdhfk skjf sfksd flks flf sdlfs lfsdlkf sdf sdf lfs', '2025-06-07', '17:00:00'),
('event3157', 'zxczxzxc', 'xzczczxcxz xz xzczx czxc zx czx c', '2025-06-26', '04:05:00'),
('event4453', 'zczs sds  sd zc zx czx czxc zxc z cz czx', 'cxzcxzczx  czxczxczx  xc zxc ', '2025-06-27', '05:01:00'),
('event5169', 'c  zcxc zc xzc zxc ', ' xc xc ', '2025-06-23', '05:07:00'),
('event6604', ',mnnnm,n', 'lkllkl;k;l  l;kk; ', '2025-07-05', '08:36:00'),
('event7833', 'mn nn,nm,n', 'jkj kjlkj', '2025-07-12', '10:38:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
