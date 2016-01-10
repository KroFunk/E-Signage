-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jan 10, 2016 at 08:36 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `esign`
--
CREATE DATABASE IF NOT EXISTS `esign` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `esign`;

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE IF NOT EXISTS `audit` (
`audit_id` int(11) NOT NULL,
  `esign_id` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `action` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
`content_id` int(11) NOT NULL,
  `esign_id` int(11) NOT NULL,
  `content_type` varchar(3) NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `autosave` text NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `UserID` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `esigns`
--

CREATE TABLE IF NOT EXISTS `esigns` (
`esign_id` int(11) NOT NULL,
  `sign_description` text NOT NULL,
  `sign_location` text NOT NULL,
  `sign_icon` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `esigns`
--

INSERT INTO `esigns` (`esign_id`, `sign_description`, `sign_location`, `sign_icon`) VALUES
(1, 'School Announcements', 'Senior School Foyer', 'http://localhost/e-signage/files/images/demo.jpg'),
(2, 'Junior Messages', 'Junior School Foyer', 'http://localhost/e-signage/files/images/demo2.jpg'),
(3, 'Fiveways Messages', 'Fiveways Foyer', 'http://localhost/e-signage/files/images/demo3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`UserID` int(11) NOT NULL COMMENT 'Auto Incrementing UserID',
  `Email` text NOT NULL,
  `Name` text NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='User table for Authentication and Auditing';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Email`, `Name`, `Password`) VALUES
(2, 'rpw@rydeschool.net', 'Robin Wright', '$2y$10$7SCnA78xgH2dMXaY.a655ux9jXl8xJDZgCljTUOZO2yW4bQSL9VSq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
 ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
 ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `esigns`
--
ALTER TABLE `esigns`
 ADD PRIMARY KEY (`esign_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`UserID`), ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `esigns`
--
ALTER TABLE `esigns`
MODIFY `esign_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto Incrementing UserID',AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
