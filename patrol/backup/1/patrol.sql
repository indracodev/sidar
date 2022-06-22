-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2021 at 10:51 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patrol`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_activity`
--

CREATE TABLE `tb_activity` (
  `uid` int(10) NOT NULL,
  `activityId` varchar(10) NOT NULL,
  `personId` varchar(5) NOT NULL,
  `activityStart` datetime NOT NULL,
  `activityEnd` datetime DEFAULT NULL,
  `activityStatus` varchar(1) NOT NULL,
  `trackId` varchar(11) NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_activity`
--

INSERT INTO `tb_activity` (`uid`, `activityId`, `personId`, `activityStart`, `activityEnd`, `activityStatus`, `trackId`, `lastUpdated`) VALUES
(1, '1', '1', '2021-05-20 11:00:00', NULL, '0', '', '2021-05-20 09:44:12'),
(7, '2', '2', '2021-05-20 16:05:15', NULL, '0', '', '2021-05-20 09:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_checkpoint`
--

CREATE TABLE `tb_checkpoint` (
  `uid` int(2) NOT NULL,
  `checkpointId` varchar(20) NOT NULL,
  `checkpointName` varchar(60) NOT NULL,
  `checkLatitude` varchar(255) NOT NULL,
  `checkLongitude` varchar(255) NOT NULL,
  `checkStatus` varchar(1) NOT NULL,
  `userName` varchar(60) NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_checkpoint`
--

INSERT INTO `tb_checkpoint` (`uid`, `checkpointId`, `checkpointName`, `checkLatitude`, `checkLongitude`, `checkStatus`, `userName`, `lastUpdated`) VALUES
(1, '1', 'A', '-7.293284', '112.675162', '1', '', '2021-06-04 10:25:06'),
(2, '2', 'B', '-7.293358', '112.675166', '1', '', '2021-06-04 10:01:05'),
(3, '3', 'C', '-7.293307', '112.675265', '1', '', '2021-06-04 10:25:04'),
(4, '4', 'D', '-7.293422', '112.675332', '1', '', '2021-05-20 05:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_person`
--

CREATE TABLE `tb_person` (
  `uid` int(5) NOT NULL,
  `personId` varchar(20) NOT NULL,
  `personName` varchar(60) NOT NULL,
  `userName` varchar(60) NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_person`
--

INSERT INTO `tb_person` (`uid`, `personId`, `personName`, `userName`, `lastUpdated`) VALUES
(1, '1', 'yoggy', '', '2021-05-20 06:39:10'),
(2, '2', 'nanda', '', '2021-05-20 06:39:10'),
(3, '23', 'yuda', 'admin', '2021-06-08 07:38:51'),
(4, 'FF:FF:FF:FF:FF:FF:FF', 'amir', 'admin', '2021-06-08 08:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `tb_phase`
--

CREATE TABLE `tb_phase` (
  `uid` int(11) NOT NULL,
  `phaseId` varchar(11) NOT NULL,
  `phaseDate` date NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_phase`
--

INSERT INTO `tb_phase` (`uid`, `phaseId`, `phaseDate`, `lastUpdated`) VALUES
(1, '1', '2021-06-03', '2021-06-03 04:34:20'),
(8, '2', '2021-06-04', '2021-06-04 05:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `tb_report`
--

CREATE TABLE `tb_report` (
  `uid` int(10) NOT NULL,
  `reportId` varchar(10) NOT NULL,
  `reportLatitude` varchar(255) NOT NULL,
  `reportLongitude` varchar(255) NOT NULL,
  `activityId` varchar(10) NOT NULL,
  `personId` varchar(5) NOT NULL,
  `checkpointId` varchar(2) NOT NULL,
  `reportDate` date NOT NULL,
  `reportTime` time NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_report`
--

INSERT INTO `tb_report` (`uid`, `reportId`, `reportLatitude`, `reportLongitude`, `activityId`, `personId`, `checkpointId`, `reportDate`, `reportTime`, `lastUpdated`) VALUES
(1, '1', '0', '0', '1', '1', '1', '2021-05-20', '12:00:00', '2021-05-20 09:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `tb_schedule`
--

CREATE TABLE `tb_schedule` (
  `uid` int(11) NOT NULL,
  `scheduleId` varchar(11) NOT NULL,
  `personId` varchar(5) NOT NULL,
  `checkpointName` varchar(60) NOT NULL,
  `phaseId` varchar(11) NOT NULL,
  `scheduleStart` time NOT NULL,
  `scheduleEnd` time NOT NULL,
  `scheduleDate` date NOT NULL,
  `userName` varchar(60) NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_schedule`
--

INSERT INTO `tb_schedule` (`uid`, `scheduleId`, `personId`, `checkpointName`, `phaseId`, `scheduleStart`, `scheduleEnd`, `scheduleDate`, `userName`, `lastUpdated`) VALUES
(1, '1', '1', 'A', '1', '08:00:00', '09:00:00', '2021-06-03', 'admin', '2021-06-04 04:28:08'),
(2, '2', '2', 'B', '1', '09:00:00', '10:00:00', '2021-06-03', 'admin', '2021-06-04 06:18:21'),
(3, '3', '1', 'C', '1', '11:00:00', '12:00:00', '2021-06-03', 'admin', '2021-06-04 04:27:51'),
(4, '4', '2', 'D', '1', '10:00:00', '11:00:00', '2021-06-03', 'admin', '2021-06-04 06:17:48'),
(7, '5', '1', 'A', '2', '08:00:00', '09:00:00', '2021-06-04', 'admin', '2021-06-04 05:42:57');

-- --------------------------------------------------------

--
-- Table structure for table `tb_track`
--

CREATE TABLE `tb_track` (
  `uid` int(11) NOT NULL,
  `trackId` varchar(11) NOT NULL,
  `trackValue` text NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `uid` int(5) NOT NULL,
  `userId` varchar(5) NOT NULL,
  `userName` varchar(60) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userLevel` varchar(2) NOT NULL,
  `userHash` varchar(255) NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`uid`, `userId`, `userName`, `userPassword`, `userLevel`, `userHash`, `lastUpdated`) VALUES
(1, '1', 'admin', '8a9bcf1e51e812d0af8465a8dbcc9f741064bf0af3b3d08e6b0246437c19f7fb', '1', 'yzyaDdmA2gRBYyvK7iNLB7ZTGOI2RjM8meBYEFcUK07ZLVsbRq', '2021-06-08 08:27:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_activity`
--
ALTER TABLE `tb_activity`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `activityId` (`activityId`);

--
-- Indexes for table `tb_checkpoint`
--
ALTER TABLE `tb_checkpoint`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `checkpointId` (`checkpointId`);

--
-- Indexes for table `tb_person`
--
ALTER TABLE `tb_person`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `personId` (`personId`);

--
-- Indexes for table `tb_phase`
--
ALTER TABLE `tb_phase`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `phaseId` (`phaseId`);

--
-- Indexes for table `tb_report`
--
ALTER TABLE `tb_report`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `scheduleId` (`scheduleId`);

--
-- Indexes for table `tb_track`
--
ALTER TABLE `tb_track`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `trackId` (`trackId`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_activity`
--
ALTER TABLE `tb_activity`
  MODIFY `uid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_checkpoint`
--
ALTER TABLE `tb_checkpoint`
  MODIFY `uid` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_person`
--
ALTER TABLE `tb_person`
  MODIFY `uid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_phase`
--
ALTER TABLE `tb_phase`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_report`
--
ALTER TABLE `tb_report`
  MODIFY `uid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_track`
--
ALTER TABLE `tb_track`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `uid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
