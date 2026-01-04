-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2025 at 08:55 AM
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
-- Database: `portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `about_id` int(11) NOT NULL,
  `about_image` varchar(255) NOT NULL,
  `about_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_mobile` varchar(20) NOT NULL,
  `admin_image` varchar(255) NOT NULL,
  `admin_role` enum('admin','user') NOT NULL DEFAULT 'user',
  `admin_status` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `admin_mobile`, `admin_image`, `admin_role`, `admin_status`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$YSKh2Qzax.I8RII9/2dx.ewrblZtoCqitTD5Bw1kI2EE0ia2Pjymm', '0300-1234567', 'uploads/admin/1735723387_t1.jpg', 'admin', 1),
(252, 'Muhammad Sajawal', 'sajawal@sociavo.com', '$2y$10$zCgUlJJuHspwMDI6ZdisqOVIJCdtZ9QyBZpchwnixP3Gjvps7nj2a', '03079727675', 'uploads/admin/1736500764_about-img.jpg', 'admin', 1),
(253, 'Muhammad Sultan', 'sultankhiji56@gmail.com', '$2y$10$bDAlBJB6ShjWUO3GvFig0.w79iGyiwpw8mbnbhnwkhu3AxpvMUzRS', '03051608550', 'uploads/admin/1736500906_burger mubarak ho sultan bhai.jpg', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `client_image` varchar(255) NOT NULL,
  `client_status` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`, `client_image`, `client_status`) VALUES
(1, 'Zoom Engineering', 'uploads/clients/1736262081_CLIENTS-03.png', 0),
(2, 'Enwa Washing Powder', 'uploads/clients/1736262092_CLIENTS-12.png', 0),
(3, 'Crokery Godam', 'uploads/clients/1736262098_CLIENTS-20.png', 1),
(5, 'The Care Pathology Lab', 'uploads/clients/1736262115_CLIENTS-13.png', 1),
(6, 'Alpine School', 'uploads/clients/1736262162_CLIENTS-14.png', 1),
(7, 'Kamalika Shampoo', 'uploads/clients/1736262206_CLIENTS-01.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `contact_info_id` int(11) NOT NULL,
  `contact_mobile` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`contact_info_id`, `contact_mobile`, `contact_email`, `contact_address`) VALUES
(1, '0301-1234567', 'anymail78@gmail.com', 'Opposite HBL , Lodhran , Pakistan');

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

