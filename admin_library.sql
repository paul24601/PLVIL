-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2024 at 12:24 PM
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
-- Database: `admin_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `bookId` int(24) NOT NULL,
  `bookCategory` varchar(100) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `columnNumber` int(11) NOT NULL,
  `Accession` varchar(255) NOT NULL,
  `bookEdition` int(24) NOT NULL,
  `bookYear` year(4) NOT NULL,
  `Property` varchar(255) NOT NULL,
  `isbn` int(24) NOT NULL,
  `image1` varchar(200) NOT NULL,
  `image2` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`bookId`, `bookCategory`, `Title`, `Author`, `columnNumber`, `Accession`, `bookEdition`, `bookYear`, `Property`, `isbn`, `image1`, `image2`) VALUES
(7, 'Literature', 'Novalist and Novel', 'Harold Bloom', 1, '22-7362', 232, '2021', 'Valenzuela City', 791097277, '', ''),
(8, 'Entertainment', 'The Hunger Games', 'Suzanne Collins', 3, '23-2344', 49493847, '2021', 'Valenzuela City', 439023483, '', ''),
(9, 'Novel', 'The Goldfinch', 'Donna Tartt', 5, '21-362721', 283232, '2021', 'Valenzuela City', 2147483647, '', ''),
(10, 'Fantasy', 'Teacher Education', 'Ivann Mattson', 3, '21-3432', 7, '2022', 'Valenzuela City', 2147483647, '', ''),
(14, 'Literature', 'BASA NA', 'MAX TRINITY', 2, '23023', 323, '2021', 'VALENZUELA', 3234283, '', ''),
(19, 'Laws', 'Laws for Professional', 'Mike Santos', 2, '372834-42', 324, '2018', 'Valenzuela', 23233, '', ''),
(69, 'Fiction', 'An Eco-Critical Appraisal of the Selected Novels', 'Rabia Mukhtar', 2, '32-3232', 23923, '2020', 'Valenzuela', 978, '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`bookId`,`isbn`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `bookId` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
