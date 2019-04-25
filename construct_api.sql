-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2019 at 06:11 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `construct_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `rfq`
--

CREATE TABLE `rfq` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `due_date` date NOT NULL,
  `attachment` varchar(150) NOT NULL,
  `rfq_details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `name`, `contact_name`, `email`, `address`, `phone`) VALUES
(9, 8, 'RADEL Corp', 'Ashwin', 'contact@radelcorp.in', 'Bommanahalli, Bangalore - 560068', '9538497461'),
(10, 8, 'RADEL Corp', 'Ashwin', 'contact@radelcorp.in', 'Bommanahalli, Bangalore - 560068', '9538497461'),
(11, 8, 'RADEL Corp', 'Ashwin', 'contact@radelcorp.in', 'Bommanahalli, Bangalore - 560068', '9538497461'),
(12, 8, 'RADEL Corp', 'Ashwin', 'contact@radelcorp.in', 'Bommanahalli, Bangalore - 560068', '9538497461'),
(13, 8, 'RADE', 'Ashwin', 'contact@radelcorp.in', 'Bommanahalli, Bangalore - 560068', '9538497461'),
(14, 10, 'Ashwin Kumar', 'Ashwin', 'ashwin@radelcorp.in', '68/1, 3rd A Main, 10th Cross, Industrial Area, Bommanahalli, Industrial Area, Bommanahalli', '9538497461'),
(15, 10, 'Ashwin Kumar', 'Ashwin', 'ash@test.com', '68/1, 3rd A Main, 10th Cross, Industrial Area, Bommanahalli, Industrial Area, Bommanahalli', '9538497461'),
(16, 10, 'Ashwin Kumar', 'Teachable', 'learn@radel.site', '68/1, 3rd A Main, 10th Cross, Industrial Area, Bommanahalli', '9538497461'),
(17, 10, 'Ashwin Kumar', 'Ashwin', 'ashwinncj@gmail.com', '68/1, 3rd A Main, 10th Cross, Industrial Area, Bommanahalli', '9538497461');

-- --------------------------------------------------------

--
-- Table structure for table `user_credentials`
--

CREATE TABLE `user_credentials` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expiry` datetime NOT NULL,
  `hash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_credentials`
--

INSERT INTO `user_credentials` (`id`, `email`, `password`, `token`, `expiry`, `hash`) VALUES
(8, 'ashwinncj@gmail.com', '027f364afa7f8b9c787eb61a2deaf80c64f4a8f3', '5ca9bc3eea9c7ee53d7a97c257009db106d2371f7fc617cc079886cf78908f5bd759128a6d71536e', '2019-04-25 23:29:29', ''),
(9, 'contact@radelcorp.in', '027f364afa7f8b9c787eb61a2deaf80c64f4a8f3', '335642bd21bf5e82be0a6690f01095d14721b9192ccada98f9f969bb6b52d2312cb049a73ac2b1a8', '2019-04-23 22:28:18', ''),
(10, 'ashwin@radelcorp.in', '027f364afa7f8b9c787eb61a2deaf80c64f4a8f3', '817b76141f2474faee86aaf6efdece99b833fac49fc195e5141ab175244ae9e83ac929af0a684ad1', '2019-04-25 19:26:37', ''),
(11, 'ashwin@radelcorp.ind', '027f364afa7f8b9c787eb61a2deaf80c64f4a8f3', '40593b84cbb40937e260d3be23bbac0bcd641b6f405a375e52676aec3a732d462e4fd9ed318298cf', '2019-04-23 22:41:02', ''),
(12, 'ashwinncj@gmail.comff', '027f364afa7f8b9c787eb61a2deaf80c64f4a8f3', 'a8ee39e69a1de8fe861a4bbdb43c6c7dc4a9868c95f9f4737bd657c17f6f4182167cf3c8d7575646', '2019-04-23 22:41:52', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `user_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `contact_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`user_id`, `company_name`, `address`, `phone`, `contact_name`) VALUES
(8, 'RADEL Corp', '68/1, 3rd \'A\' Main 10th Cross, Industrial Area, Bommanahalli, Bangalore - 560068', '9538497461', 'Ashwin Kumar C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rfq`
--
ALTER TABLE `rfq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_credentials`
--
ALTER TABLE `user_credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rfq`
--
ALTER TABLE `rfq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_credentials`
--
ALTER TABLE `user_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
