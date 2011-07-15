-- phpMyAdmin SQL Dump
-- version 3.3.7deb5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 15, 2011 at 10:18 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-7+squeeze1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

DROP TABLE IF EXISTS `user_accounts`;
CREATE TABLE IF NOT EXISTS `user_accounts` (
  `user_id` int(11) NOT NULL,
  `account` varchar(255) NOT NULL,
  UNIQUE KEY `account` (`account`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_accounts`
--

