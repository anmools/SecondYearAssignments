-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 02:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `calibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `ISBN` varchar(20) NOT NULL,
  `BookTitle` varchar(200) NOT NULL,
  `Author` varchar(100) NOT NULL,
  `Edition` int(11) NOT NULL DEFAULT 1,
  `Year` year(4) NOT NULL,
  `Category` int(11) NOT NULL,
  `Reserved` tinyint(1) NOT NULL DEFAULT 0,
  `ReservedBy` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`ISBN`, `BookTitle`, `Author`, `Edition`, `Year`, `Category`, `Reserved`, `ReservedBy`) VALUES
('093-403992', 'Computers in Business', 'Alicia Oneill', 3, '1997', 4, 0, NULL),
('23472-8729', 'Exploring Peru', 'Stephanie Birch', 4, '2005', 3, 0, NULL),
('237-34823', 'Business Strategy', 'Joe Peppard', 2, '2002', 2, 0, NULL),
('23u8-923849', 'A guide to nutrition', 'John Thorpe', 2, '1997', 1, 0, NULL),
('2983-3494', 'Cooking for children', 'Anabelle Sharpe', 1, '2003', 7, 0, NULL),
('82n8-308', 'Computers for idiots', 'Susan O\'Neill', 5, '1998', 4, 0, NULL),
('9781785658709', 'Gallant', 'V. E. Schwab', 1, '2022', 8, 0, NULL),
('9823-23984', 'My life in picture', 'Kevin Graham', 8, '2004', 1, 0, NULL),
('9823-2403-0', 'DaVinci Code', 'Dan Brown', 1, '2003', 8, 0, NULL),
('9823-98345', 'How to cook Italian food', 'Jamie Oliver', 2, '2005', 7, 0, NULL),
('9823-98487', 'Optimising your business', 'Cleo Blair', 1, '2002', 1, 0, NULL),
('98234-029384', 'My ranch in Texas', 'George Bush', 1, '2005', 3, 0, NULL),
('988745-234', 'Tara Road', 'Maeve Binchy', 4, '2002', 8, 0, NULL),
('993-004-00', 'My life in bits', 'John Smith', 1, '2001', 3, 0, NULL),
('9987-0039882', 'Shooting History', 'Jon Snow', 1, '2003', 1, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `CategoryID_FK` (`Category`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `CategoryID_FK` FOREIGN KEY (`Category`) REFERENCES `category` (`CategoryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
