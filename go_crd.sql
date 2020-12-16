-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2020 at 04:50 AM
-- Server version: 5.7.26-log
-- PHP Version: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `go_crd`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1',
  `total_cards` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `contact`, `password`, `username`, `is_active`, `total_cards`, `date`) VALUES
(1, 'demo@demo.com', '', '', 'SU', 1, 0, '2020-12-16 19:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE IF NOT EXISTS `card` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `payment_status` int(1) NOT NULL DEFAULT '0',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trial_expiry_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `plan_expiry_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `subscription_type` int(11) NOT NULL DEFAULT '1',
  `card_link` varchar(255) NOT NULL,
  `card_status` int(1) NOT NULL DEFAULT '1',
  `has_footer` int(1) NOT NULL DEFAULT '1',
  `template` int(11) NOT NULL,
  `design` text NOT NULL,
  `creator` int(11) NOT NULL,
  `is_admin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card_company`
--

CREATE TABLE IF NOT EXISTS `card_company` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `person_name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `alternative_phone` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `google_location` varchar(255) DEFAULT NULL,
  `about` text,
  `nature` varchar(255) DEFAULT NULL,
  `specialities` varchar(255) DEFAULT NULL,
  `appointment` varchar(255) DEFAULT NULL,
  `files` text,
  `is_visible` int(11) NOT NULL DEFAULT '1',
  `section_title` varchar(255) NOT NULL DEFAULT 'About Us',
  `section_position` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card_feedback`
--

CREATE TABLE IF NOT EXISTS `card_feedback` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `is_visible` int(1) NOT NULL DEFAULT '1',
  `section_title` varchar(255) NOT NULL DEFAULT 'Feedbacks',
  `section_position` int(11) NOT NULL DEFAULT '6'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card_feedback_entries`
--

CREATE TABLE IF NOT EXISTS `card_feedback_entries` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `rating` int(5) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card_gallery`
--

CREATE TABLE IF NOT EXISTS `card_gallery` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `is_visible` int(1) NOT NULL,
  `section_title` varchar(255) NOT NULL DEFAULT 'Gallery',
  `section_position` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card_messages`
--

CREATE TABLE IF NOT EXISTS `card_messages` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card_offers_section`
--

CREATE TABLE IF NOT EXISTS `card_offers_section` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `description` text,
  `MRP` float DEFAULT NULL,
  `offer_price` float DEFAULT NULL,
  `button` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_visible` int(1) NOT NULL DEFAULT '1',
  `section_title` varchar(255) NOT NULL DEFAULT 'Products & Services',
  `section_position` int(11) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card_payment`
--

CREATE TABLE IF NOT EXISTS `card_payment` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `venmo` varchar(255) DEFAULT NULL,
  `cashapp` varchar(255) DEFAULT NULL,
  `paypal` varchar(255) DEFAULT NULL,
  `is_visible` int(1) NOT NULL DEFAULT '1',
  `section_title` varchar(255) NOT NULL DEFAULT 'Payment Info',
  `section_position` int(11) NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card_product_information`
--

CREATE TABLE IF NOT EXISTS `card_product_information` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `button` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_visible` int(1) NOT NULL DEFAULT '1',
  `section_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card_social_media`
--

CREATE TABLE IF NOT EXISTS `card_social_media` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `pinterest` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `others` text,
  `youtube_videos` text,
  `is_visible` int(1) NOT NULL DEFAULT '1',
  `section_title` varchar(255) NOT NULL DEFAULT 'Social Links',
  `section_position` int(11) NOT NULL DEFAULT '9'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1',
  `total_cards` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card_company`
--
ALTER TABLE `card_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `card_feedback`
--
ALTER TABLE `card_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`),
  ADD KEY `card_id_2` (`card_id`);

--
-- Indexes for table `card_feedback_entries`
--
ALTER TABLE `card_feedback_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `card_gallery`
--
ALTER TABLE `card_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `card_messages`
--
ALTER TABLE `card_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `card_offers_section`
--
ALTER TABLE `card_offers_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`),
  ADD KEY `card_id_2` (`card_id`);

--
-- Indexes for table `card_payment`
--
ALTER TABLE `card_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `card_product_information`
--
ALTER TABLE `card_product_information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `card_social_media`
--
ALTER TABLE `card_social_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `card_company`
--
ALTER TABLE `card_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `card_feedback`
--
ALTER TABLE `card_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `card_feedback_entries`
--
ALTER TABLE `card_feedback_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `card_gallery`
--
ALTER TABLE `card_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `card_messages`
--
ALTER TABLE `card_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `card_offers_section`
--
ALTER TABLE `card_offers_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `card_payment`
--
ALTER TABLE `card_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `card_product_information`
--
ALTER TABLE `card_product_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `card_social_media`
--
ALTER TABLE `card_social_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
