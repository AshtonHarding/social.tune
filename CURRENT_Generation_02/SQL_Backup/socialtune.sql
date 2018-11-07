-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2015 at 08:16 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `socialtune`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
`id` int(11) NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `pending` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_one`, `user_two`, `pending`) VALUES
(2, 4, 7, 0),
(4, 1, 4, 0),
(5, 2, 4, 0),
(6, 11, 4, 0),
(7, 8, 4, 0),
(9, 4, 5, 0),
(10, 4, 3, 0),
(12, 6, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
`id` int(255) NOT NULL,
  `poster_id` int(255) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `poster_id`, `post_date`, `message`) VALUES
(1, 4, '2015-04-02 16:10:12', 'Today, I implemented a status.'),
(2, 4, '2015-04-02 16:34:32', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(4, 7, '2015-04-02 16:50:09', 'EAT A DICK.'),
(6, 4, '2015-04-03 00:41:40', 'nico nico nii~'),
(9, 4, '2015-04-03 20:54:58', 'testing 1 2 3.'),
(10, 4, '2015-04-04 23:25:43', '<b>Hi</b>'),
(15, 4, '2015-04-04 23:27:22', '<sub><sub>fuuuuuck</sub></sub>'),
(21, 4, '2015-04-04 23:31:48', '<sub><sub><sub>f<sub>u<sub>c<sub>k</sub></sub></sub></sub></sub></sub>'),
(23, 4, '2015-04-04 23:32:15', 'æ—¥æœ¬èªž'),
(24, 4, '2015-04-04 23:32:30', '<h1>æ—¥æœ¬èªž</h1>'),
(40, 4, '2015-04-04 23:40:16', '<script>\r\n  var iframe = window.getElementsByTagName( "iframe" )[ 0 ];\r\n  alert( "Frame title: " + iframe.contentWindow.title );\r\n</script>\r\n\r\n\r\n<iframe src="http://www.google.com" width="300" height="300">\r\n  <p>Your browser does not support iframes.</p>\r\n</iframe>'),
(42, 4, '2015-04-04 23:40:40', '<img src="http://127.0.0.1/socialtune/user-images/4.jpg">'),
(46, 4, '2015-04-04 23:57:12', 'This is easy mode exploitable. Unsure if I should black list or white list.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(254) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(254) NOT NULL,
  `first_name` varchar(254) NOT NULL,
  `last_name` varchar(254) NOT NULL,
  `birthdate` varchar(11) NOT NULL,
  `location_country` varchar(254) NOT NULL,
  `location_state` varchar(254) NOT NULL,
  `location_town` varchar(254) NOT NULL,
  `signup_date` varchar(254) NOT NULL,
  `bio` longtext NOT NULL,
  `default_image` varchar(256) NOT NULL,
  `user_type` int(2) NOT NULL,
  `isOnline` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--


---------- I had to remove some people and edit some things.

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `birthdate`, `location_country`, `location_state`, `location_town`, `signup_date`, `bio`, `default_image`, `user_type`, `isOnline`) VALUES
(1, 'jsmith@example.com', 'f0716b9280cc081c2f1b2789sd3cb09f5e828baa08799db578bsdf64be144465a6c94a', 'John', 'Smith', '0000-00-00', '', '', '', '0000-00-00', 'Hello. This is a test bio. In the future, I will add the ability to edit. In the mean time, enjoy NOT BEING ABLE TO EDIT IT. MWAHAHAHAHAHAHHAAHAH - Ashton', '1.jpg', 0, 0),
(2, 'jdoe@example.com', '93d057269122f3255ba708b4604aa6ef83454bdd4c76b9fda234557a38614896223', 'Jane', 'Doe', '05/20/1992', '', '', '', 'signup_date', 'Hello. This is a test bio. In the future, I will add the ability to edit. In the mean time, enjoy NOT BEING ABLE TO EDIT IT. MWAHAHAHAHAHAHHAAHAH - Ashton', '2.jpg', 0, 0),
(3, 'test@test.com', 'f07416b9280cc081c2f1b2789cb09f5ea828baa08799db578346b64be144465a6c94a', 'Douglas', 'Harding', '12/23/1991', 'USA', 'Texas', 'Houston', '3/25/2015', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', '5.jpg', 0, 0),
(4, 'asdasda@asdasdasd.com', '2ddde0ff4405833483527fa2dd82f9e37f07249cf69d610e7718ba50328cb6f2', 'Asdasd', 'asdasd', '01/01/1993', '', '', '', '3/27/2015', '', '', 0, 0),
(5, 'as@as.com', '141641f1f06dc8346ac61236tfd6d3bb2ab4861c428fe4d3b7326a5ee4012a86fe8e3', 'Ashton', 'Harding', '01/01/1993', '', '', '', '3/27/2015', '', '10.jpg', 0, 0),
(6, 'firstband@first.com', 'f0716b923480cc0681c2f1b2789cb09f5e828baa08799db578b64be144465a6c94a', 'First Band', '', '01/1/2015', 'USA', 'Texas', 'Spring', '3/27/2015', 'Super radical band. With music.', '11.jpg', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD KEY `password` (`password`,`first_name`,`last_name`,`birthdate`,`location_country`,`location_state`,`location_town`,`signup_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(254) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
