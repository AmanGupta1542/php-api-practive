-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2024 at 10:49 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clg`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `contact` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `dob`, `contact`, `email`, `password`, `created_at`) VALUES
(1, 'Aman', '1998-10-18', 123, 'aman@gmail.com', 'aman', '2024-04-08 02:00:17'),
(4, 'Raj 1 Soni', '1998-11-11', 23784758374, 'raj@gmail.com', 'raj', '2024-04-11 01:53:57'),
(5, 'Sanjay Sahu', '2000-12-10', 123456, 'sanjay@gmail.com', 'sanjay', '2024-04-11 01:55:11'),
(7, 'Aarav Kumar', '2000-05-15', 9876543210, 'aarav@example.com', '', '2024-04-12 02:05:47'),
(8, 'Aditi Gupta', '1999-09-20', 8765432109, 'aditi@example.com', '', '2024-04-12 02:05:47'),
(9, 'Arjun Sharma', '2001-03-10', 7654321098, 'arjun@example.com', '', '2024-04-12 02:05:47'),
(10, 'Diya Patel', '2002-07-25', 6543210987, 'diya@example.com', '', '2024-04-12 02:05:47'),
(11, 'Kavya Singh', '2000-01-05', 5432109876, 'kavya@example.com', '', '2024-04-12 02:05:47'),
(12, 'Ishaan Sharma', '2003-02-18', 4321098765, 'ishaan@example.com', '', '2024-04-12 02:05:47'),
(13, 'Ananya Mishra', '2001-11-30', 3210987654, 'ananya@example.com', '', '2024-04-12 02:05:47'),
(14, 'Advait Singh', '2004-04-12', 2109876543, 'advait@example.com', '', '2024-04-12 02:05:47'),
(15, 'Myra Gupta', '2002-08-08', 1098765432, 'myra@example.com', '', '2024-04-12 02:05:47'),
(16, 'Rohan Patel', '2000-06-22', 9876543211, 'rohan@example.com', '', '2024-04-12 02:05:47'),
(17, 'Aarohi Sharma', '2003-09-17', 8765432110, 'aarohi@example.com', '', '2024-04-12 02:05:47'),
(18, 'Anika Gupta', '2001-12-05', 7654321099, 'anika@example.com', '', '2024-04-12 02:05:47'),
(19, 'Kabir Singh', '2002-04-29', 6543210988, 'kabir@example.com', '', '2024-04-12 02:05:47'),
(20, 'Pari Singh', '2003-10-10', 5432109877, 'pari@example.com', '', '2024-04-12 02:05:47'),
(21, 'Vivaan Patel', '2001-07-02', 4321098766, 'vivaan@example.com', '', '2024-04-12 02:05:47'),
(22, 'Saanvi Mishra', '2002-11-18', 3210987655, 'saanvi@example.com', '', '2024-04-12 02:05:47'),
(23, 'Shaurya Gupta', '2000-12-25', 2109876544, 'shaurya@example.com', '', '2024-04-12 02:05:47'),
(24, 'Siya Sharma', '2003-05-09', 1098765433, 'siya@example.com', '', '2024-04-12 02:05:47'),
(25, 'Reyansh Patel', '2001-09-14', 9876543212, 'reyansh@example.com', '', '2024-04-12 02:05:47'),
(26, 'Avni Singh', '2002-02-28', 8765432111, 'avni@example.com', '', '2024-04-12 02:05:47'),
(27, 'Vihaan Gupta', '2000-03-15', 7654321100, 'vihaan@example.com', '', '2024-04-12 02:05:47'),
(28, 'Aanya Mishra', '2003-08-07', 6543210989, 'aanya@example.com', '', '2024-04-12 02:05:47'),
(29, 'Ansh Singh', '2001-06-20', 5432109878, 'ansh@example.com', '', '2024-04-12 02:05:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
