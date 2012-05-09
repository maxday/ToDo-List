-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 09, 2012 at 07:23 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `TAG`
--

CREATE TABLE `TAG` (
  `uuid` char(23) NOT NULL,
  `title` varchar(10) NOT NULL,
  `dateCreated` date NOT NULL,
  `dateDeleted` date DEFAULT NULL,
  `user` char(23) NOT NULL,
  PRIMARY KEY (`uuid`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TAG`
--


-- --------------------------------------------------------

--
-- Table structure for table `TASK`
--

CREATE TABLE `TASK` (
  `uuid` char(23) NOT NULL,
  `dateCreated` date NOT NULL,
  `dateCompleted` date DEFAULT NULL,
  `dateDeleted` date DEFAULT NULL,
  `title` varchar(30) NOT NULL,
  `dueDate` date DEFAULT NULL,
  `priority` char(2) DEFAULT NULL,
  `isImportant` tinyint(4) DEFAULT NULL,
  `tag` char(23) DEFAULT NULL,
  PRIMARY KEY (`uuid`),
  KEY `tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TASK`
--


-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE `USER` (
  `uuid` char(23) NOT NULL,
  `pwd` char(32) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `login` varchar(50) NOT NULL,
  `hideTips` tinyint(4) DEFAULT NULL,
  `isAdvancedUser` tinyint(4) DEFAULT NULL,
  `dateCreated` date NOT NULL,
  `isProtected` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `USER`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `TAG`
--
ALTER TABLE `TAG`
  ADD CONSTRAINT `TAG_ibfk_1` FOREIGN KEY (`user`) REFERENCES `USER` (`uuid`);

--
-- Constraints for table `TASK`
--
ALTER TABLE `TASK`
  ADD CONSTRAINT `TASK_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `TAG` (`uuid`);
