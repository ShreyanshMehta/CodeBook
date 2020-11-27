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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `pass`, `name`, `email`) VALUES
('admin', '$2y$10$tarwS1yhWVKboz59jOTu1uRqZ3FMleRO.WXl6iPucfPQyQWbiwOpq', 'admin', 'admin@gmail.com'),
('machone', '$2y$10$ztkewzrzKkFaLoGP23G6.uKH1lzeVSujk3YwJAv1dN5ORZoLQC8pi', 'Shreyansh Mehta', 'shreyansh887121@gmail.com'),
('mehtaji', '$2y$10$Vnec2qJFw8YhBy9WZNnKFeNSy99C4K7u7FoW/2qAyz6wHXph/SF06', 'Shreyansh Mehta', 'admin@gmail.com'),
('theviral_v', '$2y$10$aG7dazJA5MwpXZ6fQoticu/X9i0lQmDBGVXOBz44xEGGN8hlhYsSG', 'Vishesh Maheshwari', 'admin@gmail.com'),
('shreyanshmehta', '$2y$10$wOLagDJ9K/1cmz6u.osvNuj1d9anI7iWTYwhG90b71M3lh8nn2pla', 'Shreyansh Mehta', 'admin@gmail.com'),
('pushpa', '$2y$10$4.Lk68eclc3EBq8tLmfBhesEeX.sDERLoL6nbQAFkVCYIeyD7AGIC', 'Pushpa Mehta', 'admin@gmail.com'),
('sanjay', '$2y$10$qJNu2ljTkbYtmCwZWWtyrOUpBNoP6hJD3IH02c4k8uIl6sm3YKWj.', 'Sanjay', 'admin@gmail.com'),
('jporwal09', '$2y$10$SDQyqVgO3Wn6RKjKSuCxSefQ3nXdVYefWfOpvap.HgPM07e08vdDG', 'jayesh', 'admin@gmail.com'),
('hello', '$2y$10$imJqUsja1IN/zUR6lrX4QeBYhW/Ck3VXqda2iQTuvSLnVJZ6fXXqS', 'admin', 'admin@gmail.com'),
('theviralv', '$2y$10$Pzy/Aev4TP6Xq1Z1VwByJutladr5N5PME3e.ANo/MI.0/BW3fqzd.', 'Vishesh Maheshwari', 'admin@gmail.com'),
('hello1', '$2y$10$wywKbe743dsRZZ1y6g.g8..8VcQkM9WRfFHrlRG9kyxLzzEKqYZiC', 'admin', 'admin@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
