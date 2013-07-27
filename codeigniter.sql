-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 27, 2013 at 07:08 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codeigniter`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_no` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `d_added` datetime NOT NULL,
  `d_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `cart_no`, `item_id`, `item_quantity`, `d_added`, `d_updated`) VALUES
(12, 2, 1, 1, '2013-07-27 06:01:06', '0000-00-00 00:00:00'),
(13, 3, 1, 1, '2013-07-27 06:03:44', '0000-00-00 00:00:00'),
(18, 1, 1, 3, '0000-00-00 00:00:00', '2013-07-27 07:05:16'),
(19, 1, 2, 2, '0000-00-00 00:00:00', '2013-07-27 07:05:24'),
(20, 1, 7, 1, '2013-07-27 07:05:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` text NOT NULL,
  `item_code` text NOT NULL,
  `item_info` longblob NOT NULL,
  `d_added` datetime NOT NULL,
  `d_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_name`, `item_code`, `item_info`, `d_added`, `d_updated`) VALUES
(1, 'itemname', 'item12', 0x6974656d20696e666f, '0000-00-00 00:00:00', '2013-07-24 11:02:05'),
(2, 'item name', 'Itema2', 0x6974656d2073737373696e666f, '0000-00-00 00:00:00', '2013-07-24 11:04:06'),
(7, 'nekwiten', 'newita', 0x6f6169666b667366, '0000-00-00 00:00:00', '2013-07-26 11:15:29');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `is_admin` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `email`, `username`, `password`, `is_admin`, `date_added`, `date_updated`) VALUES
(17, 'ammar.haydear@gmail.com', 'admin', 'admin', 1, '2013-07-26 10:18:43', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
