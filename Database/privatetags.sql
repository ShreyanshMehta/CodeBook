-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2020 at 04:17 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `privatetags`
--

CREATE TABLE `privatetags` (
  `user_id` varchar(100) NOT NULL,
  `tag` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `solved` int(5) NOT NULL,
  `attempted` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `privatetags`
--

INSERT INTO `privatetags` (`user_id`, `tag`, `code`, `author`, `solved`, `attempted`) VALUES
('mehtaji', 'hello', 'DISTNUM', 'mgch', 3429, 4806);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
