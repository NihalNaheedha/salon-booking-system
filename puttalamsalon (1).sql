-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 14, 2026 at 04:51 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puttalamsalon`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `service_id` int NOT NULL,
  `customer_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  KEY `service_id_2` (`service_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `booking_date`, `booking_time`, `service_id`, `customer_id`) VALUES
(41, '2025-10-30', '13:30:00', 42, 15),
(42, '2025-10-31', '19:00:00', 34, 16),
(43, '2025-10-15', '13:00:00', 38, 15),
(44, '2025-10-09', '13:15:00', 29, 15),
(45, '2025-10-08', '12:00:00', 35, 15),
(46, '2025-10-08', '12:00:00', 29, 15),
(47, '2025-10-08', '12:00:00', 43, 16),
(48, '2025-10-08', '12:00:00', 21, 18);

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

DROP TABLE IF EXISTS `availability`;
CREATE TABLE IF NOT EXISTS `availability` (
  `id` int NOT NULL AUTO_INCREMENT,
  `day` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('open','closed') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'open',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`id`, `day`, `start_time`, `end_time`, `status`) VALUES
(25, '2025-10-09', '11:00:00', '12:00:00', 'closed'),
(27, '2025-10-03', '13:45:00', '14:45:00', 'closed'),
(26, '2025-10-29', '13:15:00', '15:30:00', 'closed');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'customer',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `phone`, `password`, `role`) VALUES
(10, 'Naheedha', 'mnfnaheedha@gmail.com', '0752497973', 'naheedha', 'admin'),
(15, 'Nihmathulla Nihal', 'nihalnihmathulla@gmail.com', '0779253920', '1234', 'customer'),
(16, 'Sudhaish', 'sudhaish@gmail.com', '0785623443', '4567', 'customer'),
(18, 'Nihmathulla', 'puttalasalon@gmail.com', '0752497973', '9876', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `service_type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `price`, `service_type`) VALUES
(19, 'Express Color(10 Mins)', 2500.00, 'Hair Color | Forms'),
(20, 'Grey Coverage', 4100.00, 'Hair Color | Forms'),
(21, 'Grey Coverage - Amonia Free', 4200.00, 'Hair Color | Forms'),
(22, 'Fashion Color', 5900.00, 'Hair Color | Forms'),
(23, 'Highlights', 4500.00, 'Hair Color | Forms'),
(24, 'Repair &amp; Rejuvenate - Short', 3300.00, 'Hair Color | Forms'),
(25, 'Hair With Head Wash', 1300.00, 'Hair Cut | Style | Massage'),
(26, 'Hair Setting', 2000.00, 'Hair Cut | Style | Massage'),
(27, 'Shaving', 700.00, 'Hair Cut | Style | Massage'),
(29, 'Braiding Per Strand - Short', 1200.00, 'Hair Cut | Style | Massage'),
(30, 'Braiding Per  Strand - Long', 1600.00, 'Hair Cut | Style | Massage'),
(31, 'Hair Tattoo', 2200.00, 'Hair Cut | Style | Massage'),
(32, 'Hair Massage - Oil', 1200.00, 'Hair Cut | Style | Massage'),
(33, 'Hair Massage - Tonic', 1100.00, 'Hair Cut | Style | Massage'),
(34, 'Hot Oil Hair Treatment', 3100.00, 'Hair Cut | Style | Massage'),
(35, 'Classic Clean Up', 3400.00, 'Clean - Up'),
(36, 'Brightening Clean Up', 6800.00, 'Clean - Up'),
(37, 'Natural Glow Facial', 5200.00, 'Facial'),
(38, 'Face Massage', 1600.00, 'Facial'),
(40, 'Luxury Pedicure - Massage Chair', 8100.00, 'Pedicure'),
(41, 'Premium Pedicure', 6300.00, 'Pedicure'),
(42, 'Classic Pedicure', 2100.00, 'Pedicure'),
(43, 'Groom&#039;s Dressing All Day', 19000.00, 'Dressing'),
(44, 'Bestman&#039;s Dressing (All Day Long)', 12700.00, 'Dressing'),
(46, 'dvgyucgx', 456.00, 'hair');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
