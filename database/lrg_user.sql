-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 17, 2021 at 10:55 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lrg_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_level` varchar(2) NOT NULL DEFAULT '0',
  `user_name` varchar(250) NOT NULL,
  `user_fname` varchar(250) NOT NULL,
  `user_lname` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_ip` varchar(50) DEFAULT NULL,
  `user_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  `login_times` int(11) DEFAULT '0',
  `user_status` varchar(20) NOT NULL DEFAULT 'unlocked',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_level`, `user_name`, `user_fname`, `user_lname`, `user_password`, `user_email`, `user_ip`, `user_date`, `last_login`, `login_times`, `user_status`) VALUES
(1, '2', 'admin', 'Zoe', 'Zoe', 'admin123', 'test@test.com', '127.0.0.1', '2021-02-12 19:57:36', '2021-03-14 09:37:58', 65, 'unlocked'),
(5, '0', 'test2', 'test', 'test', 'test123', 'test.test@com', '127.0.0.1', '2021-03-12 08:36:18', '2021-03-16 07:34:52', 50, 'unlocked'),
(2, '2', 'pan', 'pan', 'pan', 'pan123', 'test.test@com', '127.0.0.1', '2021-03-12 08:36:18', '2021-03-17 10:13:33', 51, 'unlocked'),
(3, '0', 'test', 'test', 'test', 'test123', 'test.test@com', '127.0.0.1', '2021-03-12 08:36:18', '2021-03-16 07:34:52', 50, 'unlocked'),
(4, '0', 'test1', 'test', 'test', 'test123', 'test.test@com', '127.0.0.1', '2021-03-12 08:36:18', '2021-03-16 07:34:52', 50, 'unlocked');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