CREATE TABLE `counter` (
  `counter_id` int(11) NOT NULL,
  `projects` int(10) NOT NULL,
  `team` int(10) NOT NULL,
  `clients` int(10) NOT NULL,
  `hours_support` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counter`
--

INSERT INTO `counter` (`counter_id`, `projects`, `team`, `clients`, `hours_support`) VALUES
(1, 260, 12, 160, 2400);

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

CREATE TABLE `logo` (
  `logo_id` int(11) NOT NULL,
  `main_logo` varchar(255) NOT NULL,
  `second_logo` varchar(255) NOT NULL,
  `site_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logo`
--

INSERT INTO `logo` (`logo_id`, `main_logo`, `second_logo`, `site_name`) VALUES
(1, 'uploads/logo/1736397792_sociavo logo design concepts-13.png', 'uploads/logo/1736499442_sociavo logo design black txt -13.png', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `portfolio_id` int(11) NOT NULL,
  `portfolio_title` varchar(255) NOT NULL,
  `service_id` int(50) NOT NULL,
  `service_category_id` int(50) NOT NULL,
  `portfolio_image` varchar(255) NOT NULL,
  `portfolio_url` varchar(255) NOT NULL,
  `portfolio_status` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`portfolio_id`, `portfolio_title`, `service_id`, `service_category_id`, `portfolio_image`, `portfolio_url`, `portfolio_status`) VALUES
(1, 'Post Design', 3, 1, 'uploads/portfolio/1736401488_p9.jpg', '#', 1),
(2, 'Product Design', 3, 1, 'uploads/portfolio/1736402382_p4.jpg', '#', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

CREATE TABLE `pricing` (
  `pricing_id` int(11) NOT NULL,
  `pricing_feature` text NOT NULL,
  `pricing_category` varchar(255) NOT NULL,
  `pricing_status` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pricing`
--

INSERT INTO `pricing` (`pricing_id`, `pricing_feature`, `pricing_category`, `pricing_status`) VALUES
(1, '10 Posts', 'Basic', 0),
(2, '2 Video Reels', 'Basic', 1),
(3, '1 Facebook Cover', 'Basic', 1),
(4, 'Captions Writing Engagement', 'Basic', 1),
(5, 'Hashtag Research', 'Basic', 1),
(6, 'Page Optimization', 'Basic', 1),
(7, 'Performance Report', 'Basic', 1),
(8, '20 Posts', 'Standard', 1),
(9, '5 Video Reels', 'Standard', 0),
(10, '2 Facebook Cover', 'Standard', 1),
(11, 'Captions Writing Engagement', 'Standard', 1),
(12, 'Hashtag Research', 'Standard', 1),
(13, 'Page Optimization', 'Standard', 1),
(14, 'Ad Management', 'Standard', 1),
(15, 'Audience Growth Strategy Seasonal & Event Content', 'Standard', 1),
(16, '30 Posts', 'Premium', 1),
(17, '8 Video Reels', 'Premium', 1),
(18, '2 Facebook Cover', 'Premium', 1),
(19, '4 story highlighs', 'Premium', 1),
(20, 'Captions Writing Engagement', 'Premium', 1),
(21, 'Custom Campaigns', 'Premium', 1),
(22, 'Storytelling posts DMs, and Mentions', 'Premium', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `client_name` int(50) NOT NULL,
  `service_name` int(50) NOT NULL,
  `service_category` int(50) NOT NULL,
  `project_price` int(50) NOT NULL,
  `project_status` enum('pending','completed') NOT NULL DEFAULT 'pending',
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `client_name`, `service_name`, `service_category`, `project_price`, `project_status`, `created_at`) VALUES
(1, 3, 3, 1, 100, 'pending', '2025-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_icon` varchar(255) NOT NULL,
  `service_image` varchar(255) NOT NULL,
  `service_details` text NOT NULL,
  `service_status` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_icon`, `service_image`, `service_details`, `service_status`) VALUES
(2, 'Digital Marketing', 'uploads/services/1736406006_icon_s3.png', 'uploads/services/1736263417_digital-marketing.jpg', '<p>DM</p>', 1),
(3, 'Graphic Designing', 'uploads/services/1736406033_icon_4.png', 'uploads/services/1736263445_graphic-desiging.jpg', '<p>GD</p>', 1),
(4, 'Video Editing', 'uploads/services/1736405962_icon_progress.png', 'uploads/services/1736263480_video-editing.jpg', '<p>VE</p>', 1),
(5, 'Web Development', 'uploads/services/1736406079_icon_1.png', 'uploads/services/1736263516_web-development.jpg', '<p>WD</p>', 1),
(6, 'SEO', 'uploads/services/1736405980_icon_research.png', 'uploads/services/1736263545_seo.jpg', '<h3>Steps to Fix the Database</h3>\r\n<ul>\r\n<li>Ensure the <code>services</code> table contains valid records.</li>\r\n<li>Check the <code>service_status</code> column for the respective <code>service_id</code>.</li>\r\n<li>Run the SQL query manually in your database tool (e.g., phpMyAdmin) to verify the output.</li>\r\n</ul>\r\n<h3>Testing</h3>\r\n<ul>\r\n<li>Pass valid and invalid <code>id</code> values to test the error handling.</li>\r\n<li>Confirm the database records exist and contain proper values.</li>\r\n</ul>', 1),
(8, 'Social Media Management', 'uploads/services/1736405844_icon_b1.png', 'uploads/services/1736405906_image_social-media-marketing.jpg', '<p>sdfsdf</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_category`
--

CREATE TABLE `service_category` (
  `service_category_id` int(11) NOT NULL,
  `service_id` int(50) NOT NULL,
  `service_category_name` varchar(255) NOT NULL,
  `service_category_price` int(50) NOT NULL,
  `service_category_status` int(20) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_category`
--

INSERT INTO `service_category` (`service_category_id`, `service_id`, `service_category_name`, `service_category_price`, `service_category_status`) VALUES
(1, 3, 'Logo Design', 30, 1),
(2, 1, 'Landing Page', 100, 1),
(3, 5, 'Landing Page', 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `social_links_id` int(11) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`social_links_id`, `facebook`, `whatsapp`, `instagram`, `linkedin`, `youtube`) VALUES
(1, 'https://www.facebook.com/', '+923051608550', 'https://www.instagram.com/', 'https://www.linkedin.com/', 'https://www.youtube.com/');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_member_id` int(11) NOT NULL,
  `team_member_name` varchar(255) NOT NULL,
  `team_member_image` varchar(255) NOT NULL,
  `team_member_profession` varchar(255) NOT NULL,
  `team_member_status` int(20) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_member_id`, `team_member_name`, `team_member_image`, `team_member_profession`, `team_member_status`) VALUES
(1, 'Muhammad Sultan', 'uploads/team/1735799459_tur ja.jpg', 'Web Developer', 1),
(2, 'Muhammad Sajawal', 'uploads/team/1736412570_about-img.jpg', 'Graphic Designer', 1),
(3, 'Muhammad Farhan', 'uploads/team/1736412630_avatar-s-1.png', 'Video Editor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `testimonial_id` int(11) NOT NULL,
  `testimonial_client_name` varchar(255) NOT NULL,
  `testimonial_message` text NOT NULL,
  `testimonial_stars` varchar(255) NOT NULL,
  `testimonial_client_image` varchar(255) NOT NULL,
  `testimonial_status` int(50) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`testimonial_id`, `testimonial_client_name`, `testimonial_message`, `testimonial_stars`, `testimonial_client_image`, `testimonial_status`) VALUES
(1, 'Muhammad Ali2', 'sdfsdfsddsfs', '3', 'uploads/testimonials/1736403996_p3.jpg', 1),
(2, 'Sajawal ', 'sefsdfsdfsdfsdfxv xcvdsvsdvsdfsdfsfsdfsdfds', '4', 'uploads/testimonials/1736406609_idea-bulb.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_messages`
--

CREATE TABLE `users_messages` (
  `message_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  `user_message` text NOT NULL,
  `message_status` enum('unread','read') NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_messages`
--

INSERT INTO `users_messages` (`message_id`, `user_name`, `user_email`, `user_mobile`, `user_message`, `message_status`) VALUES
(1, 'Muhammad Ali', 'abc@gmail.com', 'free', 'this is the message of user', 'read'),
(2, 'Tanveer', 'tanveer@gmail.com', 'lkdjfklsdajlkfjaskl', 'lkjfklsdjklfskldhfklh', 'read'),
(3, 'Random user', 'sultan@gmail.com', '03051608550', 'hdfhkjsahfkjshakfhk', 'read'),
(4, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdvsd', 'read'),
(5, 'Orange', 'sultankhiji56@gmail.com', '03051608550', 'rasf', 'read'),
(6, 'Logo Design', 'sultan56@gmail.com', '03051608550', 'afsaf', 'read'),
(7, 'Mudasir Khan', 'sultankhiji56@gmail.com', '03051608550', 'dcsd', 'read'),
(8, 'Mudasir Khan', 'sultan@gmail.com', '03051608550', 'sdsd', 'read'),
(9, 'Mudasir Khan', 'sultan@ticer.pk', 'dfds', 'sdfsdfsd', 'read'),
(10, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdsa', 'read'),
(11, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdsa', 'read'),
(12, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdsa', 'read'),
(13, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdfsd', 'read'),
(14, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdfsd', 'read'),
(15, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdfsd', 'read'),
(16, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdfsd', 'read'),
(17, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdfsd', 'read'),
(18, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdfsd', 'read'),
(19, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdfsd', 'read'),
(20, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdfsd', 'read'),
(21, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdfsd', 'read'),
(22, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sdfsd', 'read'),
(23, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(24, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(25, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(26, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(27, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(28, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(29, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(30, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(31, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(32, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(33, 'sadfds', 'sultan@ticer.pk', 'dsds', 'sfsd', 'read'),
(34, 'ads', 'sultan56@gmail.com', 'as', 'asda', 'read'),
(35, 'ads', 'sultan56@gmail.com', 'as', 'asda', 'read'),
(36, 'ads', 'sultan56@gmail.com', 'as', 'asda', 'read'),
(37, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'asdsa', 'read'),
(38, 'Mudasir Khan', 'sultan@gmail.com', '03051608550', 'dfs', 'read'),
(39, 'Mudasir Khan', 'sultankhiji56@gmail.com', '03051608550', 'sdfds', 'read'),
(40, 'Mudasir Khan', 'sultan@gmail.com', '03051608550', 'csz', 'read'),
(41, 'Mudasir Khan', 'sultan@ticer.pk', '', 'sadsa', 'read'),
(42, 'Amir Bhatti', 'sultan@ticer.pk', '03051608550', 'sads', 'read'),
(43, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'scds', 'read'),
(44, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sadsa', 'read'),
(45, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'asd', 'read'),
(46, 'Amir Bhatti', 'sultan56@gmail.com', '03051608550', 'wefrrwef', 'read'),
(47, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'sc', 'read'),
(48, 'Muhammad Sultan', 'sultan56@gmail.com', '03051608550', 'dasdasd', 'read'),
(49, 'Sajawal', 'sultan@ticer.pk', '03051608550', 'sdfdsfsd', 'read'),
(50, 'Mudasir Khan', 'sultan@ticer.pk', '03051608550', 'kjhjkgjhg', 'read');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`contact_info_id`);

--
-- Indexes for table `counter`
--
ALTER TABLE `counter`
  ADD PRIMARY KEY (`counter_id`);

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`logo_id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`portfolio_id`);

--
-- Indexes for table `pricing`
--
ALTER TABLE `pricing`
  ADD PRIMARY KEY (`pricing_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_category`
--
ALTER TABLE `service_category`
  ADD PRIMARY KEY (`service_category_id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`social_links_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_member_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`testimonial_id`);

--
-- Indexes for table `users_messages`
--
ALTER TABLE `users_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `about_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `contact_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `counter`
--
ALTER TABLE `counter`
  MODIFY `counter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logo`
--
ALTER TABLE `logo`
  MODIFY `logo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `portfolio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pricing`
--
ALTER TABLE `pricing`
  MODIFY `pricing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `service_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `social_links_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `testimonial_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_messages`
--
ALTER TABLE `users_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
