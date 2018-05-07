-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Apr 30, 2018 at 01:41 PM
-- Server version: 5.5.60
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camagru`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `statut` varchar(25) DEFAULT 'user',
  `token` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `statut`, `token`, `active`, `created_at`) VALUES
(6, 'philippe', 'philippe@gmail.com', '$2y$10$kXVKBT.HJrC9ySiXItiLP.wIxw6uK4o106/61ZzzBqS3zf7eiebXO', 'user', NULL, 0, '2018-04-23 19:06:43'),
(7, 'ayda', 'ayda@gmail.com', '$2y$10$fzLoI.xcnNSXuFRaZSeeEOkf49TtMhaTlNGxuK0M4N2zxl5TgWw9S', 'user', NULL, 0, '2018-04-23 19:09:01'),
(63, 'ff', 'ff@ff.ff', '$2y$10$0xNB1.8hRgWkrGMZtfm2uuBtHouFwC12x4cdOKzbe.rNwvvKS8WlS', 'user', 'd36d3eeb', 0, '2018-04-30 11:32:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
