-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2020 at 02:46 AM
-- Server version: 5.7.31
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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

CREATE TABLE `admin` (
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
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `contact`, `password`, `username`, `is_active`, `total_cards`, `date`) VALUES
(2, 'admin@gocrz.biz', 'demo', '123', 'admin', 1, 20, '2020-12-21 02:42:02');

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `payment_status` int(1) NOT NULL DEFAULT '0',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trial_expiry_date` timestamp NULL DEFAULT NULL,
  `plan_expiry_date` timestamp NULL DEFAULT NULL,
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

CREATE TABLE `card_company` (
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

CREATE TABLE `card_feedback` (
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

CREATE TABLE `card_feedback_entries` (
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

CREATE TABLE `card_gallery` (
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

CREATE TABLE `card_messages` (
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

CREATE TABLE `card_offers_section` (
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

CREATE TABLE `card_payment` (
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

CREATE TABLE `card_product_information` (
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

CREATE TABLE `card_social_media` (
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
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `su_email` varchar(255) DEFAULT NULL,
  `su_password` varchar(255) DEFAULT NULL,
  `stripe_key` varchar(255) DEFAULT NULL,
  `razorpay_key` varchar(255) DEFAULT NULL,
  `monthly_price` float DEFAULT NULL,
  `yearly_price` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `url`, `su_email`, `su_password`, `stripe_key`, `razorpay_key`, `monthly_price`, `yearly_price`) VALUES
(1, 'http://localhost/go-crd/Cards/', 'su@gocrd.biz', '123', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
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
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `contact`, `password`, `username`, `is_active`, `total_cards`, `date`) VALUES
(3, 'jzmalik123@gmail.com', '03114114466', '123', 'jzmalik123', 1, 0, '2020-12-21 02:09:40'),
(4, 'ammaraslam10@gmail.com', '0302203123', 'opop', 'ammar', 0, 0, '2020-12-21 02:09:40');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_card_creator` (`creator`);

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
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `fk_card_creator` FOREIGN KEY (`creator`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_company`
--
ALTER TABLE `card_company`
  ADD CONSTRAINT `fk_card_id` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_feedback`
--
ALTER TABLE `card_feedback`
  ADD CONSTRAINT `fk_card_id_feedback` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_feedback_entries`
--
ALTER TABLE `card_feedback_entries`
  ADD CONSTRAINT `fk_card_id_feedback_entries` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_gallery`
--
ALTER TABLE `card_gallery`
  ADD CONSTRAINT `fk_card_id_gallery` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_messages`
--
ALTER TABLE `card_messages`
  ADD CONSTRAINT `fk_card_id_messages` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_offers_section`
--
ALTER TABLE `card_offers_section`
  ADD CONSTRAINT `fk_card_id_offers` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_payment`
--
ALTER TABLE `card_payment`
  ADD CONSTRAINT `fk_card_id_payment` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_product_information`
--
ALTER TABLE `card_product_information`
  ADD CONSTRAINT `fk_card_id_prod_info` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card_social_media`
--
ALTER TABLE `card_social_media`
  ADD CONSTRAINT `fk_card_id_social` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
