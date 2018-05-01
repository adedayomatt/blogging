-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2018 at 04:33 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` char(50) NOT NULL,
  `first_name` char(255) NOT NULL,
  `last_name` char(255) NOT NULL,
  `username` char(255) NOT NULL,
  `password` char(255) NOT NULL,
  `password_hash` char(255) NOT NULL,
  `date_registered` datetime NOT NULL,
  `timestamp` int(50) NOT NULL,
  `last_seen` int(50) NOT NULL,
  `token` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `first_name`, `last_name`, `username`, `password`, `password_hash`, `date_registered`, `timestamp`, `last_seen`, `token`) VALUES
('admin-1524824450', 'Someone', 'Anyone', 'anyone', 'aaa', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '2018-04-27 11:20:50', 1524824450, 1524824450, '3b3690fba8bd08059eae130425396eb05ded1b7d'),
('admin-1524827332', 'Somebody', 'Anybody', 'somebody', 'some', 'eb875812858d27b22cb2b75f992dffadc1b05c66', '2018-04-27 12:08:52', 1524827332, 1524827332, 'af522d0b5e9c56c6bff230ccc178f1840595f97a'),
('Admin-1524832780', 'Adedayo', 'Matthews', 'matt', 'ade', '6fb0394b969258c4f33b92bbe8c601462bb5455b', '2018-04-24 19:13:40', 1524593620, 1524593620, 'b70166d2359e55ff3484f5d7020c70d86d890796');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` char(50) NOT NULL,
  `post_id` char(50) NOT NULL,
  `comment` longtext NOT NULL,
  `commenter` char(255) NOT NULL,
  `date_commented` datetime NOT NULL,
  `timestamp` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `comment`, `commenter`, `date_commented`, `timestamp`) VALUES
('comment-1524754258', 'post-1524663996', 'Interesting!', 'Olaniyi', '2018-04-26 15:50:58', 1524754258),
('comment-1524823740', 'post-1524668262', 'This is cool!', 'Anonymous', '2018-04-27 11:09:00', 1524823740),
('comment-1524837468', 'post-1524830993', 'All the best for them all!', 'Adedayo Matthews', '2018-04-27 14:57:48', 1524837468);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` char(50) NOT NULL,
  `title` varchar(500) NOT NULL,
  `body` longtext NOT NULL,
  `featured_photo` char(255) NOT NULL,
  `posted_by` char(255) NOT NULL,
  `date_posted` datetime NOT NULL,
  `timestamp` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `body`, `featured_photo`, `posted_by`, `date_posted`, `timestamp`) VALUES
('post-1524660010', 'Matthew Got Talent!', 'This is a report coming from Matthews, blah blah blah', '', 'Admin-1524832780', '2018-04-25 13:40:10', 1524660010),
('post-1524663996', 'Eddie Murphy goes WOWED!', 'No surprise as the veteran Hollywood actor...', '', 'Admin-1524832780', '2018-04-25 14:46:36', 1524663996),
('post-1524668262', 'Davido promises to release new single by April 30th', 'The Nigerian singer Davido has promised his fans to release a new single by April 30th this year, he made this known on his instagram page yesterday. He also mentioned that the single would be the biggest hit in Nigeria. Let\'s just keep our fingers crossed and hope this comes through. ', '', 'Admin-1524832780', '2018-04-25 15:57:42', 1524668262),
('post-1524670739', 'Rapper Meek Mill Released From Prison', 'Rapper, Meek Mill, has been released from prison.\r\n\r\nAccording to reports, the Pennsylvania Supreme Court granted the rapper bail after being incarcerated since November 2017 for violating his probation.\r\n\r\nHis two-to-four-year sentence for a probation violation stemming from a 2007 drug and weapons charge, handed down by controversial Judge Genece Brinkley, was overturned by the Supreme Court of Pennsylvania yesterday following series of appeals from his legal team\r\n\r\nIn a statement to Billboard, Meek said:\r\n\r\nâ€œIâ€™d like to thank God, my family, my friends, my attorneys, my team at Roc Nation including JAY-Z, Desiree Perez, my good friend Michael Rubin, my fans, The Pennsylvania Supreme Court and all my public advocates for their love, support and encouragement during this difficult time,\" began Meek.\r\n\r\n\"While the past five months have been a nightmare, the prayers, visits, calls, letters and rallies have helped me stay positive. To the Philadelphia District Attorneyâ€™s office, Iâ€™m grateful for your commitment to justice -- not only for my case, but for others that have been wrongfully jailed due to police misconduct,\" he continued.\r\n\r\n\"Although Iâ€™m blessed to have the resources to fight this unjust situation, I understand that many people of color across the country donâ€™t have that luxury and I plan to use my platform to shine a light on those issues. In the meantime, I plan to work closely with my legal team to overturn this unwarranted conviction and look forward to reuniting with my family and resuming my music career.â€\r\n\r\n', 'featured-photo-1524000854.jpg', 'Admin-1524832780', '2018-04-25 16:38:59', 1524670739),
('post-1524829165', 'New Admin added to myBlog', 'This is a new admin added to myBlog, i hope you enjoy my content, great to have y\'all there', '', 'admin-1524827332', '2018-04-27 12:39:25', 1524829165),
('post-1524830993', 'Kanye West didnâ€™t lose millions of Twitter followers for supporting President Trump; Here\'s what really happened!', 'Contrary to reports that controversial American rapper, Kanye West lost over 9million followers for tweeting in support of President Trump, \'The Life of Pablo\' rapper actually lost no follower and here\'s what really happened.\r\n\r\n \r\n\r\nTwo days, Kanye went on one of his many Twitter rants detailing how\'s he come out of the \"sunken place,\". \"I\'m not scared of the media,\" he wrote. \"I\'m not scared of the past and I\'m optimistic about the future. This tweet is in love not fear.\"\r\n\r\nShortly after, â€™Ye posted a photo of himself wearing a \"Make America Great Again\" cap as he stood beside top music executives Lyor Cohen and Elliot Grainge, captioning the pic \"we got love.\" He then went on to upload an additional photo of the Trump autographed hat by itself, writing \"my MAGA hat is signed.\"  \r\n\r\n \r\n\r\nPresident Trump himself thanked the Chicago MC for his ongoing support and while that ensued, thousands took notice of West\'s Twitter follower count, which seemingly took a devastating decline from 27.8 million to 18.6.\r\n\r\n \r\n\r\nHowever, according to Twitter, it all appears to be a glitch on their end with a Twitter spokesperson saying, \'we can confirm that Kanye\'s follower count is currently at approximately 27M followers. Any fluctuation that people might be seeing is an inconsistency and should be resolved soon.\"  \r\n\r\n \r\n\r\nIt was immediately resolved and as at the time of this report, Kanye\'s Twitter followers stand at 27,9 million.\r\n', 'featured-photo-1524836754.png', 'Admin-1524832780', '2018-04-27 13:09:53', 1524830993),
('post-1526739453', 'Hello World', 'My first blog here', '', 'Admin-1524832780', '2018-04-24 22:09:31', 1524604171);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_fk` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `admin_fk` (`posted_by`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `post_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `admin_fk` FOREIGN KEY (`posted_by`) REFERENCES `admins` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
