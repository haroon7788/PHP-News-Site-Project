-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2022 at 06:12 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `post` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `post`) VALUES
(1, 'Programmers', 5),
(2, 'E-sports Players', 2),
(4, 'Doctors', 1),
(5, 'Entertainment', 1),
(6, 'Teachers', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` int(11) NOT NULL,
  `post_date` varchar(50) NOT NULL,
  `author` int(11) NOT NULL,
  `post_img` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `description`, `category`, `post_date`, `author`, `post_img`) VALUES
(1, 'HTML5', 'Hyper Text Markup Language Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic nisi maxime magni sapiente dolor eius in perferendis vel reiciendis tempora ea accusamus delectus dolore, veniam architecto at quam illo veritatis.', 1, '22 Dec, 2021', 15, 'business.jpg'),
(3, 'Tekken 7', 'Fighting Video Game Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic nisi maxime magni sapiente dolor eius in perferendis vel reiciendis tempora ea accusamus delectus dolore, veniam architecto at quam illo veritatis.', 2, '22 Dec, 2021', 18, 'fitness.jpg'),
(4, 'Corona', 'Corona virus will be no more. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic nisi maxime magni sapiente dolor eius in perferendis vel reiciendis tempora ea accusamus delectus dolore, veniam architecto at quam illo veritatis.', 4, '22 Dec, 2021', 18, 'bottle.png'),
(5, 'PHP', 'Hypertext Preprocessor. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic nisi maxime magni sapiente dolor eius in perferendis vel reiciendis tempora ea accusamus delectus dolore, veniam architecto at quam illo veritatis.', 1, '22 Dec, 2021', 16, 'computer-g941855474_1920.jpg'),
(6, 'Maths', 'Math is a good subject to learn. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic nisi maxime magni sapiente dolor eius in perferendis vel reiciendis tempora ea accusamus delectus dolore, veniam architecto at quam illo veritatis.', 6, '22 Dec, 2021', 16, 'contact-us.jpg'),
(7, 'Laravel', 'Laravel is good. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic nisi maxime magni sapiente dolor eius in perferendis vel reiciendis tempora ea accusamus delectus dolore, veniam architecto at quam illo veritatis.', 1, '22 Dec, 2021', 15, '2pizza.jpg'),
(14, 'Bootstrap', 'Bootstrap 5 is the newest version of Bootstrap, which is the most popular HTML, CSS, and JavaScript framework for creating responsive, mobile-first websites.\r\nBootstrap 5 is completely free to download and use!\r\nBootstrap 5 is the newest version of Bootstrap; with new components, faster stylesheet and more responsiveness.\r\n\r\nBootstrap 5 supports the latest, stable releases of all major browsers and platforms. However, Internet Explorer 11 and down is not supported.\r\n\r\nThe main differences between Bootstrap 5 and Bootstrap 3 & 4, is that Bootstrap 5 has switched to JavaScript instead of jQuery.', 1, '23 Dec, 2021', 15, 'computer-g941855474_1920.jpg'),
(31, 'PUBG', 'Player Unknown Battle Field', 2, '25 Dec, 2021', 18, '1640418110_fitness.jpg'),
(32, 'Node JS', 'A Backend Language', 1, '25 Dec, 2021', 18, '1640418120_fitness.jpg'),
(16, 'Who Am I (Movie)', 'Who Am I (German: Who Am I – Kein System ist sicher; English: \"Who Am I: No System Is Safe\") is a 2014 German techno-thriller film directed by Baran bo Odar. It is centered on a computer hacker group in Berlin geared towards global fame. It was screened in the Contemporary World Cinema section at the 2014 Toronto International Film Festival. The film was shot in Berlin and Rostock. Because of its story line and some elements, the film is often compared to Fight Club and Mr. Robot.', 5, '23 Dec, 2021', 16, 'tv-channel-g4fa70adf3_1920.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `webname` varchar(60) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `footerdesc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`webname`, `logo`, `footerdesc`) VALUES
('WORLD NEWS', '1641642312_news.jpg', '© Copyright 2021 NEWS | Powered by Haroon Mughal');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `role` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `username`, `password`, `role`) VALUES
(1, 'Haroon', 'Mughal', 'haroon64445', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1),
(2, 'Waqas', 'Raja', 'raja495', '3da541559918a808c2402bba5012f6c60b27661c', 0),
(6, 'Gul', 'Sher', 'gulsher', '3da541559918a808c2402bba5012f6c60b27661c', 0),
(7, 'Ahmad', 'Sohail', 'ahmad798', '3da541559918a808c2402bba5012f6c60b27661c', 1),
(8, 'Zee', 'Boy', 'zeeboy', '92429d82a41e930486c6de5ebda9602d55c39986', 1),
(9, 'Zeeshan', 'Khalid', 'zeeshankhalid', '69823ea488d8c01322b809901397ce944bcebaf8', 0),
(10, 'Hassam', 'Sarwar', 'hassam511', '8799e914d696af765cb33604694a4b076db6981a', 0),
(11, 'Imran', 'Khan', 'khansab', 'eba082ff45517c06bd365c2fde1fc77cda7a8f6f', 0),
(18, 'New', 'User', 'user', '12dea96fec20593566ab75692c9949596833adc9', 0),
(15, 'Haroon', 'Mughal', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1),
(16, 'Normal', 'User', 'normaluser', '12dea96fec20593566ab75692c9949596833adc9', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_id` (`post_id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
