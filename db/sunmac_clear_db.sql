
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 166.62.8.8
-- Generation Time: Feb 19, 2020 at 08:47 AM
-- Server version: 5.5.51
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sunmaccloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `uncompleted_machine_time`
--

CREATE TABLE `uncompleted_machine_time` (
  `category_id` int(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `thickness` varchar(10) NOT NULL,
  `size` varchar(10) NOT NULL,
  `machine_id` int(10) NOT NULL,
  `minutes` int(20) NOT NULL,
  `numbers` int(10) NOT NULL,
  `count` int(10) NOT NULL,
  `length` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uncompleted_machine_time`
--

