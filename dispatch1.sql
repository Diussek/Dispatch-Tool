-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 13, 2019 at 12:10 PM
-- Server version: 5.5.21-log
-- PHP Version: 5.3.20

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dispatch1`
--

-- --------------------------------------------------------

--
-- Table structure for table `engineers`
--

CREATE TABLE IF NOT EXISTS `engineers` (
  `engname` varchar(25) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `engmail` varchar(35) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `maximologin` varchar(40) NOT NULL,
  `srcount` varchar(12) NOT NULL,
  `incount` varchar(12) NOT NULL,
  `shiftcount` int(1) NOT NULL,
  `minioncount` int(1) NOT NULL,
  `visible` int(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `engineers`
--

INSERT INTO `engineers` (`engname`, `engmail`, `maximologin`, `srcount`, `incount`, `shiftcount`, `minioncount`, `visible`) VALUES
('Michal Malecki', 'michal.malecki@company.com', 'MICHAL.MALECKI@COMPANY.COM', '1', '1', 2, 1, 1),
('Marcin Bula', 'marcin.bula@company.com', 'MARCIN.BULA@COMPANY.COM', '1', '1', 3, 1, 1),
('Agnieszka Bakal', 'agnieszka.bakal@company.com', 'AGNIESZKA.BAKAL@COMPANY.COM', '1', '1', 1, 2, 1);


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `rights` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `rights`) VALUES
(1, 'test', '81c81b2635d1df61c0282d5445fa8edd', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
