-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2022 at 02:02 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categores`
--

CREATE TABLE `categores` (
  `id` int(11) NOT NULL COMMENT 'The Id Of The Categorey',
  `name` varchar(255) NOT NULL COMMENT 'The Category ame',
  `description` text NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `visibilty` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'zero is visible \r\none is hidden',
  `allowComment` tinyint(4) NOT NULL DEFAULT 0,
  `allowAds` tinyint(4) NOT NULL DEFAULT 0,
  `parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categores`
--

INSERT INTO `categores` (`id`, `name`, `description`, `ordering`, `visibilty`, `allowComment`, `allowAds`, `parent`) VALUES
(44, 'computers', 'main category for computers department', 0, 0, 0, 0, 0),
(45, 'laptop', 'sub-category for laptop which is part of computers main category', 0, 0, 0, 0, 44),
(46, 'printers', 'sub-category for printers which is part of computers main category', 0, 0, 0, 0, 44),
(47, 'electronics', 'main category for electronics department', 0, 0, 0, 0, 0),
(48, 'headphones', 'sub-category for headphones which is part of electronics main category', 0, 0, 0, 0, 47);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `c_status` tinyint(4) NOT NULL DEFAULT 0,
  `c_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `c_status`, `c_date`, `item_id`, `user_id`) VALUES
(63, 'so nice black wireless over', 1, '2022-05-04 11:55:26', 104, 145),
(64, 'very nice apple laptop', 1, '2022-05-04 11:55:30', 105, 146),
(65, 'very helpful printer and scanner', 1, '2022-05-04 11:57:29', 106, 146);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_desc` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `add_date` date NOT NULL,
  `country` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` smallint(6) NOT NULL,
  `apporove` tinyint(4) NOT NULL DEFAULT 0,
  `cat_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `item_tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_desc`, `price`, `add_date`, `country`, `image`, `status`, `rating`, `apporove`, `cat_id`, `member_id`, `item_tags`) VALUES
(103, 'Apple AirPods (2nd Generation)', 'Quick access to Siri by saying “ Hey Siri ”', '150', '2022-05-04', 'Egypt', '646634_appleHeadPhones.jpg', '1', 3, 1, 48, 145, 'headPhones, electronics'),
(104, 'Wireless Over Ear Bluetooth Headphones', 'Incredible Sound Loved by 20 Million+ People', '60', '2022-05-04', 'Egypt', '808257_wirelessEar.jpg', '2', 3, 1, 48, 146, 'overEar, electronics'),
(105, 'apple Laptop', 'a very nice labtop', '1000', '2022-05-04', 'Egypt', '82522_appleLaptop.jpg', '1', 2, 1, 45, 145, 'laptop, apple'),
(106, 'xerox printer', 'a hard xerox printer', '300', '2022-05-04', 'Belarus', '899401_xerox.jpg', '1', 2, 1, 46, 146, 'xerox, printers'),
(107, 'sony WF headPhones', 'Industry-leading noise canceling bluetooth earbuds with the new Integrated Processor V1', '200', '2022-05-04', 'Belarus', '448080_sony1.jpg/641018_sony2.jpg/417719_sony3.jpg/124120_sony4.jpg', '1', 0, 1, 48, 145, 'headPhones, electroonics');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL COMMENT 'to identify users',
  `userName` varchar(255) NOT NULL COMMENT 'user name to login',
  `password` varchar(255) CHARACTER SET utf8mb4 NOT NULL COMMENT 'password to login',
  `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp() COMMENT 'date when user join',
  `groupId` int(11) NOT NULL DEFAULT 0 COMMENT 'to identifiy members from admins',
  `trustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'seler rank',
  `regStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user apporovel',
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `password`, `email`, `fullname`, `date`, `groupId`, `trustStatus`, `regStatus`, `image`) VALUES
(144, 'admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'admin@gmail.com', 'admin admin', '2022-05-04', 1, 0, 1, ''),
(145, 'ali', 'caaccc75114555826c3cb1dba938762dc71cd4c0', 'ali@gmail.com', 'Ali Ashour', '2022-05-04', 0, 0, 1, ''),
(146, 'yossef', 'b6a3c0033d13d65606ebaa0e8a7b4cbe05823640', 'yossef@gmail.com', 'Yossef Ashour', '2022-05-04', 0, 0, 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categores`
--
ALTER TABLE `categores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `comments` (`item_id`),
  ADD KEY `comments2` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `users_one` (`member_id`),
  ADD KEY `cat_one` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categores`
--
ALTER TABLE `categores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The Id Of The Categorey', AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to identify users', AUTO_INCREMENT=147;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments2` FOREIGN KEY (`user_id`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_one` FOREIGN KEY (`cat_id`) REFERENCES `categores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_one` FOREIGN KEY (`member_id`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
