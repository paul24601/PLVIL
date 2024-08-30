-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 02:55 PM
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
  `columnNumber` varchar(11) NOT NULL,
  `Accession` varchar(255) NOT NULL,
  `bookEdition` int(24) NOT NULL,
  `bookYear` year(4) NOT NULL,
  `Property` varchar(255) NOT NULL,
  `CallNumber` varchar(50) NOT NULL,
  `isbn` varchar(17) NOT NULL,
  `image1` varchar(200) NOT NULL,
  `image2` char(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`bookId`, `bookCategory`, `Title`, `Author`, `columnNumber`, `Accession`, `bookEdition`, `bookYear`, `Property`, `CallNumber`, `isbn`, `image1`, `image2`) VALUES
(161, 'Novel', 'Pride and prejudice', 'Jane Austen', '3 L', '323-4422', 22, '2022', 'Valenzuela City', '', '978-93-96055-02-6', 'bookstempic.png', 'sample.jpg'),
(176, 'Education', 'Make it Stick ', 'Henry L. Rodieger ', '1 L', '5553', 323234, '2014', 'PLV Maysan', '', '978-16-29239-74-3', 'bookstempic.png', 'books5.jpg'),
(178, 'Entertainment', 'The Great Gatsby', 'F Scott Fitzgerald', '2 R', '23-4324', 23, '1925', 'PLV Maysan', '', '978-06-84830-42-1', 'bookstempic.png', 'book-sample-1.jpg'),
(179, 'Technology', 'The Age of AI', 'Jason Thacker', '1 R', '25-3234', 20, '2020', 'PLV Maysan', '', '978-17-99732-84-6', 'bookstempic.png', 'book-sample-2.jpg'),
(180, 'Literature', 'Wuthering Heights', 'Emily Bronte', '2 L', '26-2323', 23, '2019', 'PLV Maysan', '', '978-04-51523-38-9', 'bookstempic.png', 'book-sample-3.jpg'),
(181, 'Literature', 'Crime and Punishment II', 'Fyodor Dostoevsky', '2 L', '21-24232', 23, '2012', 'PLV Maysan', '343.32', ' 978-04-86415-87-', 'bookstempic.png', 'book-sample-4.jpg'),
(182, 'Literature', 'The Catcher in the Rye', 'J. D. Salinger', '4 R', '29-3233', 43, '1951', 'PLV Maysan', '', '978-03-16769-48-8', 'bookstempic.png', 'book-sample-5.jpg'),
(183, 'Literature', 'Frankenstein', 'Mary Shelley', '1 R', '245-4433', 235556, '2021', 'PLV Maysan', '', '978-04-86282-11-4', 'bookstempic.png', 'book-sample-6.jpg'),
(184, 'Literature', 'The Call of the Wild', 'Jack London', '1 R', '12-3444', 21, '1980', 'PLV Maysan', '', '978-19-45644-51-1', 'bookstempic.png', 'book-sample-7.jpg'),
(185, 'Education', 'Excellent Sheep', 'William Deresiewicz', '5 L', '212333', 43222, '2014', 'PLV Maysan', '90.23', '978-1-4767-0173-5', 'bookstempic.png', 'book-sample-8.jpg'),
(186, 'Education', 'Teaching to Transgress', 'Bell hooks', '1 R', '29304', 23404, '1994', 'PLV Maysan', '', '978-0-41590-808-5', 'bookstempic.png', 'book-sample-9.jpg'),
(187, 'Novel', 'A Little Life', 'Hanya Yanagihara', '5 R', '34-2323', 32, '2017', 'PLV Maysan', '210.23', '978-08-04172-70-7', 'bookstempic.png', 'book-sample-11.jpg'),
(188, 'Novel', 'The Patrick Melrose', 'Edward St. Aubyn', '5 L', '323-4233', 323434, '2020', 'PLV Maysan', '', '978-12-50069-60-3', 'bookstempic.png', 'book-sample-12.jpg'),
(189, 'Education', 'Taste Your Words Book ', 'Bonnie Clark', '4 R', '345555', 34555, '2011', 'PLV Maysan', '', '978-15-46015-17-8', 'bookstempic.png', 'book-sample-13.jpg'),
(190, 'Education', 'You Cant Say You Cant Play', 'Vivian Gussin Paley', '4 L', '343-4344', 454, '2002', 'PLV Maysan', '', '9780-67-49659-04', 'bookstempic.png', 'book-sample-14.jpg'),
(191, 'Novel', 'The Dead Romantics', 'Ashley Poston', '4 L', '64343', 53424, '2021', 'PLV Maysan', '', '978-05-93336-48-9', 'bookstempic.png', 'book-sample-15.jpg'),
(192, 'Novel', 'A Court of Silver Flames ', 'Sarah J. Maas', '4 L', '23-444', 54230, '2009', 'PLV Maysan', '223.21', '978-15-26635-36-5', 'bookstempic.png', 'book-sample-16.jpg'),
(193, 'Entertainment', 'The Kite Runner ', 'Khaled Hosseini', '3 L', '394232', 534943, '2019', 'PLV Maysan', '', '978-15-94631-93-1', 'bookstempic.png', 'book-sample-17.jpg'),
(194, 'Entertainment', 'The Girl in His Shadow', 'Audrey Blake', '1 R', '654443', 345454, '2017', 'PLV Maysan', '', '978-17-28228-72-3', 'bookstempic.png', 'book-sample-18.jpg'),
(196, 'Entertainment', 'The cat in the hat', 'Dr. Seuss', '4 R', '88423', 42324, '2015', 'PLV Maysan', '', ' 978-03-94800-01-', 'bookstempic.png', 'book-sample-20.jpg'),
(197, 'Entertainment', 'The Diamond Eye ', 'Kate Quinn', '5 L', '46788', 64333, '2019', 'PLV Maysan', '', '978-00-63226-14-2', 'bookstempic.png', 'book-sample-21.jpg'),
(199, 'Technology', 'Zero to One', 'Peter Thiel', '4 R', '7545', 3456, '2012', 'PLV Maysan', '', '978-08-04139-29-8', 'bookstempic.png', 'book-sample-22.jpg'),
(200, 'Technology', 'Tell The Machine Goodnight', 'Katie Williams', '3 L', '56453', 64333, '2016', 'PLV Maysan', '', '978-05-25533-12-2', 'bookstempic.png', 'book-sample-23.jpg'),
(201, 'Technology', 'More Than A Glitch', 'Meredith Broussard', '3 R', '74323', 43622, '2017', 'PLV Maysan', '', '978-02-62548-32-8', 'bookstempic.png', 'book-sample-24.jpg'),
(202, 'Technology', 'Billion Dollar Loser Book', 'Reeves Wiedeman', '5 L', '63832', 73232, '2014', 'PLV Maysan', '123.33', '978-03-16461-36-8', 'bookstempic.png', 'book-sample-25.jpg');

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
  MODIFY `bookId` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
