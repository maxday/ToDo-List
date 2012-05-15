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
-- Table structure for table `MYTODO_TAG`
--


DROP TABLE `MYTODO_TAG`;
DROP TABLE `MYTODO_USER`;
DROP TABLE `MYTODO_TASK`;
DROP TABLE `MYTODO_PROTECT`;


CREATE TABLE `MYTODO_TAG` (
  `uuid` char(23) NOT NULL,
  `title` varchar(10) NOT NULL,
  `dateCreated` date NOT NULL,
  `dateDeleted` date DEFAULT NULL,
  `user` char(23) NOT NULL,
  PRIMARY KEY (`uuid`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MYTODO_TAG`
--


-- --------------------------------------------------------

--
-- Table structure for table `MYTODO_TASK`
--

CREATE TABLE `MYTODO_TASK` (
  `uuid` char(23) NOT NULL,
  `dateCreated` date NOT NULL,
  `dateCompleted` date DEFAULT NULL,
  `dateDeleted` date DEFAULT NULL,
  `title` varchar(30) NOT NULL,
  `dueDate` date DEFAULT NULL,
  `priority` char(2) DEFAULT NULL,
  `isImportant` tinyint(1) DEFAULT NULL,
  `tag` char(23) DEFAULT NULL,
  `user` char(23) DEFAULT NULL,
  PRIMARY KEY (`uuid`),
  KEY `tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Dumping data for table `MYTODO_PROTECT`
--


-- --------------------------------------------------------

--
-- Table structure for table `MYTODO_PROTECT`
--

CREATE TABLE `MYTODO_PROTECT` (
  `uuid` char(23) NOT NULL,
  `isProtected` tinyint(1) NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MYTODO_TASK`
--


-- --------------------------------------------------------

--
-- Table structure for table `MYTODO_USER`
--

CREATE TABLE `MYTODO_USER` (
  `uuid` char(23) NOT NULL,
  `pwd` char(32) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `login` varchar(50) NOT NULL,
  `hideTips` tinyint(1) DEFAULT NULL,
  `isAdvancedUser` tinyint(1) DEFAULT NULL,
  `dateCreated` date NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MYTODO_USER`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `MYTODO_TAG`
--
ALTER TABLE `MYTODO_TAG`
  ADD CONSTRAINT `MYTODO_TAG_ibfk_1` FOREIGN KEY (`user`) REFERENCES `MYTODO_USER` (`uuid`);

--
-- Constraints for table `MYTODO_TASK`
--
ALTER TABLE `MYTODO_TASK`
  ADD CONSTRAINT `MYTODO_TASK_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `MYTODO_TAG` (`uuid`);
ALTER TABLE `MYTODO_TASK`
  ADD CONSTRAINT `MYTODO_TASK_ibfk_2` FOREIGN KEY (`user`) REFERENCES `MYTODO_USER` (`uuid`);

--
-- Constraints for table `MYTODO_PROTECT`
--
ALTER TABLE `MYTODO_PROTECT`
  ADD CONSTRAINT `MYTODO_PROTECT_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `MYTODO_USER` (`uuid`);
